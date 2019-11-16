<?php

namespace Davidhsianturi\Compass\Tests\Compass;

use Illuminate\Http\Response;
use Davidhsianturi\Compass\Tests\TestCase;
use Davidhsianturi\Compass\Tests\Fixtures\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route as RouteFacade;
use Davidhsianturi\Compass\Authenticators\TokenAuthRepository;

class TokenAuthRepositoryTest extends TestCase
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

        $this->repository = new TokenAuthRepository();
    }

    public function test_get_all_registered_users_from_storage()
    {
        tap(factory(User::class, 3)->create(), function ($users) {
            $this->assertSame($users->count(), $this->repository->get()->count());
        });
    }

    public function test_authenticate_a_plain_text_api_token_for_request()
    {
        // Hash option is false.
        config()->set('auth.guards.api.hash', false);

        $user = factory(User::class)->create();
        $attributeKey = config('compass.authenticator.user_attribute');
        $result = $this->repository->get()->first();

        $this->getJson('/authenticate', [
                'Authorization' => 'Bearer '.$result->apiKey,
            ])
            ->assertStatus(Response::HTTP_OK)
            ->assertSeeText('Authenticated!');

        $this->assertTrue(auth('api')->check());
        $this->assertSame($user->$attributeKey, $result->identifierKey);
    }

    public function test_authenticate_refreshed_api_token_for_request()
    {
        // Hash option is true.
        config()->set('auth.guards.api.hash', true);
        config()->set('compass.authenticator.user_attribute', 'id');

        $user = factory(User::class)->states('hashedToken')->create();
        $attributeKey = config('compass.authenticator.user_attribute', 'id');
        $result = $this->repository->get()->first();

        $this->getJson('/authenticate', [
            'Authorization' => 'Bearer '.$result->apiKey,
        ])
        ->assertStatus(Response::HTTP_OK)
        ->assertSeeText('Authenticated!');

        $this->assertTrue(auth('api')->check());
        $this->assertEquals($user->$attributeKey, $result->identifierKey);
    }
}
