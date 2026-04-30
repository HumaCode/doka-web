/* ════════════════════════════════════
   DATA
════════════════════════════════════ */
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

const AVATAR_GRADS = [
  'linear-gradient(135deg,#4f46e5,#7c3aed)',
  'linear-gradient(135deg,#10b981,#06b6d4)',
  'linear-gradient(135deg,#f59e0b,#f97316)',
  'linear-gradient(135deg,#ec4899,#f472b6)',
  'linear-gradient(135deg,#8b5cf6,#a78bfa)',
  'linear-gradient(135deg,#ef4444,#f87171)',
];

const ICONS_POOL = [
  'bi-building-fill','bi-building-check','bi-building-gear','bi-building-lock','bi-building-add',
  'bi-house-fill','bi-hospital-fill','bi-bank','bi-bank2','bi-shop-fill',
  'bi-briefcase-fill','bi-laptop','bi-cpu-fill','bi-shield-fill','bi-shield-check-fill',
  'bi-heart-fill','bi-people-fill','bi-person-workspace','bi-globe-americas','bi-globe2',
  'bi-graph-up-arrow','bi-bar-chart-fill','bi-pie-chart-fill','bi-journal-text','bi-journal-bookmark-fill',
  'bi-gear-fill','bi-tools','bi-wrench-adjustable','bi-camera-fill','bi-camera-video-fill',
  'bi-megaphone-fill','bi-flag-fill','bi-trophy-fill','bi-star-fill','bi-award-fill',
  'bi-cash-coin','bi-receipt','bi-clipboard-fill','bi-file-earmark-text-fill','bi-folder-fill',
  'bi-tree-fill','bi-flower1','bi-droplet-fill','bi-lightning-fill','bi-sun-fill',
  'bi-bus-front-fill','bi-airplane-fill','bi-truck-fill','bi-bicycle','bi-car-front-fill',
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

let DATA = [
  { id:1,  nama:'Dinas Komunikasi dan Informatika',              sing:'Diskominfo',   jenis:'Dinas',       kepala:'Ahmad Fauzi, S.Kom., M.T.',   telp:'(0285) 412345', email:'diskominfo@pekalongan.go.id', web:'https://kominfo.pekalongan.go.id',   alamat:'Jl. Sriwijaya No. 44, Kota Pekalongan',     desc:'Melaksanakan urusan pemerintahan di bidang komunikasi dan informatika, statistik, dan persandian.',              icon:'bi-cpu-fill',            gradId:0,  kegiatan:72, pengguna:8,  foto:312, status:'active'   },
  { id:2,  nama:'Dinas Pendidikan',                              sing:'Disdik',       jenis:'Dinas',       kepala:'Dr. Siti Rahayu, M.Pd.',       telp:'(0285) 421100', email:'disdik@pekalongan.go.id',    web:'https://disdik.pekalongan.go.id',    alamat:'Jl. Sriwijaya No. 32, Kota Pekalongan',     desc:'Melaksanakan urusan pemerintahan di bidang pendidikan.',                                                          icon:'bi-journal-bookmark-fill',gradId:1,  kegiatan:45, pengguna:6,  foto:198, status:'active'   },
  { id:3,  nama:'Dinas Kesehatan',                               sing:'Dinkes',       jenis:'Dinas',       kepala:'dr. Budi Santoso, M.Kes.',     telp:'(0285) 425678', email:'dinkes@pekalongan.go.id',    web:'https://dinkes.pekalongan.go.id',    alamat:'Jl. Dr. Wahidin No. 17, Kota Pekalongan',   desc:'Melaksanakan urusan pemerintahan di bidang kesehatan masyarakat.',                                                icon:'bi-hospital-fill',       gradId:7,  kegiatan:38, pengguna:7,  foto:167, status:'active'   },
  { id:4,  nama:'Dinas Sosial',                                  sing:'Dinsos',       jenis:'Dinas',       kepala:'Hendra Wijaya, S.Sos., M.M.',  telp:'(0285) 431200', email:'dinsos@pekalongan.go.id',    web:'',                                  alamat:'Jl. Pemuda No. 52, Kota Pekalongan',        desc:'Melaksanakan urusan pemerintahan di bidang sosial and perlindungan masyarakat.',                                  icon:'bi-heart-fill',          gradId:3,  kegiatan:28, pengguna:5,  foto:112, status:'active'   },
  { id:5,  nama:'Dinas Pekerjaan Umum dan Penataan Ruang',       sing:'DPUPR',        jenis:'Dinas',       kepala:'Ir. Dewi Kusuma, M.T.',        telp:'(0285) 445566', email:'dpupr@pekalongan.go.id',     web:'https://pu.pekalongan.go.id',        alamat:'Jl. Veteran No. 8, Kota Pekalongan',        desc:'Melaksanakan urusan di bidang pekerjaan umum, penataan ruang, and perumahan.',                                   icon:'bi-building-gear',       gradId:2,  kegiatan:31, pengguna:4,  foto:143, status:'active'   },
  { id:6,  nama:'Dinas Koperasi, Usaha Kecil and Menengah',      sing:'Diskop UKM',   jenis:'Dinas',       kepala:'Wahyu Nugroho, S.E., M.M.',    telp:'(0285) 456789', email:'diskop@pekalongan.go.id',    web:'',                                  alamat:'Jl. Barito No. 3, Kota Pekalongan',         desc:'Melaksanakan urusan di bidang koperasi, usaha kecil and menengah.',                                               icon:'bi-cash-coin',           gradId:8,  kegiatan:22, pengguna:3,  foto:89,  status:'active'   },
  { id:7,  nama:'Dinas Pariwisata, Kebudayaan, Kepemudaan and Olahraga', sing:'Disparbudpora', jenis:'Dinas', kepala:'Rina Marlina, S.Pd., M.M.',telp:'(0285) 467890', email:'disparpora@pekalongan.go.id',web:'https://pariwisata.pekalongan.go.id',alamat:'Jl. Merdeka No. 12, Kota Pekalongan',      desc:'Melaksanakan urusan di bidang pariwisata, kebudayaan, kepemudaan, and olahraga.',                                icon:'bi-trophy-fill',         gradId:4,  kegiatan:19, pengguna:4,  foto:98,  status:'active'   },
  { id:8,  nama:'Badan Perencanaan Pembangunan Daerah',          sing:'Bappeda',      jenis:'Badan',       kepala:'Faisal Rahman, S.T., M.Sc.',   telp:'(0285) 478900', email:'bappeda@pekalongan.go.id',   web:'https://bappeda.pekalongan.go.id',   alamat:'Jl. Sriwijaya No. 48, Kota Pekalongan',     desc:'Melaksanakan fungsi perencanaan pembangunan and pengembangan daerah Kota Pekalongan.',                            icon:'bi-graph-up-arrow',      gradId:9,  kegiatan:24, pengguna:5,  foto:105, status:'active'   },
  { id:9,  nama:'Badan Kepegawaian and Pengembangan SDM',        sing:'BKPSDM',       jenis:'Badan',       kepala:'Nurul Hidayah, S.IP., M.M.',   telp:'(0285) 489001', email:'bkpsdm@pekalongan.go.id',    web:'',                                  alamat:'Jl. Pemuda No. 60, Kota Pekalongan',        desc:'Melaksanakan fungsi manajemen kepegawaian and pengembangan sumber daya manusia aparatur.',                        icon:'bi-people-fill',         gradId:10, kegiatan:17, pengguna:3,  foto:71,  status:'active'   },
  { id:10, nama:'Inspektorat Daerah',                            sing:'Inspektorat',  jenis:'Inspektorat', kepala:'Maya Sari, S.H., M.H.',        telp:'(0285) 489001', email:'inspektorat@pekalongan.go.id',web:'',                                 alamat:'Jl. Pemuda No. 66, Kota Pekalongan',        desc:'Melaksanakan pengawasan and pemeriksaan penyelenggaraan pemerintahan daerah.',                                    icon:'bi-shield-fill',         gradId:5,  kegiatan:15, pengguna:3,  foto:62,  status:'active'   },
  { id:11, nama:'Sekretariat Daerah',                            sing:'Setda',        jenis:'Sekretariat', kepala:'Rizal Pratama, S.IP., M.Si.',  telp:'(0285) 421001', email:'setda@pekalongan.go.id',     web:'https://pekalongan.go.id',           alamat:'Jl. Sriwijaya No. 1, Kota Pekalongan',      desc:'Membantu kepala daerah dalam penyusunan kebijakan, koordinasi, pembinaan, and pengawasan.',                       icon:'bi-building-lock',       gradId:0,  kegiatan:56, pengguna:10, foto:231, status:'active'   },
  { id:12, nama:'Sekretariat DPRD',                              sing:'Setwan',       jenis:'Sekretariat', kepala:'Agung Prasetyo, S.Sos.',       telp:'(0285) 421010', email:'setwan@pekalongan.go.id',    web:'',                                  alamat:'Jl. Sriwijaya No. 3, Kota Pekalongan',     desc:'Memberikan dukungan administrasi and keahlian kepada DPRD Kota Pekalongan.',                                     icon:'bi-journal-text',        gradId:1,  kegiatan:12, pengguna:3,  foto:55,  status:'active'   },
  { id:13, nama:'Bagian Hubungan Masyarakat',                    sing:'Humas',        jenis:'Bagian',      kepala:'Rinto Wibowo, S.Sos.',         telp:'(0285) 421002', email:'humas@pekalongan.go.id',     web:'',                                  alamat:'Jl. Sriwijaya No. 1 (Balai Kota)',          desc:'Melaksanakan urusan kehumasan, protokol, and publikasi pemerintah daerah Kota Pekalongan.',                       icon:'bi-megaphone-fill',      gradId:11, kegiatan:33, pengguna:4,  foto:156, status:'active'   },
  { id:14, nama:'Dinas Lingkungan Hidup',                        sing:'DLH',          jenis:'Dinas',       kepala:'Sri Lestari, S.T., M.Ling.',   telp:'(0285) 492100', email:'dlh@pekalongan.go.id',       web:'',                                  alamat:'Jl. Dr. Cipto No. 9, Kota Pekalongan',      desc:'Melaksanakan urusan di bidang lingkungan hidup, kebersihan, and persampahan.',                                   icon:'bi-tree-fill',           gradId:12, kegiatan:18, pengguna:3,  foto:77,  status:'inactive' },
  { id:15, nama:'RSUD Bendan Kota Pekalongan',                   sing:'RSUD Bendan',  jenis:'RSUD',        kepala:'dr. Yudi Prasetyo, Sp.PD.',    telp:'(0285) 421399', email:'rsud@pekalongan.go.id',      web:'https://rsud.pekalongan.go.id',      alamat:'Jl. Sriwijaya No. 68, Kota Pekalongan',     desc:'Rumah sakit umum daerah milik Pemerintah Kota Pekalongan yang melayani kesehatan masyarakat.',                   icon:'bi-hospital-fill',       gradId:5,  kegiatan:8,  pengguna:5,  foto:43,  status:'inactive' },
];

/* ════════════════════════════════════
   STATE
════════════════════════════════════ */
let filteredData  = [...DATA];
let currentPage   = 1;
let perPage       = 15;
let editingId     = null;
let selIcon       = 'bi-building-fill';
let selColor      = 0;
let sortKey       = '';
let sortAsc       = true;
let selectedIds   = new Set();

/* ════════════════════════════════════
   STATS ANIMATION
════════════════════════════════════ */
function animCounter(id, target) {
  const el = document.getElementById(id); if (!el) return;
  let cur = 0; const inc = target / 50;
  const t = setInterval(() => {
    cur += inc; if (cur >= target) { cur = target; clearInterval(t); }
    el.textContent = Math.floor(cur).toLocaleString('id-ID');
  }, 16);
}
function updateStats() {
  animCounter('sc1', DATA.length);
  animCounter('sc2', DATA.filter(d => d.status === 'active').length);
  animCounter('sc3', DATA.reduce((s, d) => s + d.kegiatan, 0));
  animCounter('sc4', DATA.reduce((s, d) => s + d.pengguna, 0));
}

/* ════════════════════════════════════
   FILTER
════════════════════════════════════ */
function filterData() {
  const q   = document.getElementById('searchInput').value.toLowerCase();
  const st  = document.getElementById('filterStatus').value;
  const jen = document.getElementById('filterJenis').value;
  filteredData = DATA.filter(d =>
    (!q   || d.nama.toLowerCase().includes(q) || d.sing.toLowerCase().includes(q) || (d.kepala||'').toLowerCase().includes(q)) &&
    (!st  || d.status === st) &&
    (!jen || d.jenis  === jen)
  );
  currentPage = 1;
  selectedIds.clear();
  updateBulkBar();
  render();
}

function resetFilters() {
  document.getElementById('searchInput').value = '';
  document.getElementById('filterStatus').value = '';
  document.getElementById('filterJenis').value = '';
  filterData();
}

/* ════════════════════════════════════
   SORT
════════════════════════════════════ */
function sortBy(key) {
  if (sortKey === key) sortAsc = !sortAsc; else { sortKey = key; sortAsc = true; }
  filteredData.sort((a, b) => {
    const av = String(a[key] ?? ''), bv = String(b[key] ?? '');
    return sortAsc ? av.localeCompare(bv, undefined, {numeric:true}) : bv.localeCompare(av, undefined, {numeric:true});
  });
  currentPage = 1;
  // Update header icons
  ['nama','jenis','kepala','kegiatan','pengguna','foto','status'].forEach(k => {
    const th = document.getElementById('th-'+k);
    const si = document.getElementById('si-'+k);
    if (!th || !si) return;
    th.classList.toggle('sorted', k === sortKey);
    si.className = k === sortKey
      ? (sortAsc ? 'sort-icon bi bi-sort-down-alt' : 'sort-icon bi bi-sort-up')
      : 'sort-icon bi bi-chevron-expand';
  });
  render();
}

/* ════════════════════════════════════
   RENDER TABLE
════════════════════════════════════ */
function render() {
  const tbody     = document.getElementById('tableBody');
  const emptyDiv  = document.getElementById('emptyState');
  const badge     = document.getElementById('tableCountBadge');
  const total     = filteredData.length;
  const start     = (currentPage - 1) * perPage;
  const slice     = filteredData.slice(start, start + perPage);

  badge.textContent = `${total} unit`;

  if (!total) {
    tbody.innerHTML = '';
    emptyDiv.classList.remove('d-none');
    document.getElementById('pageInfo').textContent = '';
    document.getElementById('pagination').innerHTML = '';
    return;
  }
  emptyDiv.classList.add('d-none');

  const rows = slice.map((d, i) => {
    const gradStr  = GRADS[d.gradId] || GRADS[0];
    const jClass   = JENIS_MAP[d.jenis] || 'jb-default';
    const init     = d.kepala ? d.kepala.split(' ').map(w=>w[0]).join('').slice(0,2).toUpperCase() : '—';
    const avGrad   = AVATAR_GRADS[(start + i) % AVATAR_GRADS.length];
    const checked  = selectedIds.has(d.id) ? 'checked' : '';

    return `
      <tr class="${selectedIds.has(d.id) ? 'selected' : ''}" data-id="${d.id}">
        <td class="col-check"><input type="checkbox" ${checked} onchange="onRowCheck(this, ${d.id})" /></td>
        <td>
          <div class="uk-name-cell">
            <div class="uk-logo" style="background:${gradStr};"><i class="bi ${d.icon}"></i></div>
            <div>
              <div class="uk-name-text">${d.nama}</div>
              <span class="uk-sing-text">${d.sing}</span>
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
        <td style="text-align:center;"><span class="count-pill"><i class="bi bi-calendar3-fill"></i> ${d.kegiatan}</span></td>
        <td style="text-align:center;"><span class="count-pill"><i class="bi bi-people-fill" style="color:var(--c-green);"></i> ${d.pengguna}</span></td>
        <td style="text-align:center;"><span class="count-pill"><i class="bi bi-images" style="color:var(--c-pink);"></i> ${d.foto}</span></td>
        <td><span class="status-pill ${d.status === 'active' ? 'sp-active' : 'sp-inactive'}">${d.status === 'active' ? 'Aktif' : 'Nonaktif'}</span></td>
        <td>
          <div class="tbl-actions">
            <button class="tbl-btn tbl-view"   onclick="openDrawer(${d.id})"     title="Detail"><i class="bi bi-eye-fill"></i></button>
            <button class="tbl-btn tbl-edit"   onclick="openEditModal(${d.id})"  title="Edit"><i class="bi bi-pencil-fill"></i></button>
            <button class="tbl-btn tbl-toggle" onclick="toggleStatus(${d.id})"  title="${d.status==='active'?'Nonaktifkan':'Aktifkan'}"><i class="bi ${d.status==='active'?'bi-toggle-on':'bi-toggle-off'}"></i></button>
            <button class="tbl-btn tbl-delete" onclick="deleteUK(${d.id})"      title="Hapus"><i class="bi bi-trash3-fill"></i></button>
          </div>
        </td>
      </tr>`;
  });

  tbody.innerHTML = rows.join('');

  const s = start + 1, e = Math.min(start + perPage, total);
  document.getElementById('pageInfo').textContent = `Menampilkan ${s}–${e} dari ${total} unit kerja`;

  const pageIds = slice.map(d => d.id);
  const allChecked = pageIds.length > 0 && pageIds.every(id => selectedIds.has(id));
  document.getElementById('checkAll').checked = allChecked;
  document.getElementById('checkAll').indeterminate = !allChecked && pageIds.some(id => selectedIds.has(id));

  renderPagination(total);
}

/* ════════════════════════════════════
   PAGINATION
════════════════════════════════════ */
function renderPagination(total) {
  const totalPages = Math.ceil(total / perPage);
  const pg = document.getElementById('pagination');
  if (totalPages <= 1) { pg.innerHTML = ''; return; }

  let html = `<button class="page-btn" onclick="goPage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}><i class="bi bi-chevron-left"></i></button>`;

  const pages = new Set([1, totalPages, currentPage, currentPage - 1, currentPage + 1].filter(p => p >= 1 && p <= totalPages));
  const sorted = [...pages].sort((a, b) => a - b);
  let prev = 0;
  sorted.forEach(p => {
    if (p - prev > 1) html += `<span style="display:grid;place-items:center;width:34px;color:var(--c-muted);font-size:.85rem;">…</span>`;
    html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
    prev = p;
  });

  html += `<button class="page-btn" onclick="goPage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}><i class="bi bi-chevron-right"></i></button>`;
  pg.innerHTML = html;
}

function goPage(p) {
  const total = Math.ceil(filteredData.length / perPage);
  if (p < 1 || p > total) return;
  currentPage = p;
  render();
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function changePerPage(val) {
  perPage = +val;
  currentPage = 1;
  render();
}

/* ════════════════════════════════════
   CHECKBOX / BULK
════════════════════════════════════ */
function toggleAllCheck(cb) {
  const start = (currentPage - 1) * perPage;
  const slice = filteredData.slice(start, start + perPage);
  slice.forEach(d => cb.checked ? selectedIds.add(d.id) : selectedIds.delete(d.id));
  render();
  updateBulkBar();
}

function onRowCheck(cb, id) {
  cb.checked ? selectedIds.add(id) : selectedIds.delete(id);
  const tr = cb.closest('tr');
  tr.classList.toggle('selected', cb.checked);
  const start = (currentPage - 1) * perPage;
  const pageIds = filteredData.slice(start, start + perPage).map(d => d.id);
  const allChecked = pageIds.every(pid => selectedIds.has(pid));
  document.getElementById('checkAll').checked = allChecked;
  document.getElementById('checkAll').indeterminate = !allChecked && pageIds.some(pid => selectedIds.has(pid));
  updateBulkBar();
}

function updateBulkBar() {
  const n = selectedIds.size;
  const bar = document.getElementById('bulkActions');
  if (bar) bar.classList.toggle('show', n > 0);
  const selText = document.getElementById('selectedCountText');
  if (selText) selText.textContent = `${n} dipilih`;
}

function bulkToggle() {
  if (!selectedIds.size) return;
  DKA.dialog({ type:'warning', title:'Toggle Status Massal', message:`Status ${selectedIds.size} unit kerja terpilih akan diubah. Lanjutkan?`, confirm:'Ya, Toggle Sekarang' })
    .then(r => {
      if (!r) return;
      selectedIds.forEach(id => {
        const d = DATA.find(x => x.id === id);
        if (d) d.status = d.status === 'active' ? 'inactive' : 'active';
      });
      selectedIds.clear(); updateStats(); filterData();
      DKA.toast({ type:'success', title:'Status berhasil diubah!', message:`Unit kerja diperbarui.`, position:'top-right' });
    });
}

function bulkDelete() {
  if (!selectedIds.size) return;
  DKA.deleteConfirm({
    title   : `Hapus ${selectedIds.size} Unit Kerja?`,
    message : 'Semua unit kerja yang dipilih akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.',
    itemName: `${selectedIds.size} unit kerja terpilih`,
    confirm : 'Ya, Hapus Semua',
  }).then(r => {
    if (!r) return;
    const loader = DKA.loading({ title:'Menghapus data...', message:'Mohon tunggu.', style:'dots' });
    setTimeout(() => {
      const n = selectedIds.size;
      DATA = DATA.filter(d => !selectedIds.has(d.id));
      filteredData = filteredData.filter(d => !selectedIds.has(d.id));
      selectedIds.clear(); loader.close(); updateBulkBar(); updateStats(); filterData();
      DKA.toast({ type:'success', title:'Berhasil Dihapus', message:`${n} unit kerja dihapus dari sistem.`, position:'top-right' });
    }, 1400);
  });
}

/* ════════════════════════════════════
   ICON & COLOR PICKERS
════════════════════════════════════ */
function buildIconGrid(q = '') {
  const icons = q ? ICONS_POOL.filter(i => i.includes(q.toLowerCase())) : ICONS_POOL;
  document.getElementById('iconGrid').innerHTML = icons.map(ic =>
    `<button type="button" class="icon-btn ${ic === selIcon ? 'selected' : ''}" onclick="pickIcon('${ic}')" title="${ic.replace('bi-','')}">
      <i class="bi ${ic}"></i>
    </button>`
  ).join('');
}

function pickIcon(ic) {
  selIcon = ic;
  buildIconGrid(document.getElementById('iconSearch').value);
  document.getElementById('mPreviewIcon').className  = `bi ${ic}`;
  document.getElementById('mHeadIconI').className    = `bi ${ic}`;
}

function buildColorSwatches() {
  document.getElementById('colorSwatches').innerHTML = GRADS.map((g, i) =>
    `<div class="c-swatch ${i === selColor ? 'selected' : ''}" style="background:${g};" onclick="pickColor(${i})"></div>`
  ).join('');
}

function pickColor(id) {
  selColor = id;
  buildColorSwatches();
  const g = GRADS[id];
  document.getElementById('mPreviewLogo').style.background = g;
  document.getElementById('mHeadIcon').style.background    = g;
}

/* ════════════════════════════════════
   MODAL
════════════════════════════════════ */
const FIELDS = ['f-nama','f-sing','f-jenis','f-kepala','f-telp','f-email','f-web','f-alamat','f-desc'];

function resetForm() {
  FIELDS.forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
  document.querySelectorAll('.fgroup').forEach(g => g.classList.remove('has-err'));
  document.getElementById('iconSearch').value = '';
  document.getElementById('mPreviewName').textContent = 'Nama Unit Kerja';
  document.getElementById('mPreviewSing').textContent = 'Singkatan · Jenis';
}

function openAddModal() {
  editingId = null; selIcon = 'bi-building-fill'; selColor = 0;
  document.getElementById('mTitleText').textContent      = 'Tambah Unit Kerja';
  document.getElementById('btnSave').innerHTML           = '<i class="bi bi-check2-circle"></i> Simpan';
  document.getElementById('mPreviewIcon').className      = 'bi bi-building-fill';
  document.getElementById('mHeadIconI').className        = 'bi bi-building-fill';
  document.getElementById('mPreviewLogo').style.background = GRADS[0];
  document.getElementById('mHeadIcon').style.background    = GRADS[0];
  resetForm();
  buildIconGrid(); buildColorSwatches();
  document.getElementById('modalUK').classList.add('show');
  document.body.style.overflow = 'hidden';
}

function openEditModal(id) {
  const d = DATA.find(x => x.id === id); if (!d) return;
  editingId = id; selIcon = d.icon; selColor = d.gradId;
  document.getElementById('mTitleText').textContent      = 'Edit Unit Kerja';
  document.getElementById('btnSave').innerHTML           = '<i class="bi bi-check2-circle"></i> Perbarui';
  document.getElementById('mPreviewIcon').className      = `bi ${d.icon}`;
  document.getElementById('mHeadIconI').className        = `bi ${d.icon}`;
  const g = GRADS[d.gradId];
  document.getElementById('mPreviewLogo').style.background = g;
  document.getElementById('mHeadIcon').style.background    = g;
  resetForm();
  document.getElementById('f-nama').value   = d.nama;
  document.getElementById('f-sing').value   = d.sing;
  document.getElementById('f-jenis').value  = d.jenis;
  document.getElementById('f-kepala').value = d.kepala  || '';
  document.getElementById('f-telp').value   = d.telp    || '';
  document.getElementById('f-email').value  = d.email   || '';
  document.getElementById('f-web').value    = d.web     || '';
  document.getElementById('f-alamat').value = d.alamat  || '';
  document.getElementById('f-desc').value   = d.desc    || '';
  document.getElementById('mPreviewName').textContent = d.nama;
  document.getElementById('mPreviewSing').textContent = `${d.sing} · ${d.jenis}`;
  buildIconGrid(); buildColorSwatches();
  document.getElementById('modalUK').classList.add('show');
  document.body.style.overflow = 'hidden';
}

function closeModal() {
  document.getElementById('modalUK').classList.remove('show');
  document.body.style.overflow = '';
}

/* Live preview updates */
function onNamaInput(v) {
  document.getElementById('mPreviewName').textContent = v || 'Nama Unit Kerja';
}
function onSingInput(v) {
  const j = document.getElementById('f-jenis').value;
  document.getElementById('mPreviewSing').textContent = (v || 'Singkatan') + (j ? ` · ${j}` : '');
}
function onJenisInput(v) {
  const s = document.getElementById('f-sing').value;
  document.getElementById('mPreviewSing').textContent = (s || 'Singkatan') + (v ? ` · ${v}` : '');
}

function clearErr(grpId) { document.getElementById(grpId)?.classList.remove('has-err'); }
function setErr(grpId)   { document.getElementById(grpId)?.classList.add('has-err'); }

function saveUK() {
  const nama  = document.getElementById('f-nama').value.trim();
  const sing  = document.getElementById('f-sing').value.trim();
  const jenis = document.getElementById('f-jenis').value;
  let ok = true;
  if (!nama)  { setErr('grp-nama');  ok = false; } else clearErr('grp-nama');
  if (!sing)  { setErr('grp-sing');  ok = false; } else clearErr('grp-sing');
  if (!jenis) { setErr('grp-jenis'); ok = false; } else clearErr('grp-jenis');
  if (!ok) { DKA.toast({ type:'danger', title:'Form belum lengkap', message:'Harap isi semua field yang wajib.', position:'top-right' }); return; }

  const btn = document.getElementById('btnSave');
  const orig = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

  setTimeout(() => {
    const payload = {
      nama, sing, jenis,
      kepala: document.getElementById('f-kepala').value.trim(),
      telp:   document.getElementById('f-telp').value.trim(),
      email:  document.getElementById('f-email').value.trim(),
      web:    document.getElementById('f-web').value.trim(),
      alamat: document.getElementById('f-alamat').value.trim(),
      desc:   document.getElementById('f-desc').value.trim(),
      icon:   selIcon, gradId: selColor,
    };

    if (editingId) {
      const d = DATA.find(x => x.id === editingId);
      Object.assign(d, payload);
      DKA.toast({ type:'success', title:'Unit Kerja Diperbarui!', message:`"${nama}" berhasil diperbarui.`, position:'top-right', duration:4000 });
    } else {
      DATA.push({ id: Date.now(), ...payload, kegiatan: 0, pengguna: 0, foto: 0, status: 'active' });
      DKA.toast({ type:'success', title:'Unit Kerja Ditambahkan!', message:`"${nama}" berhasil ditambahkan.`, position:'top-right', duration:4000 });
    }

    btn.disabled = false;
    btn.innerHTML = orig;
    updateStats(); filterData(); closeModal();
  }, 1100);
}

/* ════════════════════════════════════
   TOGGLE STATUS
════════════════════════════════════ */
function toggleStatus(id) {
  const d = DATA.find(x => x.id === id); if (!d) return;
  const act = d.status === 'active' ? 'nonaktifkan' : 'aktifkan';
  DKA.dialog({
    type   : d.status === 'active' ? 'warning' : 'success',
    title  : d.status === 'active' ? 'Nonaktifkan Unit Kerja?' : 'Aktifkan Unit Kerja?',
    message: `Unit kerja <strong>${d.sing}</strong> akan di${act}. Pengguna terdaftar tidak terpengaruh.`,
    confirm: `Ya, ${act.charAt(0).toUpperCase() + act.slice(1)}`,
  }).then(r => {
    if (!r) return;
    d.status = d.status === 'active' ? 'inactive' : 'active';
    updateStats(); filterData();
    DKA.toast({ type: d.status === 'active' ? 'success' : 'info', title: `Unit Kerja ${d.status === 'active' ? 'Diaktifkan' : 'Dinonaktifkan'}`, message: `"${d.nama}" berhasil di${act}kan.`, position:'top-right' });
  });
}

/* ════════════════════════════════════
   DELETE
════════════════════════════════════ */
function deleteUK(id) {
  closeDrawer();
  const d = DATA.find(x => x.id === id); if (!d) return;
  DKA.deleteConfirm({
    title   : 'Hapus Unit Kerja?',
    message : d.kegiatan > 0
      ? `Unit kerja ini memiliki <strong>${d.kegiatan} kegiatan</strong> and <strong>${d.pengguna} pengguna</strong>. Data terkait tidak akan ikut terhapus.`
      : 'Unit kerja ini belum memiliki kegiatan. Aman untuk dihapus.',
    itemName: `${d.jenis} ${d.sing}`,
    confirm : 'Ya, Hapus Unit Kerja',
  }).then(r => {
    if (!r) return;
    const loader = DKA.loading({ title:'Menghapus unit kerja...', message:'Membersihkan data terkait.', style:'dots' });
    setTimeout(() => {
      DATA = DATA.filter(x => x.id !== id);
      filteredData = filteredData.filter(x => x.id !== id);
      selectedIds.delete(id);
      loader.close(); updateBulkBar(); updateStats(); filterData();
      DKA.toast({ type:'success', title:'Unit Kerja Dihapus', message:`"${d.nama}" berhasil dihapus.`, position:'top-right' });
    }, 1200);
  });
}

/* ════════════════════════════════════
   DETAIL DRAWER
════════════════════════════════════ */
function openDrawer(id) {
  const d = DATA.find(x => x.id === id); if (!d) return;
  const grad = GRADS[d.gradId] || GRADS[0];
  const inits = d.sing.replace(/[^A-Za-z0-9]/g,'').slice(0,3).toUpperCase();
  const jClass = JENIS_MAP[d.jenis] || 'jb-default';

  document.getElementById('drawerBody').innerHTML = `
    <div class="d-hero" style="background:${grad};">
      <div class="d-hero-watermark">${inits}</div>
      <div class="d-hero-logo"><i class="bi ${d.icon}"></i></div>
      <div class="d-hero-info">
        <div class="d-hero-name">${d.nama}</div>
        <div class="d-hero-sing">${d.sing} · ${d.jenis}</div>
      </div>
    </div>

    <div class="d-section">
      <div class="d-stat-grid">
        <div class="d-stat-box"><div class="d-stat-val">${d.kegiatan}</div><div class="d-stat-lbl">Kegiatan</div></div>
        <div class="d-stat-box"><div class="d-stat-val">${d.pengguna}</div><div class="d-stat-lbl">Pengguna</div></div>
        <div class="d-stat-box"><div class="d-stat-val">${d.foto}</div><div class="d-stat-lbl">Foto</div></div>
      </div>

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
        <div><div class="d-lbl">Email</div><div class="d-val"><a href="mailto:${d.email}">${d.email}</a></div></div>
      </div>` : ''}

      ${d.web ? `
      <div class="d-row">
        <div class="d-icon"><i class="bi bi-globe"></i></div>
        <div><div class="d-lbl">Website</div><div class="d-val"><a href="${d.web}" target="_blank">${d.web}</a></div></div>
      </div>` : ''}

      ${d.desc ? `
      <div class="d-divider"></div>
      <div class="d-sec-title">Tupoksi / Deskripsi</div>
      <div style="font-size:.855rem;color:var(--c-text-2);line-height:1.78;background:var(--c-surface2);border:1px solid var(--c-border);border-radius:10px;padding:14px;">
        ${d.desc}
      </div>` : ''}
    </div>`;

  document.getElementById('drawerEditBtn').onclick   = () => { closeDrawer(); setTimeout(() => openEditModal(id), 220); };
  document.getElementById('drawerDeleteBtn').onclick = () => deleteUK(id);
  document.getElementById('drawerOverlay').classList.add('show');
}

function closeDrawer() { document.getElementById('drawerOverlay').classList.remove('show'); }

/* ════════════════════════════════════
   EXPORT
════════════════════════════════════ */
function doExport() {
  const l = DKA.loading({ title:'Membuat file export...', message:'Menyiapkan data unit kerja.', style:'dots' });
  setTimeout(() => {
    l.close();
    DKA.toast({ type:'success', title:'Export Berhasil!', message:`unit-kerja-${new Date().toISOString().slice(0,10)}.xlsx siap diunduh.`, position:'top-right', duration:5000 });
  }, 1500);
}

/* ── INIT ── */
document.addEventListener('DOMContentLoaded', () => {
  updateStats();
  filterData();
  
  const modalUK = document.getElementById('modalUK');
  if (modalUK) {
    modalUK.addEventListener('click', e => { if (e.target === modalUK) closeModal(); });
  }
  
  const drawerOverlay = document.getElementById('drawerOverlay');
  if (drawerOverlay) {
    drawerOverlay.addEventListener('click', e => { if (e.target === drawerOverlay) closeDrawer(); });
  }
});
