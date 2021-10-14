<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Tests\Fixtures\EfficientUuidPost;

$factory->define(EfficientUuidPost::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
    ];
});
