<?php

namespace App\Services\SmsProviders;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InfobipSmsProvider
{
    public function send(string $to, string $message): bool
    {
        $payload = [
            'messages' => [
                [
                    'from' => config('services.infobip.sender'),
                    'destinations' => [['to' => $to]],
                    'text' => $message
                ]
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'App ' . config('services.infobip.key'),
                'Content-Type' => 'application/json'
            ])->post(config('services.infobip.url') . '/sms/2/text/advanced', $payload);

            if ($response->successful()) {
                Log::info("[Infobip] SMS envoyé à $to : " . $message);
                return true;
            }

            Log::warning("[Infobip] Échec pour $to → " . $response->status() . ' : ' . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error("[Infobip] Exception : " . $e->getMessage());
            return false;
        }
    }
}
