<?php

namespace Database\Seeders;

use App\Models\MaintenanceRequest;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;


class MaintenanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     */
    public function run(Faker $faker): void
    {
        // Get all tenants and properties
        $technicians = User::where('role', 'technician')->get();
        $tenants = Tenant::all();
        $properties = Property::all();
        // $faker = Faker::create();

        // Ensure there are tenants and properties
        if ($tenants->isEmpty()) {
            echo "No tenants found. Cannot create maintenance requests.\n";
            return;
        } elseif ($properties->isEmpty()) {
            echo "No properties found. Cannot create maintenance requests.\n";
            return;
        } elseif ($technicians->isEmpty()) {
            echo "No technicians found. Cannot assign maintenance requests.\n";
            return;
        }

        // Seed maintenance requests for each tenant
        foreach ($tenants as $tenant) {
            // Pick a random property for the tenant
            $property = $properties->random(); // Randomly select a property from the list
            
            //
            // $technician = $technicians->random();

            // Randomly generate priority and status
            $priority = $faker->randomElement(['low', 'medium', 'high']);
            $status = $faker->randomElement(['open', 'closed', 'in-progress']);

            // Generate a random maintenance request description
            $description = $faker->sentence(6, true); // A random sentence as the description
            
            // Generate the reported_at and resolved_at dates
            $reportedAt = $faker->dateTimeThisYear(); // Random date within the current year
            $resolvedAt = $status == 'closed' ? $faker->dateTimeBetween($reportedAt, 'now') : null; // If status is 'closed', set a resolved date

            // Create the maintenance request record
            MaintenanceRequest::create([
                'technician_id' =>null,
                'tenant_id' => $tenant->id,  // Associate the request with the tenant
                'property_id' => $property->id,  // Associate with the property
                'maintenance_picture_url' => $faker->imageUrl(150,150),
                'priority' => $priority, // Random priority
                'description' => $description, // Description for the maintenance issue
                'status' => 'open', // Random status (open, closed, in-progress)
                'reported_at' => $reportedAt, // Date when the issue was reported
                'resolved_at' => $resolvedAt, // Only set if the status is 'closed'
            ]);
        }
    }
}
