# 📄 Modul: Export PDF

Modul ini digunakan untuk mengekspor berbagai data sistem (Kegiatan, Statistik, Galeri) ke dalam format PDF dengan opsi kustomisasi yang luas.

## ✨ Fitur Utama
1. **Multi-Document Type**: Mendukung ekspor Laporan Bulanan, Daftar Kegiatan, Galeri Foto, Rekap Unit, dan Detail Kegiatan.
2. **Dynamic Preview**: Pratinjau tampilan PDF (Header, Statistik, Tabel) yang diperbarui secara real-time berdasarkan input filter.
3. **Advanced Filtering**: Filter rentang bulan (Mulai - Akhir), Tahun, Unit Kerja, Kategori, dan Status.
4. **PDF Options**: Pengaturan ukuran kertas (A4, A3, Letter), orientasi (Portrait/Landscape), serta opsi watermark dan kompresi gambar.
5. **Interactive Export Progress**: Animasi progress bar dan langkah-langkah pemrosesan data (Memvalidasi, Mengambil Data, Memproses Foto, dsb).
6. **Export History**: Mencatat riwayat unduhan PDF sebelumnya dengan fitur unduh ulang dan hapus riwayat.

## 🛠️ Detail Teknis
- **Controller**: `App\Http\Controllers\Laporan\ExportController`
- **Route Name**: `laporan.export-pdf`
- **Assets**: 
    - CSS: `public/assets/css/export-pdf.css`
    - JS: `public/assets/js/export-pdf.js`
- **Sidebar State**: Secara otomatis dalam posisi *collapsed* (ciut) saat mengakses halaman ini untuk memberikan ruang kerja yang lebih luas.

## 🚀 Implementasi (Update 2026-05-03)
- **Modular Assets**: Memisahkan style dan logic ke file eksternal.
- **Blade Integration**: Menggunakan `x-master-layout` dengan data dinamis untuk filter Unit Kerja dan Kategori dari database.
- **UI Consistency**: Menggunakan library `DKA` untuk notifikasi dan konfirmasi penghapusan riwayat.
