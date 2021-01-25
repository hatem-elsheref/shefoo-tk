<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $fillable = [
        'admin_id',
        'category_id',
        'title',
        'slug',
        'meta',
        'content',
        'image',
        'status',
        'views',
        'comments'
    ];

    public function tags(){
        return $this->belongsToMany('\App\Models\Blog\Tag','post_tags','post_id','tag_id');
    }
    public function category(){
        return $this->belongsTo('\App\Models\Blog\Category','category_id','id');
    }

    public function admin(){
        return $this->belongsTo('\App\Models\Admin','admin_id','id');
    }

    public function postTags(){
        return $this->tags->pluck('id')->toArray();
    }

}
