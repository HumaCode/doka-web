<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\Shield\RoleSeeder;
use Database\Seeders\Master\UnitKerjaSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UnitKerjaSeeder::class,
            UserSeeder::class,
            KategoriSeeder::class,
            \Database\Seeders\Master\KegiatanSeeder::class,
        ]);
    }
}
