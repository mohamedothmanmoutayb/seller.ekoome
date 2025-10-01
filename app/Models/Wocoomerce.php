<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Wocoomerce extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function seller()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
