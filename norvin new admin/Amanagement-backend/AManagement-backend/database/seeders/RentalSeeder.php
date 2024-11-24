<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Rental;
class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Fetch tenants and assign rentals
        Tenant::all()->each(function ($tenant) {
            $room = $tenant->room; // Assume each tenant is assigned a room
            Rental::create([
                'tenant_id' => $tenant->id,
                'room_id' => $room->id,
                'rent_amount' => $room->price,
                'start_date' => $tenant->start_date,
                'end_date' => $tenant->end_date,
                'status' => 'active',
            ]);
        });
    }
}
