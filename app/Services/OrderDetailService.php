<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class OrderDetailService
{
    # Lấy danh sách order detail theo order
    public function findAllByOrder()
    {
        try {
            $user = Auth::user();

            $order = Order::where('user_id', $user->id)->first();

            if ($order) {
                $orderDetails = OrderDetail::where('order_id', $order->id)->with('product', 'product.images', 'product.category')->get();

                $orderDetails->each(function ($detail) {
                    $detail->product->makeHidden(['category_id']);
                });

                return $orderDetails->makeHidden(['product_id']);
            }

            return null;
        } catch (QueryException $e) {

            throw new \Exception("Error when retrieving order detail data: " . $e->getMessage(), 500);
        }
    }


    # Tạo đơn hàng chi tiết
    public function create($data)
    {
        try {
            $orderDetail = OrderDetail::create([
                'order_id' => $data['orderId'],
                'product_id' => $data['productId'],
                'quantity' => $data['quantity'],
                'total' => $data['total'],
            ]);

            return $orderDetail;
        } catch (QueryException $e) {

            throw new \Exception('Error creating order detail: ' . $e->getMessage(), 500);
        }
    }
}
