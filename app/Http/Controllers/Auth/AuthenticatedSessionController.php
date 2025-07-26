<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->hasRole('superadmin')) {
                return redirect()->intended('/superadmin/dashboard');
            } elseif ($user->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->intended('/user/dashboard');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }
}

