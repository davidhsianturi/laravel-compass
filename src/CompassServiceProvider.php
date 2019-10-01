<?php

namespace Davidhsianturi\Compass;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Davidhsianturi\Compass\Contracts\ApiDocsRepository;
use Davidhsianturi\Compass\Contracts\RequestRepository;
use Davidhsianturi\Compass\Contracts\ResponseRepository;
use Davidhsianturi\Compass\Storage\DatabaseRequestRepository;
use Davidhsianturi\Compass\Storage\DatabaseResponseRepository;

class CompassServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerPublishing();

        $this->loadViewsFrom(
            __DIR__.'/../resources/views', 'compass'
        );
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes()
    {
        Route::namespace('Davidhsianturi\Compass\Http\Controllers')
            ->as('compass.')
            ->prefix(config('compass.path'))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__.'/Http/routes.php');
            });
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'/Storage/migrations');
        }
    }

    /**
     * Determine if we should register the migrations.
     *
     * @return void
     */
    protected function shouldMigrate()
    {
        return Compass::$runsMigrations && config('compass.driver') === 'database';
    }

    /**
     * Register the package's publishable resources.
     *
     * @return void
     */
    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/Storage/migrations' => database_path('migrations'),
            ], 'compass-migrations');

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/compass'),
            ], 'compass-assets');

            $this->publishes([
                __DIR__.'/../resources/views/documentarian' => resource_path('views/vendor/compass'),
            ], 'compass-views');

            $this->publishes([
                __DIR__.'/../config/compass.php' => config_path('compass.php'),
            ], 'compass-config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/compass.php', 'compass'
        );

        $this->registerStorageDriver();
        $this->registerTemplateBuilder();

        $this->commands([
            Console\InstallCommand::class,
            Console\PublishCommand::class,
            Console\BuildCommand::class,
            Console\RebuildCommand::class,
        ]);
    }

    /**
     * Register the package storage driver.
     *
     * @return void
     */
    protected function registerStorageDriver()
    {
        $driver = config('compass.driver');

        if (method_exists($this, $method = 'register'.ucfirst($driver).'Driver')) {
            return $this->$method();
        }
    }

    /**
     * Register the package database storage driver.
     *
     * @return void
     */
    protected function registerDatabaseDriver()
    {
        $this->app->singleton(
            RequestRepository::class, DatabaseRequestRepository::class
        );

        $this->app->singleton(
            ResponseRepository::class, DatabaseResponseRepository::class
        );

        $this->app->when(DatabaseRequestRepository::class)
            ->needs('$connection')
            ->give(config('compass.storage.database.connection'));
    }

    /**
     * Register the package template builder.
     *
     * @return void
     */
    protected function registerTemplateBuilder()
    {
        $builder = config('compass.builder');

        if (method_exists($this, $method = 'register'.ucfirst($builder).'Builder')) {
            return $this->$method();
        }
    }

    /**
     * Register the package slate builder.
     *
     * @return void
     */
    protected function registerSlateBuilder()
    {
        $this->app->singleton(
            ApiDocsRepository::class, SlateBuilder::class
        );
    }
}
