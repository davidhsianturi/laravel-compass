<?php

namespace Davidhsianturi\Compass\Tests\Storage;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseRoutesRepository;

class DatabaseRoutesRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseRoutesRepository('testbench');
    }

    public function test_return_all_the_routes()
    {
        $this->registerAppRoutes();

        $appRoutes = Compass::getAppRoutes();
        $routeInStorage = $this->saveRoute($appRoutes->random());
        $result = $this->repository->get();

        $this->assertNull($appRoutes->random()['uuid']);
        $this->assertTrue($result->contains('storageId', $appRoutes->random()['uuid']));

        $this->assertNotNull($routeInStorage->uuid);
        $this->assertTrue($result->contains('storageId', $routeInStorage->uuid));

        $this->assertSameSize($appRoutes, $result);
    }

    public function test_find_route_by_route_hash()
    {
        $this->registerAppRoutes();

        $appRoute = Compass::getAppRoutes()->random();
        $result = $this->repository->find($appRoute['route_hash'])->jsonSerialize();

        $this->assertSame($appRoute['route_hash'], $result['id']);
        $this->assertSame($appRoute['uuid'], $result['storageId']);

        $routeInStorage = $this->saveRoute($appRoute);
        $result = $this->repository->find($routeInStorage->route_hash)->jsonSerialize();

        $this->assertSame($routeInStorage->route_hash, $result['id']);
        $this->assertSame($routeInStorage->uuid, $result['storageId']);
    }

    protected function saveRoute(array $attribute)
    {
        return factory(RouteModel::class)->create([
            'route_hash' => $attribute['route_hash'],
            'title' => $attribute['uri'],
            'content' => [],
        ]);
    }
}
