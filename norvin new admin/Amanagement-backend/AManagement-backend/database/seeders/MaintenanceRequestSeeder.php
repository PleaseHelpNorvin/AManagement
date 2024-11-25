<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder; // Import Seeder class
use App\Models\Tenant;
use App\Models\MaintenanceRequest;
use Faker\Generator as Faker;

class MaintenanceRequestSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        // Get all tenants or select a random tenant
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            // Create a random maintenance request for each tenant
            MaintenanceRequest::create([
                'tenant_id' => $tenant->id,  // Link to tenant
                'property_id' => $tenant->room->property_id,
                'user_id' => $tenant->user->id,  // Link to the user associated with the tenant
                'title' => $faker->sentence,  // Generate a random title for the request
                'description' => $faker->sentence,
                'status' => $faker->randomElement(['open', 'closed']),  // Valid values

                // Add other fields as necessary
            ]);
        }
    }
}
