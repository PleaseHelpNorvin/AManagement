<?php
// database/seeders/PaymentSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get tenants (assuming tenants already exist)
        $tenant1 = Tenant::find(1); // Tenant 1
        $tenant2 = Tenant::find(2); // Tenant 2

        // Create payments for Tenant 1
        Payment::create([
            'tenant_id' => $tenant1->id, // Link to Tenant 1
            'amount' => 500, // Payment amount
            'status' => 'paid', // Payment status
            'due_date' => Carbon::now()->addMonth(1), // Due date is 1 month from now
        ]);

        Payment::create([
            'tenant_id' => $tenant1->id, // Link to Tenant 1
            'amount' => 500, // Payment amount
            'status' => 'pending', // Payment status
            'due_date' => Carbon::now()->addMonth(2), // Due date is 2 months from now
        ]);

        // Create payments for Tenant 2
        Payment::create([
            'tenant_id' => $tenant2->id, // Link to Tenant 2
            'amount' => 600, // Payment amount
            'status' => 'paid', // Payment status
            'due_date' => Carbon::now()->addMonth(1), // Due date is 1 month from now
        ]);

        Payment::create([
            'tenant_id' => $tenant2->id, // Link to Tenant 2
            'amount' => 600, // Payment amount
            'status' => 'pending', // Payment status
            'due_date' => Carbon::now()->addMonth(2), // Due date is 2 months from now
        ]);
    }
}
