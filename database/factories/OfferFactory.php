<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Offer;
use App\Category;
use Faker\Generator as Faker;

$categories = Category::all();

$factory->define(Offer::class, function (Faker $faker) use ($categories) {
    $fromDate = $faker->dateTimeBetween('now', '+2 months');
    $toDate = $faker->dateTimeBetween($fromDate->format('Y-m-d H:i:s'), $fromDate->format('Y-m-d H:i:s').'+7 days');
    $images = [];
    for ($i = 0; $i < 3; $i ++){
        array_push($images, 'seed'.rand(0,7).'.jpg' );
    }
    $price = $faker->randomFloat(2,20,5000);
    $discount = round(($price / 100) * rand(5,50), 2);
    return [
        'name' => $faker->text(25),
        'leave_at' => $fromDate,
        'arrive_at' => $toDate,
        'hidden' => 0,
        'category_id' => $categories[rand(0, count($categories) - 1)]->id,
        'price' => $price,
        'images' => json_encode($images),
        'discount' => $discount,
        'country' => $faker->country,
        'city' => $faker->city,
        'description' => $faker->text(500),
    ];
});
