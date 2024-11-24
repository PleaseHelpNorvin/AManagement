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
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Tenant ID
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // Unit ID
            $table->string('title'); // Request title
            $table->text('description'); // Detailed description
            $table->enum('status', ['open', 'closed'])->default('open'); // Request status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('maintenance_requests');
    }
};
