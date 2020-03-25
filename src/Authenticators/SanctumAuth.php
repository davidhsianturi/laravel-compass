<?php

namespace Davidhsianturi\Compass\Authenticators;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\Contracts\AuthenticatorRepository;

class SanctumAuth implements AuthenticatorRepository
{
    use UserProvider;

    /**
     * Return a valid credential of users.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\Authenticators\CredentialResult[]
     */
    public function credentials()
    {
        return $this->getUsers()
                    ->reject(function ($user) {
                        return $user->tokens()->get()->isEmpty();
                    })->map(function ($user) {
                        $plainTextToken = Str::random(80);
                        // override the latest access token.
                        $token = tap($user->tokens()->latest()->first(), function ($token) use ($plainTextToken) {
                            $token->update(['token' => hash('sha256', $plainTextToken)]);
                        });

                        return new CredentialResult($token->name, $plainTextToken);
                    })->values();
    }
}
