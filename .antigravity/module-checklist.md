# 🛠️ Module Creation Checklist

Gunakan checklist ini saat membuat modul baru untuk memastikan tidak ada layer yang terlewat.

## 1. Database & Model
- [ ] Buat Migration (Gunakan ULID sebagai primary key).
- [ ] Buat Model di folder yang sesuai (misal: `App\Models\Master`).
- [ ] Tambahkan **FULLTEXT Index** pada kolom pencarian utama di migration.
- [ ] Buat Factory & Seeder (Opsional tapi disarankan).

## 2. API & Data Layer
- [ ] Buat `RepositoryInterface` di `app/Repositories/Master/{Module}`.
- [ ] Buat `Repository` implementation.
- [ ] Buat `ServiceInterface` di `app/Services/Master/{Module}`.
- [ ] Buat `Service` implementation.
- [ ] Implementasikan **Server-Side Caching** untuk data statistik.
- [ ] Implementasikan **Cache Invalidation** pada setiap operasi Write (Create/Update/Delete).
- [ ] Buat `Resource` di `app/Http/Resources/Master`.

## 3. Request & Controller
- [ ] Buat `StoreRequest` & `UpdateRequest` di `app/Http/Requests/Master/{Module}`.
- [ ] Buat `Controller` di `app/Http/Controllers/Master`.
- [ ] Daftarkan Routes di `routes/web.php`.
- [ ] Daftarkan Binding di `AppServiceProvider.php`.

## 4. Frontend (UI/UX)
- [ ] Buat `index.blade.php` di `resources/views/pages/{module}`.
- [ ] Buat `partials/modal-view.blade.php` untuk Add/Edit/Detail.
- [ ] Buat `{module}.js` di `public/assets/js`.
- [ ] Buat `{module}.css` di `public/assets/css`.
- [ ] **A11y Audit**: Pastikan semua input memiliki `<label for="...">`.
- [ ] **A11y Audit**: Pastikan semua tombol ikon memiliki `aria-label` dan `title`.

## 5. AJAX Integration
- [ ] Implementasi `loadData()` dengan pagination & search.
- [ ] Implementasi `saveData()` (Add & Edit).
- [ ] Implementasi `deleteData()` dengan `DKA.deleteConfirm`.
- [ ] Implementasi `toggleStatus()` (jika ada).
