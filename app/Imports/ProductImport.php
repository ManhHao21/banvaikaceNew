<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    private $data = [];

    public function model(array $row)
    {
        $product = new Product([
            "name" => $row['name'] ?? null,
            "slug" => $row['slug'] ?? null,
            "sku" => $row['code'] ?? null,
            "price" => $row['price'] ?? null,
            "categories_id" => $row['category'] ?? null,
            "description" => $row['des'] ?? null,
            "image" => $row['image'] ?? null,
            "material_id" => json_encode([
                $row['material1'] ?? null,
                $row['material2'] ?? null,
            ]) ?? null,
            "gms" => $row['gms'] ?? null,
        ]);

        return $product;
    }

    public function headingRow(): int
    {
        return 1;
    }


    public function rules(): array
    {
        return [
            'name' => ['required'],
            'slug' => ['required', 'unique:product,slug'],
            'code' => ['required'],
            'price' => ['required'],
            'category' => ['required'],
            'des' => ['required'],
            'image' => ['required'],
            'material' => ['required'],
            'gms' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'slug.unique' => 'Đường dẫn đã tồn tại, vui lòng nhập lại',
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'code.required' => 'Vui lòng nhập mã sản phẩm',
            'price.required' => 'Vui lòng nhập giá sản phẩm',
            'category.required' => 'Vui lòng nhập danh mục sản phẩm',
            'des.required' => 'Vui lòng nhập mô tả sản phẩm',
            'image.required' => 'Vui lòng nhập hình ảnh sản phẩm',
            'material.required' => 'Vui lòng nhập chất liệu sản phẩm',
            'gms.required' => 'Vui lòng nhập trọng lượng sản phẩm',
        ];
    }
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $row = $failure->row();
            $errors = $failure->errors();
            Log::error("Lỗi tại hàng $row: " . implode(', ', $errors));
        }
    }
}
