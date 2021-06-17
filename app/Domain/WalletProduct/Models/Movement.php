<?php

namespace App\Domain\WalletProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    public $table = 'movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'wallet_product_id',
        'price',
        'type',
        'quantity',
        'amount',
        'date',
        'rates'
    ];

    public function walletProduct()
    {
        return $this->belongsTo(WalletProduct::class);
    }

    public function setPriceAttribute(float $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The price must be greater than zero');
        }

        $this->attributes['price'] = $value;
    }

    public function setQuantityAttribute(int $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The quantity must be greater than zero');
        }

        $this->attributes['quantity'] = intval($value);
    }

    public function setAmountAttribute(float $value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The amount must be greater than zero');
        }

        $this->attributes['amount'] = $value;
    }
}
