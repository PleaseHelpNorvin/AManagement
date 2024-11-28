<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserProfile;
use App\Models\User;
use Faker\Factory as Faker;

class UserProfileSeeder extends Seeder
{
    public function run()
    {
        // Custom function to generate Philippine phone number
        function phoneNumber()
        {
            $prefixes = ['091', '092', '093', '094', '095', '096', '097', '098', '099'];
            $prefix = $prefixes[array_rand($prefixes)];
            $number = $prefix . mt_rand(1000000, 9999999); // Generates a 7-digit random number
            return $number;
        }

        // Initialize Faker instance for generating random data
        $faker = Faker::create();

        // Fetch all users with the 'TENANT' role
        $tenants = User::all();

        // Loop through each tenant and create a profile for them
        foreach ($tenants as $tenant) {
            UserProfile::create([
                'user_id' => $tenant->id, // Linking profile to the tenant user
                'phone_number' => phoneNumber(), // Generate Philippine phone number
                'address' => $faker->address, // Generate unique address
                'profile_picture_url' => $faker->imageUrl(150, 150), // Generate unique image URL
                'emergency_contact' => phoneNumber(), // Generate Philippine emergency contact
                'bio' => $faker->text(200), // Generate unique bio with random text
            ]);
        }
    }
}
