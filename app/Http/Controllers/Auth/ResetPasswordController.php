<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Password Reset Controller
	|--------------------------------------------------------------------------
	|
	| This controller is responsible for handling password reset requests
	| and uses a simple trait to include this behavior. You're free to
	| explore this trait and override any methods you wish to tweak.
	|
	*/
	use ResetsPasswords;

	/**
	 * Where to redirect users after resetting their password.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get the response for a successful password reset.
	 *
	 * @param  string  $response
	 * @return \Illuminate\Http\Response
	 */
	protected function sendResetResponse($response)
	{
		$user = Auth::user();
		session( [ 'center_id' => 1 ] );

		if (isset($user->center_id)) {
			session( [ 'center_id' => $user->center_id ] );
		}

		return redirect($this->redirectPath())
			->with('status', trans($response));
	}

}
