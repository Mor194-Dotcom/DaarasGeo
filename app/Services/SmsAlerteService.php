<?php

namespace App\Services;

use App\Models\Alerte;
use App\Services\SmsProviders\InfobipSmsProvider;
use Illuminate\Support\Facades\Log;

class SmsAlerteService
{
    public static function envoyer(Alerte $alerte, string $numero)
    {
        // Message clair, court, et compatible SMS
        $message = "🚨 DAARASGEO : Talibé hors zone détecté.\n" .
            "Nom: " . ($alerte->utilisateur->nom ?? 'Inconnu') . "\n" .
            "Date: " . now()->format('d/m/Y H:i');

        try {
            $smsProvider = new InfobipSmsProvider(); // ou fallback Twilio
            return $smsProvider->send($numero, $message);
        } catch (\Throwable $e) {
            Log::warning("Échec SMS alerte vers $numero : " . $e->getMessage());
            return false;
        }
    }
}
