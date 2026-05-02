<x-master-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/pengguna.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Modal Scroll Fix */
            .modal-box {
                max-height: 90vh;
                display: flex;
                flex-direction: column;
            }
            .modal-body {
                overflow-y: auto;
                flex: 1;
            }

            /* Premium Select2 Styling */
            .select2-container--default .select2-selection--single {
                height: 48px;
                border: 1px solid var(--c-border);
                border-radius: 12px;
                background-color: #fff;
                transition: all 0.3s ease;
                display: flex;
                align-items: center;
                padding: 0 10px;
            }
            .select2-container--default.select2-container--open .select2-selection--single {
                border-color: var(--c-primary);
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: var(--c-text);
                font-size: 0.9rem;
                font-weight: 500;
            }
            .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: #94a3b8;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 46px;
                right: 10px;
            }
            .select2-container--default .select2-selection--single .select2-selection__clear {
                margin-right: 25px;
                color: #ef4444;
                font-size: 1.2rem;
            }

            /* Dropdown Styling */
            .select2-dropdown {
                border: 1px solid var(--c-border);
                border-radius: 12px;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                z-index: 9999;
                margin-top: 5px;
            }
            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1px solid var(--c-border);
                border-radius: 8px;
                padding: 8px 12px;
                outline: none;
            }
            .select2-container--default .select2-search--dropdown .select2-search__field:focus {
                border-color: var(--c-primary);
            }
            .select2-results__option {
                padding: 10px 15px;
                font-size: 0.875rem;
                color: var(--c-text);
            }
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: var(--c-primary);
                color: #fff;
            }
            .select2-container--default .select2-results__option[aria-selected=true] {
                background-color: #f1f5f9;
                color: var(--c-primary);
                font-weight: 600;
            }

            /* Instansi Column Styling */
            .instansi-wrapper {
                display: flex;
                flex-direction: column;
                gap: 4px;
            }
            .instansi-name {
                font-weight: 600;
                color: var(--c-text);
                font-size: 0.85rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 200px;
            }
            .instansi-badge {
                display: inline-flex;
                align-items: center;
                padding: 2px 10px;
                background-color: rgba(79, 70, 229, 0.08);
                color: var(--c-primary);
                border-radius: 6px;
                font-size: 0.65rem;
                font-weight: 800;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                width: fit-content;
                border: 1px solid rgba(79, 70, 229, 0.15);
            }
        </style>
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
            <label for="searchInput" class="visually-hidden">Cari Pengguna</label>
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama, email, atau ID..." aria-label="Cari pengguna" />
        </div>
        <label for="filterRole" class="visually-hidden">Filter Role</label>
        <select class="toolbar-select" id="filterRole" aria-label="Filter berdasarkan role">
            <option value="">Semua Role</option>
            @foreach ($roles as $role)
                <option value="{{ $role->name }}">{{ Str::title($role->name) }}</option>
            @endforeach
        </select>
        <label for="filterStatus" class="visually-hidden">Filter Status</label>
        <select class="toolbar-select" id="filterStatus" aria-label="Filter berdasarkan status">
            <option value="">Semua Status</option>
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
        </select>
        <button class="btn-toolbar btn-reset" onclick="resetFilters()" title="Reset Filter" aria-label="Reset semua filter">
            <i class="bi bi-arrow-counterclockwise"></i>
        </button>
        <div class="toolbar-right">
            <button class="btn-toolbar btn-export" onclick="exportData()">
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
                        <th class="col-check"><input type="checkbox" onchange="toggleAll(this)" aria-label="Pilih semua pengguna"></th>
                        <th>Pengguna</th>
                        <th>Instansi</th>
                        <th>Jabatan</th>
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/pengguna.js') }}"></script>
    @endpush
</x-master-layout>
