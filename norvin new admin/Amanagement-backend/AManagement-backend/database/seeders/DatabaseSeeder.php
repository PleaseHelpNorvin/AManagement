<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RentalSeeder::class,
            PaymentSeeder::class,
            MaintenanceRequestSeeder::class,
            MessageSeeder::class,
            NotificationSeeder::class,
        ]);
    }
}
