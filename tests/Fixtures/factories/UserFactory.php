<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Davidhsianturi\Compass\Tests\Fixtures\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'api_token' => Str::random(60),
    ];
});

$factory->state(User::class, 'hashedToken', function () {
    $token = Str::random(60);

    return [
        'api_token' => hash('sha256', $token),
    ];
});
