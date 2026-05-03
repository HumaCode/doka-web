# 📄 Modul: Export PDF

Modul ini digunakan untuk mengekspor berbagai data sistem (Kegiatan, Statistik, Galeri) ke dalam format PDF dengan opsi kustomisasi yang luas.

## ✨ Fitur Utama
1. **Multi-Document Type**: Mendukung ekspor Laporan Bulanan, Daftar Kegiatan, Galeri Foto, Rekap Unit, Detail Kegiatan, dan Laporan Kustom.
2. **Dynamic Preview (PDF Viewer Style)**: Pratinjau tampilan PDF dengan navigasi halaman, thumbnail sidebar, dan scroll antar halaman yang responsif.
3. **Advanced Filtering**: Filter rentang bulan (Mulai - Akhir), Tahun, Unit Kerja, Kategori, dan Status.
4. **PDF Options**: Pengaturan ukuran kertas (A4, A3, F4, Letter), orientasi (Portrait/Landscape), serta opsi watermark dan kompresi gambar.
5. **Configuration Sync**: Semua switch (Cover, Grafik, Foto, Footer, Watermark) di halaman konfigurasi otomatis sinkron ke preview via URL params.
6. **Print-Optimized**: Layout cetak yang rapi dengan 16 baris data per halaman, page break otomatis, dan UI chrome tersembunyi saat print.
7. **Export History**: Mencatat riwayat unduhan PDF sebelumnya dengan fitur unduh ulang dan hapus riwayat.

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
- **Tabel (Bulanan, Daftar, Rekap, Kustom)**: `16 baris per halaman`
- **Galeri Foto**: `6 item per halaman` (grid 2x3)
- **Detail Kegiatan**: `3 kartu per halaman`

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
- **Route Name**: `laporan.export-pdf`
- **Preview Route**: `laporan/export-pdf/preview-full` (GET with query params)
- **Assets**: 
    - CSS: `public/assets/css/export-pdf.css`
    - JS: `public/assets/js/export-pdf.js`
- **Sidebar State**: Secara otomatis dalam posisi *collapsed* saat mengakses halaman ini.

## 📂 File Kunci
- `resources/views/pages/laporan/preview-pdf.blade.php` — Master file untuk logika tampilan preview dan navigasi.
- `resources/views/pages/laporan/export-pdf.blade.php` — Halaman konfigurasi (switch, filter, tombol export).
- `public/assets/js/export-pdf.js` — Engine utama yang menangani pengiriman parameter konfigurasi.
- `public/assets/css/export-pdf.css` — Styling halaman konfigurasi.

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
