<?php

namespace Davidhsianturi\Compass\Contracts;

use Davidhsianturi\Compass\RouteResult;
use Illuminate\Support\Collection;

interface RoutesRepository
{
    /**
     * Return all the routes.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\RouteResult[]
     */
    public function get();

    /**
     * find the route with the given ID.
     *
     * @param  string  $id
     * @return \Davidhsianturi\Compass\RouteResult
     */
    public function find(string $id): RouteResult;

    /**
     * Update or insert the given route.
     *
     * @param  array  $route
     * @return mixed
     */
    public function save(array $route);
}
