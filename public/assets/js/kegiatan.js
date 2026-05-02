/**
 * ═══════════════════════════════════════
 * KEGIATAN MODULE JS (AJAX VERSION - OPTIMIZED)
 * ═══════════════════════════════════════
 */

// Global State
let currentView = localStorage.getItem('kegiatan_view') || 'card';
let currentPage = 1;
let perPage = 12; 
let selectedIds = new Set();
let sortField = 'created_at';
let sortOrder = 'desc';
let lastResponseData = null;

// Configuration
const STATUS_CFG = {
    selesai: { cls: 'kc-badge-selesai', label: 'Selesai', tbl: 'sp-selesai', tbllabel: 'Selesai' },
    draft: { cls: 'kc-badge-draft', label: 'Draft', tbl: 'sp-draft', tbllabel: 'Draft' },
    berjalan: { cls: 'kc-badge-berjalan', label: 'Sedang Berjalan', tbl: 'sp-berjalan', tbllabel: 'Berjalan' },
};

$(document).ready(function () {
    // Initialize Select2
    $('.toolbar-select').select2({
        width: 'auto'
    }).on('change', function() {
        filterData();
    });

    loadData();
    setView(currentView, false);

    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) $('#fabBtn').addClass('visible');
        else $('#fabBtn').removeClass('visible');
    });

    $('#drawerOverlay').on('click', function (e) {
        if (e.target === this) closeDrawer();
    });

    let searchTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            currentPage = 1;
            loadData();
        }, 500);
    });
});

/* ════════════════════════════════════
   CORE DATA LOADING
════════════════════════════════════ */
function loadData(force = true) {
    const params = {
        page: currentPage,
        per_page: perPage,
        search: $('#searchInput').val(),
        status: $('#filterStatus').val(),
        kategori: $('#filterKategori').val(),
        bulan: $('#filterBulan').val(), // Added month filter
        sort_field: sortField,
        sort_order: sortOrder
    };

    if (!force && lastResponseData) {
        render(lastResponseData.data, lastResponseData.meta);
        return;
    }

    if (currentView === 'card') $('#cardGrid').addClass('loading-opacity');
    else $('#tableBody').addClass('loading-opacity');
    
    $.ajax({
        url: '/kegiatan/data',
        method: 'GET',
        data: params,
        success: function (res) {
            if (res.success) {
                lastResponseData = res.data;
                const data = res.data.data;
                const meta = res.data.meta;
                const stats = res.data.stats;

                updateStats(stats);
                render(data, meta);
                updateBulkBar();
            }
        },
        complete: function() {
            $('.loading-opacity').removeClass('loading-opacity');
        },
        error: function (err) {
            console.error('Failed to load data:', err);
            DKA.notify({ type: 'error', title: 'Kesalahan', message: 'Gagal memuat data dari server.' });
        }
    });
}

function updateStats(stats) {
    if (!stats) return;
    animCounter('sc1', stats.total);
    animCounter('sc2', stats.selesai);
    animCounter('sc3', stats.draft);
    animCounter('sc4', stats.berjalan);
}

function animCounter(id, target) {
    const el = document.getElementById(id); if (!el) return;
    let cur = parseInt(el.textContent.replace(/\./g, '')) || 0;
    const diff = target - cur;
    if (diff === 0) { el.textContent = target.toLocaleString('id-ID'); return; }
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

/* ════════════════════════════════════
   RENDER LOGIC
════════════════════════════════════ */
function render(data, meta) {
    if (currentView === 'card') {
        $('#cardViewWrap').show();
        $('#tableViewWrap').hide();
        $('#cardPaginationWrap').show();
        renderCards(data);
        renderPagination(meta, 'cardPagination', 'cardPageInfo');
    } else {
        $('#cardViewWrap').hide();
        $('#tableViewWrap').show();
        $('#cardPaginationWrap').hide();
        renderTable(data);
        renderPagination(meta, 'pagination', 'pageInfo');
    }
}

function renderCards(data) {
    const grid = $('#cardGrid');
    const empty = $('#emptyCard');
    grid.empty();
    if (!data.length) { empty.removeClass('d-none'); return; }
    empty.addClass('d-none');
    let html = data.map(d => {
        const sc = STATUS_CFG[d.status] || STATUS_CFG['draft'];
        return `
            <div class="kegiatan-card fade-up" data-id="${d.id}">
                <div class="kc-cover">
                    <img src="${d.cover}" alt="${d.judul}" loading="lazy">
                    <span class="kc-badge ${sc.cls}"><i class="bi bi-circle-fill" style="font-size:.45rem;"></i> ${sc.label}</span>
                    ${d.foto_count > 0 ? `<span class="kc-foto-count"><i class="bi bi-images"></i> ${d.foto_count} foto</span>` : ''}
                </div>
                <div class="kc-body">
                    <div class="kc-date"><i class="bi bi-calendar3"></i> ${d.tanggal}</div>
                    <div class="kc-title" title="${d.judul}">${d.judul}</div>
                    <div class="kc-desc">${d.short_uraian}</div>
                    <div class="kc-meta">
                        <div class="kc-meta-item"><i class="bi bi-images" style="color:var(--c-primary);"></i> ${d.foto_count}</div>
                        <div class="kc-meta-item"><i class="bi bi-paperclip" style="color:var(--c-accent);"></i> ${d.attachment_count}</div>
                        <div class="kc-kategori" style="background:${d.kategori.warna}15;color:${d.kategori.warna};">
                            <i class="bi ${d.kategori.icon}"></i> ${d.kategori.nama}
                        </div>
                    </div>
                </div>
                <div class="kc-footer">
                    <div class="kc-uploader">
                        <div class="kc-uploader-avatar" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);">${d.petugas.initials}</div>
                        <span class="kc-uploader-name">${d.petugas.name}</span>
                    </div>
                    <button class="kc-action-btn view" onclick="openDrawer('${d.id}')" title="Detail"><i class="bi bi-eye-fill"></i></button>
                    <button class="kc-action-btn edit" onclick="editKegiatan('${d.id}')" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                    <button class="kc-action-btn delete" onclick="deleteKegiatan('${d.id}', '${d.judul}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                </div>
            </div>`;
    }).join('');
    grid.html(html);
}

function renderTable(data) {
    const body = $('#tableBody');
    const empty = $('#emptyTable');
    body.empty();
    if (!data.length) { empty.removeClass('d-none'); return; }
    empty.addClass('d-none');
    let html = data.map(d => {
        const sc = STATUS_CFG[d.status] || STATUS_CFG['draft'];
        const isChecked = selectedIds.has(d.id) ? 'checked' : '';
        return `
            <tr>
                <td class="col-check"><input type="checkbox" class="row-check" data-id="${d.id}" onchange="toggleCheck('${d.id}')" ${isChecked} /></td>
                <td>
                    <div class="tbl-title-cell">
                        <img src="${d.cover}" class="tbl-thumb" alt="thumb" loading="lazy">
                        <div>
                            <div class="tbl-title" title="${d.judul}">${d.judul}</div>
                            <div class="tbl-desc">${d.short_uraian}</div>
                        </div>
                    </div>
                </td>
                <td><div style="font-weight:600;font-size:.82rem;">${d.tanggal}</div></td>
                <td><span class="kat-pill" style="background:${d.kategori.warna}15;color:${d.kategori.warna};"><i class="bi ${d.kategori.icon}"></i> ${d.kategori.nama}</span></td>
                <td><span class="status-pill ${sc.tbl}">${sc.tbllabel}</span></td>
                <td style="text-align:center;"><span class="foto-pill"><i class="bi bi-images"></i> ${d.foto_count}</span></td>
                <td><div style="font-weight:600;font-size:.82rem;">${d.petugas.name}</div></td>
                <td>
                    <div class="tbl-actions">
                        <button class="tbl-btn tbl-view" onclick="openDrawer('${d.id}')" title="Detail"><i class="bi bi-eye-fill"></i></button>
                        <button class="tbl-btn tbl-edit" onclick="editKegiatan('${d.id}')" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                        <button class="tbl-btn tbl-delete" onclick="deleteKegiatan('${d.id}', '${d.judul}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');
    body.html(html);
}

function renderPagination(meta, containerId, infoId) {
    const pg = $(`#${containerId}`);
    const info = $(`#${infoId}`);
    pg.empty();
    if (!meta) return;
    info.text(`Menampilkan ${meta.from || 0}–${meta.to || 0} dari ${meta.total} kegiatan`);
    if (meta.last_page <= 1) return;
    pg.append(`<button class="page-btn" ${meta.current_page === 1 ? 'disabled' : ''} onclick="changePage(${meta.current_page - 1})"><i class="bi bi-chevron-left"></i></button>`);
    for (let i = 1; i <= meta.last_page; i++) {
        if (i === 1 || i === meta.last_page || (i >= meta.current_page - 1 && i <= meta.current_page + 1)) {
            pg.append(`<button class="page-btn ${i === meta.current_page ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`);
        } else if (i === meta.current_page - 2 || i === meta.current_page + 2) {
            pg.append(`<span style="padding:8px; color:var(--c-muted);">...</span>`);
        }
    }
    pg.append(`<button class="page-btn" ${meta.current_page === meta.last_page ? 'disabled' : ''} onclick="changePage(${meta.current_page + 1})"><i class="bi bi-chevron-right"></i></button>`);
}

/* ════════════════════════════════════
   INTERACTIVE CONTROLS
════════════════════════════════════ */
function changePage(p) { currentPage = p; loadData(); scrollToTop(); }

function setView(v, reload = true) {
    currentView = v;
    localStorage.setItem('kegiatan_view', v);
    $('#btnCardView, #btnTableView').removeClass('active');
    if (v === 'card') $('#btnCardView').addClass('active');
    else $('#btnTableView').addClass('active');
    if (lastResponseData) render(lastResponseData.data, lastResponseData.meta);
    else if (reload) loadData();
}

function filterData() { currentPage = 1; loadData(); }

function resetFilters() {
    $('#searchInput').val('');
    $('#filterStatus').val('').trigger('change');
    $('#filterKategori').val('').trigger('change');
    $('#filterBulan').val('').trigger('change');
}

function sortTable(field) {
    const fields = ['judul', 'tanggal_raw', 'kategori_id', 'status', '', 'petugas_id'];
    const target = fields[field];
    if (!target) return;
    if (sortField === target) sortOrder = sortOrder === 'asc' ? 'desc' : 'asc';
    else { sortField = target; sortOrder = 'asc'; }
    $('.sort-icon').removeClass('bi-chevron-up bi-chevron-down').addClass('bi-chevron-expand');
    const icon = sortOrder === 'asc' ? 'bi-chevron-up' : 'bi-chevron-down';
    $(`.kegiatan-table thead th:nth-child(${field + 2}) .sort-icon`).removeClass('bi-chevron-expand').addClass(icon);
    loadData();
}

/* ════════════════════════════════════
   CHECKBOX & BULK LOGIC
════════════════════════════════════ */
function toggleAllCheck(el) {
    $('.row-check').prop('checked', el.checked);
    if (el.checked) { $('.row-check').each(function() { selectedIds.add($(this).data('id')); }); }
    else { $('.row-check').each(function() { selectedIds.delete($(this).data('id')); }); }
    updateBulkBar();
}

function toggleCheck(id) {
    if (selectedIds.has(id)) selectedIds.delete(id);
    else selectedIds.add(id);
    updateBulkBar();
}

function updateBulkBar() {
    const count = selectedIds.size;
    if (count > 0 && currentView === 'table') { $('#bulkActions').addClass('show'); $('#selectedCountText').text(`${count} dipilih`); }
    else { $('#bulkActions').removeClass('show'); $('#checkAll').prop('checked', false); }
}

function bulkDelete() {
    const ids = Array.from(selectedIds);
    if (ids.length === 0) return;

    DKA.deleteConfirm({ 
        title: 'Hapus Terpilih?', 
        message: `Hapus <strong>${ids.length}</strong> kegiatan yang dipilih?`, 
        itemName: ids.length + ' Item Terpilih' 
    }).then(res => {
        if (!res) return;

        const loader = DKA.loading({ 
            title: 'Menghapus data...', 
            message: 'Sedang membersihkan data terpilih.', 
            style: 'dots' 
        });

        $.ajax({
            url: '/kegiatan/bulk-delete',
            method: 'POST',
            data: { 
                _token: $('meta[name="csrf-token"]').attr('content'), 
                ids: ids 
            },
            success: function(response) { 
                setTimeout(() => {
                    loader.close();
                    if (response.success) {
                        DKA.toast({
                            type: 'success',
                            title: 'Kegiatan Dihapus',
                            message: response.message,
                            position: 'top-right'
                        });
                        
                        $('#bulkActions').removeClass('show');
                        $('#checkAll').prop('checked', false);
                        selectedIds.clear(); 
                        loadData(); 
                    } else {
                        DKA.notify({ 
                            type: 'danger', 
                            title: 'Gagal Menghapus', 
                            message: response.message,
                            duration: 5000 
                        });
                    }
                }, 1000);
            },
            error: function() {
                loader.close();
                DKA.notify({ 
                    type: 'danger', 
                    title: 'Kesalahan Server', 
                    message: 'Koneksi terputus atau terjadi masalah server.',
                    duration: 5000 
                });
            }
        });
    });
}

/* ════════════════════════════════════
   DRAWER & ACTIONS
════════════════════════════════════ */
function openDrawer(id) {
    const item = lastResponseData.data.find(x => x.id === id);
    if (!item) return;
    const sc = STATUS_CFG[item.status] || STATUS_CFG['draft'];
    let bodyHtml = `
        <div class="drawer-gallery">
            <div class="gallery-main-placeholder" style="background:linear-gradient(135deg,#4f46e5,#7c3aed); overflow:hidden;">
                <img src="${item.cover}" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <span class="gallery-count-badge"><i class="bi bi-images"></i> ${item.foto_count} Foto</span>
        </div>
        <div class="drawer-info">
            <div class="d-section-title">Informasi Utama</div>
            <div class="d-info-row">
                <div class="d-info-icon"><i class="bi bi-calendar3"></i></div>
                <div><div class="d-info-label">Tanggal Kegiatan</div><div class="d-info-val">${item.tanggal}</div></div>
            </div>
            <div class="d-info-row">
                <div class="d-info-icon" style="background:${item.kategori.warna}15; color:${item.kategori.warna};"><i class="bi ${item.kategori.icon}"></i></div>
                <div><div class="d-info-label">Kategori</div><div class="d-info-val">${item.kategori.nama}</div></div>
            </div>
            <div class="d-divider" style="height:1px; background:var(--c-border); margin:20px 0;"></div>
            <div class="d-section-title">Uraian</div>
            <h4 style="font-family:'Nunito',sans-serif; font-weight:800; font-size:1.1rem; color:var(--c-text); margin-bottom:12px;">${item.judul}</h4>
            <div class="d-desc-box">${item.uraian}</div>
        </div>
    `;
    $('#drawerBody').html(bodyHtml);
    $('#drawerOverlay').addClass('show');
    $('body').css('overflow', 'hidden');
}

function closeDrawer() { $('#drawerOverlay').removeClass('show'); $('body').css('overflow', ''); }
function editKegiatan(id) { window.location.href = `/kegiatan/${id}/edit`; }
function deleteKegiatan(id, title) {
    DKA.deleteConfirm({ title: 'Hapus Kegiatan?', message: `Hapus "<strong>${title}</strong>"?`, itemName: title }).then(res => {
        if (res) { 
            const loader = DKA.loading({ title: 'Menghapus Kegiatan', message: 'Sedang memproses...', style: 'ring' });
            $.ajax({ 
                url: `/kegiatan/${id}`, 
                method: 'DELETE', 
                data: { _token: $('meta[name="csrf-token"]').attr('content') }, 
                success: function(res) { 
                    loader.close();
                    DKA.notify({ type: 'success', title: 'Berhasil', message: res.message || 'Kegiatan dihapus.' });
                    loadData(); 
                },
                error: function() {
                    loader.close();
                    DKA.notify({ type: 'error', title: 'Gagal', message: 'Gagal menghapus kegiatan.' });
                }
            }); 
        }
    });
}
function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }
