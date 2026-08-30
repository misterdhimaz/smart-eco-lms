<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('climate_stats', function (Blueprint $table) {
            $table->id();
            $table->string('indicator');
            $table->decimal('value', 8, 2);
            $table->string('unit');
            $table->string('subtitle')->nullable();
            $table->enum('trend_type', ['up', 'down', 'neutral'])->default('up');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('climate_stats');
    }
};
