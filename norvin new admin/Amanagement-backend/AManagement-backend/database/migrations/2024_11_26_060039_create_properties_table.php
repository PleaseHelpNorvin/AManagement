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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('unit_name'); // E.g., Unit A, Apartment 1B
            $table->string('address');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Admin who manages the unit
            $table->boolean('is_vacant')->default(true); // Tracks vacancy
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
