<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Commons\UserContract;
use App\Entities\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        UserContract::NAME      => $faker->firstName,
        UserContract::SURNAME   => $faker->lastName,
        UserContract::EMAIL     => $faker->safeEmail,
        UserContract::TELEPHONE => $faker->phoneNumber,
        UserContract::ROLE      => array_rand(['Admin', 'AdvUser', 'User']),
        UserContract::PASSWORD  => bcrypt(str_random(10)),
        'remember_token'        => str_random(10),
    ];
});
