<x-master-layout>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/role-permission.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="ph-left">
            <h1><i class="bi bi-shield-lock-fill"></i> Akses & Role Permission</h1>
            <p>Kelola peran pengguna dan atur hak akses setiap fitur dalam sistem DokaKegiatan.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <a href="#">Pengaturan</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-shield-lock-fill"></i> Akses & Role</span>
        </nav>
    </div>

    <!-- Mini Stats -->
    <div class="mini-stats">
        <div class="mini-stat ms1">
            <div class="ms-icon"><i class="bi bi-person-badge-fill"></i></div>
            <div>
                <div class="ms-val" id="sc1">0</div>
                <div class="ms-lbl">Total Role</div>
            </div>
        </div>
        <div class="mini-stat ms2">
            <div class="ms-icon"><i class="bi bi-shield-fill-check"></i></div>
            <div>
                <div class="ms-val" id="sc2">0</div>
                <div class="ms-lbl">Total Permission</div>
            </div>
        </div>
        <div class="mini-stat ms3">
            <div class="ms-icon"><i class="bi bi-people-fill"></i></div>
            <div>
                <div class="ms-val" id="sc3">0</div>
                <div class="ms-lbl">Pengguna Aktif</div>
            </div>
        </div>
        <div class="mini-stat ms4">
            <div class="ms-icon"><i class="bi bi-calendar-check-fill"></i></div>
            <div>
                <div class="ms-val" id="sc4">{{ $counts['login_today'] ?? 0 }}</div>
                <div class="ms-lbl">Login Hari Ini</div>
            </div>
        </div>
    </div>

    <!-- Section: Roles -->
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;animation:fadeUp .4s ease .1s both;">
        <div class="role-section-title" style="margin-bottom:0;"><i class="bi bi-person-badge-fill"></i> Daftar Role</div>
        <button class="btn-tb btn-add" onclick="openAddRoleModal()"><i class="bi bi-plus-lg"></i> Tambah Role</button>
    </div>

    <div class="role-grid" id="roleGrid">
        <!-- Rendered by JS -->
    </div>

    <!-- Permission Matrix -->
    <div class="matrix-card">
        <div class="matrix-head">
            <div>
                <div class="matrix-title"><i class="bi bi-grid-3x3-gap-fill"></i> Matrix Hak Akses</div>
                <div style="font-size:.75rem;color:var(--c-muted);margin-top:2px;">Klik toggle untuk mengubah akses per role. Perubahan belum tersimpan sampai klik Simpan.</div>
            </div>
            <div class="matrix-role-tabs" id="matrixRoleTabs">
                <!-- Rendered by JS -->
            </div>
        </div>

        <div class="perm-wrap">
            <table class="perm-table" id="permTable">
                <thead id="permHead"></thead>
                <tbody id="permBody"></tbody>
            </table>
        </div>

        <div class="save-bar">
            <div class="save-bar-info"><i class="bi bi-exclamation-triangle-fill"></i> Perubahan permission akan diterapkan setelah pengguna login ulang.</div>
            <div class="save-bar-btns">
                <button class="btn-reset-perm" onclick="resetPermissions()"><i class="bi bi-arrow-counterclockwise"></i> Reset</button>
                <button class="btn-save-perm" onclick="savePermissions()"><i class="bi bi-check2-circle"></i> Simpan Perubahan</button>
            </div>
        </div>
    </div>

    <!-- MODAL ADD/EDIT ROLE -->
    <div class="modal-overlay" id="modalRole">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-title">
                    <div class="modal-head-icon" id="mHeadIcon" style="background:linear-gradient(135deg,var(--c-primary),var(--c-purple));"><i class="bi bi-person-badge-fill" id="mHeadIconI"></i></div>
                    <span id="mTitleText">Tambah Role Baru</span>
                </div>
                <button class="btn-close-modal" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <!-- Preview -->
                <div class="role-preview-box">
                    <div class="rp-icon" id="rpIcon" style="background:linear-gradient(135deg,var(--c-primary),var(--c-purple));"><i class="bi bi-person-badge-fill" id="rpIconI"></i></div>
                    <div>
                        <div class="rp-name" id="rpName">Nama Role</div>
                        <div class="rp-desc" id="rpDesc">Deskripsi singkat role</div>
                        <div class="rp-hint">Preview tampilan role</div>
                    </div>
                </div>

                <div class="frow2">
                    <div class="fgroup" id="grp-rname">
                        <div class="flabel"><i class="bi bi-type" style="color:var(--c-muted);font-size:.85rem;"></i> Nama Role <span class="text-danger">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-type f-icon"></i>
                            <input type="text" class="fctrl" id="f-rname" placeholder="Contoh: Operator" maxlength="30" oninput="document.getElementById('rpName').textContent=this.value||'Nama Role'" />
                        </div>
                    </div>
                    <div class="fgroup" id="grp-rslug">
                        <div class="flabel"><i class="bi bi-hash" style="color:var(--c-muted);font-size:.85rem;"></i> Kode Role <span class="text-danger">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-hash f-icon"></i>
                            <input type="text" class="fctrl" id="f-rslug" placeholder="operator" maxlength="20" />
                        </div>
                    </div>
                </div>

                <div class="fgroup">
                    <div class="flabel"><i class="bi bi-card-text" style="color:var(--c-muted);font-size:.85rem;"></i> Deskripsi <span style="color:var(--c-muted);font-weight:500;font-size:.72rem;">(opsional)</span></div>
                    <textarea class="fctrl no-icon" id="f-rdesc" rows="2" placeholder="Deskripsi singkat hak akses role ini..." oninput="document.getElementById('rpDesc').textContent=this.value||'Deskripsi singkat role'"></textarea>
                </div>

                <!-- Icon picker -->
                <div class="fgroup" style="margin-bottom:10px;">
                    <div class="flabel"><i class="bi bi-emoji-smile" style="color:var(--c-primary);font-size:.85rem;"></i> Pilih Ikon</div>
                    <div class="icon-grid-mini" id="roleIconGrid"></div>
                </div>

                <!-- Color picker -->
                <div class="fgroup" style="margin-bottom:0;">
                    <div class="flabel"><i class="bi bi-palette-fill" style="color:var(--c-primary);font-size:.85rem;"></i> Pilih Warna</div>
                    <div class="c-swatches" id="roleColorGrid"></div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-m-secondary" onclick="closeModal()"><i class="bi bi-x-circle"></i> Batal</button>
                <button class="btn-m-primary" id="btnSaveRole" onclick="saveRole()"><i class="bi bi-check2-circle"></i> Simpan Role</button>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/role-permission.js') }}"></script>
        <script>
            window.ROUTES = {
                store: "{{ route('setting.role-permission.store') }}",
                update: "{{ route('setting.role-permission.update', ':id') }}",
                destroy: "{{ route('setting.role-permission.destroy', ':id') }}",
                sync: "{{ route('setting.role-permission.sync') }}",
                csrf: "{{ csrf_token() }}"
            };

            document.addEventListener('DOMContentLoaded', function() {
                const rolesData = @json($roles);
                const permissionsData = @json($permissions);
                initRolePermission(rolesData, permissionsData);
            });
        </script>
    @endpush
</x-master-layout>
