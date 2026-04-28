let currentPage = 1;

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
                const users = response.data;
                const meta = response.meta;
                const stats = response.stats;

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
                        <td><input type="checkbox" class="row-check" data-id="${u.id}" onchange="updateBulk()"></td>
                        <td>
                            <div style="display:flex; align-items:center; gap:10px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:${color}; color:#fff; display:grid; place-items:center; font-weight:800;">${initial}</div>
                                <div>
                                    <div style="font-weight:700; color:var(--c-text);">${u.name}</div>
                                    <div style="font-size:0.75rem; color:var(--c-muted);">${u.email}</div>
                                </div>
                            </div>
                        </td>
                        <td>${u.username || '-'}</td>
                        <td><span class="role-badge role-${u.roles[0]?.name || 'user'}">${(u.roles[0]?.name || 'user').toUpperCase()}</span></td>
                        <td><span class="status-badge status-${u.is_active ? 'active' : 'inactive'}">${u.is_active ? 'Aktif' : 'Non-aktif'}</span></td>
                        <td style="text-align:center;">
                            <div class="action-btns">
                                <button class="btn-action btn-view" onclick="openDrawer('${u.id}')"><i class="bi bi-eye"></i></button>
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

$(document).ready(function() {
    renderTable();
    let searchTimer;
    $('#searchInput').on('input', function() {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => renderTable(1), 500);
    });
    $('#filterRole').on('change', () => renderTable(1));
    $('#filterStatus').on('change', () => renderTable(1));
});

let editUserId = null;

function openAddModal() {
    editUserId = null;
    $('#modalTitle').text('Tambah Pengguna');
    $('#formUser')[0].reset();
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

                if (user.roles && user.roles.length > 0) {
                    $('#f-role').val(user.roles[0].name);
                } else {
                    $('#f-role').val('');
                }

                $('#f-is_active').val(user.is_active ? "1" : "0");

                $('#modalTitle').text('Edit Pengguna');
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

function openDrawer(id) {
    alert('Fitur detail untuk ID: ' + id);
}

function closeDrawer() {
    $('#drawerOverlay').removeClass('show');
}

function toggleAll(el) {
    $('.row-check').prop('checked', el.checked);
    updateBulk();
}

function updateBulk() {
    const checked = $('.row-check:checked').length;
    $('#bulkCount').text(`${checked} dipilih`);
    $('#bulkBar').toggleClass('show', checked > 0);
}

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
