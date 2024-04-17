<?php

namespace App\Http\Controllers\Fontend;

use App\Models\Material;
use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function getCategory($slug) {
        $category = Categories::whereSlug($slug)->first();
        $materials = Material::all();
        if ($category) {
            $products = Product::where("categories_id", $category->id)->get();
        }
        return view("Fontend.shop", compact("category", 'products', 'materials'));
    }
}
