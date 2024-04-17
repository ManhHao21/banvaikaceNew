<?php
namespace App\Repositories;

use App\Models\UserCatelogue;
use App\Repositories\Interface\UserCatelogueRepositoryInterface;


class UserCatelogueRepository extends BaseRepository implements UserCatelogueRepositoryInterface
{

    protected $model;
    public function __construct(UserCatelogue $model)
    {
        $this->model = $model;
    }
    public function getPagination($page = 15)
    {
        return UserCatelogue::paginate($page);
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
                $query->where('name', 'like', '%' . $condition['keyword'] . '%');
            }
        });
        if (isset($condition["publish"]) && $condition['publish'] != 0) {
            $query->where('publish', '=', $condition['publish']);
        }
        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
    public function findById(int $modelId, array $column = ['*'], array $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }
}