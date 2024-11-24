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
        // Create Users
        $user1 = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $user2 = User::create([
            'name' => 'Tenant User 1',
            'email' => 'tenant1@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
        ]);

        $user3 = User::create([
            'name' => 'Tenant User 2',
            'email' => 'tenant2@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tenant',
        ]);

        // Create Properties for each user
        $user1->properties()->create([
            'unit_name' => 'saac 1 buaya 123 1101.',
            'is_vacant' => true,
        ]);

        $user2->properties()->create([
            'unit_name' => '456 Tenant 1 St.',
            'is_vacant' => false,
        ]);

        $user3->properties()->create([
            'unit_name' => '789 Tenant 2 St.',
            'is_vacant' => true,
        ]);

        // Create Payments for each user
        $user1->payments()->create([
            'amount' => 500,
            'payment_date' => now(),
            'payment_method' => 'credit_card',
        ]);

        $user2->payments()->create([
            'amount' => 300,
            'payment_date' => now(),
            'payment_method' => 'bank_transfer',
        ]);

        $user3->payments()->create([
            'amount' => 350,
            'payment_date' => now(),
            'payment_method' => 'paypal',
        ]);

        // Create Maintenance Requests for each user
        $user1->maintenanceRequests()->create([
            'issue' => 'Broken pipe in the bathroom',
            'status' => 'pending',
        ]);

        $user2->maintenanceRequests()->create([
            'issue' => 'Faulty air conditioning',
            'status' => 'in_progress',
        ]);

        // Create Messages between users (many-to-many)
        // Assuming the Message model has a user-to-user relation setup
        $user1->messages()->create([
            'message' => 'Hello Tenant 1, welcome!',
            'receiver_id' => $user2->id,
            'is_read' => true,
        ]);

        $user2->messages()->create([
            'message' => 'Hello Tenant 2, welcome!',
            'receiver_id' => $user3->id,
            'is_read' => false,
        ]);
    }
}
