<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nbr_place',
        'vol_id',
        'user_id',   
        'price'    
    ];

    public function vol()
    {
        return $this->belongsTo(Vol::class, 'vol_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
{
    return $this->hasOne(Payment::class);
}
}
