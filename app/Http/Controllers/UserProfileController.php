<?php

namespace App\Http\Controllers;

use App\Commons\UserContract;
use App\Entities\User;
use App\Repositories\CenterRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{
	protected $defaultPagination = 25;
	protected $icon              = 'fa fa-users';
	protected $titleResume       = 'pages/user.title';
	protected $titleNew          = 'pages/user.new_button';

    protected $centerRepository;
	protected $userRepository;

    public function __construct(CenterRepository $centerRepository, UserRepository $userRepository)
    {
    	$this->centerRepository = $centerRepository;
        $this->userRepository   = $userRepository;
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

	protected function userValidation(Request $request)
	{
		$this->validate($request, [
			UserContract::NAME      => 'required|string',
			UserContract::SURNAME   => 'required|string',
			UserContract::TELEPHONE => 'numeric',
			UserContract::EMAIL     => 'required|email',
			UserContract::ROLE      => 'string',
			UserContract::CENTER_ID => 'numeric',
		]);
	}

	protected function getTableActionButtons(User $user)
	{
		return '<div class="btn-group">
                    <a href="'.route('user.details', $user->id).'" data-toggle="tooltip" data-original-title="'.trans('general.edit').'" data-placement="bottom" class="btn btn-success btn-xs">
                        <i class="fa fa-edit"></i>
                    </a>
                </div>
                
                <div class="btn-group">
                    <a href="'.route('user.delete', $user->id).'" data-toggle="tooltip" data-original-title="'.trans('general.remove').'" data-placement="bottom" class="btn btn-danger btn-xs btn-delete">
                        <i class="fa fa-trash-o"></i>
                    </a>
                </div>';
	}

	public function ajaxResume()
	{
		return Datatables::of($this->userRepository->getAll())
				->addColumn('role', function (User $user) {
					return trans("general.{$user->role}");
				})
                ->addColumn('actions', function (User $user) {
	                 return $this->getTableActionButtons($user);
                })
                ->make(true);
	}


    public function resumeProfile(Guard $auth)
    {
        $user = $auth->user();
        return view('user_profile', ['title' => $user->completeName, 'icon' => $this->icon, 'user' => $user]);
    }

    public function updateProfile(Request $request, Guard $auth)
    {
        $this->userProfileValidation($request);
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

    public function resume()
    {
	    $users = $this->userRepository->getAllPaginated($this->defaultPagination);
	    return view('pages.users.resume', ['title' => trans($this->titleResume), 'icon' => $this->icon, 'users' => $users]);
    }

	public function create()
	{
		$roles = Auth::user()->getRolesForCreatingUsers();
		$centers = $this->centerRepository->getAll();
		return view('pages.users.details', ['title' => trans($this->titleNew), 'icon' => $this->icon, 'roles' => $roles, 'centers' => $centers]);
	}

	public function store(Request $request)
	{
		$this->userValidation($request);
		try {
			$user = $this->userRepository->create($request->only([UserContract::NAME, UserContract::SURNAME, UserContract::ROLE,
																  UserContract::CENTER_ID, UserContract::TELEPHONE, UserContract::EMAIL]));

			session()->flash('success', trans('pages/user.store_success',['Name' => $user->completeName]));
		} catch (\PDOException $exception) {
			session()->flash('info', trans('pages/user.store_exists', ['Name' => "{$request->get('name')} {$request->get('surname')}"]));
		} finally {
			return Redirect::route('center.resume');
		}
	}

	public function update(Request $request, $id)
	{
		$this->genericValidation($request);
		$center = $this->centerRepository->update($id, $request->only(['name', 'address', 'address2', 'municipality_id', 'postalCode']));
		session()->flash('success', trans('pages/center.update_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
		return Redirect::route('center.details', $center->id);
	}

	public function delete($id)
	{
		$center = $this->centerRepository->deleteById($id);
		if (session('center_id') == $id) {
			session()->forget('center_id');
		}
		session()->flash('success', trans('pages/center.delete_success',['Name' => $center->name, 'Municipality' => $center->municipality->name]));
		return $this->resume();
	}
}
