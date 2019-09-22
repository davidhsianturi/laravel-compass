<?php

namespace Davidhsianturi\Compass\Tests\Http;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseResponseRepository;

class RoutesResponseTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseResponseRepository();
    }

    public function test_store_route_response_as_example()
    {
        $this->registerAppRoutes();

        $route = Compass::getAppRoutes()->random();

        $exampleData = factory(RouteModel::class)->raw([
            'uuid' => $route['uuid'],
            'route_hash' => $route['route_hash'],
            'example' => true,
        ]);

        $this->postJson(route('compass.response.store'), $exampleData)
            ->assertOk()
            ->assertJson([
                'route_hash' => $exampleData['route_hash'],
                'title' => $exampleData['title'],
                'description' => $exampleData['description'],
                'content' => $exampleData['content'],
                'example' => $exampleData['example'],
            ]);
    }

    public function test_update_existing_route_response_from_storage()
    {
        $response = $this->existingRouteResponse()->toArray();

        $updateAttr = array_merge($response, ['title' => 'Filter Invoices']);

        $this->postJson(route('compass.response.store'), $updateAttr)
            ->assertOk()
            ->assertExactJson($updateAttr);
    }

    public function test_show_route_response()
    {
        $response = $this->existingRouteResponse();

        $this->getJson(route('compass.response.show', $response->uuid))
            ->assertOk()
            ->assertExactJson($response->toArray());
    }

    public function test_delete_route_response_from_storage()
    {
        $response = $this->existingRouteResponse();

        $this->assertDatabaseHas('compass_routeables', ['uuid' => $response->uuid]);

        $this->deleteJson(route('compass.response.destroy', $response->uuid))->assertStatus(204);

        $this->assertDatabaseMissing('compass_routeables', ['uuid' => $response->uuid]);
    }

    protected function existingRouteResponse()
    {
        $this->registerAppRoutes();

        $route = Compass::getAppRoutes()->random();

        return factory(RouteModel::class)->create([
            'route_hash' => $route['route_hash'],
            'example' => true,
        ]);
    }
}
