<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [

        'title' => $faker->name,
        'slug' => $faker->unique()->userName,
        'description' => $faker->text,
        'original' => $faker->imageUrl(2560, 1600),
        'medium' => $faker->imageUrl(1280, 800),
        'placeholder' => $faker->imageUrl(8, 5),
        'small' => $faker->imageUrl(640, 400),
        'thumbnail' => $faker->imageUrl(40, 25),
        'xsmall' => $faker->imageUrl(160, 100),
        'order' => $faker->unique()->randomNumber
    ];
});
