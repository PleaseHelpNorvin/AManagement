<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
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
        if ($users->count() < 2) {
            echo "Not enough users to create messages.\n";
            return;
        }

        // Seed messages between random users
        for ($i = 0; $i < 50; $i++) {  // Adjust the number of messages to create (here, we are creating 50 messages)
            // Pick random sender and receiver, ensuring they are not the same
            $sender = $users->random();
            do {
                $receiver = $users->random();
            } while ($sender->id == $receiver->id);  // Ensure sender and receiver are not the same user

            // Random message content
            $messageContent = $faker->text(200); // Random text for the message

            // Random status (sent, read, or archived)
            $status = $faker->randomElement(['sent', 'read', 'archived']);

            // Create the message record
            Message::create([
                'sender_id' => $sender->id,  // Sender's user ID
                'receiver_id' => $receiver->id,  // Receiver's user ID
                'message' => $messageContent,  // Random message content
                'status' => $status,  // Random message status
            ]);
        }
    }
}
