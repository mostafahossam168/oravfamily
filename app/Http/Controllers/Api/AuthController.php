<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendOtpRequest;
use App\Http\Requests\Auth\VerifyOtpRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(private AuthService $authService) {}


    public function profile(Request $request)
    {
        $user = $this->authService->profile($request);
        return $this->returnData(new UserResource($user), 'بيانات المستحدم');
    }

    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $this->authService->sendOtp($request->phone);

        return $this->returnSuccessMessage('تم إرسال كود التحقق بنجاح');
    }

    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $result = $this->authService->verifyOtp(
            $request->phone,
            $request->otp,
            $request->fcm_token
        );

        if (!$result['success']) {
            return $this->returnError($result['message']);
        }

        return $this->returnData([
            'user'  => new UserResource($result['user']),
            'token' => $result['token'],
        ], 'تم تسجيل الدخول بنجاح');
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->returnSuccessMessage('تم تسجيل الخروج بنجاح');
    }
}
