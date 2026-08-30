<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dan tambahkan kolom jika belum ada
            if (!Schema::hasColumn('users', 'nik')) $table->string('nik')->nullable();
            if (!Schema::hasColumn('users', 'npwp')) $table->string('npwp')->nullable();
            if (!Schema::hasColumn('users', 'tempat_lahir')) $table->string('tempat_lahir')->nullable();
            if (!Schema::hasColumn('users', 'tanggal_lahir')) $table->date('tanggal_lahir')->nullable();
            if (!Schema::hasColumn('users', 'agama')) $table->string('agama')->nullable();
            if (!Schema::hasColumn('users', 'kewarganegaraan')) $table->string('kewarganegaraan')->default('Indonesia')->nullable();
            if (!Schema::hasColumn('users', 'jenis_kelamin')) $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan', 'Lainnya'])->nullable();
            if (!Schema::hasColumn('users', 'no_hp')) $table->string('no_hp')->nullable();

            // Akademik
            if (!Schema::hasColumn('users', 'universitas')) $table->string('universitas')->nullable();
            if (!Schema::hasColumn('users', 'dosen_pa')) $table->string('dosen_pa')->nullable();
            if (!Schema::hasColumn('users', 'nim')) $table->string('nim')->nullable();
            if (!Schema::hasColumn('users', 'jenis_pendaftaran')) $table->string('jenis_pendaftaran')->nullable();
            if (!Schema::hasColumn('users', 'prodi')) $table->string('prodi')->nullable();
            if (!Schema::hasColumn('users', 'jalur_pendaftaran')) $table->string('jalur_pendaftaran')->nullable();
            if (!Schema::hasColumn('users', 'ukt')) $table->string('ukt')->nullable();
            if (!Schema::hasColumn('users', 'angkatan')) $table->string('angkatan')->nullable();
            if (!Schema::hasColumn('users', 'gelombang_masuk')) $table->string('gelombang_masuk')->nullable();
            if (!Schema::hasColumn('users', 'status_akademik')) $table->string('status_akademik')->default('Aktif')->nullable();
            if (!Schema::hasColumn('users', 'tanggal_masuk')) $table->date('tanggal_masuk')->nullable();
            if (!Schema::hasColumn('users', 'periode_masuk')) $table->string('periode_masuk')->nullable();
            if (!Schema::hasColumn('users', 'kelas')) $table->string('kelas')->nullable();

            // Alamat
            if (!Schema::hasColumn('users', 'jalan')) $table->string('jalan')->nullable();
            if (!Schema::hasColumn('users', 'dusun')) $table->string('dusun')->nullable();
            if (!Schema::hasColumn('users', 'rt')) $table->string('rt')->nullable();
            if (!Schema::hasColumn('users', 'rw')) $table->string('rw')->nullable();
            if (!Schema::hasColumn('users', 'kelurahan')) $table->string('kelurahan')->nullable();
            if (!Schema::hasColumn('users', 'kecamatan')) $table->string('kecamatan')->nullable();
            if (!Schema::hasColumn('users', 'kab_kota')) $table->string('kab_kota')->nullable();
            if (!Schema::hasColumn('users', 'provinsi')) $table->string('provinsi')->nullable();
            if (!Schema::hasColumn('users', 'kode_pos')) $table->string('kode_pos')->nullable();
            if (!Schema::hasColumn('users', 'penerima_kps')) $table->enum('penerima_kps', ['Ya', 'Tidak'])->default('Tidak')->nullable();

            // Orang Tua & Wali & Tambahan
            if (!Schema::hasColumn('users', 'nama_ayah')) $table->string('nama_ayah')->nullable();
            if (!Schema::hasColumn('users', 'no_hp_ayah')) $table->string('no_hp_ayah')->nullable();
            if (!Schema::hasColumn('users', 'alamat_ayah')) $table->text('alamat_ayah')->nullable();
            if (!Schema::hasColumn('users', 'nama_ibu')) $table->string('nama_ibu')->nullable();
            if (!Schema::hasColumn('users', 'no_hp_ibu')) $table->string('no_hp_ibu')->nullable();
            if (!Schema::hasColumn('users', 'alamat_ibu')) $table->text('alamat_ibu')->nullable();
            if (!Schema::hasColumn('users', 'nama_wali')) $table->string('nama_wali')->nullable();
            if (!Schema::hasColumn('users', 'no_hp_wali')) $table->string('no_hp_wali')->nullable();
            if (!Schema::hasColumn('users', 'pt_asal')) $table->string('pt_asal')->nullable();
            if (!Schema::hasColumn('users', 'prodi_asal')) $table->string('prodi_asal')->nullable();
            if (!Schema::hasColumn('users', 'riwayat_pendidikan_terakhir')) $table->string('riwayat_pendidikan_terakhir')->nullable();
        });
    }

    public function down(): void
    {
        // ...
    }
};
