<?php

namespace Davidhsianturi\Compass\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Davidhsianturi\Compass\CompassServiceProvider;
use Illuminate\Support\Facades\Route as RouteFacade;
use Davidhsianturi\Compass\Storage\DatabaseRoutesRepository;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            CompassServiceProvider::class,
        ];
    }

    protected function resolveApplicationCore($app)
    {
        parent::resolveApplicationCore($app);

        $app->detectEnvironment(function () {
            return 'self-testing';
        });
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = $app->get('config');

        $config->set('logging.default', 'errorlog');
        $config->set('database.default', 'testbench');
        $config->set('compass.storage.database.connection', 'testbench');
        $config->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app->when(DatabaseRoutesRepository::class)
            ->needs('$connection')
            ->give('testbench');
    }

    protected function registerAppRoutes()
    {
        RouteFacade::group(['domain' => 'domain1.tld.test'], function () {
            RouteFacade::post('/domain1-1', function () { return 'domain1'; })->name('domain1-1');
            RouteFacade::get('domain1-2', function () { return 'domain1'; })->name('domain1-2');
            RouteFacade::get('/prefix1/domain1-1', function () { return 'domain1'; })->name('prefix1.domain1-1');
            RouteFacade::get('prefix1/domain1-2', function () { return 'domain1'; })->name('prefix1.domain1-2');
            RouteFacade::get('/prefix2/domain1-1', function () { return 'domain1'; })->name('prefix2.domain1-1');
            RouteFacade::get('prefix2/domain1-2', function () { return 'domain1'; })->name('prefix2.domain1-2');
        });

        RouteFacade::group(['domain' => 'domain2.tld.test'], function () {
            RouteFacade::post('/domain2-1', function () { return 'domain2'; })->name('domain2-1');
            RouteFacade::get('domain2-2', function () { return 'domain2'; })->name('domain2-2');
            RouteFacade::get('/prefix1/domain2-1', function () { return 'domain2'; })->name('prefix1.domain2-1');
            RouteFacade::get('prefix1/domain2-2', function () { return 'domain2'; })->name('prefix1.domain2-2');
            RouteFacade::get('/prefix2/domain2-1', function () { return 'domain2'; })->name('prefix2.domain2-1');
            RouteFacade::get('prefix2/domain2-2', function () { return 'domain2'; })->name('prefix2.domain2-2');
        });
    }
}
