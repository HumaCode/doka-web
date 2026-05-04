# 📜 Activity Log Module

Dokumentasi untuk sistem monitoring aktivitas pengguna.

## 🏗️ Architecture
Modul ini menggunakan **Spatie Activity Log** yang telah dikustomisasi untuk mendukung **ULID**.
- **Interface**: `ActivityLogServiceInterface`, `ActivityLogRepositoryInterface`
- **Service**: `ActivityLogService` (Formatting data, stats calculation)
- **Repository**: `ActivityLogRepository` (Advanced filtering, ULID queries)
- **Resource**: `ActivityLogResource` (JSON Transformation)

## 🔑 Key Features
1.  **ULID Support**: Menggunakan ULID sebagai Primary Key untuk keamanan dan performa indexing.
2.  **Advanced Filtering**: Filter berdasarkan user, jenis event (created, updated, deleted), modul, dan pencarian teks.
3.  **Standardized Pagination**: Menggunakan `PaginateResource` untuk konsistensi meta data di frontend.
4.  **Interactive Detail**: Modal detail yang menampilkan data perubahan (properties) dalam format JSON yang cantik.

## 📁 File Structure
- **Model**: `App\Models\Activity` (Custom model with `HasUlids`)
- **Controller**: `App\Http\Controllers\Master\ActivityLogController`
- **Service**: `App\Services\Master\ActivityLog\ActivityLogService`
- **Repository**: `App\Repositories\Master\ActivityLog\ActivityLogRepository`
- **Resource**: `App\Http\Resources\Master\ActivityLogResource`
- **View**: `resources/views/pages/setting/activity-log/index.blade.php`
- **JS**: `public/assets/js/activity-log.js`

## 🛠️ Implementation Details
- **Migration**: Tabel `activity_log` dimodifikasi menggunakan `$table->ulid('id')->primary()`.
- **Global Toggle**: Fitur logging dapat diaktifkan/nonaktifkan melalui panel Pengaturan Sistem.
- **Resource Pattern**: 
  ```php
  $resource = PaginateResource::make($logs, ActivityLogResource::class)->toArray(request());
  ```

## 📝 Change Log (2026-05-04)
- **ULID Migration**: Mengubah integer ID menjadi ULID.
- **Architecture Refactor**: Implementasi Service-Repository pattern agar sejalan dengan modul Kategori.
- **Clean Code**: Pembersihan Controller (Thin Controller) dan pemindahan logika ke Service.
- **UI Upgrade**: Penyesuaian tombol aksi dan modal detail agar lebih premium.
