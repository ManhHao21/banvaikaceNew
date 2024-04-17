<?php
namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\Interface\WardRepositoryInterface;


class WardRepository extends BaseRepository implements WardRepositoryInterface
{

    protected $model;
    public function __construct(Ward $model)
    {
        $this->model = $model;
    }
}