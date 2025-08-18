<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // file blade kamu
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'phone'                 => 'required|string|max:20',
            'otp'                   => 'required|numeric',
            'password'              => 'required|min:6|confirmed',
        ]);

        // Validasi OTP
        $otp = Cache::get('otp_' . $request->email);
        if (!$otp || $otp != $request->otp) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }

        // Simpan user baru
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => Hash::make($request->password),
        ]);

        // Assign role 'user'
        $user->assignRole('user');

        // Hapus OTP setelah dipakai
        Cache::forget('otp_' . $request->email);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
