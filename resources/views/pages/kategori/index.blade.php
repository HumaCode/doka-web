<x-master-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/kategori.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-tags-fill"></i> Manajemen Kategori</h1>
            <p>Kelola kategori kegiatan — tambah, edit, dan atur status kategori.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-tags-fill"></i> Kategori</span>
        </nav>
    </div>

    <!-- Mini Stats -->
    <div class="mini-stats fade-up">
        <div class="mini-stat ms1">
            <div class="ms-icon"><i class="bi bi-tags-fill"></i></div>
            <div>
                <div class="ms-val" id="sc1">0</div>
                <div class="ms-lbl">Total Kategori</div>
            </div>
        </div>
        <div class="mini-stat ms2">
            <div class="ms-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="ms-val" id="sc2">0</div>
                <div class="ms-lbl">Aktif</div>
            </div>
        </div>
        <div class="mini-stat ms3">
            <div class="ms-icon"><i class="bi bi-calendar3-fill"></i></div>
            <div>
                <div class="ms-val" id="sc3">0</div>
                <div class="ms-lbl">Total Kegiatan</div>
            </div>
        </div>
        <div class="mini-stat ms4">
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
            <label for="searchInput" class="visually-hidden">Cari Kategori</label>
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama kategori..." aria-label="Cari kategori" />
        </div>
        <label for="filterStatus" class="visually-hidden">Filter Status</label>
        <select class="toolbar-select" id="filterStatus" aria-label="Filter berdasarkan status">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
        <button class="btn-toolbar btn-reset" onclick="resetFilters()" title="Reset Filter" aria-label="Reset semua filter">
            <i class="bi bi-arrow-counterclockwise"></i>
        </button>
        <div class="toolbar-right">
            <div class="view-toggle">
                <button class="view-btn active" id="btnCardView" onclick="setView('card')" title="Card View" aria-label="Tampilan Card">
                    <i class="bi bi-grid-3x2-gap-fill"></i>
                </button>
                <button class="view-btn" id="btnTableView" onclick="setView('table')" title="Table View" aria-label="Tampilan Tabel">
                    <i class="bi bi-table"></i>
                </button>
            </div>
            <button class="btn-toolbar btn-add" onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
        </div>
    </div>

    <!-- Card View -->
    <div id="cardViewWrap" class="fade-up">
        <div class="kat-grid" id="katGrid"></div>
        <div class="empty-state d-none" id="emptyCard">
            <div class="empty-icon"><i class="bi bi-tags"></i></div>
            <h3>Tidak ada kategori ditemukan</h3>
            <p>Ubah filter atau tambahkan kategori baru.</p>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableViewWrap" style="display:none;" class="fade-up">
        <div class="table-card">
            <div class="table-card-head">
                <div>
                    <div class="table-card-title"><i class="bi bi-table"></i> Daftar Kategori</div>
                    <div class="table-meta" id="tableMeta"></div>
                </div>
            </div>
            <div class="table-wrap">
                <table class="kat-table">
                    <thead>
                        <tr>
                            <th style="width:44px;">#</th>
                            <th onclick="sortTable(0)">Kategori <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(1)">Slug <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(2)">Kegiatan <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(3)">Foto <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th onclick="sortTable(4)">Status <i class="bi bi-chevron-expand sort-icon"></i></th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody"></tbody>
                </table>
                <div class="empty-state d-none" id="emptyTable">
                    <div class="empty-icon"><i class="bi bi-tags"></i></div>
                    <h3>Tidak ada kategori ditemukan</h3>
                    <p>Ubah filter atau tambahkan kategori baru.</p>
                </div>
            </div>
            <div class="table-footer">
                <div class="page-info" id="pageInfo"></div>
                <div class="pagination-wrap" id="pagination"></div>
            </div>
        </div>
    </div>

    <!-- Card Pagination -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-top:16px;flex-wrap:wrap;gap:10px;" id="cardPagWrap">
        <div class="page-info" id="cardPageInfo"></div>
        <div class="pagination-wrap" id="cardPagination"></div>
    </div>

    @include('pages.kategori.partials.modal-view')

    @push('js')
        <script src="{{ asset('assets/js/kategori.js') }}"></script>
    @endpush
</x-master-layout>
