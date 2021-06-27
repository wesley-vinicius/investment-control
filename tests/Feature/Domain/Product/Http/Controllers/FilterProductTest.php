<?php

namespace Tests\Feature\Domain\Product\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Models\ProductCategory;
use App\Domain\Product\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
     * @dataProvider getSuccessScenarios
     */
    public function testReturnProductWhenCategoryMatch(array $state, string $search, int $quantity, int $quantity_expected)
    {
        $product = Product::factory($quantity)
            ->state(new Sequence($state))
            ->create()
            ->first();

        $response = $this->getJson(route('product.filter', [1, $search]));
        $response->assertOk();

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('data', $quantity_expected)
                ->has(
                    "data.0",
                    fn ($json) =>
                    $json->where('id', $product->id)
                        ->where('name', $product->name)
                        ->where('symbol', $product->symbol)
                        ->missing('created_at')
                        ->missing('updated_at')
                )
        );
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

    public function getSuccessScenarios()
    {
        return [
            [
                "state" => ['symbol' => 'BIDI'],
                "search" => 'BI',
                "quantity" => 1,
                "quantity_expected" => 1
            ],
            [
                "state" => ['symbol' =>  'IUSA'],
                "search" =>  'IU',
                "quantity" => 1,
                "quantity_expected" => 1
            ],
            [
                "state" =>  ['symbol' =>  'BIDI'],
                "search" =>  'ID',
                "quantity" => 1,
                "quantity_expected" => 1
            ],
            [
                "state" =>  [
                    'symbol' => 'BIDI4',
                    'symbol' => 'BIDI11',
                    'symbol' => 'BIDI3',
                    'symbol' => 'BSEW13',
                    'symbol' => 'BWSDR4',
                    'symbol' => 'BASD10'
                ],
                "search" => 'B',
                "quantity"  => 6,
                "quantity_expected" => 6
            ],
            [
                "state" =>  [
                    'symbol' => 'BIDI4',
                    'symbol' => 'BIDI44',
                    'symbol' => 'BIDI11',
                    'symbol' => 'BIDI3',
                    'symbol' => 'BSEW13',
                    'symbol' => 'BWSDR4',
                    'symbol' => 'BASD10'
                ],
                "search" => 'B',
                "quantity"  => 7,
                "quantity_expected" => 6
            ]
        ];
    }
}
