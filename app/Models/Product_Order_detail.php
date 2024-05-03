<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product_Order_detail extends Model
{
    use HasFactory;
    protected $table = 'product_order_detail';
    protected $fillable = ['product_id', 'order_detail', 'quantity'];
}
