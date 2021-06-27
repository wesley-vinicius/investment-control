<?php

namespace Tests\Unit\Wallet\Models;

use App\Domain\Auth\Models\User;
use App\Domain\Product\Models\Product;
use App\Domain\Product\Models\ProductCategory;
use App\Domain\Product\Models\ProductType;
use App\Domain\WalletProduct\Models\WalletProduct;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testWalletDatabaseHasExpectedColumns()
    {
        $this->assertTrue( 
          Schema::hasColumns('wallets', [
            'id',  'name', 'description', 'user_id',
        ]), 1);
    }

    public function testWalletHasManyWalletProduct()
    {
        $user = User::factory()->create();
        $categoryType = ProductCategory::factory()->create();
        $productType = ProductType::factory()->create(['product_category_id' => $categoryType->id]);
        $product = Product::factory()->create(['product_type_id' => $productType->id]);
        WalletProduct::factory()->create(
            [
                'wallet_id' => $user->wallet[0]->id,
                'product_id' => $product->id
            ]
        );

        $this->assertEquals(1, $user->wallet[0]->walletProduct->count());
        $this->assertInstanceOf(Collection::class, $user->wallet[0]->walletProduct);
    }
}
