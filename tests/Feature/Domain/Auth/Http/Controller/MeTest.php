<?php

namespace Tests\Feature\Domain\Auth\Http\Controller;

use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class MeTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testLoggedOutUserNotHaveAccess()
    {
        $response = $this->getJson(route('auth.me'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $response->assertJson(['message' => true]);    
    }

    public function testLoggedInUserHasAccess()
    {
        $user = Sanctum::actingAs(
            User::factory()->create()
        );
        
        $response = $this->getJson(route('auth.me'));
        $response->assertOk()
        ->assertExactJson($user->toArray());
    }
}