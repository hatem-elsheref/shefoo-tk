<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded=[];
    protected $table='permissions';

    public function groups(){
        return $this->belongsToMany(Group::class,'group_permissions','permission','group');
    }
}
