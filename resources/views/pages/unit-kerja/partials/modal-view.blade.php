<!-- Modal Add / Edit Unit Kerja -->
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

<!-- Detail Drawer -->
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
