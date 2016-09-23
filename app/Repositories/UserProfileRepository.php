<?php

namespace App\Repositories;

use App\Commons\Roles;
use App\Commons\UserContract;
use App\Entities\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class UserProfileRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new User();
    }

    public function update(Guard $auth, $name, $surname, $telephone, $email)
    {
        $user = $auth->user();
        $user->update([UserContract::NAME => $name, UserContract::SURNAME => $surname, UserContract::TELEPHONE => $telephone, UserContract::EMAIL => $email]);
        return $user;
    }

}