<?php

namespace Tests\Feature\Domain\Product\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ListAllProductTest extends TestCase
{
    use DatabaseMigrations;
    
    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=ProductCategorySeeder');
        $this->artisan('db:seed --class=ProductTypeSeeder');

        Sanctum::actingAs(
            User::factory()->create()
        );
    }

    /**
     *
     * @return void
     *
     * @dataProvider countReturnListProductProvider
     */
    public function testListProducts($count)
    {
        $products = Product::factory($count)->create();
        $response = $this->getJson(route('product.listAll'));
        $response->assertOk();

        foreach($products as $key => $product)
        {
            $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', $count)
            ->has("data.{$key}", fn ($json) =>
                $json->where('id', $product->id)
                    ->where('name', $product->name)
                    ->where('company_name', $product->company_name)
                    ->where('symbol', $product->symbol)
                    ->where('type', [
                        'id' => $product->type->id,
                        'name' => $product->type->name,
                        'category' => [
                            'id' => $product->type->category->id,
                            'name' => $product->type->category->name
                        ]
                    ])
                    ->where('description', $product->description)
                    ->where('document', $product->document)
                    ->missing('created_at')
                    ->missing('updated_at')
                )
            );
        }
    
    }

    public function countReturnListProductProvider()
    {
        return [
            [0],
            [1],
            [2],
            [10],
            [100]
        ];
    }
}