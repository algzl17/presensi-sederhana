<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login()
    {
        if (auth()->check()) {
            return to_route('home');
        }
        return view('autentification.login');
    }

    public function loginPost()
    {
        request()->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'required' => 'Wajib isi!',
            'email' => 'Email tidak valid!'
        ]);

        $admin = User::whereEmail(request()->post('email'))->first();
        if ($admin) {
            if (password_verify(request()->post('password'), $admin->password)) {
                Auth::login($admin, request()->post('remender') ? true : false);
                return to_route('home');
            }
            return back()->withErrors(['password' => 'Kata sandi salah!']);
        }
        return back()->withErrors(['email' => 'Email tidak terdaftar!']);
    }

    public function signout()
    {
        Auth::logout();
        return to_route('login');
    }
}
