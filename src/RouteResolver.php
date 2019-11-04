<?php

namespace Davidhsianturi\Compass;

use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Davidhsianturi\Compass\Contracts\RouteResolverContract;

class RouteResolver implements RouteResolverContract
{
    /**
     * Retrieve title from the route.
     *
     * @param Route $route
     *
     * @return string
     */
    public function getTitle(Route $route)
    {
        $baseUri = config('compass.routes.base_uri');

        return Str::after($route->uri(), $baseUri);
    }

    /**
     * Retrieve description from the route.
     *
     * @param Route $route
     *
     * @return string
     */
    public function getDescription(Route $route)
    {
        return '';
    }
}
