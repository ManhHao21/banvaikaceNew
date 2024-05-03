<?php


namespace App\Repositories\Interface;

interface BaseRepositoryInterface
{
    public function pagination(
        array $column = ['*'],
        array $condition = [],
        array $join = [],
        array $extend = [],
        $perPage = 20,
        array $relations = [],
        array $order = []

    );
    public function getAll();
    public function create(array $dataRequest = []);
    public function updated(int $id = 0, array $payload = []);
    public function updateByWhereIn(string $whereInField = '', array $whereIn = [], array $payload = []);
    public function deleted($id);

    public function getFirstById($id, array $column = ['*']);
    public function getCondition($slug, array $column = ['*'],  array $relation = []);
    public function getDatabyWhere(string $whereInField = '', array $whereIn = []);
    public function insert(array $attributes);
}
?>
