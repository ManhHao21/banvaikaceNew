<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SinglePage extends Model
{
    use HasFactory;
    protected $table = 'single_page';
    protected $fillable = [
        'title',
        'image',
        'short_description',
        'description',
        'content',
        'publish',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
}
