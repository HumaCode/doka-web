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
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan FULLTEXT index untuk pencarian cepat di skala besar
            $table->fullText(['name', 'email', 'username', 'phone', 'nip', 'nik', 'jabatan'], 'users_search_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropFullText('users_search_fulltext');
        });
    }
};
