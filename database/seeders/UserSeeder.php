<?php

namespace Database\Seeders;

use App\Models\Master\UnitKerja;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. Ambil Unit Kerja
        $unitKerjaIds = UnitKerja::pluck('id')->toArray();

        if (empty($unitKerjaIds)) {
            $this->command->error('Tabel unit_kerja kosong! Jalankan UnitKerjaSeeder terlebih dahulu.');

            return;
        }

        // 1. Konfigurasi Awal
        $mainUsers = ['dev', 'admin', 'user'];
        $rawPassword = '123'; // Password sebelum di-hash

        $default = [
            'email_verified_at' => now(),
            'password' => Hash::make($rawPassword),
            'remember_token' => Str::random(10),
            'is_active' => '1',
            'phone' => '086774446633',
            'gender' => 'l',
            'nik' => '3334445555666677',
            'jabatan' => '-',
            'unit_kerja_id' => $unitKerjaIds[0], // Set default ke instansi pertama untuk user utama
        ];

        $this->command->warn('Sedang membuat user utama...');

        foreach ($mainUsers as $value) {
            $user = User::create([
                ...$default,
                'id' => (string) Str::ulid(),
                'name' => ucwords($value),
                'username' => $value,
                'email' => $value . '@gmail.com',
            ]);

            $user->assignRole($value);
        }

        // 2. Buat 1000 User Tambahan (Role User)
        $this->command->warn('Sedang membuat 1000 user tambahan (ini mungkin memakan waktu)...');

        User::factory()
            ->count(100)
            ->create([
                'unit_kerja_id' => fn() => fake()->randomElement($unitKerjaIds),
            ])
            ->each(function ($u) {
                $u->assignRole('user');
            });

        // 3. Output Laporan Rapi di Terminal
        $this->command->info("\n" . str_repeat('-', 60));
        $this->command->info('   USER SEEDER SELESAI');
        $this->command->info(str_repeat('-', 60));

        $this->command->line('   [ AKUN DEV ]');
        $this->command->line('   Username : dev');
        $this->command->line('   Password : ' . $rawPassword);
        $this->command->line('');

        $this->command->line('   [ AKUN ADMIN ]');
        $this->command->line('   Username : admin');
        $this->command->line('   Password : ' . $rawPassword);
        $this->command->line('');

        $this->command->line('   [ AKUN USER (CONTOH 1 DARI 1000) ]');
        $this->command->line('   Username : user');
        $this->command->line('   Password : ' . $rawPassword);

        $this->command->info(str_repeat('-', 60));
        $this->command->warn(' Total data berhasil di-seed: ' . (User::count()) . ' Users');
        $this->command->info(str_repeat('-', 60) . "\n");
    }
}
