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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_code')->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Tenant's user ID
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade'); // Room assigned to the tenant
            $table->date('lease_start'); // Lease start date
            $table->decimal('deposit_amount', 10, 2)->default(0);
            $table->decimal('monthly_rent', 10, 2)->default(0);
            $table->date('lease_end')->nullable(); // Lease end date
            $table->enum('status', ['pending','active', 'inactive', 'terminated'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
