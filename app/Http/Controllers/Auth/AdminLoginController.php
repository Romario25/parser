<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('auth.login-admin');
    }

    protected function credentials(Request $request)
    {

        return array_merge($request->only($this->username(), 'password'), ['status' => 1, 'role' => User::ADMIN]);

    }
}
