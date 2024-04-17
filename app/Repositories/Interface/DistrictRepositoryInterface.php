<?php


namespace App\Repositories\Interface;

Interface  DistrictRepositoryInterface {
    public function all();
    public function findDistrictByProvince(int $province_id);
}
?>