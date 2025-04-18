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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('restrict'); // Un servicio no debería eliminarse si hay citas asociadas
            $table->foreignId('schedule_id')->nullable()->constrained('professional_schedule')->onDelete('set null');
        
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable(); // Puede ser estimado al principio
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'rescheduled'])->default('scheduled');
            $table->text('notes')->nullable(); // Notas sobre la cita
            $table->string('reason')->nullable();
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
