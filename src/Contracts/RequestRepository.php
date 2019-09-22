<?php

namespace Davidhsianturi\Compass\Contracts;

use Illuminate\Support\Collection;
use Davidhsianturi\Compass\RouteResult;

interface RequestRepository
{
    /**
     * Return all the route requests.
     *
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\RouteResult[]
     */
    public function get();

    /**
     * find the route request with the given ID.
     *
     * @param  string  $id
     * @return \Davidhsianturi\Compass\RouteResult
     */
    public function find(string $id): RouteResult;

    /**
     * Update or insert the given route request.
     *
     * @param  array  $route
     * @return mixed
     */
    public function save(array $route);
}
