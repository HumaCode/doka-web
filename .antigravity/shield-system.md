# 🛡️ Shield: Role & Permission System

Modul ini bertanggung jawab atas manajemen peran (*roles*) dan hak akses (*permissions*) menggunakan package `spatie/laravel-permission` yang telah dikustomisasi.

## 📁 Struktur Kode
*   **Controller**: `App\Http\Controllers\Shield\RolePermissionController`
*   **Service**: `App\Services\Shield\RolePermission\RolePermissionService`
*   **Repository**: `App\Repositories\Shield\RolePermission\RolePermissionRepository`
*   **Models**: 
    *   `App\Models\Shield\Role` (Custom, mendukung `ULID`, `icon`, `grad_id`, `slug`)
    *   `App\Models\Shield\Permission` (Custom, mendukung `group`, `description`)
*   **Requests**:
    *   `App\Http\Requests\Shield\RoleStoreRequest`
    *   `App\Http\Requests\Shield\RoleUpdateRequest`

## 🔑 Key Features
1.  **ULID Primary Keys**: Menggunakan ULID untuk keamanan dan kemudahan pengurutan data di database.
2.  **Dynamic Matrix UI**: Antarmuka matrix untuk mengelola hak akses banyak role dalam satu tabel.
3.  **Visual Customization**: Setiap role memiliki ikon (Bootstrap Icons) dan warna gradasi yang dapat dikustomisasi.
4.  **Security Bypass**: Role `dev` dan `super-admin` memiliki bypass otomatis melalui `Gate::before` di `AppServiceProvider`.

## 🛣️ Routes & Permissions
| Method | Route Name | Action | Description | Required Permission |
| :--- | :--- | :--- | :--- | :--- |
| `index` | `setting.role-permission.index` | **READ** | Main dashboard matrix | `settings.role` |
| `store` | `setting.role-permission.store` | **CREATE** | Tambah role baru | `settings.role` |
| `update` | `setting.role-permission.update` | **UPDATE** | Perbarui data role | `settings.role` |
| `destroy` | `setting.role-permission.destroy` | **DELETE** | Hapus role (hanya jika kosong) | `settings.role` |
| `sync` | `setting.role-permission.sync` | **UPDATE** | Sinkronisasi hak akses | `settings.role` |

## 🛠️ JS Logic
File JS Utama: `public/assets/js/role-permission.js`
*   `initRolePermission()`: Inisialisasi data dari backend.
*   `renderMatrix()`: Merender tabel matrix hak akses secara dinamis.
*   `savePermissions()`: Mengirim data sinkronisasi via AJAX.
*   `saveRole()`: Mengirim data tambah/edit role via AJAX.

## ⚠️ Security Rules
- Role `dev` dan `super-admin` **tidak dapat dihapus**.
- Role yang masih memiliki pengguna aktif **tidak dapat dihapus** (harus dikosongkan dulu).
- Seluruh pengecekan di Sidebar menggunakan `@can` atau `@canAny`.
- Seluruh Route diproteksi dengan middleware `can:permission_name`.

> [!TIP]
> Saat menambah permission baru, pastikan untuk mengisi kolom `group` di tabel `permissions` agar muncul dengan rapi di matrix UI.
