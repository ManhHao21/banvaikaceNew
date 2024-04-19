<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image_color_product extends Model
{
    use HasFactory;
    protected $table = 'image_color_product';
    protected $fillable = [
        'product_id',
        'image_color'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'product_id', 'id');
    }
}
