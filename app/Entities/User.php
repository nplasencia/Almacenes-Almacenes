<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Commons\UserContract;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        UserContract::NAME, UserContract::SURNAME, UserContract::EMAIL, UserContract::ROLE, UserContract::PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        UserContract::PASSWORD, 'remember_token',
    ];

    public function getCompleteName() {
        return $this->name.' '.$this->surname;
    }

    public function hasProfileImage() {
        if (Storage::disk('public')->exists('avatar'.'/'.$this->id.'.jpg')) {
            return true;
        } else {
            return false;
        }
    }
}
