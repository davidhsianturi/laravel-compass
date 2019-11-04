<?php

namespace Davidhsianturi\Compass\Contracts;

use Illuminate\Routing\Route;

interface RouteResolverContract
{
    /**
     * Retrieve title from the route.
     *
     * @param Route $route
     *
     * @return string
     */
    public function getTitle(Route $route);

    /**
     * Retrieve description from the route.
     *
     * @param Route $route
     *
     * @return string
     */
    public function getDescription(Route $route);
}
