<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User; // Importing User Model
use App\Models\Property; // Importing Property Model
use App\Models\Tenant;


class MaintenanceRequest extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'property_id', 'title', 'description', 'status'];

    // A maintenance request belongs to a user (tenant)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // public function tenant()
    // {
    //     return $this->belongsTo(Tenant::class); // Corrected the method name to tenant
    // }
}
