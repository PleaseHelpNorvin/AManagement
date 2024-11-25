<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Payment;


class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tenant::all()->each(function ($tenant, $index) {
            // Use the index to generate unique payment amounts
            Payment::create([
                'tenant_id' => $tenant->id,
                'room_id' => $tenant->room_id,
                'amount' => 5000 + ($index * 100), // Example: 5000, 5100, 5200...
                'status' => 'pending',
                'due_date' => now()->addMonth(),
            ]);

            Payment::create([
                'tenant_id' => $tenant->id,
                'room_id' => $tenant->room_id,
                'amount' => 2300 + ($index * 50), // Example: 2300, 2350, 2400...
                'status' => 'overdue',
                'due_date' => now()->addMonths(2),
            ]);

            Payment::create([
                'tenant_id' => $tenant->id,
                'room_id' => $tenant->room_id,
                'amount' => 12300 + ($index * 150), // Example: 12300, 12450, 12600...
                'status' => 'paid',
                'due_date' => now()->addMonths(3),
            ]);
        });
    }
}
