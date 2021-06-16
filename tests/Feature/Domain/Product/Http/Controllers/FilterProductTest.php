<?php

namespace Tests\Feature\Domain\Product\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Models\ProductCategory;
use App\Domain\Product\Models\ProductType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FilterProductTest extends TestCase
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
     * @dataProvider filterProductData
     */
    public function testReturnProductWhenCategoryMatch($name, $search, $quantity)
    {
        $products = Product::factory($quantity)
        ->state(['symbol' => $name])
        ->create();

        $response = $this->getJson(route('product.filter', [1, $search]));
        $response->assertOk();

        foreach($products as $key => $product)
        {
            $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', $quantity)
            ->has("data.{$key}", fn ($json) =>
                $json->where('id', $product->id)
                ->where('name', $product->name)
                ->where('symbol', $product->symbol)
                ->missing('created_at')
                ->missing('updated_at')
                )
            );
        }
    }

    public function testNotReturnProductWhenFilterNotMatch()
    {
        Product::factory(2)
        ->state(['symbol' => 'ITAU'])
        ->create();

        $response = $this->getJson(route('product.filter', [1, 'ggrtg']));
        $response->assertOk()
        ->assertExactJson([
            'data' => [],
        ]);
    }

    public function testNotReturnProductWhenCategoryNotMatch()
    {
        ProductCategory::factory(1)->create();
        ProductType::factory(1)
        ->state(['product_category_id' => 2])
        ->create();

        Product::factory(1)
        ->state(['symbol' => 'ITAU', 'product_type_id' => 2])
        ->create();

        $response = $this->getJson(route('product.filter', [1, 'ITAU']));
        $response->assertOk()
        ->assertExactJson([
            'data' => [],
        ]);
    }

    public function filterProductData()
    {
        return [
            ['BIDI', 'BI', 1],
            ['IUSA', 'IU', 1],
            ['BIDI', 'BI', 1],
            ['BIDI', 'DI', 2],
        ];
    }
}