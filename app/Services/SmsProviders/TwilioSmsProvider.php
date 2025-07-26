<?php

namespace App\Services\SmsProviders;

use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;


class TwilioSmsProvider
{
    protected Client $client;
    protected string $sender;

    public function __construct()
    {
        // Initialisation du client Twilio avec les variables d'environnement
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $this->sender = config('services.twilio.from');
    }

    public function send(string $to, string $message): bool
    {
        try {
            $this->client->messages->create($to, [
                'from' => $this->sender,
                'body' => $message,
            ]);

            Log::info("[Twilio] SMS envoyé à $to : $message");
            return true;
        } catch (\Throwable $e) {
            Log::error("[Twilio] Échec d'envoi à $to : " . $e->getMessage());
            return false;
        }
    }
}
