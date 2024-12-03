<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    //

    protected $fillable = [
        'tenant_id',
        'property_id',
        'contract_code',
        'rent_amount',
        'late_fee',
        'security_deposit_amount',
        'contract_date',
        'start_date',
        'payment_due_day',
        'status',
        'end_date',
        'notice_period',
    ];


    protected $casts = [
        'contract_date' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date', // Cast end_date to date
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

    // MANIPULATORS

      /**
     * Scope to get active contracts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get pending contracts
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get expired contracts
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

}
