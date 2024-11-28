<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Property;
use App\Models\Room;
use App\Models\contract;
use App\Models\Tenant;
use App\Models\Billing;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\Message;
use App\Models\Notification;
// use App\Models\;

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
            UserProfileSeeder::class,
            PropertySeeder::class,
            RoomSeeder::class,
            ContractSeeder::class,
            TenantSeeder::class,
            BillingSeeder::class,
            PaymentSeeder::class,
            MaintenanceRequestSeeder::class,
            MessageSeeder::class,
            NotificationSeeder::class,
            // Add more seeders as needed
        ]);
    }
}

