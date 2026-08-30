<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade'); // Terhubung ke tabel modul
            $table->string('title');
            $table->enum('type', ['quiz', 'essay']);
            $table->integer('time_limit')->nullable()->default(0); // 0 berarti tanpa batas waktu
            $table->integer('xp_reward')->default(100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
