<?php

namespace App\Http\Controllers;

use App\Repositories\UserProfileRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
	protected $icon              = 'fa fa-users';

	protected $userProfileRepository;

    public function __construct(UserProfileRepository $userProfileRepository)
    {
        $this->userProfileRepository = $userProfileRepository;
    }

    protected function userProfileValidation(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string',
            'surname'   => 'required|string',
            'telephone' => 'numeric',
            'email'     => 'required|email',
            'image'     => 'image|mimes:jpeg,jpg',
        ]);
    }


    public function resume(Guard $auth)
    {
        $user = $auth->user();
	    $sendEmailOptions = [null => 'Nunca', 1 => 'Cada día', 7 => 'Cada semana', 15 => 'Cada 15 días', 30 => 'Cada 30 días'];
	    $notificationOptions = [7 => '1 semana antes', 15 => '15 días antes', 30 => '1 mes antes', 60 => '2 meses antes'];
        return view('user_profile', ['title' => $user->completeName, 'icon' => $this->icon, 'user' => $user,
                                     'sendEmailOptions' => $sendEmailOptions, 'notificationOptions' => $notificationOptions]);
    }

    public function update(Request $request, Guard $auth)
    {
        $this->userProfileValidation($request);
        $this->userProfileRepository->update($auth, $request);
        if ($request->file('image') !== null) {
            $file = $request->file('image');
            Storage::disk('public')->put('avatar/'.$auth->user()->id.'.jpg', File::get($file));
        }
        session()->flash('success', trans('pages/user_profile.update_success'));
        return Redirect::route('user_profile.resume');
    }

    public function getProfileImage(Guard $auth)
    {
        $file = Storage::disk('public')->get('avatar/'.$auth->user()->id.'.jpg');
        return new Response($file, 200);
    }

	public function changePassword(Request $request)
	{
		if (!Hash::check($request->get('old_pswd'), Auth::user()->password)) {
			session()->flash( 'info', trans( 'pages/user_profile.update_pswd_error' ) );
		} else {
			$user = Auth::user();
			$user->password = Hash::make($request->get('new_pswd'));
			$user->save();
			session()->flash( 'success', trans( 'pages/user_profile.update_pswd_success' ) );
		}
		return Redirect::route('user_profile.resume');
	}
}
