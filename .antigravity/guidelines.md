# 🚀 DokaWeb Development Guidelines

Dokumen ini berisi standar pengembangan untuk proyek **DokaWeb** agar tetap konsisten, rapi, dan mudah dipelihara.

## 🏗️ Arsitektur Backend (Service-Repository Pattern)

Setiap modul baru **WAJIB** mengikuti struktur 4-layer:

1.  **Controller**: Hanya menangani request/response dan validasi dasar. Delegasikan logika bisnis ke Service.
2.  **Service**: Tempat logika bisnis utama. Mengolah data sebelum disimpan atau setelah diambil dari database.
3.  **Repository**: Tempat query database (Eloquent). Memisahkan logika data dari logika bisnis.
4.  **Interface**: Digunakan untuk binding Service dan Repository agar mendukung *Dependency Injection*.

## 📁 Struktur Folder Modul

Setiap modul (misal: `ModulBaru`) harus memiliki file di lokasi berikut:

*   **Controller**: `app/Http/Controllers/Master/ModulBaruController.php`
*   **Request**: `app/Http/Requests/Master/ModulBaru/StoreModulBaruRequest.php`
*   **Service**: `app/Services/Master/ModulBaru/ModulBaruService.php` (dan Interface)
*   **Repository**: `app/Repositories/Master/ModulBaru/ModulBaruRepository.php` (dan Interface)
*   **Resource**: `app/Http/Resources/Master/ModulBaruResource.php`
*   **View**: `resources/views/pages/modul-baru/index.blade.php`
*   **Assets**: 
    *   `public/assets/js/modul-baru.js`
    *   `public/assets/css/modul-baru.css`

## 🎨 Standar UI/UX (Premium Feel)

1.  **Tombol Utama**: Gunakan class `.btn-primary-m` dengan ikon Bootstrap Icons.
2.  **Alert/Toast**: Gunakan library `DKA` (DokaAlert):
    *   `DKA.notify({ type: 'success', ... })` untuk notifikasi sukses.
    *   `DKA.loading({ ... })` untuk proses AJAX yang lama.
    *   `DKA.deleteConfirm({ ... })` untuk konfirmasi hapus.
3.  **Form Validation**: Error harus ditampilkan di bawah input dengan class `.finvalid` berwarna merah (`#ef4444`).
4.  **Loading State**: Gunakan spinner atau progress bar saat melakukan request AJAX.

## 🔗 Binding Service & Repository

Jangan lupa mendaftarkan binding di `app/Providers/AppServiceProvider.php` setiap kali membuat modul baru:

```php
$this->app->bind(Interface::class, Implementation::class);
```
