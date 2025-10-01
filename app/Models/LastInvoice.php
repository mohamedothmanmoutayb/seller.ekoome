<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastInvoice extends Model
{
    use HasFactory;

    public function invoice()
    {
        return $this->hasMany('App\Models\Invoice','id','id_invoice_negative');
    }

    public function invoic()
    {
        return $this->hasOne('App\Models\Invoice','id','id_invoice_negative');
    }
}
