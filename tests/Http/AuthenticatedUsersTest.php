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

    public function test_get_the_authenticated_users_that_provided_by_simple_auth()
    {
        config()->set('auth.guards.api.hash', true);

        $users = factory(User::class)->states('hashedToken')->create();
        $response = $this->get(route('compass.users'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(['data' => []])
            ->assertJsonCount($users->count(), 'data');

        $this->confirmUsers($response->getData()->data);
    }

    protected function confirmUsers(array $users)
    {
        foreach ($users as $user) {
            $this
                ->getJson('/authenticate', ['Authorization' => 'Bearer '.$user->token])
                ->assertStatus(Response::HTTP_OK)
                ->assertSeeText('Authenticated!');
        }
    }
}
