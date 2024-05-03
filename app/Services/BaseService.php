<?php

namespace App\Services;

use Carbon\Carbon;
use App\Services\Interface\BaseServiceInterface;

class BaseService
{
    public function convertImage($image, $dir = null)
    {
        $path = $image->store($dir ?? 'image');
        return $path;
    }

    public function convertBirthday($birthday = '')
    {
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday = $dateCarbon->format('Y-m-d H:i:s');
        return $birthday;
    }
}
