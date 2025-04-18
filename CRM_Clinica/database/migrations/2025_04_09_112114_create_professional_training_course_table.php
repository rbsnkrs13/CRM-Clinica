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
        Schema::create('professional_training_course', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_course_id')->constrained()->onDelete('cascade');
            $table->foreignId('professional_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        
            $table->unique(['training_course_id', 'professional_id'], 'prof_train_unique'); // Nombre de índice explícito y corto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_training_course');
    }
};
