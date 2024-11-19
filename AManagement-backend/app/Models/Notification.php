<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    //.
    use HasFactory;

    protected $table = 'notifications';

    // Fields that can be mass-assigned
    protected $fillable = [
        'user_id',
        'content',
        'read_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsReadAttribute()
    {
        return !is_null($this->read_at);
    }
}
