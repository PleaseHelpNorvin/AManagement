<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    //
    protected $fillable = ['tenant_id', 'property_id', 'rent_amount', 'start_date', 'end_date', 'status'];

    // A rental belongs to a tenant (user)
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    // A rental belongs to a property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
