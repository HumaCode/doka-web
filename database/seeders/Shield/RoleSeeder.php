<?php

namespace Database\Seeders\Shield;

use Illuminate\Database\Seeder;
use App\Models\Shield\Role;
use App\Models\Shield\Permission;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Permissions
        $permissions = [
            // Dashboard
            ['name' => 'dashboard.view', 'group' => 'Dashboard', 'description' => 'Akses halaman dashboard utama'],
            ['name' => 'dashboard.stats', 'group' => 'Dashboard', 'description' => 'Melihat data statistik ringkasan'],

            // Kegiatan
            ['name' => 'kegiatan.view', 'group' => 'Kegiatan', 'description' => 'Melihat daftar dan detail kegiatan'],
            ['name' => 'kegiatan.create', 'group' => 'Kegiatan', 'description' => 'Membuat dokumentasi kegiatan baru'],
            ['name' => 'kegiatan.edit', 'group' => 'Kegiatan', 'description' => 'Mengubah data kegiatan yang ada'],
            ['name' => 'kegiatan.delete', 'group' => 'Kegiatan', 'description' => 'Menghapus kegiatan dari sistem'],
            ['name' => 'kegiatan.publish', 'group' => 'Kegiatan', 'description' => 'Mengubah status draft ke selesai'],

            // Foto & Galeri
            ['name' => 'foto.view', 'group' => 'Foto & Galeri', 'description' => 'Mengakses halaman galeri foto'],
            ['name' => 'foto.upload', 'group' => 'Foto & Galeri', 'description' => 'Mengunggah foto kegiatan baru'],
            ['name' => 'foto.delete', 'group' => 'Foto & Galeri', 'description' => 'Menghapus foto dari galeri'],
            ['name' => 'foto.dl', 'group' => 'Foto & Galeri', 'description' => 'Mengunduh foto secara individual atau massal'],

            // Laporan
            ['name' => 'laporan.view', 'group' => 'Laporan', 'description' => 'Mengakses halaman laporan bulanan'],
            ['name' => 'laporan.export', 'group' => 'Laporan', 'description' => 'Export laporan ke PDF atau Excel'],
            ['name' => 'laporan.print', 'group' => 'Laporan', 'description' => 'Mencetak laporan bulanan'],

            // Master Data
            ['name' => 'kategori.manage', 'group' => 'Master Data', 'description' => 'CRUD kategori kegiatan'],
            ['name' => 'unitkerja.manage', 'group' => 'Master Data', 'description' => 'CRUD unit kerja / OPD'],

            // Pengguna
            ['name' => 'user.view', 'group' => 'Pengguna', 'description' => 'Melihat daftar pengguna'],
            ['name' => 'user.create', 'group' => 'Pengguna', 'description' => 'Menambah akun pengguna baru'],
            ['name' => 'user.edit', 'group' => 'Pengguna', 'description' => 'Mengubah data pengguna'],
            ['name' => 'user.delete', 'group' => 'Pengguna', 'description' => 'Menghapus akun pengguna'],
            ['name' => 'user.role', 'group' => 'Pengguna', 'description' => 'Mengubah role / hak akses pengguna'],

            // Pengaturan Sistem
            ['name' => 'settings.view', 'group' => 'Pengaturan Sistem', 'description' => 'Mengakses halaman pengaturan sistem'],
            ['name' => 'settings.edit', 'group' => 'Pengaturan Sistem', 'description' => 'Mengubah konfigurasi sistem'],
            ['name' => 'settings.role', 'group' => 'Pengaturan Sistem', 'description' => 'Menambah/mengubah/menghapus role'],
            ['name' => 'settings.backup', 'group' => 'Pengaturan Sistem', 'description' => 'Membuat dan restore backup data'],
        ];

        foreach ($permissions as $perm) {
            $existingPerm = Permission::where('name', $perm['name'])->first();
            if ($existingPerm) {
                $existingPerm->update($perm);
            } else {
                Permission::create(array_merge($perm, [
                    'id' => (string) str()->ulid(),
                    'guard_name' => 'web'
                ]));
            }
        }

        // 2. Create Roles
        $roles = [
            [
                'name'        => 'dev',
                'slug'        => 'dev',
                'description' => 'Akses penuh ke sistem dan konfigurasi teknis.',
                'icon'        => 'bi-shield-fill',
                'grad_id'     => 0,
            ],
            [
                'name'        => 'admin',
                'slug'        => 'admin',
                'description' => 'Mengelola data, pengguna, dan konfigurasi umum sistem.',
                'icon'        => 'bi-shield-lock-fill',
                'grad_id'     => 1,
            ],
            [
                'name'        => 'operator',
                'slug'        => 'operator',
                'description' => 'Menginput dan mengelola data kegiatan serta foto.',
                'icon'        => 'bi-person-badge-fill',
                'grad_id'     => 2,
            ],
            [
                'name'        => 'fotografer',
                'slug'        => 'fotografer',
                'description' => 'Upload foto, mengelola galeri, dan mengakses laporan.',
                'icon'        => 'bi-camera-fill',
                'grad_id'     => 3,
            ],
            [
                'name'        => 'user',
                'slug'        => 'user',
                'description' => 'Hanya dapat melihat data dan laporan. Tidak dapat mengedit.',
                'icon'        => 'bi-eye-fill',
                'grad_id'     => 4,
            ],
        ];

        foreach ($roles as $r) {
            $role = Role::where('slug', $r['slug'])->first();
            if ($role) {
                $role->update($r);
            } else {
                $role = Role::create(array_merge($r, [
                    'id' => (string) str()->ulid(),
                    'type_role' => 'system',
                    'is_active' => '1',
                    'guard_name' => 'web'
                ]));
            }

            // Assign permissions
            if ($r['name'] === 'dev') {
                $role->syncPermissions(Permission::all());
            } elseif ($r['name'] === 'administrator') {
                $role->syncPermissions(Permission::where('name', 'not like', 'settings.role%')->where('name', 'not like', 'settings.backup%')->get());
            } elseif ($r['name'] === 'operator') {
                $role->syncPermissions(['dashboard.view', 'dashboard.stats', 'kegiatan.view', 'kegiatan.create', 'kegiatan.edit', 'foto.view', 'foto.upload', 'foto.dl', 'laporan.view', 'user.view']);
            } elseif ($r['name'] === 'fotografer') {
                $role->syncPermissions(['dashboard.view', 'kegiatan.view', 'foto.view', 'foto.upload', 'foto.delete', 'foto.dl', 'laporan.view']);
            } elseif ($r['name'] === 'viewer') {
                $role->syncPermissions(['dashboard.view', 'dashboard.stats', 'kegiatan.view', 'foto.view', 'foto.dl', 'laporan.view']);
            }
        }
    }
}
