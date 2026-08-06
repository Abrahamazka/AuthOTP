<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(12)->mixedCase()->symbols()],
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json(['message' => 'Register berhasil', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => ['required', Password::min(12)->mixedCase()->symbols()],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password salah!'], 401);
        }

        $googleResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        $otp = Str::random(12);

        $hashedotp = Hash::make($otp);

        Cache::put('otp_' . $user->email, $hashedotp, now()->addMinutes(1));

        Mail::to($user->email)->send(new OtpMail($otp));

        //     return response()->json([
        //     'msg' => 'Cek kode OTP di email anda',
        //     'otpawl' => $otp,
        //     'otphash' => $hashedotp,
        //     'cek' => Cache::get('otp_' . $user->email)
        // ], 200);

        return response()->json(['message' => 'Cek kode OTP di email anda'], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string',
        ]);

        $simpanOtphash = Cache::get('otp_' . $request->email);

        if (!$simpanOtphash || !Hash::check($request->otp, $simpanOtphash)) {
            return response()->json(['message' => 'Kode OTP tidak valid'], 400);
        }

        Cache::forget('otp_' . $request->email);

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => 'sukses', 'message' => 'Login berhasil', 'token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => 'sukses', 'message' => 'Logout berhasil'], 200);
    }
}
