<?php

namespace Davidhsianturi\Compass\Tests\Compass;

use Illuminate\Support\Str;
use Davidhsianturi\Compass\Compass;
use Davidhsianturi\Compass\Tests\TestCase;

class RoutesConfigTest extends TestCase
{
    public function test_register_app_routes()
    {
        $this->registerAppRoutes();

        $this->assertCount(12, Compass::getAppRoutes());
    }

    public function test_filter_app_routes_from_domains_rule()
    {
        $this->registerAppRoutes();

        config(['compass.routes.domains' => ['domain1.*', 'domain2.*']]);
        $this->assertCount(12, Compass::getAppRoutes());

        config(['compass.routes.domains' => ['domain1.*']]);
        $this->assertCount(6, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertStringContainsString('domain1', $route['domain']);
            $this->assertStringNotContainsString('domain2', $route['domain']);
        }

        config(['compass.routes.domains' => ['domain2.*']]);
        $this->assertCount(6, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertStringContainsString('domain2', $route['domain']);
            $this->assertStringNotContainsString('domain1', $route['domain']);
        }
    }

    public function test_filter_app_routes_from_prefixes_rule()
    {
        $this->registerAppRoutes();

        config(['compass.routes.prefixes' => ['api/v1/prefix1/*', 'api/v1/prefix2/*']]);
        $this->assertCount(8, Compass::getAppRoutes());

        config(['compass.routes.prefixes' => ['api/v1/prefix1/*']]);
        $this->assertCount(4, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertTrue(Str::is('api/v1/prefix1/*', $route['uri']));
            $this->assertFalse(Str::is('api/v1/prefix2/*', $route['uri']));
        }

        config(['compass.routes.prefixes' => ['api/v1/prefix2/*']]);
        $this->assertCount(4, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertTrue(Str::is('api/v1/prefix2/*', $route['uri']));
            $this->assertFalse(Str::is('api/v1/prefix1/*', $route['uri']));
        }
    }

    public function test_exclude_app_routes_with_the_route_name()
    {
        $this->registerAppRoutes();

        config(['compass.routes.exclude' => ['*']]);
        $this->assertCount(0, Compass::getAppRoutes());

        config(['compass.routes.exclude' => ['compass.*', 'prefix1.*']]);
        $this->assertCount(8, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertFalse(Str::is('compass.*', $route['name']));
            $this->assertStringNotContainsString('prefix.*', $route['name']);
        }

        config(['compass.routes.exclude' => ['compass.*', 'prefix1.domain1-1']]);
        $this->assertCount(11, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertFalse(Str::is('compass.*', $route['name']));
            $this->assertFalse(Str::is('prefix.domain1-1', $route['name']));
        }
    }

    public function test_exclude_app_routes_with_the_route_uri()
    {
        $this->registerAppRoutes();

        config(['compass.routes.exclude' => ['compass*', 'api/v1*']]);
        $this->assertCount(0, Compass::getAppRoutes());

        config(['compass.routes.exclude' => ['compass*', 'api/v1/prefix2/*']]);
        $this->assertCount(8, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertFalse(Str::is('compass*', $route['uri']));
            $this->assertFalse(Str::is('api/v1/prefix2/*', $route['uri']));
        }

        config(['compass.routes.exclude' => ['compass*', 'api/v1/prefix2/domain2-2']]);
        $this->assertCount(11, $routes = Compass::getAppRoutes());
        foreach ($routes as $route) {
            $this->assertFalse(Str::is('compass*', $route['uri']));
            $this->assertFalse(Str::is('api/v1/prefix2/domain2-2', $route['uri']));
        }
    }

    public function test_grouping_app_routes_with_the_first_word_in_route_uri()
    {
        $this->registerAppRoutes();

        config(['compass.routes.base_uri' => 'api/v1']);

        $appRoutes = Compass::getAppRoutes();
        $groupedRoutes = Compass::groupingRoutes($appRoutes);
        $expectedResult = $appRoutes->groupBy(function ($route) {
            return strtok(Str::after($route['uri'], 'api/v1'), '/');
        })->toArray();

        $this->assertEquals($expectedResult, $groupedRoutes->toArray());
    }
}
