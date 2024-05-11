<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vol extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaving_from',
        'going_to',
        'departure',   
        'access',
        'stopover',
        'price'
    ];

    // Relation avec la destination de départ
    public function leavingFrom()
    {
        return $this->belongsTo(Destination::class, 'leaving_from');
    }

    // Relation avec la destination d'arrivée
    public function goingTo()
    {
        return $this->belongsTo(Destination::class, 'going_to');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'vol_id');
    }
}
