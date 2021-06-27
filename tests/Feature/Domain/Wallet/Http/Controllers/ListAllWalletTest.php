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
     * @dataProvider getSuccessScenarios
     */
    public function testListProducts($quantityToCreate, $quantityToExpected)
    {
        Wallet::factory($quantityToCreate)->state(['user_id' => 1])->create();
        $wallet = User::find(1)->wallet;
        $response = $this->getJson(route('wallet.listAll'));
        $response->assertOk();

        foreach($wallet as $key => $product)
        {
            $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', $quantityToExpected)
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

    public function getSuccessScenarios()
    {
        return [
            [
                'quantity_to_create' => 0, 
                'quantity_to_expected' => 1
            ],
            [
                'quantity_to_create' => 1, 
                'quantity_to_expected' => 2
            ],
            [
                'quantity_to_create' => 9, 
                'quantity_to_expected' => 10
            ],
        ];
    }
}
