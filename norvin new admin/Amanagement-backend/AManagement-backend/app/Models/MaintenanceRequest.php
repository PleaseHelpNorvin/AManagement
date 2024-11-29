<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'priority','technician_id', 'tenant_id', 'property_id', 'maintenance_picture_url', 'description', 'status', 'reported_at', 'resolved_at',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
