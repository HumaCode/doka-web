<?php

namespace Database\Seeders;

use App\Models\Master\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kategori::factory()->count(100)->create();
    }
}
