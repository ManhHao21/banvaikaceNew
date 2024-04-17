<?php
namespace App\Repositories;

use App\Models\PostCategory;
use App\Repositories\Interface\PostCategoryRepositoryInterface;


class PostCategoryRepository extends BaseRepository implements PostCategoryRepositoryInterface
{

    protected $model;
    public function __construct(PostCategory $model)
    {
        $this->model = $model;
    }
    public function getPagination($page = 15)
    {
        return PostCategory::paginate($page);
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
                    ->orWhere('meta_title', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_description', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('meta_keyword', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset($condition["publish"]) && $condition['publish'] != 0) {
                $query->where('publish', '=', $condition['publish']);
            }
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }

}