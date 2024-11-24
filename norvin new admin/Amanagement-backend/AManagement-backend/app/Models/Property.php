<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User; // Importing User Model
use App\Models\Payment; // Importing Payment Model
use App\Models\MaintenanceRequest; // Importing MaintenanceRequest Model

class Property extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'unit_name',
        'admin_id',
        'is_vacant',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

}
