<?php

use Davidhsianturi\Compass\Storage\RouteModel;

/* @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(RouteModel::class, function (Faker\Generator $faker) {
    return [
        'storage_id' => $faker->uuid,
        'route_id' => $faker->md5,
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'network' => [$faker->word => $faker->word],
    ];
});
