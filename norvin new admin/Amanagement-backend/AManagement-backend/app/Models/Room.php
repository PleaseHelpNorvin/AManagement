<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Room extends Model
{ 
    use HasFactory;

    //
    protected $fillable = [
        'name',
        'property_id',
        'price',
        'is_vacant',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->hasMany(Tenant::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
