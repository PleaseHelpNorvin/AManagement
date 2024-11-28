<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Property;
use Faker\Factory as Faker;

class RoomSeeder extends Seeder
{
    public function run()
    {
        // Initialize Faker instance for generating random data
        $faker = Faker::create();

        // Fetch all properties from the database
        $properties = Property::all();

        // If properties exist, proceed to create rooms
        foreach ($properties as $property) {
            // Create 5 rooms for each property (you can adjust the number as needed)
            for ($i = 0; $i < 5; $i++) {
                Room::create([
                    'property_id' => $property->id,
                    'room_code' => strtoupper($faker->lexify('ROOM???')), // Generates a room code like ROOMABC
                    'rent_amount' => $faker->randomFloat(2, 5000, 50000), // Random rent amount between 5000 and 50000
                    'status' => $faker->randomElement(['available', 'rented', 'under maintenance']), // Random room status
                ]);
            }
        }
    }
}
