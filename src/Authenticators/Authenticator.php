<?php

namespace Davidhsianturi\Compass\Authenticators;

trait Authenticator
{
    /**
     * Get the guard configuration.
     *
     * @return array
     */
    protected function getGuardConfiguration()
    {
        $name = config('compass.authenticator.guard');

        return config('auth.guards.'.$name);
    }

    /**
     * Get a new query builder for the model instance.
     *
     * @param  \Illuminate\Database\Eloquent\Model|null  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newModelQuery($model = null)
    {
        return is_null($model)
                ? $this->createModel()->newQuery()
                : $model->newQuery();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function createModel()
    {
        $provider = $this->getGuardProvider();

        $class = '\\'.ltrim($provider['model'], '\\');

        return new $class;
    }

    /**
     * Get the guard provider configuration.
     *
     * @return array
     */
    protected function getGuardProvider()
    {
        $guard = $this->getGuardConfiguration();

        return config('auth.providers.'.$guard['provider']);
    }

    /**
     * Get the user attribute key.
     *
     * @return string
     */
    protected function userAttributeKey()
    {
        return config('compass.authenticator.user_attribute_key');
    }
}
