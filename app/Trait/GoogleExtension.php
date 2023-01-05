<?php

namespace App\Trait;


trait GoogleExtension{

    /**
     * Returns a google client that is logged into the current user
     *
     * @return Client
     */
    private function getUserClient()
    {
        /**
         * Get Logged in user
         */
        $user = \App\Models\User::where('id', '=', auth()->user()->id)->first();

        /**
         * Strip slashes from the access token json
         * if you don't strip mysql's escaping, everything will seem to work
         * but you will not get a new access token from your refresh token
         */
        $accessTokenJson = stripslashes($user->google_access_token_json);

        /**
         * Get client and set access token
         */
        $client = $this->getClient();
        $client->setAccessToken($accessTokenJson);

        /**
         * Handle refresh
         */
        if ($client->isAccessTokenExpired()) {
            // fetch new access token
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            $client->setAccessToken($client->getAccessToken());

            // save new access token
            $user->google_access_token_json = json_encode($client->getAccessToken());
            $user->save();
        }

        return $client;
    } // getUserClient

    /**
     * Gets a google client
     *
     * @return Client
     */
    private function getClient(): \Google\Client
    {
        // load our config.json that contains our credentials for accessing google's api as a json string
        $configJson = env('GOOGLE_SECRET');

        // define an application name
        $applicationName = env('APP_NAME');

        // create the client
        $client = new \Google\Client();
        $client->setApplicationName($applicationName);
        $client->setAuthConfig($configJson);
        $client->setAccessType('offline'); // necessary for getting the refresh token
        $client->setApprovalPrompt('force'); // necessary for getting the refresh token
        // scopes determine what google endpoints we can access. keep it simple for now.
        $client->setScopes(
            [
                \Google\Service\Oauth2::USERINFO_PROFILE,
                \Google\Service\Oauth2::USERINFO_EMAIL,
                \Google\Service\Oauth2::OPENID,
                \Google\Service\Sheets::SPREADSHEETS_READONLY
            ]
        );
        $client->setIncludeGrantedScopes(true);
        return $client;
    } // getClient

}