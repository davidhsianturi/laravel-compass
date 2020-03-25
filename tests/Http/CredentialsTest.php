<?php

namespace Davidhsianturi\Compass\Tests\Http;

use Davidhsianturi\Compass\Tests\AuthenticatorHelper;
use Davidhsianturi\Compass\Tests\Fixtures\UserTest as User;

class CredentialsTest extends AuthenticatorHelper
{
    public function test_get_valid_credentials_with_token_driver()
    {
        $this->app->get('config')->set('auth.guards.api.hash', true);

        $user = factory(User::class)->state('withHash')->create();
        $response = $this->getJson(route('compass.credentials'));
        $response
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    ['name' => $user->email],
                ],
            ]);

        $this->assertAccessToken($response->original['data']->first()->token, 'api');
    }

    public function test_get_valid_credentials_with_sanctum_driver()
    {
        $this->withoutExceptionHandling();

        $token = $this->factorySanctumUser()->tokens()->latest()->first();
        $response = $this->getJson(route('compass.credentials'));
        $response
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    ['name' => $token->name],
                ],
            ]);

        $this->assertAccessToken($response->original['data']->first()->token, 'sanctum');
    }
}
