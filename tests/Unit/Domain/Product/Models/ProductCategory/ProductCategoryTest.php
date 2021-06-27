<?php

namespace Tests\Unit\Domain\Product\Models\ProductCategory;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function testUsersDatabaseHasExpectedColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('product_categories', [
                'id', 'name'
            ]),
            1
        );
    }
}
