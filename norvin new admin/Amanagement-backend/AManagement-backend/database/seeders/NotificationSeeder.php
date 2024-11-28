<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     */
    public function run(Faker $faker): void
    {
        // Get all users
        $users = User::all();

        // Ensure there are enough users
        if ($users->isEmpty()) {
            echo "No users found. Cannot create notifications.\n";
            return;
        }

        // Seed notifications for each user
        for ($i = 0; $i < 50; $i++) {  // Adjust the number of notifications (here, we are creating 50 notifications)
            // Pick a random user
            $user = $users->random();

            // Random notification message
            $message = $faker->sentence();  // Random sentence for the notification message

            // Random status (unread, read, or dismissed)
            $status = $faker->randomElement(['unread', 'read', 'dismissed']);

            // Create the notification record
            Notification::create([
                'user_id' => $user->id,  // User's ID
                'message' => $message,  // Random message content
                'status' => $status,  // Random status
            ]);
        }
    }
}
