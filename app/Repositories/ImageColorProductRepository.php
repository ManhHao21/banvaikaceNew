<?php
namespace App\Repositories;

use App\Models\Image_color_product;
use App\Repositories\Interface\ImageColorProductRepositoryInterface;


class ImageColorProductRepository extends BaseRepository implements ImageColorProductRepositoryInterface
{

    protected $model;
    public function __construct(Image_color_product $model)
    {
        $this->model = $model;
    }
}
