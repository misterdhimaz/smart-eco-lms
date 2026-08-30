<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kelas (Classrooms)
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subject')->nullable();
            $table->text('description')->nullable();
            $table->string('code', 5)->unique(); // Kode unik 5 digit untuk join
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete(); // Dosen/Admin pembuat kelas
            $table->timestamps();
        });

        // 2. Tabel Pivot Mahasiswa & Kelas (Anggota Kelas)
        Schema::create('classroom_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Mahasiswa
            $table->timestamps();
        });

        // 3. Tabel Tugas / Proyek (Assignments)
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('attachment')->nullable(); // Lampiran file dari admin (PDF/Doc/dll)
            $table->dateTime('due_date')->nullable(); // Tenggat waktu
            $table->timestamps();
        });

        // 4. Tabel Pengumpulan Tugas (Submissions)
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Mahasiswa yang mengumpulkan
            $table->string('file_path')->nullable(); // File tugas yang diupload mahasiswa
            $table->text('student_comment')->nullable(); // Komentar pribadi dari mahasiswa
            $table->integer('grade')->nullable(); // Nilai dari admin (0-100)
            $table->text('admin_feedback')->nullable(); // Umpan balik/komentar dari admin
            $table->enum('status', ['submitted', 'graded', 'late'])->default('submitted');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('classroom_user');
        Schema::dropIfExists('classrooms');
    }
};
