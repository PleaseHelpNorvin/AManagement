<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create(); 
        //php artisan db:seed

        User::factory()->create([
            'username' => 'User',
            'email' => 'test@test.com',
        ]);
        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 1
        ]);
        User::factory()->create([
            'username' => 'admin1',
            'email' => 'admin1@admin.com',
            'role' => 1
        ]);
    }
}
