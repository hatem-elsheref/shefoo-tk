<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded=[];
    protected $table='groups';

    public function permissions(){
        return $this->belongsToMany(Permission::class,'group_permissions','group','permission');
    }
    public function admins(){
        return $this->hasMany(Admin::class,'group','id');
    }
}
