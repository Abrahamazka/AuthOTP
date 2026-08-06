<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PwresetController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $email = $request->email;

        $otp = Str::random(12);

        $hashedotp = Hash::make($otp);

        Cache::put('otp_' . $email, $hashedotp, now()->addMinutes(1));

        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($email) {
            $message->to($email)
                ->subject('Kode OTP Reset Password');
        });

        return response()->json([
            'status' => 'sukses'
        ], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|string'
        ]);

        $email = $request->email;

        $Otpsimpan = Cache::get('otp_' . $email);

        if (!$Otpsimpan) {
            return response()->json([
                'message' => 'Kode OTP sudah kedaluwarsa atau tidak ditemukan.'
            ], 400);
        }

        if (!hash::check($request->otp, $Otpsimpan)) {
            return response()->json([
                'message' => 'Kode OTP salah.'
            ], 400);
        }

        Cache::forget('otp_' . $email);

        $resetToken = \Illuminate\Support\Str::random(60);

        Cache::put('reset_token_' . $email, $resetToken, now()->addMinutes(2));

        return response()->json([
            'message' => 'OTP Valid! Silakan buat password baru dalam 2 menit.',
            'reset_token' => $resetToken
        ], 200);
    }
    public function passwordReset(Request $request)
    {
        $request->validate([
            'email'       => 'required|email|exists:users,email',
            'reset_token' => 'required',
            'password'    => 'required|min:8|confirmed'
        ]);

        $email = $request->email;
        $savedToken = Cache::get('reset_token_' . $email);

        if (!$savedToken || $savedToken !== $request->reset_token) {
            return response()->json([
                'message' => 'Sesi reset password tidak valid atau sudah kedaluwarsa.'
            ], 400);
        }

        $user = User::where('email', $email)->first();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        Cache::forget('reset_token_' . $email);

        return response()->json([
            'message' => 'Password berhasil diubah! Silakan login.'
        ], 200);
    }
}
