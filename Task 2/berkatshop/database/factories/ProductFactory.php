<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(\App\Models\Admin\Product::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->name,
        'price' => $faker->numberBetween(0, 1000000),
        'created_at' => now(),
        'updated_at' => now()
    ];
});
