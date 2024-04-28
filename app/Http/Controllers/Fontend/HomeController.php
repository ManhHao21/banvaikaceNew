<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Option;
use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $menus = Categories::where('parent_id', '=', 0)->get();

        $productNew = Product::where('publish', '=', 1)->get();

        return view("frontend.index", compact("menus", 'productNew'));
    }
}