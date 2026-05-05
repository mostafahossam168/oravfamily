<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class AuthRepository implements AuthInterface
{
    public function __construct(private WhatsAppService $whatsApp) {}

    public function profile($request)
    {
        return $request->user();
    }

    public function sendOtp(string $phone): bool
    {
        $user = User::firstOrCreate(['phone' => $phone], []);

        $otp = '123456';
        $user->otp = $otp;
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->save();

        return $this->whatsApp->sendOtp($phone, $otp);
    }

    public function verifyOtp(string $phone, string $otp, ?string $fcmToken): array
    {
        $user = User::where('phone', $phone)->first();

        if (!$user) {
            return ['success' => false, 'message' => 'رقم الهاتف غير مسجل'];
        }

        if ($user->otp !== $otp) {
            return ['success' => false, 'message' => 'كود التحقق غير صحيح'];
        }

        if (Carbon::now()->isAfter($user->otp_expires_at)) {
            return ['success' => false, 'message' => 'انتهت صلاحية كود التحقق، أعد الإرسال'];
        }

        $user->otp = null;
        $user->otp_expires_at = null;

        if ($fcmToken) {
            $user->fcm_token = $fcmToken;
        }

        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return ['success' => true, 'user' => $user, 'token' => $token];
    }

    public function logout(User $user): void
    {
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
    }
}
