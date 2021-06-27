<?php

namespace Tests\Feature\Domain\Product\Http\Controllers;

use App\Domain\Auth\Models\User;
use App\Domain\Product\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ViewProductTest extends TestCase
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

    public function testViewProducts()
    {
        $product = Product::factory(1)->create()->first();
        $response = $this->getJson(route('product.view', $product->id));
        $response->assertOk();

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('data.id', $product->id)
                ->where('data.name', $product->name)
                ->where('data.company_name', $product->company_name)
                ->where('data.symbol', $product->symbol)
                ->where('data.type', [
                    'id' => $product->type->id,
                    'name' => $product->type->name,
                    'category' => [
                        'id' => $product->type->category->id,
                        'name' => $product->type->category->name
                    ]
                ])
                ->where('data.description', $product->description)
                ->where('data.document', $product->document)
                ->missing('data.created_at')
                ->missing('data.updated_at')
        );
    }

    public function testReturnNotFoundStatusWhenIsNotExistsProductWithIdInformed()
    { 
        $response = $this->getJson(route('product.view', 1));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
