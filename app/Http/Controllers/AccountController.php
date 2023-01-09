<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function profile(Request $request, $id)
    {
        $account = Account::where('id', $id)->first();
        return view('pages.account.profile', [
            'account' => $account
        ]);
    }
}
