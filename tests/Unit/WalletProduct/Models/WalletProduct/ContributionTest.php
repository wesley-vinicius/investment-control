<?php

namespace Tests\Unit\WalletProduct\Models\WalletProduct;

use App\Domain\WalletProduct\Models\WalletProduct;
use Tests\TestCase;

class ContributionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testQuantityCannotLessZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The quantity must be greater than zero');
        $walletProduct = WalletProduct::factory(1)
        ->state(['amount_applied' => 0, 'quantity' => 0])
        ->make()->first();
        $walletProduct->contribution(-12, 100.00);
    }

    public function testQuantityCannotBeZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The quantity must be greater than zero');
        $walletProduct = WalletProduct::factory(1)
        ->state(['amount_applied' => 0, 'quantity' => 0])
        ->make()->first();
        $walletProduct->contribution(0, 100.00);
    }

    public function testAmountCannotLessZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The amount must be greater than zero');
        $walletProduct = WalletProduct::factory(1)
        ->state(['amount_applied' => 0, 'quantity' => 0])
        ->make()->first();
        $walletProduct->contribution(10, -0);
    }

    public function testAmountCannotBeZero()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The amount must be greater than zero');
        $walletProduct = WalletProduct::factory(1)
        ->state(['amount_applied' => 0, 'quantity' => 0])
        ->make()->first();
        $walletProduct->contribution(10, 0);
    }

    public function testContribution()
    {
        $quantity = rand(1, 50);
        $price = rand(1, 100.251);
        $amount = $quantity * $price;

        $walletProduct = WalletProduct::factory(1)->make()->first();
        $amountApplied = $walletProduct->amount_applied + $amount;
        $quantityExpected = $walletProduct->quantity + $quantity;

        $walletProduct->contribution($quantity, $amount);
       
        $this->assertEquals($amountApplied, $walletProduct->amount_applied);
        $this->assertEquals($quantityExpected, $walletProduct->quantity);
    }
}
