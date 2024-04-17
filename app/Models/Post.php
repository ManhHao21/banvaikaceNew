<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable = [
        'title',
        'image',
        'short_description',
        'description',
        'category_post_id',
        'content',
        'publish',
        'slug',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];
    public function PostCategory()
    {
        return $this->belongsTo(PostCategory::class, 'category_post_id', 'id');
    }
}
