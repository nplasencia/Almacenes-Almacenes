<?php

namespace App\Mail;

use App\Entities\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUser extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var User
	 */
	public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new_user')
	        ->subject(trans('email.new_user_subject'))
	        ->with('introLines', ['Bienvenido al software de almacenes de la empresa Alcruz Canarias SL. Estos son los datos de acceso:'])
	        ->with('actionText', 'Acceder al sistema')
	        ->with('actionUrl', url('/'))
	        ->with('level', 'success')
	        ->with('outroLines', ['Podrás cambiar la clave desde tu panel de usuario. ¡Bienvenido!']);
    }
}
