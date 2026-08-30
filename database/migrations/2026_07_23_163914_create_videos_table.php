<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_module_id')->constrained('video_modules')->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['youtube', 'upload'])->default('youtube');
            $table->string('video_url');
            $table->string('duration')->nullable()->default('00:00');
            $table->text('description')->nullable();
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
