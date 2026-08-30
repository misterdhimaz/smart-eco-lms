<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->string('badge')->default('Lab 01');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('cover_image');
            $table->enum('type', ['embed', 'native_carbon'])->default('embed');
            $table->string('embed_url')->nullable(); // Link eksternal (jika type = embed)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('simulations');
    }
};
