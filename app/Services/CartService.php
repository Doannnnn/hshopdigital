<?php

namespace App\Services;

use App\Models\Cart;
use Illuminate\Database\QueryException;

class CartService
{
    # Tạo giỏ hàng
    public function create($userId)
    {
        try {
            $cart = Cart::create([
                'user_id' => $userId,
            ]);

            return $cart;
        } catch (QueryException $e) {

            throw new \Exception('Error creating cart: ' . $e->getMessage(), 500);
        }
    }
}
