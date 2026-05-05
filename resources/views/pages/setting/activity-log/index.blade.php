<x-master-layout title="Log Aktivitas User">
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/unit-kerja.css') }}">
        <style>
            /* Custom adjustments for activity log */
            .event-badge { padding: 5px 12px; border-radius: 8px; font-size: 0.65rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; }
            .event-created { background: #d1fae5; color: #065f46; }
            .event-updated { background: #fef3c7; color: #92400e; }
            .event-deleted { background: #fee2e2; color: #991b1b; }
            
            .log-name-badge { background: #f1f5f9; color: #475569; padding: 5px 10px; border-radius: 8px; font-size: 0.65rem; font-weight: 700; border: 1px solid #e2e8f0; }
            .causer-cell { display: flex; align-items: center; gap: 12px; }
            .causer-avatar { width: 34px; height: 34px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; border: 1px solid #dbeafe; }
            
            .prop-box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 20px; border-radius: 12px; font-family: 'Monaco', 'Consolas', monospace; font-size: 0.8rem; color: #334155; white-space: pre-wrap; margin-top: 15px; }
            .prop-label { font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
            
            /* Overriding unit-kerja.css for better fit */
            .uk-table td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
            .table-footer { padding: 20px 25px; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
            .pagination-wrap { display: flex; gap: 5px; }
        </style>
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-clock-history"></i> Log Aktivitas User</h1>
            <p>Jejak audit seluruh aktivitas dan perubahan data dalam sistem DokaWeb.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-clock-history"></i> Log Aktivitas</span>
        </nav>
    </div>

    <!-- Mini Stats -->
    <div class="row g-3 fade-up mb-4">
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms1">
                <div class="mini-stat-icon"><i class="bi bi-list-check"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc1">{{ \Spatie\Activitylog\Models\Activity::count() }}</div>
                    <div class="mini-stat-lbl">Total Log</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms2">
                <div class="mini-stat-icon"><i class="bi bi-calendar-event"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc2">{{ \Spatie\Activitylog\Models\Activity::whereDate('created_at', today())->count() }}</div>
                    <div class="mini-stat-lbl">Hari Ini</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms3">
                <div class="mini-stat-icon"><i class="bi bi-person-badge"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc3">{{ \Spatie\Activitylog\Models\Activity::whereNotNull('causer_id')->count() }}</div>
                    <div class="mini-stat-lbl">User</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mini-stat ms4">
                <div class="mini-stat-icon"><i class="bi bi-cpu-fill"></i></div>
                <div class="mini-stat-info">
                    <div class="mini-stat-val" id="sc4">{{ \Spatie\Activitylog\Models\Activity::whereNull('causer_id')->count() }}</div>
                    <div class="mini-stat-lbl">Sistem</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar fade-up mb-4 d-flex flex-wrap gap-2">
        <div class="toolbar-search flex-grow-1" style="min-width: 200px;">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" class="form-control" placeholder="Cari deskripsi log..." oninput="renderTable(1)" />
        </div>
        <div class="d-flex gap-2 flex-grow-1 flex-md-grow-0">
            <select class="toolbar-select form-select" name="log_name" onchange="renderTable(1)" style="min-width: 130px;">
                <option value="">Semua Modul</option>
                <option value="kegiatan">Kegiatan</option>
                <option value="user">User & Akun</option>
                <option value="unit_kerja">Unit Kerja</option>
            </select>
            <select class="toolbar-select form-select" name="event" onchange="renderTable(1)" style="min-width: 130px;">
                <option value="">Semua Aksi</option>
                <option value="created">Tambah</option>
                <option value="updated">Ubah</option>
                <option value="deleted">Hapus</option>
            </select>
            <button class="btn btn-outline-secondary" onclick="resetFilters()" title="Reset Filter">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </div>
        <div class="ms-auto-md">
            <button class="btn btn-primary" onclick="DKA.notify({type:'info', message:'Fitur export sedang disiapkan'})">
                <i class="bi bi-download me-1"></i> Export CSV
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card fade-up">
        <div class="table-header">
            <div class="table-title"><i class="bi bi-table"></i> Daftar Riwayat Aktivitas</div>
            <div style="display:flex;align-items:center;gap:12px;">
                <span class="table-count-badge" id="tableCountBadge">0 log</span>
            </div>
        </div>

        <div class="table-responsive-wrap">
            <table class="uk-table">
                <thead>
                    <tr>
                        <th width="220">PELAKU (USER)</th>
                        <th>AKSI / DESKRIPSI</th>
                        <th>MODUL</th>
                        <th>WAKTU</th>
                        <th style="text-align:center;">DETAIL</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>
        </div>

        <!-- Table footer -->
        <div class="table-footer">
            <div class="page-info" id="pageInfo">Menampilkan 0 log</div>
            <div class="pagination-wrap" id="paginationWrap"></div>
        </div>
    </div>

    <!-- Log Detail Modal -->
    <div class="modal fade" id="modalLogDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: 800;"><i class="bi bi-info-circle-fill text-primary"></i> Detail Perubahan Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="log-detail-content">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/activity-log.js') }}"></script>
        <script>
            function resetFilters() {
                $('input#searchInput').val('');
                $('select[name="log_name"]').val('');
                $('select[name="event"]').val('');
                renderTable(1);
            }

            function deleteLog(id) {
                DKA.deleteConfirm({
                    title: 'Hapus Log Aktivitas?',
                    message: 'Riwayat aktivitas ini akan dihapus permanen dari sistem.',
                    itemName: 'Log ID: ' + String(id).substring(0, 8)
                }).then(res => {
                    if (res) {
                        const loader = DKA.loading({ title: 'Menghapus...', message: 'Sedang membersihkan log.', style: 'dots' });
                        
                        $.ajax({
                            url: `/setting/activity-log/${id}`,
                            method: "DELETE",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(res) {
                                loader.close();
                                if (res.success) {
                                    DKA.notify({ type: 'success', title: 'Terhapus', message: res.message });
                                    renderTable(currentPage);
                                }
                            },
                            error: function(xhr) {
                                loader.close();
                                const msg = xhr.responseJSON ? xhr.responseJSON.message : 'Gagal menghapus log.';
                                DKA.notify({ type: 'danger', title: 'Error', message: msg });
                            }
                        });
                    }
                });
            }

            function viewLogDetail(id) {
                $('#modalLogDetail').modal('show');
                $('#log-detail-content').html(`
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
                        <p class="mt-3 text-muted fw-bold">Mengambil detail aktivitas...</p>
                    </div>
                `);

                $.get(`/setting/activity-log/${id}`, function(res) {
                    if(res.success) {
                        const data = res.data;
                        
                        // Action styling
                        let eventClass = 'bg-info';
                        let eventIcon = 'bi-info-circle';
                        if(data.event === 'created') { eventClass = 'bg-success'; eventIcon = 'bi-plus-circle'; }
                        if(data.event === 'updated') { eventClass = 'bg-warning'; eventIcon = 'bi-pencil-square'; }
                        if(data.event === 'deleted') { eventClass = 'bg-danger'; eventIcon = 'bi-trash'; }

                        let propsHtml = '';
                        if (data.properties && Object.keys(data.properties).length > 0) {
                            propsHtml = `
                                <div class="mt-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-braces text-primary"></i>
                                        <label class="prop-label mb-0">Data Perubahan (Payload JSON)</label>
                                    </div>
                                    <div class="prop-box" style="background: #1e293b; color: #e2e8f0; border: none; box-shadow: inset 0 2px 10px rgba(0,0,0,0.2);"><code>${JSON.stringify(data.properties, null, 4)}</code></div>
                                </div>`;
                        }

                        $('#log-detail-content').html(`
                            <div class="log-detail-header ${eventClass} text-white p-4 rounded-4 mb-4 d-flex align-items-center gap-3">
                                <div class="display-6"><i class="bi ${eventIcon}"></i></div>
                                <div>
                                    <div class="text-uppercase fw-bold opacity-75" style="font-size: .7rem; letter-spacing: 1px;">Log Aktivitas #${String(data.id).substring(0,8)}</div>
                                    <h4 class="mb-0 fw-800">${data.description}</h4>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-4 bg-light h-100">
                                        <label class="prop-label"><i class="bi bi-person-circle me-1"></i> Pelaku (Causer)</label>
                                        <div class="d-flex align-items-center gap-3 mt-1">
                                            <div class="causer-avatar" style="width: 45px; height: 45px; font-size: 1.1rem;">${data.causer ? data.causer[0] : 'S'}</div>
                                            <div>
                                                <div class="fw-bold text-dark">${data.causer || 'System Auto'}</div>
                                                <div class="text-muted small">${data.causer === 'System' ? 'System Service' : 'Administrator'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 border rounded-4 bg-light h-100 text-md-end">
                                        <label class="prop-label"><i class="bi bi-clock-history me-1"></i> Waktu Kejadian</label>
                                        <div class="mt-1">
                                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">${data.created_at}</div>
                                            <div class="badge bg-white text-primary border border-primary-subtle rounded-pill px-3 py-2 mt-1 shadow-sm">
                                                <i class="bi bi-hourglass-split me-1"></i> ${data.time_ago}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="p-3 border rounded-4">
                                        <div class="row">
                                            <div class="col-6 border-end">
                                                <label class="prop-label"><i class="bi bi-layers me-1"></i> Modul Terkait</label>
                                                <div class="fw-bold mt-1 text-uppercase text-primary">${data.log_name}</div>
                                            </div>
                                            <div class="col-6 ps-4">
                                                <label class="prop-label"><i class="bi bi-box-seam me-1"></i> Tipe Objek</label>
                                                <div class="fw-bold mt-1">${data.subject_type ? data.subject_type.split('\\').pop() : 'N/A'}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${propsHtml}
                        `);
                    }
                });
            }

            function deleteLog(id) {
                DKA.deleteConfirm({
                    title: 'Hapus Log?',
                    message: 'Menghapus log ini tidak akan memengaruhi data asli, namun riwayat audit akan hilang.',
                    itemName: 'Log ID: ' + id,
                    confirm: 'Hapus Log',
                    cancel: 'Batal'
                }).then(result => {
                    if (result) {
                        $.ajax({
                            url: `/setting/activity-log/${id}`,
                            method: 'DELETE',
                            success: function(res) {
                                DKA.notify({ type: 'success', message: res.message });
                                renderTable(currentPage);
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
</x-master-layout>
