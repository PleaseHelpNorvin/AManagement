<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_logged_in',
        // 'is_idle',
        'last_active_at',
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
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_active_at' => 'datetime'
    ];

    public function isAdmin(){
        return $this->role === 1;
    }

    
    public function isUser(){
        return $this->role === 0;
    }

    public function revokeAllTokens()
    {
        $this->tokens->each(function ($token) {
            $token->delete();
        });
    }

    // public function revokeAdminTokens()
    // {
    //     if ($this->isAdmin()) {
            
    //        $this->token()->where('tokenable_id', $this->id)->delete();
    //         //If you only want to clear the authentication token (e.g., authToken) and retain other session data, you should call Session::forget('authToken') instead.
           
    //         // Session::forget('authToken');
    //     }
    // }
    public function revokeAdminTokenById($userId)
    {
        // Find the user by ID
        $user = self::find($userId);

        // Check if the user exists and is an admin
        if ($user && $user->isAdmin()) {
            // Revoke all tokens for the admin user
            $user->tokens()->delete();
        }
    }
}
