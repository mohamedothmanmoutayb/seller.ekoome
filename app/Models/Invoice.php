<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function leadinvoice()
    {
        return $this->hasMany('App\Models\LeadInvoice','id_invoice','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','id_user','id');
    }
    
    public function seller()
    {
        return $this->hasone('App\Models\User','id','id_user');
    }

    public function lastinvoice()
    {
        return $this->hasone('App\Models\LastInvoice','id_invoice','id');
    }

    
}
