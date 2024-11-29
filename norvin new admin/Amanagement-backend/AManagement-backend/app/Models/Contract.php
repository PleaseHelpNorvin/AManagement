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
        'contract_type',
        'start_date',
        'end_date',
        'rent_amount',
        'security_payment',
        'payment_frequency',
        'payment_due_date',
        'late_fee',
        'total_paid',
        'renewal_date',
        'status',
        'special_terms',
        'is_renewable',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'payment_due_date' => 'datetime',
        'renewal_date' => 'datetime',
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

     // Accessor for full contract status
     public function getContractStatusAttribute()
     {
         return ucfirst($this->status);
     }
 
     // Mutator to ensure 'special_terms' always starts with uppercase
     public function setSpecialTermsAttribute($value)
     {
         $this->attributes['special_terms'] = ucfirst($value);
     }

     
     public function scopeActive($query)
     {
         return $query->where('status', 'active');
     }
 
     // Scope for expired contracts
     public function scopeExpired($query)
     {
         return $query->where('status', 'expired');
     }


}
