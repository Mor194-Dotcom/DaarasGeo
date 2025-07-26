<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Alerte;
use App\Models\Utilisateur;

class AlerteDeclencheeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    /*   public function __construct()
    {
        //
    } */

    /**
     * Get the message envelope.
     */
    /*  public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alerte Declenchee Mail',
        );
    }
 */
    /**
     * Get the message content definition.
     */
    public $alerte;
    public $destinataire;

    public function __construct(Alerte $alerte, Utilisateur $destinataire)
    {
        $this->alerte = $alerte;
        $this->destinataire = $destinataire;
    }

    public function build()
    {
        return $this->subject('🚨 Alerte Talibé hors zone')
            ->view('emails.alerte_declenchee');
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
