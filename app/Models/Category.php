<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function offers()
    {
        return $this->hasMany(Offer::class, 'id_category', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'id_category', 'id');
    }

}
