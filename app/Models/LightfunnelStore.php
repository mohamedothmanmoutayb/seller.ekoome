<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LightfunnelStore extends Model
{
    use HasFactory;

    
    protected $fillable = ['cursor','account_id','domaine_url','access_token','user_id','country_id','is_active','refresh_token'];

    public function lightfunnelWebhooks()
    {
        return $this->hasMany('App\Models\LightfunnelWebhook');
    }


}
