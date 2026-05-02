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
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('judul');
            $table->date('tanggal');
            $table->time('waktu')->nullable();
            $table->string('lokasi')->nullable();
            
            $table->foreignUlid('kategori_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
                  
            $table->foreignUlid('unit_id')
                  ->nullable()
                  ->constrained('unit_kerja')
                  ->onDelete('set null');

            $table->longText('uraian');
            $table->integer('jumlah_peserta')->nullable();
            $table->string('narasumber')->nullable();
            
            $table->enum('status', ['draft', 'berjalan', 'selesai'])->default('draft');
            
            $table->foreignUlid('petugas_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');

            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
