<?php

namespace Davidhsianturi\Compass\Authenticators;

trait UserProvider
{
    /**
     * The default Authenticator configuration.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $config;

    /**
     * The auth identifier for user.
     *
     * @var string
     */
    protected $identifier;

    /**
     * Create a new user provider instance.
     *
     * @param  \Illuminate\Support\Collection  $config
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->identifier = $config['identifier'];
    }

    /**
     * Get a user provider instance.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getUsers()
    {
        return $this->createModel()->newQuery()->get();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createModel()
    {
        $class = '\\'.ltrim($this->config['provider']['model'], '\\');

        return new $class;
    }
}
