<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Notification;


class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::all()->each(function ($user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'Payment Reminder',
                'data' => json_encode(['message' => 'Your rent is due soon.']),
                'is_read' => false,
            ]);
        });
    }
}
