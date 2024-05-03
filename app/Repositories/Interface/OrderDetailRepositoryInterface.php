<?php
namespace App\Repositories\Interface;
interface OrderDetailRepositoryInterface
{

    public function pagination(array $column = ['*'], array $condition = [], array $join = [], array $extend = [], $perPage = 20, array $relations = [], array $order = []);
}
