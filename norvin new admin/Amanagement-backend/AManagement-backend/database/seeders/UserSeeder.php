<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin Users
        $admin1 = User::create([
            'name' => 'Admin One',
            'email' => 'admin1@example.com',
            'password' => Hash::make('password'),
            'role' => User::ADMIN,
        ]);

        $admin2 = User::create([
            'name' => 'Admin Two',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password'),
            'role' => User::ADMIN,
        ]);

        $admin3 = User::create([
            'name' => 'Admin Three',
            'email' => 'admin3@example.com',
            'password' => Hash::make('password'),
            'role' => User::ADMIN,
        ]);

        // Create Tenant Users
        $tenant1 = User::create([
            'name' => 'Tenant One',
            'email' => 'tenant1@example.com',
            'password' => Hash::make('password'),
            'role' => User::TENANT,
        ]);

        $tenant2 = User::create([
            'name' => 'Tenant Two',
            'email' => 'tenant2@example.com',
            'password' => Hash::make('password'),
            'role' => User::TENANT,
        ]);

        $tenant3 = User::create([
            'name' => 'Tenant Three',
            'email' => 'tenant3@example.com',
            'password' => Hash::make('password'),
            'role' => User::TENANT,
        ]);

        // Create Technician Users
        $technician1 = User::create([
            'name' => 'Tech One',
            'email' => 'tech1@example.com',
            'password' => Hash::make('password'),
            'role' => User::TECHNICIAN,
        ]);

        $technician2 = User::create([
            'name' => 'Tech Two',
            'email' => 'tech2@example.com',
            'password' => Hash::make('password'),
            'role' => User::TECHNICIAN,
        ]);

        $technician3 = User::create([
            'name' => 'Tech Three',
            'email' => 'tech3@example.com',
            'password' => Hash::make('password'),
            'role' => User::TECHNICIAN,
        ]);
    }
}
