<?php

namespace App\Models;

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
        'amount_applied'
    ];

    public function contribution(int $quantity, float $amount)
    {
        $this->quantity += $quantity;
        $this->amount_applied += $amount;
    }

    public function rescue(int $quantity, float $amount)
    {
        if ($this->quantity < $quantity)
        {
            throw new \DomainException('Amount not available for rescue.');
        }
        $this->quantity -= $quantity;
        $this->amount_applied -= $amount;
    }
}
