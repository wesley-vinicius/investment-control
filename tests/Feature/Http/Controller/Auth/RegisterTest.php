<?php

namespace Tests\Feature\App\Api\Transaction\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testInvalidEmail()
    {
        $payload = [
            'name' => 'test name',
            'email' => 'test email',
            'password' => 'password'
        ];

        $response = $this->postJson(
            route('auth.register'), 
        $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testRegistrationEmailAlreadyInUse()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'test name',
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->postJson(
            route('auth.register'), 
        $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['email']);
    }

    public function testPasswordIsLessThanEight()
    {
        $password = 'passw';
        $payload = [
            'name' => 'test name',
            'email' => 'test@test.com', 
            'password' => $password,
            "password_confirmation" => $password
        ];

        $response = $this->postJson(
            route('auth.register'), 
        $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['password']);

    }

    public function testDifferentPasswords()
    {
        $payload = [
            'name' => 'test name',
            'email' => 'test@test.com', 
            'password' => 'password',
            "password_confirmation" => 'fgbfdgfdgdfgf'
        ];

        $response = $this->postJson(
            route('auth.register'), 
        $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['password']);

    }

    public function testRegisterUser()
    {
        $password = 'password';
        $payload = [
            'name' => 'test name',
            'email' => 'test@test.com', 
            'password' => $password,
            "password_confirmation" => $password
        ];

        $response = $this->postJson(
            route('auth.register'), 
        $payload);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
        ]);
    }

}