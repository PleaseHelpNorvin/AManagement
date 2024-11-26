<?php
// database/seeders/MaintenanceRequestSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MaintenanceRequest;
use App\Models\Property;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User; // Technician model

class MaintenanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get properties, rooms, tenants, and technicians (assuming they already exist)
        $property1 = Property::find(1); // Property 1
        $property2 = Property::find(2); // Property 2
        
        $room1 = Room::find(1); // Room 1
        $room2 = Room::find(2); // Room 2

        $tenant1 = Tenant::find(1); // Tenant 1
        $tenant2 = Tenant::find(2); // Tenant 2

        $technician1 = User::where('role', 'technician')->first(); 
        $technician2 = User::where('role', 'technician')->skip(1)->first();
        
        // Create maintenance requests for Tenant 1
        MaintenanceRequest::create([
            'property_id' => $property1->id,
            'room_id' => $room1->id,
            'tenant_id' => $tenant1->id,
            'description' => 'Leaky faucet in the bathroom',
            'priority' => 'high',
            'status' => 'pending',
            'technician_id' => $technician1->id,
            'completion_date' => null, // Not completed yet
            'remarks' => 'Urgent issue reported.',
        ]);

        MaintenanceRequest::create([
            'property_id' => $property2->id,
            'room_id' => $room2->id,
            'tenant_id' => $tenant2->id,
            'description' => 'Air conditioning not working',
            'priority' => 'medium',
            'status' => 'in_progress',
            'technician_id' => $technician2->id,
            'completion_date' => null, // Not completed yet
            'remarks' => 'Awaiting part replacement.',
        ]);
    }
}
