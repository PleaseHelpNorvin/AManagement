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

    // Tenant user creation
    $tenant = User::create([
        'name' => 'John Doe',
        'email' => 'tenant@example.com',
        'phone' => '0987654321',
        'password' => Hash::make('password'),
        'role' => 'tenant', // Tenant role
        'lease_start' => now()->subMonths(1),
        'lease_end' => now()->addMonths(11),
    ]);

    // Assign tenant to a room (linked to a property)
    $room = $properties->first()->rooms()->create([
        'name' => 'Room 101',
        'price' => 5000.00, // Example room price
        'is_vacant' => false, // Mark the room as occupied
    ]);

    // Create a Tenant record for the tenant user
    Tenant::create([
        'user_id' => $tenant->id,
        'room_id' => $room->id,
        'start_date' => now()->subMonths(1),
        'end_date' => now()->addMonths(11),
    ]);

    // Additional tenant users and their corresponding Tenant records
    User::factory(5)->create(['role' => 'tenant'])->each(function ($user) use ($properties) {
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
            'start_date' => now()->subMonths(1),
            'end_date' => now()->addMonths(11),
        ]);
    });
}

}
