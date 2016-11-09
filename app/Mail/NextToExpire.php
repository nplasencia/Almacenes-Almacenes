<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NextToExpire extends Mailable
{
    use Queueable, SerializesModels;

	public $nextToExpireCentersAndItems;

	/**
	 * Create a new message instance.
	 *
	 * @param array $nextToExpireCentersAndItems
	 */
    public function __construct(Array $nextToExpireCentersAndItems)
    {
        $this->nextToExpireCentersAndItems = $nextToExpireCentersAndItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
	    return $this->view('emails.next_to_expire')
	                ->subject(trans('email.next_to_subject'))
	                ->with('introLines', ['Estos son los artículos próximos a caducar:'])
	                ->with('actionText', 'Acceder al software')
	                ->with('actionUrl', url('/'))
	                ->with('level', 'success')
	                ->with('outroLines', ['Esperamos que tengas un buen día.']);
    }
}
