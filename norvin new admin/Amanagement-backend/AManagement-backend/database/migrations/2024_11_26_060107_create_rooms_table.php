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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // E.g., Room 101, Room 102
            $table->decimal('price', 10, 2); // Rent price for the room
            $table->boolean('is_vacant')->default(true); // Whether the room is available or not
            $table->foreignId('property_id')->constrained()->onDelete('cascade'); // Foreign key to properties table
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
