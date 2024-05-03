<?php

namespace App\Http\Controllers\Fontend;

use App\Services\ProductService;
use session;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }
    public function getProductDetail($slug)
    {
        $product_detail = $this->productService->findById($slug);
        return view('frontend.layout.product-detail', compact('product_detail'));
    }

    public function postProductDetail(Request $request)
    {
        // if (Auth::check()) {
        //     $data = $request->all();
        //     $carts = Cart::where('product_id', $data['idProduct'])->first();

        //     if ($carts) {
        //         // Nếu sản phẩm đã tồn tại trong giỏ hàng, bạn có thể thực hiện các xử lý cập nhật ở đây.
        //         $carts->quantity += $data['quantity'];
        //         if ($carts->users_id == null) {
        //             $carts->users_id = Auth::user()->id;

        //         }

        //         $carts->save();

        //         $totalQuantity = Cart::sum('quantity');

        //         return response([
        //             'message' => 'Thêm sản phẩm thành công',
        //             'success' => 200,
        //             'quantity' => $totalQuantity
        //         ]);
        //     } else {
        //         // Nếu sản phẩm chưa tồn tại trong giỏ hàng, tạo một bản ghi mới.
        //         $carts = new Cart();
        //         $carts->product_id = $data['idProduct'];
        //         $carts->quantity = $data['quantity'];
        //         $carts->users_id = Auth::user()->id;
        //         $carts->save();
        //         $totalQuantity = Cart::sum('quantity');
        //         return response([
        //             'message' => 'Thêm sản phẩm thành công',
        //             'success' => 200,
        //             'quantity' => $carts->quantity
        //         ]);
        //     }
        // } else {
        $carts = session()->get('carts', []);
        $idProduct = $request->input('idProduct');
        $quantity = $request->input('quantity');
        $existingProductIndex = array_search($idProduct, array_column($carts, 'idProduct'));

        if ($existingProductIndex !== false) {
            $carts[$existingProductIndex]['quantity'] += $quantity;
        } else {
            $carts[] = ['idProduct' => $idProduct, 'quantity' => $quantity];
        }

        session()->put('carts', $carts);
        $totalQuantity = array_sum(array_column($carts, 'quantity'));

        return response([
            'message' => 'Thêm sản phẩm thành công',
            'success' => 200,
            'quantity' => $totalQuantity,
        ]);
        // }
    }




}