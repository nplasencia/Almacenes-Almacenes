<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class LoginController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/
	use AuthenticatesUsers;

	protected $redirectTo = '/';

	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

		$user = Auth::user();
		session( [ 'center_id' => 1 ] );

		if (isset($user->center_id)) {
			session( [ 'center_id' => $user->center_id ] );
		}

		$this->clearLoginAttempts($request);

		return $this->authenticated($request, $this->guard()->user())
			?: redirect()->intended($this->redirectPath());
	}
}
