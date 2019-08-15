<?php

namespace Davidhs\Compass\Contracts;

use Davidhs\Compass\RouteResult;
use Illuminate\Support\Collection;

interface RoutesRepository
{
    /**
     * Return all the routes.
     *
     * @return \Illuminate\Support\Collection|\Davidhs\Compass\RouteResult[]
     */
    public function get();

    /**
     * find the route with the given ID.
     *
     * @param  string  $id
     * @return \Davidhs\Compass\RouteResult
     */
    public function find($id): RouteResult;

    /**
     * Update or insert the given route.
     *
     * @param  array  $route
     * @return mixed
     */
    public function save(array $route);
}
