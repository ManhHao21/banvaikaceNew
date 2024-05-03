<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Repositories\Interface\OrderDetailRepositoryInterface;

class ProductOrderDetailService extends BaseService
{
    protected $OrderDetailRepositoryInterface;

    public function __construct(OrderDetailRepositoryInterface $OrderDetailRepositoryInterface)
    {
        $this->OrderDetailRepositoryInterface = $OrderDetailRepositoryInterface;
    }

    public function createOrderDetail($request)
    {
        $data = $request->all();
        $total = 0;
        $carts = $cart = session()->get('carts', []);
        foreach ($carts as $key => $value) {
            $total += $value['price'] * $value['quantity'];
        }
        $order_detail =  $this->OrderDetailRepositoryInterface->create([
            "order_code" =>  $orderCode = strtoupper(Str::random(3)) . time() . strtoupper(Str::random(3)),
            'address' => $data['address'],
            "province_id" => $data['province_id'],
            "district_id" => $data['district_id'],
            "ward_id" => $data['ward_id'],
            "code" => $data['code'],
            "phone" => $data['phone'],
            "email" => $data['email'],
            "total" => $total
        ]);
        if($request->payment_option == 'cash') {
            foreach ($carts as $key => $value) {

            }
        }
    }
}
