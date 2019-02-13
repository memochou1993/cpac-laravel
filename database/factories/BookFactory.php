<?php

use Faker\Generator as Faker;

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'creator' => $faker->name(),
        'description' => $faker->text(),
        'contributor' => $faker->name(),
        'date' => $faker->year($max = 'now'),
        'language' => $faker->languageCode(),
    ];
});
