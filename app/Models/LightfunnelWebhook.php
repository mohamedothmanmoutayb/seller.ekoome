<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LightfunnelWebhook extends Model
{

    use HasFactory;

    protected $fillable = ['webhook_event', 'url', 'lightfunnel_store_id'];

    public function lightfunnelStore()
    {
        return $this->belongsTo('App\Models\LightfunnelStore');
    }
}
