<?php

namespace Davidhsianturi\Compass\Contracts;

interface AuthenticatorRepository
{
    /**
     * Return a new credential of users.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\Authenticators\CredentialResult[]
     */
    public function credentials();
}
