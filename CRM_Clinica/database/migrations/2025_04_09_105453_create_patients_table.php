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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            //datos para el paciente
            $table->string('name');
            $table->string('lastName');
            $table->date('birth_date')->nullable();
            $table->string('gender')->nullable();
            $table->text('medical_history')->nullable(); // Historial médico relevante
            // Datos del padre/madre/tutor legal 1
            $table->string('parent1_name')->nullable();
            $table->string('parent1_lastName')->nullable();
            $table->string('parent1_phone')->nullable();
            $table->string('parent1_relationship')->nullable(); // Madre, Padre, Tutor, etc.
            // Datos del padre/madre/tutor legal 2 (opcional)
            $table->string('parent2_name')->nullable();
            $table->string('parent2_lastName')->nullable();
            $table->string('parent2_phone')->nullable();
            $table->string('parent2_relationship')->nullable();

            $table->string('address')->nullable();
            $table->string('phone')->nullable(); // Teléfono de contacto principal del paciente/familia
            $table->string('email')->nullable(); // Email de contacto principal del paciente/familia (si aplica)
            $table->foreignId('school_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
