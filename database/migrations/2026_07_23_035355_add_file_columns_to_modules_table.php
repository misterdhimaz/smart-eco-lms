<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            // Menambahkan kolom untuk nama file sampul dan dokumen
            $table->string('cover_image')->nullable()->after('description');
            $table->string('document_file')->nullable()->after('cover_image');
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'document_file']);
        });
    }
};
