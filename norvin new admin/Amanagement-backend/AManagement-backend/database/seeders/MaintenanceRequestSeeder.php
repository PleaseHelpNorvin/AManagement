<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MaintenanceRequest;
use App\Models\Property;


class MaintenanceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Property::all()->each(function ($property) {
            MaintenanceRequest::create([
                'user_id' => $property->admin_id, // Admin user
                'property_id' => $property->id,
                'title' => 'Leaking faucet',
                'description' => 'The kitchen faucet has been leaking for a few days.',
                'status' => 'open',
            ]);
        });
    }
}
