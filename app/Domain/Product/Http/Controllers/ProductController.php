<?php

namespace App\Domain\Product\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domain\Product\Http\Resources\ProductResource;
use App\Domain\Product\Models\Product;

class ProductController extends Controller
{

    public function listAll()
    {
        return ProductResource::collection(Product::all());
    }
}
