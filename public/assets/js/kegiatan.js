/* ════════════════════════════════════
   DATA SEED (DUMMY)
════════════════════════════════════ */
const KAT_COLORS = {
  'Rapat'      : { bg:'rgba(79,70,229,.1)',   color:'var(--c-primary)', icon:'bi-people-fill' },
  'Pelatihan'  : { bg:'rgba(16,185,129,.1)',  color:'var(--c-green)',   icon:'bi-book-fill' },
  'Kunjungan'  : { bg:'rgba(245,158,11,.1)',  color:'var(--c-accent)',  icon:'bi-geo-alt-fill' },
  'Sosialisasi': { bg:'rgba(6,182,212,.1)',   color:'var(--c-secondary)',icon:'bi-megaphone-fill' },
  'Upacara'    : { bg:'rgba(236,72,153,.1)',  color:'var(--c-pink)',    icon:'bi-flag-fill' },
};
const AVATAR_GRADS = [
  'linear-gradient(135deg,#4f46e5,#7c3aed)',
  'linear-gradient(135deg,#10b981,#06b6d4)',
  'linear-gradient(135deg,#f59e0b,#f97316)',
  'linear-gradient(135deg,#ec4899,#f472b6)',
  'linear-gradient(135deg,#8b5cf6,#a78bfa)',
];
const COVER_EMOJIS = ['📷','🎞','🖼','📸','🏛','👥','🏆','📋','🎓','🌏','🏢','🎤'];
const STATUS_CFG = {
  selesai  : { cls:'kc-badge-selesai', label:'Selesai',          tbl:'sp-selesai',  tbllabel:'Selesai' },
  draft    : { cls:'kc-badge-draft',   label:'Draft',             tbl:'sp-draft',    tbllabel:'Draft' },
  berjalan : { cls:'kc-badge-berjalan',label:'Sedang Berjalan',  tbl:'sp-berjalan', tbllabel:'Berjalan' },
};

let DATA = [
  {id:1, judul:'Rapat Koordinasi Dinas Kominfo Kota Pekalongan',      uraian:'Rapat koordinasi membahas program kerja tahun 2025 dan evaluasi capaian triwulan pertama bersama seluruh kepala bidang.',tanggal:'2025-04-24',kategori:'Rapat',      status:'selesai', foto:12, petugas:'Ahmad Fauzi',    petugasGrad:0, emoji:'📋'},
  {id:2, judul:'Pelatihan SDM Digitalisasi Pelayanan Publik',          uraian:'Kegiatan pelatihan peningkatan kapasitas SDM dalam rangka implementasi digitalisasi layanan publik berbasis teknologi.',tanggal:'2025-04-22',kategori:'Pelatihan',   status:'selesai', foto:8,  petugas:'Siti Rahayu',    petugasGrad:1, emoji:'🎓'},
  {id:3, judul:'Kunjungan Lapangan Infrastruktur IT Puskesmas',        uraian:'Monitoring dan evaluasi infrastruktur teknologi informasi di seluruh puskesmas Kota Pekalongan semester I 2025.',   tanggal:'2025-04-20',kategori:'Kunjungan',   status:'selesai', foto:18, petugas:'Budi Santoso',   petugasGrad:2, emoji:'🌏'},
  {id:4, judul:'Sosialisasi Aplikasi SiPeDas kepada Warga',            uraian:'Sosialisasi penggunaan aplikasi pelayanan digital kepada warga di kelurahan sebagai bagian dari smart city.',          tanggal:'2025-04-18',kategori:'Sosialisasi', status:'selesai', foto:6,  petugas:'Dewi Kusuma',    petugasGrad:3, emoji:'🎤'},
  {id:5, judul:'Upacara Peringatan Hari Kartini Tingkat Kota',         uraian:'Upacara bendera dalam rangka memperingati Hari Kartini yang diikuti oleh seluruh ASN Kota Pekalongan.',              tanggal:'2025-04-21',kategori:'Upacara',     status:'selesai', foto:24, petugas:'Wahyu Nugroho',  petugasGrad:4, emoji:'🏆'},
  {id:6, judul:'Rapat Evaluasi Program Smart City 2025',               uraian:'Evaluasi progres implementasi program smart city Kota Pekalongan yang melibatkan seluruh OPD terkait.',             tanggal:'2025-04-17',kategori:'Rapat',      status:'selesai', foto:5,  petugas:'Rizal Pratama',  petugasGrad:0, emoji:'🏢'},
  {id:7, judul:'Pelatihan Fotografi Dokumentasi Kegiatan',             uraian:'Pelatihan teknik fotografi yang baik dan benar untuk keperluan dokumentasi kegiatan pemerintahan kota.',            tanggal:'2025-04-15',kategori:'Pelatihan',   status:'selesai', foto:32, petugas:'Rina Marlina',   petugasGrad:1, emoji:'📷'},
  {id:8, judul:'Kunjungan ke Pusat Data Nasional Surabaya',            uraian:'Studi banding dan kunjungan ke Pusat Data Nasional (PDN) Surabaya untuk benchmark pengelolaan data pemerintah.',    tanggal:'2025-04-14',kategori:'Kunjungan',   status:'selesai', foto:14, petugas:'Faisal Rahman',  petugasGrad:2, emoji:'🏛'},
  {id:9, judul:'Sosialisasi Keamanan Siber untuk ASN',                 uraian:'Sosialisasi ancaman keamanan siber dan cara pencegahannya kepada aparatur sipil negara Kota Pekalongan.',           tanggal:'2025-04-12',kategori:'Sosialisasi', status:'selesai', foto:9,  petugas:'Ahmad Fauzi',    petugasGrad:0, emoji:'🖼'},
  {id:10,judul:'Rapat Finalisasi Anggaran TIK 2025-2026',              uraian:'Pembahasan dan finalisasi rencana anggaran pengembangan teknologi informasi dan komunikasi dua tahun ke depan.',     tanggal:'2025-04-10',kategori:'Rapat',      status:'selesai', foto:4,  petugas:'Wahyu Nugroho',  petugasGrad:4, emoji:'📋'},
  {id:11,judul:'Workshop Pembuatan Konten Media Sosial Pemerintah',    uraian:'Workshop kreatif pembuatan konten media sosial yang menarik untuk akun resmi Pemkot Pekalongan.',                   tanggal:'2025-04-08',kategori:'Pelatihan',   status:'selesai', foto:21, petugas:'Siti Rahayu',    petugasGrad:1, emoji:'🎞'},
  {id:12,judul:'Kunjungan Monitoring CCTV Kota Pekalongan',            uraian:'Monitoring dan evaluasi sistem CCTV di titik-titik strategis Kota Pekalongan beserta uji koneksi ke command center.',tanggal:'2025-04-05',kategori:'Kunjungan',   status:'selesai', foto:16, petugas:'Budi Santoso',   petugasGrad:2, emoji:'📸'},
  {id:13,judul:'Upacara Hari Pendidikan Nasional Kota Pekalongan',     uraian:'Pelaksanaan upacara Hardiknas tingkat Kota Pekalongan yang digelar di halaman Balai Kota.',                         tanggal:'2025-05-02',kategori:'Upacara',     status:'berjalan',foto:0,  petugas:'Dewi Kusuma',    petugasGrad:3, emoji:'🏆'},
  {id:14,judul:'Rapat Persiapan HUT Kota Pekalongan ke-419',          uraian:'Rapat koordinasi persiapan rangkaian acara dan kegiatan dalam rangka Hari Ulang Tahun Kota Pekalongan ke-419.',    tanggal:'2025-05-05',kategori:'Rapat',      status:'berjalan',foto:0,  petugas:'Rizal Pratama',  petugasGrad:0, emoji:'📋'},
  {id:15,judul:'Sosialisasi PPID Kota Pekalongan ke Masyarakat',      uraian:'Kegiatan sosialisasi hak masyarakat mendapatkan informasi publik melalui layanan PPID Kota Pekalongan.',            tanggal:'2025-05-08',kategori:'Sosialisasi', status:'draft',   foto:0,  petugas:'Rina Marlina',   petugasGrad:1, emoji:'🎤'},
  {id:16,judul:'Pelatihan Pengelolaan Website OPD',                    uraian:'Bimbingan teknis pengelolaan dan pembaruan konten website resmi Organisasi Perangkat Daerah se-Kota Pekalongan.',  tanggal:'2025-05-10',kategori:'Pelatihan',   status:'draft',   foto:0,  petugas:'Faisal Rahman',  petugasGrad:2, emoji:'🎓'},
  {id:17,judul:'Rapat Koordinasi E-Government Seluruh OPD',            uraian:'Rapat koordinasi pengembangan e-government dan integrasi sistem informasi antar OPD Kota Pekalongan.',              tanggal:'2025-04-03',kategori:'Rapat',      status:'selesai', foto:7,  petugas:'Ahmad Fauzi',    petugasGrad:0, emoji:'🏢'},
  {id:18,judul:'Kunjungan Studi Banding ke Pemkot Semarang',           uraian:'Kunjungan studi banding ke Pemerintah Kota Semarang untuk mempelajari best practice smart city.',                  tanggal:'2025-03-28',kategori:'Kunjungan',   status:'selesai', foto:19, petugas:'Wahyu Nugroho',  petugasGrad:4, emoji:'🌏'},
  {id:19,judul:'Upacara Isra Miraj Kota Pekalongan',                   uraian:'Pelaksanaan peringatan Isra Miraj Nabi Muhammad SAW tingkat Kota Pekalongan di Auditorium Balai Kota.',             tanggal:'2025-03-25',kategori:'Upacara',     status:'selesai', foto:11, petugas:'Siti Rahayu',    petugasGrad:1, emoji:'🏛'},
  {id:20,judul:'Workshop Data Analytics untuk Pemerintahan',           uraian:'Workshop pengolahan dan analisis data pemerintahan menggunakan tools modern untuk pengambilan keputusan berbasis data.',tanggal:'2025-03-20',kategori:'Pelatihan', status:'selesai', foto:13, petugas:'Budi Santoso',  petugasGrad:2, emoji:'📊'},
  {id:21,judul:'Sosialisasi Batik Digital Pekalongan ke Platform E-Commerce',uraian:'Program sosialisasi pemasaran batik Pekalongan melalui platform e-commerce nasional kepada para pengrajin dan UMKM.',tanggal:'2025-03-15',kategori:'Sosialisasi',status:'selesai',foto:22,petugas:'Dewi Kusuma',petugasGrad:3,emoji:'🎤'},
  {id:22,judul:'Rapat Pembahasan Master Plan TIK 2025-2030',           uraian:'Pembahasan rencana induk pengembangan TIK Kota Pekalongan untuk periode 2025 hingga 2030.',                        tanggal:'2025-03-10',kategori:'Rapat',      status:'selesai', foto:6,  petugas:'Rizal Pratama',  petugasGrad:0, emoji:'📋'},
  {id:23,judul:'Kunjungan Kerja Komisi I DPRD ke Kominfo',             uraian:'Kunjungan kerja Komisi I DPRD Kota Pekalongan dalam rangka reses dan pengawasan program kerja Dinas Kominfo.',     tanggal:'2025-03-05',kategori:'Kunjungan',   status:'selesai', foto:9,  petugas:'Rina Marlina',   petugasGrad:1, emoji:'🏢'},
  {id:24,judul:'Upacara HUT Korpri ke-53 Kota Pekalongan',            uraian:'Upacara peringatan Hari Ulang Tahun Korps Pegawai Republik Indonesia ke-53 tingkat Kota Pekalongan.',              tanggal:'2025-03-01',kategori:'Upacara',     status:'selesai', foto:15, petugas:'Faisal Rahman',  petugasGrad:2, emoji:'🏆'},
];

/* ════════════════════════════════════
   STATE
════════════════════════════════════ */
let filteredData    = [...DATA];
let currentView     = 'card';
let currentPage     = 1;
const perPage       = 12;
let selectedIds     = new Set();

/* ════════════════════════════════════
   INITIALIZATION
════════════════════════════════════ */
$(document).ready(function() {
    updateStats();
    render();

    // FAB scroll logic
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) $('#fabBtn').addClass('visible');
        else $('#fabBtn').removeClass('visible');
    });

    // Close drawer on overlay click
    $('#drawerOverlay').on('click', function(e) {
        if (e.target === this) closeDrawer();
    });
});

/* ════════════════════════════════════
   MINI STATS
════════════════════════════════════ */
function animCounter(id, target) {
  const el = document.getElementById(id); if (!el) return;
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

function updateStats() {
  animCounter('sc1', DATA.length);
  animCounter('sc2', DATA.filter(d => d.status === 'selesai').length);
  animCounter('sc3', DATA.filter(d => d.status === 'draft').length);
  animCounter('sc4', DATA.reduce((s, d) => s + d.foto, 0));
}

/* ════════════════════════════════════
   FILTER
════════════════════════════════════ */
function filterData() {
  const q   = $('#searchInput').val().toLowerCase();
  const st  = $('#filterStatus').val();
  const kat = $('#filterKategori').val();
  const bln = $('#filterBulan').val();

  filteredData = DATA.filter(d =>
    (!q   || d.judul.toLowerCase().includes(q) || d.uraian.toLowerCase().includes(q)) &&
    (!st  || d.status   === st) &&
    (!kat || d.kategori === kat) &&
    (!bln || d.tanggal.split('-')[1] === bln)
  );
  currentPage = 1;
  render();
}

/* ════════════════════════════════════
   DATE FORMAT
════════════════════════════════════ */
function fmtDate(s) {
  const [y,m,d] = s.split('-');
  const mn = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  return `${+d} ${mn[+m-1]} ${y}`;
}

/* ════════════════════════════════════
   RENDER
════════════════════════════════════ */
function render() {
  if (currentView === 'card') {
      $('#cardViewWrap').show();
      $('#tableViewWrap').hide();
      $('#cardPaginationWrap').show();
      renderCards();
  } else {
      $('#cardViewWrap').hide();
      $('#tableViewWrap').show();
      $('#cardPaginationWrap').hide();
      renderTable();
  }
}

/* ── CARD VIEW ── */
function renderCards() {
  const grid   = $('#cardGrid');
  const empty  = $('#emptyCard');
  const start  = (currentPage - 1) * perPage;
  const slice  = filteredData.slice(start, start + perPage);

  if (!filteredData.length) { 
      grid.empty(); 
      empty.removeClass('d-none'); 
      renderPagination('cardPagination', 'cardPageInfo'); 
      return; 
  }
  empty.addClass('d-none');

  const kat = KAT_COLORS;
  let html = slice.map(d => {
    const sc  = STATUS_CFG[d.status];
    const kc  = kat[d.kategori] || { bg:'rgba(79,70,229,.1)', color:'var(--c-primary)', icon:'bi-tag-fill' };
    const init = d.petugas.split(' ').map(w => w[0]).join('').slice(0,2);
    return `
      <div class="kegiatan-card" data-id="${d.id}">
        <div class="kc-cover">
          <div class="kc-cover-placeholder" style="background:linear-gradient(135deg,${gradByIndex(d.petugasGrad)});">${d.emoji}</div>
          <span class="kc-badge ${sc.cls}"><i class="bi bi-circle-fill" style="font-size:.45rem;"></i> ${sc.label}</span>
          ${d.foto > 0 ? `<span class="kc-foto-count"><i class="bi bi-images"></i> ${d.foto} foto</span>` : ''}
        </div>
        <div class="kc-body">
          <div class="kc-date"><i class="bi bi-calendar3"></i> ${fmtDate(d.tanggal)}</div>
          <div class="kc-title">${d.judul}</div>
          <div class="kc-desc">${d.uraian}</div>
          <div class="kc-meta">
            <div class="kc-meta-item"><i class="bi bi-images" style="color:var(--c-primary);"></i> ${d.foto} foto</div>
            <div class="kc-kategori" style="background:${kc.bg};color:${kc.color};">
              <i class="bi ${kc.icon}"></i> ${d.kategori}
            </div>
          </div>
        </div>
        <div class="kc-footer">
          <div class="kc-uploader">
            <div class="kc-uploader-avatar" style="background:linear-gradient(135deg,${gradByIndex(d.petugasGrad)});">${init}</div>
            <span class="kc-uploader-name">${d.petugas}</span>
          </div>
          <button class="kc-action-btn view"   onclick="openDrawer(${d.id})" title="Detail Kegiatan" aria-label="Lihat detail ${d.judul}"><i class="bi bi-eye-fill"></i></button>
          <button class="kc-action-btn edit"   onclick="editKegiatan(${d.id})" title="Edit Kegiatan" aria-label="Edit kegiatan ${d.judul}"><i class="bi bi-pencil-fill"></i></button>
          <button class="kc-action-btn delete" onclick="deleteKegiatan(${d.id})" title="Hapus Kegiatan" aria-label="Hapus kegiatan ${d.judul}"><i class="bi bi-trash3-fill"></i></button>
        </div>
      </div>`;
  }).join('');
  
  grid.html(html);
  renderPagination('cardPagination', 'cardPageInfo');
}

/* ── TABLE VIEW ── */
function renderTable() {
    const body = $('#tableBody');
    const empty = $('#emptyTable');
    const start = (currentPage - 1) * perPage;
    const slice = filteredData.slice(start, start + perPage);

    if (!filteredData.length) {
        body.empty();
        empty.removeClass('d-none');
        renderPagination('pagination', 'pageInfo');
        return;
    }
    empty.addClass('d-none');

    const kat = KAT_COLORS;
    let html = slice.map(d => {
        const sc = STATUS_CFG[d.status];
        const kc = kat[d.kategori] || { bg: 'rgba(79, 70, 229, .1)', color: 'var(--c-primary)', icon: 'bi-tag-fill' };
        const isChecked = selectedIds.has(d.id) ? 'checked' : '';

        return `
            <tr>
                <td><input type="checkbox" class="row-check" data-id="${d.id}" onchange="toggleCheck(${d.id})" ${isChecked} aria-label="Pilih ${d.judul}" /></td>
                <td>
                    <div class="tbl-title-cell">
                        <div class="tbl-thumb-placeholder" style="background:linear-gradient(135deg,${gradByIndex(d.petugasGrad)}); font-size:1.1rem;">${d.emoji}</div>
                        <div>
                            <div class="tbl-title">${d.judul}</div>
                            <div class="tbl-desc">${d.uraian}</div>
                        </div>
                    </div>
                </td>
                <td><div style="font-weight:600;font-size:.82rem;">${fmtDate(d.tanggal)}</div></td>
                <td><span class="kat-pill" style="background:${kc.bg};color:${kc.color};"><i class="bi ${kc.icon}"></i> ${d.kategori}</span></td>
                <td><span class="status-pill ${sc.tbl}">${sc.tbllabel}</span></td>
                <td style="text-align:center;"><span class="foto-pill"><i class="bi bi-images"></i> ${d.foto}</span></td>
                <td><div style="font-weight:600;font-size:.82rem;">${d.petugas}</div></td>
                <td>
                    <div class="tbl-actions">
                        <button class="tbl-btn tbl-view"   onclick="openDrawer(${d.id})" title="Detail Kegiatan" aria-label="Lihat detail ${d.judul}"><i class="bi bi-eye-fill"></i></button>
                        <button class="tbl-btn tbl-edit"   onclick="editKegiatan(${d.id})" title="Edit Kegiatan" aria-label="Edit kegiatan ${d.judul}"><i class="bi bi-pencil-fill"></i></button>
                        <button class="tbl-btn tbl-delete" onclick="deleteKegiatan(${d.id})" title="Hapus Kegiatan" aria-label="Hapus kegiatan ${d.judul}"><i class="bi bi-trash3-fill"></i></button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

    body.html(html);
    renderPagination('pagination', 'pageInfo');
}

function renderPagination(containerId, infoId) {
    const total = filteredData.length;
    const lastPage = Math.ceil(total / perPage);
    const start = (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, total);

    $(`#${infoId}`).text(`Menampilkan ${total ? start : 0}–${end} dari ${total} kegiatan`);

    const pg = $(`#${containerId}`);
    pg.empty();
    if (lastPage <= 1) return;

    pg.append(`<button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})" aria-label="Halaman sebelumnya"><i class="bi bi-chevron-left"></i></button>`);

    for (let i = 1; i <= lastPage; i++) {
        if (i === 1 || i === lastPage || (i >= currentPage - 1 && i <= currentPage + 1)) {
            pg.append(`<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`);
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            pg.append(`<span style="padding:8px; color:var(--c-muted);">...</span>`);
        }
    }

    pg.append(`<button class="page-btn" ${currentPage === lastPage ? 'disabled' : ''} onclick="changePage(${currentPage + 1})" aria-label="Halaman selanjutnya"><i class="bi bi-chevron-right"></i></button>`);
}

function changePage(p) {
    currentPage = p;
    render();
    scrollToTop();
}

function setView(v) {
    currentView = v;
    $('#btnCardView, #btnTableView').removeClass('active');
    if (v === 'card') $('#btnCardView').addClass('active');
    else $('#btnTableView').addClass('active');
    render();
}

function gradByIndex(i) {
  const G = ['#4f46e5,#7c3aed','#10b981,#06b6d4','#f59e0b,#f97316','#ec4899,#f472b6','#8b5cf6,#a78bfa'];
  return G[i % G.length];
}

/* ════════════════════════════════════
   DRAWER CONTROL
════════════════════════════════════ */
function openDrawer(id) {
    const d = DATA.find(x => x.id === id);
    if (!d) return;

    const kat = KAT_COLORS;
    const kc = kat[d.kategori] || { bg: 'rgba(79, 70, 229, .1)', color: 'var(--c-primary)', icon: 'bi-tag-fill' };
    const sc = STATUS_CFG[d.status];

    let bodyHtml = `
        <div class="drawer-gallery">
            <div class="gallery-main-placeholder" style="background:linear-gradient(135deg,${gradByIndex(d.petugasGrad)});">${d.emoji}</div>
            <span class="gallery-count-badge"><i class="bi bi-images"></i> ${d.foto} Foto</span>
        </div>
        <div class="drawer-info">
            <div class="d-section-title">Informasi Utama</div>
            <div class="d-info-row">
                <div class="d-info-icon"><i class="bi bi-calendar3"></i></div>
                <div>
                    <div class="d-info-label">Tanggal Kegiatan</div>
                    <div class="d-info-val">${fmtDate(d.tanggal)}</div>
                </div>
            </div>
            <div class="d-info-row">
                <div class="d-info-icon" style="background:${kc.bg}; color:${kc.color};"><i class="bi ${kc.icon}"></i></div>
                <div>
                    <div class="d-info-label">Kategori</div>
                    <div class="d-info-val">${d.kategori}</div>
                </div>
            </div>
            <div class="d-info-row">
                <div class="d-info-icon"><i class="bi bi-person-badge"></i></div>
                <div>
                    <div class="d-info-label">Petugas Dokumentasi</div>
                    <div class="d-info-val">${d.petugas}</div>
                </div>
            </div>
            <div class="d-info-row">
                <div class="d-info-icon"><i class="bi bi-check2-circle"></i></div>
                <div>
                    <div class="d-info-label">Status Dokumentasi</div>
                    <div class="d-info-val"><span class="status-pill ${sc.tbl}">${sc.tbllabel}</span></div>
                </div>
            </div>

            <div class="d-divider" style="height:1px; background:var(--c-border); margin:20px 0;"></div>
            <div class="d-section-title">Uraian / Deskripsi</div>
            <h4 style="font-family:'Nunito',sans-serif; font-weight:800; font-size:1.1rem; color:var(--c-text); margin-bottom:12px;">${d.judul}</h4>
            <div class="d-desc-box">${d.uraian}</div>
        </div>
    `;

    $('#drawerBody').html(bodyHtml);
    $('#drawerOverlay').addClass('show');
    $('body').css('overflow', 'hidden');

    // Bind footer buttons
    $('#drawerEditBtn').off('click').on('click', () => { closeDrawer(); editKegiatan(id); });
    $('#drawerDeleteBtn').off('click').on('click', () => { deleteKegiatan(id); });
}

function closeDrawer() {
    $('#drawerOverlay').removeClass('show');
    $('body').css('overflow', '');
}

/* ════════════════════════════════════
   ACTIONS (PLACEHOLDER)
════════════════════════════════════ */
function editKegiatan(id) { DKA.notify({ type: 'info', title: 'Edit', message: 'Fitur Edit akan segera hadir.' }); }
function deleteKegiatan(id) { 
    const d = DATA.find(x => x.id === id);
    DKA.deleteConfirm({ title: 'Hapus Kegiatan?', message: 'Data kegiatan akan dihapus permanen.', itemName: d ? d.judul : 'Kegiatan' })
    .then(res => { if(res) DKA.notify({ type: 'success', title: 'Dihapus', message: 'Data berhasil dihapus (Simulasi).' }); });
}
function exportData() { DKA.notify({ type: 'success', title: 'Export', message: 'Mengekspor data ke Excel...' }); }
function scrollToTop() { window.scrollTo({ top: 0, behavior: 'smooth' }); }

/* ── Bulk actions placeholder ── */
function toggleAllCheck(el) { $('.row-check').prop('checked', el.checked); }
function toggleCheck(id) { /* handle state */ }
