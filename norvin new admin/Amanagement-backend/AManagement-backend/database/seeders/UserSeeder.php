<?php
// database/seeders/UserSeeder.php
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
            'phone' => '1234567890',
            'password' => Hash::make('password'),
            'role' => User::ADMIN,
        ]);

        $admin2 = User::create([
            'name' => 'Admin Two',
            'email' => 'admin2@example.com',
            'phone' => '0987654321',
            'password' => Hash::make('password'),
            'role' => User::ADMIN,
        ]);
        
        // Create Tenant Users (and other roles like Technicians, if needed)
        $tenant1 = User::create([
            'name' => 'Tenant One',
            'email' => 'tenant1@example.com',
            'phone' => '1112223333',
            'password' => Hash::make('password'),
            'role' => User::TENANT,
        ]);

        $tenant2 = User::create([
            'name' => 'Tenant Two',
            'email' => 'tenant2@example.com',
            'phone' => '4445556666',
            'password' => Hash::make('password'),
            'role' => User::TENANT,
        ]);

        $technician1 = User::create([
            'name' => 'Tech One',
            'email' => 'Tech1@example.com',
            'phone' => '12312312312',
            'password' => Hash::make('password'),
            'role' => User::TECHNICIAN,
        ]);

        $technician1 = User::create([
            'name' => 'Tech Two',
            'email' => 'Tech2@example.com',
            'phone' => '1512512412431',
            'password' => Hash::make('password'),
            'role' => User::TECHNICIAN,
        ]);
    }
}
