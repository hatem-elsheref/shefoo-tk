<?php

namespace App\Models\Blog;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table  = 'tags';
    protected $fillable = ['name','slug'];
}
