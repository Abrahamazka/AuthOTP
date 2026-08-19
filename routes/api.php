<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PwresetController;
use App\Http\Controllers\LaporanController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/request-otp', [AuthController::class, 'requestOtp']);
Route::post('/login/verify-otp', [AuthController::class, 'verifyOtp']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profil', function (Illuminate\Http\Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::put('/profil/update', [AuthController::class, 'updateProfile']);
    Route::post('/profil/foto', [AuthController::class, 'updateFoto']);
    Route::delete('/profil/foto', [AuthController::class, 'hapusFoto']);
    Route::put('profil/password', [AuthController::class, 'updatePassword']);
    Route::post('/laporan', [LaporanController::class, 'store']);
    Route::get('/admin/laporan', [LaporanController::class, 'indexAdmin']);
    Route::patch('/admin/laporan/{id}/status', [LaporanController::class, 'updateStatus']);
    Route::delete('/admin/laporan/{id}', [LaporanController::class, 'destroy']);
});
Route::post('/forgot-password', [PwresetController::class, 'sendOtp']);
Route::post('/verify-otp', [PwresetController::class, 'verifyOtp']);
Route::post('/password-reset', [PwresetController::class, 'passwordReset']);

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('/admin/users', [AuthController::class, 'createUser']);
    Route::get('/admin/users', [AuthController::class, 'getAllUsers']);
    Route::delete('/admin/users/{id}', [AuthController::class, 'deleteUser']);
    Route::put('/admin/users/{id}/role', [AuthController::class, 'ubahRole']);
    Route::put('/admin/users/{id}/password-reset', [AuthController::class, 'resetPasswordUser']);
    Route::put('/admin/users/{id}', [AuthController::class, 'updateUserAdmin']);
});
