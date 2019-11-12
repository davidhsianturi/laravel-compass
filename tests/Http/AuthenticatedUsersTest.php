<?php

namespace Davidhsianturi\Compass\Tests\Http;

use Illuminate\Http\Response;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Tests\Fixtures\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route as RouteFacade;

class AuthenticatedUsersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/../Fixtures/factories');
        $this->loadMigrationsFrom([
            '--database' => 'testbench',
            '--path' => realpath(__DIR__.'/../Fixtures/migrations'),
        ]);

        RouteFacade::get('/authenticate', function () {
            return 'Authenticated!';
        })->middleware('auth:api');
    }

    public function test_get_authenticated_users_provided_by_the_simple_authenticator()
    {
        // Config by default.
        config()->set('auth.guards.api.driver', 'token');
        config()->set('compass.authenticator.guard', 'api');

        $users = factory(User::class, 3)->states('hashedToken')->create();
        $response = $this->get(route('compass.users'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => []])
            ->assertJsonCount($users->count(), 'data');

        $this->validateTokens($response->getData()->data);
    }

    protected function validateTokens(array $users)
    {
        foreach ($users as $user) {
            $this
                ->getJson('/authenticate', ['Authorization' => 'Bearer '.$user->apiKey])
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeText('Authenticated!');
        }
    }
}
