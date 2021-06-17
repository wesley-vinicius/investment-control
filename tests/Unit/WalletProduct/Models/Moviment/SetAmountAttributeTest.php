<?php

namespace Tests\Unit\WalletProduct\Models;

use App\Domain\WalletProduct\Models\Movement;
use Tests\TestCase;

class SetAmountAttributeTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testValueCannotLessZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transaction = new Movement();
        $transaction->setAmountAttribute(-1);
    }

    public function testValueCannotBeZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $transaction = new Movement();
        $transaction->setAmountAttribute(0);
    }

    /**
     *
     * @return void
     * 
     * @dataProvider valueAmountDataProvider
     * 
     */
    public function testValueGreaterThanZero($amount)
    {
        $transaction = new Movement();
        $transaction->setAmountAttribute($amount);
        $this->assertEquals($transaction->amount, $amount);
    }

    public function valueAmountDataProvider()
    {
        return [
            [1],
            [0.151],
            [100,51],
            [514.15],
        ];
    }
}
