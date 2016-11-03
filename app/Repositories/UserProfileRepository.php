<?php

namespace App\Repositories;

use App\Commons\UserContract;
use App\Entities\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class UserProfileRepository extends BaseRepository
{
    
    public function getEntity()
    {
        return new User();
    }

    public function update(Guard $auth, Request $request)
    {
        $user = $auth->user();
        $user->update([UserContract::NAME => $request->get('name'), UserContract::SURNAME => $request->get('surname'),
                       UserContract::TELEPHONE => $request->get('telephone'), UserContract::EMAIL => $request->get('email'),
                       UserContract::EMAIL_EACH => $request->get('sendEmail'), UserContract::EXPIRED_DAYS => $request->get('notification')]);
        return $user;
    }

}