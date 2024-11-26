<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_name',
        'address',
        'admin_id',
        'is_vacant',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class, 'property_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'property_id');
    }
}
