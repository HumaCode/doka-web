<x-master-layout>

    @push('css')
    @endpush

    @push('js')
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-grid-1x2-fill"></i> Dashboard</h1>
            <p>Selamat datang kembali, Admin Doka! Berikut ringkasan aktivitas hari ini.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="#"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-grid-1x2-fill"></i> Dashboard</span>
        </nav>
    </div>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card s1 fade-up">
            <div class="stat-change up"><i class="bi bi-arrow-up"></i> 12%</div>
            <div class="stat-icon-wrap"><i class="bi bi-calendar3-fill"></i></div>
            <div class="stat-value" id="cnt1">0</div>
            <div class="stat-label">Total Kegiatan</div>
            <div class="stat-sparkline" id="spark1"></div>
        </div>
        <div class="stat-card s2 fade-up">
            <div class="stat-change up"><i class="bi bi-arrow-up"></i> 8%</div>
            <div class="stat-icon-wrap"><i class="bi bi-images"></i></div>
            <div class="stat-value" id="cnt2">0</div>
            <div class="stat-label">Total Foto Uploaded</div>
            <div class="stat-sparkline" id="spark2"></div>
        </div>
        <div class="stat-card s3 fade-up">
            <div class="stat-change flat"><i class="bi bi-dash"></i> 0%</div>
            <div class="stat-icon-wrap"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value" id="cnt3">0</div>
            <div class="stat-label">Pengguna Aktif</div>
            <div class="stat-sparkline" id="spark3"></div>
        </div>
        <div class="stat-card s4 fade-up">
            <div class="stat-change down"><i class="bi bi-arrow-down"></i> 3%</div>
            <div class="stat-icon-wrap"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-value" id="cnt4">0</div>
            <div class="stat-label">Kegiatan Bulan Ini</div>
            <div class="stat-sparkline" id="spark4"></div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="content-row">

        <!-- Recent Activities -->
        <div class="panel fade-up">
            <div class="panel-header">
                <div class="panel-title"><i class="bi bi-clock-history"></i> Aktivitas Terbaru</div>
                <a href="#" class="panel-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="act-icon blue"><i class="bi bi-camera-fill"></i></div>
                    <div class="act-info">
                        <div class="act-title">Kegiatan Rapat Koordinasi Dinkes</div>
                        <div class="act-desc">12 foto diupload &nbsp;·&nbsp; <span class="act-badge done">Selesai</span>
                        </div>
                    </div>
                    <div class="act-time">2j lalu</div>
                </div>
                <div class="activity-item">
                    <div class="act-icon green"><i class="bi bi-person-plus-fill"></i></div>
                    <div class="act-info">
                        <div class="act-title">Pengguna baru terdaftar</div>
                        <div class="act-desc">Budi Santoso — Dinas Kominfo &nbsp;·&nbsp; <span
                                class="act-badge new">Baru</span></div>
                    </div>
                    <div class="act-time">4j lalu</div>
                </div>
                <div class="activity-item">
                    <div class="act-icon amber"><i class="bi bi-calendar-plus-fill"></i></div>
                    <div class="act-info">
                        <div class="act-title">Kegiatan Pelatihan SDM Ditambahkan</div>
                        <div class="act-desc">5 foto &nbsp;·&nbsp; <span class="act-badge pending">Draft</span>
                        </div>
                    </div>
                    <div class="act-time">6j lalu</div>
                </div>
                <div class="activity-item">
                    <div class="act-icon pink"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                    <div class="act-info">
                        <div class="act-title">Laporan Bulanan April Diekspor</div>
                        <div class="act-desc">PDF · 2.4 MB &nbsp;·&nbsp; <span class="act-badge done">Selesai</span>
                        </div>
                    </div>
                    <div class="act-time">Kemarin</div>
                </div>
                <div class="activity-item">
                    <div class="act-icon purple"><i class="bi bi-images"></i></div>
                    <div class="act-info">
                        <div class="act-title">Galeri Kunjungan Lapangan Diperbarui</div>
                        <div class="act-desc">8 foto baru ditambahkan &nbsp;·&nbsp; <span
                                class="act-badge done">Selesai</span></div>
                    </div>
                    <div class="act-time">Kemarin</div>
                </div>
            </div>
        </div>

        <!-- Sidebar widgets -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Bar chart -->
            <div class="panel fade-up">
                <div class="panel-header">
                    <div class="panel-title"><i class="bi bi-bar-chart-fill"></i> Kegiatan / Bulan</div>
                </div>
                <div class="panel-body" style="padding-bottom:8px;">
                    <div class="bar-chart-wrap">
                        <div class="bar-chart" id="barChart"></div>
                    </div>
                    <div class="chart-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--c-primary);"></div>
                            <div class="legend-label">Rapat</div>
                            <div class="legend-bar-wrap">
                                <div class="legend-bar"
                                    style="width:72%;background:linear-gradient(90deg,var(--c-primary),var(--c-secondary));">
                                </div>
                            </div>
                            <div class="legend-val">72</div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--c-green);"></div>
                            <div class="legend-label">Pelatihan</div>
                            <div class="legend-bar-wrap">
                                <div class="legend-bar"
                                    style="width:45%;background:linear-gradient(90deg,var(--c-green),#34d399);">
                                </div>
                            </div>
                            <div class="legend-val">45</div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--c-pink);"></div>
                            <div class="legend-label">Kunjungan</div>
                            <div class="legend-bar-wrap">
                                <div class="legend-bar"
                                    style="width:31%;background:linear-gradient(90deg,var(--c-pink),#f472b6);">
                                </div>
                            </div>
                            <div class="legend-val">31</div>
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--c-accent);"></div>
                            <div class="legend-label">Lainnya</div>
                            <div class="legend-bar-wrap">
                                <div class="legend-bar"
                                    style="width:18%;background:linear-gradient(90deg,var(--c-accent),var(--c-orange));">
                                </div>
                            </div>
                            <div class="legend-val">18</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar mini -->
            <div class="calendar-widget fade-up">
                <div class="cal-header">
                    <button class="cal-nav" onclick="calPrev()"><i class="bi bi-chevron-left"></i></button>
                    <h3 id="calTitle"></h3>
                    <button class="cal-nav" onclick="calNext()"><i class="bi bi-chevron-right"></i></button>
                </div>
                <div style="padding:8px 12px;">
                    <div class="cal-grid" id="calDayNames"></div>
                    <div class="cal-grid" id="calGrid"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Actions -->
    <h2
        style="font-family:'Nunito',sans-serif;font-weight:800;font-size:1rem;color:var(--c-text);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
        <i class="bi bi-lightning-fill" style="color:var(--c-accent);"></i> Aksi Cepat
    </h2>
    <div class="quick-actions fade-up">
        <a href="#" class="qa-card">
            <div class="qa-icon i1"><i class="bi bi-plus-circle-fill"></i></div>
            <div class="qa-label">Tambah Kegiatan</div>
        </a>
        <a href="#" class="qa-card">
            <div class="qa-icon i2"><i class="bi bi-cloud-upload-fill"></i></div>
            <div class="qa-label">Upload Foto</div>
        </a>
        <a href="#" class="qa-card">
            <div class="qa-icon i3"><i class="bi bi-file-earmark-pdf-fill"></i></div>
            <div class="qa-label">Export Laporan</div>
        </a>
        <a href="#" class="qa-card">
            <div class="qa-icon i4"><i class="bi bi-person-plus-fill"></i></div>
            <div class="qa-label">Tambah Pengguna</div>
        </a>
    </div>

</x-master-layout>
