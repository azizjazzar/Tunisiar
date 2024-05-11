<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Destination extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $mediaLibraryCollections = ['flag'];
    protected $mediaLibraryGenerators = ['flag'];

    protected $fillable = [
        'name',
        'abbreviation_name'
    ];

    // Relation avec les vols de départ
    public function leavingFlights()
    {
        return $this->hasMany(Vol::class, 'leaving_from');
    }

    // Relation avec les vols d'arrivée
    public function arrivingFlights()
    {
        return $this->hasMany(Vol::class, 'going_to');
    }
}
