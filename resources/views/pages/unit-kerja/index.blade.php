<x-master-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/unit-kerja.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-building-fill"></i> Manajemen Unit Kerja</h1>
            <p>Kelola data OPD / unit kerja yang terdaftar dalam sistem DokaKegiatan.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-building-fill"></i> Unit Kerja</span>
        </nav>
    </div>

    <!-- Mini Stats -->
    <div class="row g-3 fade-up mb-4">
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms1">
                <div class="mini-stat-icon"><i class="bi bi-building-fill"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc1">0</div>
                    <div class="mini-stat-lbl">Total Unit</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms2">
                <div class="mini-stat-icon"><i class="bi bi-check-circle-fill"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc2">0</div>
                    <div class="mini-stat-lbl">Aktif</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms3">
                <div class="mini-stat-icon"><i class="bi bi-calendar3-fill"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc3">0</div>
                    <div class="mini-stat-lbl">Kegiatan</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms4">
                <div class="mini-stat-icon"><i class="bi bi-people-fill"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc4">0</div>
                    <div class="mini-stat-lbl">Pengguna</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar fade-up mb-4 d-flex flex-wrap gap-2">
        <div class="toolbar-search flex-grow-1" style="min-width: 200px;">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Cari nama / singkatan..." oninput="filterData()" />
        </div>
        <div class="d-flex gap-2 flex-grow-1 flex-md-grow-0">
            <select class="toolbar-select form-select" id="filterStatus" onchange="filterData()" style="min-width: 130px;">
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="inactive">Nonaktif</option>
            </select>
            <select class="toolbar-select form-select" id="filterJenis" onchange="filterData()" style="min-width: 130px;">
                <option value="">Semua Jenis</option>
                <option value="Dinas">Dinas</option>
                <option value="Badan">Badan</option>
                <option value="Bagian">Bagian</option>
                <option value="Inspektorat">Inspektorat</option>
                <option value="Sekretariat">Sekretariat</option>
                <option value="Kantor">Kantor</option>
                <option value="RSUD">RSUD</option>
            </select>
            <button class="btn btn-outline-secondary" onclick="resetFilters()" title="Reset Filter">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </div>
        <div class="ms-auto-md d-flex gap-2 w-100-sm">
            <button class="btn btn-outline-primary flex-grow-1" onclick="exportData()"><i class="bi bi-download"></i> Export</button>
            <button class="btn btn-primary flex-grow-1" onclick="openAddModal()"><i class="bi bi-plus-lg"></i> Tambah Unit</button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card fade-up">
        <!-- Bulk bar -->
        <div class="bulk-bar" id="bulkActions">
            <span class="bulk-count" id="selectedCountText">0 dipilih</span>
            <button class="btn-bulk btn-bulk-toggle" onclick="bulkToggle()"><i class="bi bi-toggle-on"></i> Toggle Status</button>
            <button class="btn-bulk btn-bulk-del" onclick="bulkDelete()"><i class="bi bi-trash3-fill"></i> Hapus Terpilih</button>
        </div>

        <div class="table-header">
            <div class="table-title"><i class="bi bi-table"></i> Daftar Unit Kerja</div>
            <div style="display:flex;align-items:center;gap:12px;">
                <span class="table-count-badge" id="tableCountBadge">0 unit</span>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:.78rem;color:var(--c-muted);">Tampilkan:</span>
                    <label for="perPageSelect" class="visually-hidden">Data per halaman</label>
                    <select class="per-page-select" id="perPageSelect" onchange="changePerPage(this.value)" aria-label="Jumlah data per halaman">
                        <option value="10">10</option>
                        <option value="15" selected>15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive-wrap">
            <table class="uk-table">
                <thead>
                    <tr>
                        <th class="col-check"><input type="checkbox" id="checkAll" onchange="toggleAllCheck(this)" aria-label="Pilih semua unit kerja" /></th>
                        <th onclick="sortBy('nama')" id="th-nama">Unit Kerja <i class="bi bi-chevron-expand sort-icon" id="si-nama"></i></th>
                        <th onclick="sortBy('jenis')" id="th-jenis">Jenis <i class="bi bi-chevron-expand sort-icon" id="si-jenis"></i></th>
                        <th onclick="sortBy('kepala')" id="th-kepala">Kepala / Pimpinan <i class="bi bi-chevron-expand sort-icon" id="si-kepala"></i></th>
                        <th onclick="sortBy('kegiatan')" id="th-kegiatan" style="text-align:center;">Kegiatan <i class="bi bi-chevron-expand sort-icon" id="si-kegiatan"></i></th>
                        <th onclick="sortBy('pengguna')" id="th-pengguna" style="text-align:center;">Pengguna <i class="bi bi-chevron-expand sort-icon" id="si-pengguna"></i></th>
                        <th onclick="sortBy('foto')" id="th-foto" style="text-align:center;">Foto <i class="bi bi-chevron-expand sort-icon" id="si-foto"></i></th>
                        <th onclick="sortBy('status')" id="th-status">Status <i class="bi bi-chevron-expand sort-icon" id="si-status"></i></th>
                        <th style="text-align:center;cursor:default;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
            <div class="empty-state d-none" id="emptyState">
                <div class="empty-icon"><i class="bi bi-building-x"></i></div>
                <h3>Tidak ada unit kerja ditemukan</h3>
                <p>Coba ubah filter atau kata kunci pencarian Anda.</p>
                <button class="btn-tb btn-add" style="margin:0 auto;" onclick="openAddModal()"><i class="bi bi-plus-lg"></i> Tambah Unit Kerja</button>
            </div>
        </div>

        <!-- Table footer -->
        <div class="table-footer">
            <div class="page-info" id="pageInfo">Menampilkan 0 data</div>
            <div class="pagination-wrap" id="pagination"></div>
        </div>
    </div>

    @include('pages.unit-kerja.partials.modal-view')

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/unit-kerja.js') }}"></script>
    @endpush
</x-master-layout>
