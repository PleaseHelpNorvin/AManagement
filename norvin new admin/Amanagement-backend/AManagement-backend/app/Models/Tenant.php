<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_code',
        'user_id',
        'room_id',
        'lease_start',
        'deposit_amount',
        'monthly_rent',
        'lease_end',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function rental()
    {
        return $this->hasMany(Rental::class, 'tenant_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
    }
}
