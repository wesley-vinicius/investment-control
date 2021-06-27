<?php

namespace Tests\Unit\Domain\WalletProduct\Models;

use App\Domain\WalletProduct\Models\Movement;
use Tests\TestCase;

class SetQuantityAttributeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testValueCannotLessZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transaction = new Movement();
        $transaction->setQuantityAttribute(-1);
    }

    public function testValueCannotBeZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transaction = new Movement();
        $transaction->setQuantityAttribute(0);
    }

    /**
     *
     * @return void
     * 
     * @dataProvider valueQuantityDataProvider
     * 
     */
    public function testValueGreaterThanZero($quantity)
    {
        $transaction = new Movement();
        $transaction->setQuantityAttribute($quantity);
        $this->assertEquals($transaction->quantity, $quantity);
    }

  
   public function valueQuantityDataProvider()
    {
        return [
            [1],
            [10],
        ];
    }
}
