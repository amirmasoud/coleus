<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Block::class, function (Faker $faker) {
    return [
        'content' => $faker->text,
        'order' => $faker->unique()->randomNumber,
        'status' => 'published',
        'type' => 'm-1/2'
    ];
});
