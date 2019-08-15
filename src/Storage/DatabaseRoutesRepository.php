<?php

namespace Davidhs\Compass\Storage;

use Illuminate\Support\Str;
use Davidhs\Compass\Compass;
use Illuminate\Support\Carbon;
use Davidhs\Compass\RouteResult;
use Illuminate\Support\Facades\DB;
use Davidhs\Compass\Contracts\RoutesRepository;

class DatabaseRoutesRepository implements RoutesRepository
{
    /**
     * The database connection name that should be used.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new database repository.
     *
     * @param  string  $connection
     * @return void
     */
    public function __construct(string $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return all the routes.
     *
     * @return \Illuminate\Support\Collection|Davidhs\Compass\RouteResult[]
     */
    public function get()
    {
        $routes = RouteModel::on($this->connection)->get()->toArray();

        return Compass::syncRoute($routes)->map(function ($route) {
            return $this->routeResult($route);
        });
    }

    /**
     * find the route with the given ID.
     *
     * @param  string  $id
     * @return \Davidhs\Compass\RouteResult
     */
    public function find($id): RouteResult
    {
        $routes = RouteModel::on($this->connection)->whereRouteId($id)->get()->toArray();

        $route = Compass::syncRoute($routes)->where('route_id', $id)->first();

        return $this->routeResult($route);
    }

    /**
     * Update or insert the given route.
     *
     * @param  array  $route
     * @return \Davidhs\Compass\RouteResult
     */
    public function save(array $route)
    {
        $storageId = $route['storageId'] ?? Str::uuid();

        $this->table('compass_routeables')->updateOrInsert(
            ['route_id' => $route['id'], 'storage_id' => $storageId],
            [
                'title' => $route['title'],
                'description' => $route['description'],
                'network' => json_encode($route['network'])
            ]
        );

        return $this->find($route['id']);
    }

    /**
     * The route result.
     *
     * @param  array  $route
     * @return \Davidhs\Compass\RouteResult
     */
    protected function routeResult(array $route)
    {
        return new RouteResult(
            $route['route_id'],
            $route['storage_id'],
            $route['title'],
            $route['description'],
            $route['network'],
            [
                'domain' => $route['domain'],
                'method' => $route['method'],
                'uri' => $route['uri'],
                'name' => $route['name'],
                'action' => $route['action'],
            ],
            Carbon::parse($route['created_at']),
            Carbon::parse($route['updated_at'])
        );
    }

    /**
     * Get a query builder instance for the given table.
     *
     * @param  string  $table
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table($table)
    {
        return DB::connection($this->connection)->table($table);
    }
}
