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
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('property_id')->nullable()->constrained('properties')->onDelete('cascade');
            $table->enum('contract_type', ['template','fixed','monthly', 'annual', 'one_time'])->default('template'); // Enum column
            // Start date for the contract
            $table->timestamp('start_date');
            // End date for fixed-term contracts (nullable for others)
            $table->timestamp('end_date')->nullable();
            // Rent amount (can be monthly, annual, or one-time payment)
            $table->decimal('rent_amount', 8, 2);
            // Payment due date for rent (could be monthly, annually, or just once)
            $table->date('payment_due_date');
            // Optional renewal date for monthly contracts (can renew periodically)
            $table->date('renewal_date')->nullable();
            //optional for the agreement that 
            $table->text('special_term')->nullable()->default('The tenant agrees to pay the water and electricity bills for their room, starting at 0.');
            // Enum for the status of the contract
            $table->enum('status', ['template', 'expired', 'terminated', 'finalized', 'active'])->default('template');
            
            // Timestamps to track contract creation and updates
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
