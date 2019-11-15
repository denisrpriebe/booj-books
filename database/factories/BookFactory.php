<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\User;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'olid' => $faker->isbn10,
        'title' => $faker->sentence,
        'author' => $faker->name,
        'description' => $faker->paragraph,
        'image' => 'http://booj-books.test/storage/images/booj-logo.png',
        'published' => $faker->year,
    ];
});
