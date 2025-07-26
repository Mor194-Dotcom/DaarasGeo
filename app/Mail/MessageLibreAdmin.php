<?php

namespace App\Mail;

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Utilisateur;

class MessageLibreAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public Utilisateur $destinataire;
    public string $contenu;

    public function __construct(Utilisateur $destinataire, string $contenu)
    {
        $this->destinataire = $destinataire;
        $this->contenu = $contenu;
    }

    public function build()
    {
        return $this->subject("Message administratif — DAARASGEO")
            ->view('emails.message_libre_admin')
            ->with([
                'nom' => $this->destinataire->nom,
                'contenu' => $this->contenu,
            ]);
    }
}
