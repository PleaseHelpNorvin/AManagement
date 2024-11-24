<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User; // Importing User Model


class Notification extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'data', 'is_read'
    ];

    // Define relationship to User (Receiver)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
