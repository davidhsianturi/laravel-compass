<?php

namespace Davidhsianturi\Compass\Tests;

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\SanctumServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Davidhsianturi\Compass\Tests\Fixtures\UserTest;

class AuthenticatorHelper extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFactoriesUsing($this->app, __DIR__.'/Fixtures/factories');
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--path' => realpath(__DIR__.'/Fixtures/migrations'),
        ]);
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->get('config')->set('auth.providers.users.model', UserTest::class);
    }

    protected function getPackageProviders($app)
    {
        return array_merge(
            parent::getPackageProviders($app),
            [SanctumServiceProvider::class]
        );
    }

    /**
     * Create user with two access tokens.
     *
     * @return \Davidhsianturi\Compass\Tests\Fixtures\UserTest
     */
    protected function factorySanctumUser()
    {
        $config = $this->app->get('config');
        $config->set('compass.authenticator.guard', 'sanctum');
        $config->set('auth.guards.sanctum.provider', 'users');

        $this->artisan('migrate', ['--database' => 'testbench'])->run();

        return tap(factory(UserTest::class)->create(), function ($user) {
            $user->createToken('secret', ['sec:ret']);
            $user->createToken('compass-tests', ['foo:bar']);
            $user->tokens()->where('name', 'secret')->update(['created_at' => now()->subMinutes(60)]);
        });
    }

    /**
     * Assert that the given access token is valid.
     *
     * @param  string  $token
     * @param  string  $guard
     * @return void
     */
    protected function assertAccessToken(string $token, string $guard)
    {
        Route::get('/foo', function () {
            return 'bar';
        })->middleware('auth:'.$guard);

        $response = $this->get('/foo', ['Authorization' => 'Bearer '.$token]);

        $response->assertStatus(200);
        $response->assertSee('bar');
    }
}
