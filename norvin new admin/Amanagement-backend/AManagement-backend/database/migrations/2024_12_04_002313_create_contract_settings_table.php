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
        Schema::create('contract_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('late_fee_percentage', 5, 2); // Store late fee percentage
            $table->decimal('security_deposit_percentage', 5, 2); // Store security deposit percentage
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_settings');
    }
};
