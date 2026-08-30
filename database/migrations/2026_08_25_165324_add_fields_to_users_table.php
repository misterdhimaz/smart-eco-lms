<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom belum ada, baru buat
            if (!Schema::hasColumn('users', 'kode_kelas')) {
                $table->string('kode_kelas')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('kode_kelas');
            }

            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('jenis_kelamin');
            }
        });
    }

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['kode_kelas', 'jenis_kelamin', 'foto']);
    });
}
};
