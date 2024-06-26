<?php
namespace App\Repositories;

use App\Models\Province;
use App\Repositories\Interface\ProvinceRepositoryInterface;


class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{

    protected $model;
    public function __construct(Province $model)
    {
        $this->model = $model;
    }
}git push gitlab --all
