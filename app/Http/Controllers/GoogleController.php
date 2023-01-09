<?php

namespace App\Http\Controllers;

use App\Enums\Notification\ReadPermission;
use App\Enums\Notification\Status;
use App\Enums\Notification\Type;
use App\Enums\User\PermissionLevel;
use App\Enums\User\Role;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\User;
use App\Trait\GoogleExtension;
use Symfony\Component\HttpFoundation\JsonResponse;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Auth;

/**
 * Google Controller
 *
 */
class GoogleController extends Controller
{
    use GoogleExtension;
    /**
     * Return the url of the google auth.
     * FE should call this and then direct to this url.
     *
     * @return JsonResponse
     */
    public function getAuthUrl(Request $request)
    {
        /**
         * Create google client
         */
        $client = $this->getClient();

        /**
         * Generate the url at google we redirect to
         */
        $authUrl = $client->createAuthUrl();

        /**
         * HTTP 200
         */
        return redirect($authUrl)->send();
    } // getAuthUrl


    /**
     * Login and register
     * Gets registration data by calling google Oauth2 service
     *
     * @return JsonResponse
     */
    public function postLogin(Request $request)
    {

        /**
         * Get authcode from the query string
         */
        $authCode = urldecode($request->input('code'));

        /**
         * Google client
         */
        $client = $this->getClient();

        /**
         * Exchange auth code for access token
         * Note: if we set 'access type' to 'force' and our access is 'offline', we get a refresh token. we want that.
         */
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // dd($accessToken);
        /**
         * Set the access token with google. nb json
         */
        $client->setAccessToken(json_encode($accessToken));

        // dd($accessToken);

        /**
         * Get user's data from google
         */
        $service = new \Google\Service\Oauth2($client);
        $userFromGoogle = $service->userinfo->get();

        /**
         * Select user if already exists
         */
        $user = User::where('provider_name', '=', 'google')
            ->where('provider_id', '=', $userFromGoogle->id)
            ->orWhere('email', $userFromGoogle->email)
            ->first();

        /**
         */
        if (!$user) {
            $user = User::create([
                'provider_id' => $userFromGoogle->id,
                'provider_name' => 'google',
                'google_access_token_json' => json_encode($accessToken),
                'name' => $userFromGoogle->name,
                'email' => $userFromGoogle->email,
                'password' => bcrypt('ilovepanda'),
                
            ]);

            $account = Account::create([
                'user_id' => $user->id,
                'avatar' => $userFromGoogle->picture,
                'role' => Role::LEARNER,
                'permission_level' => PermissionLevel::LEARNER,
                'note' => ''
            ]);
        }
        /**
         * Save new access token for existing user
         */
        else {
            $user->google_access_token_json = json_encode($accessToken);
            $user->save();
        }


        if (Auth::attempt([
            'email' => $user->email,
            'password' =>  'ilovepanda'
        ])) {
            $request->session()->regenerate();
            $notificationService = app('service.notification');
            $notificationService->create([
                'content' =>  trans('notification.loggin_success', ['username' => $user->name]),
                'user_id' => $user->id,
                'status' => Status::UNREAD,
                'type' => Type::AUTH,
                'read_permission' => ReadPermission::USER
            ]);
            return redirect()->intended('home');
        }

        return 'Error';
        /**
         * Log in and return token
         * HTTP 201
         */
        $token = $user->createToken("Google")->accessToken;
        return response()->json($token, 201);
    } // postLogin




    /**
     * Get meta data on a page of files in user's google drive
     *
     * @return JsonResponse
     */
    public function getDrive(Request $request): JsonResponse
    {
        /**
         * Get google api client for session user
         */
        $client = $this->getUserClient();

        /**
         * Create a service using the client
         * @see vendor/google/apiclient-services/src/
         */
        $service = new \Google\Service\Drive($client);

        /**
         * The arguments that we pass to the google api call
         */
        $parameters = [
            'pageSize' => 10,
        ];

        /**
         * Call google api to get a list of files in the drive
         */
        $results = $service->files->listFiles($parameters);

        /**
         * HTTP 200
         */
        return response()->json($results, 200);
    }
}
