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

        $this->assertNull($appRoutes->random()['storage_id']);
        $this->assertTrue($result->contains('storageId', $appRoutes->random()['storage_id']));

        $this->assertNotNull($routeInStorage->storage_id);
        $this->assertTrue($result->contains('storageId', $routeInStorage->storage_id));

        $this->assertSameSize($appRoutes, $result);
    }

    public function test_find_route_by_route_id()
    {
        $this->registerAppRoutes();

        $appRoute = Compass::getAppRoutes()->random();
        $result = $this->repository->find($appRoute['route_id'])->jsonSerialize();

        $this->assertSame($appRoute['route_id'], $result['id']);
        $this->assertSame($appRoute['storage_id'], $result['storageId']);

        $routeInStorage = $this->saveRoute($appRoute);
        $result = $this->repository->find($routeInStorage->route_id)->jsonSerialize();

        $this->assertSame($routeInStorage->route_id, $result['id']);
        $this->assertSame($routeInStorage->storage_id, $result['storageId']);
    }

    protected function saveRoute(array $attribute)
    {
        return factory(RouteModel::class)->create([
            'route_id' => md5($attribute['uri'].':'.$attribute['method']),
            'title' => $attribute['uri'],
            'network' => [],
        ]);
    }
}
