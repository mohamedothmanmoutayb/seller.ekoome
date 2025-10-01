<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaigneData extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function country()
    {
        return $this->belongsTo(Countrie::class, 'id_country');
    }

    public function scenarios()
    {
        return $this->hasMany(Scenario::class, 'id_campaigne');
    }



}
