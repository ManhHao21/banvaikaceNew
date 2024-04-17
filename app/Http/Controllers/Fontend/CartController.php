<?php

namespace App\Http\Controllers\Fontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Interface\ProductServiceInterface;

class CartController extends Controller
{
    protected $productService;
    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }
    public function getCart(Request $request)
    {

        if ($request->data) {
            $data =  $this->productService->getCartToOrder($request->data);
            return response()->json([
                'data' => $data,
                'success' => 200
            ]);
        }
        // $carts = session()->get("carts");
        // return view("Fontend.cart", compact("carts"));
    }

    public function deleteTable(Request $request)
    {
        $carts = session()->get("carts");
        foreach ($carts as $key => $cart) {
            if ($carts[$key]['idProduct'] == $request->input('id')) {
                unset($carts[$key]);
                $table_view = view('Fontend.component.table', compact('carts'))->render();
                break; // stop the loop once the item is found and removed
            }
        }
        session()->put("carts", $carts);

        return response()->json(['success' => true, 'html' => $table_view]);
    }

    public function updateTable(Request $request)
    {
        $carts = session()->get("carts");

        foreach ($request->input("products") as $product) {
            foreach ($carts as $key => &$cart) {
                if ($product['id'] == $cart['idProduct']) {

                    $cart['quantity'] = $product['quantity'];
                    $table_view = view('Fontend.component.table', compact('carts'))->render();
                    break;
                }
            }
        }


        session()->put("carts", $carts);


        return response()->json(['success' => true, 'html' => $table_view]);
    }


}