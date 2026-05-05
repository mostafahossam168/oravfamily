<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    // Fonnte — free WhatsApp API (fonnte.com)
    // 1. سجّل على fonnte.com
    // 2. اسكان QR بهاتفك
    // 3. انسخ الـ Token وحطه في FONNTE_TOKEN بالـ .env
    private string $endpoint = 'https://api.fonnte.com/send';

    public function sendOtp(string $phone, string $otp): bool
    {
        $message = "🔐 كود التحقق الخاص بك:\n\n*{$otp}*\n\nصالح لمدة 5 دقائق.\nلا تشارك هذا الكود مع أي أحد.";

        try {
            $response = Http::withHeaders([
                'Authorization' => config('services.fonnte.token'),
            ])->post($this->endpoint, [
                'target'  => $phone,
                'message' => $message,
            ]);

            if (!$response->successful()) {
                Log::warning('Fonnte WhatsApp failed', [
                    'phone'  => $phone,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Fonnte WhatsApp exception: ' . $e->getMessage());
            return false;
        }
    }
}
