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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // Property ID
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Unit ID (if applicable)
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade'); // Tenant ID
            $table->text('description'); // Detailed description
            $table->timestamp('request_date');
            $table->enum('priority', ['not-set','low','medium', 'high', 'urgent'])->default('not-set');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'canceled'])->default('pending');
            $table->foreignId('technician_id')->constrained('users')->onDelete('cascade'); // Staff ID (user assigned to handle request)
            $table->datetime('completion_date')->nullable(); // Completion date, can be null
            $table->string('remarks')->nullable(); // Remarks for completion, can be null
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
