<?php

namespace Davidhsianturi\Compass\Tests\Http;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseDocsRepository;

class RoutesDocumentationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseDocsRepository();
    }

    public function test_store_route_documentation()
    {
        $this->registerAppRoutes();

        $route = Compass::getAppRoutes()->random();

        $docsAttr = factory(RouteModel::class)->raw([
            'uuid' => $route['uuid'],
            'route_hash' => $route['route_hash'],
        ]);

        $this->postJson(route('compass.docs.store'), $docsAttr)
            ->assertOk()
            ->assertJsonStructure(['docs' => []])
            ->assertJson([
                'docs' => [
                    'route_hash' => $docsAttr['route_hash'],
                    'title' => $docsAttr['title'],
                    'description' => $docsAttr['description'],
                    'content' => $docsAttr['content'],
                ],
            ]);
    }

    public function test_update_existing_route_documentation_from_storage()
    {
        $documentation = $this->existingRouteDocs()->toArray();

        $updateAttr = array_merge($documentation, ['title' => 'Filter Invoices']);

        $this->postJson(route('compass.docs.store'), $updateAttr)
            ->assertOk()
            ->assertExactJson($updateAttr);
    }

    public function test_show_route_documentation()
    {
        $documentation = $this->existingRouteDocs();

        $this->getJson(route('compass.docs.show', $documentation->uuid))
            ->assertOk()
            ->assertExactJson($documentation->toArray());
    }

    public function test_delete_route_documentation_from_storage()
    {
        $documentation = $this->existingRouteDocs();

        $this->assertDatabaseHas('compass_routeables', ['uuid' => $documentation->uuid]);

        $this->deleteJson(route('compass.docs.destroy', $documentation->uuid))->assertStatus(204);

        $this->assertDatabaseMissing('compass_routeables', ['uuid' => $documentation->uuid]);
    }

    protected function existingRouteDocs()
    {
        $this->registerAppRoutes();

        $route = Compass::getAppRoutes()->random();

        return factory(RouteModel::class)->create([
            'route_hash' => $route['route_hash'],
            'docs' => true,
        ]);
    }
}
