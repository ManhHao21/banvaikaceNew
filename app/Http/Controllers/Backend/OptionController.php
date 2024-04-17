<?php

namespace App\Http\Controllers\Backend;

use App\Models\Option;
use App\Models\Product;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function catelog()
    {
        $catelogs = Categories::all();
        $optionProducts = Option::where('key', '=', 'catelog')->first();
        if (isset($optionProducts)) {
            $value = $optionProducts['value'];
            $decodedValues = json_decode($value, true);
            return view("backend.option.catelog", compact("catelogs", 'decodedValues'));
        }
        return view("backend.option.catelog", compact("catelogs"));

    }
    public function postCatelog(Request $request)
    {
        $catelogs = json_encode($request->_a());
        dd($catelogs);
        $option = Option::where('key', 'catelog')->first();
        if ($option) {
            $option->update(['value' => $catelogs]);
            $option->save();
            return redirect()->route('admin.option.catelog')->with('success', 'Thêm option thành công');
        } else {
            $option = Option::create([
                'value' => $catelogs,
                'key' => 'catelog'
            ]);
            $option->save();
            return redirect()->route('admin.option.catelog')->with('success', 'Thêm option thành công');
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function getProduct()
    {
        $products = Product::all();
        $optionProducts = Option::where('key', '=', 'product')->first();
        if ($optionProducts) {
            $value = $optionProducts['value'];
            $decodedValues = json_decode($value, true);
            return view("backend.option.product", compact("products", 'decodedValues'));
        }

        return view("backend.option.product", compact("products"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function getProductPost(Request $request)
    {
        $product = json_encode($request->all());
        $option = Option::where('key', 'product')->first();
        if ($option) {
            $option->update(['value' => $product]);
            $option->save();
            return redirect()->route('admin.option.getProduct')->with('success', 'Thêm option thành công');
        } else {
            $option = Option::create([
                'value' => $product,
                'key' => 'product'
            ]);
            $option->save();
            return redirect()->route('admin.option.getProduct')->with('success', 'Thêm option thành công');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Option $option)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        //
    }
}