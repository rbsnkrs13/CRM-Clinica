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
        Schema::create('training_courses', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique(); // Título de la formación (ej: "Primeros Auxilios Psicológicos en la Infancia")
            $table->text('description')->nullable(); // Descripción detallada del contenido de la formación
            $table->decimal('price', 8, 2)->nullable(); // Precio de la formación
            $table->dateTime('start_date_time')->nullable(); // Fecha y hora de inicio de la formación
            $table->dateTime('end_date_time')->nullable(); // Fecha y hora de fin de la formación
            $table->integer('capacity')->nullable(); // Capacidad máxima de participantes
            $table->string('location')->nullable(); // Lugar donde se imparte la formación (presencial u online)
            $table->text('syllabus')->nullable(); // Temario o programa de la formación (podría ser un JSON o texto)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_courses');
    }
};
