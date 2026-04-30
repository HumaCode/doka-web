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

// --- GLOBAL VARIABLES --- //
let currentPage = 1;

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
                    
                    // Avatar colors logic
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

    // Modal overlay close
    $('#modalUK').on('click', function(e) {
        if (e.target === this) closeModal();
    });
    
    $('#drawerOverlay').on('click', function(e) {
        if (e.target === this) closeDrawer();
    });
});

// --- HELPER FUNCTIONS --- //
function updateBulk() {
    const checked = $('.row-check:checked').length;
    $('#selectedCountText').text(`${checked} dipilih`);
    $('#bulkActions').toggleClass('show', checked > 0);
}

function toggleAllCheck(el) {
    $('.row-check').prop('checked', el.checked);
    updateBulk();
}

function resetFilters() {
    $('#searchInput').val('');
    $('#filterStatus').val('');
    $('#filterJenis').val('');
    renderTable(1);
}

function closeModal() {
    $('#modalUK').removeClass('show');
    document.body.style.overflow = '';
}

function closeDrawer() {
    $('#drawerOverlay').removeClass('show');
}

// --- PLACEHOLDERS FOR CRUD --- //
function openAddModal() {
    DKA.notify({ type: 'info', title: 'Info', message: 'Fungsi Tambah akan segera diimplementasikan.' });
}

function openEditModal(id) {
    DKA.notify({ type: 'info', title: 'Info', message: 'Fungsi Edit ID: ' + id });
}

function toggleStatus(id) {
    DKA.notify({ type: 'info', title: 'Info', message: 'Toggle Status ID: ' + id });
}

function deleteUK(id, nama) {
    DKA.deleteConfirm({
        title: 'Hapus Unit Kerja?',
        message: 'Data unit kerja akan dihapus permanen.',
        itemName: nama
    }).then(res => {
        if (res) DKA.notify({ type: 'success', title: 'Berhasil', message: 'Data berhasil dihapus (Simulasi)' });
    });
}

function openDrawer(id) {
    DKA.notify({ type: 'info', title: 'Info', message: 'Buka Detail ID: ' + id });
}

function doExport() {
    DKA.notify({ type: 'success', title: 'Export', message: 'Mengekspor data...' });
}
