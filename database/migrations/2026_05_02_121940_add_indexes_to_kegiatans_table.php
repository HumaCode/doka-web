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
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->index('judul');
            $table->index('status');
            $table->index('tanggal');
            $table->index('created_at');
            
            // Fulltext search index
            $table->fullText(['judul', 'uraian', 'lokasi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropIndex(['judul']);
            $table->dropIndex(['status']);
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['created_at']);
            $table->dropFullText(['judul', 'uraian', 'lokasi']);
        });
    }
};
