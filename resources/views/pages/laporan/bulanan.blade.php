<x-master-layout title="Laporan Bulanan — DokaKegiatan">
    @push('css')
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/laporan-bulanan.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header">
        <div class="ph-left">
            <h1><i class="bi bi-bar-chart-fill"></i> Laporan Bulanan</h1>
            <p>Rekap dokumentasi kegiatan per bulan, per unit kerja, beserta analisis capaian.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <a href="#">Laporan</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-bar-chart-fill"></i> Laporan Bulanan</span>
        </nav>
    </div>

    <!-- Filter Bar -->
    <form action="{{ route('laporan.bulanan') }}" method="GET" id="filterForm" onsubmit="event.preventDefault(); generateReport();">
        <div class="filter-bar" style="position:relative;">
            <div class="filter-group">
                <div class="filter-label"><i class="bi bi-calendar3"></i> Bulan</div>
                <select class="filter-select" name="bulan" id="fBulan" onchange="generateReport()">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ $m }}" {{ (request('bulan', date('m')) == $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label"><i class="bi bi-calendar-year"></i> Tahun</div>
                <select class="filter-select" name="tahun" id="fTahun" onchange="generateReport()">
                    @foreach(range(date('Y'), date('Y') - 3) as $y)
                        <option value="{{ $y }}" {{ (request('tahun', date('Y')) == $y) ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <div class="filter-label"><i class="bi bi-building-fill"></i> Unit Kerja</div>
                <select class="filter-select" name="unit_id" id="fUnit" onchange="generateReport()" {{ (auth()->user()->hasRole('admin') && !auth()->user()->hasRole('dev')) ? 'disabled' : '' }}>
                    <option value="">Semua Unit Kerja</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ (request('unit_id') == $unit->id || ((auth()->user()->hasRole('admin') && !auth()->user()->hasRole('dev')) && auth()->user()->unit_kerja_id == $unit->id)) ? 'selected' : '' }}>
                            {{ $unit->nama_instansi }}
                        </option>
                    @endforeach
                </select>
                @if(auth()->user()->hasRole('admin') && !auth()->user()->hasRole('dev'))
                    <input type="hidden" name="unit_id" value="{{ auth()->user()->unit_kerja_id }}">
                @endif
            </div>
            <div class="filter-group">
                <div class="filter-label"><i class="bi bi-tags-fill"></i> Kategori</div>
                <select class="filter-select" name="kategori_id" id="fKategori" onchange="generateReport()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ (request('kategori_id') == $cat->id) ? 'selected' : '' }}>
                            {{ $cat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-actions">
                <button type="button" class="btn-tb btn-outline" onclick="printReport()"><i class="bi bi-printer-fill"></i> Cetak</button>
                <button type="button" class="btn-tb btn-green" onclick="exportExcel()"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
                <button type="button" class="btn-tb btn-red" onclick="exportPDF()"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
                <button type="button" class="btn-tb btn-primary" onclick="resetFilters()"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
            </div>
        </div>
    </form>

    <div id="reportContentArea">
        <!-- Report Hero -->
        <div class="report-hero" id="reportHero">
            <div class="report-hero-inner">
                <div>
                    <div class="report-hero-title" id="heroTitle">Laporan Kegiatan Bulan {{ \Carbon\Carbon::create()->month((int)request('bulan', date('m')))->translatedFormat('F') }} {{ request('tahun', date('Y')) }}</div>
                    <div class="report-hero-sub">
                        <span><i class="bi bi-building-fill"></i> {{ request('unit_id') ? ($units->find(request('unit_id'))->nama_instansi ?? 'Semua Unit Kerja') : 'Semua Unit Kerja' }}</span>
                        <span><i class="bi bi-clock-fill"></i> Digenerate: <span id="heroGenTime"></span></span>
                    </div>
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;">
                    <span class="report-badge"><i class="bi bi-check-circle-fill" style="font-size:.55rem;"></i> Laporan Resmi</span>
                    <span class="report-badge"><i class="bi bi-shield-fill" style="font-size:.55rem;"></i> DokaKegiatan v1.2</span>
                </div>
            </div>
        </div>

    <!-- Stat Cards -->
    <div class="stat-grid" id="statGrid">
        <div class="stat-card sc1">
            <div class="sc-icon"><i class="bi bi-calendar3-fill"></i></div>
            <div class="sc-val" id="scKegiatan">0</div>
            <div class="sc-lbl">Total Kegiatan</div>
            <div class="sc-trend up" id="scKegiatanTrend"><i class="bi bi-arrow-up-short"></i> 0% vs bulan lalu</div>
        </div>
        <div class="stat-card sc2">
            <div class="sc-icon"><i class="bi bi-images"></i></div>
            <div class="sc-val" id="scFoto">0</div>
            <div class="sc-lbl">Total Foto Diupload</div>
            <div class="sc-trend up" id="scFotoTrend"><i class="bi bi-arrow-up-short"></i> 0% vs bulan lalu</div>
        </div>
        <div class="stat-card sc3">
            <div class="sc-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="sc-val" id="scSelesai">0</div>
            <div class="sc-lbl">Kegiatan Selesai</div>
            <div class="sc-trend flat" id="scSelesaiTrend"><i class="bi bi-dash"></i> 0% tingkat selesai</div>
        </div>
        <div class="stat-card sc4">
            <div class="sc-icon"><i class="bi bi-building-fill"></i></div>
            <div class="sc-val" id="scUnit">0</div>
            <div class="sc-lbl">Unit Kerja Aktif</div>
            <div class="sc-trend up" id="scUnitTrend"><i class="bi bi-people-fill"></i> 0 petugas terlibat</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">

        <!-- ═══ LEFT ═══ -->
        <div>

            <!-- Daftar Kegiatan -->
            <div class="rep-card">
                <div class="rep-card-head rch-indigo">
                    <div class="rep-card-title"><i class="bi bi-list-ul"></i> Daftar Kegiatan <span id="tableCount" style="font-size:.75rem;font-weight:600;color:var(--c-muted);margin-left:4px;"></span></div>
                    <div style="display:flex;gap:6px;">
                        <button class="btn-tb btn-outline" style="padding:6px 12px;font-size:.75rem;" onclick="sortTable()">
                            <i class="bi bi-sort-down-alt"></i> Urutkan
                        </button>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table class="kegiatan-table" id="kegiatanTable">
                        <thead>
                            <tr>
                                <th class="kt-no">#</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Unit Kerja</th>
                                <th>Status</th>
                                <th style="text-align:center;">Foto</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kegiatanBody"></tbody>
                    </table>
                    <div class="empty-state d-none" id="emptyTable">
                        <i class="bi bi-calendar-x"></i>
                        <h3>Tidak ada data kegiatan</h3>
                        <p>Tidak ada kegiatan yang sesuai filter yang dipilih.</p>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="rep-card-footer" id="tablePagination" style="padding:12px 20px;border-top:1px solid var(--c-border);display:flex;justify-content:space-between;align-items:center;">
                </div>
            </div>

            <!-- Distribusi Mingguan -->
            <div class="rep-card">
                <div class="rep-card-head rch-amber">
                    <div class="rep-card-title"><i class="bi bi-calendar-week-fill"></i> Distribusi Kegiatan per Minggu</div>
                </div>
                <div class="rep-card-body">
                    <div class="week-grid" id="weekGrid"></div>
                    <div style="margin-top:16px;">
                        <div style="font-size:.72rem;color:var(--c-muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Tren Harian (Kegiatan)</div>
                        <div class="mini-bar-chart" id="miniBarChart"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ═══ RIGHT ═══ -->
        <div>

            <!-- Kontribusi per Unit -->
            <div class="rep-card">
                <div class="rep-card-head rch-green">
                    <div class="rep-card-title"><i class="bi bi-building-fill"></i> Kontribusi per Unit Kerja</div>
                </div>
                <div class="rep-card-body" id="unitProgBars"></div>
            </div>

            <!-- Distribusi Kategori -->
            <div class="rep-card">
                <div class="rep-card-head rch-pink">
                    <div class="rep-card-title"><i class="bi bi-pie-chart-fill"></i> Distribusi Kategori</div>
                </div>
                <div class="rep-card-body">
                    <div style="display:flex;flex-direction:column;gap:0;" id="katBars"></div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="rep-card">
                <div class="rep-card-head rch-slate">
                    <div class="rep-card-title"><i class="bi bi-clipboard-fill"></i> Ringkasan Laporan</div>
                </div>
                <div class="rep-card-body">
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-calendar3-fill"></i></div>
                        <div>
                            <div class="info-label">Periode Laporan</div>
                            <div class="info-val" id="rPeriode">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-calendar-check-fill"></i></div>
                        <div>
                            <div class="info-label">Hari Aktif</div>
                            <div class="info-val" id="rHariAktif">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="info-label">Rata-rata / Hari</div>
                            <div class="info-val" id="rRataHari">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-trophy-fill"></i></div>
                        <div>
                            <div class="info-label">Unit Terbanyak</div>
                            <div class="info-val" id="rTopUnit">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-camera-fill"></i></div>
                        <div>
                            <div class="info-label">Rata-rata Foto/Kegiatan</div>
                            <div class="info-val" id="rRataFoto">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div>
                            <div class="info-label">Terakhir Diperbarui</div>
                            <div class="info-val" id="rUpdate">—</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    @push('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    
    <script>
        // Data injection from Blade to External JS
        const IS_ADMIN = {{ auth()->user()->hasRole('admin') ? 'true' : 'false' }};
        const INITIAL_STATS = @json($reportData['stats']);
        const KEGIATAN_SHOW_URL = "{{ route('kegiatan.show', ':id') }}";
        const KEGIATAN_DESTROY_URL = "{{ route('kegiatan.destroy', ':id') }}";
        const MASTER_DATA = {
            {{ (int)request('bulan', date('m')) }}: @json($reportData['kegiatan'])
        };
    </script>
    
    <script src="{{ asset('assets/js/laporan-bulanan.js') }}"></script>
    @endpush
</x-master-layout>
