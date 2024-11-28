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
                echo "no contract";
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

            // Create the billing record
            Billing::create([
                'tenant_id' => $tenant->id,
                'contract_id' => $contract->id,
                'amount_due' => $amountDue,
                'amount_paid' => $amountPaid,
                'payment_status' => $paymentStatus,
                'billing_period_start' => $billingPeriodStart,
                'billing_period_end' => $billingPeriodEnd,
            ]);
        }
    }
}
