<?php

declare(strict_types=1);

namespace App\Domain\WalletProduct\Models;

use Database\Factories\WalletProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletProduct extends Model
{
    use HasFactory;

    public $table = 'wallet_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'wallet_id',
        'quantity',
        'product_id',
        'amount_applied',
        'start_date',
    ];

    public function contribution(int $quantity, float $amount): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('The quantity must be greater than zero');
        }
        if ($amount <= 0) {
            throw new \InvalidArgumentException('The amount must be greater than zero');
        }

        $this->quantity += $quantity;
        $this->amount_applied += $amount;
    }

    public function rescue(int $quantity, float $amount): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('The quantity must be greater than zero');
        }
        if ($amount <= 0) {
            throw new \InvalidArgumentException('The amount must be greater than zero');
        }

        $this->quantity -= $quantity;
        $this->amount_applied -= $amount;
    }

    protected static function newFactory()
    {
        return WalletProductFactory::new();
    }
}
