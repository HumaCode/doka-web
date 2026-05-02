<x-master-layout>
    <x-slot:title>DokaKegiatan — Edit Kegiatan</x-slot:title>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('assets/css/kegiatan-form.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
        <style>
            .ck-editor__editable { min-height: 200px; border-radius: 0 0 10px 10px !important; }
            .flatpickr-calendar { border-radius: 12px; box-shadow: var(--shadow-lg); border: 1px solid var(--c-border); }
        </style>
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="ph-left">
            <h1><i class="bi bi-pencil-square"></i> Edit Kegiatan</h1>
            <p>Perbarui informasi dokumentasi kegiatan <strong>{{ $kegiatan->judul }}</strong>.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <a href="{{ route('kegiatan.index') }}">Semua Kegiatan</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-pencil-square"></i> Edit</span>
        </nav>
    </div>

    <!-- Main Form Container -->
    <form id="mainForm" novalidate onsubmit="return false;" data-id="{{ $kegiatan->id }}" data-mode="edit">
        @method('PUT')
        <div class="form-grid">

            <!-- ═══ LEFT COLUMN ═══ -->
            <div class="form-left-col">
                <!-- 1. Informasi Utama -->
                <div class="form-card">
                    <div class="fc-head indigo">
                        <div>
                            <div class="fc-title"><i class="bi bi-info-circle-fill"></i> Informasi Utama</div>
                            <div class="fc-desc">Perbarui data dasar dokumentasi kegiatan</div>
                        </div>
                    </div>
                    <div class="fc-body">
                        <!-- Judul -->
                        <div class="fgroup" id="grp-judul">
                            <label for="f-judul" class="flabel"><i class="bi bi-type" style="color:var(--c-muted);font-size:.85rem;"></i> Judul Kegiatan <span class="req">*</span></label>
                            <div class="fwrap">
                                <i class="bi bi-type ficon"></i>
                                <input type="text" class="fctrl" id="f-judul" name="judul" value="{{ $kegiatan->judul }}" placeholder="Contoh: Rapat Koordinasi Dinas Kominfo 2025" 
                                    oninput="charCount(this,'cc-judul',120);clearErr('grp-judul')" maxlength="120" required />
                            </div>
                            <div class="char-counter" id="cc-judul">{{ strlen($kegiatan->judul) }} / 120</div>
                            <div class="finvalid">Judul kegiatan wajib diisi.</div>
                        </div>

                        <!-- Tanggal & Waktu -->
                        <div class="frow2">
                            <div class="fgroup" id="grp-tanggal">
                                <label for="f-tanggal" class="flabel"><i class="bi bi-calendar3" style="color:var(--c-muted);font-size:.85rem;"></i> Tanggal Kegiatan <span class="req">*</span></label>
                                <div class="fwrap">
                                    <i class="bi bi-calendar3 ficon"></i>
                                    <input type="date" class="fctrl" id="f-tanggal" name="tanggal" value="{{ $kegiatan->tanggal->format('Y-m-d') }}" onchange="clearErr('grp-tanggal')" required />
                                </div>
                                <div class="finvalid">Tanggal kegiatan wajib diisi.</div>
                            </div>
                            <div class="fgroup" id="grp-waktu">
                                <label for="f-waktu" class="flabel"><i class="bi bi-clock" style="color:var(--c-muted);font-size:.85rem;"></i> Waktu Mulai <span class="opt">(opsional)</span></label>
                                <div class="fwrap">
                                    <i class="bi bi-clock ficon"></i>
                                    <input type="text" class="fctrl" id="f-waktu" name="waktu" value="{{ $kegiatan->waktu }}" placeholder="--:--" readonly />
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="fgroup">
                            <label for="f-lokasi" class="flabel"><i class="bi bi-geo-alt-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Lokasi Kegiatan <span class="opt">(opsional)</span></label>
                            <div class="fwrap">
                                <i class="bi bi-geo-alt-fill ficon"></i>
                                <input type="text" class="fctrl" id="f-lokasi" name="lokasi" value="{{ $kegiatan->lokasi }}" placeholder="Contoh: Ruang Rapat Lantai 3, Gedung A" />
                            </div>
                        </div>

                        <!-- Kategori & Unit Kerja -->
                        <div class="frow2">
                            <div class="fgroup" id="grp-kategori">
                                <label for="f-kategori" class="flabel"><i class="bi bi-tags-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Kategori <span class="req">*</span></label>
                                <div class="fwrap">
                                    <i class="bi bi-tags-fill ficon"></i>
                                    <select class="fctrl" id="f-kategori" name="kategori_id" onchange="clearErr('grp-kategori')" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $kegiatan->kategori_id == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="finvalid">Kategori wajib dipilih.</div>
                            </div>
                            <div class="fgroup">
                                <label for="f-unit" class="flabel"><i class="bi bi-building-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Unit Kerja <span class="opt">(opsional)</span></label>
                                <div class="fwrap">
                                    <i class="bi bi-building-fill ficon"></i>
                                    <select class="fctrl" id="f-unit" name="unit_id">
                                        <option value="">-- Pilih Unit --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $kegiatan->unit_id == $unit->id ? 'selected' : '' }}>{{ $unit->nama_instansi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="fgroup">
                            <label for="tagInput" class="flabel"><i class="bi bi-hash" style="color:var(--c-muted);font-size:.85rem;"></i> Tag <span class="opt">(opsional, tekan Enter)</span></label>
                            <div class="tags-wrap" id="tagsWrap" onclick="document.getElementById('tagInput').focus()">
                                <input type="text" class="tags-input" id="tagInput" placeholder="Ketik tag lalu Enter..." />
                            </div>
                            <div class="fhint"><i class="bi bi-lightbulb"></i> Contoh: smart-city, 2025, koordinasi, infrastruktur</div>
                        </div>
                    </div>
                </div>

                <!-- 2. Uraian Kegiatan -->
                <div class="form-card">
                    <div class="fc-head green">
                        <div>
                            <div class="fc-title"><i class="bi bi-file-text-fill"></i> Uraian Kegiatan</div>
                            <div class="fc-desc">Deskripsi lengkap jalannya kegiatan</div>
                        </div>
                    </div>
                    <div class="fc-body">
                        <div class="fgroup" id="grp-uraian">
                            <label for="editor-uraian" class="flabel"><i class="bi bi-pen-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Uraian Kegiatan <span class="req">*</span></label>
                            <div class="ck-editor-wrap" id="ck-wrap">
                                <textarea id="editor-uraian" name="uraian">{!! $kegiatan->uraian !!}</textarea>
                            </div>
                            <div class="finvalid" id="err-uraian">Uraian kegiatan wajib diisi.</div>
                        </div>
                    </div>
                </div>

                <!-- 3. Upload Foto -->
                <div class="form-card">
                    <div class="fc-head amber">
                        <div>
                            <div class="fc-title"><i class="bi bi-images"></i> Upload Foto Dokumentasi</div>
                            <div class="fc-desc">Maksimal 20 foto per kegiatan</div>
                        </div>
                        <div class="char-counter" id="photoCountLabel" style="margin-top:0;">0 / 20</div>
                    </div>
                    <div class="fc-body">
                        <div class="photo-upload-zone" id="uploadZone" onclick="document.getElementById('photoInput').click()">
                            <input type="file" id="photoInput" multiple accept="image/*" onchange="handleFileSelect(event)" />
                            <div class="upload-icon-wrap"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                            <div class="upload-title">Tarik foto baru ke sini atau klik untuk memilih</div>
                            <div class="upload-sub">Format: JPG, PNG, WEBP (Maks 5MB per foto)</div>
                            <div class="upload-or">Atau</div>
                            <button type="button" class="btn-browse"><i class="bi bi-plus-lg"></i> Tambah Foto</button>
                        </div>

                        <div class="photo-preview-wrap" id="photoPreviewWrap">
                            <!-- JS Generated Previews -->
                        </div>

                        <div class="photo-counter">
                            <div class="photo-counter-info">
                                <i class="bi bi-info-circle-fill"></i> Kapasitas Upload
                            </div>
                            <div class="photo-counter-bar-wrap">
                                <div class="photo-counter-bar">
                                    <div class="photo-counter-fill" id="photoCounterFill" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="photo-counter-num" id="photoCounterNum">0 / 20</div>
                            <button type="button" class="btn-clear-photos" onclick="clearPhotos()"><i class="bi bi-trash3"></i> Kosongkan</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ═══ RIGHT COLUMN ═══ -->
            <aside class="form-right-col">
                <!-- Status Dokumentasi -->
                <div class="side-card">
                    <div class="sc-head">
                        <div class="sc-title"><i class="bi bi-check2-circle"></i> Status Dokumentasi</div>
                    </div>
                    <div class="sc-body">
                        <div class="status-options">
                            <div class="status-opt">
                                <input type="radio" name="status" id="st-draft" value="draft" {{ $kegiatan->status == 'draft' ? 'checked' : '' }} />
                                <label for="st-draft" class="draft">
                                    <i class="bi bi-file-earmark-text"></i> Draft
                                </label>
                            </div>
                            <div class="status-opt">
                                <input type="radio" name="status" id="st-berjalan" value="berjalan" {{ $kegiatan->status == 'berjalan' ? 'checked' : '' }} />
                                <label for="st-berjalan" class="berjalan">
                                    <i class="bi bi-play-circle"></i> Berjalan
                                </label>
                            </div>
                            <div class="status-opt">
                                <input type="radio" name="status" id="st-selesai" value="selesai" {{ $kegiatan->status == 'selesai' ? 'checked' : '' }} />
                                <label for="st-selesai" class="selesai">
                                    <i class="bi bi-check-all"></i> Selesai
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Peserta -->
                <div class="side-card">
                    <div class="sc-head">
                        <div class="sc-title"><i class="bi bi-people-fill"></i> Detail Peserta</div>
                    </div>
                    <div class="sc-body">
                        <div class="fgroup">
                            <label for="f-peserta" class="flabel">Jumlah Peserta <span class="opt">(opsional)</span></label>
                            <div class="fwrap">
                                <i class="bi bi-people-fill ficon"></i>
                                <input type="number" class="fctrl" id="f-peserta" name="jumlah_peserta" value="{{ $kegiatan->jumlah_peserta }}" placeholder="0" min="0" />
                            </div>
                        </div>
                        <div class="fgroup" style="margin-bottom:0;">
                            <label for="f-narasumber" class="flabel">Narasumber / Pemateri <span class="opt">(opsional)</span></label>
                            <div class="fwrap">
                                <i class="bi bi-person-video3 ficon"></i>
                                <input type="text" class="fctrl" id="f-narasumber" name="narasumber" value="{{ $kegiatan->narasumber }}" placeholder="Nama narasumber" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Petugas Dokumentasi -->
                <div class="side-card">
                    <div class="sc-head">
                        <div class="sc-title"><i class="bi bi-person-badge"></i> Petugas Dokumentasi</div>
                    </div>
                    <div class="sc-body" style="padding: 12px 18px;">
                        <div class="fgroup" style="margin-bottom: 12px;">
                            <div class="fwrap">
                                <i class="bi bi-search ficon"></i>
                                <input type="text" class="fctrl" id="searchPetugas" placeholder="Cari nama petugas..." onkeyup="filterPetugas()" style="padding: 8px 12px 8px 36px; font-size: .8rem; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="petugas-list" id="petugasList">
                            @foreach($users as $user)
                                @php
                                    $initials = collect(explode(' ', $user->name))->map(fn($n) => str($n)->substr(0,1))->take(2)->join('');
                                    $colors = ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#7c3aed'];
                                    $color = $colors[$loop->index % count($colors)];
                                @endphp
                                <div class="petugas-opt">
                                    <input type="radio" name="petugas_id" id="p-{{ $user->id }}" value="{{ $user->id }}" {{ $kegiatan->petugas_id == $user->id ? 'checked' : '' }} />
                                    <label for="p-{{ $user->id }}">
                                        <div class="p-avatar" style="background: {{ $color }};">{{ $initials }}</div>
                                        <div>
                                            <div class="p-name">{{ $user->name }}</div>
                                            <div class="p-role">{{ $user->roles->first()->name ?? 'Staff' }}</div>
                                        </div>
                                        <div class="p-check"></div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Lampiran Dokumen -->
                <div class="side-card">
                    <div class="sc-head">
                        <div class="sc-title"><i class="bi bi-paperclip"></i> Lampiran Dokumen</div>
                    </div>
                    <div class="sc-body">
                        <div class="photo-upload-zone" style="padding:18px 14px;" onclick="document.getElementById('docInput').click()">
                            <input type="file" id="docInput" name="attachments[]" accept=".pdf,.docx,.xlsx,.pptx" multiple style="display:none;" onchange="handleDocSelect(event)" />
                            <i class="bi bi-file-earmark-arrow-up-fill" style="font-size:1.6rem;color:var(--c-muted);display:block;margin: 0 auto 7px;"></i>
                            <div style="font-size:.8rem;font-weight:700;color:var(--c-text);margin-bottom:3px;text-align:center;">Upload Dokumen Baru</div>
                        </div>
                        <div id="docPreview" style="margin-top:8px;display:flex;flex-direction:column;gap:5px;"></div>
                    </div>
                </div>
            </aside>
        </div>

        <!-- Hidden input for deleted media IDs -->
        <input type="hidden" name="deleted_media" id="deletedMedia" value="">

        <!-- Form Actions Bar -->
        <div class="form-actions-bar fade-up">
            <button type="button" class="btn-cancel-form" onclick="cancelForm()">
                <i class="bi bi-x-circle"></i> Batalkan
            </button>
            <div style="margin-left:auto; display:flex; gap:10px;">
                <button type="button" class="btn-submit" onclick="submitForm(false)">
                    <i class="bi bi-save-fill"></i> Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    <!-- Photo Preview Modal -->
    <div class="preview-modal-overlay" id="previewOverlay" onclick="closePreview()">
        <button type="button" class="preview-close"><i class="bi bi-x-lg"></i></button>
        <img src="" alt="Preview Full" id="previewImg" class="preview-modal-img" onclick="event.stopPropagation()">
    </div>

    <!-- Floating Action Button -->
    <button class="fab" id="fabBtn" onclick="scrollToTop()" aria-label="Kembali ke atas">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script>
        // Data for existing media
        window.existingMedia = {
            photos: {!! json_encode($kegiatan->getMedia('foto_kegiatan')->map(fn($m) => [
                'id' => $m->id,
                'src' => $m->getUrl(),
                'name' => $m->file_name
            ])) !!},
            docs: {!! json_encode($kegiatan->getMedia('lampiran_kegiatan')->map(fn($m) => [
                'id' => $m->id,
                'name' => $m->file_name,
                'download_url' => route('kegiatan.download', $m->uuid)
            ])) !!}
        };
        window.existingTags = {!! json_encode($kegiatan->tags ?? []) !!};
    </script>

    @push('js')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/js/kegiatan-form.js') }}"></script>
    @endpush
</x-master-layout>
