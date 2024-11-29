<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    //

    protected $fillable = [
        'tenant_id',
        'contract_id', 
        'amount_due', 
        'amount_paid',
        'electric_meter_picture',
        'water_meter_picture',
        'electric_reading',
        'water_reading', 
        'payment_status', 
        'billing_period_start',
         'billing_period_end',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
