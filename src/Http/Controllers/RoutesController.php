<?php

namespace Davidhsianturi\Compass\Http\Controllers;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Contracts\RoutesRepository;

class RoutesController
{
    /**
     * The routes repository.
     *
     * @var \Davidhsianturi\Compass\Contracts\RoutesRepository
     */
    protected $routes;

    /**
     * Create a new RoutesController instance.
     *
     * @param  \Davidhsianturi\Compass\Contracts\RoutesRepository  $routes
     * @return void
     */
    public function __construct(RoutesRepository $routes)
    {
        $this->routes = $routes;
    }

    /**
     * List the routes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $collections = $this->routes->get();

        return response()->json([
            'routes' => [
                'list' => $collections,
                'group' => Compass::groupingRoutes($collections),
            ],
        ]);
    }

    /**
     * Get route with the given ID.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            'route' => $this->routes->find($id),
        ]);
    }

    /**
     * Store the route.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        return response()->json([
            'route' => $this->routes->save($this->validateRequest()),
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'id' => 'string|required',
            'storageId' => 'nullable',
            'title' => 'string|required',
            'description' => 'nullable',
            'network' => 'nullable|array',
        ]);
    }
}
