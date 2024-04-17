<?php
namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    protected $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
    }
    public function getPagination($page = 15)
    {
        return Product::paginate($page);
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
            if (isset($condition["keyword"]) && !empty($condition['keyword'])) {
                $query->where('name', 'like', '%' . $condition['keyword'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset($condition["publish"]) && $condition['publish'] != 0) {
                $query->where('publish', '=', $condition['publish']);
            }
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        $query->orderBy('id', $order['key']);
        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }

}