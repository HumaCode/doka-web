/**
 * Reusable debounce function to limit the rate at which a function can fire.
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

/* ════════════════════════════════════
   STATE
════════════════════════════════════ */
let currentPage  = 1;
let currentView  = 'card';
let editingId    = null;
let selIcon      = 'bi-tags-fill';
let selColor     = 0;

const ALL_ICONS = [
    'bi-people-fill','bi-book-fill','bi-geo-alt-fill','bi-megaphone-fill','bi-flag-fill',
    'bi-shop-window','bi-heart-fill','bi-three-dots-vertical','bi-calendar3-fill','bi-camera-fill',
    'bi-briefcase-fill','bi-building-fill','bi-chat-dots-fill','bi-trophy-fill','bi-star-fill',
    'bi-lightning-fill','bi-shield-fill','bi-house-fill','bi-globe-americas','bi-phone-fill',
    'bi-laptop','bi-cpu-fill','bi-database-fill','bi-cloud-fill','bi-graph-up-arrow',
    'bi-pie-chart-fill','bi-bar-chart-fill','bi-newspaper','bi-envelope-fill','bi-bell-fill',
    'bi-person-fill','bi-person-workspace','bi-gear-fill','bi-tools','bi-wrench-adjustable',
    'bi-clipboard-fill','bi-file-earmark-text-fill','bi-journals','bi-bookmark-fill','bi-pin-fill',
    'bi-music-note-beamed','bi-camera-video-fill','bi-image-fill','bi-palette-fill','bi-brush-fill',
    'bi-headphones','bi-mic-fill','bi-broadcast-pin','bi-wifi','bi-usb-symbol',
    'bi-flower1','bi-tree-fill','bi-sun-fill','bi-moon-fill','bi-cloud-rain-fill',
    'bi-airplane-fill','bi-bus-front-fill','bi-bicycle','bi-bag-fill','bi-box-seam-fill',
];

const COLORS = [
    { id:0,  grad:'linear-gradient(135deg,#4f46e5,#7c3aed)',  hex:'#4f46e5' },
    { id:1,  grad:'linear-gradient(135deg,#10b981,#06b6d4)',  hex:'#10b981' },
    { id:2,  grad:'linear-gradient(135deg,#f59e0b,#f97316)',  hex:'#f59e0b' },
    { id:3,  grad:'linear-gradient(135deg,#06b6d4,#3b82f6)',  hex:'#06b6d4' },
    { id:4,  grad:'linear-gradient(135deg,#ec4899,#f472b6)',  hex:'#ec4899' },
    { id:5,  grad:'linear-gradient(135deg,#8b5cf6,#a78bfa)',  hex:'#8b5cf6' },
    { id:6,  grad:'linear-gradient(135deg,#ef4444,#f87171)',  hex:'#ef4444' },
    { id:7,  grad:'linear-gradient(135deg,#64748b,#94a3b8)',  hex:'#64748b' },
    { id:8,  grad:'linear-gradient(135deg,#059669,#34d399)',  hex:'#059669' },
    { id:9,  grad:'linear-gradient(135deg,#d97706,#fbbf24)',  hex:'#d97706' },
    { id:10, grad:'linear-gradient(135deg,#0891b2,#22d3ee)',  hex:'#0891b2' },
    { id:11, grad:'linear-gradient(135deg,#7c3aed,#ec4899)',  hex:'#7c3aed' },
    { id:12, grad:'linear-gradient(135deg,#1d4ed8,#38bdf8)',  hex:'#1d4ed8' },
    { id:13, grad:'linear-gradient(135deg,#be185d,#f9a8d4)',  hex:'#be185d' },
    { id:14, grad:'linear-gradient(135deg,#15803d,#4ade80)',  hex:'#15803d' },
    { id:15, grad:'linear-gradient(135deg,#b45309,#fde68a)',  hex:'#b45309' },
];

/* ════════════════════════════════════
   DATA LOADING
════════════════════════════════════ */
function loadData(page = 1) {
    currentPage = page;
    const search = $('#searchInput').val();
    const status = $('#filterStatus').val();

    // Loading states
    const grid  = $('#katGrid');
    const tbody = $('#tableBody');
    const emptyCard = $('#emptyCard');
    const emptyTable = $('#emptyTable');

    if (currentView === 'card') {
        grid.html('<div style="grid-column:1/-1; text-align:center; padding:60px;"><span class="spinner-border text-primary"></span><p style="margin-top:10px; color:var(--c-muted);">Memuat kategori...</p></div>');
    } else {
        tbody.html('<tr><td colspan="7" style="text-align:center; padding:40px;"><span class="spinner-border spinner-border-sm"></span> Memuat data...</td></tr>');
    }

    $.ajax({
        url: "/kategori/getallpagination",
        method: "GET",
        data: {
            page: page,
            search: search,
            status: status,
            per_page: 12
        },
        success: function(response) {
            if (response.success) {
                const result = response.data;
                const data = result.data;
                const meta = result.meta;
                const stats = result.stats;

                renderUI(data, meta);
                updateStats(stats);
            }
        },
        error: function() {
            const errHtml = '<div style="grid-column:1/-1; text-align:center; padding:60px; color:var(--c-red);"><i class="bi bi-exclamation-triangle" style="font-size:2rem;"></i><p>Gagal memuat data.</p></div>';
            if (currentView === 'card') grid.html(errHtml);
            else tbody.html('<tr><td colspan="7" style="text-align:center; color:var(--c-red);">Gagal memuat data.</td></tr>');
        }
    });
}

function renderUI(data, meta) {
    if (currentView === 'card') renderCards(data, meta);
    else renderTable(data, meta);
}

function renderCards(data, meta) {
    const grid = $('#katGrid');
    const empty = $('#emptyCard');
    
    if (data.length === 0) {
        grid.empty();
        empty.removeClass('d-none');
        renderPagination(meta, 'card');
        return;
    }
    empty.addClass('d-none');

    grid.html(data.map(d => `
        <div class="kat-card fade-up">
            <div class="kat-card-bar" style="background:${d.warna || 'var(--c-primary)'};"></div>
            <div class="kat-card-body">
                <div class="kat-icon-wrap" style="background:${d.warna || 'var(--c-primary)'};">
                    <i class="bi ${d.icon || 'bi-tags-fill'}"></i>
                </div>
                <div class="kat-name">${d.nama_kategori}</div>
                <div class="kat-desc">${d.deskripsi || '<span style="color:var(--c-border);font-style:italic;">Belum ada deskripsi</span>'}</div>
                <code class="kat-slug">${d.slug}</code>
                <div class="kat-stats">
                    <div class="kat-stat"><i class="bi bi-calendar3-fill" style="color:var(--c-primary);"></i> <span>0</span> kegiatan</div>
                    <div class="kat-stat"><i class="bi bi-images" style="color:var(--c-green);"></i> <span>0</span> foto</div>
                </div>
            </div>
            <div class="kat-card-footer">
                <span class="kat-status ${d.status === 'active' ? 'kat-status-active' : 'kat-status-inactive'}">
                    ${d.status === 'active' ? 'Aktif' : 'Nonaktif'}
                </span>
                <div class="kat-actions">
                    <button class="kat-action-btn kat-btn-edit" onclick="openEditModal('${d.id}')" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                    <button class="kat-action-btn kat-btn-toggle" onclick="toggleStatus('${d.id}', '${d.nama_kategori}')" title="Toggle Status">
                        <i class="bi ${d.status === 'active' ? 'bi-toggle-on' : 'bi-toggle-off'}"></i>
                    </button>
                    <button class="kat-action-btn kat-btn-delete" onclick="deleteKategori('${d.id}', '${d.nama_kategori}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                </div>
            </div>
        </div>`).join(''));
    
    renderPagination(meta, 'card');
}

function renderTable(data, meta) {
    const tbody = $('#tableBody');
    const empty = $('#emptyTable');

    if (data.length === 0) {
        tbody.empty();
        empty.removeClass('d-none');
        renderPagination(meta, 'table');
        return;
    }
    empty.addClass('d-none');

    tbody.html(data.map((d, i) => `
        <tr>
            <td style="font-family:'DM Mono',monospace;color:var(--c-muted);font-size:.78rem;">${(meta.current_page - 1) * meta.per_page + i + 1}</td>
            <td>
                <div class="tbl-kat-cell">
                    <div class="tbl-icon-sm" style="background:${d.warna || 'var(--c-primary)'};"><i class="bi ${d.icon || 'bi-tags-fill'}"></i></div>
                    <div>
                        <div class="tbl-kat-name">${d.nama_kategori}</div>
                        <div class="tbl-kat-slug" style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${d.deskripsi || '-'}</div>
                    </div>
                </div>
            </td>
            <td><code style="font-family:'DM Mono',monospace;font-size:.75rem;background:var(--c-surface2);padding:3px 8px;border-radius:5px;">${d.slug}</code></td>
            <td style="font-weight:700;text-align:center;">0</td>
            <td style="font-weight:700;text-align:center;">0</td>
            <td>
                <span class="kat-status ${d.status === 'active' ? 'kat-status-active' : 'kat-status-inactive'}">
                    ${d.status === 'active' ? 'Aktif' : 'Nonaktif'}
                </span>
            </td>
            <td>
                <div class="tbl-actions">
                    <button class="tbl-btn tbl-edit" onclick="openEditModal('${d.id}')" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                    <button class="tbl-btn tbl-toggle" onclick="toggleStatus('${d.id}', '${d.nama_kategori}')" title="Toggle Status"><i class="bi ${d.status === 'active' ? 'bi-toggle-on' : 'bi-toggle-off'}"></i></button>
                    <button class="tbl-btn tbl-delete" onclick="deleteKategori('${d.id}', '${d.nama_kategori}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                </div>
            </td>
        </tr>`).join(''));

    renderPagination(meta, 'table');
}

function renderPagination(meta, type) {
    const info = type === 'card' ? $('#cardPageInfo') : $('#pageInfo');
    const wrap = type === 'card' ? $('#cardPagination') : $('#pagination');
    
    if (meta.total === 0) {
        info.text('');
        wrap.empty();
        return;
    }

    const start = (meta.current_page - 1) * meta.per_page + 1;
    const end = Math.min(meta.current_page * meta.per_page, meta.total);
    info.text(`Menampilkan ${start}–${end} dari ${meta.total} kategori`);

    if (meta.last_page <= 1) {
        wrap.empty();
        return;
    }

    let html = `<button class="page-btn" onclick="loadData(${meta.current_page - 1})" ${meta.current_page === 1 ? 'disabled' : ''}><i class="bi bi-chevron-left"></i></button>`;
    
    for (let i = 1; i <= meta.last_page; i++) {
        if (i === 1 || i === meta.last_page || (i >= meta.current_page - 1 && i <= meta.current_page + 1)) {
            html += `<button class="page-btn ${i === meta.current_page ? 'active' : ''}" onclick="loadData(${i})">${i}</button>`;
        } else if (i === meta.current_page - 2 || i === meta.current_page + 2) {
            html += `<span style="padding:0 8px; color:var(--c-muted);">...</span>`;
        }
    }

    html += `<button class="page-btn" onclick="loadData(${meta.current_page + 1})" ${meta.current_page === meta.last_page ? 'disabled' : ''}><i class="bi bi-chevron-right"></i></button>`;
    wrap.html(html);
}

function updateStats(stats) {
    if (!stats) return;
    const anim = (id, val) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.textContent = val.toLocaleString('id-ID');
    };
    anim('sc1', stats.total);
    anim('sc2', stats.active);
    anim('sc3', stats.kegiatan || 0);
    anim('sc4', stats.foto || 0);
}

/* ════════════════════════════════════
   INITIALIZATION
════════════════════════════════════ */
$(document).ready(function() {
    loadData();

    const debouncedSearch = debounce(() => loadData(1), 500);
    $('#searchInput').on('input', debouncedSearch);
    $('#filterStatus').on('change', () => loadData(1));

    // Modal overlay click to close
    document.querySelectorAll('.modal-overlay').forEach(m => {
        m.addEventListener('click', e => {
            if(e.target === m) {
                m.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });
});

/* ════════════════════════════════════
   VIEW TOGGLE
════════════════════════════════════ */
function setView(v) {
    currentView = v;
    $('#btnCardView').toggleClass('active', v === 'card');
    $('#btnTableView').toggleClass('active', v === 'table');
    
    $('#cardViewWrap').toggle(v === 'card');
    $('#cardPagWrap').toggle(v === 'card');
    $('#tableViewWrap').toggle(v === 'table');
    
    loadData(1);
}

function resetFilters() {
    $('#searchInput').val('');
    $('#filterStatus').val('');
    loadData(1);
}

/* ════════════════════════════════════
   ICON & COLOR HELPERS
════════════════════════════════════ */
function buildIconGrid(filter='') {
    const grid = document.getElementById('iconGrid');
    if(!grid) return;
    const icons = filter ? ALL_ICONS.filter(i => i.includes(filter.toLowerCase())) : ALL_ICONS;
    grid.innerHTML = icons.map(ic => `
        <button type="button" class="icon-btn ${ic===selIcon?'selected':''}" onclick="selectIcon('${ic}')" title="${ic}">
            <i class="bi ${ic}"></i>
        </button>`).join('');
}
function filterIcons(q) { buildIconGrid(q); }
function selectIcon(ic) {
    selIcon = ic;
    buildIconGrid(document.getElementById('iconSearch')?.value || '');
    const preview = document.getElementById('previewIcon');
    const head = document.getElementById('modalHeadIconI');
    if(preview) preview.className = `bi ${ic}`;
    if(head) head.className = `bi ${ic}`;
}

function buildColorGrid() {
    const grid = document.getElementById('colorGrid');
    if(!grid) return;
    grid.innerHTML = COLORS.map(c => `
        <div class="color-swatch ${c.id===selColor?'selected':''}"
            style="background:${c.grad};"
            onclick="selectColor(${c.id})" title="${c.hex}"></div>`).join('');
}
function selectColor(id) {
    selColor = id;
    buildColorGrid();
    const grad = COLORS[id].grad;
    const preview = document.getElementById('previewBox');
    const head = document.getElementById('modalHeadIcon');
    if(preview) preview.style.background = grad;
    if(head) head.style.background = grad;
}

/* ════════════════════════════════════
   MODAL ACTIONS
════════════════════════════════════ */
function openAddModal() {
    editingId = null;
    selIcon  = 'bi-tags-fill';
    selColor = 0;
    
    $('#modalTitleText').text('Tambah Kategori');
    $('#modalHeadIconI').attr('class', 'bi bi-tags-fill');
    $('#modalHeadIcon').css('background', COLORS[0].grad);
    $('#btnSaveKat').html('<i class="bi bi-check2-circle"></i> Simpan Kategori');
    $('#previewIcon').attr('class', 'bi bi-tags-fill');
    $('#previewBox').css('background', COLORS[0].grad);
    $('#previewName').text('Nama Kategori');
    $('#previewSlug').text('nama-kategori');
    
    $('#f-nama').val('');
    $('#f-slug').val('');
    $('#f-desc').val('');
    
    $('.fgroup').removeClass('has-err');
    buildIconGrid(); 
    buildColorGrid();
    $('#modalKat').addClass('show');
    document.body.style.overflow='hidden';
}

function openEditModal(id) {
    editingId = id;
    const loader = DKA.loading({
        title: 'Memuat Data',
        message: 'Mengambil informasi kategori...',
        style: 'ring'
    });

    $.ajax({
        url: `/kategori/${id}`,
        method: 'GET',
        success: function(response) {
            loader.close();
            if (response.success) {
                const d = response.data;
                
                // Update Modal UI
                $('#modalTitleText').text('Edit Kategori');
                $('#btnSaveKat').html('<i class="bi bi-check2-circle"></i> Simpan Perubahan');
                
                // Fill Form
                $('#f-nama').val(d.nama_kategori);
                $('#f-slug').val(d.slug);
                $('#f-desc').val(d.deskripsi || '');
                $('#f-status').val(d.status);
                
                // Set Icon & Color state
                selIcon = d.icon || 'bi-tags-fill';
                
                // Find color ID by hex
                const foundColor = COLORS.find(c => c.hex === d.warna) || COLORS[0];
                selColor = foundColor.id;

                // Refresh UI components
                buildIconGrid();
                buildColorGrid();
                
                // Update Previews
                $('#modalHeadIcon').css('background', foundColor.grad);
                $('#modalHeadIconI').attr('class', `bi ${selIcon}`);
                $('#previewIcon').attr('class', `bi ${selIcon}`);
                $('#previewBox').css('background', foundColor.grad);
                $('#previewName').text(d.nama_kategori);
                $('#previewSlug').text(d.slug);

                $('.fgroup').removeClass('has-err');
                $('#modalKat').addClass('show');
                document.body.style.overflow='hidden';
            }
        },
        error: function() {
            loader.close();
            DKA.notify({
                type: 'danger',
                title: 'Gagal',
                message: 'Tidak dapat mengambil data kategori.',
                duration: 4000
            });
        }
    });
}

function closeModal(id) { 
    $(`#${id}`).removeClass('show'); 
    document.body.style.overflow=''; 
}

function clearErr(id) {
    $(`#${id}`).removeClass('has-err');
}

window.onNamaInput = function(val) {
    const slug = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').trim();
    $('#f-slug').val(slug);
    $('#previewName').text(val || 'Nama Kategori');
    $('#previewSlug').text(slug || 'nama-kategori');
};

window.updatePreview = function() {
    $('#previewSlug').text($('#f-slug').val() || 'nama-kategori');
};

function saveKategori() {
    const btn = $('#btnSaveKat');
    const isEdit = !!editingId;

    // Data collection
    const data = {
        nama_kategori: $('#f-nama').val(),
        slug: $('#f-slug').val(),
        deskripsi: $('#f-desc').val(),
        icon: selIcon,
        warna: COLORS[selColor].hex, // We store the HEX color
        status: $('#f-status').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    // Simple client-side validation
    let hasErr = false;
    $('.fgroup').removeClass('has-err');

    if (!data.nama_kategori) { $('#grp-nama').addClass('has-err'); hasErr = true; }
    if (!data.slug) { $('#grp-slug').addClass('has-err'); hasErr = true; }

    if (hasErr) return;

    // --- Loading Step (Consistency with Pengguna Module) ---
    const steps = [
        'Memvalidasi data...',
        'Mengirim ke server...',
        'Menyimpan ke database...',
        'Selesai!'
    ];

    const loader = DKA.loading({
        title: isEdit ? 'Memperbarui Kategori' : 'Menyimpan Kategori',
        message: 'Memulai proses...',
        style: 'ring',
    });

    steps.forEach((msg, i) => {
        setTimeout(() => loader.update(msg), (i + 1) * 600);
    });

    $.ajax({
        url: isEdit ? `/kategori/${editingId}` : '/kategori',
        method: isEdit ? 'PUT' : 'POST',
        data: data,
        success: function(response) {
            setTimeout(() => {
                loader.close();
                if (response.success) {
                    DKA.notify({
                        type: 'success',
                        title: isEdit ? 'Kategori Diperbarui!' : 'Kategori Disimpan!',
                        message: response.message,
                        duration: 6000,
                    });
                    closeModal('modalKat');
                    loadData(currentPage);
                }
            }, (steps.length) * 600);
        },
        error: function(err) {
            loader.close();
            if (err.status === 422) {
                const errors = err.responseJSON.errors;
                Object.keys(errors).forEach(key => {
                    // Map backend key to frontend group id
                    const groupId = key === 'nama_kategori' ? 'grp-nama' : `grp-${key}`;
                    const group = $(`#${groupId}`);
                    if (group.length) {
                        group.addClass('has-err');
                        group.find('.finvalid').text(errors[key][0]);
                    }
                });
                DKA.notify({
                    type: 'danger',
                    title: 'Validasi Gagal',
                    message: 'Periksa kembali isian formulir Anda.',
                    duration: 6000
                });
            } else {
                DKA.notify({
                    type: 'danger',
                    title: 'Error Server',
                    message: 'Koneksi terputus atau terjadi masalah server.',
                    duration: 6000
                });
            }
        }
    });
}

function deleteKategori(id, name) {
    DKA.deleteConfirm({
        title: 'Hapus Kategori?',
        message: 'Kategori ini akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.',
        itemName: name,
    }).then(result => {
        if (!result) return;

        const loader = DKA.loading({
            title: 'Menghapus...',
            message: 'Membersihkan data kategori.',
            style: 'dots'
        });

        $.ajax({
            url: `/kategori/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                setTimeout(() => {
                    loader.close();
                    if (response.success) {
                        DKA.toast({
                            type: 'success',
                            title: 'Dihapus',
                            message: response.message,
                            position: 'top-right'
                        });
                        loadData(currentPage);
                    }
                }, 800);
            },
            error: function() {
                loader.close();
                DKA.notify({
                    type: 'danger',
                    title: 'Gagal',
                    message: 'Koneksi terputus atau terjadi kesalahan server.',
                    duration: 5000
                });
            }
        });
    });
}

function toggleStatus(id, name) {
    DKA.dialog({
        type: 'question',
        title: 'Ubah Status Kategori?',
        message: `Apakah Anda yakin ingin mengubah status kategori <strong>${name}</strong>?`,
        confirm: 'Ya, Ubah Status',
        cancel: 'Batal'
    }).then(result => {
        if (!result) return;

        const loader = DKA.loading({
            title: 'Memproses...',
            message: 'Memperbarui status kategori.',
            style: 'dots'
        });

        $.ajax({
            url: `/kategori/${id}/toggle`,
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                setTimeout(() => {
                    loader.close();
                    if (response.success) {
                        DKA.toast({
                            type: 'success',
                            title: 'Berhasil',
                            message: response.message,
                            position: 'top-right'
                        });
                        loadData(currentPage);
                    }
                }, 800);
            },
            error: function() {
                loader.close();
                DKA.notify({
                    type: 'danger',
                    title: 'Gagal',
                    message: 'Koneksi terputus atau terjadi kesalahan server.',
                    duration: 5000
                });
            }
        });
    });
}
