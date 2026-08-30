<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->onDelete('cascade');
            $table->enum('type', ['pg', 'essay']);
            $table->text('text');
            $table->json('options')->nullable(); // Menampung pilihan A, B, C, D (JSON)
            $table->integer('correct_answer')->nullable(); // Index jawaban benar (0, 1, 2, 3)
            $table->text('essay_guideline')->nullable(); // Panduan penilaian esai
            $table->boolean('is_ai')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
