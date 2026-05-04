# 👤 Profile Management Module

Dokumentasi untuk modul pengelolaan profil pengguna.

## 🏗️ Architecture
Modul ini mengikuti pola standar 4-layer:
- **Interface**: `ProfileServiceInterface`, `ProfileRepositoryInterface`
- **Service**: `ProfileService` (Logika bisnis, upload media, update password)
- **Repository**: `ProfileRepository` (Query database)
- **Controller**: `ProfileController` (Request handling, JSON responses)

## 📁 File Structure
- **Model**: `App\Models\User` (Updated with Spatie Media Library & Relations)
- **Controller**: `App\Http\Controllers\Master\ProfileController`
- **Service**: `App\Services\Master\Profile\ProfileService`
- **Repository**: `App\Repositories\Master\Profile\ProfileRepository`
- **View**: `resources/views/pages/profile/index.blade.php`
- **Assets**: 
  - `public/assets/css/profile.css`
  - `public/assets/js/profile.js` (Integrasi DKA Alert & Spatie Media)

## 🚀 Features
1.  **Statistik Dinamis**: Menampilkan jumlah kegiatan, foto, dan masa keanggotaan (bulan) secara real-time.
2.  **Avatar & Cover (Spatie Media Library)**:
    - Koleksi `avatar`: Foto profil utama (Single file).
    - Koleksi `cover`: Foto sampul profil (Single file).
    - Fallback: Jika media kosong, sistem mengambil dari kolom `avatar` (Google OAuth) atau inisial nama.
3.  **Update Profil**: Mengubah nama, email, telepon, alamat, dan bio via AJAX.
4.  **Keamanan**:
    - Update Password dengan verifikasi password saat ini.
    - Password strength meter.
    - Toggle 2FA (UI Placeholder).
5.  **Aset Terpisah**: CSS dan JS dipisahkan dari Blade untuk performa dan kemudahan maintenance.

## 🛠️ Tech Stack Integration
- **Spatie Media Library**: Digunakan untuk pengelolaan file gambar.
- **DKA Library**: Digunakan untuk notifikasi (`DKA.notify`) dan loader (`DKA.loading`).
- **jQuery AJAX**: Semua aksi simpan dilakukan secara asynchronous.

## 📝 Change Log (2026-05-04)
- Inisialisasi modul profil.
- Migrasi penambahan kolom `address` dan `bio` pada tabel `users`.
- Integrasi Spatie Media Library untuk Avatar dan Cover.
- Perbaikan bug clickability pada tombol cover (z-index fix).
- Perbaikan bug statistik bulan negatif (max calculation fix).
- Standardisasi alert menggunakan DKA Library.
