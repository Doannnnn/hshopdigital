<?php

namespace App\Http\Controllers;

use App\Services\OrderDetailService;
use App\Services\OrderService;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    private $orderService;

    private $orderDetailService;

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->orderService = new OrderService;

        $this->orderDetailService = new OrderDetailService;
    }


    # Lấy danh sách chi tiết đơn hàng 
    public function getAllOrderDetails()
    {
        try {
            $orderDetails = $this->orderDetailService->findAllByOrder();

            return response()->json($orderDetails, 200);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }


    # Đặt hàng
    public function order()
    {
        try {
            $validatedData = request()->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'phone' => 'required',
                'payment_method' => 'required',
                'email' => 'required',
                'notes' => 'nullable'
            ]);

            $order = $this->orderService->create($validatedData);

            return response()->json(['message' => 'Order successfully', 'order' => $order], 200);
        } catch (ValidationException $e) {

            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
