<?php

namespace App\Http\Controllers\Fontend;

use session;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function getProductDetail($slug)
    {
        $product = Product::where('slug', '=', $slug)->first();
        if ($product) {
            $commentCount = $product->comments;
            $comments = $product->comments()->latest()->take(5)->get();
            $relatedProducts = Product::where('categories_id', $product->categories_id)
                ->where('slug', '!=', $slug)
                ->latest()
                ->take(10)
                ->get();

            return view('fontend.productDetail', compact('product', 'comments', 'commentCount', 'relatedProducts'));
        }
        return abort(404);
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