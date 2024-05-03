<?php

namespace App\Http\Controllers\Fontend;

use App\Repositories\ProvinceRepository;
use App\Services\ProductService;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    protected $productService, $provinceRepository;
    public function __construct(ProductService $productService, ProvinceRepository $provinceRepository)
    {
        $this->productService = $productService;
        $this->provinceRepository = $provinceRepository;
    }
    public function checkout()
    {
        $provindes = $this->provinceRepository->getAll();
        return view('frontend.layout.checkout', compact('provindes'));
    }

}
