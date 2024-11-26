<?php
// database/seeders/TenantSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\User;
// use App\Models\Property;
use App\Models\Room;
use Carbon\Carbon; // Import Carbon for date handling

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get users
        $tenant1User = User::where('email', 'tenant1@example.com')->first();
        $tenant2User = User::where('email', 'tenant2@example.com')->first();

        // Get properties
        $Room1 = Room::find(1); // Apartment 101
        $Room2 = Room::find(2); // Apartment 102

        // Generate random 6-digit tenant codes
        $tenantCode1 = mt_rand(100000, 999999); // Random 6-digit number for Tenant 1
        $tenantCode2 = mt_rand(100000, 999999); // Random 6-digit number for Tenant 2

        // Create tenants for Property 1
        Tenant::create([
            'tenant_code' => $tenantCode1, // Assign random 6-digit tenant code
            'user_id' => $tenant1User->id, // Link to tenant 1 user
            'room_id' => $Room1->id, // Link to Property 1
            'lease_start' => Carbon::now(), // Lease start date
            'deposit_amount' => 1000, // Example deposit amount
            'monthly_rent' => 500, // Example monthly rent
            'lease_end' => Carbon::now()->addYear(1), // Lease ends in 1 year
            'status' => 'active', // Tenant status
        ]);

        // Create tenants for Property 2
        Tenant::create([
            'tenant_code' => $tenantCode2, // Assign random 6-digit tenant code
            'user_id' => $tenant2User->id, // Link to tenant 2 user
            'room_id' => $Room2->id, // Link to Property 2
            'lease_start' => Carbon::now(), // Lease start date
            'deposit_amount' => 1200, // Example deposit amount
            'monthly_rent' => 600, // Example monthly rent
            'lease_end' => Carbon::now()->addYear(1), // Lease ends in 1 year
            'status' => 'active', // Tenant status
        ]);
    }
}
