<?php

namespace Davidhsianturi\Compass\Tests\Http;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseRequestRepository;

class RoutesRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseRequestRepository('testbench');
    }

    public function test_get_all_routes_request()
    {
        $this->registerAppRoutes();

        $routes = $this->repository->get();
        $totalList = $routes->count();
        $totalGroup = Compass::groupingRoutes($routes)->count();

        $this->getJson(route('compass.request'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'list' => [],
                    'group' => [],
                ],
            ])
            ->assertJsonCount($totalList, 'data.list')
            ->assertJsonCount($totalGroup, 'data.group');
    }

    public function test_show_route_request_by_id()
    {
        $this->registerAppRoutes();

        $route = $this->repository->get()->random()->jsonSerialize();

        $this->getJson(route('compass.request.show', $route['id']))
            ->assertSuccessful()
            ->assertExactJson($route);
    }

    public function test_store_the_route_request_to_storage()
    {
        $this->registerAppRoutes();

        $appRoute = Compass::getAppRoutes()->random();
        $response = $this->postJson(route('compass.request.store'), [
            'id' => $appRoute['route_hash'],
            'storageId' => null,
            'title' => $appRoute['title'],
            'description' => $appRoute['description'],
            'content' => $appRoute['content'],
        ]);

        $response->assertSuccessful()
            ->assertJson([
                'id' => $appRoute['route_hash'],
                'title' => $appRoute['title'],
                'content' => $appRoute['content'],
            ]);

        $this->assertNotNull($response->json(['storageId']));
    }

    public function test_update_existing_route_request_from_storage()
    {
        $route = $this->repository->find($this->routeFactory()->route_hash)->jsonSerialize();

        $updateAttribute = array_merge($route, ['title' => 'List All Invoices']);

        $this->postJson(route('compass.request.store'), $updateAttribute)
            ->assertSuccessful()
            ->assertJson([
                'id' => $updateAttribute['id'],
                'storageId' => $updateAttribute['storageId'],
                'title' => 'List All Invoices',
                'content' => $updateAttribute['content'],
            ]);
    }

    protected function routeFactory()
    {
        $this->registerAppRoutes();

        $route = $this->repository->get()->random()->jsonSerialize();

        return factory(RouteModel::class)->create([
            'route_hash' => $route['id'],
            'title' => $route['title'],
            'content' => [],
        ]);
    }
}
