# 📊 Modul Laporan Bulanan

Modul ini menyediakan visualisasi data kegiatan bulanan dengan fitur ekspor dan analisis statistik yang dioptimalkan.

## 🛠️ Arsitektur & Teknologi
- **Frontend Logic**: `public/assets/js/laporan-bulanan.js` (Vanilla JS, AJAX, Chart.js)
- **Styling**: `public/assets/css/laporan-bulanan.css` (Bento UI, Responsive Design, Print Optimization)
- **Backend Service**: `App\Services\Laporan\LaporanService`
- **Backend Repo**: `App\Repositories\Laporan\LaporanRepository`
- **Dependencies**: `html2pdf.js` (PDF), `xlsx` (Excel), `Select2` (Filter), `Chart.js` (Visualisasi)

## ✨ Fitur Utama
1. **Bento UI Statistics**: 4 kartu statistik utama (Total Kegiatan, Selesai, Foto, Unit Aktif).
2. **Dynamic Filtering**: Filter berdasarkan Bulan, Tahun, Unit Kerja, dan Kategori secara real-time via AJAX.
3. **Multi-Export System**:
    - **Print**: Layout khusus cetak dengan pengoptimalan warna.
    - **Excel**: Ekspor data kegiatan ke format `.xlsx`.
    - **PDF**: Ekspor dokumen resmi dengan layout 1080px yang distandarisasi.
4. **Access Control**: Filter otomatis `unit_id` untuk role Admin, akses penuh untuk role Dev.
5. **Interactive Row Actions**:
    - **View Detail**: Terintegrasi langsung ke halaman detail kegiatan utama.
    - **Real Deletion**: Penghapusan permanen via AJAX dengan integrasi Spatie Media Library untuk pembersihan otomatis file fisik.

## 🚀 Optimasi Performa (Update 2026-05-03)
- **N+1 Query Fix**: Menggunakan `with(['kategori', 'unitKerja'])` pada Repository.
- **Media Optimization**: Menggunakan `withCount('media as foto_count')` untuk menghindari pemuatan objek media ke memori saat perhitungan jumlah foto.
- **Database Aggregation**: Mengganti perhitungan koleksi PHP dengan `selectRaw` SQL tunggal untuk statistik bulanan.
- **Frontend Efficiency**: Menghilangkan perhitungan berat di sisi browser; JavaScript kini langsung menggunakan data statistik matang dari server.
- **Print & Export CSS**: Menonaktifkan animasi (`animation: none !important`) saat proses ekspor PDF untuk mencegah gambar tertangkap dalam kondisi transparan.

## 📝 Catatan Teknis
- **Container PDF**: Menggunakan ID `#reportContentArea` sebagai target capture `html2pdf`.
- **Layout Fixed**: Tabel menggunakan `table-layout: fixed` dengan `min-width: 1100px` untuk menjaga stabilitas kolom saat scroll horizontal.
