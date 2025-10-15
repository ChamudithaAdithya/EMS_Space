<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login()
    {

        if (!empty(Auth::check())) {
            return redirect('admin/dashboard');
        }

        return view('auth.login');
    }

    public function AuthLogin(Request $request)
    {
        $credentilas = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentilas, $remember)) {
            return redirect()->intended('admin/dashboard');

        } else {
            return redirect()->back()->with('error', "Incorrect Email and Password. Try again!");
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect(url(""));
    }
}
