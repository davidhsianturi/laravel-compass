<?php

namespace Davidhsianturi\Compass;

use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route as RouteFacade;

class Compass
{
    /**
     * Indicates if Compass migrations will be run.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Get the application routes.
     *
     * @return Illuminate\Support\Collection
     */
    public static function getAppRoutes()
    {
        return collect(RouteFacade::getRoutes())->map(function ($route) {
            return static::getRouteInformation($route);
        })->filter();
    }

    /**
     * Get the route information for a given route.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @return array
     */
    protected static function getRouteInformation(Route $route)
    {
        $methods = array_diff($route->methods(), ['HEAD']);

        return static::filterRoute([
            "storage_id" => null,
            "title" => $route->uri(),
            "description" => null,
            "network" => [],
            'route_id' => md5($route->uri().':'.implode($methods)),
            'domain' => $route->domain(),
            'method' => implode($methods),
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => ltrim($route->getActionName(), '\\'),
            "created_at" => null,
            "updated_at" => null,
        ]);
    }

    /**
     * Filter the route by the config rules.
     *
     * @param  array  $route
     * @return array|null
     */
    protected static function filterRoute(array $route)
    {
        $routeRule = config('compass.routes');

        if ((Str::is($routeRule['exclude'], $route['name'])) ||
             ! Str::is($routeRule['domains'], $route['domain']) ||
             ! Str::is($routeRule['prefixes'], $route['uri'])) {
            return;
        }

        return $route;
    }

    /**
     * Sync route from storage with app routes.
     *
     * @param  array  $storage
     * @return Illuminate\Support\Collection
     */
    public static function syncRoute(array $storage)
    {
        return static::getAppRoutes()->map(function ($appRoute) use ($storage) {
            $route = collect($storage)->where('route_id', $appRoute['route_id'])->collapse()->toArray();

            return array_merge($appRoute, $route);
        })->values();
    }

    /**
     * Group the routes with the first word in route URI.
     *
     * @param  Illuminate\Support\Collection|\Davidhsianturi\Compass\RouteResult[]  $routes
     * @return Illuminate\Support\Collection|\Davidhsianturi\Compass\RouteResult[]
     */
    public static function groupingRoutes(Collection $routes)
    {
        return $routes->groupBy(function ($item) {
            return strtok($item->info['uri'], '/');
        });
    }

    /**
     * Get the default JavaScript variables for Compass.
     *
     * @return array
     */
    public static function scriptVariables()
    {
        return [
            'path' => config('compass.path'),
        ];
    }
}
