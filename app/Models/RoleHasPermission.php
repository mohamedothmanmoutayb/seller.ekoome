<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    use HasFactory;
    
    
    public function permission()
    {
        return $this->hasMany('App\Models\Permission','id','permission_id');
    }
}
