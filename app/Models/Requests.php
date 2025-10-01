<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function offer()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function country()
    {
        return $this->belongsTo(Countrie::class, 'id_country','id');
    }
}
