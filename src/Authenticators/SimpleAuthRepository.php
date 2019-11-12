<?php

namespace Davidhsianturi\Compass\Authenticators;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\UserResult;
use Davidhsianturi\Compass\Contracts\UsersRepository;

class SimpleAuthRepository implements UsersRepository
{
    use Authenticator;

    /**
     * Return all the users from storage.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\UserResult[]
     */
    public function get()
    {
        $storageKey = $this->storageKey();
        $attributeKey = $this->userAttributeKey();
        $refreshToken = $this->usingHashedToken();

        return $this->newModelQuery()
                    ->get()
                    ->map(function ($user) use ($storageKey, $attributeKey, $refreshToken) {
                        $token = Str::random(60);
                        $attributeKey = $user->$attributeKey ?? 'unknown';

                        if ($refreshToken) {
                            $user->forceFill([$storageKey => hash('sha256', $token)])->save();

                            return new UserResult($token, $attributeKey);
                        }

                        return new UserResult($user->$storageKey, $attributeKey);
                    })->values();
    }

    /**
     * Get the guard hash option value.
     *
     * @return bool
     */
    protected function usingHashedToken()
    {
        $guard = $this->getGuardConfiguration();

        return $guard['hash'] ?? false;
    }

    /**
     * Get the guard storage key value.
     *
     * @return string
     */
    protected function storageKey()
    {
        $guard = $this->getGuardConfiguration();

        return $guard['storage_key'] ?? 'api_token';
    }
}
