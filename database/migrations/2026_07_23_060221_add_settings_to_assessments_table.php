<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->integer('duration_minutes')->default(60)->after('type'); // Durasi kuis (menit)
            $table->integer('passing_grade')->default(70)->after('duration_minutes'); // Nilai KKM
            $table->integer('max_attempts')->default(1)->after('passing_grade'); // Batas percobaan
            $table->boolean('shuffle_questions')->default(false)->after('max_attempts'); // Acak soal
            $table->dateTime('start_time')->nullable()->after('shuffle_questions'); // Waktu buka
            $table->dateTime('end_time')->nullable()->after('start_time'); // Deadline tutup
        });
    }

    public function down(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn(['duration_minutes', 'passing_grade', 'max_attempts', 'shuffle_questions', 'start_time', 'end_time']);
        });
    }
};
