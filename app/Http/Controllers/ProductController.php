<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class ProductController extends Controller
{
    private $productService;

    public function __construct()
    {
        $this->productService = new ProductService;
    }


    # Lấy tất cả sản phẩm
    public function getAllProduct()
    {
        try {
            $products = $this->productService->findAll();

            return response()->json($products, 200);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Lấy sản phẩm theo ID
    public function getProductById($productId)
    {
        try {
            $product = $this->productService->findById($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found'], 404);
            }

            return response()->json($product);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
