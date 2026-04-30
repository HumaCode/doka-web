/**
 * Reusable debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

const GRADS = [
    'linear-gradient(135deg,#4f46e5,#7c3aed)',
    'linear-gradient(135deg,#10b981,#06b6d4)',
    'linear-gradient(135deg,#f59e0b,#f97316)',
    'linear-gradient(135deg,#ec4899,#f472b6)',
    'linear-gradient(135deg,#8b5cf6,#a78bfa)',
    'linear-gradient(135deg,#ef4444,#f87171)',
    'linear-gradient(135deg,#0891b2,#22d3ee)',
    'linear-gradient(135deg,#059669,#34d399)',
    'linear-gradient(135deg,#d97706,#fbbf24)',
    'linear-gradient(135deg,#1d4ed8,#38bdf8)',
    'linear-gradient(135deg,#7c3aed,#ec4899)',
    'linear-gradient(135deg,#be185d,#f9a8d4)',
    'linear-gradient(135deg,#064e3b,#10b981)',
    'linear-gradient(135deg,#b45309,#fde68a)',
    'linear-gradient(135deg,#64748b,#94a3b8)',
    'linear-gradient(135deg,#15803d,#4ade80)',
];

const JENIS_MAP = {
    'Dinas'      : 'jb-dinas',
    'Badan'      : 'jb-badan',
    'Bagian'     : 'jb-bagian',
    'Inspektorat': 'jb-inspektorat',
    'Sekretariat': 'jb-sekretariat',
    'Kantor'     : 'jb-kantor',
    'RSUD'       : 'jb-rsud',
};

const ICONS = [
    'bi-building', 'bi-building-fill', 'bi-cpu-fill', 'bi-journal-bookmark-fill', 'bi-hospital-fill',
    'bi-heart-fill', 'bi-building-gear', 'bi-tree-fill', 'bi-bus-front-fill', 'bi-trophy-fill',
    'bi-graph-up-arrow', 'bi-people-fill', 'bi-shield-fill', 'bi-building-lock', 'bi-journal-text',
    'bi-shield-check-fill', 'bi-megaphone-fill', 'bi-briefcase-fill', 'bi-gear-fill', 'bi-cash-coin',
    'bi-tools', 'bi-bank', 'bi-mortarboard-fill', 'bi-droplet-fill', 'bi-lightning-charge-fill',
    'bi-reception-4', 'bi-broadcast-pin', 'bi-camera-reels-fill', 'bi-cart-fill', 'bi-chat-dots-fill'
];

// --- GLOBAL VARIABLES --- //
let currentPage = 1;
let selectedIcon = 'bi-building-fill';
let selectedColorIdx = 0;
let currentId = null; // null for add, string ID for edit

// --- DATA LOADING --- //
function renderTable(page = 1) {
    currentPage = page;
    const search = $('#searchInput').val();
    const status = $('#filterStatus').val();
    const jenis = $('#filterJenis').val();
    const perPage = $('#perPageSelect').val() || 15;

    const body = $('#tableBody');
    body.html('<tr><td colspan="9" style="text-align:center; padding:50px;"><span class="spinner-border spinner-border-sm"></span> Memuat data...</td></tr>');

    $.ajax({
        url: "/unit-kerja/getallpagination",
        method: "GET",
        data: {
            page: page,
            search: search,
            status: status,
            jenis: jenis,
            per_page: perPage
        },
        success: function(response) {
            if (response.success) {
                const result = response.data;
                const items = result.data;
                const meta = result.meta;
                const stats = result.stats;

                if (items.length === 0) {
                    body.html('<tr><td colspan="9" style="text-align:center; padding:50px; color:var(--c-muted);">Tidak ada data unit kerja ditemukan.</td></tr>');
                    updatePagination(meta);
                    updateStats(stats);
                    return;
                }

                body.empty();
                items.forEach((d, i) => {
                    const gradStr = GRADS[d.warna % GRADS.length] || GRADS[0];
                    const jClass = JENIS_MAP[d.jenis] || 'jb-default';
                    const init = d.kepala ? d.kepala.split(' ').filter(v => !v.includes('.')).map(w => w[0]).join('').slice(0, 2).toUpperCase() : '—';
                    
                    const avColors = ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#06b6d4'];
                    const avGrad = avColors[i % avColors.length];

                    body.append(`
                        <tr>
                            <td class="col-check"><input type="checkbox" class="row-check" data-id="${d.id}" onchange="updateBulk()"></td>
                            <td>
                                <div class="uk-name-cell">
                                    <div class="uk-logo" style="background:${gradStr};"><i class="bi ${d.icon || 'bi-building'}"></i></div>
                                    <div>
                                        <div class="uk-name-text">${d.nama}</div>
                                        <span class="uk-sing-text">${d.singkatan}</span>
                                    </div>
                                </div>
                            </td>
                            <td><span class="jenis-badge ${jClass}">${d.jenis}</span></td>
                            <td>
                                ${d.kepala
                                    ? `<div class="kepala-cell">
                                        <div class="kepala-av" style="background:${avGrad};">${init}</div>
                                        <span style="font-size:.82rem;font-weight:600;color:var(--c-text);">${d.kepala}</span>
                                      </div>`
                                    : `<span style="color:var(--c-muted);font-size:.82rem;">—</span>`}
                            </td>
                            <td style="text-align:center;"><span class="count-pill"><i class="bi bi-calendar3-fill"></i> ${d.kegiatan || 0}</span></td>
                            <td style="text-align:center;"><span class="count-pill"><i class="bi bi-people-fill" style="color:var(--c-green);"></i> ${d.pengguna || 0}</span></td>
                            <td style="text-align:center;"><span class="count-pill"><i class="bi bi-images" style="color:var(--c-pink);"></i> ${d.foto || 0}</span></td>
                            <td><span class="status-pill ${d.status === 'active' ? 'sp-active' : 'sp-inactive'}">${d.status === 'active' ? 'Aktif' : 'Nonaktif'}</span></td>
                            <td>
                                <div class="tbl-actions">
                                    <button class="tbl-btn tbl-view" onclick="openDrawer('${d.id}')" title="Detail"><i class="bi bi-eye-fill"></i></button>
                                    <button class="tbl-btn tbl-edit" onclick="openEditModal('${d.id}')" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="tbl-btn tbl-toggle" onclick="toggleStatus('${d.id}')" title="Ubah Status"><i class="bi ${d.status === 'active' ? 'bi-toggle-on' : 'bi-toggle-off'}"></i></button>
                                    <button class="tbl-btn tbl-delete" onclick="deleteUK('${d.id}', '${d.nama}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                $('#tableCountBadge').text(`${meta.total} unit`);
                $('#pageInfo').text(`Menampilkan ${meta.from || 0}–${meta.to || 0} dari ${meta.total} unit kerja`);
                updatePagination(meta);
                updateStats(stats);
            }
        },
        error: function() {
            body.html('<tr><td colspan="9" style="text-align:center; padding:50px; color:var(--c-red);">Gagal memuat data dari server.</td></tr>');
        }
    });
}

function updatePagination(meta) {
    const pg = $('#pagination');
    pg.empty();
    if (meta.last_page <= 1) return;

    pg.append(`<button class="page-btn" ${meta.current_page === 1 ? 'disabled' : ''} onclick="renderTable(${meta.current_page - 1})"><i class="bi bi-chevron-left"></i></button>`);

    for (let i = 1; i <= meta.last_page; i++) {
        if (i === 1 || i === meta.last_page || (i >= meta.current_page - 1 && i <= meta.current_page + 1)) {
            pg.append(`<button class="page-btn ${i === meta.current_page ? 'active' : ''}" onclick="renderTable(${i})">${i}</button>`);
        } else if (i === meta.current_page - 2 || i === meta.current_page + 2) {
            pg.append(`<span style="padding:8px; color:var(--c-muted);">...</span>`);
        }
    }

    pg.append(`<button class="page-btn" ${meta.current_page === meta.last_page ? 'disabled' : ''} onclick="renderTable(${meta.current_page + 1})"><i class="bi bi-chevron-right"></i></button>`);
}

function updateStats(stats) {
    if (!stats) return;
    animCounter('sc1', stats.total);
    animCounter('sc2', stats.active);
    animCounter('sc3', stats.kegiatan);
    animCounter('sc4', stats.pengguna);
}

function animCounter(id, target) {
    const el = document.getElementById(id);
    if (!el) return;
    let cur = parseInt(el.textContent.replace(/\./g, '')) || 0;
    const diff = target - cur;
    if (diff === 0) return;
    
    const duration = 1000;
    const start = performance.now();
    const from = cur;

    function step(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        const val = Math.floor(from + diff * progress);
        el.textContent = val.toLocaleString('id-ID');
        if (progress < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
}

// --- INITIALIZATION --- //
$(document).ready(function() {
    renderTable();

    const debouncedSearch = debounce(() => renderTable(1), 500);
    $('#searchInput').on('input', debouncedSearch);
    $('#filterStatus, #filterJenis, #perPageSelect').on('change', () => renderTable(1));

    // Modal logic
    $('#modalUK').on('click', function(e) { if (e.target === this) closeModal(); });
    $('#drawerOverlay').on('click', function(e) { if (e.target === this) closeDrawer(); });

    buildIconGrid();
    initColorSwatches();
    initSelect2();
});

function initSelect2() {
    $('#f-jenis').select2({
        dropdownParent: $('#modalUK'),
        placeholder: '-- Pilih Jenis --',
        width: '100%'
    }).on('change', function() {
        const val = $(this).val();
        onJenisInput(val);
        clearErr('grp-jenis');
    });
}

// --- UI HELPERS --- //
function buildIconGrid(query = '') {
    const grid = $('#iconGrid');
    grid.empty();
    const filtered = ICONS.filter(i => i.includes(query.toLowerCase()));
    filtered.forEach(icon => {
        const active = icon === selectedIcon ? 'selected' : '';
        grid.append(`<div class="icon-btn ${active}" onclick="selectIcon('${icon}', this)"><i class="bi ${icon}"></i></div>`);
    });
}

function selectIcon(icon, el) {
    selectedIcon = icon;
    $('.icon-btn').removeClass('selected');
    $(el).addClass('selected');
    $('#mPreviewIcon, #mHeadIconI').attr('class', 'bi ' + icon);
}

function initColorSwatches() {
    const container = $('#colorSwatches');
    container.empty();
    GRADS.forEach((grad, i) => {
        const active = i === selectedColorIdx ? 'selected' : '';
        container.append(`<div class="c-swatch ${active}" style="background:${grad}" onclick="selectColor(${i}, this)"></div>`);
    });
}

function selectColor(idx, el) {
    selectedColorIdx = idx;
    $('.c-swatch').removeClass('selected');
    $(el).addClass('selected');
    const grad = GRADS[idx];
    $('#mPreviewLogo, #mHeadIcon').css('background', grad);
}

// --- FORM INPUT EVENTS --- //
function onNamaInput(val) { $('#mPreviewName').text(val || 'Nama Unit Kerja'); }
function onSingInput(val) { updatePreviewSubtitle(); }
function onJenisInput(val) { updatePreviewSubtitle(); }
function updatePreviewSubtitle() {
    const s = $('#f-sing').val() || 'Singkatan';
    const j = $('#f-jenis').val() || 'Jenis';
    $('#mPreviewSing').text(`${s} · ${j}`);
}
function clearErr(id) { $(`#${id}`).removeClass('has-error'); }

// --- MODAL CONTROL --- //
function openAddModal() {
    currentId = null;
    resetForm();
    $('#mTitleText').text('Tambah Unit Kerja');
    $('#btnSave').html('<i class="bi bi-check2-circle"></i> Simpan');
    $('#modalUK').addClass('show');
    document.body.style.overflow = 'hidden';
}

function openEditModal(id) {
    resetForm();
    currentId = id;
    $('#mTitleText').text('Edit Unit Kerja');
    $('#btnSave').html('<i class="bi bi-check2-circle"></i> Perbarui');
    
    const loader = DKA.loading({ title: 'Memuat Data', message: 'Sedang mengambil data unit kerja...', style: 'ring' });

    $.ajax({
        url: `/unit-kerja/${id}`,
        method: "GET",
        success: function(res) {
            loader.close();
            if (res.success) {
                const d = res.data;
                $('#f-nama').val(d.nama);
                $('#f-sing').val(d.singkatan);
                $('#f-jenis').val(d.jenis).trigger('change');
                $('#f-kepala').val(d.kepala);
                $('#f-telp').val(d.telp);
                $('#f-email').val(d.email);
                $('#f-web').val(d.website);
                $('#f-alamat').val(d.alamat);
                $('#f-desc').val(d.deskripsi);
                
                selectedIcon = d.icon || 'bi-building-fill';
                selectedColorIdx = parseInt(d.warna) || 0;
                
                buildIconGrid();
                initColorSwatches();
                onNamaInput(d.nama);
                updatePreviewSubtitle();
                
                // Update preview icons/colors
                $('#mPreviewIcon, #mHeadIconI').attr('class', 'bi ' + selectedIcon);
                $('#mPreviewLogo, #mHeadIcon').css('background', GRADS[selectedColorIdx % GRADS.length]);

                $('#modalUK').addClass('show');
                document.body.style.overflow = 'hidden';
            }
        },
        error: function() {
            loader.close();
            DKA.notify({ type: 'danger', title: 'Error', message: 'Gagal memuat data unit kerja.' });
        }
    });
}

function closeModal() {
    $('#modalUK').removeClass('show');
    document.body.style.overflow = '';
}

function resetForm() {
    currentId = null;
    $('#f-nama, #f-sing, #f-kepala, #f-telp, #f-email, #f-web, #f-alamat, #f-desc').val('');
    $('#f-jenis').val('').trigger('change');
    $('.fgroup').removeClass('has-err');
    selectedIcon = 'bi-building-fill';
    selectedColorIdx = 0;
    buildIconGrid();
    initColorSwatches();
    onNamaInput('');
    updatePreviewSubtitle();
    
    // Reset preview icons/colors
    $('#mPreviewIcon, #mHeadIconI').attr('class', 'bi ' + selectedIcon);
    $('#mPreviewLogo, #mHeadIcon').css('background', GRADS[0]);
}

// --- AJAX OPERATIONS --- //
function saveUK() {
    const nama = $('#f-nama').val();
    const sing = $('#f-sing').val();
    const jenis = $('#f-jenis').val();

    let hasError = false;
    $('.fgroup').removeClass('has-err');
    
    if (!nama) { $('#grp-nama').addClass('has-err'); hasError = true; }
    if (!sing) { $('#grp-sing').addClass('has-err'); hasError = true; }
    if (!jenis) { $('#grp-jenis').addClass('has-err'); hasError = true; }
    
    if (hasError) {
        DKA.notify({
            type: 'danger',
            title: 'Validasi Gagal',
            message: 'Harap lengkapi semua kolom yang wajib diisi (*).',
            duration: 3000
        });
        return;
    }

    const data = {
        nama_instansi: nama,
        singkatan: sing,
        jenis_opd: jenis,
        nama_kepala: $('#f-kepala').val(),
        telp: $('#f-telp').val(),
        email: $('#f-email').val(),
        website: $('#f-web').val(),
        alamat: $('#f-alamat').val(),
        deskripsi: $('#f-desc').val(),
        icon: selectedIcon,
        warna: selectedColorIdx,
        status: 'active'
    };

    const steps = [
        'Memvalidasi data...',
        'Mengirim ke server...',
        'Menyimpan ke database...',
        'Selesai!'
    ];

    const loader = DKA.loading({ 
        title: currentId ? 'Memperbarui Unit Kerja' : 'Menyimpan Unit Kerja', 
        message: 'Memulai proses...', 
        style: 'ring' 
    });

    steps.forEach((msg, i) => {
        setTimeout(() => loader.update(msg), (i + 1) * 600);
    });

    $.ajax({
        url: currentId ? `/unit-kerja/${currentId}` : "/unit-kerja",
        method: currentId ? "PUT" : "POST",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: data,
        success: function(res) {
            setTimeout(() => {
                loader.close();
                if (res.success) {
                    DKA.notify({ 
                        type: 'success', 
                        title: 'Berhasil', 
                        message: res.message,
                        duration: 5000 
                    });
                    closeModal();
                    renderTable(1);
                }
            }, steps.length * 600);
        },
        error: function(xhr) {
            loader.close();
            if (xhr.status === 422) {
                const errs = xhr.responseJSON.errors;
                let msg = '';
                $.each(errs, (k, v) => msg += v[0] + '<br>');
                DKA.notify({ type: 'danger', title: 'Validasi Gagal', message: msg });
            } else {
                DKA.notify({ type: 'danger', title: 'Error', message: 'Terjadi kesalahan sistem.' });
            }
        }
    });
}

function deleteUK(id, nama) {
    DKA.deleteConfirm({
        title: 'Hapus Unit Kerja?',
        message: 'Data unit kerja akan dihapus permanen.',
        itemName: nama
    }).then(res => {
        if (res) {
            DKA.notify({ type: 'info', title: 'Simulasi', message: 'Fungsi hapus ID: ' + id });
        }
    });
}

// Other helpers...
function updateBulk() {
    const checked = $('.row-check:checked').length;
    $('#selectedCountText').text(`${checked} dipilih`);
    $('#bulkActions').toggleClass('show', checked > 0);
}
function toggleAllCheck(el) { $('.row-check').prop('checked', el.checked); updateBulk(); }
function resetFilters() { $('#searchInput').val(''); $('#filterStatus').val(''); $('#filterJenis').val(''); renderTable(1); }
function closeDrawer() { $('#drawerOverlay').removeClass('show'); }
function openDrawer(id) {
    const overlay = $('#drawerOverlay');
    const body = $('#drawerBody');
    
    // Reset body and show loader
    body.html('<div style="padding:50px; text-align:center;"><span class="spinner-border text-primary"></span><br><small class="text-muted mt-2 d-block">Memuat Detail...</small></div>');
    overlay.addClass('show');
    document.body.style.overflow = 'hidden';

    $.ajax({
        url: `/unit-kerja/${id}`,
        method: "GET",
        success: function(res) {
            if (res.success) {
                renderDrawerBody(res.data);
                
                // Bind buttons
                $('#drawerEditBtn').off('click').on('click', function() {
                    closeDrawer();
                    openEditModal(id);
                });
                $('#drawerDeleteBtn').off('click').on('click', function() {
                    deleteUK(id, res.data.nama);
                });
            }
        },
        error: function() {
            body.html('<div style="padding:50px; text-align:center; color:var(--c-red);">Gagal memuat data.</div>');
        }
    });
}

function renderDrawerBody(d) {
    const gradStr = GRADS[d.warna % GRADS.length] || GRADS[0];
    const jClass = JENIS_MAP[d.jenis] || 'jb-default';
    const inits = d.singkatan.replace(/[^A-Za-z0-9]/g,'').slice(0,3).toUpperCase();
    
    let html = `
        <div class="d-hero" style="background:${gradStr};">
            <div class="d-hero-watermark">${inits}</div>
            <div class="d-hero-logo"><i class="bi ${d.icon || 'bi-building-fill'}"></i></div>
            <div class="d-hero-info">
                <div class="d-hero-name">${d.nama}</div>
                <div class="d-hero-sing">${d.singkatan} · ${d.jenis}</div>
            </div>
        </div>

        <div class="d-section">
            <!-- Stat grid -->
            <div class="d-stat-grid">
                <div class="d-stat-box"><div class="d-stat-val">${d.kegiatan || 0}</div><div class="d-stat-lbl">Kegiatan</div></div>
                <div class="d-stat-box"><div class="d-stat-val">${d.pengguna || 0}</div><div class="d-stat-lbl">Pengguna</div></div>
                <div class="d-stat-box"><div class="d-stat-val">${d.foto || 0}</div><div class="d-stat-lbl">Foto</div></div>
            </div>

            <!-- Status & Badge -->
            <div style="margin-bottom:14px;">
                <span class="status-pill ${d.status === 'active' ? 'sp-active' : 'sp-inactive'}">
                    ${d.status === 'active' ? 'Aktif' : 'Nonaktif'}
                </span>
                &nbsp;
                <span class="jenis-badge ${jClass}">${d.jenis}</span>
            </div>

            <div class="d-divider"></div>
            <div class="d-sec-title">Informasi Utama</div>

            ${d.kepala ? `
            <div class="d-row">
                <div class="d-icon"><i class="bi bi-person-fill"></i></div>
                <div><div class="d-lbl">Kepala / Pimpinan</div><div class="d-val">${d.kepala}</div></div>
            </div>` : ''}

            ${d.alamat ? `
            <div class="d-row">
                <div class="d-icon"><i class="bi bi-geo-alt-fill"></i></div>
                <div><div class="d-lbl">Alamat</div><div class="d-val">${d.alamat}</div></div>
            </div>` : ''}

            ${d.telp ? `
            <div class="d-row">
                <div class="d-icon"><i class="bi bi-telephone-fill"></i></div>
                <div><div class="d-lbl">Telepon</div><div class="d-val">${d.telp}</div></div>
            </div>` : ''}

            ${d.email ? `
            <div class="d-row">
                <div class="d-icon"><i class="bi bi-envelope-fill"></i></div>
                <div><div class="d-lbl">Email</div><div class="d-val"><a href="mailto:${d.email}" class="d-link">${d.email}</a></div></div>
            </div>` : ''}

            ${d.web ? `
            <div class="d-row">
                <div class="d-icon"><i class="bi bi-globe"></i></div>
                <div><div class="d-lbl">Website</div><div class="d-val"><a href="${d.web}" target="_blank" class="d-link">${d.web}</a></div></div>
            </div>` : ''}

            ${d.deskripsi ? `
            <div class="d-divider"></div>
            <div class="d-sec-title">Tupoksi / Deskripsi</div>
            <div style="font-size:.855rem;color:var(--c-text-2);line-height:1.78;background:var(--c-surface2);border:1px solid var(--c-border);border-radius:10px;padding:14px;">
                ${d.deskripsi}
            </div>` : ''}
        </div>
    `;
    
    $('#drawerBody').html(html);
}
function doExport() { DKA.notify({ type: 'success', title: 'Export', message: 'Mengekspor data...' }); }
function toggleStatus(id) { DKA.notify({ type: 'info', title: 'Info', message: 'Toggle Status ID: ' + id }); }
