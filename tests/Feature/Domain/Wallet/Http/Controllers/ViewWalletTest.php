<?php

namespace Tests\Feature\Domain\Wallet\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Domain\Wallet\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ViewWalletTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    public function testViewWallet()
    {
        $wallet = User::find(1)->wallet->first();
        $response = $this->getJson(route('wallet.view', $wallet->id));
        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('data.id', $wallet->id)
                ->where('data.name', $wallet->name)
                ->where('data.description', $wallet->description)
                ->missing('data.created_at')
                ->missing('data.updated_at')
        );
    }

    public function testUserCannotAccessWalletAnotherUser()
    {
        User::factory(1)->create();
        $response = $this->getJson(route('wallet.view', 2));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
