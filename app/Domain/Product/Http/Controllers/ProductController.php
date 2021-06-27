<?php

declare(strict_types=1);

namespace App\Domain\Product\Http\Controllers;

use App\Core\Http\Controllers\Controller;
use App\Domain\Product\Http\Resources\ProductFilterResource;
use App\Domain\Product\Http\Resources\ProductResource;
use App\Domain\Product\Models\Product;

class ProductController extends Controller
{
    public function listAll()
    {
        return ProductResource::collection(Product::all());
    }

    public function view($id)
    {
        $product = Product::find($id);
        if(!$product)
            return response(null, 404);

        return ProductResource::make($product);
    }
    

    public function filter($idCategory, $filter)
    {
        $product = Product::where('product_types.product_category_id', $idCategory)
            ->join('product_types', 'product_types.id', 'products.product_type_id')
            ->where('symbol', 'LIKE', "%{$filter}%")
            ->select('products.id', 'products.name', 'products.symbol')
            ->limit(6)
            ->get();

        return ProductFilterResource::collection($product);
    }
}
