<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rating;
use Faker\Generator as Faker;
use App\User;
use App\Offer;

$offersCount = Offer::all()->count();
$usersCount = User::all()->count();

$factory->define(Rating::class, function (Faker $faker) use (&$offersCount, &$usersCount){
    return [
        'offer_id' => rand(1, $offersCount),
        'user_id' => rand(1,$usersCount),
        'rating' => rand(1,5),
    ];
});
