# 🔐 Permissions & Methods Map

Dokumen ini mencatat seluruh rute dan method untuk keperluan konfigurasi **Role & Permission**.

---

## 👥 Modul: Pengguna (Users)
**Controller**: `App\Http\Controllers\Master\UserController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `pengguna.index` | **READ** | Halaman manajemen pengguna | `pengguna.view` |
| `getAllPagination` | `pengguna.api.index` | **READ** | Ambil data pengguna (AJAX) | `pengguna.view` |
| `store` | `pengguna.api.store` | **CREATE** | Tambah pengguna baru | `pengguna.create` |
| `show` | `pengguna.api.show` | **READ** | Detail pengguna untuk Edit | `pengguna.view` |
| `update` | `pengguna.api.update` | **UPDATE** | Perbarui data pengguna | `pengguna.edit` |
| `destroy` | `pengguna.api.destroy` | **DELETE** | Hapus satu pengguna | `pengguna.delete` |
| `destroyBulk` | `pengguna.api.destroy-bulk` | **DELETE** | Hapus banyak pengguna sekaligus | `pengguna.delete` |
| `toggleStatus` | `pengguna.api.toggle-status`| **UPDATE** | Aktif/Nonaktifkan akun | `pengguna.edit` |

---

## 🏛️ Modul: Unit Kerja
**Controller**: `App\Http\Controllers\Master\UnitKerjaController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `unit-kerja.index` | **READ** | Halaman manajemen unit kerja | `unit_kerja.view` |
| `getAllPagination` | `unit-kerja.api.index` | **READ** | Ambil data unit (AJAX) | `unit_kerja.view` |
| `store` | `unit-kerja.api.store` | **CREATE** | Tambah unit kerja baru | `unit_kerja.create` |
| `show` | `unit-kerja.api.show` | **READ** | Detail unit untuk Edit | `unit_kerja.view` |
| `update` | `unit-kerja.api.update` | **UPDATE** | Perbarui data unit | `unit_kerja.edit` |
| `destroy` | `unit-kerja.api.destroy` | **DELETE** | Hapus unit kerja | `unit_kerja.delete` |
 
---

## 📊 Modul: Laporan
**Controller**: `App\Http\Controllers\Laporan\LaporanController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `bulanan` | `laporan.bulanan` | **READ** | Laporan kegiatan bulanan & ekspor | `laporan.view` |
| `toggleStatus` | `unit-kerja.api.toggle-status`| **UPDATE** | Aktif/Nonaktifkan unit | `unit_kerja.edit` |
| `bulkDelete` | `unit-kerja.api.bulk-delete` | **DELETE** | Hapus banyak unit sekaligus | `unit_kerja.delete` |
| `bulkToggleStatus` | `unit-kerja.api.bulk-toggle` | **UPDATE** | Ubah status banyak unit | `unit_kerja.edit` |

---

## 🏷️ Modul: Kategori
**Controller**: `App\Http\Controllers\Master\CategoryController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `kategori.index` | **READ** | Halaman manajemen kategori | `kategori.view` |
| `getAllPagination` | `kategori.api.index` | **READ** | Ambil data kategori (AJAX) | `kategori.view` |
| `store` | `kategori.api.store` | **CREATE** | Tambah kategori baru | `kategori.create` |
| `update` | `kategori.api.update` | **UPDATE** | Perbarui data kategori | `kategori.edit` |
| `destroy` | `kategori.api.destroy` | **DELETE** | Hapus kategori | `kategori.delete` |
| `toggleStatus` | `kategori.api.toggle-status`| **UPDATE** | Aktif/Nonaktifkan kategori | `kategori.edit` |

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
| `bulkDelete` | `kegiatan.bulk-delete` | **DELETE** | Hapus banyak kegiatan | `kegiatan.delete` |
| `download` | `kegiatan.download` | **READ** | Unduh lampiran private | `kegiatan.download` |

---

## 🖼️ Modul: Galeri Foto
**Controller**: `App\Http\Controllers\Kegiatan\GaleriController`

| Method | Route Name | Action | Deskripsi | Rekomendasi Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `galeri.index` | **READ** | Halaman galeri foto | `galeri.view` |
| `store` | `galeri.store` | **CREATE** | Upload foto ke kegiatan | `galeri.upload` |
| `destroy` | `galeri.destroy` | **DELETE** | Hapus satu/banyak foto | `galeri.delete` |
| `downloadZip` | `galeri.download-zip` | **EXPORT** | Unduh ZIP per folder | `galeri.download` |

---

## 📝 Catatan Implementasi
- Semua rute dengan suffix `.api` mengembalikan JSON.
- Pastikan Middleware `PermissionMiddleware` dari Spatie sudah didaftarkan di `Kernel.php`.
- Gunakan `$this->middleware('permission:name')` di constructor controller untuk proteksi level method.
