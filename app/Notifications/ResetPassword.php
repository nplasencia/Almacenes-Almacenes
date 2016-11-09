<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{

	/**
	 * The password reset token.
	 *
	 * @var string
	 */
	public $token;

	/**
	 * Create a notification instance.
	 *
	 * @param  string  $token
	 */
	public function __construct($token)
	{
		$this->token = $token;
	}

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
	        ->subject(trans('email.reset_subject'))
	        ->view('auth.emails.password')
	        ->line('Estás recibiendo este email porque hemos registrado una solicitud de reinicio de tu contraseña.')
	        ->action('Reiniciar contraseña', url('password/reset', $this->token))
	        ->line('Si no has solicitado reiniciar tu contraseña, ignora este mensaje.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
