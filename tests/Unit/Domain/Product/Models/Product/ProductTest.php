<?php

namespace Tests\Unit\Domain\Product\Models\Product;

use App\Domain\Product\Models\Product;
use App\Domain\Product\Models\ProductCategory;
use App\Domain\Product\Models\ProductType;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUsersDatabaseHasExpectedColumns()
    {
        $this->assertTrue( 
          Schema::hasColumns('products', [
            'name', 'symbol', 'product_type_id', 'company_name', 'document', 'description',
        ]), 1);
    }

    public function testProductBelongsToProductType()
    {
        $categoryType = ProductCategory::factory()->create();
        $productType = ProductType::factory()->create(['product_category_id' => $categoryType->id]);
        $product = Product::factory()->make(['product_type_id' => $productType->id]);

        $this->assertEquals(1, $product->type->count());
        $this->assertInstanceOf(ProductType::class, $product->type);
    }
}
