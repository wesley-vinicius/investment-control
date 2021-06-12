<?php

namespace App\Domain\Wallet\Models;

use Database\Factories\WalletFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    public $table = 'wallets';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

    protected static function newFactory()
    {
        return WalletFactory::new();
    }

    public function walletProduct()
    {
        return $this->hasMany(WalletProduct::class);
    }
}