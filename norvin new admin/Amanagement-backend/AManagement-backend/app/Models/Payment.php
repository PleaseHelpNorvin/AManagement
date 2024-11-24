<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User; // Importing User Model
use App\Models\Property; // Importing Property Model

class Payment extends Model
{
    //
    use HasFactory;

    protected $fillable = ['tenant_id', 'property_id', 'amount', 'status', 'due_date'];


    // A payment belongs to a tenant
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    // A payment belongs to a property
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
