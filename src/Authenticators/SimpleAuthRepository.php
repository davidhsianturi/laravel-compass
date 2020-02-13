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
        $storageKey = $this->getStorageKey();
        $attributeKey = $this->getUserAttribute();
        $usingHashedToken = $this->usingHashedToken();

        return $this->newModelQuery()
                    ->get()
                    ->map(function ($user) use ($storageKey, $attributeKey, $usingHashedToken) {
                        $token = Str::random(60);
                        $userAttribute = $user->$attributeKey ?? 'unknown';

                        if ($usingHashedToken) {
                            $user->forceFill([$storageKey => hash('sha256', $token)])->save();

                            return new UserResult($token, $userAttribute);
                        }

                        return new UserResult($user->$storageKey, $userAttribute);
                    })->values();
    }

    protected function usingHashedToken(): bool
    {
        $guard = $this->authenticationGuard();

        return $guard['hash'] ?? false;
    }

    protected function getStorageKey(): string
    {
        $guard = $this->authenticationGuard();

        return $guard['storage_key'] ?? 'api_token';
    }
}
