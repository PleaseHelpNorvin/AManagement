<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Models\Billing;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentDueNotification;

class CheckPaymentDueDates extends Command
{
    protected $signature = 'billing:check-due-dates';
    protected $description = 'Check if any contracts have due payments and notify tenants.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get all contracts that have a "payment_due_day" and process them
        $contracts = Contract::all();

        foreach ($contracts as $contract) {
            $paymentDueDay = $contract->payment_due_day;
            $dueDate = null;

            // Calculate the due date based on the payment_due_day
            if ($paymentDueDay == '15th') {
                $dueDate = now()->setDay(15)->startOfDay(); // Set the date to the 15th of the current month
            } elseif ($paymentDueDay == 'last_day') {
                $dueDate = now()->endOfMonth()->startOfDay(); // Set the date to the last day of the current month
            }

            // Check if the due date is today or overdue
            if ($dueDate && $dueDate->isToday()) {
                $this->notifyTenant($contract, 'Your payment is due today.');
            } elseif ($dueDate && $dueDate->isPast()) {
                $this->notifyTenant($contract, 'Your payment is overdue.');
            }
        }

        return 0;
    }

    // Send notification to the tenant
    protected function notifyTenant($contract, $message)
    {
        $tenant = $contract->tenant;
        if ($tenant) {
            // Send a notification (you can create a custom notification)
            Notification::send($tenant, new PaymentDueNotification($message));
        }
    }
}
