<?php


namespace App\Services\Interface;

interface SinglePageServiceInterface
{
    public function created($request);
    public function updated($id, $request);
    public function paginate($request);
    public function updateStatus(array $post = []);
    public function updateStatusAll(array $post = []);
}
?>