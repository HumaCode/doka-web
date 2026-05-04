/**
 * System Setting Module JS
 */

$(document).ready(function() {
    // CSRF Setup for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize UI
    initTooltips();
});

/**
 * Switch between settings sections
 */
function switchSection(id) {
    // Update Nav
    $('.snav-btn').removeClass('active');
    $(`.snav-btn[onclick="switchSection('${id}')"]`).addClass('active');

    // Update Panels
    $('.settings-panel').removeClass('active');
    $(`#sec-${id}`).addClass('active');

    // Special init for storage
    if (id === 'storage') {
        loadBackups();
    }
    if (id === 'keamanan') {
        loadSecurityStats();
    }

    // Update URL hash without jumping
    history.replaceState(null, null, `#${id}`);
}

/**
 * Load Security Stats and Logs
 */
function loadSecurityStats() {
    $.ajax({
        url: '/setting/security/stats',
        method: 'GET',
        success: function(res) {
            if (res.success) {
                const data = res.data;
                $('#count-attacks').text(data.attack_count);
                $('#count-failed-login').text(data.failed_login_count);
                
                let logHtml = '';
                if (data.recent_attacks.length > 0) {
                    data.recent_attacks.forEach(log => {
                        logHtml += `
                            <tr>
                                <td><strong>${log.ip_address}</strong></td>
                                <td><span class="badg-attack">ATTACK DETECTED</span></td>
                                <td class="text-truncate" style="max-width: 150px;"><code>${log.path}</code></td>
                                <td class="text-muted">${log.time_ago}</td>
                                <td class="text-end"><span class="badge bg-danger">BLOCKED</span></td>
                            </tr>
                        `;
                    });
                } else {
                    logHtml = '<tr><td colspan="5" class="text-center py-4 text-muted">Belum ada aktivitas mencurigakan.</td></tr>';
                }
                $('#security-log-body').html(logHtml);
                
                loadActivityLogs();
            }
        }
    });
}

/**
 * Load User Activity Logs
 */
function loadActivityLogs() {
    $.ajax({
        url: '/setting/security/activities',
        method: 'GET',
        success: function(res) {
            if (res.success) {
                const logs = res.data;
                let activityHtml = '';
                if (logs.length > 0) {
                    logs.forEach(act => {
                        activityHtml += `
                            <div class="activity-item">
                                <div class="act-ico" style="background:${act.color}20; color:${act.color};">
                                    <i class="${act.icon}"></i>
                                </div>
                                <div class="act-content">
                                    <div class="act-title">${act.user_name}</div>
                                    <div class="act-desc">${act.description}</div>
                                    <div class="act-time">${act.time_ago}</div>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    activityHtml = '<div class="p-4 text-center text-muted">Belum ada aktivitas.</div>';
                }
                $('#activity-log-body').html(activityHtml);
            }
        }
    });
}

/**
 * Save settings via AJAX
 */
function saveSettings(sectionId) {
    const btn = $(event.target).closest('button');
    const originalText = btn.html();
    
    let data;
    if (sectionId === 'activity-log-toggle') {
        data = {
            activity_log_enabled: $('#toggle-activity-log').is(':checked') ? '1' : '0',
            section: 'keamanan',
            _token: $('input[name="_token"]').val()
        };
    } else {
        const form = $(`#form-${sectionId}`);
        data = form.serialize() + '&section=' + sectionId;
    }

    const loader = DKA.loading({ message: 'Menyimpan perubahan...' });
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
    
    $.ajax({
        url: '/setting/system',
        method: 'POST',
        data: data,
        success: function(res) {
            loader.close();
            DKA.notify({
                type: 'success',
                title: 'Berhasil!',
                message: res.message
            });
        },
        error: function(err) {
            loader.close();
            const msg = err.responseJSON ? err.responseJSON.message : 'Terjadi kesalahan sistem.';
            DKA.notify({
                type: 'error',
                title: 'Gagal!',
                message: msg
            });
        },
        complete: function() {
            btn.prop('disabled', false).html(originalText);
        }
    });
}

/**
 * Upload Logo/Favicon
 */
function uploadAsset(type, input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    const formData = new FormData();
    formData.append('file', file);
    formData.append('type', type);

    const loader = DKA.loading({ message: 'Mengunggah file...' });

    $.ajax({
        url: '/setting/system/logo',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            loader.close();
            if (res.success) {
                const data = res.data;
                $(`#preview-${type}`).attr('src', data.url);
                
                // Handle icons if no image was there before
                const previewBox = $(`#preview-${type}`).parent();
                previewBox.find('i.bi-image, i.bi-app-indicator').remove();
                $(`#preview-${type}`).show();

                DKA.notify({
                    type: 'success',
                    message: res.message
                });
            }
        },
        error: function(err) {
            loader.close();
            const msg = err.responseJSON ? err.responseJSON.message : 'Gagal mengunggah file.';
            DKA.notify({
                type: 'error',
                message: msg
            });
        }
    });
}

/**
 * Test Email Connection
 */
function testEmailConnection() {
    const form = $('#form-email');
    const data = form.serialize();
    const loader = DKA.loading({ message: 'Mencoba koneksi SMTP...' });
    
    $.ajax({
        url: '/setting/system/test-email',
        method: 'POST',
        data: data,
        success: function(res) {
            loader.close();
            DKA.notify({
                type: 'success',
                title: 'Berhasil!',
                message: 'Koneksi SMTP berhasil. Email percobaan telah dikirim.'
            });
        },
        error: function(err) {
            loader.close();
            const msg = err.responseJSON ? err.responseJSON.message : 'Koneksi SMTP gagal.';
            DKA.notify({
                type: 'error',
                title: 'Gagal!',
                message: msg
            });
        }
    });
}

/**
 * Backup Management
 */
function loadBackups() {
    const tbody = $('#backup-list-body');
    
    $.ajax({
        url: '/setting/backup',
        method: 'GET',
        success: function(backups) {
            tbody.empty();
            if (backups.length === 0) {
                tbody.append('<tr><td colspan="4" class="text-center py-4 text-muted">Belum ada file backup.</td></tr>');
                return;
            }
            
            backups.forEach(b => {
                tbody.append(`
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-file-earmark-zip text-primary me-2" style="font-size: 1.2rem;"></i>
                                <span class="fw-medium">${b.file_name}</span>
                            </div>
                        </td>
                        <td class="py-3 text-muted" style="font-size: .85rem;">${b.file_size}</td>
                        <td class="py-3 text-muted" style="font-size: .85rem;">${b.last_modified}</td>
                        <td class="py-3 text-end px-4">
                            <div class="btn-group">
                                <a href="/setting/backup/download/${b.id}" class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="bi bi-download"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteBackup('${b.id}')" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            });
        },
        error: function() {
            tbody.html('<tr><td colspan="4" class="text-center py-4 text-danger">Gagal memuat data backup.</td></tr>');
        }
    });
}

function createBackup() {
    const btn = $('#btn-create-backup');
    const originalContent = btn.html();
    
    const loader = DKA.loading({ message: 'Sedang membuat backup database... Mohon tunggu sebentar.' });
    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Memproses...');
    
    $.ajax({
        url: '/setting/backup',
        method: 'POST',
        success: function(res) {
            loader.close();
            DKA.notify({ type: 'success', message: res.message });
            loadBackups();
        },
        error: function(err) {
            loader.close();
            const msg = err.responseJSON ? err.responseJSON.message : 'Gagal membuat backup.';
            DKA.notify({ type: 'error', message: msg });
        },
        complete: function() {
            btn.prop('disabled', false).html(originalContent);
        }
    });
}

function deleteBackup(id) {
    DKA.deleteConfirm({
        title: 'Hapus Riwayat Backup?',
        message: 'Tindakan ini akan menghapus riwayat dan file backup secara permanen dari server.',
        itemName: 'File Backup ID: ' + id,
        confirm: 'Ya, Hapus Permanen',
        cancel: 'Batal'
    }).then(result => {
        if (result) {
            const loader = DKA.loading({ message: 'Menghapus riwayat backup...' });
            
            $.ajax({
                url: `/setting/backup/${id}`,
                method: 'DELETE',
                success: function(res) {
                    loader.close();
                    DKA.notify({ type: 'success', message: res.message });
                    loadBackups();
                },
                error: function(err) {
                    loader.close();
                    DKA.notify({ type: 'error', message: 'Gagal menghapus backup.' });
                }
            });
        }
    });
}

/**
 * Tooltips Init
 */
function initTooltips() {
    // If using Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
}
