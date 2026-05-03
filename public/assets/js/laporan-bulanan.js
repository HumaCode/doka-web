/* ── INIT SELECT2 ── */
$(document).ready(function() {
    $('.filter-select').select2({
        minimumResultsForSearch: 10,
        width: 'resolve'
    }).on('change', function() {
        generateReport();
    });
});

/* ════════════════════════════════════
   RAW DATA
   ════════════════════════════════════ */
const BULAN_STR = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

const GRADS = [
    'linear-gradient(135deg,#4f46e5,#7c3aed)',
    'linear-gradient(135deg,#10b981,#06b6d4)',
    'linear-gradient(135deg,#f59e0b,#f97316)',
    'linear-gradient(135deg,#ec4899,#f472b6)',
    'linear-gradient(135deg,#8b5cf6,#a78bfa)',
    'linear-gradient(135deg,#ef4444,#f87171)',
    'linear-gradient(135deg,#0891b2,#22d3ee)',
    'linear-gradient(135deg,#059669,#34d399)',
];

const KAT_CFG = {
    'Rapat': {
        bg: 'rgba(79,70,229,.1)',
        color: 'var(--c-primary)',
        bar: 'linear-gradient(90deg,#4f46e5,#06b6d4)'
    },
    'Pelatihan': {
        bg: 'rgba(16,185,129,.1)',
        color: 'var(--c-green)',
        bar: 'linear-gradient(90deg,#10b981,#34d399)'
    },
    'Kunjungan': {
        bg: 'rgba(245,158,11,.1)',
        color: 'var(--c-accent)',
        bar: 'linear-gradient(90deg,#f59e0b,#f97316)'
    },
    'Sosialisasi': {
        bg: 'rgba(6,182,212,.1)',
        color: 'var(--c-secondary)',
        bar: 'linear-gradient(90deg,#06b6d4,#3b82f6)'
    },
    'Upacara': {
        bg: 'rgba(236,72,153,.1)',
        color: 'var(--c-pink)',
        bar: 'linear-gradient(90deg,#ec4899,#f472b6)'
    },
};

const STATUS_CFG = {
    selesai: {
        cls: 'sp-selesai',
        label: 'Selesai'
    },
    berjalan: {
        cls: 'sp-berjalan',
        label: 'Berjalan'
    },
    draft: {
        cls: 'sp-draft',
        label: 'Draft'
    },
};

const UNIT_CFG = {
    'Diskominfo': { gradId: 0, short: 'Diskominfo' },
    'Disdik': { gradId: 1, short: 'Disdik' },
    'Dinkes': { gradId: 2, short: 'Dinkes' },
    'Dinsos': { gradId: 3, short: 'Dinsos' },
    'Humas': { gradId: 4, short: 'Humas' },
    'Setda': { gradId: 5, short: 'Setda' },
    'DPUPR': { gradId: 6, short: 'DPUPR' },
    'Inspektorat': { gradId: 7, short: 'Inspektorat' },
};

/* ════════════════════════════════════
   STATE
   ════════════════════════════════════ */
let currentData = [];
let sortAsc = false;
let currentPage = 1;
const itemsPerPage = 10;

/* ════════════════════════════════════
   INIT & AJAX
   ════════════════════════════════════ */
function fmtDate(s) {
    if (!s) return '—';
    const [y, m, d] = s.split('-');
    return `${+d} ${BULAN_STR[+m]} ${y}`;
}

async function generateReport() {
    const bulan = +document.getElementById('fBulan').value;
    const tahun = +document.getElementById('fTahun').value;
    const unitId = document.getElementById('fUnit').value;
    const katId = document.getElementById('fKategori').value;

    // Show loading if DKA is available
    let loader;
    if (typeof DKA !== 'undefined') {
        loader = DKA.loading({ title: 'Memperbarui data...', style: 'dots' });
    }

    try {
        const url = new URL(window.location.href);
        url.searchParams.set('bulan', bulan);
        url.searchParams.set('tahun', tahun);
        if (unitId) url.searchParams.set('unit_id', unitId); else url.searchParams.delete('unit_id');
        if (katId) url.searchParams.set('kategori_id', katId); else url.searchParams.delete('kategori_id');

        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await response.json();

        // Update state
        if (typeof MASTER_DATA !== 'undefined') {
            MASTER_DATA[bulan] = data.kegiatan;
        }
        currentData = data.kegiatan;
        currentPage = 1;

        // Update UI
        updateHero(bulan, tahun, document.getElementById('fUnit').options[document.getElementById('fUnit').selectedIndex].text);
        updateStats(data.stats);
        renderTable();
        renderUnitBars();
        renderKatBars();
        renderWeek(bulan, tahun);
        renderSummary(bulan, tahun);

        // Update URL without reload
        window.history.pushState({}, '', url);

    } catch (err) {
        console.error(err);
    } finally {
        if (loader) loader.close();
    }
}

/* ════════════════════════════════════
   HERO
   ════════════════════════════════════ */
function updateHero(bulan, tahun, unitText) {
    const unitDisplay = unitText === 'Semua Unit Kerja' ? 'Semua Unit Kerja' : unitText;
    document.getElementById('heroTitle').textContent =
        `Laporan Kegiatan Bulan ${BULAN_STR[bulan]} ${tahun}`;
    document.getElementById('heroGenTime').parentNode.parentNode.querySelector('span:first-child').innerHTML = 
        `<i class="bi bi-building-fill"></i> ${unitDisplay}`;
    document.getElementById('heroGenTime').textContent = new Date().toLocaleString('id-ID', {
        dateStyle: 'long',
        timeStyle: 'short'
    });
}

/* ════════════════════════════════════
   STATS
   ════════════════════════════════════ */

function animC(id, target) {
    const el = document.getElementById(id);
    if (!el) return;
    let c = 0;
    const inc = target / 50;
    const t = setInterval(() => {
        c += inc;
        if (c >= target) {
            c = target;
            clearInterval(t);
        }
        el.textContent = Math.floor(c).toLocaleString('id-ID');
    }, 16);
}

function updateStats(stats) {
    if (!stats) return;

    const totalK = stats.total_kegiatan || 0;
    const totalF = stats.total_foto || 0;
    const selesai = stats.total_selesai || 0;
    const units = stats.unit_aktif || 0;
    
    // Previous stats (for trend - optional, can be passed from server too)
    const prev = { k: 0, f: 0, s: 0, u: 0 };

    animC('scKegiatan', totalK);
    animC('scFoto', totalF);
    animC('scSelesai', selesai);
    animC('scUnit', units);

    const pctK = prev.k ? Math.round(((totalK - prev.k) / prev.k) * 100) : 0;
    const pctF = prev.f ? Math.round(((totalF - prev.f) / prev.f) * 100) : 0;
    const pctS = totalK ? Math.round((selesai / totalK) * 100) : 0;

    setTrend('scKegiatanTrend', pctK, `${pctK > 0 ? '+' : ''}${pctK}% vs bulan lalu`);
    setTrend('scFotoTrend', pctF, `${pctF > 0 ? '+' : ''}${pctF}% vs bulan lalu`);
    
    const scSelesaiTrend = document.getElementById('scSelesaiTrend');
    if (scSelesaiTrend) {
        scSelesaiTrend.innerHTML = `<i class="bi bi-bar-chart-fill"></i> ${pctS}% tingkat selesai`;
        scSelesaiTrend.className = `sc-trend ${pctS >= 75 ? 'up' : pctS >= 50 ? 'flat' : 'down'}`;
    }

    const scUnitTrend = document.getElementById('scUnitTrend');
    if (scUnitTrend) {
        const petugas = units * 2; // Estimation
        scUnitTrend.innerHTML = `<i class="bi bi-people-fill"></i> ${petugas} petugas terlibat`;
        scUnitTrend.className = 'sc-trend flat';
    }
}

function setTrend(id, pct, label) {
    const el = document.getElementById(id);
    if (!el) return;
    const cls = pct > 0 ? 'up' : pct < 0 ? 'down' : 'flat';
    const ic = pct > 0 ? 'bi-arrow-up-short' : pct < 0 ? 'bi-arrow-down-short' : 'bi-dash';
    el.className = `sc-trend ${cls}`;
    el.innerHTML = `<i class="bi ${ic}"></i> ${label}`;
}

/* ════════════════════════════════════
   TABLE
   ════════════════════════════════════ */
function renderTable() {
    const tbody = document.getElementById('kegiatanBody');
    const empty = document.getElementById('emptyTable');
    const cnt = document.getElementById('tableCount');
    const pag = document.getElementById('tablePagination');

    cnt.textContent = currentData.length ? `(${currentData.length} kegiatan)` : '';

    if (!currentData.length) {
        tbody.innerHTML = '';
        empty.classList.remove('d-none');
        pag.innerHTML = '';
        return;
    }
    empty.classList.add('d-none');

    // Pagination Logic
    const totalItems = currentData.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    if (currentPage > totalPages) currentPage = totalPages || 1;

    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const pagedData = currentData.slice(start, end);

    /* Static rows */
    tbody.innerHTML = pagedData.map((d, i) => {
        const sc = STATUS_CFG[d.status];
        const kc = getKatCfg(d.kat);
        const uc = getUnitCfg(d.unit);
        return `
<tr>
<td class="kt-no">${String(start + i + 1).padStart(2,'0')}</td>
<td>
  <div class="kt-name">${d.nama}</div>
  <div class="kt-name-sub">
    <span><i class="bi bi-calendar3"></i> ${fmtDate(d.tgl)}</span>
  </div>
</td>
<td><span style="font-size:.82rem;font-weight:600;color:var(--c-text);white-space:nowrap;">${fmtDate(d.tgl)}</span></td>
<td><span class="kat-pill" style="background:${kc.bg};color:${kc.color};">${d.kat}</span></td>
<td>
  <div style="display:flex;align-items:center;gap:7px;">
    <div style="width:22px;height:22px;border-radius:6px;background:${GRADS[uc.gradId]};display:grid;place-items:center;color:#fff;font-size:.6rem;flex-shrink:0;">
      <i class="bi bi-building-fill"></i>
    </div>
    <span class="kt-unit">${d.unit}</span>
  </div>
</td>
<td><span class="status-pill ${sc.cls}">${sc.label}</span></td>
<td class="foto-count">${d.foto > 0 ? `<span style="background:rgba(79,70,229,.08);padding:3px 9px;border-radius:99px;"><i class="bi bi-images" style="color:var(--c-primary);font-size:.75rem;"></i> ${d.foto}</span>` : '<span style="color:var(--c-muted);">—</span>'}</td>
<td>
  <div class="tbl-actions-sm">
    <button class="tbl-btn-sm tb-view" onclick="viewKegiatan('${d.id}')" title="Detail"><i class="bi bi-eye-fill"></i></button>
    <button class="tbl-btn-sm tb-del"  onclick="delKegiatan('${d.id}', '${d.nama.replace(/'/g,"\\'")}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
  </div>
</td>
</tr>`;
    }).join('');

    renderPagination(totalPages);
}

function renderPagination(totalPages) {
    const pag = document.getElementById('tablePagination');
    if (totalPages <= 1) {
        pag.innerHTML = `<span style="font-size:.75rem;color:var(--c-muted);">Menampilkan semua ${currentData.length} kegiatan</span>`;
        return;
    }

    const startIdx = (currentPage - 1) * itemsPerPage + 1;
    const endIdx = Math.min(currentPage * itemsPerPage, currentData.length);

    let html = `
        <span style="font-size:.75rem;color:var(--c-muted);">Menampilkan <b>${startIdx}-${endIdx}</b> dari <b>${currentData.length}</b></span>
        <div style="display:flex;gap:5px;">
            <button class="btn-tb btn-outline" style="padding:4px 8px;" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})"><i class="bi bi-chevron-left"></i></button>
    `;

    for (let i = 1; i <= totalPages; i++) {
        if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            html += `<button class="btn-tb ${i === currentPage ? 'btn-primary' : 'btn-outline'}" style="padding:4px 10px;min-width:32px;" onclick="changePage(${i})">${i}</button>`;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            html += `<span style="padding:0 5px;color:var(--c-muted);">...</span>`;
        }
    }

    html += `
            <button class="btn-tb btn-outline" style="padding:4px 8px;" ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})"><i class="bi bi-chevron-right"></i></button>
        </div>
    `;
    pag.innerHTML = html;
}

function changePage(p) {
    currentPage = p;
    renderTable();
    document.getElementById('kegiatanTable').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function resetFilters() {
    const now = new Date();
    const curMonth = now.getMonth() + 1;
    const curYear = now.getFullYear();

    $('#fBulan').val(curMonth).trigger('change.select2');
    $('#fTahun').val(curYear).trigger('change.select2');
    
    // Check global flag set in blade
    if (typeof IS_ADMIN === 'undefined' || !IS_ADMIN) {
        $('#fUnit').val('').trigger('change.select2');
    }
    
    $('#fKategori').val('').trigger('change.select2');
}

function printReport() {
    // Temporarily show all data for printing
    const originalPage = currentPage;
    const originalItemsPerPage = itemsPerPage;
    
    // Set huge items per page to show all
    const tbody = document.getElementById('kegiatanBody');
    
    tbody.innerHTML = currentData.map((d, i) => {
        const sc = STATUS_CFG[d.status];
        const kc = getKatCfg(d.kat);
        const uc = getUnitCfg(d.unit);
        return `
<tr>
<td class="kt-no">${String(i + 1).padStart(2,'0')}</td>
<td>
  <div class="kt-name">${d.nama}</div>
  <div class="kt-name-sub">
    <span><i class="bi bi-calendar3"></i> ${fmtDate(d.tgl)}</span>
  </div>
</td>
<td><span style="font-size:.82rem;font-weight:600;color:var(--c-text);white-space:nowrap;">${fmtDate(d.tgl)}</span></td>
<td><span class="kat-pill" style="background:${kc.bg};color:${kc.color};">${d.kat}</span></td>
<td>
  <div style="display:flex;align-items:center;gap:7px;">
    <div style="width:22px;height:22px;border-radius:6px;background:${GRADS[uc.gradId]};display:grid;place-items:center;color:#fff;font-size:.6rem;flex-shrink:0;">
      <i class="bi bi-building-fill"></i>
    </div>
    <span class="kt-unit">${d.unit}</span>
  </div>
</td>
<td><span class="status-pill ${sc.cls}">${sc.label}</span></td>
<td class="foto-count">${d.foto > 0 ? `<span style="background:rgba(79,70,229,.08);padding:3px 9px;border-radius:99px;"><i class="bi bi-images" style="color:var(--c-primary);font-size:.75rem;"></i> ${d.foto}</span>` : '<span style="color:var(--c-muted);">—</span>'}</td>
<td></td>
</tr>`;
    }).join('');

    // Hide pagination
    document.getElementById('tablePagination').style.display = 'none';

    // Print
    setTimeout(() => {
        window.print();
        // Restore original state
        document.getElementById('tablePagination').style.display = 'flex';
        renderTable();
    }, 500);
}

function sortTable() {
    sortAsc = !sortAsc;
    currentPage = 1;
    currentData.sort((a, b) => sortAsc ?
        a.tgl.localeCompare(b.tgl) :
        b.tgl.localeCompare(a.tgl)
    );
    renderTable();
    if (typeof DKA !== 'undefined') {
        DKA.toast({
            type: 'info',
            title: `Diurutkan ${sortAsc?'Terlama':'Terbaru'}`,
            message: 'Tabel berhasil diurutkan.',
            position: 'bottom-right',
            duration: 2000
        });
    }
}

/* ════════════════════════════════════
   HELPERS & COLORS
   ════════════════════════════════════ */
function getHash(str) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    return Math.abs(hash);
}

function getUnitCfg(unit) {
    // Find in static config
    for (const key in UNIT_CFG) {
        if (unit.toLowerCase().includes(key.toLowerCase())) return UNIT_CFG[key];
    }
    // Dynamic based on hash
    const h = getHash(unit);
    return { gradId: h % GRADS.length, short: unit };
}

function getKatCfg(kat) {
    // Find in static config
    for (const key in KAT_CFG) {
        if (kat.toLowerCase().includes(key.toLowerCase())) return KAT_CFG[key];
    }
    // Dynamic based on hash
    const h = getHash(kat);
    const colors = ['#4f46e5', '#10b981', '#f59e0b', '#06b6d4', '#ec4899', '#ef4444', '#8b5cf6', '#0891b2'];
    const c = colors[h % colors.length];
    return {
        bg: `${c}1a`, // 10% opacity
        color: c,
        bar: `linear-gradient(90deg, ${c}, ${c}dd)`
    };
}

/* ════════════════════════════════════
   UNIT PROGRESS BARS
   ════════════════════════════════════ */
function renderUnitBars() {
    const unitMap = {};
    currentData.forEach(d => {
        if (!unitMap[d.unit]) unitMap[d.unit] = { k: 0, f: 0 };
        unitMap[d.unit].k++;
        unitMap[d.unit].f += d.foto;
    });
    const sorted = Object.entries(unitMap).sort((a, b) => b[1].k - a[1].k);
    const maxK = sorted.length ? sorted[0][1].k : 1;

    document.getElementById('unitProgBars').innerHTML = sorted.map(([unit, val]) => {
        const uc = getUnitCfg(unit);
        const pct = Math.round((val.k / maxK) * 100);
        return `
<div class="prog-row">
<div class="prog-top">
  <div class="prog-name">
    <div class="prog-logo-sm" style="background:${GRADS[uc.gradId]};"><i class="bi bi-building-fill"></i></div>
    ${unit}
  </div>
  <div class="prog-val">${val.k} kegiatan · ${val.f} foto</div>
</div>
<div class="prog-bar-bg">
  <div class="prog-fill" style="width:${pct}%;background:${GRADS[uc.gradId]};"></div>
</div>
</div>`;
    }).join('') || `<div style="text-align:center;color:var(--c-muted);padding:24px;font-size:.85rem;">Tidak ada data</div>`;
}

/* ════════════════════════════════════
   KATEGORI BARS
   ════════════════════════════════════ */
function renderKatBars() {
    const katMap = {};
    currentData.forEach(d => {
        katMap[d.kat] = (katMap[d.kat] || 0) + 1;
    });
    const sorted = Object.entries(katMap).sort((a, b) => b[1] - a[1]);
    const total = currentData.length || 1;

    document.getElementById('katBars').innerHTML = sorted.map(([kat, count]) => {
        const kc = getKatCfg(kat);
        const pct = Math.round((count / total) * 100);
        return `
<div style="padding:10px 0;border-bottom:1px solid var(--c-border);">
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
  <span style="display:flex;align-items:center;gap:6px;">
    <span class="kat-pill" style="background:${kc.bg};color:${kc.color};">${kat}</span>
  </span>
  <span style="font-family:'DM Mono',monospace;font-size:.75rem;font-weight:700;color:var(--c-text-2);">${count} (${pct}%)</span>
</div>
<div class="prog-bar-bg">
  <div class="prog-fill" style="width:${pct}%;background:${kc.bar};"></div>
</div>
</div>`;
    }).join('') || `<div style="text-align:center;color:var(--c-muted);padding:24px;font-size:.85rem;">Tidak ada data</div>`;
}

/* ════════════════════════════════════
   WEEK DISTRIBUTION
   ════════════════════════════════════ */
function renderWeek(bulan, tahun) {
    const weeks = [0, 0, 0, 0, 0];
    currentData.forEach(d => {
        const day = +d.tgl.split('-')[2];
        const w = Math.min(Math.floor((day - 1) / 7), 4);
        weeks[w]++;
    });

    document.getElementById('weekGrid').innerHTML = weeks.map((count, i) => `
<div class="week-item">
<div class="week-label">Minggu ${i+1}</div>
<div class="week-count">${count}</div>
<div class="week-sub">kegiatan</div>
</div>`).join('');

    // Mini bar chart
    const days = Array.from({
        length: 20
    }, (_, i) => {
        const val = currentData.filter(d => +d.tgl.split('-')[2] === i + 1).length;
        return {
            day: i + 1,
            val
        };
    });
    const maxVal = Math.max(...days.map(d => d.val), 1);
    document.getElementById('miniBarChart').innerHTML = days.map(d => {
        const pct = Math.round((d.val / maxVal) * 75);
        return `
<div class="mbc-bar-wrap">
<div class="mbc-val">${d.val > 0 ? d.val : ''}</div>
<div class="mbc-bar" style="height:${Math.max(pct,4)}px;background:${d.val > 0 ? 'linear-gradient(180deg,var(--c-primary),var(--c-secondary))' : 'var(--c-border)'};"></div>
<div class="mbc-lbl">${d.day}</div>
</div>`;
    }).join('');
}

/* ════════════════════════════════════
   SUMMARY PANEL
   ════════════════════════════════════ */
function renderSummary(bulan, tahun) {
    const days = new Date(tahun, bulan, 0).getDate();
    const hariAktif = [...new Set(currentData.map(d => d.tgl))].length;
    const totalK = currentData.length;
    const totalF = currentData.reduce((s, d) => s + d.foto, 0);

    const unitCounts = {};
    currentData.forEach(d => {
        unitCounts[d.unit] = (unitCounts[d.unit] || 0) + 1;
    });
    const topUnit = Object.entries(unitCounts).sort((a, b) => b[1] - a[1])[0];

    document.getElementById('rPeriode').textContent = `${BULAN_STR[bulan]} ${tahun} (${days} hari)`;
    document.getElementById('rHariAktif').textContent = `${hariAktif} dari ${days} hari`;
    document.getElementById('rRataHari').textContent = hariAktif ? (totalK / hariAktif).toFixed(1) + ' kegiatan/hari' : '—';
    document.getElementById('rTopUnit').textContent = topUnit ? `${topUnit[0]} (${topUnit[1]} kegiatan)` : '—';
    document.getElementById('rRataFoto').textContent = totalK ? (totalF / totalK).toFixed(1) + ' foto/kegiatan' : '—';
    document.getElementById('rUpdate').textContent = new Date().toLocaleString('id-ID', {
        dateStyle: 'medium',
        timeStyle: 'short'
    });
}

/* ════════════════════════════════════
   ROW ACTIONS
   ════════════════════════════════════ */
function viewKegiatan(id) {
    // window.location.href = '#';
}

function delKegiatan(id, nama) {
    if (typeof DKA !== 'undefined') {
        DKA.deleteConfirm({
            title: 'Hapus dari Laporan?',
            message: 'Kegiatan ini akan dihapus dari sistem (simulasi). Data foto terkait tidak akan ikut terhapus.',
            itemName: nama.slice(0, 50) + (nama.length > 50 ? '...' : ''),
            confirm: 'Ya, Hapus Kegiatan',
        }).then(r => {
            if (!r) return;
            const l = DKA.loading({
                title: 'Menghapus kegiatan...',
                message: 'Mohon tunggu.',
                style: 'dots'
            });
            setTimeout(() => {
                // Remove from data
                const bulan = +document.getElementById('fBulan').value;
                if (typeof MASTER_DATA !== 'undefined' && MASTER_DATA[bulan]) {
                    const idx = MASTER_DATA[bulan].findIndex(d => d.id === id);
                    if (idx > -1) MASTER_DATA[bulan].splice(idx, 1);
                }
                l.close();
                generateReport();
                DKA.toast({
                    type: 'success',
                    title: 'Kegiatan Dihapus',
                    message: 'Data berhasil dihapus dari laporan.',
                    position: 'top-right'
                });
            }, 1200);
        });
    }
}

/* ════════════════════════════════════
   EXPORT
   ════════════════════════════════════ */
function exportPDF() {
    if (!currentData || currentData.length === 0) {
        if (typeof DKA !== 'undefined') {
            DKA.toast({ type: 'warning', title: 'Data Kosong', message: 'Tidak ada data untuk di-export.' });
        }
        return;
    }

    const bulanText = document.getElementById('fBulan').options[document.getElementById('fBulan').selectedIndex].text;
    const tahun = document.getElementById('fTahun').value;
    const fileName = `Laporan_Bulanan_${bulanText}_${tahun}.pdf`;

    let loader;
    if (typeof DKA !== 'undefined') {
        loader = DKA.loading({ title: 'Menyiapkan PDF...', message: 'Mereset tampilan untuk cetak.', style: 'wave' });
    }

    // 1. Prepare for export
    document.body.classList.add('exporting-pdf');
    const paginationEl = document.getElementById('tablePagination');
    paginationEl.style.display = 'none';

    document.getElementById('kegiatanBody').innerHTML = currentData.map((d, i) => {
        const sc = STATUS_CFG[d.status];
        const kc = getKatCfg(d.kat);
        const uc = getUnitCfg(d.unit);
        return `
<tr>
<td class="kt-no">${String(i + 1).padStart(2,'0')}</td>
<td style="width:40%;">
  <div class="kt-name">${d.nama}</div>
  <div class="kt-name-sub"><span><i class="bi bi-calendar3"></i> ${fmtDate(d.tgl)}</span></div>
</td>
<td style="white-space:nowrap;">${fmtDate(d.tgl)}</td>
<td><span class="kat-pill" style="background:${kc.bg};color:${kc.color};">${d.kat}</span></td>
<td><span class="kt-unit">${d.unit}</span></td>
<td><span class="status-pill ${sc.cls}">${sc.label}</span></td>
<td class="foto-count">${d.foto > 0 ? `<span style="display:inline-flex;align-items:center;gap:5px;background:rgba(79,70,229,.08);padding:3px 10px;border-radius:99px;white-space:nowrap;"><i class="bi bi-images" style="color:var(--c-primary);font-size:.75rem;"></i> ${d.foto}</span>` : '<span style="color:var(--c-muted);">—</span>'}</td>
<td></td>
</tr>`;
    }).join('');

    // 2. Export options
    const element = document.getElementById('reportContentArea');
    const opt = {
        margin:       [0.3, 0.3],
        filename:     fileName,
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2, useCORS: true, logging: false },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
    };

    // 3. Generate PDF
    setTimeout(() => {
        html2pdf().set(opt).from(element).save().then(() => {
            // Restore state
            document.body.classList.remove('exporting-pdf');
            paginationEl.style.display = 'flex';
            renderTable();
            if (loader) {
                loader.close();
                DKA.toast({ type: 'success', title: 'PDF Berhasil', message: 'Laporan PDF telah diunduh.' });
            }
        }).catch(err => {
            console.error(err);
            document.body.classList.remove('exporting-pdf');
            if (loader) loader.close();
        });
    }, 500);
}

function exportExcel() {
    if (!currentData || currentData.length === 0) {
        if (typeof DKA !== 'undefined') {
            DKA.toast({ type: 'warning', title: 'Data Kosong', message: 'Tidak ada data untuk di-export.' });
        } else {
            alert('Tidak ada data untuk di-export.');
        }
        return;
    }

    const bulanText = document.getElementById('fBulan').options[document.getElementById('fBulan').selectedIndex].text;
    const tahun = document.getElementById('fTahun').value;
    
    // Show loading if DKA available
    let loader;
    if (typeof DKA !== 'undefined') {
        loader = DKA.loading({ title: 'Mengekspor...', message: 'Menyiapkan file Excel.', style: 'dots' });
    }

    setTimeout(() => {
        // Prepare data for XLSX
        const data = currentData.map((d, i) => ({
            'No': i + 1,
            'Nama Kegiatan': d.nama,
            'Tanggal': d.tgl,
            'Kategori': d.kat,
            'Unit Kerja': d.unit,
            'Status': d.status,
            'Jumlah Foto': d.foto
        }));

        const ws = XLSX.utils.json_to_sheet(data);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Laporan Bulanan");
        
        // Auto-size columns
        const colWidths = [
            { wch: 5 },
            { wch: 50 },
            { wch: 15 },
            { wch: 20 },
            { wch: 35 },
            { wch: 15 },
            { wch: 12 }
        ];
        ws['!cols'] = colWidths;

        XLSX.writeFile(wb, `Laporan_Bulanan_${bulanText}_${tahun}.xlsx`);

        if (loader) {
            loader.close();
            DKA.toast({ type: 'success', title: 'Export Berhasil', message: 'File Excel telah diunduh.' });
        }
    }, 500);
}

/* ── INIT ── */
document.addEventListener('DOMContentLoaded', () => {
    // Auto-collapse sidebar on this page for wider view
    if (window.innerWidth > 768) {
        document.body.classList.add('collapsed');
    }

    const bulan = +document.getElementById('fBulan').value;
    if (typeof MASTER_DATA !== 'undefined') {
        currentData = MASTER_DATA[bulan] || [];
    }
    
    updateHero(bulan, +document.getElementById('fTahun').value, document.getElementById('fUnit').options[document.getElementById('fUnit').selectedIndex].text);
    if (typeof INITIAL_STATS !== 'undefined') {
        updateStats(INITIAL_STATS);
    }
    renderTable();
    renderUnitBars();
    renderKatBars();
    renderWeek(bulan, +document.getElementById('fTahun').value);
    renderSummary(bulan, +document.getElementById('fTahun').value);
});
