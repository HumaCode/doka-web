<x-master-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/pengguna.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-people-fill"></i> Manajemen Pengguna</h1>
            <p>Kelola data pengguna sistem DokaKegiatan — tambah, edit, dan atur hak akses.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-people-fill"></i> Pengguna</span>
        </nav>
    </div>

    <!-- Mini Stats -->
    <div class="mini-stats fade-up">
        <div class="mini-stat ms1">
            <div class="mini-stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc1">0</div>
                <div class="mini-stat-lbl">Total Pengguna</div>
            </div>
        </div>
        <div class="mini-stat ms2">
            <div class="mini-stat-icon"><i class="bi bi-person-check-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc2">0</div>
                <div class="mini-stat-lbl">Aktif</div>
            </div>
        </div>
        <div class="mini-stat ms3">
            <div class="mini-stat-icon"><i class="bi bi-person-fill-gear"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc3">0</div>
                <div class="mini-stat-lbl">Administrator</div>
            </div>
        </div>
        <div class="mini-stat ms4">
            <div class="mini-stat-icon"><i class="bi bi-person-x-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc4">0</div>
                <div class="mini-stat-lbl">Tidak Aktif</div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar fade-up">
        <div class="toolbar-search">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama, email..." />
        </div>
        <select class="toolbar-select" id="filterRole">
            <option value="">Semua Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ Str::title($role->name) }}</option>
            @endforeach
        </select>
        <select class="toolbar-select" id="filterStatus">
            <option value="">Semua Status</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </select>
        <button class="btn-toolbar btn-reset" onclick="resetFilters()" title="Reset Filter">
            <i class="bi bi-arrow-counterclockwise"></i>
        </button>
        <div class="toolbar-right">
            <button class="btn-toolbar btn-export" onclick="alert('Export data ke Excel/PDF')">
                <i class="bi bi-download"></i> Export
            </button>
            <button class="btn-toolbar btn-add" onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i> Tambah Pengguna
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card fade-up">
        <div class="bulk-bar" id="bulkBar">
            <span class="bulk-count" id="bulkCount">0 dipilih</span>
            <button class="btn-bulk btn-bulk-del" onclick="deleteBulk()">
                <i class="bi bi-trash3-fill"></i> Hapus Terpilih
            </button>
        </div>

        <div class="table-header">
            <div class="table-title"><i class="bi bi-table"></i> Daftar Pengguna</div>
            <div class="table-meta" id="tableMeta">Memuat data...</div>
        </div>

        <div class="table-responsive-wrap">
            <table id="userTable">
                <thead>
                    <tr>
                        <th class="col-check"><input type="checkbox" onchange="toggleAll(this)"></th>
                        <th>Pengguna</th>
                        <th>Instansi</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>
    </div>

    @include('pages.pengguna.partials.modal-view')

    @push('js')
        <script src="{{ asset('assets/js/pengguna.js') }}"></script>
    @endpush
</x-master-layout>
