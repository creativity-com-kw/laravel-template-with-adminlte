<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'description' => $faker->paragraphs(2, true),
        'address' => $faker->paragraphs(1, true),
        'latitude' => 12.12121212,
        'longitude' => 14.2121212,
        'num_seats' => 20,
        'price' => 120,
        'duration' => 90,
        'status' => 1
    ];
});
