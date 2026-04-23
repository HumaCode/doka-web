<?php

namespace Database\Seeders\Shield;

use Illuminate\Database\Seeder;
use App\Models\Shield\Role; // Pastikan namespace model kustommu yang dipanggil
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name'        => 'dev',
                'slug'        => 'dev',
                'type_role'   => 'system',
                'description' => 'Akses penuh ke sistem dan konfigurasi teknis.',
                'is_active'   => '1',
                'guard_name'  => 'web',
            ],
            [
                'name'        => 'admin',
                'slug'        => 'admin',
                'type_role'   => 'system',
                'description' => 'Mengelola data operasional dan verifikasi dokumentasi.',
                'is_active'   => '1',
                'guard_name'  => 'web',
            ],
            [
                'name'        => 'user',
                'slug'        => 'user',
                'type_role'   => 'system',
                'description' => 'Pengguna standar untuk mencatat dokumentasi kegiatan.',
                'is_active'   => '1',
                'guard_name'  => 'web',
            ],
        ];

        foreach ($roles as $role) {
            // Kita cek dulu datanya ada atau tidak berdasarkan slug
            $existingRole = Role::where('slug', $role['slug'])->first();

            if ($existingRole) {
                // Jika sudah ada, cukup update datanya saja
                $existingRole->update($role);
            } else {
                // Jika belum ada, kita masukkan manual ID ULID-nya di sini
                Role::create(array_merge($role, [
                    'id' => (string) str()->ulid()
                ]));
            }
        }
    }
}
