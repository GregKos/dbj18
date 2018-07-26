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

$factory->define(App\Post::class, function (Faker $faker) {
    $created_at = $faker->dateTimeBetween('-3 years');
    $published = $faker->numberBetween(0,1);
    $published_at = ($published) ? $faker->dateTimeBetween($created_at) : null;
    return [
        'title' => $faker->sentence(),
        'subtitle' => $faker->sentence(15),
        'content' => $faker->paragraph(20),
        'created_at' => $created_at,
        'published' => $published,
        'published_at' => $published_at,
    ];
});