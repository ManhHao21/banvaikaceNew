<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'content',
        'product_id'
    ];

    public function Product(){
        return $this->belongsTo(Product::class);
    }
}
