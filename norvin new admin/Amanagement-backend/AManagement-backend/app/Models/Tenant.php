<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    //
    protected $fillable = ['start_date', 'end_date'];

    // A tenant is a user renting a room
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // A tenant rents a room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

}
