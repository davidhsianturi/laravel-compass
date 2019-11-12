<?php

namespace Davidhsianturi\Compass\Authenticators;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\UserResult;
use Davidhsianturi\Compass\Contracts\UsersRepository;

class TokenAuthRepository implements UsersRepository
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

        if ($this->usingHashedToken()) {
            return $this->refreshTokens($storageKey);
        }

        return $this->getUsers()->map(function ($user) use ($storageKey) {
            return new UserResult($user->$storageKey);
        })->values();
    }

    /**
     * Refresh the tokens by given a storage key.
     *
     * @param  string  $storageKey
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\UserResult[]
     */
    protected function refreshTokens(string $storageKey)
    {
        return $this->getUsers()->map(function ($user) use ($storageKey) {
            $token = Str::random(60);

            $user->forceFill([$storageKey => hash('sha256', $token)])->save();

            return new UserResult($token);
        })->values();
    }

    /**
     * Get all the users for the model instance.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getUsers()
    {
        return $this->createModel()
            ->newQuery()
            ->get();
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
