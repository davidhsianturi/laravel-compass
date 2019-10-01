<?php

namespace Davidhsianturi\Compass\Tests\Storage;

use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Storage\RouteModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Storage\DatabaseResponseRepository;

class DatabaseResponseRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/../../src/Storage/factories');

        $this->repository = new DatabaseResponseRepository();
    }

    public function test_find_route_response_as_example_by_uuid()
    {
        $examplesInStorage = $this->responseAsExample();

        $result = $this->repository->find($examplesInStorage->uuid);

        $this->assertSame($examplesInStorage->uuid, $result->uuid);
        $this->assertSame($examplesInStorage->route_hash, $result->route_hash);
        $this->assertSame($examplesInStorage->title, $result->title);
        $this->assertSame($examplesInStorage->description, $result->description);
        $this->assertSame($examplesInStorage->content, $result->content);
        $this->assertSame($examplesInStorage->example, $result->example);
    }

    public function test_delete_existing_example_from_storage()
    {
        $example = $this->responseAsExample();

        $this->assertDatabaseHas('compass_routeables', ['uuid' => $example->uuid]);

        $this->repository->delete($example->uuid);

        $this->assertDatabaseMissing('compass_routeables', ['uuid' => $example->uuid]);
    }

    protected function responseAsExample()
    {
        $this->registerAppRoutes();

        $route = Compass::getAppRoutes()->random();

        return factory(RouteModel::class)->create([
            'route_hash' => $route['route_hash'],
            'content' => [
                'data' => 'data',
                'more' => 'more',
            ],
            'example' => true,
        ]);
    }
}
