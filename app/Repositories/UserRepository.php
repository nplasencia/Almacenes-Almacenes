<?php

namespace App\Repositories;

use App\Entities\User;
use Illuminate\Contracts\Auth\Guard;

class UserRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new User();
    }

    public function update(Guard $auth, $name, $surname, $telephone, $email)
    {
        $user = $auth->user();
        $user->name      = $name;
        $user->surname   = $surname;
        $user->telephone = $telephone;
        $user->email     = $email;
        $user->update();
        return $user;
    }
}