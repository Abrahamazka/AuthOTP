<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PwresetController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:3,5');
Route::post('/login/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('throttle:3,5');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profil', function (Illuminate\Http\Request $request) {
        return $request->user();
    }); 
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('/forgot-password', [PwresetController::class, 'sendOtp'])->middleware('throttle:5,2');
Route::post('/verify-otp', [PwresetController::class, 'verifyOtp']);
Route::post('/password-reset', [PwresetController::class, 'passwordReset']);