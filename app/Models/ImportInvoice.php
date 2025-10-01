<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportInvoice extends Model
{
    use HasFactory;

    public function import()
    {
        return $this->hasMany('App\Models\Import','id','id_import');
    }
}
