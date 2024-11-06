<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\User;


class ClientInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'middlename',
        'lastname',
        'gender',
        'address',
        'contact_number',
        // 'gcash_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

