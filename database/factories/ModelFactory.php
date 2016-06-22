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
use App\Commons\CenterContract;
use App\Entities\User;
use App\Entities\Center;

$factory->define(User::class, function () {

    $faker = Faker\Factory::create("es_ES");

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

$factory->define(Center::class, function () {

    $faker = Faker\Factory::create("es_ES");

    return [
        CenterContract::NAME            => $faker->company,
        CenterContract::ADDRESS         => $faker->streetAddress,
        CenterContract::ADDRESS2        => $faker->streetAddress,
        CenterContract::MUNICIPALITY_ID => rand(1, 88),
        CenterContract::POSTALCODE      => $faker->postcode,
    ];
});