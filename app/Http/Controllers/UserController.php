<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $icon  = 'fa fa-user';
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    protected function genericValidation(Request $request)
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
        return view('user_profile', ['title' => $user->getCompleteName(), 'icon' => $this->icon, 'user' => $user]);
    }

    public function update(Request $request, Guard $auth)
    {
        $this->genericValidation($request);
        $this->userRepository->update($auth, $request->get('name'), $request->get('surname'), $request->get('telephone'), $request->get('email'));
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
}
