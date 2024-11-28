<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id', 'payment_date', 'amount_paid', 'payment_method', 'status', 'transaction_id',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
