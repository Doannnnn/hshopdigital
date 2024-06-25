<?php

namespace App\Services;

use App\Models\ShippingAddress;
use Illuminate\Database\QueryException;

class ShippingAddressService
{
    # Tạo địa chỉ giao hàng
    public function create($data)
    {
        try {
            $shipingAddress = ShippingAddress::create([
                'first_name' => $data['first_name'],
                'last_name'  => $data['last_name'],
                'address'  => $data['address'],
                'city'  => $data['city'],
                'phone'  => $data['phone'],
                'email'  => $data['email'],
                'order_id'  => $data['orderId'],
            ]);

            return $shipingAddress;
        } catch (QueryException $e) {

            throw new \Exception('Error creating cart: ' . $e->getMessage(), 500);
        }
    }
}
