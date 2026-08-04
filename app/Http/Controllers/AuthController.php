<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);

        return response()->json(['message' => 'Register berhasil', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Password salah!'], 401);
        }

        $otp = rand(100000, 999999);

        Cache::put('otp_' . $user->email, $otp, now()->addMinutes(1));

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'Cek kode OTP di email anda'], 200);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric',
        ]);

        $simpanOtp = Cache::get('otp_' . $request->email);

        if (!$simpanOtp || $simpanOtp != $request->otp) {
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
