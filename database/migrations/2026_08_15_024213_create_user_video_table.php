<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_video', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('video_id')->constrained('videos')->onDelete('cascade'); // Sesuaikan 'videos' dengan nama tabel video Anda
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_video');
    }
};
