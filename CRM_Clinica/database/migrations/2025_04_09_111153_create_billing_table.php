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
        Schema::create('billing', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->nullable()->constrained()->onDelete('set null'); // Opcional: Si quieres rastrear quién atendió para la factura
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null'); // Opcional: Si la factura está directamente ligada a una cita
        
            $table->string('invoice_number')->unique(); // Número único de la factura
            $table->date('billing_date'); // Fecha de emisión de la factura
            $table->date('due_date')->nullable(); // Fecha de vencimiento del pago
            $table->decimal('total_amount', 10, 2); // Importe total de la factura
            $table->decimal('amount_paid', 10, 2)->default(0.00); // Importe pagado
            $table->enum('payment_status', ['pending', 'paid','cancelled'])->default('pending');
            $table->string('payment_method')->nullable(); // Método de pago utilizado
            $table->dateTime('payment_date')->nullable(); // Fecha del pago
        
            $table->text('notes')->nullable(); // Notas adicionales sobre la factura
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billing_');
    }
};
