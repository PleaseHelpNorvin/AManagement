<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use App\Models\Room;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initialize Faker instance for generating random data
        $faker = Faker::create();

        // Fetch users with 'tenant' role
        $users = User::where('role', 'tenant')->get();

        // Ensure there are users to seed tenants
        if ($users->isEmpty()) {
            echo "No tenant users found.\n";
            return;
        }

        // Loop through users and create tenants
        foreach ($users as $user) {
            // Randomly select a room for each tenant
            $room = Room::inRandomOrder()->first();

            Tenant::create([
                'user_id' => $user->id,  // Link tenant to user
                'lease_start_date' => $faker->date(),
                'lease_end_date' => $faker->date(),
                'room_id' => $room->id,  // Assign a random room to tenant
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }
}
