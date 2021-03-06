<?php

namespace App\Entities;

use App\Commons\Roles;
use App\Commons\UserContract;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends AuthUser
{

	use Notifiable;

    protected $fillable = [ UserContract::NAME, UserContract::SURNAME, UserContract::EMAIL, UserContract::ROLE, UserContract::TELEPHONE, UserContract::CENTER_ID,
                            UserContract::EMAIL_EACH, UserContract::EXPIRED_DAYS];

    protected $hidden = [ UserContract::PASSWORD, 'remember_token' ];

	public function center()
	{
		return $this->belongsTo(Center::class);
	}

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

    public function getLastCarbonEmailAttribute()
    {
	    return Carbon::createFromFormat('Y-m-d H:i:s', $this->last_email);
    }

    public function hasProfileImage()
    {
        if (Storage::disk('public')->exists('avatar'.'/'.$this->id.'.jpg')) {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}
}
