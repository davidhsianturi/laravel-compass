<?php

namespace Davidhsianturi\Compass;

use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route as RouteFacade;

final class Compass
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
     * @return \Illuminate\Support\Collection
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
        $methods = array_values(array_diff($route->methods(), ['HEAD']));
        $baseUri = config('compass.routes.base_uri');

        return static::filterRoute([
            'uuid' => null,
            'title' => Str::after($route->uri(), $baseUri),
            'description' => null,
            'content' => [],
            'example' => false,
            'route_hash' => md5($route->uri().':'.implode($methods)),
            'domain' => $route->domain(),
            'methods' => $methods,
            'uri' => $route->uri(),
            'name' => $route->getName(),
            'action' => ltrim($route->getActionName(), '\\'),
            'created_at' => null,
            'updated_at' => null,
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
        $routeRules = config('compass.routes');

        if ((Str::is($routeRules['exclude'], $route['name'])) ||
             Str::is($routeRules['exclude'], $route['uri']) ||
             ! Str::is($routeRules['domains'], $route['domain']) ||
             ! Str::is($routeRules['prefixes'], $route['uri'])) {
            return;
        }

        return $route;
    }

    /**
     * Sync route from storage with app routes.
     *
     * @param  array  $routeInStorage
     * @return \Illuminate\Support\Collection
     */
    public static function syncRoute(array $routeInStorage)
    {
        return static::getAppRoutes()->map(function ($appRoute) use ($routeInStorage) {
            $route = collect($routeInStorage)
                ->where('route_hash', $appRoute['route_hash'])
                ->collapse()
                ->toArray();

            return array_merge($appRoute, $route);
        })->values();
    }

    /**
     * Group the routes with a base URI.
     *
     * @param  \Illuminate\Support\Collection|\Davidhsianturi\Compass\RouteResult[]  $routes
     * @return \Illuminate\Support\Collection|\Davidhsianturi\Compass\RouteResult[]
     */
    public static function groupingRoutes(Collection $routes)
    {
        $baseUri = config('compass.routes.base_uri');

        return $routes->groupBy(function ($route) use ($baseUri) {
            if (is_object($route)) {
                return strtok(Str::after($route->info['uri'], $baseUri), '/');
            }

            return strtok(Str::after($route['uri'], $baseUri), '/');
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
            'app' => [
                'name' => config('app.name'),
                'base_url' => config('app.url'),
                'env' => App::environment(),
            ],
            'authenticator' => config('compass.authenticator.enabled'),
        ];
    }

    /**
     * Configure Compass to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations()
    {
        static::$runsMigrations = false;

        return new static;
    }

    /**
     * Check if assets are up-to-date.
     *
     * src: https://github.com/laravel/telescope/pull/729
     *
     * @return bool
     *
     * @throws \RuntimeException
     */
    public static function assetsAreCurrent()
    {
        $publishedPath = public_path('vendor/compass/mix-manifest.json');

        if (! File::exists($publishedPath)) {
            throw new RuntimeException('The Compass assets are not published. Please run: php artisan compass:publish');
        }

        return File::get($publishedPath) === File::get(__DIR__.'/../public/mix-manifest.json');
    }
}
