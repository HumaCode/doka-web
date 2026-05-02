<!-- ═══════════ MODAL ADD/EDIT ═══════════ -->
<div class="modal-overlay" id="modalKat">
    <div class="modal-box">
        <div class="modal-head">
            <div class="modal-title">
                <div class="head-icon" id="modalHeadIcon" style="background:linear-gradient(135deg,var(--c-primary),var(--c-purple));">
                    <i class="bi bi-tags-fill" id="modalHeadIconI"></i>
                </div>
                <span id="modalTitleText">Tambah Kategori</span>
            </div>
            <button class="btn-close-modal" onclick="closeModal('modalKat')" aria-label="Tutup Modal">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body">

            <!-- Preview -->
            <div class="icon-preview-wrap">
                <div class="icon-preview-box" id="previewBox" style="background:linear-gradient(135deg,var(--c-primary),var(--c-purple));">
                    <i class="bi bi-tags-fill" id="previewIcon"></i>
                </div>
                <div class="icon-preview-info">
                    <strong id="previewName">Nama Kategori</strong>
                    Preview tampilan ikon & warna<br/>
                    <span style="font-family:'DM Mono',monospace;font-size:.68rem;" id="previewSlug">nama-kategori</span>
                </div>
            </div>

            <!-- Nama & Slug -->
            <div class="frow2">
                <div class="fgroup" id="grp-nama">
                    <label class="flabel" for="f-nama"><i class="bi bi-type" style="color:var(--c-muted);font-size:.85rem;"></i> Nama Kategori <span class="req">*</span></label>
                    <div class="fwrap">
                        <i class="bi bi-type ficon"></i>
                        <input type="text" class="fctrl" id="f-nama" placeholder="Contoh: Rapat Koordinasi"
                            oninput="onNamaInput(this.value);clearErr('grp-nama')" maxlength="50" />
                    </div>
                    <div class="finvalid">Nama kategori wajib diisi.</div>
                </div>
                <div class="fgroup" id="grp-slug">
                    <label class="flabel" for="f-slug"><i class="bi bi-link-45deg" style="color:var(--c-muted);font-size:.85rem;"></i> Slug <span class="req">*</span></label>
                    <div class="fwrap">
                        <i class="bi bi-link-45deg ficon"></i>
                        <input type="text" class="fctrl" id="f-slug" placeholder="rapat-koordinasi"
                            readonly oninput="clearErr('grp-slug');updatePreview()" />
                    </div>
                    <div class="finvalid">Slug wajib diisi (huruf kecil, tanpa spasi).</div>
                    <div class="fhint">Otomatis dari nama. Gunakan huruf kecil & strip (-).</div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="fgroup">
                <label class="flabel" for="f-desc"><i class="bi bi-card-text" style="color:var(--c-muted);font-size:.85rem;"></i> Deskripsi <span style="color:var(--c-muted);font-weight:500;font-size:.72rem;">(opsional)</span></label>
                <textarea class="fctrl no-icon" id="f-desc" rows="3" placeholder="Deskripsi singkat..."></textarea>
            </div>

            <!-- Status -->
            <div class="fgroup" id="grp-status">
                <label class="flabel" for="f-status"><i class="bi bi-toggle-on" style="color:var(--c-muted);font-size:.85rem;"></i> Status <span class="req">*</span></label>
                <div class="fwrap">
                    <i class="bi bi-toggle-on ficon"></i>
                    <select class="fctrl" id="f-status" onchange="clearErr('grp-status')">
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
                <div class="finvalid">Status wajib dipilih.</div>
            </div>

            <!-- Icon Picker -->
            <div class="fgroup">
                <div class="icon-picker-label"><i class="bi bi-emoji-smile" style="color:var(--c-primary);margin-right:4px;"></i> Pilih Ikon</div>
                <div class="icon-search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" class="icon-search" id="iconSearch" placeholder="Cari ikon..." oninput="filterIcons(this.value)" aria-label="Cari ikon" />
                </div>
                <div class="icon-grid" id="iconGrid"></div>
            </div>

            <!-- Color Picker -->
            <div class="fgroup" style="margin-bottom:0;">
                <div class="color-picker-label"><i class="bi bi-palette-fill" style="color:var(--c-primary);margin-right:4px;"></i> Pilih Warna</div>
                <div class="color-grid" id="colorGrid"></div>
            </div>

        </div>
        <div class="modal-foot">
            <button class="btn-secondary-m" onclick="closeModal('modalKat')">
                <i class="bi bi-x-circle"></i> Batal
            </button>
            <button class="btn-primary-m" id="btnSaveKat" onclick="saveKategori()">
                <i class="bi bi-check2-circle"></i> Simpan Kategori
            </button>
        </div>
    </div>
</div>
