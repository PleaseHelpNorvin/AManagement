<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Rental extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'tenant_id',
        'room_id',
        'rent_amount',
        'start_date',
        'end_date',
        'status',
        // 'payment_status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
