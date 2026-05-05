<?php

use App\Http\Controllers\Api\AuthController;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::middleware('auth:sanctum')->post('my-profile', [AuthController::class, 'profile']);
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
});
