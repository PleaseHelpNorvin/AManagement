<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{ 
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'is_vacant',
        'property_id',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Relationship with Rental: A Room can have multiple Rentals
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
