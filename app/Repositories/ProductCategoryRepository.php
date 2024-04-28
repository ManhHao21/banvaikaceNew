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
    public function pagination(
        array $column = ['*'],
        array $condition = [],
        array $join = [],
        array $extend = [],
        $perPage = 20,
        array $relations = [],
        array $order = []
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset ($condition["keyword"]) && !empty ($condition['keyword'])) {
                $query->where('name', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_title', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_description', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_keyword', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset ($condition["publish"]) && $condition['publish'] != 0) {
                $query->where('publish', '=', $condition['publish']);
            }
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        $query->orderBy('id', $order['key']);
        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
    public function findBySlug($request, $slug)
    {
        // Tìm danh mục dựa trên slug và có publish = 1
        $category = $this->model->where('slug', $slug)->where('publish', 1)->first();

        if (!$category) {
            // Xử lý trường hợp không tìm thấy danh mục, ví dụ: trả về thông báo lỗi hoặc giá trị mặc định
            return null;
        }

        // Khởi tạo một biến để lưu trữ tất cả sản phẩm
        $allProducts = collect();

        // Nếu danh mục hiện tại có danh mục con
        if ($category->children->isNotEmpty()) {
            // Lấy tất cả danh mục con có publish = 1 và các sản phẩm của chúng
            $childrenCategories = $category->children()->where('publish', 1)->with('Product')->get();

            // Lặp qua từng danh mục con để thêm sản phẩm vào biến allProducts
            foreach ($childrenCategories as $childrenCategory) {
                $allProducts = $allProducts->merge($childrenCategory->Product);
            }
        }

        // Lấy các sản phẩm của chính danh mục hiện tại
        $allProducts = $allProducts->merge($category->Product);

        // Trả về danh sách tất cả sản phẩm
        return $allProducts;
    }


}