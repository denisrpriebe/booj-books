<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'isbn' => $faker->isbn10,
        'title' => ucwords($faker->words(rand(2, 10), true)),
        'author' => $faker->name,
        'thumbnail' => null,
        'copyright' => $faker->date(),
    ];
});
