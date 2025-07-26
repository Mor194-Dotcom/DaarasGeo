<?php

namespace App\Services;

use App\Services\SmsProviders\InfobipSmsProvider;
use App\Services\SmsProviders\TwilioSmsProvider;
use Illuminate\Support\Facades\Log;

class SmsDispatcher
{
    protected InfobipSmsProvider $infobip;
    protected TwilioSmsProvider $twilio;

    public function __construct()
    {
        $this->infobip = new InfobipSmsProvider();
        $this->twilio = new TwilioSmsProvider();
    }

    public function send(string $to, string $message): bool
    {
        // Tentative Infobip
        if ($this->infobip->send($to, $message)) {
            Log::info("[SMS Dispatcher] Infobip réussi.");
            return true;
        }

        Log::warning("[SMS Dispatcher] Infobip échoué, bascule vers Twilio.");

        // Tentative Twilio
        if ($this->twilio->send($to, $message)) {
            Log::info("[SMS Dispatcher] Twilio réussi.");
            return true;
        }

        Log::error("[SMS Dispatcher] Échec des deux providers.");
        return false;
    }
}
