/* ════════════════════════════════════
   DATA (Dummy for now)
════════════════════════════════════ */
let DATA = [
    { id:1, nama:'Rapat / Koordinasi', slug:'rapat-koordinasi', desc:'Kegiatan rapat internal maupun koordinasi antar instansi pemerintah.',        icon:'bi-people-fill',              grad:'linear-gradient(135deg,#4f46e5,#7c3aed)', gradId:0,  kegiatan:72, foto:312, status:'active',   urutan:1 },
    { id:2, nama:'Pelatihan / Workshop', slug:'pelatihan-workshop', desc:'Kegiatan pelatihan, bimbingan teknis, dan workshop pengembangan SDM.',    icon:'bi-book-fill',                grad:'linear-gradient(135deg,#10b981,#06b6d4)', gradId:1,  kegiatan:45, foto:198, status:'active',   urutan:2 },
    { id:3, nama:'Kunjungan / Studi Banding', slug:'kunjungan-studi-banding', desc:'Kunjungan lapangan dan studi banding ke instansi lain.',         icon:'bi-geo-alt-fill',             grad:'linear-gradient(135deg,#f59e0b,#f97316)', gradId:2,  kegiatan:31, foto:145, status:'active',   urutan:3 },
    { id:4, nama:'Sosialisasi / Diseminasi', slug:'sosialisasi-diseminasi', desc:'Sosialisasi program, kebijakan, dan informasi kepada masyarakat.', icon:'bi-megaphone-fill',           grad:'linear-gradient(135deg,#06b6d4,#3b82f6)', gradId:3,  kegiatan:28, foto:97,  status:'active',   urutan:4 },
    { id:5, nama:'Upacara / Seremonial', slug:'upacara-seremonial', desc:'Upacara bendera, peringatan hari besar, dan kegiatan seremonial.',         icon:'bi-flag-fill',                grad:'linear-gradient(135deg,#ec4899,#f472b6)', gradId:4,  kegiatan:18, foto:124, status:'active',   urutan:5 },
    { id:6, nama:'Pameran / Expo', slug:'pameran-expo', desc:'Kegiatan pameran produk, expo teknologi, dan gelar karya.',                            icon:'bi-shop-window',              grad:'linear-gradient(135deg,#8b5cf6,#a78bfa)', gradId:5,  kegiatan:9,  foto:67,  status:'active',   urutan:6 },
    { id:7, nama:'Olahraga / Kesehatan', slug:'olahraga-kesehatan', desc:'Senam pagi, jalan sehat, dan kegiatan olahraga lainnya.',                 icon:'bi-heart-fill',               grad:'linear-gradient(135deg,#ef4444,#f87171)', gradId:6,  kegiatan:14, foto:78,  status:'active',   urutan:7 },
    { id:8, nama:'Lainnya', slug:'lainnya', desc:'Kegiatan lain yang tidak masuk dalam kategori di atas.',                                           icon:'bi-three-dots-vertical',      grad:'linear-gradient(135deg,#64748b,#94a3b8)', gradId:7,  kegiatan:12, foto:48,  status:'inactive', urutan:8 },
];

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
   STATE
════════════════════════════════════ */
let filteredData = [...DATA];
let currentView  = 'card';
let currentPage  = 1;
const perPage    = 12;
let editingId    = null;
let selIcon      = 'bi-tags-fill';
let selColor     = 0;
let sortCol      = -1, sortAsc = true;

/* ════════════════════════════════════
   STATS
════════════════════════════════════ */
function updateStats() {
    const animC = (id, t) => {
        const el=document.getElementById(id); 
        if(!el) return;
        let c=0,i=t/50;
        const tm=setInterval(()=>{c+=i;if(c>=t){c=t;clearInterval(tm);}el.textContent=Math.floor(c).toLocaleString('id-ID');},16);
    };
    animC('sc1', DATA.length);
    animC('sc2', DATA.filter(d=>d.status==='active').length);
    animC('sc3', DATA.reduce((s,d)=>s+d.kegiatan,0));
    animC('sc4', DATA.reduce((s,d)=>s+d.foto,0));
}

/* ════════════════════════════════════
   FILTER
════════════════════════════════════ */
function filterData() {
    const q  = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const st = document.getElementById('filterStatus')?.value || '';
    filteredData = DATA.filter(d =>
        (!q  || d.nama.toLowerCase().includes(q) || d.slug.includes(q) || d.desc.toLowerCase().includes(q)) &&
        (!st || d.status === st)
    );
    currentPage = 1;
    render();
}

/* ════════════════════════════════════
   RENDER
════════════════════════════════════ */
function render() {
    if (currentView==='card') renderCards(); else renderTable();
}

function renderCards() {
    const grid  = document.getElementById('katGrid');
    const empty = document.getElementById('emptyCard');
    if(!grid || !empty) return;

    const slice = filteredData.slice((currentPage-1)*perPage, currentPage*perPage);
    if (!filteredData.length) { grid.innerHTML=''; empty.classList.remove('d-none'); renderCardPag(); return; }
    empty.classList.add('d-none');

    grid.innerHTML = slice.map(d => `
        <div class="kat-card" data-id="${d.id}">
            <div class="kat-card-bar" style="background:${d.grad};"></div>
            <div class="kat-card-body">
                <div class="kat-icon-wrap" style="background:${d.grad};">
                    <i class="bi ${d.icon}"></i>
                </div>
                <div class="kat-name">${d.nama}</div>
                <div class="kat-desc">${d.desc || '<span style="color:var(--c-border);font-style:italic;">Belum ada deskripsi</span>'}</div>
                <code class="kat-slug">${d.slug}</code>
                <div class="kat-stats">
                    <div class="kat-stat"><i class="bi bi-calendar3-fill" style="color:var(--c-primary);"></i> <span>${d.kegiatan}</span> kegiatan</div>
                    <div class="kat-stat"><i class="bi bi-images" style="color:var(--c-green);"></i> <span>${d.foto}</span> foto</div>
                </div>
            </div>
            <div class="kat-card-footer">
                <span class="kat-status ${d.status==='active'?'kat-status-active':'kat-status-inactive'}">
                    ${d.status==='active'?'Aktif':'Nonaktif'}
                </span>
                <div class="kat-actions">
                    <button class="kat-action-btn kat-btn-edit" onclick="openEditModal(${d.id})" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                    <button class="kat-action-btn kat-btn-toggle" onclick="toggleStatus(${d.id})" title="${d.status==='active'?'Nonaktifkan':'Aktifkan'}">
                        <i class="bi ${d.status==='active'?'bi-toggle-on':'bi-toggle-off'}"></i>
                    </button>
                    <button class="kat-action-btn kat-btn-delete" onclick="deleteKategori(${d.id})" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                </div>
            </div>
        </div>`).join('');
    renderCardPag();
}

function renderCardPag() {
    const total = Math.ceil(filteredData.length/perPage);
    const s=(currentPage-1)*perPage+1, e=Math.min(currentPage*perPage,filteredData.length);
    const info = document.getElementById('cardPageInfo');
    const pg = document.getElementById('cardPagination');
    if(!info || !pg) return;

    info.textContent = filteredData.length ? `Menampilkan ${s}–${e} dari ${filteredData.length} kategori` : '';
    if(total<=1){pg.innerHTML='';return;}
    let html=`<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}><i class="bi bi-chevron-left"></i></button>`;
    for(let i=1;i<=total;i++) html+=`<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
    html+=`<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===total?'disabled':''}><i class="bi bi-chevron-right"></i></button>`;
    pg.innerHTML=html;
}

function renderTable() {
    const tbody = document.getElementById('tableBody');
    const empty = document.getElementById('emptyTable');
    if(!tbody || !empty) return;

    const slice = filteredData.slice((currentPage-1)*perPage, currentPage*perPage);
    if (!filteredData.length) { tbody.innerHTML=''; empty.classList.remove('d-none'); renderTablePag(); return; }
    empty.classList.add('d-none');
    tbody.innerHTML = slice.map((d,i) => `
        <tr>
            <td style="font-family:'DM Mono',monospace;color:var(--c-muted);font-size:.78rem;">${(currentPage-1)*perPage+i+1}</td>
            <td>
                <div class="tbl-kat-cell">
                    <div class="tbl-icon-sm" style="background:${d.grad};"><i class="bi ${d.icon}"></i></div>
                    <div>
                        <div class="tbl-kat-name">${d.nama}</div>
                        <div class="tbl-kat-slug">${d.desc||''}</div>
                    </div>
                </div>
            </td>
            <td><code style="font-family:'DM Mono',monospace;font-size:.75rem;background:var(--c-surface2);padding:3px 8px;border-radius:5px;">${d.slug}</code></td>
            <td style="font-weight:700;text-align:center;">${d.kegiatan}</td>
            <td style="font-weight:700;text-align:center;">${d.foto}</td>
            <td>
                <span class="kat-status ${d.status==='active'?'kat-status-active':'kat-status-inactive'}">
                    ${d.status==='active'?'Aktif':'Nonaktif'}
                </span>
            </td>
            <td>
                <div class="tbl-actions">
                    <button class="tbl-btn tbl-edit"   onclick="openEditModal(${d.id})" title="Edit"><i class="bi bi-pencil-fill"></i></button>
                    <button class="tbl-btn tbl-toggle" onclick="toggleStatus(${d.id})"  title="Toggle Status"><i class="bi ${d.status==='active'?'bi-toggle-on':'bi-toggle-off'}"></i></button>
                    <button class="tbl-btn tbl-delete" onclick="deleteKategori(${d.id})" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
                </div>
            </td>
        </tr>`).join('');
    
    const s=(currentPage-1)*perPage+1, e=Math.min(currentPage*perPage,filteredData.length);
    const meta = document.getElementById('tableMeta');
    const info = document.getElementById('pageInfo');
    if(meta) meta.textContent=`${filteredData.length} kategori`;
    if(info) info.textContent=filteredData.length?`Menampilkan ${s}–${e} dari ${filteredData.length}`:'';
    renderTablePag();
}

function renderTablePag() {
    const total=Math.ceil(filteredData.length/perPage);
    const pg=document.getElementById('pagination');
    if(!pg) return;
    if(total<=1){pg.innerHTML='';return;}
    let html=`<button class="page-btn" onclick="goPage(${currentPage-1})" ${currentPage===1?'disabled':''}><i class="bi bi-chevron-left"></i></button>`;
    for(let i=1;i<=total;i++) html+=`<button class="page-btn ${i===currentPage?'active':''}" onclick="goPage(${i})">${i}</button>`;
    html+=`<button class="page-btn" onclick="goPage(${currentPage+1})" ${currentPage===total?'disabled':''}><i class="bi bi-chevron-right"></i></button>`;
    pg.innerHTML=html;
}

function goPage(p) {
    const total=Math.ceil(filteredData.length/perPage);
    if(p<1||p>total) return;
    currentPage=p; render();
    window.scrollTo({top:0,behavior:'smooth'});
}

/* ════════════════════════════════════
   SORT TABLE
════════════════════════════════════ */
function sortTable(col) {
    if(sortCol===col) sortAsc=!sortAsc; else{sortCol=col;sortAsc=true;}
    const keys=['nama','slug','kegiatan','foto','status'];
    filteredData.sort((a,b)=>{
        const av=String(a[keys[col]]), bv=String(b[keys[col]]);
        return sortAsc?av.localeCompare(bv,undefined,{numeric:true}):bv.localeCompare(av,undefined,{numeric:true});
    });
    currentPage=1; renderTable();
    document.querySelectorAll('.kat-table thead th .sort-icon').forEach((ic,i)=>{
        ic.className='sort-icon bi '+(i===col?(sortAsc?'bi-sort-down-alt':'bi-sort-up'):'bi-chevron-expand');
        ic.closest('th').classList.toggle('sorted',i===col);
    });
}

/* ════════════════════════════════════
   VIEW TOGGLE
════════════════════════════════════ */
function setView(v) {
    currentView=v; currentPage=1;
    document.getElementById('btnCardView')?.classList.toggle('active',v==='card');
    document.getElementById('btnTableView')?.classList.toggle('active',v==='table');
    
    const cardWrap = document.getElementById('cardViewWrap');
    const tableWrap = document.getElementById('tableViewWrap');
    const cardPag = document.getElementById('cardPagWrap');

    if(cardWrap) cardWrap.style.display  = v==='card'  ? '':'none';
    if(tableWrap) tableWrap.style.display = v==='table' ? '':'none';
    if(cardPag) cardPag.style.display   = v==='card'  ? '':'none';
    render();
}

/* ════════════════════════════════════
   BUILD ICON & COLOR GRIDS
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
   MODAL OPEN/CLOSE
════════════════════════════════════ */
function openAddModal() {
    editingId = null;
    selIcon  = 'bi-tags-fill';
    selColor = 0;
    
    const title = document.getElementById('modalTitleText');
    const headIconI = document.getElementById('modalHeadIconI');
    const headIcon = document.getElementById('modalHeadIcon');
    const btn = document.getElementById('btnSaveKat');
    const previewIcon = document.getElementById('previewIcon');
    const previewBox = document.getElementById('previewBox');
    const previewName = document.getElementById('previewName');
    const previewSlug = document.getElementById('previewSlug');

    if(title) title.textContent = 'Tambah Kategori';
    if(headIconI) headIconI.className = 'bi bi-tags-fill';
    if(headIcon) headIcon.style.background = COLORS[0].grad;
    if(btn) btn.innerHTML = '<i class="bi bi-check2-circle"></i> Simpan Kategori';
    if(previewIcon) previewIcon.className = 'bi bi-tags-fill';
    if(previewBox) previewBox.style.background = COLORS[0].grad;
    if(previewName) previewName.textContent = 'Nama Kategori';
    if(previewSlug) previewSlug.textContent = 'nama-kategori';
    
    ['f-nama','f-slug','f-desc'].forEach(id=>{ 
        const el=document.getElementById(id); 
        if(el) el.value=''; 
    });
    
    document.querySelectorAll('.fgroup').forEach(g=>g.classList.remove('has-err'));
    buildIconGrid(); 
    buildColorGrid();
    openModal('modalKat');
}

function openEditModal(id) {
    const d = DATA.find(x=>x.id===id); 
    if(!d) return;
    editingId = id;
    selIcon   = d.icon;
    selColor  = d.gradId;
    
    const title = document.getElementById('modalTitleText');
    const headIconI = document.getElementById('modalHeadIconI');
    const headIcon = document.getElementById('modalHeadIcon');
    const btn = document.getElementById('btnSaveKat');
    const previewIcon = document.getElementById('previewIcon');
    const previewBox = document.getElementById('previewBox');
    const previewName = document.getElementById('previewName');
    const previewSlug = document.getElementById('previewSlug');
    const fNama = document.getElementById('f-nama');
    const fSlug = document.getElementById('f-slug');
    const fDesc = document.getElementById('f-desc');

    if(title) title.textContent = 'Edit Kategori';
    if(headIconI) headIconI.className = `bi ${d.icon}`;
    if(headIcon) headIcon.style.background = d.grad;
    if(btn) btn.innerHTML = '<i class="bi bi-check2-circle"></i> Perbarui Kategori';
    if(previewIcon) previewIcon.className = `bi ${d.icon}`;
    if(previewBox) previewBox.style.background = d.grad;
    if(previewName) previewName.textContent = d.nama;
    if(previewSlug) previewSlug.textContent = d.slug;
    if(fNama) fNama.value = d.nama;
    if(fSlug) fSlug.value = d.slug;
    if(fDesc) fDesc.value = d.desc||'';
    
    document.querySelectorAll('.fgroup').forEach(g=>g.classList.remove('has-err'));
    buildIconGrid(); 
    buildColorGrid();
    openModal('modalKat');
}

function openModal(id) { 
    document.getElementById(id)?.classList.add('show'); 
    document.body.style.overflow='hidden'; 
}
function closeModal(id) { 
    document.getElementById(id)?.classList.remove('show'); 
    document.body.style.overflow=''; 
}

/* ════════════════════════════════════
   NAMA → SLUG AUTO
════════════════════════════════════ */
window.onNamaInput = function(val) {
    const slug = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/\s+/g,'-').replace(/-+/g,'-').trim();
    const fSlug = document.getElementById('f-slug');
    const pName = document.getElementById('previewName');
    const pSlug = document.getElementById('previewSlug');
    
    if(fSlug) fSlug.value = slug;
    if(pName) pName.textContent = val || 'Nama Kategori';
    if(pSlug) pSlug.textContent = slug || 'nama-kategori';
};

window.updatePreview = function() {
    const pSlug = document.getElementById('previewSlug');
    const fSlug = document.getElementById('f-slug');
    if(pSlug) pSlug.textContent = fSlug?.value || 'nama-kategori';
};

/* ════════════════════════════════════
   VALIDATE & SAVE
════════════════════════════════════ */
window.clearErr = function(id) { document.getElementById(id)?.classList.remove('has-err'); };
function setErr(id)   { document.getElementById(id)?.classList.add('has-err'); }

window.saveKategori = function() {
    const nama = document.getElementById('f-nama')?.value.trim();
    const slug = document.getElementById('f-slug')?.value.trim();
    let ok = true;
    if(!nama) { setErr('grp-nama'); ok=false; } else clearErr('grp-nama');
    if(!slug) { setErr('grp-slug'); ok=false; } else clearErr('grp-slug');
    
    if(!ok) { 
        if(window.DKA) DKA.toast({type:'danger',title:'Form belum lengkap',message:'Harap isi semua field wajib.',position:'top-right'}); 
        return; 
    }

    const btn = document.getElementById('btnSaveKat');
    if(btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
    }

    setTimeout(()=>{
        if(btn) btn.disabled = false;
        const grad = COLORS[selColor].grad;
        if(editingId) {
            const d=DATA.find(x=>x.id===editingId);
            d.nama=nama; d.slug=slug; d.desc=document.getElementById('f-desc').value.trim();
            d.icon=selIcon; d.grad=grad; d.gradId=selColor;
            if(btn) btn.innerHTML = '<i class="bi bi-check2-circle"></i> Perbarui Kategori';
            if(window.DKA) DKA.toast({type:'success',title:'Kategori Diperbarui!',message:`"${nama}" berhasil diperbarui.`,position:'top-right',duration:4000});
        } else {
            DATA.push({ id:Date.now(), nama, slug, desc:document.getElementById('f-desc').value.trim(), icon:selIcon, grad, gradId:selColor, kegiatan:0, foto:0, status:'active', urutan:DATA.length+1 });
            if(btn) btn.innerHTML = '<i class="bi bi-check2-circle"></i> Simpan Kategori';
            if(window.DKA) DKA.toast({type:'success',title:'Kategori Ditambahkan!',message:`"${nama}" berhasil ditambahkan.`,position:'top-right',duration:4000});
        }
        updateStats(); 
        filterData(); 
        closeModal('modalKat');
    }, 1100);
};

/* ════════════════════════════════════
   TOGGLE STATUS
════════════════════════════════════ */
window.toggleStatus = function(id) {
    const d=DATA.find(x=>x.id===id); 
    if(!d) return;
    const action = d.status==='active' ? 'nonaktifkan' : 'aktifkan';
    
    if(window.DKA) {
        DKA.dialog({
            type   : d.status==='active'?'warning':'success',
            title  : d.status==='active'?'Nonaktifkan Kategori?':'Aktifkan Kategori?',
            message: `Kategori "<strong>${d.nama}</strong>" akan di${action}. Kegiatan yang sudah menggunakan kategori ini tidak terpengaruh.`,
            confirm: `Ya, ${action.charAt(0).toUpperCase()+action.slice(1)}`,
        }).then(result=>{
            if(!result) return;
            d.status = d.status==='active'?'inactive':'active';
            updateStats(); filterData();
            DKA.toast({type:d.status==='active'?'success':'info',title:`Kategori ${d.status==='active'?'Diaktifkan':'Dinonaktifkan'}`,message:`"${d.nama}" berhasil di${action}kan.`,position:'top-right'});
        });
    }
};

/* ════════════════════════════════════
   DELETE
════════════════════════════════════ */
window.deleteKategori = function(id) {
    const d=DATA.find(x=>x.id===id); 
    if(!d) return;
    
    if(window.DKA) {
        DKA.deleteConfirm({
            title   : 'Hapus Kategori?',
            message : d.kegiatan>0
                ? `Kategori ini digunakan oleh <strong>${d.kegiatan} kegiatan</strong>. Hapus kategori ini tidak akan menghapus kegiatannya, namun kategori akan dihapus dari sana.`
                : 'Kategori ini belum memiliki kegiatan. Aman untuk dihapus.',
            itemName: `${d.icon.replace('bi-','')} ${d.nama}`,
            confirm : 'Ya, Hapus Kategori',
        }).then(result=>{
            if(!result) return;
            const loader=DKA.loading({title:'Menghapus kategori...',message:'Membersihkan data terkait.',style:'dots'});
            setTimeout(()=>{
                DATA=DATA.filter(x=>x.id!==id);
                filteredData=filteredData.filter(x=>x.id!==id);
                loader.close(); updateStats(); filterData();
                DKA.toast({type:'success',title:'Kategori Dihapus',message:`"${d.nama}" berhasil dihapus.`,position:'top-right'});
            },1200);
        });
    }
};

/* Init */
document.addEventListener('DOMContentLoaded', () => {
    updateStats();
    filterData();
    
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
