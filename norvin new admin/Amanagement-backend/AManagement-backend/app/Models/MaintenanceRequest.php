<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User; // Importing User Model
use App\Models\Property; // Importing Property Model

class MaintenanceRequest extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'property_id', 'title', 'description', 'status'];

    // A maintenance request belongs to a user (tenant)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A maintenance request belongs to a property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
