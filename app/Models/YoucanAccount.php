<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YoucanAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'password',
        'account_token',
        'token_type',
        'is_staff',
        'expired_at'
    ];

    protected $casts = [
        'is_staff' => 'boolean',
        'expired_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stores()
    {
        return $this->hasMany(YoucanStore::class, 'account_id');
    }
}