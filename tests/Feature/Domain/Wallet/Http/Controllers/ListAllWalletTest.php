<?php

namespace Tests\Feature\Domain\Wallet\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Domain\Wallet\Models\Wallet;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListAllWalletTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
    
        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    /**
     *
     * @return void
     *
     * @dataProvider listWalletData
     */
    public function testListProducts($quantityToCreate, $quantity)
    {
        Wallet::factory($quantityToCreate)->state(['user_id' => 1])->create();
        $wallet = User::find(1)->wallet;
        $response = $this->getJson(route('wallet.listAll'));
        $response->assertOk();

        foreach($wallet as $key => $product)
        {
            $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', $quantity)
            ->has("data.{$key}", fn ($json) =>
                $json->where('id', $product->id)
                    ->where('name', $product->name)
                    ->where('description', $product->description)
                    ->missing('created_at')
                    ->missing('updated_at')
                )
            );
        }
    
    }

    public function listWalletData()
    {
        return [
            [0, 1],
            [1, 2],
            [2, 3],
            [10, 11],
        ];
    }
}
