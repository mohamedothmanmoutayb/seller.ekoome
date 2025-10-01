<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryExpense extends Model
{
    use HasFactory;
  
    protected $fillable = [
        'id_country',
        'id_user',
        'name',
        'description',
        'image'
    ];}
