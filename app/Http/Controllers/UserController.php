<?php

namespace App\Http\Controllers;

use App\Commons\UserContract;
use App\Entities\User;
use App\Mail\NewUser as NewUserEmail;
use App\Repositories\CenterRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
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

	private function sendEmailToNewUser(User $user)
	{
		Mail::send('emails.new_user', ['user' => $user], function ($m) use ($user) {
			$m->from('no-reply.alcruz@auret.es', 'Alcruz Canarias Software');

			$m->to($user->email, $user->name)->subject('[Almacenes] Has sido registrado correctamente');
		});

		return response();
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

	public function store(Guard $auth, Request $request)
	{

		$this->userValidation($request);

		try {
			$user = $this->userRepository->store($auth, $request->only([UserContract::NAME, UserContract::SURNAME, UserContract::ROLE,
																        UserContract::CENTER_ID, UserContract::TELEPHONE, UserContract::EMAIL]));
			//$user->notify(new NewUser($user));
			Mail::to($user->email, $user->completeName)->send(new NewUserEmail($user));
			session()->flash('success', trans('pages/user.store_success',['Name' => $user->completeName]));
		} catch (\PDOException $exception) {
			session()->flash('info', trans('pages/user.store_exists', ['Name' => "{$request->get('name')} {$request->get('surname')}"]));
		} finally {
			return $this->resume();
		}
	}

	public function details($id)
	{
		$user = $this->userRepository->findOrFail($id);
		$roles = Auth::user()->getRolesForCreatingUsers();
		$centers = $this->centerRepository->getAll();

		return view('pages.users.details', ['title' => $user->completeName, 'icon' => $this->icon, 'roles' => $roles, 'centers' => $centers, 'user' => $user]);
	}

	public function update(Request $request, Guard $auth, $id)
	{
		//$this->userValidation($request);

		$user = $this->userRepository->update($auth, $id, $request->only([UserContract::NAME, UserContract::SURNAME, UserContract::ROLE,
																   UserContract::CENTER_ID, UserContract::TELEPHONE, UserContract::EMAIL]));

		session()->flash('success', trans('pages/user.update_success',['Name' => $user->completeName]));
		return Redirect::route('user.details', $user->id);
	}

	public function delete($id)
	{
		$user = $this->userRepository->deleteById($id);
		session()->flash('success', trans('pages/user.delete_success',['Name' => $user->completeName]));
		return $this->resume();
	}
}
