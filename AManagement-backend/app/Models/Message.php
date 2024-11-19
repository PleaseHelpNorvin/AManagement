<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Model\User;

class Message extends Model
{
    //
    use HasFactory;
    protected $table = 'messages';  

    protected $fillable = [
        'message', // Match the column name in the migration
        'sender_id',
        'receiver_id',
        'is_read',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
