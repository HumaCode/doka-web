/**
 * Reusable debounce function to limit the rate at which a function can fire.
 * @param {Function} func - The function to be debounced.
 * @param {number} wait - The delay in milliseconds.
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// --- GLOBAL VARIABLES & HELPERS --- //
let currentPage = 1;

// --- DATA LOADING & TABLE RENDERING --- //
function renderTable(page = 1) {
    currentPage = page;
    const search = $('#searchInput').val();
    const role = $('#filterRole').val();
    const status = $('#filterStatus')?.val() || '';

    const body = $('#tableBody');
    body.html(
        '<tr><td colspan="6" style="text-align:center; padding:40px;"><span class="spinner-border spinner-border-sm"></span> Memuat data...</td></tr>'
    );

    $.ajax({
        url: "/pengguna/getallpagination",
        method: "GET",
        data: {
            page: page,
            search: search,
            role: role,
            status: status,
            per_page: 10
        },
        success: function(response) {
            if (response.success) {
                const result = response.data;
                const users = result.data;
                const meta = result.meta;
                const stats = result.stats;

                if (users.length === 0) {
                    body.html(
                        '<tr><td colspan="6" style="text-align:center; padding:40px; color:var(--c-muted);">Tidak ada data pengguna ditemukan.</td></tr>'
                    );
                    updatePagination(meta);
                    updateStats(stats || meta);
                    return;
                }

                body.empty();
                users.forEach(u => {
                    const initial = u.name ? u.name[0].toUpperCase() : '?';
                    const colors = ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#06b6d4'];
                    const color = colors[u.id.length % colors.length] || '#4f46e5';

                    body.append(`
                    <tr>
                        <td class="col-check"><input type="checkbox" class="row-check" data-id="${u.id}" onchange="updateBulk()"></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:${color}; color:#fff; display:grid; place-items:center; font-weight:800;">${initial}</div>
                                <div>
                                    <div style="font-weight:700; color:var(--c-text);">${u.name}</div>
                                    <div style="font-size:0.75rem; color:var(--c-muted);">${u.email}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="instansi-wrapper">
                                <div class="instansi-name" title="${u.unit_kerja?.nama || ''}">${u.unit_kerja?.nama || '-'}</div>
                                ${u.unit_kerja?.sing ? `<div class="instansi-badge">${u.unit_kerja.sing}</div>` : ''}
                            </div>
                        </td>
                        <td><span class="role-badge role-${u.roles[0]?.name || 'user'}">${(u.roles[0]?.name || 'user').toUpperCase()}</span></td>
                        <td><span class="status-badge status-${u.is_active ? 'active' : 'inactive'}">${u.is_active ? 'Aktif' : 'Non-aktif'}</span></td>
                        <td style="text-align:center;">
                            <div class="action-btns">
                                <button class="btn-action btn-view" onclick="openDetailModal('${u.id}')"><i class="bi bi-eye"></i></button>
                                <button class="btn-action btn-edit" onclick="openEditModal('${u.id}')"><i class="bi bi-pencil-square"></i></button>
                                <button class="btn-action btn-delete" data-id="${u.id}" data-name="${u.name} — ${(u.roles[0]?.name || 'user').toUpperCase()}" onclick="deleteUser(this)"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `);
                });

                $('#tableMeta').text(`Menampilkan ${users.length} dari ${meta.total} pengguna`);
                updatePagination(meta);
                updateStats(stats || meta);
            }
        },
        error: function() {
            body.html(
                '<tr><td colspan="6" style="text-align:center; padding:40px; color:var(--c-red);">Gagal memuat data. Silakan coba lagi.</td></tr>'
            );
        }
    });
}

function updatePagination(meta) {
    let pagWrap = $('#paginationWrap');
    if (pagWrap.length === 0) {
        $('.table-card').append(
            '<div id="paginationWrap" style="padding:16px 20px; border-top:1px solid var(--c-border); display:flex; justify-content:center; gap:5px;"></div>'
        );
        pagWrap = $('#paginationWrap');
    }

    pagWrap.empty();
    if (meta.last_page <= 1) return;

    pagWrap.append(
        `<button class="btn-pag" ${meta.current_page === 1 ? 'disabled' : ''} onclick="renderTable(${meta.current_page - 1})"><i class="bi bi-chevron-left"></i></button>`
    );

    for (let i = 1; i <= meta.last_page; i++) {
        if (i === 1 || i === meta.last_page || (i >= meta.current_page - 1 && i <= meta.current_page + 1)) {
            pagWrap.append(
                `<button class="btn-pag ${i === meta.current_page ? 'active' : ''}" onclick="renderTable(${i})">${i}</button>`
            );
        } else if (i === meta.current_page - 2 || i === meta.current_page + 2) {
            pagWrap.append('<span style="padding:8px; color:var(--c-muted);">...</span>');
        }
    }

    pagWrap.append(
        `<button class="btn-pag" ${meta.current_page === meta.last_page ? 'disabled' : ''} onclick="renderTable(${meta.current_page + 1})"><i class="bi bi-chevron-right"></i></button>`
    );
}

function updateStats(stats) {
    if (!stats) return;
    $('#sc1').text(stats.total !== undefined ? stats.total : 0);

    if (stats.active !== undefined) $('#sc2').text(stats.active);
    if (stats.admin !== undefined) $('#sc3').text(stats.admin);
    if (stats.inactive !== undefined) $('#sc4').text(stats.inactive);
}

// --- INITIALIZATION --- //
$(document).ready(function() {
    renderTable();

    // Use debounced function for search input to reduce server load
    const debouncedSearch = debounce(() => renderTable(1), 500);
    $('#searchInput').on('input', debouncedSearch);

    $('#filterRole').on('change', () => renderTable(1));
    $('#filterStatus').on('change', () => renderTable(1));

    // Initialize Select2 for Instansi
    $('.select2').select2({
        placeholder: "Pilih Instansi",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#modalUser')
    });
});

// --- MODAL & FORM CONTROL --- //
let editUserId = null;

function openAddModal() {
    editUserId = null;
    $('#modalTitle').text('Tambah Pengguna');
    $('#modalSubTitle').text('Silakan lengkapi formulir untuk menambah akun baru.');
    $('#modalIcon').html('<i class="bi bi-person-plus-fill"></i>');
    $('#formUser')[0].reset();
    $('#f-unit_kerja_id').val(null).trigger('change');
    $('.form-ctrl-m').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#modalUser').addClass('show');
}

function openEditModal(id) {
    editUserId = id;
    $('.form-ctrl-m').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('#formUser')[0].reset();

    const loader = DKA.loading({
        title: 'Memuat Data',
        message: 'Mengambil informasi pengguna...',
        style: 'ring'
    });

    $.ajax({
        url: '/pengguna/' + id,
        method: 'GET',
        success: function(response) {
            loader.close();
            if (response.success) {
                const user = response.data;
                $('#f-name').val(user.name || '');
                $('#f-username').val(user.username || '');
                $('#f-email').val(user.email || '');
                $('#f-phone').val(user.phone || '');
                $('#f-gender').val(user.gender ? user.gender.toLowerCase() : '');
                $('#f-unit_kerja_id').val(user.unit_kerja?.id || '').trigger('change');

                if (user.roles && user.roles.length > 0) {
                    $('#f-role').val(user.roles[0].name);
                } else {
                    $('#f-role').val('');
                }

                $('#f-is_active').val(user.is_active ? "1" : "0");

                $('#modalTitle').text('Edit Pengguna');
                $('#modalSubTitle').text('Perbarui informasi akun pengguna ini.');
                $('#modalIcon').html('<i class="bi bi-pencil-square"></i>');
                $('#modalUser').addClass('show');
            }
        },
        error: function() {
            loader.close();
            DKA.notify({
                type: 'danger',
                title: 'Gagal',
                message: 'Tidak dapat mengambil data pengguna.',
                duration: 4000
            });
        }
    });
}

function closeModal(id) {
    $(`#${id}`).removeClass('show');
}

function resetFilters() {
    $('#searchInput').val('');
    $('#filterRole').val('');
    $('#filterStatus').val('');
    renderTable(1);
}

// --- DETAIL VIEW --- //
function openDetailModal(id) {
    const content = $('#detailUserContent');
    content.html(`
        <div style="text-align:center; padding:40px;">
            <div class="spinner-border text-primary"></div>
            <p style="margin-top:10px; color:var(--c-muted);">Mengambil data...</p>
        </div>
    `);
    $('#modalDetailUser').addClass('show');

    $.ajax({
        url: '/pengguna/' + id,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const u = response.data;
                const initial = u.name ? u.name[0].toUpperCase() : '?';
                const colors = ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#06b6d4'];
                const color = colors[u.id.length % colors.length] || '#4f46e5';
                
                const gender = u.gender === 'l' ? 'Laki-laki' : (u.gender === 'p' ? 'Perempuan' : '-');
                const status = u.is_active ? 
                    '<span class="status-badge status-active">Aktif</span>' : 
                    '<span class="status-badge status-inactive">Non-aktif</span>';
                
                const role = u.roles && u.roles.length > 0 ? 
                    `<span class="role-badge role-${u.roles[0].name}">${u.roles[0].name.toUpperCase()}</span>` : 
                    '<span class="role-badge role-user">USER</span>';

                content.html(`
                    <div class="detail-container">
                        <div class="detail-header">
                            <div class="detail-avatar" style="background:${color}">${initial}</div>
                            <div class="detail-header-info">
                                <div class="detail-name">${u.name}</div>
                                <div class="detail-email">${u.email}</div>
                                <div style="margin-top:8px; display:flex; gap:8px;">${role} ${status}</div>
                            </div>
                        </div>
                        
                        <div class="detail-grid">
                            <div class="detail-item" style="grid-column: span 2;">
                                <label class="detail-label">Instansi / Unit Kerja</label>
                                <div class="detail-value">
                                    <div style="font-weight:700; color:var(--c-text);">${u.unit_kerja?.nama || '-'}</div>
                                    <div style="font-size:0.7rem; color:var(--c-primary); font-weight:800;">${u.unit_kerja?.sing || ''}</div>
                                </div>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Username</label>
                                <div class="detail-value">${u.username || '-'}</div>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">No. Handphone</label>
                                <div class="detail-value">${u.phone || '-'}</div>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">Jenis Kelamin</label>
                                <div class="detail-value">${gender}</div>
                            </div>
                            <div class="detail-item">
                                <label class="detail-label">ID Pengguna</label>
                                <div class="detail-value" style="font-family:monospace; font-size:0.75rem;">${u.id}</div>
                            </div>
                        </div>
                    </div>
                `);

                $('#btnEditFromDetail').attr('onclick', `closeModal('modalDetailUser'); openEditModal('${u.id}')`);
            }
        },
        error: function() {
            content.html(`
                <div style="text-align:center; padding:40px; color:var(--c-red);">
                    <i class="bi bi-exclamation-triangle" style="font-size:2rem;"></i>
                    <p style="margin-top:10px;">Gagal memuat data pengguna.</p>
                </div>
            `);
        }
    });
}

// --- BULK ACTION CONTROL --- //
function toggleAll(el) {
    $('.row-check').prop('checked', el.checked);
    updateBulk();
}

function updateBulk() {
    const checked = $('.row-check:checked').length;
    $('#bulkCount').text(`${checked} dipilih`);
    $('#bulkBar').toggleClass('show', checked > 0);
}

// --- CRUD OPERATIONS (SAVE) --- //
function saveUser() {
    $('.form-ctrl-m').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    const formData = new FormData($('#formUser')[0]);

    const steps = [
        'Memvalidasi data...',
        'Mengirim ke server...',
        'Menyimpan ke database...',
        'Selesai!'
    ];

    const targetUrl = editUserId ? "/pengguna/update/" + editUserId : "/pengguna";
    const isEdit = !!editUserId;

    const loader = DKA.loading({
        title: isEdit ? 'Memperbarui Pengguna' : 'Menyimpan Pengguna',
        message: 'Memulai proses...',
        style: 'ring',
    });

    steps.forEach((msg, i) => {
        setTimeout(() => loader.update(msg), (i + 1) * 800);
    });

    $.ajax({
        url: targetUrl,
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            setTimeout(() => {
                loader.close();
                if (response.success) {
                    DKA.notify({
                        type: 'success',
                        title: 'Pengguna Disimpan!',
                        message: response.message ||
                            'Pengguna baru berhasil ditambahkan.',
                        duration: 6000,
                    });
                    closeModal('modalUser');
                    $('#formUser')[0].reset();
                    renderTable(currentPage);
                }
            }, (steps.length) * 800);
        },
        error: function(xhr) {
            loader.close();
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    const $input = $(`#f-${key}`);
                    $input.addClass('is-invalid');
                    $input.after(
                        `<div class="invalid-feedback" style="color:#ef4444; font-size:12px; margin-top:4px;">${messages[0]}</div>`
                    );
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
                    title: 'Koneksi Terputus / Error Server',
                    message: 'Koneksi ke server terputus atau terjadi kesalahan. Beberapa fitur mungkin tidak tersedia. Coba refresh halaman.',
                    duration: 6000
                });
            }
        }
    });
}

// --- CRUD OPERATIONS (DELETE) --- //
function deleteUser(btn) {
    const id = $(btn).data('id');
    const itemName = $(btn).data('name');

    DKA.deleteConfirm({
        title: 'Hapus Akun Pengguna?',
        message: 'Pengguna ini akan dihapus dari sistem beserta seluruh datanya.',
        itemName: itemName,
    }).then(result => {
        if (!result) return;

        const l = DKA.loading({
            title: 'Menghapus data...',
            message: 'Membersihkan data terkait.',
            style: 'dots'
        });

        $.ajax({
            url: "/pengguna/delete/" + id,
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                setTimeout(() => {
                    l.close();
                    if (response.success) {
                        DKA.toast({
                            type: 'success',
                            title: 'Pengguna Dihapus',
                            message: response.message,
                            position: 'top-right'
                        });
                        renderTable(currentPage);
                    } else {
                        DKA.notify({
                            type: 'danger',
                            title: 'Gagal Menghapus',
                            message: response.message,
                            duration: 5000
                        });
                    }
                }, 1000); // give it a sec to show the dots animation gracefully
            },
            error: function() {
                l.close();
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

function deleteBulk() {
    const checked = $('.row-check:checked');
    if (checked.length === 0) return;

    const ids = [];
    checked.each(function() {
        ids.push($(this).data('id'));
    });

    DKA.deleteConfirm({
        title: 'Hapus ' + ids.length + ' Pengguna?',
        message: 'Pengguna yang dipilih akan dihapus permanen beserta seluruh datanya.',
        itemName: ids.length + ' Akun Terpilih',
    }).then(result => {
        if (!result) return;

        const l = DKA.loading({
            title: 'Menghapus data...',
            message: 'Membersihkan data terpilih.',
            style: 'dots'
        });

        $.ajax({
            url: "/pengguna/bulk-delete",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                ids: ids
            },
            success: function(response) {
                setTimeout(() => {
                    l.close();
                    if (response.success) {
                        DKA.toast({
                            type: 'success',
                            title: 'Pengguna Dihapus',
                            message: response.message,
                            position: 'top-right'
                        });
                        
                        $('#bulkBar').removeClass('show');
                        $('.col-check input').prop('checked', false);
                        renderTable(currentPage);
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
                l.close();
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

