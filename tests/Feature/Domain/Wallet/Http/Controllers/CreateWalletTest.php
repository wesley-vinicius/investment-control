<?php

namespace Tests\Feature\Domain\Wallet\Http\Controllers;

use Illuminate\Support\Str;
use App\Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CreateWalletTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    
        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    public function testCreateWallet()
    {
        $user = User::find(1);
        $payload = [
            'name' => Str::random(10),
            'description' => md5(rand(0, 10)),
        ];

        $response = $this->postJson(
            route('wallet.create'), 
        $payload);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('wallets', [
            'name' => $payload['name'],
            'description' => $payload['description'],
            'user_id' => $user->id
        ]);
    }

}
