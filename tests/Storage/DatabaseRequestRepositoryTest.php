<?php

namespace Davidhsianturi\Compass\Tests\Storage;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseRequestRepository;

class DatabaseRequestRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseRequestRepository('testbench');
    }

    public function test_return_all_the_routes_request()
    {
        $this->registerAppRoutes();

        $appRoutes = Compass::getAppRoutes();
        $request = $this->saveRequest($appRoutes->random());
        $result = $this->repository->get();

        $this->assertNull($appRoutes->random()['uuid']);
        $this->assertTrue($result->contains('storageId', $appRoutes->random()['uuid']));

        $this->assertNotNull($request->uuid);
        $this->assertTrue($result->contains('storageId', $request->uuid));

        $this->assertSameSize($appRoutes, $result);
    }

    public function test_find_request_by_the_route_hash()
    {
        $this->registerAppRoutes();

        $appRoute = Compass::getAppRoutes()->random();
        $result = $this->repository->find($appRoute['route_hash'])->jsonSerialize();

        $this->assertSame($appRoute['route_hash'], $result['id']);
        $this->assertSame($appRoute['uuid'], $result['storageId']);

        $request = $this->saveRequest($appRoute);
        $result = $this->repository->find($request->route_hash)->jsonSerialize();

        $this->assertSame($request->route_hash, $result['id']);
        $this->assertSame($request->uuid, $result['storageId']);
    }

    public function test_grouping_routes_request_with_the_first_word_in_route_uri()
    {
        $this->registerAppRoutes();
        $this->saveRequest(Compass::getAppRoutes()->random());

        config(['compass.routes.base_uri' => 'api/v1']);
        $allRoutes = $this->repository->get();

        $groupedRoutes = Compass::groupingRoutes($allRoutes);
        $expectedResult = $allRoutes->groupBy(function ($route) {
            return strtok(Str::after($route->info['uri'], 'api/v1'), '/');
        })->toArray();

        $this->assertEquals($expectedResult, $groupedRoutes->toArray());
    }

    protected function saveRequest(array $attribute)
    {
        return factory(RouteModel::class)->create([
            'route_hash' => $attribute['route_hash'],
            'title' => $attribute['uri'],
            'content' => [],
        ]);
    }
}
