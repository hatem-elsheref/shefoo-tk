<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;


class Admin extends Authenticatable
{

    protected $guarded=[];
    protected $table='admins';

    public function adminGroup(){
        return $this->belongsTo(Group::class,'group','id');
    }
}
