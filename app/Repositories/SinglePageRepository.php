<?php
namespace App\Repositories;

use App\Models\SinglePage;
use App\Repositories\Interface\SinglePageRepositoryInterface;


class SinglePageRepository extends BaseRepository implements SinglePageRepositoryInterface
{

    protected $model;
    public function __construct(SinglePage $model)
    {
        $this->model = $model;
    }
    public function getPagination($page = 15)
    {
        return SinglePage::paginate($page);
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
                    ->orWhere('email', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('address', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('phone', 'LIKE', '%' . $condition['keyword'] . '%');
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