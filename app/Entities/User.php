<?php

namespace App\Entities;

use App\Commons\Roles;
use App\Commons\UserContract;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Storage;

class User extends AuthUser
{

    protected $fillable = [ UserContract::NAME, UserContract::SURNAME, UserContract::EMAIL, UserContract::ROLE, UserContract::TELEPHONE, UserContract::CENTER_ID ];

    protected $hidden = [ UserContract::PASSWORD, 'remember_token' ];

	protected $hierarchy = [
		Roles::SUPER_ADMIN => 3,
		Roles::ADMIN       => 2,
		Roles::ADVANCED    => 1,
		Roles::REGULAR     => 0,
	];

	public function canSee($minRole)
	{
		if ($minRole == null || $this->hierarchy[$this->role] >= $this->hierarchy[$minRole]) {
			return true;
		}
		return false;
	}

	public function isSuperAdmin()
	{
		return $this->canSee(Roles::SUPER_ADMIN);
	}

    public function isAdmin()
    {
	    return $this->canSee(Roles::ADMIN);
    }

	public function isAdvancedUser() {
		return $this->canSee(Roles::ADVANCED);
	}

	public function getRolesForCreatingUsers()
    {
    	if ($this->role == Roles::SUPER_ADMIN) {
    	    return [Roles::SUPER_ADMIN, Roles::ADMIN, Roles::ADVANCED, Roles::REGULAR];
	    } elseif ($this->role == Roles::ADMIN) {
		    return [Roles::ADMIN, Roles::ADVANCED, Roles::REGULAR];
	    }
    	return [];
    }

	public function getCompleteNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    public function hasProfileImage()
    {
        if (Storage::disk('public')->exists('avatar'.'/'.$this->id.'.jpg')) {
            return true;
        } else {
            return false;
        }
    }
}
