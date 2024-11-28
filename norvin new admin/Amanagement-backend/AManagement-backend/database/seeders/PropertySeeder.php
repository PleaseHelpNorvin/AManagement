<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     */
    public function run(Faker $faker): void
    {
        // Get a user with the 'admin' role (assuming 'role' column exists)
        $adminUser = User::where('role', 'admin')->first();

        // Ensure we have an admin user
        if ($adminUser) {
            // Seed 10 properties with Faker
            foreach (range(1, 10) as $index) {
                Property::create([
                    'owner_id' => $adminUser->id,  // Set the owner_id to the admin user's id
                    'name' => $faker->word,        // Random property name
                    'address' => $faker->address,  // Random address
                    'city' => $faker->city,        // Random city
                    'postal_code' => $faker->postcode,  // Random postal code
                    'type' => $faker->randomElement(['apartment','house','boarding-house']),  // Random property type
                    'status' => $faker->randomElement(['available','rented','full']),  // Random status
                ]);
            }
        } else {
            // Output message if no admin user found
            echo "No admin user found to assign as property owner.\n";
        }
    }
}
