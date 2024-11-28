<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Payment;
use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Faker $faker
     */
    public function run(Faker $faker): void
    {
        // Get all billing records
        $billings = Billing::all();

        // Ensure there are billings to create payments
        if ($billings->isEmpty()) {
            echo "No billings found. Cannot create payments.\n";
            return;
        }

        // Seed payments for each billing record
        foreach ($billings as $billing) {
            // Simulate PayMongo API response (you'll need to replace this with actual API calls)
            $paymentDate = $faker->dateTimeThisMonth();
            $amountPaid = $faker->randomFloat(2, 0, $billing->amount_due);
            $paymentMethod = $faker->randomElement(['credit_card', 'gcash', 'paypal']); // Example methods
            $status = $faker->randomElement(['pending', 'paid', 'failed']);
            $transactionId = $faker->uuid; // Use UUID as a placeholder for transaction ID

            // Create payment record
            Payment::create([
                'billing_id' => $billing->id,
                'payment_date' => $paymentDate,
                'amount_paid' => $amountPaid,
                'payment_method' => $paymentMethod,
                'status' => $status,
                'transaction_id' => $transactionId,
            ]);
        }
    }
}
