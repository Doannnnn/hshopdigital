<?php

namespace App\Http\Controllers;

use App\Services\CartDetailService;

class CartController extends Controller
{
    private $cartDetailService;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->cartDetailService = new CartDetailService;
    }


    # Lấy danh sách trong giỏ hàng 
    public function getAllCartDetails()
    {
        try {
            $cartDetails = $this->cartDetailService->findAllByCart();

            return response()->json($cartDetails, 200);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Thêm vào giỏ hàng
    public function addToCart()
    {
        $data = request(['productId', 'quantity']);

        try {
            $cartDetail = $this->cartDetailService->handleAddToCart($data);

            return response()->json(['message' => 'Product added to cart successfully.', 'cart_detail' =>  $cartDetail], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Thay đổi số lượng
    public function changeQuantity()
    {
        $data = request(['cartDetailId', 'quantity']);

        try {
            $cartDetail = $this->cartDetailService->handlChangeQuantity($data);

            return response()->json(['message' => 'Change quantity successfully.', 'cart_detail' => $cartDetail], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Xoá khỏi giỏ hàng 
    public function delete($cartDetailId)
    {
        try {
            $this->cartDetailService->delete($cartDetailId);

            return response()->json(['message' => 'Deleted cart details successfully.'], 200);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
