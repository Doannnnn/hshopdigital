<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\QueryException;

class ProductService
{
    # Lấy tất cả sản phẩm
    public function findAll()
    {
        try {
            $products = Product::with('category', 'images')->get();

            return $products->makeHidden(['category_id']);
        } catch (QueryException $e) {

            throw new \Exception("Error when retrieving product data: " . $e->getMessage(), 500);
        }
    }


    # Lấy sản phẩm theo ID
    public function findById($productId)
    {
        try {
            $product = Product::with('category', 'images')->find($productId);

            return $product ? $product->makeHidden(['category_id']) : null;
        } catch (QueryException $e) {

            throw new \Exception("Error when retrieving product data: " . $e->getMessage(), 500);
        }
    }
}
