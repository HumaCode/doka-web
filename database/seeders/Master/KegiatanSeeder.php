<?php

namespace Database\Seeders\Master;

use App\Models\Kegiatan\Kegiatan;
use Illuminate\Database\Seeder;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Matikan event model untuk mempercepat proses seeding
        // Kegiatan::flushEventListeners(); // Opsional jika ingin sangat cepat

        $this->command->info('Menyiapkan 500 data kegiatan...');

        // 2. Gunakan chunking atau buat secara langsung
        Kegiatan::factory()->count(500)->create();

        // 3. Tampilkan output sesuai permintaan user
        $this->command->info(str_repeat('-', 60));
        $this->command->warn(' Total data berhasil di-seed: '.(Kegiatan::count()).' Kegiatan');
        $this->command->info(str_repeat('-', 60)."\n");
    }
}
