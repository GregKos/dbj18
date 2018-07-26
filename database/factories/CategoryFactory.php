<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'title' => ucwords($faker->word(3, true)),
        'slug' => $faker->slug,
        'created_at' => $faker->dateTimeBetween('-3 years'),
    ];
});