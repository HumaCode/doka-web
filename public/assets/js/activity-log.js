let currentPage = 1;

function renderTable(page = 1) {
    currentPage = page;
    const search = $('#searchInput').val();
    const log_name = $('select[name="log_name"]').val();
    const event = $('select[name="event"]').val();

    const body = $('#tableBody');
    body.html('<tr><td colspan="5" class="text-center py-5"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted">Memuat data...</p></td></tr>');

    $.ajax({
        url: "/setting/activity-log/getallpagination",
        method: "GET",
        data: {
            page: page,
            search: search,
            log_name: log_name,
            event: event
        },
        success: function(res) {
            if (res.success) {
                const logs = res.data.data;
                const meta = res.data.meta;

                $('#tableCountBadge').text(`${meta.total} log`);
                $('#pageInfo').text(`Menampilkan ${meta.from || 0} - ${meta.to || 0} dari ${meta.total} log`);

                if (logs.length === 0) {
                    body.html('<tr><td colspan="5" class="text-center py-5"><i class="bi bi-inbox text-muted" style="font-size: 3rem; opacity: .2;"></i><p class="mt-3 text-muted">Belum ada riwayat aktivitas.</p></td></tr>');
                    updatePagination(meta);
                    return;
                }

                body.empty();
                logs.forEach(log => {
                    const causerInitial = log.causer ? log.causer[0] : 'S';
                    const causerRole = log.causer === 'System' ? 'Auto' : 'Administrator';

                    body.append(`
                        <tr>
                            <td>
                                <div class="causer-cell">
                                    <div class="causer-avatar">${causerInitial}</div>
                                    <div>
                                        <div class="causer-name">${log.causer}</div>
                                        <div class="causer-role">${causerRole}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="event-badge event-${log.event}">${log.event}</span>
                                <span class="ms-2 text-dark" style="font-weight: 500;">${log.description}</span>
                            </td>
                            <td><span class="log-name-badge">${log.log_name ? log.log_name.toUpperCase() : 'SYSTEM'}</span></td>
                            <td class="text-muted">
                                <div style="font-weight: 600;">${log.created_at.split(' ')[0]} ${log.created_at.split(' ')[1]} ${log.created_at.split(' ')[2]}</div>
                                <div style="font-size: .75rem;">${log.created_at.split(' ')[3]}</div>
                            </td>
                            <td class="text-center">
                                <div class="tbl-actions" style="justify-content: center;">
                                    <button class="tbl-btn tbl-view" onclick="viewLogDetail('${log.id}')" title="Lihat Detail Log">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <button class="tbl-btn tbl-delete" onclick="deleteLog('${log.id}')" title="Hapus Log">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                updatePagination(meta);
            }
        }
    });
}

function updatePagination(meta) {
    let pagWrap = $('#paginationWrap');
    pagWrap.empty();
    
    if (meta.last_page <= 1) return;

    let btnHtml = '<div class="d-flex gap-2">';
    
    // Prev
    btnHtml += `<button class="page-btn" ${meta.current_page === 1 ? 'disabled' : ''} onclick="renderTable(${meta.current_page - 1})"><i class="bi bi-chevron-left"></i></button>`;

    // Page Numbers with Ellipses
    const lastPage = meta.last_page;
    const current = meta.current_page;
    
    for (let i = 1; i <= lastPage; i++) {
        if (i === 1 || i === lastPage || (i >= current - 1 && i <= current + 1)) {
            btnHtml += `<button class="page-btn ${i === current ? 'active' : ''}" onclick="renderTable(${i})">${i}</button>`;
        } else if (i === current - 2 || i === current + 2) {
            btnHtml += `<span style="padding:8px; color:var(--c-muted);">...</span>`;
        }
    }

    // Next
    btnHtml += `<button class="page-btn" ${meta.current_page === lastPage ? 'disabled' : ''} onclick="renderTable(${meta.current_page + 1})"><i class="bi bi-chevron-right"></i></button>`;

    btnHtml += '</div>';
    pagWrap.append(btnHtml);
}

$(document).ready(function() {
    renderTable();
});
