<x-master-layout title="Export PDF — DokaKegiatan">
    @push('css')
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/export-pdf.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header">
        <div class="ph-left">
            <h1><i class="bi bi-file-earmark-pdf-fill"></i> Export PDF</h1>
            <p>Ekspor data kegiatan, laporan bulanan, galeri foto, dan rekap statistik ke format PDF.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <a href="#">Laporan</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-file-earmark-pdf-fill"></i> Export PDF</span>
        </nav>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms1">
                <div class="ms-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div>
                    <div class="ms-val" id="sc1">0</div>
                    <div class="ms-lbl">Total Export</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms2">
                <div class="ms-icon"><i class="bi bi-cloud-arrow-down-fill"></i></div>
                <div>
                    <div class="ms-val" id="sc2">0</div>
                    <div class="ms-lbl">Bulan Ini</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms3">
                <div class="ms-icon"><i class="bi bi-hdd-fill"></i></div>
                <div>
                    <div class="ms-val" id="sc3">0</div>
                    <div class="ms-lbl">Ukuran (MB)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms4">
                <div class="ms-icon"><i class="bi bi-calendar-check-fill"></i></div>
                <div>
                    <div class="ms-val" id="sc4">0</div>
                    <div class="ms-lbl">Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Content -->
    <div class="row g-4">

        <!-- ═══ LEFT: Config (col-lg-8) ═══ -->
        <div class="col-lg-8">

            <!-- 1. Pilih Jenis Dokumen -->
            <div class="form-card mb-4">
                <div class="fc-head fch-red">
                    <div class="fc-title"><i class="bi bi-file-earmark-pdf-fill"></i> Pilih Jenis Dokumen</div>
                </div>
                <div class="fc-body">
                    <div class="doc-type-grid" id="docTypeGrid">
                        <div class="doc-type-card dtc-indigo selected" data-type="laporan-bulanan" onclick="selectDocType(this,'laporan-bulanan')">
                            <div class="dtc-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);"><i class="bi bi-bar-chart-fill"></i></div>
                            <div class="dtc-name">Laporan Bulanan</div>
                            <div class="dtc-desc">Rekap lengkap kegiatan beserta statistik</div>
                            <span class="dtc-badge">Populer</span>
                        </div>
                        <div class="doc-type-card dtc-green" data-type="daftar-kegiatan" onclick="selectDocType(this,'daftar-kegiatan')">
                            <div class="dtc-icon" style="background:linear-gradient(135deg,#10b981,#06b6d4);"><i class="bi bi-calendar3-fill"></i></div>
                            <div class="dtc-name">Daftar Kegiatan</div>
                            <div class="dtc-desc">Tabel lengkap semua kegiatan</div>
                            <span class="dtc-badge">Standar</span>
                        </div>
                        <div class="doc-type-card dtc-red" data-type="galeri-foto" onclick="selectDocType(this,'galeri-foto')">
                            <div class="dtc-icon" style="background:linear-gradient(135deg,#ec4899,#f472b6);"><i class="bi bi-images"></i></div>
                            <div class="dtc-name">Galeri Foto</div>
                            <div class="dtc-desc">Album foto kegiatan dengan keterangan</div>
                            <span class="dtc-badge">Foto</span>
                        </div>
                        <div class="doc-type-card dtc-amber" data-type="rekap-unit" onclick="selectDocType(this,'rekap-unit')">
                            <div class="dtc-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);"><i class="bi bi-building-fill"></i></div>
                            <div class="dtc-name">Rekap Per Unit</div>
                            <div class="dtc-desc">Kinerja dokumentasi tiap unit kerja</div>
                            <span class="dtc-badge">Unit</span>
                        </div>
                        <div class="doc-type-card dtc-purple" data-type="detail-kegiatan" onclick="selectDocType(this,'detail-kegiatan')">
                            <div class="dtc-icon" style="background:linear-gradient(135deg,#7c3aed,#a78bfa);"><i class="bi bi-file-text-fill"></i></div>
                            <div class="dtc-name">Detail Kegiatan</div>
                            <div class="dtc-desc">Laporan detail satu kegiatan spesifik</div>
                            <span class="dtc-badge">Detail</span>
                        </div>
                        <div class="doc-type-card dtc-slate" data-type="kustom" onclick="selectDocType(this,'kustom')">
                            <div class="dtc-icon" style="background:linear-gradient(135deg,#64748b,#94a3b8);"><i class="bi bi-sliders2"></i></div>
                            <div class="dtc-name">Kustom</div>
                            <div class="dtc-desc">Pilih konten sesuai kebutuhan</div>
                            <span class="dtc-badge">Fleksibel</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Konfigurasi Filter -->
            <div class="form-card mb-4">
                <div class="fc-head fch-indigo">
                    <div class="fc-title" style="color:var(--c-text);"><i class="bi bi-funnel-fill" style="color:var(--c-primary);"></i> Filter & Rentang Data</div>
                </div>
                <div class="fc-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-calendar3" style="color:var(--c-muted);font-size:.85rem;"></i> Bulan Mulai</div>
                                <div class="fwrap">
                                    <i class="bi bi-calendar3 f-icon"></i>
                                    <select class="fctrl" id="fBulanMulai" onchange="updatePreviewInfo()">
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ $m }}" {{ date('m') == $m ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-calendar3" style="color:var(--c-muted);font-size:.85rem;"></i> Bulan Akhir</div>
                                <div class="fwrap">
                                    <i class="bi bi-calendar3 f-icon"></i>
                                    <select class="fctrl" id="fBulanAkhir" onchange="updatePreviewInfo()">
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ $m }}" {{ date('m') == $m ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-calendar-year" style="color:var(--c-muted);font-size:.85rem;"></i> Tahun</div>
                                <div class="fwrap">
                                    <i class="bi bi-calendar-year f-icon"></i>
                                    <select class="fctrl" id="fTahun" onchange="updatePreviewInfo()">
                                        @foreach(range(date('Y'), date('Y') - 3) as $y)
                                            <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-building-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Unit Kerja <span class="opt">(opsional)</span></div>
                                <div class="fwrap">
                                    <i class="bi bi-building-fill f-icon"></i>
                                    <select class="fctrl" id="fUnit" onchange="updatePreviewInfo()">
                                        <option value="">Semua Unit Kerja</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->nama_instansi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-tags-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Kategori <span class="opt">(opsional)</span></div>
                                <div class="fwrap">
                                    <i class="bi bi-tags-fill f-icon"></i>
                                    <select class="fctrl" id="fKategori" onchange="updatePreviewInfo()">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-circle-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Status <span class="opt">(opsional)</span></div>
                                <div class="fwrap">
                                    <i class="bi bi-circle-fill f-icon"></i>
                                    <select class="fctrl" id="fStatus" onchange="updatePreviewInfo()">
                                        <option value="">Semua Status</option>
                                        <option value="selesai">Selesai</option>
                                        <option value="berjalan">Sedang Berjalan</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Opsi Tampilan PDF -->
            <div class="form-card mb-4">
                <div class="fc-head fch-green">
                    <div class="fc-title" style="color:var(--c-text);"><i class="bi bi-layout-text-window" style="color:var(--c-green);"></i> Opsi Tampilan PDF</div>
                </div>
                <div class="fc-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-file-break" style="color:var(--c-muted);font-size:.85rem;"></i> Ukuran Kertas</div>
                                <div class="fwrap">
                                    <i class="bi bi-file-break f-icon"></i>
                                    <select class="fctrl" id="fKertas">
                                        <option value="A4" selected>A4 (210×297 mm)</option>
                                        <option value="A3">A3 (297×420 mm)</option>
                                        <option value="Letter">Letter (216×279 mm)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="fgroup mb-0">
                                <div class="flabel"><i class="bi bi-phone-landscape" style="color:var(--c-muted);font-size:.85rem;"></i> Orientasi</div>
                                <div class="fwrap">
                                    <i class="bi bi-phone-landscape f-icon"></i>
                                    <select class="fctrl" id="fOrientasi">
                                        <option value="portrait" selected>Portrait</option>
                                        <option value="landscape">Landscape</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ts-row">
                        <div class="ts-info">
                            <div class="ts-label">Sertakan Foto Kegiatan</div>
                            <div class="ts-desc">Lampirkan thumbnail foto dalam laporan</div>
                        </div>
                        <label class="ts-wrap"><input type="checkbox" id="optFoto" checked data-c="primary" onchange="updatePreviewInfo()" />
                            <div class="ts-track">
                                <div class="ts-thumb"></div>
                            </div>
                        </label>
                    </div>
                    <div class="ts-row">
                        <div class="ts-info">
                            <div class="ts-label">Tampilkan Grafik & Chart</div>
                            <div class="ts-desc">Tambahkan visualisasi data statistik</div>
                        </div>
                        <label class="ts-wrap"><input type="checkbox" id="optCharts" checked data-c="primary" onchange="updatePreviewInfo()" />
                            <div class="ts-track">
                                <div class="ts-thumb"></div>
                            </div>
                        </label>
                    </div>
                    <div class="ts-row">
                        <div class="ts-info">
                            <div class="ts-label">Tampilkan Nomor Halaman</div>
                            <div class="ts-desc">Tambahkan footer nomor halaman</div>
                        </div>
                        <label class="ts-wrap"><input type="checkbox" id="optPageNum" checked data-c="primary" onchange="updatePreviewInfo()" />
                            <div class="ts-track">
                                <div class="ts-thumb"></div>
                            </div>
                        </label>
                    </div>
                    <div class="ts-row">
                        <div class="ts-info">
                            <div class="ts-label">Watermark Resmi</div>
                            <div class="ts-desc">Tambahkan watermark "DokaKegiatan" pada halaman</div>
                        </div>
                        <label class="ts-wrap"><input type="checkbox" id="optWatermark" data-c="primary" onchange="updatePreviewInfo()" />
                            <div class="ts-track">
                                <div class="ts-thumb"></div>
                            </div>
                        </label>
                    </div>
                    <div class="ts-row">
                        <div class="ts-info">
                            <div class="ts-label">Kompresi Gambar</div>
                            <div class="ts-desc">Kompres gambar untuk file lebih kecil</div>
                        </div>
                        <label class="ts-wrap"><input type="checkbox" id="optCompress" checked data-c="primary" onchange="updatePreviewInfo()" />
                            <div class="ts-track">
                                <div class="ts-thumb"></div>
                            </div>
                        </label>
                    </div>
                    <div class="ts-row">
                        <div class="ts-info">
                            <div class="ts-label">Sertakan Halaman Cover</div>
                            <div class="ts-desc">Tambahkan cover page di awal dokumen</div>
                        </div>
                        <label class="ts-wrap"><input type="checkbox" id="optCover" checked data-c="primary" onchange="updatePreviewInfo()" />
                            <div class="ts-track">
                                <div class="ts-thumb"></div>
                            </div>
                        </label>
                    </div>

                    <!-- Judul Dokumen -->
                    <div class="fgroup mb-0 mt-3">
                        <div class="flabel"><i class="bi bi-type" style="color:var(--c-muted);font-size:.85rem;"></i> Judul Dokumen <span class="opt">(opsional)</span></div>
                        <div class="fwrap">
                            <i class="bi bi-type f-icon"></i>
                            <input type="text" class="fctrl" id="fJudul" placeholder="Otomatis dari jenis laporan" oninput="updatePreviewInfo()" />
                        </div>
                        <div class="fhint"><i class="bi bi-info-circle"></i> Kosongkan untuk menggunakan judul default.</div>
                    </div>
                </div>
            </div>

            <!-- 4. Riwayat Export -->
            <div class="form-card mb-4">
                <div class="fc-head" style="position:relative;">
                    <div class="fc-title" style="color:var(--c-text);"><i class="bi bi-clock-history" style="color:var(--c-primary);"></i> Riwayat Export</div>
                    <span style="font-size:.75rem;color:var(--c-muted);" id="historyCount">— dokumen</span>
                </div>
                <div class="table-responsive">
                    <table class="history-table">
                        <thead>
                            <tr>
                                <th>Nama File</th>
                                <th>Jenis</th>
                                <th>Periode</th>
                                <th>Ukuran</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="historyBody"></tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- ═══ RIGHT: Preview & Action (col-lg-4) ═══ -->
        <div class="col-lg-4">

            <!-- Preview PDF -->
            <div class="preview-card">
                <div class="pc-head">
                    <div class="pc-title"><i class="bi bi-eye-fill"></i> Preview Dokumen</div>
                </div>
                <div class="pc-body">

                    <!-- PDF Preview Box -->
                    <div class="pdf-preview" id="pdfPreview">
                        <div class="pdf-watermark">PREVIEW</div>
                        <div class="pdf-preview-header">
                            <div class="pdf-logo-row">
                                <div class="pdf-logo-box"><i class="bi bi-camera-reels-fill" style="font-size:.7rem;"></i></div>
                                <div>
                                    <div class="pdf-org-name">PEMERINTAH KOTA PEKALONGAN</div>
                                    <div class="pdf-org-sub">Dinas Komunikasi dan Informatika</div>
                                </div>
                            </div>
                            <div class="pdf-doc-title" id="previewDocTitle">LAPORAN KEGIATAN BULANAN</div>
                            <div class="pdf-doc-sub" id="previewDocPeriode">Periode: April 2025 — Semua Unit</div>
                        </div>
                        <div class="pdf-divider"></div>
                        <div class="pdf-content">
                            <div class="pdf-stat-row">
                                <div class="pdf-stat-box">
                                    <div class="pdf-stat-val">16</div>
                                    <div class="pdf-stat-lbl">Total Kegiatan</div>
                                </div>
                                <div class="pdf-stat-box">
                                    <div class="pdf-stat-val">169</div>
                                    <div class="pdf-stat-lbl">Total Foto</div>
                                </div>
                                <div class="pdf-stat-box">
                                    <div class="pdf-stat-val">4</div>
                                    <div class="pdf-stat-lbl">Unit Aktif</div>
                                </div>
                            </div>
                            <div class="pdf-divider"></div>
                            <!-- Mock table rows -->
                            <div class="pdf-table-mock">
                                <div class="pdf-tr">
                                    <div class="pdf-td-no"></div>
                                    <div class="pdf-td-name"></div>
                                    <div class="pdf-td-kat" style="background:rgba(79,70,229,.3);"></div>
                                    <div class="pdf-td-status" style="background:rgba(16,185,129,.3);"></div>
                                </div>
                                <div class="pdf-tr">
                                    <div class="pdf-td-no"></div>
                                    <div class="pdf-td-name"></div>
                                    <div class="pdf-td-kat" style="background:rgba(16,185,129,.3);"></div>
                                    <div class="pdf-td-status" style="background:rgba(16,185,129,.3);"></div>
                                </div>
                                <div class="pdf-tr">
                                    <div class="pdf-td-no"></div>
                                    <div class="pdf-td-name"></div>
                                    <div class="pdf-td-kat" style="background:rgba(245,158,11,.3);"></div>
                                    <div class="pdf-td-status" style="background:rgba(16,185,129,.3);"></div>
                                </div>
                                <div class="pdf-tr">
                                    <div class="pdf-td-no"></div>
                                    <div class="pdf-td-name"></div>
                                    <div class="pdf-td-kat" style="background:rgba(6,182,212,.3);"></div>
                                    <div class="pdf-td-status" style="background:rgba(79,70,229,.3);"></div>
                                </div>
                                <div class="pdf-tr">
                                    <div class="pdf-td-no"></div>
                                    <div class="pdf-td-name"></div>
                                    <div class="pdf-td-kat" style="background:rgba(236,72,153,.3);"></div>
                                    <div class="pdf-td-status" style="background:rgba(245,158,11,.3);"></div>
                                </div>
                                <div class="pdf-tr">
                                    <div class="pdf-td-no"></div>
                                    <div class="pdf-td-name"></div>
                                    <div class="pdf-td-kat" style="background:rgba(79,70,229,.3);"></div>
                                    <div class="pdf-td-status" style="background:rgba(16,185,129,.3);"></div>
                                </div>
                            </div>
                        </div>
                        <div class="pdf-footer-band">
                            <div class="pdf-footer-text">DokaKegiatan — Kota Pekalongan &copy; {{ date('Y') }}</div>
                            <div class="pdf-page-num">Hal. 1 dari 8</div>
                        </div>
                    </div>

                    <!-- Export Progress (shown during export) -->
                    <div class="export-progress-wrap" id="exportProgress">
                        <div class="ep-bar-wrap">
                            <div class="ep-bar-fill" id="epBar" style="width:0%;"></div>
                        </div>
                        <div class="ep-pct" id="epPct">0%</div>
                        <div class="ep-steps" id="epSteps"></div>
                    </div>

                    <!-- Export buttons -->
                    <button class="btn-export-now" id="btnExportNow" onclick="doExport()">
                        <i class="bi bi-file-earmark-pdf-fill" style="font-size:1.1rem;"></i>
                        Export PDF Sekarang
                    </button>
                    <button class="btn-preview" onclick="previewFull()"><i class="bi bi-eye-fill"></i> Preview Full</button>
                </div>
            </div>

            <!-- Estimasi Info -->
            <div class="preview-card">
                <div class="pc-head">
                    <div class="pc-title"><i class="bi bi-info-circle-fill"></i> Informasi Export</div>
                </div>
                <div class="pc-body">
                    <div class="qi-row">
                        <i class="bi bi-file-earmark-pdf-fill qi-icon" style="color:var(--c-red);"></i>
                        <span class="qi-label">Jenis Dokumen</span>
                        <span class="qi-val" id="qiJenis">Laporan Bulanan</span>
                    </div>
                    <div class="qi-row">
                        <i class="bi bi-calendar3 qi-icon"></i>
                        <span class="qi-label">Periode</span>
                        <span class="qi-val" id="qiPeriode">—</span>
                    </div>
                    <div class="qi-row">
                        <i class="bi bi-building-fill qi-icon"></i>
                        <span class="qi-label">Unit Kerja</span>
                        <span class="qi-val" id="qiUnit">Semua Unit</span>
                    </div>
                    <div class="qi-row">
                        <i class="bi bi-calendar3-fill qi-icon"></i>
                        <span class="qi-label">Estimasi Data</span>
                        <span class="qi-val" id="qiData">—</span>
                    </div>
                    <div class="qi-row">
                        <i class="bi bi-file-break qi-icon"></i>
                        <span class="qi-label">Estimasi Halaman</span>
                        <span class="qi-val" id="qiHalaman">—</span>
                    </div>
                    <div class="qi-row">
                        <i class="bi bi-hdd-fill qi-icon"></i>
                        <span class="qi-label">Estimasi Ukuran</span>
                        <span class="qi-val" id="qiUkuran">—</span>
                    </div>
                    <div class="qi-row">
                        <i class="bi bi-clock-fill qi-icon"></i>
                        <span class="qi-label">Estimasi Waktu</span>
                        <span class="qi-val" id="qiWaktu">—</span>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="preview-card">
                <div class="pc-head">
                    <div class="pc-title"><i class="bi bi-lightbulb-fill" style="color:var(--c-accent);"></i> Tips Export</div>
                </div>
                <div class="pc-body" style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,var(--c-primary),var(--c-secondary));display:grid;place-items:center;color:#fff;font-size:.75rem;flex-shrink:0;"><i class="bi bi-filter-circle-fill"></i></div>
                        <div>
                            <div style="font-size:.82rem;font-weight:700;color:var(--c-text);">Filter spesifik = file lebih kecil</div>
                            <div style="font-size:.75rem;color:var(--c-muted);margin-top:2px;">Pilih unit atau kategori tertentu untuk hasil yang lebih relevan.</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,var(--c-green),#34d399);display:grid;place-items:center;color:#fff;font-size:.75rem;flex-shrink:0;"><i class="bi bi-images"></i></div>
                        <div>
                            <div style="font-size:.82rem;font-weight:700;color:var(--c-text);">Kompresi foto = hemat ukuran</div>
                            <div style="font-size:.75rem;color:var(--c-muted);margin-top:2px;">Aktifkan kompresi gambar untuk laporan dengan banyak foto.</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:7px;background:linear-gradient(135deg,var(--c-accent),var(--c-orange));display:grid;place-items:center;color:#fff;font-size:.75rem;flex-shrink:0;"><i class="bi bi-clock-fill"></i></div>
                        <div>
                            <div style="font-size:.82rem;font-weight:700;color:var(--c-text);">Export besar butuh waktu lebih</div>
                            <div style="font-size:.75rem;color:var(--c-muted);margin-top:2px;">Laporan dengan banyak foto mungkin memerlukan beberapa menit.</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" onclick="scrollToTop()"><i class="bi bi-arrow-up"></i></button>

    @push('js')
    <script>
        const EXPORT_PREVIEW_URL = "{{ route('laporan.export-pdf.preview') }}";
        const EXPORT_PREVIEW_FULL_URL = "{{ route('laporan.export-pdf.preview-full') }}";
        const EXPORT_STORE_URL = "{{ route('laporan.export-pdf.store') }}";
        const EXPORT_DOWNLOAD_URL = "{{ route('laporan.export-pdf.download', ':id') }}";
        const EXPORT_DESTROY_URL = "{{ route('laporan.export-pdf.destroy', ':id') }}";
        const INITIAL_HISTORY = @json($history);
    </script>
    <script src="{{ asset('assets/js/export-pdf.js') }}"></script>
    @endpush
</x-master-layout>
