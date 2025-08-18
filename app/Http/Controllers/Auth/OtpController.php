<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        // Generate kode OTP (6 digit)
        $otp = rand(100000, 999999);

        // Simpan ke cache untuk 5 menit
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(5));

        // Kirim via email
        try {
            Mail::raw("Kode OTP Anda adalah: $otp (berlaku 5 menit)", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject("Kode OTP Pendaftaran");
            });

            return response()->json([
                'success' => true,
                'message' => 'Kode OTP berhasil dikirim ke email Anda.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim OTP: ' . $e->getMessage()
            ], 500);
        }
    }
}
