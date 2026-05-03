/* ════════════════════════════════════
   HISTORY DATA & CONFIG
════════════════════════════════════ */
const HIST_TYPES = {
  'laporan-bulanan': { cls:'htp-bulanan',  label:'Laporan Bulanan', icon:'bi-bar-chart-fill', grad:'linear-gradient(135deg,#4f46e5,#7c3aed)' },
  'daftar-kegiatan': { cls:'htp-kegiatan', label:'Daftar Kegiatan', icon:'bi-calendar3-fill', grad:'linear-gradient(135deg,#10b981,#06b6d4)' },
  'galeri-foto'    : { cls:'htp-galeri',   label:'Galeri Foto',     icon:'bi-images',          grad:'linear-gradient(135deg,#ec4899,#f472b6)' },
  'rekap-unit'     : { cls:'htp-rekap',    label:'Rekap Unit',      icon:'bi-building-fill',   grad:'linear-gradient(135deg,#f59e0b,#f97316)' },
  'detail-kegiatan': { cls:'htp-purple',   label:'Detail Kegiatan', icon:'bi-file-text-fill',  grad:'linear-gradient(135deg,#7c3aed,#a78bfa)' },
  'kustom'         : { cls:'htp-kustom',   label:'Kustom',          icon:'bi-sliders2',        grad:'linear-gradient(135deg,#64748b,#94a3b8)' },
};

const BULAN_STR = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

let HISTORY = typeof INITIAL_HISTORY !== 'undefined' ? INITIAL_HISTORY : [];
let selectedType = 'laporan-bulanan';

/* ════════════════════════════════════
   STATS COUNTER ANIMATION
════════════════════════════════════ */
function animC(id, t) {
  const el=document.getElementById(id); if(!el) return;
  let c=0, inc=t/50;
  if(t === 0) { el.textContent = '0'; return; }
  const tm=setInterval(()=>{ c+=inc; if(c>=t){c=t;clearInterval(tm);} el.textContent=Math.floor(c).toLocaleString('id-ID'); },16);
}

function updateStats() {
  animC('sc1', HISTORY.length);
  // Example logic for "Bulan Ini"
  const now = new Date();
  const thisMonth = HISTORY.filter(h => {
      const d = new Date(h.created_at);
      return d.getMonth() === now.getMonth() && d.getFullYear() === now.getFullYear();
  }).length;
  animC('sc2', thisMonth);
  
  // Total size (mocked if media not loaded yet)
  const totalSize = HISTORY.reduce((sum, h) => {
      const media = h.media?.[0];
      return sum + (media ? media.size / 1024 / 1024 : 0);
  }, 0);
  animC('sc3', Math.round(totalSize * 10) / 10);
  
  const today = HISTORY.filter(h => {
      const d = new Date(h.created_at);
      return d.toDateString() === now.toDateString();
  }).length;
  animC('sc4', today);
}

/* ════════════════════════════════════
   HISTORY TABLE
════════════════════════════════════ */
function formatWaktu(dateStr) {
    const d = new Date(dateStr);
    const now = new Date();
    const diff = now - d;
    const minutes = Math.floor(diff / 60000);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (minutes < 1) return 'Baru saja';
    if (minutes < 60) return `${minutes} menit lalu`;
    if (hours < 24) return `${hours} jam lalu`;
    if (days === 1) return 'Kemarin';
    if (days < 7) return `${days} hari lalu`;
    
    return d.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
}

function renderHistory() {
  const hCnt = document.getElementById('historyCount');
  const hBody = document.getElementById('historyBody');
  if(!hCnt || !hBody) return;

  hCnt.textContent = `${HISTORY.length} dokumen`;
  hBody.innerHTML = HISTORY.map(h => {
    const t = HIST_TYPES[h.type] || HIST_TYPES['kustom'];
    const media = h.media?.[0];
    const size = media ? (media.size / 1024 / 1024).toFixed(1) + ' MB' : '—';
    const downloadUrl = media ? media.original_url : '#';

    return `
      <tr>
        <td>
          <div class="ht-file">
            <div class="ht-file-icon" style="background:${t.grad};"><i class="bi ${t.icon}" style="font-size:.82rem;"></i></div>
            <div>
              <div class="ht-file-name">${h.title}</div>
              <div class="ht-file-size">${h.page_count} hal · ${size}</div>
            </div>
          </div>
        </td>
        <td><span class="ht-type-pill ${t.cls}">${t.label}</span></td>
        <td style="font-size:.82rem;white-space:nowrap;">${h.params?.bulan_mulai ? BULAN_STR[h.params.bulan_mulai] : ''} ${h.params?.tahun || ''}</td>
        <td><span style="font-family:'DM Mono',monospace;font-size:.78rem;font-weight:600;">${size}</span></td>
        <td style="font-size:.78rem;color:var(--c-muted);white-space:nowrap;">${formatWaktu(h.created_at)}</td>
        <td>
          <div class="ht-actions">
            <a href="${downloadUrl}" class="ht-btn htb-dl" target="_blank" title="Unduh"><i class="bi bi-download"></i></a>
            <button class="ht-btn htb-del" onclick="deleteHist('${h.id}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
          </div>
        </td>
      </tr>`;
  }).join('') || `<tr><td colspan="6" style="text-align:center;padding:32px;color:var(--c-muted);">Belum ada riwayat export.</td></tr>`;
}

/* ════════════════════════════════════
   DOC TYPE SELECTOR
════════════════════════════════════ */
const DOC_LABELS = {
  'laporan-bulanan': 'Laporan Kegiatan Bulanan',
  'daftar-kegiatan': 'Daftar Kegiatan',
  'galeri-foto'    : 'Album Foto Kegiatan',
  'rekap-unit'     : 'Rekap Per Unit Kerja',
  'detail-kegiatan': 'Detail Kegiatan',
  'kustom'         : 'Laporan Kustom',
};

function selectDocType(card, type) {
  document.querySelectorAll('.doc-type-card').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  selectedType = type;
  updatePreviewInfo();
}

/* ════════════════════════════════════
   PREVIEW INFO UPDATE (AJAX)
════════════════════════════════════ */
let previewTimeout = null;

function updatePreviewInfo() {
  const fBM = document.getElementById('fBulanMulai');
  const fBA = document.getElementById('fBulanAkhir');
  const fT  = document.getElementById('fTahun');
  const fU  = document.getElementById('fUnit');
  const fK  = document.getElementById('fKategori');
  const fS  = document.getElementById('fStatus');
  const fJ  = document.getElementById('fJudul');
  
  if(!fBM || !fBA || !fT || !fU || !fJ) return;

  const bulanM = +fBM.value;
  const bulanA = +fBA.value;
  const tahun  = fT.value;
  const unitText = fU.options[fU.selectedIndex]?.text || 'Semua Unit';
  const judul  = fJ.value;

  const bulanStr = bulanM === bulanA
    ? `${BULAN_STR[bulanM]} ${tahun}`
    : `${BULAN_STR[bulanM]}–${BULAN_STR[bulanA]} ${tahun}`;

  /* Update visual preview box (Client side part) */
  const docTitle = judul || DOC_LABELS[selectedType] || 'LAPORAN';
  document.getElementById('previewDocTitle').textContent = docTitle.toUpperCase();
  document.getElementById('previewDocPeriode').textContent = `Periode: ${bulanStr} — ${unitText}`;

  /* Toggle Options in Preview */
  const optWatermark = document.getElementById('optWatermark')?.checked;
  const optCharts = document.getElementById('optCharts')?.checked;
  const optPageNum = document.getElementById('optPageNum')?.checked;

  const previewEl = document.getElementById('pdfPreview');
  if(previewEl) {
      const watermarkEl = previewEl.querySelector('.pdf-watermark');
      if(watermarkEl) watermarkEl.style.display = optWatermark ? 'block' : 'none';
      
      const statsEl = previewEl.querySelector('.pdf-stat-row');
      if(statsEl) statsEl.style.opacity = optCharts ? '1' : '0';
      
      const pageNumEl = previewEl.querySelector('.pdf-page-num');
      if(pageNumEl) pageNumEl.style.opacity = optPageNum ? '1' : '0';
  }

  /* Quick info labels */
  document.getElementById('qiJenis').textContent   = DOC_LABELS[selectedType];
  document.getElementById('qiPeriode').textContent = bulanStr;
  document.getElementById('qiUnit').textContent    = unitText;

  // Debounce AJAX call for real stats
  if(previewTimeout) clearTimeout(previewTimeout);
  previewTimeout = setTimeout(() => {
    fetchPreviewStats({
        bulan_mulai: bulanM,
        bulan_akhir: bulanA,
        tahun: tahun,
        unit_id: fU.value,
        kategori_id: fK.value,
        status: fS.value
    });
  }, 500);
}

function fetchPreviewStats(filters) {
    const params = new URLSearchParams(filters).toString();
    fetch(`${EXPORT_PREVIEW_URL}?${params}`)
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                const data = res.data;
                // Update PDF Preview Stats
                const statVals = document.querySelectorAll('.pdf-stat-val');
                if(statVals.length >= 3) {
                    statVals[0].textContent = data.total_kegiatan;
                    statVals[1].textContent = data.total_foto;
                    statVals[2].textContent = data.unit_aktif;
                }
                
                // Update Quick Info Stats
                document.getElementById('qiData').textContent = `~${data.total_kegiatan} kegiatan, ${data.total_foto} foto`;
                // Estimation logic (mocked based on real counts)
                const estPages = Math.ceil(data.total_kegiatan / 4) + 1;
                document.getElementById('qiHalaman').textContent = `~${estPages} halaman`;
                document.getElementById('qiUkuran').textContent  = `~${(data.total_foto * 0.15 + 0.5).toFixed(1)} MB`;
                document.getElementById('qiWaktu').textContent   = `~${Math.ceil(data.total_kegiatan * 0.5 + 2)} detik`;
            }
        });
}

/* ════════════════════════════════════
   EXPORT PROCESS (AJAX)
════════════════════════════════════ */
const EXPORT_STEPS_CFG = [
  { icon:'bi-search',          label:'Memvalidasi parameter'    },
  { icon:'bi-database-fill',   label:'Mengambil data kegiatan'  },
  { icon:'bi-images',          label:'Memproses foto & gambar'  },
  { icon:'bi-graph-up-arrow',  label:'Membuat grafik statistik' },
  { icon:'bi-file-text-fill',  label:'Menyusun halaman PDF'     },
  { icon:'bi-file-zip-fill',   label:'Finalisasi & kompresi'    },
];

function doExport() {
  const btn = document.getElementById('btnExportNow');
  const fBM = document.getElementById('fBulanMulai');
  const fBA = document.getElementById('fBulanAkhir');
  const fT  = document.getElementById('fTahun');
  const fU  = document.getElementById('fUnit');
  const fK  = document.getElementById('fKategori');
  const fS  = document.getElementById('fStatus');
  const fJ  = document.getElementById('fJudul');

  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';

  /* Show progress UI */
  const progWrap = document.getElementById('exportProgress');
  progWrap.classList.add('show');
  const stepsEl = document.getElementById('epSteps');
  stepsEl.innerHTML = EXPORT_STEPS_CFG.map((s,i)=>`
    <div class="ep-step pending" id="step-${i}">
      <div class="ep-step-icon"><i class="bi ${s.icon}"></i></div>
      <div class="ep-step-label">${s.label}</div>
    </div>`).join('');

  const bar = document.getElementById('epBar');
  const pct = document.getElementById('epPct');
  
  // Real request to server
  const payload = {
      type: selectedType,
      title: fJ.value || DOC_LABELS[selectedType],
      filters: {
          bulan_mulai: fBM.value,
          bulan_akhir: fBA.value,
          tahun: fT.value,
          unit_id: fU.value,
          kategori_id: fK.value,
          status: fS.value
      },
      options: {
          include_photo: document.getElementById('optFoto')?.checked,
          show_chart: document.getElementById('optCharts')?.checked,
          show_page_number: document.getElementById('optPageNum')?.checked,
          use_watermark: document.getElementById('optWatermark')?.checked,
          include_cover: document.getElementById('optCover')?.checked,
          compress_image: document.getElementById('optCompress')?.checked
      }
  };

  /* Simulate steps animation while waiting for server */
  let currentStep = -1;
  const stepCount = EXPORT_STEPS_CFG.length;
  const stepInterval = setInterval(() => {
      if(currentStep >= 0) {
          document.getElementById(`step-${currentStep}`)?.classList.replace('active','done');
          const doneEl = document.getElementById(`step-${currentStep}`)?.querySelector('.ep-step-icon');
          if(doneEl) doneEl.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
      }
      currentStep++;
      if(currentStep < stepCount) {
          const stepEl = document.getElementById(`step-${currentStep}`);
          stepEl?.classList.replace('pending','active');
          const p = Math.round(((currentStep + 1) / stepCount) * 85); // Up to 85%
          bar.style.width = p + '%';
          pct.textContent = p + '%';
      } else {
          clearInterval(stepInterval);
      }
  }, 800);

  fetch(EXPORT_STORE_URL, {
      method: 'POST',
      headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(payload)
  })
  .then(res => res.json())
  .then(res => {
      if(res.success) {
          clearInterval(stepInterval);
          // Complete the bar
          bar.style.width = '100%';
          pct.textContent = '100%';
          
          setTimeout(() => {
              HISTORY.unshift(res.data);
              renderHistory();
              updateStats();
              
              document.getElementById('exportProgress').classList.remove('show');
              btn.disabled = false;
              btn.innerHTML = '<i class="bi bi-file-earmark-pdf-fill" style="font-size:1.1rem;"></i> Export PDF Sekarang';
              
              if (typeof DKA !== 'undefined') {
                DKA.notify({
                  type   : 'success',
                  title  : 'Export Berhasil! 🎉',
                  message: `${res.data.title} siap diunduh.`,
                  duration: 6000,
                });
              }
          }, 500);
      } else {
          clearInterval(stepInterval);
          alert('Error: ' + res.message);
          btn.disabled = false;
          btn.innerHTML = '<i class="bi bi-file-earmark-pdf-fill" style="font-size:1.1rem;"></i> Export PDF Sekarang';
      }
  })
  .catch(err => {
      clearInterval(stepInterval);
      console.error(err);
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-file-earmark-pdf-fill" style="font-size:1.1rem;"></i> Export PDF Sekarang';
  });
}

/* ════════════════════════════════════
   HISTORY ACTIONS (AJAX)
════════════════════════════════════ */
function deleteHist(id) {
  if (typeof DKA !== 'undefined') {
    DKA.deleteConfirm({ 
        title: 'Hapus Riwayat?', 
        message: 'File PDF akan dihapus permanen dari server.', 
        confirm: 'Ya, Hapus' 
    }).then(confirm => {
        if(!confirm) return;
        
        const url = EXPORT_DESTROY_URL.replace(':id', id);
        fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                HISTORY = HISTORY.filter(x => x.id !== id);
                renderHistory();
                updateStats();
                DKA.toast({ type:'success', title:'Dihapus', message:'Riwayat berhasil dihapus.' });
            }
        });
    });
  }
}

function previewFull() {
  const fBM = document.getElementById('fBulanMulai');
  const fBA = document.getElementById('fBulanAkhir');
  const fT  = document.getElementById('fTahun');
  const fU  = document.getElementById('fUnit');
  const fK  = document.getElementById('fKategori');
  const fS  = document.getElementById('fStatus');
  const fJ  = document.getElementById('fJudul');

  const params = new URLSearchParams({
      type: selectedType,
      title: fJ.value || DOC_LABELS[selectedType],
      bulan_mulai: fBM.value,
      bulan_akhir: fBA.value,
      tahun: fT.value,
      unit_id: fU.value,
      kategori_id: fK.value,
      status: fS.value,
      // Add Display Options
      include_photo: document.getElementById('optFoto')?.checked ? '1' : '0',
      show_chart: document.getElementById('optCharts')?.checked ? '1' : '0',
      show_page_number: document.getElementById('optPageNum')?.checked ? '1' : '0',
      use_watermark: document.getElementById('optWatermark')?.checked ? '1' : '0',
      include_cover: document.getElementById('optCover')?.checked ? '1' : '0'
  });

  if (typeof DKA !== 'undefined') {
    DKA.dialog({ 
        type:'info', 
        title:'Buka Preview?', 
        message:'Halaman preview akan dibuka di tab baru untuk melihat struktur dokumen.', 
        confirm:'Buka Sekarang' 
    }).then(confirm => {
        if(confirm) {
            window.open(`${EXPORT_PREVIEW_FULL_URL}?${params.toString()}`, '_blank');
        }
    });
  } else {
    window.open(`${EXPORT_PREVIEW_FULL_URL}?${params.toString()}`, '_blank');
  }
}

/* ════════════════════════════════════
   INIT
════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    document.body.classList.add('collapsed');
    
    updateStats();
    renderHistory();
    updatePreviewInfo();
    
    window.addEventListener('scroll',()=> {
        const fab = document.getElementById('fabBtn');
        if(fab) fab.classList.toggle('visible',window.scrollY>280);
    },{passive:true});
});

function scrollToTop(){window.scrollTo({top:0,behavior:'smooth'});}
