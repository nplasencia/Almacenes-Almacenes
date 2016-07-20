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

use App\Entities\Center;
use App\Entities\Pallet;
use App\Entities\PalletArticle;
use App\Entities\Store;
use App\Entities\User;

use App\Commons\CenterContract;
use App\Commons\PalletContract;
use App\Commons\PalletArticleContract;
use App\Commons\StoreContract;
use App\Commons\UserContract;

$factory->define(User::class, function () {

    $faker = Faker\Factory::create("es_ES");

    return [
        UserContract::NAME      => $faker->firstName,
        UserContract::SURNAME   => $faker->lastName,
        UserContract::EMAIL     => $faker->unique()->safeEmail,
        UserContract::TELEPHONE => $faker->phoneNumber,
        UserContract::ROLE      => array_rand(['Admin', 'AdvUser', 'User']),
        UserContract::PASSWORD  => bcrypt(str_random(10)),
        'remember_token'        => str_random(10),
        UserContract::CENTER_ID => random_int(1, 100),
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

$factory->define(Store::class, function () {

    $faker = Faker\Factory::create("es_ES");

    return [
        StoreContract::NAME      => $faker->unique()->streetName,
        StoreContract::CENTER_ID => random_int(1, 100),
        StoreContract::ROWS      => random_int(1, 10),
        StoreContract::COLUMNS   => random_int(1, 10),
        StoreContract::LONGITUDE => random_int(1, 5),
    ];
});

$factory->define(Pallet::class, function (Faker\Generator $faker) {

    return [
        PalletContract::STORE_ID       => random_int(1, 100),
	    PalletContract::PALLET_TYPE_ID => random_int(1, 2),
        PalletContract::LOCATION       => $faker->numerify('##-##'),
	    PalletContract::POSITION       => random_int(1, 5),
    ];
});

$factory->define(PalletArticle::class, function (Faker\Generator $faker) {

	return [
		PalletArticleContract::PALLET_ID  => random_int(1, 100),
		PalletArticleContract::ARTICLE_ID => random_int(1, 476),
		PalletArticleContract::LOT        => 'L'.random_int(1000, 9999),
		PalletArticleContract::NUMBER     => random_int(1,100),
		PalletArticleContract::WEIGHT     => $faker->randomFloat(2,0,10),
		PalletArticleContract::EXPIRATION => $faker->dateTimeBetween('+0 days', '+2 years'),
	];
});
