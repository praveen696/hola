<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request) {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/');
        }
        return redirect()->back()->withErrors(['Username or password incorrect']);;
    }
    public function getLogout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
