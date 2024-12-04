<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractSetting extends Model
{
    //
    protected $fillable = ['late_fee_percentage', 'security_deposit_percentage'];
}
