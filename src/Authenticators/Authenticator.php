<?php

namespace Davidhsianturi\Compass\Authenticators;

trait Authenticator
{
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
        $provider = $this->getUserProvider();

        $class = '\\'.ltrim($provider['model'], '\\');

        return new $class;
    }

    protected function authenticationGuard(): array
    {
        $name = config('compass.authenticator.guard');

        return config('auth.guards.'.$name);
    }

    protected function getUserProvider(): array
    {
        $guard = $this->authenticationGuard();

        return config('auth.providers.'.$guard['provider']);
    }

    protected function getUserAttribute(): string
    {
        return config('compass.authenticator.user_attribute');
    }
}
