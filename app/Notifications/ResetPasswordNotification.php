<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    protected $token;


    /**
     * Create a new notification instance.
     */
       public function __construct($token)
       {
	       $this->token = $token;
       }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
	    return (new MailMessage)
		    ->subject(Lang::get('Cambiar Contraseña'))
		    ->line('Recibes este correo porque hemos recibido una solicitud de restablecimiento de contraseña para tu cuenta.')
		    ->action('Restablecer Contraseña', url(config('app.url').route('password.reset', $this->token, false)))
		    ->line('Si no solicitaste un restablecimiento de contraseña, puedes ignorar este correo y tu contraseña seguirá siendo la misma.');
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
