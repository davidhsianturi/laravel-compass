<?php

namespace Davidhsianturi\Compass\Authenticators;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\Contracts\AuthenticatorRepository;

class TokenAuth implements AuthenticatorRepository
{
    use UserProvider;

    /**
     * Return a valid credential of users.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\Authenticators\CredentialResult[]
     */
    public function credentials()
    {
        $identifier = $this->identifier;
        $hash = $this->config['guard']['hash'] ?? false;

        if ($hash) {
            return $this->overrideTokens($identifier);
        }

        return $this->retrieveTokens($identifier);
    }

    /**
     * Get all the API tokens from storage.
     *
     * @param  string  $identifier
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\Authenticators\CredentialResult[]
     */
    protected function retrieveTokens(string $identifier)
    {
        $storageKey = $this->getStorageKey();

        return $this->getUsers()
                    ->map(function ($user) use ($storageKey, $identifier) {
                        $identifier = $user->$identifier ?? 'anonymous';

                        return new CredentialResult($identifier, $user->$storageKey);
                    })->values();
    }

    /**
     * Override all the API tokens from storage.
     *
     * @param  string  $identifier
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\Authenticators\CredentialResult[]
     */
    protected function overrideTokens(string $identifier)
    {
        $token = $this->getStorageKey();

        return $this->getUsers()
                    ->map(function ($user) use ($token, $identifier) {
                        $identifier = $user->$identifier ?? 'anonymous';

                        $user->forceFill([
                            $token => hash('sha256', $plainTextToken = Str::random(80)),
                        ])->save();

                        return new CredentialResult($identifier, $plainTextToken);
                    })->values();
    }

    /**
     * Get the storage key of the API token.
     *
     * @return string
     */
    protected function getStorageKey()
    {
        return $this->config['guard']['storage_key'] ?? 'api_token';
    }
}
