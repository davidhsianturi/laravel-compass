<?php

namespace Davidhsianturi\Compass;

use Illuminate\Support\Manager;
use Davidhsianturi\Compass\Authenticators\TokenAuth;
use Davidhsianturi\Compass\Authenticators\SanctumAuth;

class Authenticator extends Manager
{
    /**
     * Create a Token auth instance.
     *
     * @return \Davidhsianturi\Compass\Authenticators\TokenAuth
     */
    public function createTokenDriver()
    {
        $config = $this->authConfig();

        return new TokenAuth($config);
    }

    /**
     * Create a Sanctum auth instance.
     *
     * @return \Davidhsianturi\Compass\Authenticators\SanctumAuth
     */
    public function createSanctumDriver()
    {
        $config = $this->authConfig();

        return new SanctumAuth($config);
    }

    /**
     * Get the default Authenticator driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $guard = $this->authConfig()->get('guard');

        return $guard['driver'];
    }

    /**
     * Get the default Authenticator configuration.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function authConfig()
    {
        $config = $this->container['config']['compass.authenticator'];
        $guard = $this->container['config']['auth.guards.'.$config['guard']];

        return collect([
            'guard' => $guard,
            'provider' => $this->container['config']['auth.providers.'.$guard['provider']],
            'identifier' => $config['identifier'],
        ]);
    }
}
