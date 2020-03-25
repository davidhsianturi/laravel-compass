<?php

namespace Davidhsianturi\Compass\Tests\Compass\Authenticators;

use Davidhsianturi\Compass\Tests\AuthenticatorHelper;

class SanctumAuthTest extends AuthenticatorHelper
{
    public function test_it_can_provide_valid_credentials_from_the_latest_personal_access_tokens()
    {
        $user = $this->factorySanctumUser();

        // Make sure only the latest access token will be provided.
        $this->app->get('compass.authenticator')->credentials()->map(function ($credential) use ($user) {
            $oldest = $user->tokens()->oldest()->first();
            $this->assertNotSame($oldest->name, $credential->name);
            $this->assertNotSame($oldest->token, $credential->token);

            $latest = $user->tokens()->latest()->first();
            $this->assertSame($latest->name, $credential->name);
            $this->assertNotSame($latest->token, $credential->token);

            $this->assertAccessToken($credential->token, 'sanctum');
        });
    }
}
