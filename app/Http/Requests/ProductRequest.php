<?php

namespace App\Http\Requests;

use App\Models\Material;
use App\Rules\InMaterials;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required",
            "slug" => "required|unique:product,slug",
            "categories_id" => "required|not_in:0",
            // "sku" => "required",
            // "material_id" =>  ['required', new InMaterials],
            // 'gms' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'price' => 'required|numeric|between:1,99999999999999',
            'quantity' => 'required',
            'description' => 'required',
        ];
    }
   
    public function messages(): array
    {
        return [
            'name.required' => 'Tên sản phẩm không được bỏ trống',
            'slug.required' => 'Đường dẫn không được bỏ trống',
            'slug.unique' => 'Đường dẫn đã tồn tại',
            'categories_id' => 'Vui lòng chọn danh mục',
            'categories_id.not_in' => 'Vui lòng chọn danh mục',
            // 'sku.required' => "Mã sản phẩm không được bỏ trống",
            // 'material_id.required' => 'Vui lòng chọn chất liệu sản phẩm',
            // 'gms.required' => 'Trường gms là bắt buộc.',
            // 'gms.numeric' => 'Trường gms phải là một số.',
            // 'gms.regex' => 'Trường gms không đúng định dạng số thực.',
            'price.required' => 'Trường Giá là bắt buộc.',
            'price.numeric' => 'Trường Giá phải là một số.',
            'price.between' => 'Trường Giá phải nằm trong khoảng từ :min đến :max.',
            'quantity.required' => 'Trường Số lượng là bắt buộc.',
            'description.required' => 'Trường Hình ảnh là bắt buộc và phải là hình ảnh.',

        ];
    }
}
