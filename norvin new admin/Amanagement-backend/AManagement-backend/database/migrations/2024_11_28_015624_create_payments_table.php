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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->constrained('billings')->onDelete('cascade');
            $table->timestamp('payment_date');
            $table->decimal('amount_paid', 8,2);
            $table->string('payment_method'); //the reason i didnt make this enum because I paymongo already handle the payment method all I need to get the data from the paymongo api response
            $table->string('status');
            $table->string('transaction_id'); //the reason i didnt make this foreignId because I just need to get the data from paymongo response for record purposes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
