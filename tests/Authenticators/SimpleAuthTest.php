<?php

namespace Davidhsianturi\Compass\Tests\Authenticators;

use Illuminate\Http\Response;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Tests\Fixtures\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route as RouteFacade;
use Davidhsianturi\Compass\Authenticators\SimpleAuthRepository;

class SimpleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected $repository;

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

        $this->repository = new SimpleAuthRepository();
    }

    public function test_get_all_registered_users_from_storage()
    {
        tap(factory(User::class, 3)->create(), function ($users) {
            $this->assertSame($users->count(), $this->repository->get()->count());
        });
    }

    public function test_get_an_authenticated_user_when_using_the_plain_text_token()
    {
        // Hash option is false.
        config()->set('auth.guards.api.hash', false);

        $attributeKey = config('compass.authenticator.user_attribute');
        $user = factory(User::class)->create();
        $result = $this->repository->get()->first();

        $this->assertEquals($user->api_token, $result->token);
        $this->assertFalse(auth('api')->check());
        $this->confirmUser($result->token);
        $this->assertTrue(auth('api')->check());
        $this->assertEquals($user->$attributeKey, $result->userAttribute);
    }

    public function test_get_an_authenticated_user_when_using_the_hashed_token()
    {
        // Hash option is true.
        config()->set('auth.guards.api.hash', true);
        config()->set('compass.authenticator.user_attribute', 'id');

        $attributeKey = config('compass.authenticator.user_attribute');
        $user = factory(User::class)->states('hashedToken')->create();
        $result = $this->repository->get()->first();

        $this->assertNotEquals($user->api_token, $result->token);
        $this->assertFalse(auth('api')->check());
        $this->confirmUser($result->token);
        $this->assertTrue(auth('api')->check());
        $this->assertEquals($user->$attributeKey, $result->userAttribute);
    }

    protected function confirmUser(String $token)
    {
        $this
            ->getJson('/authenticate', ['Authorization' => 'Bearer '.$token])
            ->assertStatus(Response::HTTP_OK)
            ->assertSeeText('Authenticated!');
    }
}
