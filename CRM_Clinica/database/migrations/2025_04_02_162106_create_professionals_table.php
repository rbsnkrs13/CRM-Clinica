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
        Schema::create('professionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Clave foránea a la tabla users
            $table->string('specialization'); // Ej: Terapeuta Ocupacional, Neuropsicólogo
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('availability')->nullable(); // Podría ser un JSON o texto con horarios
            $table->string('address')->nullable();
            $table->text('biography')->nullable();
            $table->timestamps();
            $table->unique('user_id'); // Asegura que un usuario solo pueda ser un profesional
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};
