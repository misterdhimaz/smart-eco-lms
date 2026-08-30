<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('xp_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // 'modul', 'video', 'game', 'latihan', 'simulasi'
            $table->string('title'); // Nama aktivitasnya
            $table->integer('xp'); // Jumlah XP yang didapat
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('xp_logs');
    }
};
