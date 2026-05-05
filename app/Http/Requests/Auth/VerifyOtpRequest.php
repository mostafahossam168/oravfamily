<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class VerifyOtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone'     => ['required', 'string'],
            'otp'       => ['required', 'string', 'size:6'],
            'fcm_token' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => 'رقم الهاتف مطلوب',
            'otp.required'   => 'كود التحقق مطلوب',
            'otp.size'       => 'كود التحقق يجب أن يكون 6 أرقام',
        ];
    }
}
