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
        'unit_name', 'is_vacant'
    ];

       // A property has many rooms
       public function rooms()
       {
           return $this->hasMany(Room::class);
       }
   
       // A property has many tenants (through the rentals)
       public function tenants()
       {
           return $this->belongsToMany(User::class, 'rentals');
       }
   
       // A property can have many maintenance requests
       public function maintenanceRequests()
       {
           return $this->hasMany(MaintenanceRequest::class);
       }
   
       // A property can have many payments
       public function payments()
       {
           return $this->hasMany(Payment::class);
       }

}
