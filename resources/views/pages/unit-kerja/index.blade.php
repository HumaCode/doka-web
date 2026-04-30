<x-master-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/unit-kerja.css') }}">
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
    <div class="mini-stats fade-up">
        <div class="mini-stat ms1">
            <div class="mini-stat-icon"><i class="bi bi-building-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc1">0</div>
                <div class="mini-stat-lbl">Total Unit Kerja</div>
            </div>
        </div>
        <div class="mini-stat ms2">
            <div class="mini-stat-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc2">0</div>
                <div class="mini-stat-lbl">Aktif</div>
            </div>
        </div>
        <div class="mini-stat ms3">
            <div class="mini-stat-icon"><i class="bi bi-calendar3-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc3">0</div>
                <div class="mini-stat-lbl">Total Kegiatan</div>
            </div>
        </div>
        <div class="mini-stat ms4">
            <div class="mini-stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="mini-stat-info">
                <div class="mini-stat-val" id="sc4">0</div>
                <div class="mini-stat-lbl">Total Pengguna</div>
            </div>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar fade-up">
        <div class="toolbar-search">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama / singkatan..." oninput="filterData()" />
        </div>
        <select class="toolbar-select" id="filterStatus" onchange="filterData()">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
        <select class="toolbar-select" id="filterJenis" onchange="filterData()">
            <option value="">Semua Jenis</option>
            <option value="Dinas">Dinas</option>
            <option value="Badan">Badan</option>
            <option value="Bagian">Bagian</option>
            <option value="Inspektorat">Inspektorat</option>
            <option value="Sekretariat">Sekretariat</option>
            <option value="Kantor">Kantor</option>
            <option value="RSUD">RSUD</option>
        </select>
        <button class="btn-reset" onclick="resetFilters()" title="Reset Filter">
            <i class="bi bi-arrow-counterclockwise"></i>
        </button>
        <div class="toolbar-right">
            <button class="btn-toolbar btn-export" onclick="doExport()"><i class="bi bi-download"></i> Export</button>
            <button class="btn-toolbar btn-add" onclick="openAddModal()"><i class="bi bi-plus-lg"></i> Tambah Unit Kerja</button>
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
                    <select class="per-page-select" id="perPageSelect" onchange="changePerPage(this.value)">
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
                        <th class="col-check"><input type="checkbox" id="checkAll" onchange="toggleAllCheck(this)" /></th>
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

    <!-- ═══════════ MODAL ADD / EDIT ═══════════ -->
    <div class="modal-overlay" id="modalUK">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-title">
                    <div class="modal-head-icon" id="mHeadIcon" style="background:linear-gradient(135deg,var(--c-primary),var(--c-purple));"><i class="bi bi-building-fill" id="mHeadIconI"></i></div>
                    <span id="mTitleText">Tambah Unit Kerja</span>
                </div>
                <button class="btn-close-modal" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <!-- Preview -->
                <div class="modal-preview-box">
                    <div class="preview-logo" id="mPreviewLogo" style="background:linear-gradient(135deg,var(--c-primary),var(--c-purple));">
                        <i class="bi bi-building-fill" id="mPreviewIcon"></i>
                    </div>
                    <div>
                        <div class="preview-info-name" id="mPreviewName">Nama Unit Kerja</div>
                        <div class="preview-info-sing" id="mPreviewSing">Singkatan · Jenis</div>
                        <div class="preview-info-hint">Preview tampilan unit kerja</div>
                    </div>
                </div>

                <!-- Nama & Singkatan -->
                <div class="frow2">
                    <div class="fgroup" id="grp-nama">
                        <div class="flabel"><i class="bi bi-building-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Nama Unit Kerja <span class="req">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-building-fill ficon-l"></i>
                            <input type="text" class="fctrl" id="f-nama" placeholder="Dinas Komunikasi dan Informatika" oninput="onNamaInput(this.value);clearErr('grp-nama')" maxlength="80" />
                        </div>
                        <div class="finvalid">Nama unit kerja wajib diisi.</div>
                    </div>
                    <div class="fgroup" id="grp-sing">
                        <div class="flabel"><i class="bi bi-hash" style="color:var(--c-muted);font-size:.85rem;"></i> Singkatan <span class="req">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-hash ficon-l"></i>
                            <input type="text" class="fctrl" id="f-sing" placeholder="Diskominfo" oninput="onSingInput(this.value);clearErr('grp-sing')" maxlength="25" />
                        </div>
                        <div class="finvalid">Singkatan wajib diisi.</div>
                    </div>
                </div>

                <!-- Jenis & Kepala -->
                <div class="frow2">
                    <div class="fgroup" id="grp-jenis">
                        <div class="flabel"><i class="bi bi-diagram-3-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Jenis OPD <span class="req">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-diagram-3-fill ficon-l"></i>
                            <select class="fctrl" id="f-jenis" onchange="onJenisInput(this.value);clearErr('grp-jenis')">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Dinas">Dinas</option>
                                <option value="Badan">Badan</option>
                                <option value="Bagian">Bagian</option>
                                <option value="Inspektorat">Inspektorat</option>
                                <option value="Sekretariat">Sekretariat</option>
                                <option value="Kantor">Kantor</option>
                                <option value="RSUD">RSUD</option>
                            </select>
                        </div>
                        <div class="finvalid">Jenis OPD wajib dipilih.</div>
                    </div>
                    <div class="fgroup">
                        <div class="flabel"><i class="bi bi-person-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Nama Kepala <span class="opt">(opsional)</span></div>
                        <div class="fwrap">
                            <i class="bi bi-person-fill ficon-l"></i>
                            <input type="text" class="fctrl" id="f-kepala" placeholder="Nama kepala / pimpinan" maxlength="60" />
                        </div>
                    </div>
                </div>

                <!-- Telp & Email -->
                <div class="frow2">
                    <div class="fgroup">
                        <div class="flabel"><i class="bi bi-telephone-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Telepon <span class="opt">(opsional)</span></div>
                        <div class="fwrap">
                            <i class="bi bi-telephone-fill ficon-l"></i>
                            <input type="tel" class="fctrl" id="f-telp" placeholder="(0285) 123456" />
                        </div>
                    </div>
                    <div class="fgroup">
                        <div class="flabel"><i class="bi bi-envelope-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Email <span class="opt">(opsional)</span></div>
                        <div class="fwrap">
                            <i class="bi bi-envelope-fill ficon-l"></i>
                            <input type="email" class="fctrl" id="f-email" placeholder="info@opd.pekalongan.go.id" />
                        </div>
                    </div>
                </div>

                <!-- Website -->
                <div class="fgroup">
                    <div class="flabel"><i class="bi bi-globe" style="color:var(--c-muted);font-size:.85rem;"></i> Website <span class="opt">(opsional)</span></div>
                    <div class="fwrap">
                        <i class="bi bi-globe ficon-l"></i>
                        <input type="url" class="fctrl" id="f-web" placeholder="https://kominfo.pekalongan.go.id" />
                    </div>
                </div>

                <!-- Alamat -->
                <div class="fgroup">
                    <div class="flabel"><i class="bi bi-geo-alt-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Alamat <span class="opt">(opsional)</span></div>
                    <textarea class="fctrl no-icon" id="f-alamat" rows="2" placeholder="Alamat lengkap kantor..."></textarea>
                </div>

                <!-- Deskripsi / Tupoksi -->
                <div class="fgroup">
                    <div class="flabel"><i class="bi bi-card-text" style="color:var(--c-muted);font-size:.85rem;"></i> Tupoksi / Deskripsi <span class="opt">(opsional)</span></div>
                    <textarea class="fctrl no-icon" id="f-desc" rows="3" placeholder="Tugas pokok dan fungsi unit kerja ini..."></textarea>
                </div>

                <!-- Icon picker -->
                <div class="msec-label">Pilih Ikon</div>
                <div class="icon-search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" class="icon-search-input" id="iconSearch" placeholder="Cari ikon..." oninput="buildIconGrid(this.value)" />
                </div>
                <div class="icon-grid" id="iconGrid"></div>

                <!-- Color picker -->
                <div class="msec-label" style="margin-top:18px;">Pilih Warna</div>
                <div class="color-swatches" id="colorSwatches"></div>
            </div>
            <div class="modal-foot">
                <button class="btn-m-secondary" onclick="closeModal()"><i class="bi bi-x-circle"></i> Batal</button>
                <button class="btn-m-primary" id="btnSave" onclick="saveUK()"><i class="bi bi-check2-circle"></i> Simpan</button>
            </div>
        </div>
    </div>

    <!-- ═══════════ DETAIL DRAWER ═══════════ -->
    <div class="drawer-overlay" id="drawerOverlay">
        <div class="drawer" onclick="event.stopPropagation()">
            <div class="drawer-head">
                <div class="d-title"><i class="bi bi-building-fill"></i> Detail Unit Kerja</div>
                <button class="btn-close-drawer" onclick="closeDrawer()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="drawer-body" id="drawerBody"></div>
            <div class="drawer-footer">
                <button class="btn-d-secondary" onclick="closeDrawer()"><i class="bi bi-x-circle"></i> Tutup</button>
                <button class="btn-d-danger" id="drawerDeleteBtn"><i class="bi bi-trash3-fill"></i> Hapus</button>
                <button class="btn-d-primary" id="drawerEditBtn"><i class="bi bi-pencil-fill"></i> Edit</button>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/unit-kerja.js') }}"></script>
    @endpush
</x-master-layout>
