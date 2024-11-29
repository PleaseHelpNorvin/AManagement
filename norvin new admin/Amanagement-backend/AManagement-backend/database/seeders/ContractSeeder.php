<?php

namespace Database\Seeders;

use App\Models\Contract;
use App\Models\User;
use App\Models\Property;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     */
    public function run(Faker $faker): void
    {
        // Get tenants (users with 'tenant' role)
        $users = User::where('role', 'tenant')->get();

        // Get properties
        $properties = Property::all();

        // Ensure there are enough tenants and properties
        if ($users->isEmpty()) {
            echo "Not enough tenants to create contracts \n";
            return;
        } elseif ($properties->isEmpty()) {
            echo "Not enough properties to create contracts \n";
            return;
        }

        // Seed contracts for each tenant and property
        foreach ($users as $user) {
            // Pick a random property
            $property = $properties->random();

            // Random contract type
            $contractType = Arr::random(['one_time', 'renewable', 'non_renewable', 'auto_renewal', 'single_term', 'recurring']);

            // Random start date (in the current year)
            $startDate = $faker->dateTimeThisYear();

            // End date logic: If the contract is non-renewable or single-term, end_date is null
            $endDate = ($contractType === 'one_time' || $contractType === 'non_renewable' || $contractType === 'single_term') 
                ? null 
                : $faker->dateTimeBetween($startDate);

            // Random rent amount and security deposit
            $rentAmount = $faker->randomFloat(2, 500, 2000);  // Rent between 500 and 2000
            $securityDeposit = $faker->randomFloat(2, 100, 1000);  // Deposit between 100 and 1000

            // Random payment due date (between 1st and 28th of the month)
            $randomDay = rand(1, 28);
            $paymentDueDate = $faker->dateTimeThisYear()->format('Y-m-') . str_pad($randomDay, 2, '0', STR_PAD_LEFT); // Full date format

            // Create the contract
            Contract::create([
                'tenant_id' => null,  // Associate the contract with the tenant
                'property_id' => null,  // Associate the contract with the property
                'contract_type' => $contractType,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rent_amount' => $rentAmount,
                'security_deposit' => $securityDeposit,
                'payment_due_date' => $paymentDueDate,
                'status' => 'template',  // Default to 'active'
            ]);
        }
    }
}
