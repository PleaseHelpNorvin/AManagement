<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Models\User; // Importing User Model
use App\Models\Tenant;
use App\Models\Property; // Importing Property Model

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'room_id',
        'amount',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date', // Cast due_date to date type
    ];

    /**
     * Get the tenant that owns the payment.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class); // Relation with Tenant model
    }

    /**
     * Get the room associated with the payment.
     */
    public function room()
    {
        return $this->belongsTo(Room::class); // Relation with Room model
    }
}
