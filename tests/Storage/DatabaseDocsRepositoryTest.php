<?php

namespace Davidhsianturi\Compass\Tests\Storage;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseDocsRepository;

class DatabaseDocsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseDocsRepository();
    }

    public function test_find_route_documentation_by_uuid()
    {
        $docsInStorage = $this->routeDocs();

        $result = $this->repository->find($docsInStorage->uuid);

        $this->assertSame($docsInStorage->uuid, $result->uuid);
        $this->assertSame($docsInStorage->route_hash, $result->route_hash);
        $this->assertSame($docsInStorage->title, $result->title);
        $this->assertSame($docsInStorage->description, $result->description);
        $this->assertSame($docsInStorage->content, $result->content);
        $this->assertSame($docsInStorage->docs, $result->docs);
    }

    public function test_delete_existing_route_documentation_from_storage()
    {
        $docsInStorage = $this->routeDocs();

        $this->assertDatabaseHas('compass_routeables', ['uuid' => $docsInStorage->uuid]);

        $this->repository->delete($docsInStorage->uuid);

        $this->assertDatabaseMissing('compass_routeables', ['uuid' => $docsInStorage->uuid]);
    }

    protected function routeDocs()
    {
        $this->registerAppRoutes();

        $route = Compass::getAppRoutes()->random();

        return factory(RouteModel::class)->create([
            'route_hash' => $route['route_hash'],
            'content' => [
                'request' => 'request',
                'response' => 'response',
            ],
            'docs' => true,
        ]);
    }
}
