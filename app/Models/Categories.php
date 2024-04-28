<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'publish',
        'image'
    ];
    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id', 'id');
    }
    

    public function Product()
    {
        return $this->hasMany(Product::class, 'categories_id', 'id');
    }
}
