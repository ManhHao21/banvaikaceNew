<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Admin;
use App\Repositories\Interface\AdminRepositoryInterface;


class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{

    protected $model;
    public function __construct(Admin $model)
    {
        $this->model = $model;
    }
    public function getPagination($page = 15)
    {
        return User::paginate($page);
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
        });
        if (!empty($join)) {
            $query->join(...$join);
        }
        return $query->paginate($perPage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }

}