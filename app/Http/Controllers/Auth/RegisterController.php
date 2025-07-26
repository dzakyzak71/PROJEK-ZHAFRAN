<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
         // Ambil IP dan lokasi
        $ip = $request->ip();
        $location = 'Tidak diketahui';

        try {
            $response = Http::get("http://ip-api.com/json/{$ip}");
            if ($response->ok()) {
                $data = $response->json();
                $location = $data['city'] . ', ' . $data['country'];
            }
        } catch (\Exception $e) {
            // biarkan location tetap default
        }

        // Buat user
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'ip'       => $ip,
            'location' => $location,
        ]);
            // Assign role
        $user->assignRole('user');

        // Login langsung
        Auth::login($user);
        
        // Kirim email verifikasi
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }
}

