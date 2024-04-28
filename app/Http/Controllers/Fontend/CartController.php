<?php

namespace App\Http\Controllers\Fontend;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Commom\IdRequest;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function cart()
    {
        return view('frontend.layout.cart');
    }
    public function getCart(IdRequest $request, $id)
    {
        if ($request->input('key') == 'order') {
            $product = $this->productService->getCartOrder($id);
            return response()->json([
                'html' => $product,
            ]);
        } elseif ($request->input('key') == 'like') {
            dd('like');
        } elseif ($request->input('key') == 'change-quantity') {
            $product = $this->productService->updateQuantity($request, $id);
            return response()->json([
                'html' => $product,
            ]);
        } else if ($request->input('key') == 'close_row') {
            $product = $this->productService->closeRowCart($id);
            return response()->json([
                'html' => $product,
            ]);
        }
    }

    public function deleteTable(Request $request)
    {
        $carts = session()->get('carts');
        foreach ($carts as $key => $cart) {
            if ($carts[$key]['idProduct'] == $request->input('id')) {
                unset($carts[$key]);
                $table_view = view('Fontend.component.table', compact('carts'))->render();
                break; // stop the loop once the item is found and removed
            }
        }
        session()->put('carts', $carts);

        return response()->json(['success' => true, 'html' => $table_view]);
    }

    public function updateTable(Request $request)
    {
        $carts = session()->get('carts');

        foreach ($request->input('products') as $product) {
            foreach ($carts as $key => &$cart) {
                if ($product['id'] == $cart['idProduct']) {
                    $cart['quantity'] = $product['quantity'];
                    $table_view = view('Fontend.component.table', compact('carts'))->render();
                    break;
                }
            }
        }

        session()->put('carts', $carts);

        return response()->json(['success' => true, 'html' => $table_view]);
    }
}
