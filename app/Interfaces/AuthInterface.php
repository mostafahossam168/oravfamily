<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthInterface
{
    public function profile($request);
    public function sendOtp(string $phone): bool;

    public function verifyOtp(string $phone, string $otp, ?string $fcmToken): array;

    public function logout(User $user): void;
}
