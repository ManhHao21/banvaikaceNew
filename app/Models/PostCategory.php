<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;
    protected $table = 'category_post';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'publish'
    ];

    public function Parent_id()
    {
        return $this->hasMany(PostCategory::class, 'parent_id', 'id');
    }
    public function childrent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id', 'id');
    }

    public function Posts()
    {
        return $this->hasMany(Post::class, 'category_post_id', 'id');
    }
}
