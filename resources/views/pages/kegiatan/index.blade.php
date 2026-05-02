<x-master-layout>
    <x-slot:title>DokaKegiatan — Semua Kegiatan</x-slot:title>

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/kegiatan.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="ph-left">
            <h1><i class="bi bi-calendar3-fill"></i> Semua Kegiatan</h1>
            <p>Daftar seluruh dokumentasi kegiatan yang telah dicatat dalam sistem.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <a href="#">Kegiatan</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-calendar3-fill"></i> Semua Kegiatan</span>
        </nav>
    </div>

    <!-- Mini Stats -->
    <div class="mini-stats fade-up">
        <div class="mini-stat ms1" title="Total seluruh kegiatan">
            <div class="ms-icon"><i class="bi bi-calendar3-fill"></i></div>
            <div>
                <div class="ms-val" id="sc1">0</div>
                <div class="ms-lbl">Total Kegiatan</div>
            </div>
        </div>
        <div class="mini-stat ms2" title="Kegiatan yang sudah selesai didokumentasikan">
            <div class="ms-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="ms-val" id="sc2">0</div>
                <div class="ms-lbl">Selesai</div>
            </div>
        </div>
        <div class="mini-stat ms3" title="Kegiatan yang masih dalam bentuk draf">
            <div class="ms-icon"><i class="bi bi-clock-fill"></i></div>
            <div>
                <div class="ms-val" id="sc3">0</div>
                <div class="ms-lbl">Draft</div>
            </div>
        </div>
        <div class="mini-stat ms4" title="Total foto yang sudah diunggah">
            <div class="ms-icon"><i class="bi bi-images"></i></div>
            <div>
                <div class="ms-val" id="sc4">0</div>
                <div class="ms-lbl">Total Foto</div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar fade-up">
        <div class="toolbar-search">
            <label for="searchInput" class="visually-hidden">Cari Judul Kegiatan</label>
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari judul kegiatan..." oninput="filterData()" aria-label="Cari judul kegiatan" />
        </div>
        
        <label for="filterStatus" class="visually-hidden">Filter Status</label>
        <select class="toolbar-select" id="filterStatus" onchange="filterData()" aria-label="Filter berdasarkan status">
            <option value="">Semua Status</option>
            <option value="selesai">Selesai</option>
            <option value="berjalan">Sedang Berjalan</option>
            <option value="draft">Draft</option>
        </select>

        <label for="filterKategori" class="visually-hidden">Filter Kategori</label>
        <select class="toolbar-select" id="filterKategori" onchange="filterData()" aria-label="Filter berdasarkan kategori">
            <option value="">Semua Kategori</option>
            <option value="Rapat">Rapat</option>
            <option value="Pelatihan">Pelatihan</option>
            <option value="Kunjungan">Kunjungan</option>
            <option value="Sosialisasi">Sosialisasi</option>
            <option value="Upacara">Upacara</option>
        </select>

        <label for="filterBulan" class="visually-hidden">Filter Bulan</label>
        <select class="toolbar-select" id="filterBulan" onchange="filterData()" aria-label="Filter berdasarkan bulan">
            <option value="">Semua Bulan</option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
        </select>

        <div class="toolbar-right">
            <div class="view-toggle">
                <button class="view-btn active" id="btnCardView" onclick="setView('card')" title="Card View" aria-label="Tampilan Grid"><i class="bi bi-grid-3x2-gap-fill"></i></button>
                <button class="view-btn" id="btnTableView" onclick="setView('table')" title="Table View" aria-label="Tampilan Tabel"><i class="bi bi-table"></i></button>
            </div>
            <button class="btn-toolbar btn-export" onclick="exportData()" aria-label="Export data kegiatan"><i class="bi bi-download"></i> Export</button>
            <a href="#" class="btn-toolbar btn-add" aria-label="Tambah kegiatan baru"><i class="bi bi-plus-lg"></i> Tambah Kegiatan</a>
        </div>
    </div>

    <!-- ── CARD VIEW ── -->
    <div id="cardViewWrap" class="fade-up">
        <div class="card-grid" id="cardGrid"></div>
        <div class="empty-state d-none" id="emptyCard">
            <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
            <h3>Tidak ada kegiatan ditemukan</h3>
            <p>Coba ubah filter atau kata kunci pencarian.</p>
            <a href="#" class="btn-toolbar btn-add" style="display:inline-flex;"><i class="bi bi-plus-lg"></i> Tambah Kegiatan Baru</a>
        </div>
    </div>

    <!-- ── TABLE VIEW ── -->
    <div id="tableViewWrap" style="display:none;" class="fade-up">
        <div class="table-card">
            <div class="table-card-head">
                <div>
                    <div class="table-card-title"><i class="bi bi-table"></i> Daftar Kegiatan</div>
                    <div class="table-meta" id="tableMeta">Menampilkan semua kegiatan</div>
                </div>
            </div>
            <div class="table-wrap">
                <table class="kegiatan-table">
                    <thead>
                        <tr>
                            <th style="width:44px;"><input type="checkbox" id="checkAll" onchange="toggleAllCheck(this)" style="width:16px;height:16px;accent-color:var(--c-primary);" aria-label="Pilih semua kegiatan" /></th>
                            <th onclick="sortTable(0)">Kegiatan <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(1)">Tanggal <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(2)">Kategori <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(3)">Status <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th style="text-align:center;">Foto</th>
                            <th onclick="sortTable(5)">Petugas <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
                <div class="empty-state d-none" id="emptyTable">
                    <div class="empty-icon"><i class="bi bi-calendar-x"></i></div>
                    <h3>Tidak ada kegiatan ditemukan</h3>
                    <p>Coba ubah filter atau kata kunci pencarian.</p>
                </div>
            </div>
            <div class="table-footer">
                <div class="page-info" id="pageInfo">Menampilkan 0 data</div>
                <div class="pagination-wrap" id="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Card pagination -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px;" id="cardPaginationWrap" class="fade-up">
        <div class="page-info" id="cardPageInfo"></div>
        <div class="pagination-wrap" id="cardPagination"></div>
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" onclick="scrollToTop()" aria-label="Kembali ke atas"><i class="bi bi-arrow-up"></i></button>

    <!-- ── DETAIL DRAWER ── -->
    <div class="drawer-overlay" id="drawerOverlay">
        <div class="drawer" onclick="event.stopPropagation()">
            <div class="drawer-head">
                <div class="drawer-title"><i class="bi bi-calendar3-fill"></i> Detail Kegiatan</div>
                <button class="btn-close-drawer" onclick="closeDrawer()" aria-label="Tutup Detail"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="drawer-body" id="drawerBody"></div>
            <div class="drawer-footer">
                <button class="btn-drawer-action btn-d-secondary" onclick="closeDrawer()"><i class="bi bi-x-circle"></i> Tutup</button>
                <button class="btn-drawer-action btn-d-danger" id="drawerDeleteBtn"><i class="bi bi-trash3-fill"></i> Hapus</button>
                <button class="btn-drawer-action btn-d-primary" id="drawerEditBtn"><i class="bi bi-pencil-fill"></i> Edit Kegiatan</button>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/kegiatan.js') }}"></script>
    @endpush
</x-master-layout>
