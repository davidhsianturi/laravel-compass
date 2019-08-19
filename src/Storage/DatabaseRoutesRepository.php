<?php

namespace Davidhsianturi\Compass\Storage;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\RouteResult;
use Davidhsianturi\Compass\Contracts\RoutesRepository;

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
     * @return \Illuminate\Support\Collection|Davidhsianturi\Compass\RouteResult[]
     */
    public function get()
    {
        return Compass::syncRoute($this->routesInStorage())->map(function ($route) {
            return $this->routeResult($route, []);
        });
    }

    /**
     * find the route with the given ID.
     *
     * @param  string  $id
     * @return \Davidhsianturi\Compass\RouteResult
     */
    public function find(string $id): RouteResult
    {
        $route = Compass::syncRoute($this->routesInStorage())->whereStrict('route_hash', $id)->first();

        $docs = $this->table('compass_routeables')
            ->where('docs', true)
            ->where('route_hash', $id)
            ->get()
            ->toArray();

        return $this->routeResult($route, $docs);
    }

    /**
     * Update or insert the given route.
     *
     * @param  array  $route
     * @return mixed
     */
    public function save(array $route)
    {
        $storageId = $route['storageId'] ?? Str::uuid();

        $this->table('compass_routeables')->updateOrInsert(
            ['route_hash' => $route['id'], 'uuid' => $storageId],
            [
                'title' => $route['title'],
                'description' => $route['description'],
                'content' => json_encode($route['content']),
            ]
        );

        return $this->find($route['id']);
    }

    /**
     * The route result.
     *
     * @param  array  $route
     * @return \Davidhsianturi\Compass\RouteResult
     */
    protected function routeResult(array $route, ?array $docs)
    {
        return new RouteResult(
            $route['route_hash'],
            $route['uuid'],
            $route['title'],
            $route['description'],
            $route['content'],
            [
                'domain' => $route['domain'],
                'method' => $route['method'],
                'uri' => $route['uri'],
                'name' => $route['name'],
                'action' => $route['action'],
            ],
            Carbon::parse($route['created_at']),
            Carbon::parse($route['updated_at']),
            $docs
        );
    }

    /**
     * Get routes from storage.
     *
     * @return array
     */
    protected function routesInStorage()
    {
        return RouteModel::on($this->connection)
            ->whereDocs(false)
            ->get()
            ->toArray();
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
