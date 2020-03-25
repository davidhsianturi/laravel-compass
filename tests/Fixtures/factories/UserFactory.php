<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Davidhsianturi\Compass\Tests\Fixtures\UserTest as User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
    ];
});

$factory->state(User::class, 'withHash', function () {
    $token = Str::random(80);

    return [
        'api_token' => hash('sha256', $token),
    ];
});

$factory->state(User::class, 'withoutHash', function () {
    return [
        'api_token' => Str::random(80),
    ];
});
