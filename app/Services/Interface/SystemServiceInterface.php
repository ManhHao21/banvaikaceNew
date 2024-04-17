<?php


namespace App\Services\Interface;

interface SystemServiceInterface
{
    // public function getAllPagenate();
    public function created($request);
    public function update($id, $request);
    public function paginate($request);
}
?>