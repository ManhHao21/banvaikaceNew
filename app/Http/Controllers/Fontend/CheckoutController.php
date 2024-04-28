<?php

namespace App\Http\Controllers\Fontend;

use App\Services\ProductService;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function checkout()
    {
        return view('frontend.layout.checkout');
    }
    
}
