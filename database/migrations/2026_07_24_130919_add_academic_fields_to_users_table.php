<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Data Akademik
            $table->string('nim')->nullable()->after('email');
            $table->string('universitas')->nullable()->after('nim');
            $table->string('prodi')->nullable()->after('universitas');
            $table->string('kelas')->nullable()->after('prodi');

            // Data Diri & Kontak
            $table->string('tempat_lahir')->nullable()->after('kelas');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan', 'Lainnya'])->nullable()->after('tanggal_lahir');
            $table->string('no_hp')->nullable()->after('jenis_kelamin');

            // Data Alamat & Orang Tua (Bisa disesuaikan kebutuhan)
            $table->text('alamat')->nullable()->after('no_hp');
            $table->string('nama_ayah')->nullable()->after('alamat');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nim', 'universitas', 'prodi', 'kelas',
                'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
                'no_hp', 'alamat', 'nama_ayah', 'nama_ibu'
            ]);
        });
    }
};
