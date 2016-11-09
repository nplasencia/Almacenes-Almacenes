<?php

namespace App\Repositories;

use App\Commons\Roles;
use App\Commons\UserContract;
use App\Entities\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
	    $pass = str_random(10);
	    $user = new User($data);
	    $user->password = Hash::make($pass);
	    $user->remember_token = str_random(10);
	    $user->save();
	    $user->password = $pass;
	    return $user;
    }

    public function update(Guard $auth, $id, array $data)
    {
    	if (!isset($data[UserContract::CENTER_ID])) {
		    $data[UserContract::CENTER_ID] = $auth->user()->center_id;
	    }
        $user = $this->findOrFail($id);
        $user->update($data);

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