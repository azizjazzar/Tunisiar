<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model

{
    use HasApiTokens , HasFactory , Notifiable ;

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true; // Indique que Laravel gère automatiquement les timestamps

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clientType',
        'officeId',
        'currency',
        'corporateCode',
        'emissionCode',
        'organizationName',
        'taxIdentificationNumber',
        'owner',
        'address',
        'phoneNumber1',
        'phoneNumber2',
        'fax',
        'email',
        'officeIdQueue',
        'active',
        'logoUrl',
        
    ];
     
    
    
}
