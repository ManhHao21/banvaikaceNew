<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCategoryRequest extends FormRequest
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
            'name' => 'required|unique:category_post,name',
            'slug' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Tên danh mục không được bỏ trống",
            'name.unique' => "Đã tồn tại tên danh mục",
            'slug.required' => "Đường dẫn không được bỏ trống",
        ];

    }
}
