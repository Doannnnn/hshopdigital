<?php

namespace App\Services;

use App\Mail\OrderInvoice;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    private $orderDetailService;
    private $shippingAddressService;

    public function __construct()
    {
        $this->orderDetailService = new OrderDetailService;

        $this->shippingAddressService = new ShippingAddressService;
    }


    # Tạo đơn hàng
    public function create($data)
    {
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)->first();

        $cartDetails = CartDetail::where('cart_id', $cart->id)->get();

        $total_amount = 0;

        foreach ($cartDetails as $cartDetail) {
            $total_amount += $cartDetail->total;
        };

        try {
            // Tạo order
            $order = Order::create([
                'total_amount' => $total_amount,
                'payment_method' => $data['payment_method'],
                'notes' => $data['notes'],
                'status' => 'Pending',
                'order_date' => Carbon::now(),
                'user_id' => $user->id,
            ]);

            $data['orderId'] = $order->id;

            $this->shippingAddressService->create($data); // Tạo Shipping Address

            // Tạo order detail
            foreach ($cartDetails as $cartDetail) {
                $this->orderDetailService->create([
                    'orderId' => $order->id,
                    'productId' => $cartDetail->product_id,
                    'quantity' => $cartDetail->quantity,
                    'total' => $cartDetail->total,
                ]);
            }

            $cart->cartDetails()->delete();

            return $order;  

            // Mail::to($user->email)->send(new OrderInvoice($order));
        } catch (QueryException $e) {

            throw new \Exception('Error creating order: ' . $e->getMessage(), 500);
        }
    }
}
