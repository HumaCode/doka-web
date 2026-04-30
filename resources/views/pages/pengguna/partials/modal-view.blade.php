<!-- User Modal (Add/Edit) -->
<div class="modal-overlay" id="modalUser">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-head-title">
                <div class="modal-title-icon" id="modalIcon"><i class="bi bi-person-plus-fill"></i></div>
                <div class="modal-title-text">
                    <span class="modal-title-main" id="modalTitle">Tambah Pengguna</span>
                    <span class="modal-title-sub" id="modalSubTitle">Silakan lengkapi formulir di bawah ini.</span>
                </div>
            </div>
            <button class="btn-close-modal" onclick="closeModal('modalUser')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
            <form id="formUser" enctype="multipart/form-data">
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label-m">Nama Lengkap</label>
                    <input type="text" class="form-ctrl-m" id="f-name" name="name" placeholder="John Doe">
                </div>
                <div class="form-row" style="margin-bottom: 14px;">
                    <div class="form-group">
                        <label class="form-label-m">Username</label>
                        <input type="text" class="form-ctrl-m" id="f-username" name="username" placeholder="johndoe">
                    </div>
                    <div class="form-group">
                        <label class="form-label-m">Email</label>
                        <input type="email" class="form-ctrl-m" id="f-email" name="email" placeholder="john@example.com">
                    </div>
                </div>
                <div class="form-row" style="margin-bottom: 14px;">
                    <div class="form-group">
                        <label class="form-label-m">No. Handphone</label>
                        <input type="text" class="form-ctrl-m" id="f-phone" name="phone" placeholder="0812... (opsional)">
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
                <div class="form-group" style="margin-bottom: 14px;">
                    <label class="form-label-m">Instansi / Unit Kerja</label>
                    <select class="form-ctrl-m select2" id="f-unit_kerja_id" name="unit_kerja_id">
                        <option value="">Pilih Instansi</option>
                        @foreach ($unitKerjas as $uk)
                            <option value="{{ $uk->id }}">{{ $uk->nama_instansi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-row" style="margin-bottom: 14px;">
                    <div class="form-group">
                        <label class="form-label-m">Password</label>
                        <input type="password" class="form-ctrl-m" id="f-password" name="password" placeholder="Minimal 8 karakter">
                    </div>
                    <div class="form-group">
                        <label class="form-label-m">Konfirmasi Password</label>
                        <input type="password" class="form-ctrl-m" id="f-password_confirmation" name="password_confirmation" placeholder="Ulangi password">
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
            <button class="btn-secondary-m" style="padding:10px 20px; border-radius:10px; border:1px solid var(--c-border); background:#fff;" onclick="closeModal('modalUser')">Batal</button>
            <button class="btn-primary-m" onclick="saveUser()">Simpan Data</button>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal-overlay" id="modalDetailUser">
    <div class="modal-box" style="max-width: 650px;">
        <div class="modal-head">
            <div class="modal-head-title">
                <div class="modal-title-icon"><i class="bi bi-person-badge"></i></div>
                <div class="modal-title-text">
                    <span class="modal-title-main">Detail Pengguna</span>
                    <span class="modal-title-sub">Informasi lengkap data pengguna sistem.</span>
                </div>
            </div>
            <button class="btn-close-modal" onclick="closeModal('modalDetailUser')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body" id="detailUserContent">
            <div style="text-align:center; padding:40px;">
                <span class="spinner-border text-primary"></span>
                <p style="margin-top:10px; color:var(--c-muted);">Memuat informasi...</p>
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn-secondary-m" style="padding:10px 20px; border-radius:10px; border:1px solid var(--c-border); background:#fff;" onclick="closeModal('modalDetailUser')">Tutup</button>
            <button class="btn-primary-m" id="btnEditFromDetail">Edit Data</button>
        </div>
    </div>
</div>
