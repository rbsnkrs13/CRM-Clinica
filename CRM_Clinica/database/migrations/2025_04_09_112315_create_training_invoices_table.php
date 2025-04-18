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
        Schema::create('training_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_registration_id')->constrained()->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->date('billing_date');
            $table->decimal('total_amount', 8, 2);
            $table->decimal('amount_paid', 8, 2)->default(0.00);
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_invoices');
    }
};
