<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('unit_kerja', function (Blueprint $table) {
            $table->fullText(['nama_instansi', 'singkatan', 'nama_kepala', 'deskripsi', 'alamat'], 'unit_kerja_search_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unit_kerja', function (Blueprint $table) {
            $table->dropFullText('unit_kerja_search_fulltext');
        });
    }
};
