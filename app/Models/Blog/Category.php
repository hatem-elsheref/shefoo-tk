<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table  = 'categories';
    protected $fillable = ['name','slug'];

}
