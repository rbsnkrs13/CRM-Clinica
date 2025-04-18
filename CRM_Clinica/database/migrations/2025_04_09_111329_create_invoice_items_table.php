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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billing_id')->references('id')->on('billing')->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('restrict'); // El servicio facturado
            $table->string('description')->nullable(); // Descripción del ítem (puede ser el nombre del servicio)
            $table->integer('quantity')->default(1); // Cantidad del servicio (por defecto 1)
            $table->decimal('unit_price', 10, 2); // Precio unitario del servicio
            $table->decimal('subtotal', 10, 2); // Subtotal de esta línea (cantidad * precio unitario)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
