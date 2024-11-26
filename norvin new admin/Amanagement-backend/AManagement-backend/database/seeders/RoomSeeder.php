<?php
// database/seeders/RoomSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Property;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Fetch properties for room assignment
        $property1 = Property::find(1); // Apartment 101
        $property2 = Property::find(2); // Apartment 102

        // Create rooms for Property 1
        Room::create([
            'name' => 'Room 1A',
            'price' => 123123,
            'is_vacant' => true,
            'property_id' => $property1->id,
        ]);
        Room::create([
            'name' => 'Room 1B',
            'price' => 152133,
            'property_id' => $property1->id,
            'is_vacant' => false,
        ]);

        // Create rooms for Property 2
        Room::create([
            'name' => 'Room 2A',
            'price' => 15151,
            'property_id' => $property2->id,
            'is_vacant' => true,
        ]);
        Room::create([
            'name' => 'Room 2B',
            'price' => 51251,
            'property_id' => $property2->id,
            'is_vacant' => false,
        ]);
    }
}
