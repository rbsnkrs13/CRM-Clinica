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
        Schema::create('patient_assessments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->nullable()->constrained()->onDelete('set null'); // Si un profesional se va, las notas aún deberían existir
            $table->dateTime('assessment_date')->nullable(); // Fecha en la que se realizó la evaluación/nota
            $table->string('title')->nullable(); // Título o nombre del test/nota
            $table->text('notes')->nullable(); // Contenido principal de la evaluación, resultados del test, observaciones, etc.
            $table->string('file_path')->nullable(); // Ruta a algún archivo adjunto (PDF del test, informe, etc.)
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_assessments');
    }
};
