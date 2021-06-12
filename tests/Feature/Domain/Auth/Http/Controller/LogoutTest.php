<?php

namespace Tests\Feature\Domain\Auth\Http\Controller;

use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testLoggedOutUserNotHaveAccess()
    {
        $response = $this->postJson(route('auth.logout'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testLoggedInUserHasAccess()
    {
        Sanctum::actingAs(
            User::factory()->create()
        );
        
        $response = $this->postJson(route('auth.logout'));
        $response->assertOk();
    }
}