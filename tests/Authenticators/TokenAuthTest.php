<?php

namespace Davidhsianturi\Compass\Tests\Compass\Authenticators;

use Davidhsianturi\Compass\Tests\AuthenticatorHelper;
use Davidhsianturi\Compass\Tests\Fixtures\UserTest as User;

class TokenAuthTest extends AuthenticatorHelper
{
    public function test_it_can_provide_valid_api_token_when_the_hash_is_enabled()
    {
        // enable hash.
        $this->app->get('config')->set('auth.guards.api.hash', true);

        $user = factory(User::class)->state('withHash')->create();
        $credential = $this->app->get('compass.authenticator')->credentials()->first();

        $this->assertSame($user->email, $credential->name);
        $this->assertNotSame($user->api_token, $credential->token);

        $this->assertGuest('api');
        $this->assertAccessToken($credential->token, 'api');
        $this->assertAuthenticated('api');
    }

    public function test_it_can_provide_valid_api_token_when_the_hash_is_disabled()
    {
        // disable hash.
        $this->app->get('config')->set('auth.guards.api.hash', false);

        $user = factory(User::class)->state('withoutHash')->create();
        $credential = $this->app->get('compass.authenticator')->credentials()->first();

        $this->assertSame($user->email, $credential->name);
        $this->assertSame($user->api_token, $credential->token);

        $this->assertGuest('api');
        $this->assertAccessToken($credential->token, 'api');
        $this->assertAuthenticated('api');
    }
}
