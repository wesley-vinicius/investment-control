<?php

namespace Tests\Unit\Domain\Product\Models\ProductCategory;

use App\Domain\Product\Models\ProductCategory;
use App\Domain\Product\Models\ProductType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductTypeTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUsersDatabaseHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('product_types', [
                'id', 'name', 'product_category_id',
            ]),
            1
        );
    }

    public function testProductTypeBelongsToProductCategory()
    {
        $categoryType = ProductCategory::factory()->create();
        $productType = ProductType::factory()->make(['product_category_id' => $categoryType->id]);
    
        $this->assertEquals(1, $productType->category->count());
        $this->assertInstanceOf(ProductCategory::class, $productType->category);
    }
}
