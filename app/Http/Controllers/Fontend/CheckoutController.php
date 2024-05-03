<?php

namespace App\Http\Controllers\Fontend;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Repositories\ProvinceRepository;
use App\Services\OrderDetailService;

class CheckoutController extends Controller
{
    protected $orderDetailService, $provinceRepository;
    public function __construct(OrderDetailService $orderDetailService, ProvinceRepository $provinceRepository)
    {
        $this->orderDetailService = $orderDetailService;
        $this->provinceRepository = $provinceRepository;
    }
    public function checkout()
    {
        $provindes = $this->provinceRepository->getAll();
        return view('frontend.layout.checkout', compact('provindes'));
    }
    public function payment(Request $request) {
        if($request->payment_option) {
            $order_detail = $this->orderDetailService->createOrderDetail($request);
        }
    }
}
