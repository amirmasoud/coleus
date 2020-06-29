<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Page::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'order' => $faker->unique()->randomNumber,
        'status' => 'published'
    ];
});
