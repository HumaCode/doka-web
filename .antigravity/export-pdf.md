# 📄 Modul: Export PDF

Modul ini digunakan untuk mengekspor berbagai data sistem (Kegiatan, Statistik, Galeri) ke dalam format PDF dengan opsi kustomisasi yang luas.

## ✨ Fitur Utama
1. **Multi-Document Type**: Mendukung ekspor Laporan Bulanan, Daftar Kegiatan, Galeri Foto, Rekap Unit, Detail Kegiatan, dan Laporan Kustom.
2. **Dynamic Preview (PDF Viewer Style)**: Pratinjau tampilan PDF dengan navigasi halaman, thumbnail sidebar, dan scroll antar halaman yang responsif.
3. **Advanced Filtering**: Filter rentang bulan (Mulai - Akhir), Tahun, Unit Kerja, Kategori, dan Status.
4. **PDF Options**: Pengaturan ukuran kertas (A4, A3, F4, Letter), orientasi (Portrait/Landscape), serta opsi watermark dan kompresi gambar.
5. **Configuration Sync**: Semua switch (Cover, Grafik, Foto, Footer, Watermark) di halaman konfigurasi otomatis sinkron ke preview via URL params.
6. **Print-Optimized**: Layout cetak yang rapi dengan 16 baris data per halaman, page break otomatis, dan UI chrome tersembunyi saat print.
7. **Export History**: Mencatat riwayat unduhan PDF dengan fitur unduh ulang dan hapus riwayat.
8. **Server-Side PDF Generation**: Menggunakan **DomPDF** (`barryvdh/laravel-dompdf`) untuk generate file PDF asli dari data real.
9. **Download Route**: Route dedicated `GET /export-pdf/{id}/download` untuk unduh file PDF dari history.
10. **Real Photo Display**: Galeri Foto dan Detail Kegiatan menampilkan foto asli dari Spatie Media Library (collection `foto_kegiatan`).

## 📐 Layout per Jenis Dokumen

Setiap jenis dokumen memiliki "karakter" tampilan yang berbeda:

| Jenis | Target Pembaca | Karakter | Layout |
|-------|---------------|----------|--------|
| **Laporan Bulanan** | Pimpinan/Kepala Dinas | Pencapaian | Statistik + Grafik Batang + Tabel |
| **Daftar Kegiatan** | Admin/Auditor/Arsip | Kelengkapan Data | Tabel compact langsung (tanpa ringkasan) |
| **Rekap Per Unit** | Evaluasi Internal | Akuntabilitas Unit | Tabel dikelompokkan per Unit Kerja (group header) |
| **Detail Kegiatan** | Dokumentasi Khusus | Narasi Mendalam | Layout Kartu (foto + deskripsi, 3 per halaman) |
| **Galeri Foto** | Humas/Dokumentasi Visual | Gambar | Grid 2 kolom langsung (tanpa ringkasan) |
| **Laporan Kustom** | Fleksibel | Komprehensif | Sama dengan Laporan Bulanan |

### Aturan Halaman per Jenis:
- **Galeri Foto, Daftar Kegiatan, Detail Kegiatan**: Halaman Ringkasan/Statistik **dilewati** — langsung ke konten setelah Cover.
- **Laporan Bulanan, Rekap Unit, Kustom**: Halaman Ringkasan/Statistik **ditampilkan** dengan grafik dan data agregat.

## 🔧 Konfigurasi Data per Halaman

### Preview (Browser - `preview-pdf.blade.php`)
- **Tabel (Bulanan, Daftar, Rekap, Kustom)**: `16 baris per halaman`
- **Galeri Foto**: `6 item per halaman` (grid 2x3)
- **Detail Kegiatan**: `3 kartu per halaman`

### Export PDF (DomPDF - `export-pdf-render.blade.php`)
- **Tabel**: `13 baris per halaman` (DomPDF render lebih tinggi per baris)
- **Galeri Foto**: `4 item per halaman`
- **Detail Kegiatan**: `2 kartu per halaman`

> **Catatan**: DomPDF dan browser memiliki metric font berbeda. Jika baris per halaman terlalu banyak, sisa data akan tumpah ke halaman baru yang nyaris kosong. Angka di atas sudah disesuaikan.

## 🎨 Thumbnail Sidebar (Preview)

Thumbnail di sidebar kiri menampilkan **skeleton UI** yang merepresentasikan isi halaman:
- **Ringkasan**: Kotak statistik + grafik batang mini.
- **Tabel Data**: Header biru + baris-baris data 3 kolom.
- **Galeri Foto**: Grid 2x2 kotak foto berwarna.
- **Detail Kegiatan**: Layout kartu (foto kecil + teks).

Warna menggunakan kontras tinggi (`#94a3b8`, `#475569`, `#4f46e5`) agar terlihat jelas.

## 🖨️ Print Styles (`@media print`)

Saat mencetak (Ctrl+P / tombol Cetak):
- **UI tersembunyi**: Toolbar, sidebar, status bar, page label otomatis disembunyikan.
- **Page break**: Setiap halaman PDF mendapat `page-break-after: always`.
- **Margin**: `10mm` pada semua sisi kertas.
- **Warna akurat**: `print-color-adjust: exact` untuk menjaga gradient dan badge.
- **Clean layout**: Box shadow dan transform dihapus.

## 🔗 Sinkronisasi Switch Konfigurasi

Switch di halaman `export-pdf.blade.php` dikirim sebagai URL params ke preview:

| Switch | Parameter | CSS Class Toggle |
|--------|-----------|-----------------|
| Cover Page | `show_cover` | `.show-cover` on body |
| Grafik & Chart | `show_chart` | `.hide-charts` on body |
| Foto Kegiatan | `show_photo` | `.hide-photo` on body |
| Nomor Halaman | `show_page_number` | `.hide-footer` on body |
| Watermark | `show_watermark` | `.show-watermark` on body |
| Kompresi Gambar | `compress_image` | Backend only |

Fungsi `previewFull()` dan `doExport()` di `export-pdf.js` membaca state checkbox secara real-time.

## 🛠️ Detail Teknis
- **Controller**: `App\Http\Controllers\Laporan\ExportController`
- **Service**: `App\Services\Laporan\ExportService` (implements `ExportServiceInterface`)
- **Repository**: `App\Repositories\Laporan\ExportRepository` (implements `ExportRepositoryInterface`)
- **Model**: `App\Models\Laporan\ExportHistory` (Spatie HasMedia, collection `export_files`)
- **PDF Library**: `barryvdh/laravel-dompdf` v3.1
- **Sidebar State**: Secara otomatis dalam posisi *collapsed* saat mengakses halaman ini.

### Routes
| Route | Method | Name | Deskripsi |
|-------|--------|------|-----------|
| `laporan/export-pdf` | GET | `laporan.export-pdf` | Halaman konfigurasi |
| `laporan/export-pdf` | POST | `laporan.export-pdf.store` | Generate & simpan PDF |
| `laporan/export-pdf/preview` | GET | `laporan.export-pdf.preview` | Preview stats (AJAX) |
| `laporan/export-pdf/preview-full` | GET | `laporan.export-pdf.preview-full` | Preview full page |
| `laporan/export-pdf/{id}/download` | GET | `laporan.export-pdf.download` | Download file PDF |
| `laporan/export-pdf/{id}` | DELETE | `laporan.export-pdf.destroy` | Hapus history |

### Assets
- CSS: `public/assets/css/export-pdf.css`
- JS: `public/assets/js/export-pdf.js`

## 📂 File Kunci
- `resources/views/pages/laporan/preview-pdf.blade.php` — Preview interaktif (browser, dengan toolbar/sidebar).
- `resources/views/pages/laporan/export-pdf-render.blade.php` — Template DomPDF (server-side, tanpa UI chrome).
- `resources/views/pages/laporan/export-pdf.blade.php` — Halaman konfigurasi (switch, filter, tombol export).
- `public/assets/js/export-pdf.js` — Engine utama (preview, export AJAX, history management).
- `public/assets/css/export-pdf.css` — Styling halaman konfigurasi.
- `app/Services/Laporan/ExportService.php` — Logika generate PDF via DomPDF.
- `app/Repositories/Laporan/ExportRepository.php` — Query data kegiatan + history management.

## 🚀 Riwayat Implementasi

### Update 2026-05-03 (Sesi 1)
- **Modular Assets**: Memisahkan style dan logic ke file eksternal.
- **Blade Integration**: Menggunakan `x-master-layout` dengan data dinamis.

### Update 2026-05-03 (Sesi 2 — Preview & Print)
- **PDF Viewer Style Preview**: Scroll continuous + thumbnail sidebar + navigasi halaman.
- **Layout per Jenis Dokumen**: Setiap tipe laporan memiliki tampilan unik.
- **Sinkronisasi Switch**: Semua opsi di konfigurasi dikirim ke preview via URL params.
- **Print Optimization**: 16 baris per halaman, page-break otomatis, UI tersembunyi saat print.
- **Thumbnail Enhancement**: Skeleton UI dengan kontras tinggi dan ikon representatif.
- **Hapus Halaman Kosong**: Galeri & Daftar langsung ke konten tanpa halaman ringkasan.
- **Nomor Urut Sequential**: Penomoran tabel 1, 2, 3... berurutan antar halaman.
- **Rekap Unit Grouped**: Data dikelompokkan per Unit Kerja dengan header pemisah.
- **Detail Kegiatan Card Layout**: Tampilan kartu dengan foto + deskripsi lengkap.

### Update 2026-05-04 (Sesi 3 — Server-Side PDF & Download)
- **DomPDF Integration**: Install `barryvdh/laravel-dompdf` untuk generate PDF asli.
- **Template `export-pdf-render.blade.php`**: Blade khusus DomPDF — CSS inline, tanpa external fonts/icons, table-based chart.
- **Download Route**: `GET /export-pdf/{id}/download` dengan controller method `download()`.
- **History Download Button**: Tombol download di tabel riwayat sekarang fungsional via `downloadHist()` JS.
- **Real Data Export**: `processExport()` mengambil data real dari database (bukan dummy file).
- **Page Count Accurate**: Jumlah halaman dihitung dari output PDF real (`preg_match_all`).
- **PerPage Tuning**: Dikurangi ke 13/4/2 untuk DomPDF agar tidak overflow ke halaman kosong.
- **Real Photo in Preview**: Galeri Foto & Detail Kegiatan menampilkan foto asli dari `foto_kegiatan` collection.
- **Eager Load Media**: Repository query sekarang `with(['kategori', 'unitKerja', 'media'])` + `withCount('media as media_count')`.
- **Service Layer**: Tambah method `getDownloadMedia()` di ExportService.
- **Repository Layer**: Tambah method `findHistory()` di ExportRepository.

## ⚠️ Alur Export PDF (Server-Side)
```
User klik "Export PDF Sekarang"
→ JS POST ke /export-pdf (dengan filters + options)
→ ExportService::processExport()
  1. Query kegiatan dari DB (dengan filter)
  2. Render export-pdf-render.blade.php via DomPDF
  3. setPaper(size, orientation)
  4. output() → binary PDF
  5. Hitung page count dari PDF content
  6. Simpan ke storage/app/temp/ → attach ke Spatie Media (collection: export_files)
  7. Return ExportHistory + download_url
→ JS update tabel riwayat + notifikasi sukses
→ Tombol download → GET /export-pdf/{id}/download → response()->download()
```
