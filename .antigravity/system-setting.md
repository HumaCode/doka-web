# ⚙️ System Setting Module

Dokumentasi untuk modul pengaturan sistem aplikasi.

## 🏗️ Architecture
Modul ini mengikuti pola standar 4-layer:
- **Interface**: `SystemSettingServiceInterface`, `SystemSettingRepositoryInterface`
- **Service**: `SystemSettingService` (Logika bisnis, caching, security stats, activity logs, upload media)
- **Repository**: `SystemSettingRepository` (Query database key-value)
- **Controller**: `SystemSettingController` (Thin Controller, standardized JSON responses)

## 📁 File Structure
- **Model**: `App\Models\Master\SystemSetting`, `App\Models\Master\SystemLog`
- **Controller**: `App\Http\Controllers\Master\SystemSettingController`
- **Service**: `App\Services\Master\SystemSetting\SystemSettingService`
- **Repository**: `App\Repositories\Master\SystemSetting\SystemSettingRepository`
- **Request**: `App\Http\Requests\Master\SystemSetting\UpdateSystemSettingRequest`
- **View**: `resources/views/pages/setting/system-setting/index.blade.php`
- **Assets**: 
  - `public/assets/css/system-setting.css`
  - `public/assets/js/system-setting.js`

## 🚀 Features
1.  **Pengaturan Umum**: Nama aplikasi, URL, deskripsi, bahasa, zona waktu, dan format tanggal.
2.  **Identitas Visual**: Upload Logo (Light/Dark) dan Favicon menggunakan Spatie Media Library.
3.  **Security Monitor**: Statistik serangan (attack attempt) dan login gagal, serta log keamanan terbaru.
4.  **Database Backup**: Pembuatan backup database (format .sql) menggunakan PHP Native (tidak butuh mysqldump) dan disimpan via Media Library.
5.  **Caching**: Pengaturan disimpan dalam cache selama 1 jam. Statistik keamanan di-cache 5 menit untuk performa.

## 🛡️ Security Logic
- **Logging**: Setiap update setting dan upload asset dicatat ke `system_logs`.
- **Throttling**: (Internal) Monitoring percobaan login ilegal dan akses path berbahaya.

## 🛠️ Tech Stack Integration
- **Spatie Media Library**: Digunakan untuk pengelolaan logo, favicon, dan file backup.
- **DKA Library**: Digunakan untuk notifikasi, loader, dan konfirmasi hapus.
- **ApiResponser**: Trait untuk standarisasi response JSON `{success, message, data}`.

## 📝 Change Log (2026-05-04)
- **Optimization**: Implementasi caching pada media URLs dan security stats.
- **Refactoring**: Memindahkan seluruh logika query dari Controller ke Service.
- **Expansion**: Integrasi fitur Security Monitor dan Backup Database ke dalam panel utama.
- **Standardization**: Migrasi response ke format `ApiResponser`.
