<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => Str::random(40),
        'original' => $faker->imageUrl(1024, 1024),
        'medium' => $faker->imageUrl(512, 512),
        'placeholder' => $faker->imageUrl(4, 4),
        'small' => $faker->imageUrl(256, 256),
        'thumbnail' => $faker->imageUrl(32, 32),
        'xsmall' => $faker->imageUrl(64, 64),
        'order' => $faker->unique()->randomNumber
    ];
});
