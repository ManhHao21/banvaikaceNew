<?php
namespace App\Repositories\Interface;
interface PostCategoryRepositoryInterface
{
    public function getPagination($page);
    public function findBySlug($request, $slug);
}
?>