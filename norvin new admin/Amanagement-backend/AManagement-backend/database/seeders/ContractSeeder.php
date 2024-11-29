<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch tenants (users with the 'tenant' role) and properties
        $tenants = User::where('role', 'tenant')->get();
        $properties = Property::all();

        // Ensure there are enough tenants and properties
        if ($tenants->isEmpty()) {
            echo "No tenants found. Please seed tenants first.\n";
            return;
        }

        if ($properties->isEmpty()) {
            echo "No properties found. Please seed properties first.\n";
            return;
        }

        // Generate random contracts
        foreach ($tenants as $tenant) {
            // Randomly assign a property to the tenant
            $property = $properties->random();

            // Randomly select a contract type
            $contractType = Arr::random(['fixed', 'monthly', 'annual', 'one_time']);

            // Randomize start and end dates
            $startDate = now()->subMonths(rand(0, 12)); // Random start date within the last year
            $endDate = in_array($contractType, ['fixed', 'annual'])
                ? $startDate->copy()->addMonths(rand(6, 12)) // For fixed/annual contracts, add 6–12 months
                : null; // No end date for monthly or one-time contracts

            // Randomize rent amount, security deposit, and late fee
            $rentAmount = fake()->randomFloat(2, 500, 2000); // Rent between 500 and 2000
            $securityDeposit = fake()->randomFloat(2, 100, 1000); // Deposit between 100 and 1000
            $lateFee = fake()->randomFloat(2, 50, 500); // Late fee between 50 and 500

            // Payment frequency and due date
            $paymentFrequency = in_array($contractType, ['monthly', 'annually', 'one_time']) ? $contractType : 'one_time';
            $paymentDueDate = now()->addDays(rand(1, 28))->format('Y-m-d'); // Random day within the next month

            // Create the contract
            Contract::create([
                'tenant_id' => $tenant->id,
                'property_id' => $property->id,
                'contract_type' => $contractType,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rent_amount' => $rentAmount,
                'security_payment' => $securityDeposit,
                'payment_frequency' => $paymentFrequency,
                'payment_due_date' => $paymentDueDate,
                'late_fee' => $lateFee,
                'total_paid' => 0.00, // Default to 0
                'status' => 'active', // Default status
                'special_terms' => 'The tenant agrees to pay for utilities.',
                'is_renewable' => in_array($contractType, ['fixed', 'annual']),
                'notes' => 'Auto-generated contract.',
            ]);
        }

        echo "Contracts seeded successfully!\n";
    }
}
