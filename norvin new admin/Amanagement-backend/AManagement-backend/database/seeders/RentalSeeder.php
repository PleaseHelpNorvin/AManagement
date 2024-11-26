<?php
// database/seeders/RentalSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rental;
use App\Models\Tenant;
use Carbon\Carbon;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tenant1 = Tenant::find(1);
        $tenant2 = Tenant::find(2);
        

        // Create rental records for Tenant 1
        Rental::create([
            'tenant_id' => $tenant1->id,
            'room_id' => $tenant1->room_id,
            'rent_amount' => 1000.00,
            'start_date' => Carbon::now()->subMonths(3),
            'end_date' => Carbon::now()->addMonths(9),
            'status' => 'active', // Active, expired, etc.
        ]);

        // Create rental records for Tenant 2
        Rental::create([
            'tenant_id' => $tenant2->id,
            'room_id' => $tenant2->room_id,
            'start_date' => Carbon::now()->subMonths(1),
            'end_date' => Carbon::now()->addMonths(11),
            'rent_amount' => 1200.00,
            'status' => 'active',
        ]);
    }
}
