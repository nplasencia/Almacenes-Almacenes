<?php

namespace App\Repositories;

use App\Commons\Roles;
use App\Commons\UserContract;
use App\Entities\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new User();
    }

    public function store(Guard $auth, array $data) {
    	if (!isset($data[UserContract::CENTER_ID])) {
		    $data[UserContract::CENTER_ID] = $auth->user()->center_id;
	    }
	    $user = new User($data);
	    $user->password = bcrypt(str_random(10));
	    $user->remember_token = str_random(10);
	    $user->save();
    }

    public function update(Guard $auth, $name, $surname, $telephone, $email)
    {
        $user = $auth->user();
        $user->update([UserContract::NAME => $name, UserContract::SURNAME => $surname, UserContract::TELEPHONE => $telephone, UserContract::EMAIL => $email]);
        return $user;
    }

    private function sqlForAll($withoutActualUser) {
	    $user = Auth::user();
	    $query = $this->newQuery();
	    if ($withoutActualUser) {
		    $query = $query->where(UserContract::ID, '<>', $user->id);
	    }

	    if ($user->role == Roles::ADMIN) {
	    	$query = $query->where(UserContract::ROLE, '<>', Roles::SUPER_ADMIN)->where(UserContract::CENTER_ID, $user->center_id);
	    }

	    return $query->orderBy(UserContract::NAME)->orderBy(UserContract::SURNAME);
    }

    public function getAll($withoutActualUser = true)
    {
    	return $this->sqlForAll($withoutActualUser)->get();
    }

	public function getAllPaginated($pagination, $withoutActualUser = true)
	{
		return $this->sqlForAll($withoutActualUser)->paginate($pagination);
	}
}