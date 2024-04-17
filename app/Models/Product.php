<?php

namespace App\Models;

use App\Models\Material;
use App\Models\Categories;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'price',
        'categories_id',
        'description',
        'image',
        'material_id',
        'gms',
        'seller',
        'publish',
        'user_id',
        'is_hot',
        'is_Sale',
        'top_view',
    ];

    public function category()
    {
        return $this->hasOne(Categories::class, 'categories_id', 'id');
    }
    public function material()
    {
        return $this->hasMany(Material::class, "material_id", "id");
    }

    public function getImage(Product $product)
    {
        return $this->asset("storage/product/image/" . $product->image);
    }

    public function Comments()
    {
        return $this->hasMany(Comment::class, "product_id", "id");
    }
}
