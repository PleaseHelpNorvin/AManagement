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
            // Primary Key
            $table->id();
            
            // Foreign Keys
            $table->foreignId('tenant_id')->nullable()->constrained('users')->onDelete('cascade'); // Links to the tenant
            $table->foreignId('property_id')->nullable()->constrained('properties')->onDelete('cascade'); // Links to the property
        
            // Contract Details
            // $table->enum('contract_type', ['template', 'fixed', 'monthly', 'annual', 'one_time'])->default('template'); // Type of contract
            $table->timestamp('start_date'); // Contract start date
            $table->timestamp('end_date')->nullable(); // Contract end date (nullable for monthly/indefinite)
        
            // Financial Details
            $table->decimal('rent_amount', 10, 2); // Rent amount (monthly, annual, or one-time)
            $table->decimal('security_payment', 10, 2)->default(0.00); // Security deposit amount
            $table->enum('payment_frequency', ['monthly', 'annually', 'one_time'])->default('monthly'); // How often the payment is due
            $table->date('payment_due_date'); // Date when rent is due
            $table->decimal('late_fee', 10, 2)->nullable()->default(0.00); // Late payment fee
            $table->decimal('total_paid', 10, 2)->default(0.00); // Track total payments made by the tenant
        
            // Renewal/Termination
            $table->date('renewal_date')->nullable(); // Optional renewal date for recurring contracts
            $table->enum('status', ['active', 'expired', 'terminated', 'finalized'])->default('active'); // Status of the contract
            
            // Optional Details
            $table->text('special_terms')->nullable()->default('The tenant agrees to pay for utilities (electricity, water, etc.).'); // Special agreements or terms
            $table->boolean('is_renewable')->default(false); // Whether the contract is renewable
            $table->text('notes')->nullable(); // Additional notes or comments
        
            // Metadata
            $table->timestamps(); // Created and updated timestamps
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
