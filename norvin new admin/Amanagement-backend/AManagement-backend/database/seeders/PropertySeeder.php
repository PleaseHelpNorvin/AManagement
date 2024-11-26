<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Add this line to import the User model
use App\Models\Property;


class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ensure that users are already created before properties
        $admin1 = User::find(1); // Get admin by ID
        $admin2 = User::find(2); // Get another admin

        // Create Properties
        Property::create([
            'unit_name' => 'Apartment 101',
            'address' => '123 Main St, City, Country',
            'admin_id' => $admin1->id, // Link to existing admin
            'is_vacant' => true,
        ]);

        Property::create([
            'unit_name' => 'Apartment 102',
            'address' => '456 Elm St, City, Country',
            'admin_id' => $admin2->id, // Link to another admin
            'is_vacant' => false,
        ]);

        // Additional seeding for rooms, tenants, payments, etc.
    }
}
