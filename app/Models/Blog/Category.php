<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table  = 'categories';
    protected $fillable = ['name','slug'];


    public function posts(){
        return $this->hasMany('\App\Models\Blog\Post','category_id','id');
    }
}
