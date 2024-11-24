<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Message;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admin = User::where('role', 'admin')->first();
        $tenants = User::where('role', 'tenant')->get();

        $tenants->each(function ($tenant) use ($admin) {
            Message::create([
                'sender_id' => $tenant->id,
                'receiver_id' => $admin->id,
                'message' => 'Hello Admin, I need assistance with my lease.',
                'is_read' => false,
            ]);
        });
    }
}
