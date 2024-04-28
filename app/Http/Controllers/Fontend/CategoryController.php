<?php

namespace App\Http\Controllers\Fontend;

use App\Services\ProductCategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    protected $productCategoryService;
    public function __construct(ProductCategoryService $productCategoryService) {
        $this->productCategoryService = $productCategoryService;
    }
    public function getCategory($slug) {
        return view('frontend.layout.category');
    }

    public function loadCategory(Request $request, $slug) {
        $procduct =  $this -> productCategoryService->getProductbyCategory($request, $slug);
        return response()->json([
            'success' => 200,
            'product' => $procduct
        ]);
    }
}
