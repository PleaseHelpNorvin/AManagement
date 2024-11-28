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
        $users  = User::where('role', 'tenant')->get();
        // echo $tenants;
        // dd($users);  

        // Get properties
        $properties = Property::all();
        // echo "Properties count: " . $properties->count() . "\n";

        // Ensure there are enough tenants and properties
        if($users ->isEmpty()) {
            echo "Not enough tenants to create contracts \n";
            return;
        }elseif($properties->isEmpty()){
            echo "Not enough properties to create contracts \n";
            return;
        }

        // Seed contracts for each tenant and property
        foreach ($users  as $users ) {
            // Pick a random property
            $property = $properties->random();

            // Random contract type
            $contractType = Arr::random(['one_time', 'renewable', 'non_renewable', 'auto_renewal', 'single_term', 'recurring']);

            // Random start date and end date
            $startDate = $faker->dateTimeThisYear();
            $endDate = ($contractType === 'one_time' || $contractType === 'non_renewable') ? null : $faker->dateTimeBetween($startDate);

            // Random rent amount and security deposit
            $rentAmount = $faker->randomFloat(2, 500, 2000);  // Rent between 500 and 2000
            $securityDeposit = $faker->randomFloat(2, 100, 1000);  // Deposit between 100 and 1000

            // Random payment due date
            $paymentDueDate = $faker->randomFloat(2, 1, 31); // Payment due on a random day of the month

            // Create the contract
            Contract::create([
                'tenant_id' => $users->id,
                'property_id' => $property->id,
                'contract_type' => $contractType,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'rent_amount' => $rentAmount,
                'security_deposit' => $securityDeposit,
                'payment_due_date' => $paymentDueDate,
                'status' => 'active',  // Default to active
            ]);
        }
    }
}

