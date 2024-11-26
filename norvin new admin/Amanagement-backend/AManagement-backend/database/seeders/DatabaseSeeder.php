<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Property;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Rental;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Make sure to call the correct seeders
        $this->call([
            UserSeeder::class,
            PropertySeeder::class,
            RoomSeeder::class,
            TenantSeeder::class,
            PaymentSeeder::class,
            MaintenanceRequestSeeder::class,
            RentalSeeder::class,
            // Add more seeders as needed
        ]);
    }
}

