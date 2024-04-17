<?php
namespace App\Repositories;

use App\Models\District;
use App\Repositories\Interface\DistrictRepositoryInterface;


class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{

    protected $model;
    public function __construct(District $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function findDistrictByProvince(int $province_id = 0)
    {
        return $this->model->where('province_code', '=', $province_id)->get();

    }
}