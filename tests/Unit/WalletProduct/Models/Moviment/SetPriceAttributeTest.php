<?php

namespace Tests\Unit\WalletProduct\Models;

use App\Domain\WalletProduct\Models\Movement;
use Tests\TestCase;

class SetPriceAttributeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testValueCannotLessZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transaction = new Movement();
        $transaction->setPriceAttribute(-1);
    }

    public function testValueCannotBeZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transaction = new Movement();
        $transaction->setPriceAttribute(0);
    }

    /**
     *
     * @return void
     * 
     * @dataProvider valuePriceDataProvider
     * 
     */
    public function testValueGreaterThanZero($price)
    {
        $transaction = new Movement();
        $transaction->setPriceAttribute($price);
        $this->assertEquals($transaction->price, $price);
    }

  
   public function valuePriceDataProvider()
    {
        return [
            [1],
            [0.1],
            [100,51],
            [514.15],
        ];
    }
}
