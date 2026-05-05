<?php

namespace App\Services;

use App\Interfaces\AuthInterface;
use App\Models\User;

class AuthService
{
    public function __construct(private AuthInterface $repository) {}

    public function profile($request)
    {
        return $this->repository->profile($request);
    }
    public function sendOtp(string $phone): bool
    {
        return $this->repository->sendOtp($phone);
    }

    public function verifyOtp(string $phone, string $otp, ?string $fcmToken): array
    {
        return $this->repository->verifyOtp($phone, $otp, $fcmToken);
    }

    public function logout(User $user): void
    {
        $this->repository->logout($user);
    }
}
