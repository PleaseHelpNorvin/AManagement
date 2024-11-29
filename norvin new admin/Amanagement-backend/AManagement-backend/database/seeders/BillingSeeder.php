<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Contract;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     */
    public function run(Faker $faker): void
    {
        // Get tenants
        $tenants = User::where('role', 'tenant')->get();
        
        // Get contracts
        $contracts = Contract::all();

        // Ensure there are enough tenants and contracts
        if ($tenants->isEmpty()) {
            echo "No tenants found. Cannot create billings.\n";
            return;
        } elseif ($contracts->isEmpty()) {
            echo "No contracts found. Cannot create billings.\n";
            return;
        }

        // Seed billings for each tenant and their contract
        foreach ($tenants as $tenant) {
            // Get the first contract for the tenant
            $contract = $contracts->where('tenant_id', $tenant->id)->first();

            // If no contract is found for the tenant, skip this tenant
            if (!$contract) {
                echo "No contract for tenant ID {$tenant->id}, skipping...\n";
                continue;
            }

            // Billing period (random start date and end date)
            $billingPeriodStart = $faker->dateTimeThisMonth();
            $billingPeriodEnd = $faker->dateTimeBetween($billingPeriodStart, '+1 month');

            // Random amount due (rent amount + additional charges)
            $amountDue = $contract->rent_amount + $faker->randomFloat(2, 0, 500); // Adding a random extra charge

            // Random amount paid (could be less than or equal to amount due)
            $amountPaid = $faker->randomFloat(2, 0, $amountDue);

            // Random payment status
            $paymentStatus = $faker->randomElement(['pending', 'paid', 'overdue']);

            // Generate random readings for electric and water
            $electricReading = $faker->randomFloat(2, 10, 100);  // Example reading
            $waterReading = $faker->randomFloat(2, 10, 100);  // Example reading

            // Generate dummy binary data for electric and water meters
            $electricMeterPicture = $this->generateRandomBinaryData();  // Generate dummy binary data
            $waterMeterPicture = $this->generateRandomBinaryData();  // Same for water meter

            // Create the billing record
            Billing::create([
                'tenant_id' => $tenant->id,
                'contract_id' => $contract->id,
                'amount_due' => $amountDue,
                'amount_paid' => $amountPaid,
                'payment_status' => $paymentStatus,
                'billing_period_start' => $billingPeriodStart,
                'billing_period_end' => $billingPeriodEnd,
                'electric_reading' => $electricReading,
                'water_reading' => $waterReading,
                'electric_meter_picture' => $electricMeterPicture,
                'water_meter_picture' => $waterMeterPicture,
            ]);
        }
    }

    /**
     * Generate dummy binary data for an image.
     *
     * @return string
     */
    private function generateRandomBinaryData(): string
    {
        // Generate 1 KB of random data as binary
        return random_bytes(1024);  // 1 KB of random binary data
    }

    // private function generateRandomImage(): string
    // {
    //     // Here we're just simulating image binary data.
    //     // In a real scenario, you would probably store an image in storage and reference its path.
    //     return base64_encode(file_get_contents(storage_path('app/public/random_image.jpg')));  // Example of how to get image data
    // }
}
