<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Unique;
use App\Repositories\Interface\OrderDetailRepositoryInterface;
use App\Repositories\Interface\ProductOrderDetailRepositoryInterface;

class OrderDetailService extends BaseService
{
    protected $OrderDetailRepositoryInterface, $productOrderDetailRepositoryInterface;

    public function __construct(OrderDetailRepositoryInterface $OrderDetailRepositoryInterface, ProductOrderDetailRepositoryInterface $productOrderDetailRepositoryInterface)
    {
        $this->OrderDetailRepositoryInterface = $OrderDetailRepositoryInterface;
        $this->productOrderDetailRepositoryInterface = $productOrderDetailRepositoryInterface;
    }

    public function createOrderDetail($request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $total = 0;
            $carts = $cart = session()->get('carts', []);
            foreach ($carts as $key => $value) {
                $total += $value['price'] * $value['quantity'];
            }

            // Tạo mã đơn hàng duy nhất
            $orderCode = strtoupper(Str::random(3)) . time() . strtoupper(Str::random(3));

            $order_detail =  $this->OrderDetailRepositoryInterface->create([
                "order_code" => $orderCode,
                'address' => $data['address'],
                "province_id" => $data['province_id'],
                "district_id" => $data['district_id'],
                "ward_id" => $data['ward_id'],
                "code" => $data['code'],
                "phone" => $data['phone'],
                "email" => $data['email'],
                "total" => $total,
                'status' => 1,
                'date_order' => Cacbon::now()->format('Y-m-d H:i:s'),
            ]);

            if ($request->payment_option == 'cash') {
                $this->OrderDetailRepositoryInterface->updated($order_detail->id, [1]);
                foreach ($carts as $key => $value) {
                    $product_order =  $this->productOrderDetailRepositoryInterface->insert([
                        'product_id' => $value['id'],
                        'order_detail' => $order_detail->id,
                        'quantity' => $value['quantity']
                    ]);
                }
            }

            DB::commit();
            return $product_order;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
}
