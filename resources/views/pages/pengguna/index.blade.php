<x-master-layout>
    @push('css')
        <style>
            /* ── MINI STATS ── */
            .mini-stats {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 14px;
                margin-bottom: 22px;
            }

            .mini-stat {
                background: var(--c-surface);
                border: 1px solid var(--c-border);
                border-radius: var(--radius-md);
                padding: 16px 18px;
                display: flex;
                align-items: center;
                gap: 14px;
                box-shadow: var(--shadow-sm);
                transition: transform var(--trans), box-shadow var(--trans);
                position: relative;
                overflow: hidden;
            }

            .mini-stat:hover {
                transform: translateY(-2px);
                box-shadow: var(--shadow-md);
            }

            .mini-stat::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 3px;
            }

            .mini-stat.ms1::after {
                background: linear-gradient(90deg, var(--c-primary), var(--c-secondary));
            }

            .mini-stat.ms2::after {
                background: linear-gradient(90deg, var(--c-green), #34d399);
            }

            .mini-stat.ms3::after {
                background: linear-gradient(90deg, var(--c-accent), var(--c-orange));
            }

            .mini-stat.ms4::after {
                background: linear-gradient(90deg, var(--c-red), #f87171);
            }

            .mini-stat-icon {
                width: 42px;
                height: 42px;
                border-radius: 11px;
                display: grid;
                place-items: center;
                font-size: 1.15rem;
                color: #fff;
                flex-shrink: 0;
            }

            .ms1 .mini-stat-icon {
                background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
                box-shadow: 0 3px 10px rgba(79, 70, 229, .28);
            }

            .ms2 .mini-stat-icon {
                background: linear-gradient(135deg, var(--c-green), #34d399);
                box-shadow: 0 3px 10px rgba(16, 185, 129, .28);
            }

            .ms3 .mini-stat-icon {
                background: linear-gradient(135deg, var(--c-accent), var(--c-orange));
                box-shadow: 0 3px 10px rgba(245, 158, 11, .28);
            }

            .ms4 .mini-stat-icon {
                background: linear-gradient(135deg, var(--c-red), #f87171);
                box-shadow: 0 3px 10px rgba(239, 68, 68, .28);
            }

            .mini-stat-val {
                font-family: 'Nunito', sans-serif;
                font-weight: 900;
                font-size: 1.5rem;
                color: var(--c-text);
                line-height: 1;
            }

            .mini-stat-lbl {
                font-size: .75rem;
                color: var(--c-muted);
                font-weight: 600;
                margin-top: 2px;
            }

            /* ── TOOLBAR ── */
            .toolbar {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-wrap: wrap;
                margin-bottom: 16px;
            }

            .toolbar-search {
                flex: 1;
                min-width: 200px;
                max-width: 320px;
                position: relative;
            }

            .toolbar-search input {
                width: 100%;
                padding: 10px 14px 10px 38px;
                border: 1.5px solid var(--c-border);
                border-radius: 10px;
                font-size: .875rem;
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #fff;
                color: var(--c-text);
                outline: none;
                transition: border-color var(--trans), box-shadow var(--trans);
            }

            .toolbar-search i {
                position: absolute;
                left: 12px;
                top: 50%;
                transform: translateY(-50%);
                color: var(--c-muted);
                pointer-events: none;
            }

            .toolbar-select {
                padding: 10px 14px;
                border: 1.5px solid var(--c-border);
                border-radius: 10px;
                font-size: .875rem;
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: #fff;
                color: var(--c-text-2);
                outline: none;
                cursor: pointer;
                transition: border-color var(--trans);
                min-width: 140px;
            }

            .toolbar-right {
                margin-left: auto;
                display: flex;
                gap: 8px;
            }

            .btn-toolbar {
                display: inline-flex;
                align-items: center;
                gap: 7px;
                padding: 10px 16px;
                border-radius: 10px;
                font-size: .875rem;
                font-weight: 700;
                cursor: pointer;
                border: none;
                transition: transform var(--trans), box-shadow var(--trans), background var(--trans);
            }

            .btn-add {
                background: linear-gradient(135deg, var(--c-primary), #7c3aed);
                color: #fff;
                box-shadow: 0 4px 12px rgba(79, 70, 229, .3);
            }

            .btn-export {
                background: #fff;
                color: var(--c-text-2);
                border: 1.5px solid var(--c-border);
            }

            .btn-export:hover {
                border-color: var(--c-primary);
                color: var(--c-primary);
                background: #f5f3ff;
            }

            /* ── TABLE CARD ── */
            .table-card {
                background: var(--c-surface);
                border: 1px solid var(--c-border);
                border-radius: var(--radius-md);
                box-shadow: var(--shadow-sm);
                overflow: hidden;
            }

            .table-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                border-bottom: 1px solid var(--c-border);
                gap: 10px;
                flex-wrap: wrap;
            }

            .table-title {
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: .95rem;
                color: var(--c-text);
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .table-title i {
                color: var(--c-primary);
            }

            .table-meta {
                font-size: .78rem;
                color: var(--c-muted);
            }

            .table-responsive-wrap {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            thead th {
                background: var(--c-surface2);
                padding: 12px 16px;
                font-size: .72rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: .8px;
                color: var(--c-muted);
                border-bottom: 1px solid var(--c-border);
                white-space: nowrap;
                cursor: pointer;
                transition: color var(--trans);
            }

            thead th:hover {
                color: var(--c-primary);
            }

            tbody tr {
                border-bottom: 1px solid var(--c-border);
                transition: background var(--trans);
            }

            tbody tr:last-child {
                border-bottom: none;
            }

            tbody tr:hover {
                background: rgba(79, 70, 229, .03);
            }

            tbody td {
                padding: 14px 16px;
                font-size: .875rem;
                color: var(--c-text-2);
                vertical-align: middle;
            }

            /* Role & Status badges */
            .role-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border-radius: 99px;
                font-size: .72rem;
                font-weight: 800;
            }

            .role-admin {
                background: rgba(79, 70, 229, .1);
                color: var(--c-primary);
                border: 1px solid rgba(79, 70, 229, .2);
            }

            .role-user {
                background: rgba(6, 182, 212, .1);
                color: #0891b2;
                border: 1px solid rgba(6, 182, 212, .2);
            }

            .role-operator {
                background: rgba(245, 158, 11, .1);
                color: #d97706;
                border: 1px solid rgba(245, 158, 11, .2);
            }

            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 10px;
                border-radius: 99px;
                font-size: .72rem;
                font-weight: 700;
            }

            .status-badge::before {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
            }

            .status-active {
                background: #f0fdf4;
                color: var(--c-green);
                border: 1px solid #bbf7d0;
            }

            .status-active::before {
                background: var(--c-green);
            }

            .status-inactive {
                background: #fef2f2;
                color: #ef4444;
                border: 1px solid #fecaca;
            }

            .status-inactive::before {
                background: #ef4444;
            }

            /* Actions */
            .action-btns {
                display: flex;
                gap: 5px;
            }

            .btn-action {
                width: 32px;
                height: 32px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                display: grid;
                place-items: center;
                font-size: .9rem;
                transition: transform var(--trans), color var(--trans);
            }

            .btn-view {
                background: #eff6ff;
                color: var(--c-primary);
            }

            .btn-edit {
                background: #f0fdf4;
                color: var(--c-green);
            }

            .btn-delete {
                background: #fef2f2;
                color: #ef4444;
            }

            .btn-action:hover {
                transform: scale(1.1);
                filter: brightness(0.9);
            }

            /* Bulk Bar */
            .bulk-bar {
                display: none;
                align-items: center;
                gap: 10px;
                padding: 10px 16px;
                background: rgba(79, 70, 229, .05);
                border-bottom: 1px solid var(--c-border);
                flex-wrap: wrap;
            }

            .bulk-bar.show {
                display: flex;
            }

            .bulk-count {
                font-size: .82rem;
                font-weight: 700;
                color: var(--c-primary);
            }

            .btn-bulk {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 7px 13px;
                border-radius: 8px;
                font-size: .78rem;
                font-weight: 700;
                cursor: pointer;
                border: none;
            }

            .btn-bulk-del {
                background: #fef2f2;
                color: #ef4444;
            }

            /* Modal specific */
            .modal-box {
                background: var(--c-surface);
                border-radius: var(--radius-lg);
                width: 100%;
                max-width: 560px;
                max-height: 90vh;
                overflow-y: auto;
                transform: translateY(24px) scale(.96);
                transition: transform .3s cubic-bezier(.34, 1.56, .64, 1);
            }

            .modal-overlay.show .modal-box {
                transform: translateY(0) scale(1);
            }

            .modal-head {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 24px;
                border-bottom: 1px solid var(--c-border);
                position: sticky;
                top: 0;
                background: var(--c-surface);
                z-index: 10;
            }

            .modal-body {
                padding: 24px;
            }

            .modal-foot {
                padding: 16px 24px;
                border-top: 1px solid var(--c-border);
                display: flex;
                gap: 10px;
                justify-content: flex-end;
                background: var(--c-surface2);
            }

            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 14px;
            }

            .form-label-m {
                font-size: .8rem;
                font-weight: 700;
                color: var(--c-text);
                margin-bottom: 6px;
            }

            .form-ctrl-m {
                width: 100%;
                padding: 11px 14px;
                border: 1.5px solid var(--c-border);
                border-radius: 10px;
                font-size: .875rem;
                background: #fff;
                outline: none;
                transition: border-color var(--trans);
            }

            .form-ctrl-m:focus {
                border-color: var(--c-primary);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, .1);
            }

            /* Detail Drawer */
            .drawer-overlay {
                position: fixed;
                inset: 0;
                background: rgba(15, 23, 42, .45);
                backdrop-filter: blur(4px);
                z-index: 900;
                opacity: 0;
                pointer-events: none;
                transition: opacity .25s;
            }

            .drawer {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: 400px;
                background: var(--c-surface);
                box-shadow: var(--shadow-lg);
                z-index: 950;
                transform: translateX(100%);
                transition: transform .35s cubic-bezier(.4, 0, .2, 1);
                display: flex;
                flex-direction: column;
            }

            .drawer-overlay.show {
                opacity: 1;
                pointer-events: all;
            }

            .drawer-overlay.show .drawer {
                transform: translateX(0);
            }

            .drawer-head {
                padding: 20px 24px;
                border-bottom: 1px solid var(--c-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .drawer-body {
                flex: 1;
                overflow-y: auto;
                padding: 24px;
            }

            .btn-primary-m {
                background: linear-gradient(135deg, var(--c-primary), #7c3aed);
                color: #fff;
                border: none;
                padding: 10px 20px;
                border-radius: 10px;
                font-weight: 700;
                cursor: pointer;
            }

            @media(max-width: 768px) {
                .mini-stats {
                    grid-template-columns: repeat(2, 1fr);
                }

                .form-row {
                    grid-template-columns: 1fr;
                }

                .drawer {
                    width: 100vw;
                }
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
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama, email..." oninput="renderTable()" />
        </div>
        <select class="toolbar-select" id="filterRole" onchange="renderTable()">
            <option value="">Semua Role</option>
            <option value="admin">Admin</option>
            <option value="operator">Operator</option>
            <option value="user">User</option>
        </select>
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
            <button class="btn-bulk btn-bulk-del" onclick="alert('Hapus data terpilih')">
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

    <!-- User Modal -->
    <div class="modal-overlay" id="modalUser">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-head-title"><i class="bi bi-person-plus-fill"></i> <span id="modalTitle">Tambah
                        Pengguna</span></div>
                <button class="btn-close-modal" onclick="closeModal('modalUser')"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label-m">Nama Lengkap</label>
                    <input type="text" class="form-ctrl-m" id="f-name" placeholder="John Doe">
                </div>
                <div class="form-group">
                    <label class="form-label-m">Email</label>
                    <input type="email" class="form-ctrl-m" id="f-email" placeholder="john@example.com">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label-m">Role</label>
                        <select class="form-ctrl-m" id="f-role">
                            <option value="user">User</option>
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label-m">Status</label>
                        <select class="form-ctrl-m" id="f-status">
                            <option value="active">Aktif</option>
                            <option value="inactive">Non-aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-secondary-m"
                    style="padding:10px 20px; border-radius:10px; border:1px solid var(--c-border); background:#fff;"
                    onclick="closeModal('modalUser')">Batal</button>
                <button class="btn-primary-m" onclick="saveUser()">Simpan Data</button>
            </div>
        </div>
    </div>

    <!-- Detail Drawer -->
    <div class="drawer-overlay" id="drawerOverlay" onclick="closeDrawer()">
        <div class="drawer" onclick="event.stopPropagation()">
            <div class="drawer-head">
                <div style="font-weight:900; font-family:'Nunito';">Detail Pengguna</div>
                <button class="btn-close-modal" onclick="closeDrawer()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="drawer-body" id="drawerBody"></div>
        </div>
    </div>

    @push('js')
        <script>
            let users = [{
                    id: 1,
                    name: 'Budi Santoso',
                    email: 'budi@doka.id',
                    instansi: 'Diskominfostandi',
                    role: 'admin',
                    status: 'active',
                    color: 'var(--c-primary)'
                },
                {
                    id: 2,
                    name: 'Siti Aminah',
                    email: 'siti@doka.id',
                    instansi: 'Bappeda',
                    role: 'operator',
                    status: 'active',
                    color: 'var(--c-green)'
                },
                {
                    id: 3,
                    name: 'Andi Wijaya',
                    email: 'andi@doka.id',
                    instansi: 'Dinas Pendidikan',
                    role: 'user',
                    status: 'inactive',
                    color: 'var(--c-pink)'
                },
            ];

            function renderTable() {
                const search = document.getElementById('searchInput').value.toLowerCase();
                const role = document.getElementById('filterRole').value;
                const filtered = users.filter(u =>
                    (u.name.toLowerCase().includes(search) || u.email.toLowerCase().includes(search)) &&
                    (role === '' || u.role === role)
                );

                const body = document.getElementById('tableBody');
                body.innerHTML = filtered.map(u => `
                <tr>
                    <td><input type="checkbox" class="row-check" data-id="${u.id}" onchange="updateBulk()"></td>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:${u.color}; color:#fff; display:grid; place-items:center; font-weight:800;">${u.name[0]}</div>
                            <div>
                                <div style="font-weight:700; color:var(--c-text);">${u.name}</div>
                                <div style="font-size:0.75rem; color:var(--c-muted);">${u.email}</div>
                            </div>
                        </div>
                    </td>
                    <td>${u.instansi}</td>
                    <td><span class="role-badge role-${u.role}">${u.role.toUpperCase()}</span></td>
                    <td><span class="status-badge status-${u.status}">${u.status === 'active' ? 'Aktif' : 'Non-aktif'}</span></td>
                    <td style="text-align:center;">
                        <div class="action-btns">
                            <button class="btn-action btn-view" onclick="openDrawer(${u.id})"><i class="bi bi-eye"></i></button>
                            <button class="btn-action btn-edit" onclick="openEditModal(${u.id})"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn-action btn-delete" onclick="deleteUser(${u.id})"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>
            `).join('');

                document.getElementById('tableMeta').textContent = `Menampilkan ${filtered.length} pengguna`;
                updateStats();
            }

            function updateStats() {
                document.getElementById('sc1').textContent = users.length;
                document.getElementById('sc2').textContent = users.filter(u => u.status === 'active').length;
                document.getElementById('sc3').textContent = users.filter(u => u.role === 'admin').length;
                document.getElementById('sc4').textContent = users.filter(u => u.status === 'inactive').length;
            }

            function openAddModal() {
                document.getElementById('modalTitle').textContent = 'Tambah Pengguna';
                document.getElementById('f-name').value = '';
                document.getElementById('f-email').value = '';
                document.getElementById('modalUser').classList.add('show');
            }

            function openEditModal(id) {
                const u = users.find(x => x.id === id);
                document.getElementById('modalTitle').textContent = 'Edit Pengguna';
                document.getElementById('f-name').value = u.name;
                document.getElementById('f-email').value = u.email;
                document.getElementById('f-role').value = u.role;
                document.getElementById('f-status').value = u.status;
                document.getElementById('modalUser').classList.add('show');
            }

            function closeModal(id) {
                document.getElementById(id).classList.remove('show');
            }

            function openDrawer(id) {
                const u = users.find(x => x.id === id);
                document.getElementById('drawerBody').innerHTML = `
                <div style="text-align:center; margin-bottom:20px;">
                    <div style="width:80px; height:80px; border-radius:50%; background:${u.color}; color:#fff; display:grid; place-items:center; font-size:2rem; font-weight:900; margin:0 auto 10px;">${u.name[0]}</div>
                    <div style="font-weight:900; font-size:1.2rem;">${u.name}</div>
                    <div style="color:var(--c-muted); font-size:0.875rem;">${u.email}</div>
                </div>
                <hr style="border:0; border-top:1px solid var(--c-border); margin:20px 0;">
                <div style="margin-bottom:15px;">
                    <div style="font-size:0.75rem; color:var(--c-muted); font-weight:700; text-transform:uppercase;">Instansi</div>
                    <div style="font-weight:600;">${u.instansi}</div>
                </div>
                <div style="margin-bottom:15px;">
                    <div style="font-size:0.75rem; color:var(--c-muted); font-weight:700; text-transform:uppercase;">Role</div>
                    <div><span class="role-badge role-${u.role}">${u.role.toUpperCase()}</span></div>
                </div>
                <div style="margin-bottom:15px;">
                    <div style="font-size:0.75rem; color:var(--c-muted); font-weight:700; text-transform:uppercase;">Status</div>
                    <div><span class="status-badge status-${u.status}">${u.status === 'active' ? 'Aktif' : 'Non-aktif'}</span></div>
                </div>
            `;
                document.getElementById('drawerOverlay').classList.add('show');
            }

            function closeDrawer() {
                document.getElementById('drawerOverlay').classList.remove('show');
            }

            function toggleAll(el) {
                document.querySelectorAll('.row-check').forEach(c => c.checked = el.checked);
                updateBulk();
            }

            function updateBulk() {
                const checked = document.querySelectorAll('.row-check:checked').length;
                document.getElementById('bulkCount').textContent = `${checked} dipilih`;
                document.getElementById('bulkBar').classList.toggle('show', checked > 0);
            }

            function saveUser() {
                alert('Data berhasil disimpan!');
                closeModal('modalUser');
            }

            function deleteUser(id) {
                if (confirm('Yakin ingin menghapus pengguna ini?')) {
                    users = users.filter(u => u.id !== id);
                    renderTable();
                }
            }

            document.addEventListener('DOMContentLoaded', renderTable);
        </script>
    @endpush
</x-master-layout>
