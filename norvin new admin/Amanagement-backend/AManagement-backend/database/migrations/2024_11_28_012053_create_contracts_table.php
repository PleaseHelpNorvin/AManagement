<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Run the migrations.
    * 
    * fixed         |   Fixed-term rental agreement	                  -   The tenant agrees to stay for a specific duration (e.g., 6 months, 1 year).
    * renewable     |   Renewable lease contract                      -   The contract can be manually renewed at the end of the term.
    * non_renewable |	Non-renewable lease agreement                 -   A one-time lease contract that cannot be extended (e.g., temporary housing).
    * auto_renewal  |   Automatically renewing lease                  -   The lease renews automatically unless the tenant gives prior notice to vacate.
    * single_term   |   Single-payment contract                       -   One-time payment for a short stay (e.g., daily, weekly rental agreements).
    * recurring	    |   Monthly recurring payment for ongoing tenancy -   Continuous payment schedule for indefinite tenancy (e.g., month-to-month rent).

     */
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained('properties')->onDelete('cascade');
            $table->enum('contract_type', ['template','one_time', 'renewable', 'non_renewable','auto_renewal', 'single_term', 'recurring'])->default('template'); // Enum column
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->decimal('rent_amount', 8,2);
            $table->decimal('security_deposit', 8,2);
            $table->date('payment_due_date');
            $table->enum('status', ['template', 'expired', 'terminated', 'finalized', 'active'])->default('template');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
