<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $table = 'transactions';
    
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

    public function setPriceAttribute($value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The price must be greater than zero');
        }

        $this->attributes['price'] = $value;
    }

    public function setQuantityAttribute($value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The quantity must be greater than zero');
        }

        $this->attributes['quantity'] = $value;
    }

    public function setAmountAttribute($value)
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('The amount must be greater than zero');
        }

        $this->attributes['amount'] = $value;
    }
}
