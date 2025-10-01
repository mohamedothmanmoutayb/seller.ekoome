<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = ['phone','seller_id', 'state', 'context','language'];

    public function seller()
    {
        return $this->belongsTo(User::class);
    }
}
