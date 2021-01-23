<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table  = 'tags';
    protected $fillable = ['name','slug'];

    public function posts(){
        return $this->belongsToMany('\App\Models\Blog\Post','post_tags','tag_id','post_id');
    }
}
