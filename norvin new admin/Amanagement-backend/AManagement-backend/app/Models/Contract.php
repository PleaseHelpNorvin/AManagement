<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    //

    protected $fillable = [
        'tenant_id', 'property_id', 'contract_type', 'start_date', 'end_date', 'rent_amount', 'security_deposit', 'payment_due_date', 'status',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function billings()
    {
        return $this->hasMany(Billing::class);
    }
}
