# 🖼️ Galeri Foto Module

Modul Galeri Foto diimplementasikan dengan standar Clean Code menggunakan arsitektur 4-Layer dan integrasi Spatie Media Library.

## 🏗️ Architecture
- **Controller**: `app/Http/Controllers/Kegiatan/GaleriController.php` (Handling requests & responses).
- **Service**: `app/Services/Kegiatan/GaleriService.php` (Business logic: ZIP generation, Media orchestration).
- **Repository**: `app/Repositories/Kegiatan/GaleriRepository.php` (Data access: Spatie Media queries, Mock data generation).
- **Resource**: `app/Http/Resources/Galeri/GaleriResource.php` (Data transformation for JS).

## 🚀 Key Features
1. **Horizontal Masonry Grid**: Layout artistik (Pinterest-style) namun dengan urutan pengisian horizontal (kiri ke kanan) menggunakan CSS Grid Spans.
2. **Dynamic ZIP Download**: Mengunduh foto dalam format ZIP dengan pengelompokan otomatis per folder berdasarkan Judul Kegiatan.
3. **Premium File Uploader**:
   - Drag & drop support.
   - Live image preview sebelum upload.
   - Select2 integration untuk pencarian kegiatan di dalam modal.
4. **Bulk Management**:
   - Penghapusan massal (Bulk Delete).
   - Unduh massal (Bulk Download) berdasarkan filter aktif atau pilihan checkbox.
5. **Deterministic Statistics**: Angka statistik (Total Foto, Ukuran, Bulan Ini) bersifat stabil dan konsisten karena menggunakan logika ID-based generation untuk data simulasi.

## 🛠️ Technical Details
- **Media Library**: Menggunakan `Spatie\MediaLibrary` untuk manajemen file fisik dan database.
- **Archive**: Menggunakan `ZipArchive` untuk penggabungan file server-side sebelum diunduh.
- **UI/UX**: Vanilla CSS + Fetch API + SweetAlert2 (via DKA Wrapper).
- **Consistency**: Statistik dikunci menggunakan `crc32()` dari ID media agar tidak berubah saat reload halaman.

## 📄 Core Files
- `resources/views/pages/galery/index.blade.php`
- `app/Repositories/Kegiatan/GaleriRepository.php`
- `app/Services/Kegiatan/GaleriService.php`
- `app/Http/Controllers/Kegiatan/GaleriController.php`
- `routes/web.php`
