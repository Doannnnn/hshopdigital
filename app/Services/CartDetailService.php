<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class CartDetailService
{
    private $cartService;

    public function __construct()
    {
        $this->cartService = new CartService;
    }


    # Lấy danh sách cart detail theo cart
    public function findAllByCart()
    {
        try {
            $user = Auth::user();

            $cart = Cart::where('user_id', $user->id)->first();

            if ($cart) {
                $cartDetails = CartDetail::where('cart_id', $cart->id)->with('product', 'product.images', 'product.category')->get();

                $cartDetails->each(function ($detail) {
                    $detail->product->makeHidden(['category_id']);
                });

                return $cartDetails->makeHidden(['product_id']);
            }

            return null;
        } catch (QueryException $e) {

            throw new \Exception("Error when retrieving cart detail data: " . $e->getMessage(), 500);
        }
    }


    # Tạo giỏ hàng chi tiết
    public function create($data)
    {
        try {
            $cartDetail = CartDetail::create([
                'cart_id' => $data['cartId'],
                'product_id' => $data['productId'],
                'quantity' => $data['quantity'],
                'total' => $data['total'],
            ]);

            return $cartDetail;
        } catch (QueryException $e) {

            throw new \Exception('Error creating cart detail: ' . $e->getMessage(), 500);
        }
    }


    # Xử lý thêm vào giỏ hàng
    public function handleAddToCart($data)
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart) {
            $cart = $this->cartService->create($user->id);
        }

        $product = Product::find($data['productId']);

        if (!$product) {
            throw new \Exception('Product not found.', 404);
        }

        $price = $product->price;

        $cartDetail = CartDetail::where('cart_id', $cart->id)->where('product_id', $data['productId'])->first();

        if (!$cartDetail) {
            $data['cartId'] = $cart->id;
            $data['userId'] = $user->id;
            $data['total'] = $price * $data['quantity'];

            return $this->create($data);
        } else {
            try {
                $cartDetail->quantity += $data['quantity'];

                $cartDetail->total = $cartDetail->quantity * $price;

                $cartDetail->save();

                return $cartDetail;
            } catch (QueryException $e) {

                throw new \Exception('Error updating cart detail: ' . $e->getMessage(), 500);
            }
        }
    }


    # Xử lý thay đổi số lượng
    public function handlChangeQuantity($data)
    {
        $cartDetail = CartDetail::find($data['cartDetailId']);

        if (!$cartDetail) {
            throw new \Exception('Cart detail not found.',  404);
        }

        $product = Product::find($cartDetail->product_id);

        if (!$product) {
            throw new \Exception('Product not found.',  404);
        }

        $price = $product->price;

        $total = $data['quantity'] *  $price;

        try {
            $cartDetail->quantity = $data['quantity'];

            $cartDetail->total = $total;

            $cartDetail->save();

            return $cartDetail;
        } catch (QueryException $e) {

            throw new \Exception('Error updating cart detail: ' . $e->getMessage(), 500);
        }
    }


    # Xử lý xoá khỏi giỏ hàng
    public function delete($cartDetailId)
    {
        $cartDetail = CartDetail::find($cartDetailId);

        if (!$cartDetail) {
            throw new \Exception('Cart detail not found.', 404);
        }

        try {

            $cartDetail->delete();
        } catch (QueryException $e) {

            throw new \Exception('Error delete  cart detail: ' . $e->getMessage(), 500);
        }
    }
}
