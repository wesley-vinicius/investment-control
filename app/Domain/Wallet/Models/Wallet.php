<?php

declare(strict_types=1);

namespace App\Domain\Wallet\Models;

use App\Domain\WalletProduct\Models\WalletProduct;
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

    public function walletProduct()
    {
        return $this->hasMany(WalletProduct::class);
    }

    private static function newFactory()
    {
        return WalletFactory::new();
    }
}
