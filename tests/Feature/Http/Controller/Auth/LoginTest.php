<?php

namespace Tests\Feature\App\Core\Api\Transaction\Controllers;

use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testNotLoginIncorrectData()
    {
        $payload = [
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        $response = $this->postJson(
            route('auth.login'), 
        $payload);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertFalse(Auth::check());
    }

    public function testLogin()
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(
            route('auth.login'), 
        $payload);

        $response->assertOk();
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->id, Auth::id());
    }
}