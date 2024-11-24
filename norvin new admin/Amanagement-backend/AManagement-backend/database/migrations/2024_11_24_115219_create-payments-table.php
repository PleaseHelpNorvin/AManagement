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
        //
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tenant ID
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // Unit ID
            $table->decimal('amount', 10, 2); // Payment amount
            $table->enum('status', ['paid', 'pending', 'overdue'])->default('pending'); // Payment status
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('payments');

    }
};
