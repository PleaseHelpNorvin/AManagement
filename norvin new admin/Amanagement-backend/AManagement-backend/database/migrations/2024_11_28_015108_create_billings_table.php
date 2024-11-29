<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->decimal('amount_due',8,2);
            $table->decimal('amount_paid',8,2);
            $table->binary('electric_meter_picture');
            $table->binary('water_meter_picture');
            $table->decimal('electric_reading', 8, 2)->nullable();  // New field for electric reading
            $table->decimal('water_reading', 8, 2)->nullable();    // New field for water reading
            $table->enum('payment_status', ['pending','paid','overdue']);
            $table->timestamp('billing_period_start');
            $table->datetime('billing_period_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billings');
    }
};
