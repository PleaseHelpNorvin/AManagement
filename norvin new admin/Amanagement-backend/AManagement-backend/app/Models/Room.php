<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = ['name', 'property_id', 'price', 'is_vacant'];

    // A room belongs to a property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    // A room can have many tenants (through rentals)
    public function tenants()
    {
        return $this->belongsToMany(User::class, 'rentals', 'room_id', 'tenant_id');
    }
}
