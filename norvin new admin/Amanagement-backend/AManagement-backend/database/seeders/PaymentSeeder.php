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
        //
        Tenant::all()->each(function ($tenant) {
            Payment::create([
                'tenant_id' => $tenant->id,
                'room_id' => $tenant->room_id,
                'amount' => 5000, // Example payment amount
                'status' => 'paid',
                'due_date' => now()->addMonth(),
                // 'payments' => '2024-12-25'
            ]);
            Payment::create([
                'tenant_id' => $tenant->id,
                'room_id' => $tenant->room_id,
                'amount' => 5000, // Example payment amount
                'status' => 'paid',
                'due_date' => now()->addMonth(),
                // 'payments' => '2024-12-25'
            ]);
        });
    }
}
