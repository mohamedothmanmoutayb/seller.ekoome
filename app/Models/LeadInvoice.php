<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadInvoice extends Model
{
    use HasFactory;
    
    public function Lead()
    {
        return $this->hasMany('App\Models\Lead','id','id_lead');
    }
}
