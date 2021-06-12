<?php

namespace App\Domain\Product\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $table = 'products';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'symbol',
        'product_type_id',
        'company_name',
        'document',
        'description'
    ];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function type()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

}
