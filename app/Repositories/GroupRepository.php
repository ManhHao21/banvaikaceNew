<?php
namespace App\Repositories;

use App\Models\District;
use App\Models\Group;
use App\Repositories\Interface\GroupRepositoryInterface;


class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{

    protected $model;
    public function __construct(Group $model)
    {
        $this->model = $model;
    }
}