<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class AlerteTalibeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $alerte;

    public function __construct($alerte)
    {
        $this->alerte = $alerte;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🚨 Alerte Talibé hors zone')
            ->greeting('Bonjour ' . $notifiable->prenom)
            ->line('Un Talibé est sorti de sa zone de sécurité.')
            ->line('Nom : ' . $this->alerte->utilisateur->prenom)
            ->line('Distance : ' . number_format($this->alerte->distance, 2) . ' m')
            ->line('Date : ' . \Carbon\Carbon::parse($this->alerte->date)->format('d/m/Y à H:i'))
            ->action('Voir la carte', url('/cartes'))
            ->line('Merci de votre vigilance.');
    }


    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
