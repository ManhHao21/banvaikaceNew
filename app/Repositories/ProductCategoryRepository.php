<?php
namespace App\Repositories;

use App\Models\Categories;
use App\Repositories\Interface\ProductCategoryRepositoryInterface;

class ProductCategoryRepository extends BaseRepository implements ProductCategoryRepositoryInterface
{
    protected $model;
    public function __construct(Categories $model)
    {
        $this->model = $model;
    }
    public function getPagination($page = 15)
    {
        return Categories::paginate($page);
    }
    public function pagination(array $column = ['*'], array $condition = [], array $join = [], array $extend = [], $perPage = 20, array $relations = [], array $order = [])
    {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query
                    ->where('name', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_title', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_description', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_keyword', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset($condition['publish']) && $condition['publish'] != 0) {
                $query->where('publish', '=', $condition['publish']);
            }
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        $query->orderBy('id', $order['key']);
        return $query
            ->paginate($perPage)
            ->withQueryString()
            ->withPath(env('APP_URL') . $extend['path']);
    }
    public function findBySlug($request, $slug)
    {
        // Tìm danh mục dựa trên slug và có publish = 1
        $category = $this->model->where('slug', $slug)->where('publish', 1)->first();

        if (!$category) {
            return null;
        }

        $allProducts = collect();

        if ($category->children->isNotEmpty()) {
            if ($request->has('min') && $request->has('max')) {
                $min = $request->min;
                $max = $request->max;
                $childrenCategories = $category
                    ->children()
                    ->where('publish', 1)
                    ->with([
                        'Product' => function ($query) use ($min, $max) {
                            $query->whereBetween('price', [$min, $max]);
                        },
                    ])
                    ->paginate(8);
            } else {
                // Lấy tất cả danh mục con có publish = 1 và các sản phẩm của chúng
                $childrenCategories = $category->children()->where('publish', 1)->with('Product')->paginate(8);
            }

            $page = $childrenCategories->lastPage();

            // Lặp qua từng danh mục con để thêm sản phẩm vào biến allProducts
            foreach ($childrenCategories as $childrenCategory) {
                $allProducts = $allProducts->merge($childrenCategory->Product);
            }
        }

        // Lấy các sản phẩm của chính danh mục hiện tại
        $allProducts = $allProducts->merge($category->Product);
        // Sử dụng phương thức paginate để phân trang các sản phẩm và trả về kết quả
        return [
            'product' => $allProducts, // 8 là số sản phẩm trên mỗi trang
            'page' => $page,
        ];
    }
}
