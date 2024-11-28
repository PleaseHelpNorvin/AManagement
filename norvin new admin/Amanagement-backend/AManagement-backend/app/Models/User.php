<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\MaintenanceRequest;
use App\Models\Message;
use App\Models\Notification;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    const ADMIN = 'admin';
    const TENANT = 'tenant';
    const TECHNICIAN = 'technician';

    protected $fillable = [
        'name', 
        'email', 
        'phone', 
        'password', 
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'lease_start' => 'date',
            'lease_end' => 'date',
        ];
    }

    // Relationships
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'tenant_id');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
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

    // Role checkers
    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN;
    }

    public function isTenant(): bool
    {
        return $this->role === self::TENANT;
    }

    public function isTechnician(): bool
    {
        return $this->role === self::TECHNICIAN;
    }

    // General role checker (optional)
    public function isRole(string $role): bool
    {
        return $this->role === $role;
    }
}
