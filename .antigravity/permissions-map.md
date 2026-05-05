# 🔐 Permissions & Methods Map

Dokumen ini mencatat seluruh rute dan method untuk keperluan konfigurasi **Role & Permission**.

---

## 👥 Modul: Pengguna (Users)
**Controller**: `App\Http\Controllers\Master\Pengguna\UserController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `pengguna.index` | **READ** | Halaman manajemen pengguna | `user.view` |
| `getAllPagination` | `pengguna.getallpagination` | **READ** | Ambil data pengguna (AJAX) | `user.view` |
| `store` | `pengguna.store` | **CREATE** | Tambah pengguna baru | `user.create` |
| `show` | `pengguna.show` | **READ** | Detail pengguna untuk Edit | `user.view` |
| `update` | `pengguna.update` | **UPDATE** | Perbarui data pengguna | `user.edit` |
| `destroy` | `pengguna.destroy` | **DELETE** | Hapus satu pengguna | `user.delete` |

---

## 🏛️ Modul: Unit Kerja
**Controller**: `App\Http\Controllers\Master\UnitKerja\UnitKerjaController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `unit-kerja.index` | **READ** | Halaman manajemen unit kerja | `unitkerja.manage` |
| `getAllPagination` | `unit-kerja.getallpagination` | **READ** | Ambil data unit (AJAX) | `unitkerja.manage` |
| `store` | `unit-kerja.store` | **CREATE** | Tambah unit kerja baru | `unitkerja.manage` |
| `show` | `unit-kerja.show` | **READ** | Detail unit untuk Edit | `unitkerja.manage` |
| `update` | `unit-kerja.update` | **UPDATE** | Perbarui data unit | `unitkerja.manage` |
| `destroy` | `unit-kerja.destroy` | **DELETE** | Hapus unit kerja | `unitkerja.manage` |
 
---

## 📊 Modul: Laporan
**Controller**: `App\Http\Controllers\Laporan\LaporanController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `bulanan` | `laporan.bulanan` | **READ** | Laporan kegiatan bulanan | `laporan.view` |
| `exportPdf` | `laporan.export` | **EXPORT** | Ekspor laporan ke PDF | `laporan.export` |

---

## 🏷️ Modul: Kategori
**Controller**: `App\Http\Controllers\Master\Kategori\CategoryController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `kategori.index` | **READ** | Halaman manajemen kategori | `kategori.manage` |
| `getAllPagination` | `kategori.getallpagination` | **READ** | Ambil data kategori (AJAX) | `kategori.manage` |
| `store` | `kategori.store` | **CREATE** | Tambah kategori baru | `kategori.manage` |
| `update` | `kategori.update` | **UPDATE** | Perbarui data kategori | `kategori.manage` |
| `destroy` | `kategori.destroy` | **DELETE** | Hapus kategori | `kategori.manage` |

---

## 📅 Modul: Kegiatan
**Controller**: `App\Http\Controllers\Kegiatan\KegiatanController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `kegiatan.index` | **READ** | Halaman daftar kegiatan | `kegiatan.view` |
| `show` | `kegiatan.show` | **READ** | Detail lengkap kegiatan | `kegiatan.view` |
| `create` | `kegiatan.create` | **CREATE** | Halaman form tambah kegiatan | `kegiatan.create` |
| `store` | `kegiatan.store` | **CREATE** | Simpan kegiatan baru | `kegiatan.create` |
| `edit` | `kegiatan.edit` | **UPDATE** | Halaman form edit kegiatan | `kegiatan.edit` |
| `update` | `kegiatan.update` | **UPDATE** | Perbarui data kegiatan | `kegiatan.edit` |
| `destroy` | `kegiatan.destroy` | **DELETE** | Hapus kegiatan | `kegiatan.delete` |

---

## 🖼️ Modul: Galeri Foto
**Controller**: `App\Http\Controllers\Kegiatan\GaleriController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `galeri.index` | **READ** | Halaman galeri foto | `foto.view` |
| `upload` | `galeri.upload` | **CREATE** | Upload foto ke kegiatan | `foto.upload` |
| `destroy` | `galeri.destroy` | **DELETE** | Hapus satu/banyak foto | `foto.delete` |

---

## ⚙️ Modul: Pengaturan Role & Permission
**Controller**: `App\Http\Controllers\Shield\RolePermissionController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `setting.role-permission.index` | **READ** | Dashboard akses & role | `settings.role` |
| `store` | `setting.role-permission.store` | **CREATE** | Tambah role baru | `settings.role` |
| `update` | `setting.role-permission.update` | **UPDATE** | Edit role | `settings.role` |
| `destroy` | `setting.role-permission.destroy` | **DELETE** | Hapus role | `settings.role` |
| `sync` | `setting.role-permission.sync` | **UPDATE** | Simpan hak akses | `settings.role` |

---

## 📝 Catatan Implementasi
- Gunakan `@can('permission.name')` di Blade untuk membatasi UI.
- Gunakan `->middleware('can:permission.name')` di Route untuk keamanan sisi server.
- Role `dev` dan `super-admin` memiliki akses penuh otomatis.
