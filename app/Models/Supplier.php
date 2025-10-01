<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public function ScopeTotalPayment($query,$id)
    {
        $total = Import::where('supplier_id',$id)->sum('price');
        
        return $total ?? 0;
    }

    public function ScopeTotalDue($query,$id)
    {
        $total = Import::where('supplier_id',$id)->sum('price');

        return $total ?? 0 ;
    }
}
