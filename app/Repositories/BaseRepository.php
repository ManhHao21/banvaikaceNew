<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Interface\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function updateOrInsert(array $payload = [], array $condition = [])
    {
        return $this->model->updateOrInsert($condition, $payload);
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function pagination(array $column = ['*'], array $condition = [], array $join = [], array $extend = [], $perPage = 20, array $relations = [], array $order = [])
    {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'like', '%' . $condition['keyword'] . '%');
            }
        });
        if (isset($condition['publish']) && $condition['publish'] != 0) {
            $query->where('publish', '=', $condition['publish']);
        }
        if (isset($relations) && !empty($relations)) {
            foreach ($relations as $key => $relation) {
                $query->withCount($relation);
            }
        }
        if (!empty($join)) {
            $query->join(...$join);
        }
        $query->orderBy('id', $order);
        return $query
            ->paginate($perPage)
            ->withQueryString()
            ->withPath(env('APP_URL') . $extend['path']);
    }
    public function create(array $dataRequest = [])
    {
        $model = $this->model->create($dataRequest);
        return $model->fresh();
    }
    public function updated(int $id = 0, array $payload = [])
    {
        $model = $this->findById($id);
        return $model->update($payload);
    }

    public function updateByWhereIn(string $whereInField = '', array $whereIn = [], array $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }
    public function deleted($id, $file = false)
    {
        $admin = $this->model->find($id);
        if ($admin) {
            if ($file) {
                dd($admin->image);
                $imagePaths = json_decode($admin->image, true);
                if (count($imagePaths) > 1) {
                    foreach ($imagePaths as $key => $value) {
                        if (Storage::exists($value)) {
                            Storage::delete($value);
                        }
                    }
                } else {
                    Storage::delete($admin->image);
                }
            }
            return $admin->delete();
        }
        return false;
    }

    public function findById(int $modelId, array $column = ['*'], array $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelId);
    }

    public function getCondition($slug, array $column = ['*'],  array $relation = [])
    {
        return $this->model->select($column)->with($relation)->where('slug', $slug)->first();
    }
    public function getFirstById($id, array $column = ['*'])
    {
        return $this->model->select($column)->where('id', $id)->first();
    }
    public function insert(array $attributes)
    {
        return $this->model->insert($attributes);
    }
}
