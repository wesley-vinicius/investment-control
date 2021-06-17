<?php

namespace Database\Factories;

use App\Domain\WalletProduct\Models\WalletProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WalletProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = rand(1,100);
        return [
            'wallet_id' => 1,
            'quantity' => $quantity,
            'product_id' => 1,
            'amount_applied' => $quantity * rand(1,50),
            'start_date' => now()
        ];
    }
}
