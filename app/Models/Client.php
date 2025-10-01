<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_country',
        'id_city',
        'city',
        'name',
        'phone1',
        'phone2',
        'address',
        'seller_note',
    ];

    
    public function country()
    {
        return $this->belongsTo(Countrie::class, 'id_country');
    }
    public function city()
    {
        return $this->belongsTo(Citie::class, 'id_city');
    }
    public function getTotalLeadsAttribute()
    {
        return $this->leads()->count();
    }

    public function getReturnedLeadsAttribute()
    {
        return $this->leads()->where('status_livrison', 'returned')->count();
    }

    public function getDeliveredLeadsAttribute()
    {
        return $this->leads()->where('status_livrison', 'delivered')->count();
    }

    public function getCancelledLeadsAttribute()
    {
        return $this->leads()->where('status_livrison', 'cancelled')->count();
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'client_id');
    }

    public function communications()
    {
        return $this->hasMany(Communication::class);
    }

}
