<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;
    protected $table = "material";
    protected $fillable = ['name', 'des', 'publish'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'material_id', 'id');
    }


}
