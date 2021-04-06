<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CoachApplication;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->state(CoachApplication::class, 'pending', [
    'status' => 1
]);

$factory->state(CoachApplication::class, 'rejected', [
    'status' => 3
]);

$factory->define(CoachApplication::class, function (Faker $faker) {
    return [
        'civil_id_number' => $faker->uuid,
        'first_name' => 'Test',
        'middle_name' => '',
        'last_name' => 'Coach',
        'mobile' => 87654321,
        'email' => 'coach@domain.com',
        'gender' => 1,
        'password' => Hash::make('12345678')
    ];
});
