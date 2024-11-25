<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Property;
use App\Models\Tenant;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Admin user creation
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('password'), // Securely hash the password
            'role' => 'admin', // Admin role
        ]);

        // Create properties managed by the admin
        $properties = Property::factory(3)->create([
            'admin_id' => $admin->id,
        ]);

        // Tenant user creation with an expired lease (evicted)
        $tenantWithExpiredLease = User::create([
            'name' => 'Expired Lease Tenant',
            'email' => 'expiredtenant@example.com',
            'phone' => '1122334455',
            'password' => Hash::make('password'),
            'role' => 'tenant', // Tenant role
            'lease_start' => now()->subMonths(12), // Lease started 12 months ago
            'lease_end' => now()->subMonths(1),   // Lease ended 1 month ago
        ]);

        // Set the tenant's status to 'evicted'
        $tenantWithExpiredLease->status = $this->getTenantStatus($tenantWithExpiredLease);
        $tenantWithExpiredLease->save();

        // Assign tenant to a room (linked to a property)
        $room = $properties->first()->rooms()->create([
            'name' => 'Room 102',
            'price' => 5000.00, // Example room price
            'is_vacant' => false, // Mark the room as occupied
        ]);

        // Create a Tenant record for the tenant user with expired lease
        Tenant::create([
            'user_id' => $tenantWithExpiredLease->id,
            'room_id' => $room->id,
            'start_date' => now()->subMonths(12),
            'end_date' => now()->subMonths(1), // Lease ended 1 month ago
        ]);

        // Additional tenant users and their corresponding Tenant records
        User::factory(5)->create(['role' => 'tenant'])->each(function ($user) use ($properties) {
            // Assign lease start and end dates
            $leaseStart = now()->subMonths(rand(1, 3)); // Random start date within 1 to 3 months ago
            $leaseEnd = $leaseStart->copy()->addMonths(12); // Lease end is 12 months after start date

            // Assign each tenant user a room and create a corresponding Tenant record
            $room = $properties->random()->rooms()->create([
                'name' => 'Room ' . rand(100, 199), // Example room name
                'price' => 5000.00, // Example room price
                'is_vacant' => false, // Mark the room as occupied
            ]);

            // Create the corresponding Tenant record
            Tenant::create([
                'user_id' => $user->id,
                'room_id' => $room->id,
                'start_date' => $leaseStart,
                'end_date' => $leaseEnd,
            ]);

            // Update the user with lease start and end dates
            $user->update([
                'lease_start' => $leaseStart,
                'lease_end' => $leaseEnd,
            ]);

            // Set the tenant status based on lease dates
            $user->status = $this->getTenantStatus($user);
            $user->save();
        });
    }

    /**
     * Helper function to determine the tenant's status based on lease dates.
     */
    private function getTenantStatus(User $tenant): string
    {
        $now = now();

        if ($tenant->lease_start > $now) {
            return 'not_started'; // Lease hasn't started yet
        } elseif ($tenant->lease_end < $now) {
            return 'evicted'; // Lease has ended
        } else {
            return 'active'; // Lease is active
        }
    }
}
