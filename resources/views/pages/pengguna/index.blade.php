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
            <option value="admin">Admin</option>
            <option value="operator">Operator</option>
            <option value="user">User</option>
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
                <form id="formUser" enctype="multipart/form-data">
                    <div class="form-group" style="margin-bottom: 14px;">
                        <label class="form-label-m">Nama Lengkap</label>
                        <input type="text" class="form-ctrl-m" id="f-name" name="name"
                            placeholder="John Doe">
                    </div>
                    <div class="form-row" style="margin-bottom: 14px;">
                        <div class="form-group">
                            <label class="form-label-m">Username</label>
                            <input type="text" class="form-ctrl-m" id="f-username" name="username"
                                placeholder="johndoe">
                        </div>
                        <div class="form-group">
                            <label class="form-label-m">Email</label>
                            <input type="email" class="form-ctrl-m" id="f-email" name="email"
                                placeholder="john@example.com">
                        </div>
                    </div>
                    <div class="form-row" style="margin-bottom: 14px;">
                        <div class="form-group">
                            <label class="form-label-m">No. Handphone</label>
                            <input type="text" class="form-ctrl-m" id="f-phone" name="phone"
                                placeholder="0812... (opsional)">
                        </div>
                        <div class="form-group">
                            <label class="form-label-m">Jenis Kelamin</label>
                            <select class="form-ctrl-m" id="f-gender" name="gender">
                                <option value="">Pilih Kelamin</option>
                                <option value="l">Laki-laki (L)</option>
                                <option value="p">Perempuan (P)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row" style="margin-bottom: 14px;">
                        <div class="form-group">
                            <label class="form-label-m">Password</label>
                            <input type="password" class="form-ctrl-m" id="f-password" name="password"
                                placeholder="Minimal 8 karakter">
                        </div>
                        <div class="form-group">
                            <label class="form-label-m">Konfirmasi Password</label>
                            <input type="password" class="form-ctrl-m" id="f-password_confirmation"
                                name="password_confirmation" placeholder="Ulangi password">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label-m">Role</label>
                            <select class="form-ctrl-m" id="f-role" name="role">
                                <option value="">Pilih Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label-m">Status Aktif</label>
                            <select class="form-ctrl-m" id="f-is_active" name="is_active">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </form>
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
            let currentPage = 1;

            function renderTable(page = 1) {
                currentPage = page;
                const search = $('#searchInput').val();
                const role = $('#filterRole').val();
                const status = $('#filterStatus')?.val() || '';

                const body = $('#tableBody');
                body.html(
                    '<tr><td colspan="6" style="text-align:center; padding:40px;"><span class="spinner-border spinner-border-sm"></span> Memuat data...</td></tr>'
                );

                $.ajax({
                    url: "{{ route('pengguna.getallpagination') }}",
                    method: "GET",
                    data: {
                        page: page,
                        search: search,
                        role: role,
                        status: status,
                        per_page: 10
                    },
                    success: function(response) {
                        if (response.success) {
                            const users = response.data;
                            const meta = response.meta;
                            const stats = response.stats;

                            if (users.length === 0) {
                                body.html(
                                    '<tr><td colspan="6" style="text-align:center; padding:40px; color:var(--c-muted);">Tidak ada data pengguna ditemukan.</td></tr>'
                                );
                                updatePagination(meta);
                                updateStats(stats || meta);
                                return;
                            }

                            body.empty();
                            users.forEach(u => {
                                const initial = u.name ? u.name[0].toUpperCase() : '?';
                                const colors = ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#06b6d4'];
                                const color = colors[u.id.length % colors.length] || '#4f46e5';

                                body.append(`
                                <tr>
                                    <td><input type="checkbox" class="row-check" data-id="${u.id}" onchange="updateBulk()"></td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:36px; height:36px; border-radius:50%; background:${color}; color:#fff; display:grid; place-items:center; font-weight:800;">${initial}</div>
                                            <div>
                                                <div style="font-weight:700; color:var(--c-text);">${u.name}</div>
                                                <div style="font-size:0.75rem; color:var(--c-muted);">${u.email}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${u.username || '-'}</td>
                                    <td><span class="role-badge role-${u.roles[0]?.name || 'user'}">${(u.roles[0]?.name || 'user').toUpperCase()}</span></td>
                                    <td><span class="status-badge status-${u.is_active ? 'active' : 'inactive'}">${u.is_active ? 'Aktif' : 'Non-aktif'}</span></td>
                                    <td style="text-align:center;">
                                        <div class="action-btns">
                                            <button class="btn-action btn-view" onclick="openDrawer('${u.id}')"><i class="bi bi-eye"></i></button>
                                            <button class="btn-action btn-edit" onclick="openEditModal('${u.id}')"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn-action btn-delete" onclick="deleteUser('${u.id}')"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            `);
                            });

                            $('#tableMeta').text(`Menampilkan ${users.length} dari ${meta.total} pengguna`);
                            updatePagination(meta);
                            updateStats(stats || meta);
                        }
                    },
                    error: function() {
                        body.html(
                            '<tr><td colspan="6" style="text-align:center; padding:40px; color:var(--c-red);">Gagal memuat data. Silakan coba lagi.</td></tr>'
                        );
                    }
                });
            }

            function updatePagination(meta) {
                let pagWrap = $('#paginationWrap');
                if (pagWrap.length === 0) {
                    $('.table-card').append(
                        '<div id="paginationWrap" style="padding:16px 20px; border-top:1px solid var(--c-border); display:flex; justify-content:center; gap:5px;"></div>'
                    );
                    pagWrap = $('#paginationWrap');
                }

                pagWrap.empty();
                if (meta.last_page <= 1) return;

                pagWrap.append(
                    `<button class="btn-pag" ${meta.current_page === 1 ? 'disabled' : ''} onclick="renderTable(${meta.current_page - 1})"><i class="bi bi-chevron-left"></i></button>`
                );

                for (let i = 1; i <= meta.last_page; i++) {
                    if (i === 1 || i === meta.last_page || (i >= meta.current_page - 1 && i <= meta.current_page + 1)) {
                        pagWrap.append(
                            `<button class="btn-pag ${i === meta.current_page ? 'active' : ''}" onclick="renderTable(${i})">${i}</button>`
                        );
                    } else if (i === meta.current_page - 2 || i === meta.current_page + 2) {
                        pagWrap.append('<span style="padding:8px; color:var(--c-muted);">...</span>');
                    }
                }

                pagWrap.append(
                    `<button class="btn-pag" ${meta.current_page === meta.last_page ? 'disabled' : ''} onclick="renderTable(${meta.current_page + 1})"><i class="bi bi-chevron-right"></i></button>`
                );
            }

            $('<style>')
                .prop('type', 'text/css')
                .html(`
                .btn-pag { padding: 6px 12px; border-radius: 8px; border: 1px solid var(--c-border); background: #fff; color: var(--c-text-2); font-size: .875rem; font-weight: 600; cursor: pointer; transition: all var(--trans); }
                .btn-pag:hover:not(:disabled) { border-color: var(--c-primary); color: var(--c-primary); background: #f5f3ff; }
                .btn-pag.active { background: var(--c-primary); color: #fff; border-color: var(--c-primary); }
                .btn-pag:disabled { opacity: .5; cursor: not-allowed; }
            `)
                .appendTo('head');

            function updateStats(stats) {
                if (!stats) return;
                $('#sc1').text(stats.total !== undefined ? stats.total : 0);

                if (stats.active !== undefined) $('#sc2').text(stats.active);
                if (stats.admin !== undefined) $('#sc3').text(stats.admin);
                if (stats.inactive !== undefined) $('#sc4').text(stats.inactive);
            }

            $(document).ready(function() {
                renderTable();
                let searchTimer;
                $('#searchInput').on('input', function() {
                    clearTimeout(searchTimer);
                    searchTimer = setTimeout(() => renderTable(1), 500);
                });
                $('#filterRole').on('change', () => renderTable(1));
                $('#filterStatus').on('change', () => renderTable(1));
            });

            let editUserId = null;

            function openAddModal() {
                editUserId = null;
                $('#modalTitle').text('Tambah Pengguna');
                $('#formUser')[0].reset();
                $('.form-ctrl-m').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $('#modalUser').addClass('show');
            }

            function openEditModal(id) {
                editUserId = id;
                $('.form-ctrl-m').removeClass('is-invalid');
                $('.invalid-feedback').remove();
                $('#formUser')[0].reset();

                const loader = DKA.loading({
                    title: 'Memuat Data',
                    message: 'Mengambil informasi pengguna...',
                    style: 'ring'
                });

                $.ajax({
                    url: '/pengguna/' + id,
                    method: 'GET',
                    success: function(response) {
                        loader.close();
                        if (response.success) {
                            const user = response.data;
                            $('#f-name').val(user.name || '');
                            $('#f-username').val(user.username || '');
                            $('#f-email').val(user.email || '');
                            $('#f-phone').val(user.phone || '');
                            $('#f-gender').val(user.gender ? user.gender.toLowerCase() : '');

                            if (user.roles && user.roles.length > 0) {
                                $('#f-role').val(user.roles[0].name);
                            } else {
                                $('#f-role').val('');
                            }

                            $('#f-is_active').val(user.is_active ? "1" : "0");

                            $('#modalTitle').text('Edit Pengguna');
                            $('#modalUser').addClass('show');
                        }
                    },
                    error: function() {
                        loader.close();
                        DKA.notify({
                            type: 'danger',
                            title: 'Gagal',
                            message: 'Tidak dapat mengambil data pengguna.',
                            duration: 4000
                        });
                    }
                });
            }

            function closeModal(id) {
                $(`#${id}`).removeClass('show');
            }

            function resetFilters() {
                $('#searchInput').val('');
                $('#filterRole').val('');
                $('#filterStatus').val('');
                renderTable(1);
            }

            function openDrawer(id) {
                alert('Fitur detail untuk ID: ' + id);
            }

            function closeDrawer() {
                $('#drawerOverlay').removeClass('show');
            }

            function toggleAll(el) {
                $('.row-check').prop('checked', el.checked);
                updateBulk();
            }

            function updateBulk() {
                const checked = $('.row-check:checked').length;
                $('#bulkCount').text(`${checked} dipilih`);
                $('#bulkBar').toggleClass('show', checked > 0);
            }

            function saveUser() {
                $('.form-ctrl-m').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                const formData = new FormData($('#formUser')[0]);

                const steps = [
                    'Memvalidasi data...',
                    'Mengirim ke server...',
                    'Menyimpan ke database...',
                    'Selesai!'
                ];

                const targetUrl = editUserId ? "/pengguna/update/" + editUserId : "{{ route('pengguna.store') }}";
                const isEdit = !!editUserId;

                const loader = DKA.loading({
                    title: isEdit ? 'Memperbarui Pengguna' : 'Menyimpan Pengguna',
                    message: 'Memulai proses...',
                    style: 'ring',
                });

                steps.forEach((msg, i) => {
                    setTimeout(() => loader.update(msg), (i + 1) * 800);
                });

                $.ajax({
                    url: targetUrl,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        setTimeout(() => {
                            loader.close();
                            if (response.success) {
                                DKA.notify({
                                    type: 'success',
                                    title: 'Pengguna Disimpan!',
                                    message: response.message ||
                                        'Pengguna baru berhasil ditambahkan.',
                                    duration: 6000,
                                });
                                closeModal('modalUser');
                                $('#formUser')[0].reset();
                                renderTable(currentPage);
                            }
                        }, (steps.length) * 800);
                    },
                    error: function(xhr) {
                        loader.close();
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, messages) {
                                const $input = $(`#f-${key}`);
                                $input.addClass('is-invalid');
                                $input.after(
                                    `<div class="invalid-feedback" style="color:#ef4444; font-size:12px; margin-top:4px;">${messages[0]}</div>`
                                );
                            });
                            DKA.notify({
                                type: 'danger',
                                title: 'Validasi Gagal',
                                message: 'Periksa kembali isian formulir Anda.',
                                duration: 6000
                            });
                        } else {
                            DKA.notify({
                                type: 'danger',
                                title: 'Koneksi Terputus / Error Server',
                                message: 'Koneksi ke server terputus atau terjadi kesalahan. Beberapa fitur mungkin tidak tersedia. Coba refresh halaman.',
                                duration: 6000
                            });
                        }
                    }
                });
            }

            function deleteUser(id) {
                if (confirm('Yakin ingin menghapus pengguna ini?')) {
                    renderTable(currentPage);
                }
            }
        </script>
    @endpush
</x-master-layout>
