<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Property; // Importing Property Model
use App\Models\Payment;  // Importing Payment Model
use App\Models\MaintenanceRequest; // Importing MaintenanceRequest Model
use App\Models\Message; // Importing Message Model
use App\Models\Room;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',           // This column was missing in your seeder, but you should add it here
        'lease_start',
        'lease_end',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'lease_start' => 'date',
            'lease_end' => 'date',
        ];
    }

    //relations
    // A user can have many payments (if they are tenants)
    public function properties()
    {
        return $this->hasMany(Property::class, 'admin_id');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function tenant()
    {
        return $this->hasOne(Tenant::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
}