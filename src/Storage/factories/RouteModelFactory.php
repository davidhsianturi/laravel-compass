<?php

use Davidhsianturi\Compass\Storage\RouteModel;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(RouteModel::class, function (Faker\Generator $faker) {
    return [
        'uuid' => $faker->uuid,
        'route_hash' => $faker->md5,
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'content' => [$faker->word => $faker->word],
    ];
});
