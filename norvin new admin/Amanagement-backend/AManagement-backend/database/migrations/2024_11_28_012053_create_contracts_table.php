<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
    * Run the migrations.
    * 
    * Fixed-Term Contracts    | Let them specify the start_date and end_date.
    * Monthly Contracts       | Set the lease_end_date to null, and specify that rent is paid monthly. Optionally, store a renewal_date or last_renewal_date.
    * Annual Contracts        |	Similar to fixed-term, but with an annual renewal or expiration date.
    * One-Time Contracts      | Set a one-time rent_amount for the entire duration, and lease_end_date may be the only relevant field.
    **/
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('set null'); // Tenant who accepts the contract
            $table->foreignId('property_id')->nullable()->constrained('properties')->onDelete('cascade'); // Links to the property
            $table->string('contract_code')->unique();
            $table->decimal('rent_amount', 8, 2); // Rent amount for the specific contract
            $table->decimal('late_fee', 8, 2); // Late fee for the specific contract
            $table->decimal('security_deposit_amount', 8, 2); // Security deposit for the specific contract
            $table->date('contract_date'); // Date the contract was created
            $table->date('start_date'); // Start date of the contract
            $table->date('end_date')->nullable(); // End date of the contract (nullable if ongoing)
            $table->integer('notice_period');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending'); // Status of the contract
            $table->enum('payment_due_day', ['15th', 'last_day']); // Payment due day
            $table->timestamps(); // Created and Updated timestamps
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
