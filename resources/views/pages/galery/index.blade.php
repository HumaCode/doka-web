<x-master-layout title="Galeri Foto — DokaKegiatan">
    @push('css')
    <style>
        /* ═══════════════════════════════════
           GALLERY SPECIFIC STYLES
        ═══════════════════════════════════ */
        
        /* ─── Mini Stats ─── */
        .mini-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:22px; animation:fadeUp .45s ease .05s both; }
        .mini-stat { background:#fff; border:1px solid var(--c-border); border-radius:var(--radius-md); padding:16px 18px; display:flex; align-items:center; gap:14px; box-shadow:var(--shadow-sm); transition:transform var(--trans),box-shadow var(--trans); cursor:default; position:relative; overflow:hidden; }
        .mini-stat:hover { transform:translateY(-2px); box-shadow:var(--shadow-md); }
        .mini-stat::after { content:''; position:absolute; bottom:0; left:0; right:0; height:3px; }
        .ms1::after { background:linear-gradient(90deg,var(--c-primary),var(--c-secondary)); }
        .ms2::after { background:linear-gradient(90deg,var(--c-green),#34d399); }
        .ms3::after { background:linear-gradient(90deg,var(--c-accent),var(--c-orange)); }
        .ms4::after { background:linear-gradient(90deg,var(--c-pink),#f472b6); }
        .ms-icon { width:42px; height:42px; border-radius:11px; display:grid; place-items:center; font-size:1.15rem; color:#fff; flex-shrink:0; }
        .ms1 .ms-icon { background:linear-gradient(135deg,var(--c-primary),var(--c-secondary)); box-shadow:0 3px 10px rgba(79,70,229,.28); }
        .ms2 .ms-icon { background:linear-gradient(135deg,var(--c-green),#34d399); box-shadow:0 3px 10px rgba(16,185,129,.28); }
        .ms3 .ms-icon { background:linear-gradient(135deg,var(--c-accent),var(--c-orange)); box-shadow:0 3px 10px rgba(245,158,11,.28); }
        .ms4 .ms-icon { background:linear-gradient(135deg,var(--c-pink),#f472b6); box-shadow:0 3px 10px rgba(236,72,153,.28); }
        .ms-val { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.5rem; color:var(--c-text); line-height:1; }
        .ms-lbl { font-size:.75rem; color:var(--c-muted); font-weight:600; margin-top:2px; }

        /* ─── Toolbar ─── */
        .toolbar { display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:18px; animation:fadeUp .45s ease .1s both; }
        .toolbar-search { flex:1; min-width:200px; max-width:300px; position:relative; }
        .toolbar-search input { width:100%; padding:10px 14px 10px 38px; border:1.5px solid var(--c-border); border-radius:10px; font-size:.875rem; font-family:'Plus Jakarta Sans',sans-serif; background:#fff; color:var(--c-text); outline:none; transition:border-color var(--trans),box-shadow var(--trans); }
        .toolbar-search input:focus { border-color:var(--c-primary); box-shadow:0 0 0 3px rgba(79,70,229,.1); }
        .toolbar-search i { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--c-muted); pointer-events:none; }
        .toolbar-select { padding:10px 14px; border:1.5px solid var(--c-border); border-radius:10px; font-size:.875rem; font-family:'Plus Jakarta Sans',sans-serif; background:#fff; color:var(--c-text-2); outline:none; cursor:pointer; transition:border-color var(--trans); }
        .toolbar-select:focus { border-color:var(--c-primary); }
        .toolbar-right { margin-left:auto; display:flex; gap:8px; align-items:center; }
        .btn-tb { display:inline-flex; align-items:center; gap:7px; padding:10px 16px; border-radius:10px; font-size:.875rem; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; cursor:pointer; border:none; transition:transform var(--trans),box-shadow var(--trans); }
        .btn-tb:hover { transform:translateY(-1px); }
        .btn-upload { background:linear-gradient(135deg,var(--c-primary),var(--c-purple)); color:#fff; box-shadow:0 4px 12px rgba(79,70,229,.3); }
        .btn-upload:hover { box-shadow:0 6px 18px rgba(79,70,229,.45); }
        .btn-outline { background:#fff; color:var(--c-text-2); border:1.5px solid var(--c-border); }
        .btn-outline:hover { border-color:var(--c-primary); color:var(--c-primary); background:#f5f3ff; }

        /* View toggle */
        .view-toggle { display:flex; gap:0; border:1.5px solid var(--c-border); border-radius:10px; overflow:hidden; background:#fff; }
        .vbtn { width:38px; height:38px; border:none; background:transparent; cursor:pointer; display:grid; place-items:center; font-size:1rem; color:var(--c-muted); transition:background var(--trans),color var(--trans); }
        .vbtn.active { background:var(--c-primary); color:#fff; }
        .vbtn:hover:not(.active) { background:var(--c-surface2); color:var(--c-primary); }

        /* ─── Grid View ─── */
        .photo-grid {
          columns: 4;
          column-gap: 16px;
          animation: fadeUp .45s ease .15s both;
        }
        @media(max-width:1200px) { .photo-grid { columns: 3; } }
        @media(max-width:768px)  { .photo-grid { columns: 2; } }
        @media(max-width:480px)  { .photo-grid { columns: 1; } }

        .photo-item {
          break-inside: avoid;
          margin-bottom: 16px;
          border-radius: 18px; /* Softer rounded corners like in image */
          overflow: hidden;
          position: relative;
          cursor: pointer;
          border: none;
          transition: transform .3s cubic-bezier(.34,1.56,.64,1), box-shadow .3s;
          animation: photoIn .4s ease both;
        }
        @keyframes photoIn { from{opacity:0;transform:scale(.92)} to{opacity:1;transform:scale(1)} }
        .photo-item:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 12px 30px rgba(0,0,0,0.15); }

        .photo-content {
          width: 100%;
          display: flex;
          align-items: center;
          justify-content: center;
          position: relative;
        }

        .photo-emoji {
          font-size: 3.5rem;
          filter: drop-shadow(0 4px 8px rgba(0,0,0,0.12));
          transition: transform .3s ease;
        }
        .photo-item:hover .photo-emoji { transform: scale(1.2) rotate(5deg); }

        .photo-overlay {
          position: absolute; inset: 0;
          background: linear-gradient(to top, rgba(0,0,0,.6) 0%, transparent 60%);
          opacity: 0; transition: opacity .25s;
          display: flex; flex-direction: column; justify-content: flex-end;
          padding: 16px;
        }
        .photo-item:hover .photo-overlay { opacity: 1; }

        .photo-overlay-actions { display:flex; gap:8px; margin-bottom:10px; }
        .photo-ov-btn { width:34px; height:34px; border-radius:10px; border:none; cursor:pointer; display:grid; place-items:center; font-size:.9rem; color:#fff; transition:all .2s; }
        .pob-view   { background:rgba(255,255,255,.25); backdrop-filter:blur(8px); }
        .pob-dl     { background:rgba(16,185,129,.9); }
        .pob-delete { background:rgba(239,68,68,.9); }
        .photo-ov-btn:hover { transform:scale(1.15); }

        .photo-kegiatan { font-size:.78rem; font-weight:700; color:#fff; display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }
        .photo-date { font-size:.7rem; color:rgba(255,255,255,0.8); margin-top:2px; }

        .photo-main-badge {
          position: absolute; top: 12px; left: 12px;
          background: #3b82f6; /* Blue like in image */
          color: #fff; font-size: .65rem; font-weight: 800;
          padding: 4px 10px; border-radius: 99px;
          display: flex; align-items: center; gap: 4px;
          box-shadow: 0 4px 10px rgba(59,130,246,0.4);
          z-index: 10;
        }
        .photo-main-badge i { font-size: .6rem; }

        .photo-check-wrap {
          position: absolute; top: 8px; right: 8px;
          width: 22px; height: 22px; border-radius: 6px;
          background: rgba(255,255,255,.2); backdrop-filter: blur(4px);
          border: 2px solid rgba(255,255,255,.4);
          display: grid; place-items: center; cursor: pointer;
          transition: all var(--trans);
          opacity: 0;
        }
        .photo-item:hover .photo-check-wrap,
        .photo-item.checked .photo-check-wrap { opacity: 1; }
        .photo-item.checked .photo-check-wrap { background:var(--c-primary); border-color:var(--c-primary); }
        .photo-item.checked .photo-check-wrap::after { content:'\F26A'; font-family:'bootstrap-icons'; color:#fff; font-size:.7rem; }

        /* ─── List View ─── */
        .photo-list-card { background:#fff; border:1px solid var(--c-border); border-radius:var(--radius-md); box-shadow:var(--shadow-sm); overflow:hidden; animation:fadeUp .45s ease .15s both; }
        .photo-list-head { padding:14px 20px; border-bottom:1px solid var(--c-border); display:flex; align-items:center; justify-content:space-between; }
        .photo-list-title { font-family:'Nunito',sans-serif; font-weight:800; font-size:.95rem; color:var(--c-text); display:flex; align-items:center; gap:8px; }
        .photo-list-title i { color:var(--c-primary); }
        .list-row { display:flex; align-items:center; gap:14px; padding:12px 20px; border-bottom:1px solid var(--c-border); transition:background var(--trans); }
        .list-row:last-child { border-bottom:none; }
        .list-row:hover { background:rgba(79,70,229,.03); cursor:pointer; }
        .list-thumb-placeholder { width:64px; height:52px; border-radius:10px; display:grid; place-items:center; font-size:1.5rem; flex-shrink:0; }
        .list-info { flex:1; min-width:0; }
        .list-title { font-size:.875rem; font-weight:700; color:var(--c-text); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
        .list-meta  { font-size:.75rem; color:var(--c-muted); margin-top:3px; display:flex; gap:10px; flex-wrap:wrap; }
        .list-main-badge { flex-shrink:0; font-size:.62rem; font-weight:800; padding:3px 8px; border-radius:99px; background:linear-gradient(135deg,var(--c-primary),var(--c-secondary)); color:#fff; }
        .list-actions { display:flex; gap:4px; flex-shrink:0; }
        .list-btn { width:30px; height:30px; border-radius:8px; border:none; cursor:pointer; display:grid; place-items:center; font-size:.85rem; transition:all var(--trans); }
        .lb-view   { background:#eff6ff; color:var(--c-primary); }
        .lb-dl     { background:#f0fdf4; color:var(--c-green); }
        .lb-delete { background:#fef2f2; color:var(--c-red); }
        .lb-view:hover   { background:var(--c-primary); color:#fff; }
        .lb-dl:hover     { background:var(--c-green);   color:#fff; }
        .lb-delete:hover { background:var(--c-red);     color:#fff; }

        /* Selection bar */
        .selection-bar {
          position:fixed; bottom:28px; left:50%; transform:translateX(-50%);
          background:#1e293b; color:#fff;
          padding:12px 20px; border-radius:14px;
          display:flex; align-items:center; gap:12px;
          box-shadow:0 8px 32px rgba(0,0,0,.25);
          z-index:500; opacity:0; pointer-events:none;
          transition:opacity .25s, transform .25s;
          transform:translateX(-50%) translateY(20px);
          font-size:.85rem; font-weight:600;
        }
        .selection-bar.show { opacity:1; pointer-events:all; transform:translateX(-50%) translateY(0); }
        .sel-count { font-family:'DM Mono',monospace; font-size:.75rem; background:var(--c-primary); padding:2px 8px; border-radius:99px; }
        .sel-btn { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; border-radius:9px; border:none; cursor:pointer; font-size:.78rem; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; transition:all var(--trans); }
        .sel-dl    { background:var(--c-green);   color:#fff; }
        .sel-del   { background:var(--c-red);     color:#fff; }
        .sel-clear { background:rgba(255,255,255,.12); color:rgba(255,255,255,.8); }

        /* Lightbox */
        .lightbox { position:fixed; inset:0; z-index:2000; background:rgba(5,8,30,.96); backdrop-filter:blur(12px); display:flex; align-items:center; justify-content:center; opacity:0; pointer-events:none; transition:opacity .3s; }
        .lightbox.show { opacity:1; pointer-events:all; }
        .lb-close { position:fixed; top:20px; right:22px; width:44px; height:44px; border-radius:50%; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18); color:#fff; font-size:1.1rem; cursor:pointer; display:grid; place-items:center; transition:background var(--trans); z-index:2001; }
        .lb-nav { position:fixed; top:50%; transform:translateY(-50%); width:48px; height:48px; border-radius:50%; background:rgba(255,255,255,.1); border:1px solid rgba(255,255,255,.18); color:#fff; font-size:1.2rem; cursor:pointer; display:grid; place-items:center; z-index:2001; transition:background var(--trans); }
        .lb-prev { left:18px; }
        .lb-next { right:18px; }
        .lb-img-wrap { max-width:92vw; max-height:86vh; position:relative; }
        .lb-img { max-width:92vw; max-height:84vh; object-fit:contain; border-radius:14px; box-shadow:0 24px 80px rgba(0,0,0,.6); transform:scale(.88); opacity:0; transition:transform .38s cubic-bezier(.34,1.56,.64,1), opacity .28s; display:block; }
        .lightbox.show .lb-img { transform:scale(1); opacity:1; }
        .lb-bottom { position:fixed; bottom:0; left:0; right:0; padding:16px 80px 24px; background:linear-gradient(to top, rgba(5,8,30,.95), transparent); z-index:2001; }
        .lb-info { display:flex; align-items:center; gap:14px; margin-bottom:12px; }
        .lb-kegiatan { font-size:.9rem; font-weight:700; color:#fff; }
        .lb-date { font-size:.78rem; color:rgba(255,255,255,.6); }
        .lb-caption { font-size:.82rem; color:rgba(255,255,255,.7); margin-bottom:10px; }
        .lb-thumbs { display:flex; gap:6px; overflow-x:auto; padding-bottom:4px; }
        .lb-thumb { width:48px; height:40px; border-radius:6px; object-fit:cover; cursor:pointer; border:2px solid transparent; flex-shrink:0; opacity:.55; transition:all var(--trans); }
        .lb-thumb.active { border-color:var(--c-primary); opacity:1; }

        /* Modal */
        .modal-overlay { position:fixed; inset:0; background:rgba(15,23,42,.55); backdrop-filter:blur(6px); z-index:1000; display:grid; place-items:center; opacity:0; pointer-events:none; transition:opacity .25s; padding:16px; overflow-y:auto; }
        .modal-overlay.show { opacity:1; pointer-events:all; }
        .modal-box { background:#fff; border-radius:var(--radius-lg); box-shadow:var(--shadow-lg); width:100%; max-width:560px; transform:translateY(24px) scale(.96); transition:transform .3s cubic-bezier(.34,1.56,.64,1); }
        .modal-overlay.show .modal-box { transform:translateY(0) scale(1); }
        .modal-head { display:flex; align-items:center; justify-content:space-between; padding:18px 24px; border-bottom:1px solid var(--c-border); border-radius:var(--radius-lg) var(--radius-lg) 0 0; position:relative; }
        .modal-head::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; border-radius:var(--radius-lg) var(--radius-lg) 0 0; background:linear-gradient(90deg,var(--c-primary),var(--c-secondary),var(--c-pink)); }
        .modal-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.05rem; color:var(--c-text); display:flex; align-items:center; gap:10px; }
        .modal-title .m-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--c-primary),var(--c-purple)); display:grid; place-items:center; font-size:1rem; color:#fff; }
        .btn-close-m { width:32px; height:32px; border-radius:8px; border:none; background:var(--c-surface2); cursor:pointer; display:grid; place-items:center; color:var(--c-muted); font-size:.95rem; transition:all var(--trans); }
        .modal-body { padding:24px; max-height:calc(90vh - 140px); overflow-y:auto; }
        .modal-foot { padding:16px 24px; border-top:1px solid var(--c-border); display:flex; gap:10px; justify-content:flex-end; background:var(--c-surface2); border-radius:0 0 var(--radius-lg) var(--radius-lg); }

        .drop-zone { border:2px dashed var(--c-border); border-radius:14px; padding:36px 24px; text-align:center; cursor:pointer; transition:all var(--trans); background:var(--c-surface2); position:relative; margin-bottom:16px; }
        .drop-zone:hover, .drop-zone.drag-over { border-color:var(--c-primary); background:rgba(79,70,229,.04); transform:scale(1.01); }
        .drop-zone input { position:absolute; inset:0; opacity:0; cursor:pointer; }
        .drop-icon { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,var(--c-primary),var(--c-secondary)); display:grid; place-items:center; margin:0 auto 14px; font-size:1.6rem; color:#fff; box-shadow:0 6px 20px rgba(79,70,229,.3); }
        
        .fgroup { margin-bottom:14px; }
        .flabel { font-size:.8rem; font-weight:700; color:var(--c-text); margin-bottom:6px; display:flex; align-items:center; gap:5px; }
        .fctrl { width:100%; padding:11px 13px 11px 38px; border:1.5px solid var(--c-border); border-radius:10px; font-size:.875rem; font-family:'Plus Jakarta Sans',sans-serif; background:var(--c-surface2); color:var(--c-text); outline:none; transition:border-color var(--trans),box-shadow var(--trans),background var(--trans); }
        .fctrl:focus { border-color:var(--c-primary); box-shadow:0 0 0 3px rgba(79,70,229,.1); background:#fff; }
        .f-icon { position:absolute; left:13px; top:50%; transform:translateY(-50%); color:var(--c-muted); font-size:.9rem; pointer-events:none; }
        .fwrap { position:relative; }

        .upload-preview { display:grid; grid-template-columns:repeat(auto-fill,minmax(88px,1fr)); gap:8px; margin-top:12px; }
        .up-item { position:relative; aspect-ratio:1; border-radius:10px; overflow:hidden; border:1.5px solid var(--c-border); }
        .up-item img { width:100%; height:100%; object-fit:cover; display:block; }
        .up-item-rm { position:absolute; top:4px; right:4px; width:20px; height:20px; border-radius:50%; background:rgba(239,68,68,.85); border:none; cursor:pointer; display:grid; place-items:center; color:#fff; font-size:.6rem; }

        .btn-load-more { display:inline-flex; align-items:center; gap:8px; padding:12px 28px; border-radius:12px; border:1.5px solid var(--c-border); background:#fff; color:var(--c-text-2); font-family:'Plus Jakarta Sans',sans-serif; font-weight:700; font-size:.875rem; cursor:pointer; transition:all var(--trans); }
        .btn-load-more:hover { border-color:var(--c-primary); color:var(--c-primary); background:#f5f3ff; }

        @keyframes fadeUp { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    </style>
    @endpush

    <!-- Page Header -->
    <div class="page-header">
        <div class="ph-left">
            <h1><i class="bi bi-images"></i> Galeri Foto</h1>
            <p>Semua foto dokumentasi kegiatan dari seluruh unit kerja.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-images"></i> Galeri Foto</span>
        </nav>
    </div>

    <!-- Stats -->
    <div class="mini-stats">
        <div class="mini-stat ms1"><div class="ms-icon"><i class="bi bi-images"></i></div><div><div class="ms-val" id="sc1">0</div><div class="ms-lbl">Total Foto</div></div></div>
        <div class="mini-stat ms2"><div class="ms-icon"><i class="bi bi-calendar3-fill"></i></div><div><div class="ms-val" id="sc2">0</div><div class="ms-lbl">Dari Kegiatan</div></div></div>
        <div class="mini-stat ms3"><div class="ms-icon"><i class="bi bi-hdd-fill"></i></div><div><div class="ms-val" id="sc3">0</div><div class="ms-lbl">Total Ukuran (MB)</div></div></div>
        <div class="mini-stat ms4"><div class="ms-icon"><i class="bi bi-calendar-week-fill"></i></div><div><div class="ms-val" id="sc4">0</div><div class="ms-lbl">Upload Bulan Ini</div></div></div>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-search">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama kegiatan..." oninput="filterData()" />
        </div>
        <select class="toolbar-select" id="filterKegiatan" onchange="filterData()">
            <option value="">Semua Kegiatan</option>
        </select>
        <select class="toolbar-select" id="filterUnit" onchange="filterData()">
            <option value="">Semua Unit</option>
            <option value="Diskominfo">Diskominfo</option>
            <option value="Disdik">Disdik</option>
            <option value="Dinkes">Dinkes</option>
            <option value="Humas">Humas</option>
        </select>
        <div class="toolbar-right">
            <div class="view-toggle">
                <button class="vbtn active" id="btnGrid" onclick="setView('grid')" title="Grid View"><i class="bi bi-grid-3x2-gap-fill"></i></button>
                <button class="vbtn" id="btnList" onclick="setView('list')" title="List View"><i class="bi bi-list-ul"></i></button>
            </div>
            <button class="btn-tb btn-outline" onclick="downloadAll()"><i class="bi bi-download"></i> Unduh Semua</button>
            <button class="btn-tb btn-upload" onclick="openUploadModal()"><i class="bi bi-cloud-upload-fill"></i> Upload Foto</button>
        </div>
    </div>

    <!-- Grid View -->
    <div id="gridViewWrap">
        <div class="photo-grid" id="photoGrid"></div>
        <div class="empty-state d-none" id="emptyGrid" style="text-align:center; padding: 50px;">
            <div class="empty-icon" style="font-size: 3rem; color: var(--c-muted);"><i class="bi bi-image"></i></div>
            <h3>Tidak ada foto ditemukan</h3>
            <p>Coba ubah filter atau upload foto baru.</p>
        </div>
        <div class="load-more-wrap" id="loadMoreWrap" style="text-align:center; margin-top:20px;">
            <button class="btn-load-more" id="btnLoadMore" onclick="loadMore()">
                <i class="bi bi-arrow-down-circle lm-icon"></i>
                Muat Lebih Banyak
            </button>
        </div>
    </div>

    <!-- List View -->
    <div id="listViewWrap" style="display:none;">
        <div class="photo-list-card">
            <div class="photo-list-head">
                <div class="photo-list-title"><i class="bi bi-list-ul"></i> Daftar Foto</div>
                <span id="listCount" style="font-size:.78rem;color:var(--c-muted);"></span>
            </div>
            <div id="photoList"></div>
        </div>
    </div>

    <!-- Selection Bar -->
    <div class="selection-bar" id="selBar">
        <span class="sel-count" id="selCountText">0</span>
        <span style="font-size:.82rem;">foto dipilih</span>
        <button class="sel-btn sel-dl" onclick="downloadSelected()"><i class="bi bi-download"></i> Unduh</button>
        <button class="sel-btn sel-del" onclick="deleteSelected()"><i class="bi bi-trash3-fill"></i> Hapus</button>
        <button class="sel-btn sel-clear" onclick="clearSelection()"><i class="bi bi-x-lg"></i> Batal</button>
    </div>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <button class="lb-close" onclick="closeLightbox()"><i class="bi bi-x-lg"></i></button>
        <button class="lb-nav lb-prev" onclick="event.stopPropagation();navLb(-1)"><i class="bi bi-chevron-left"></i></button>
        <div class="lb-img-wrap" onclick="event.stopPropagation()">
            <img src="" id="lbImg" class="lb-img" alt="" />
        </div>
        <button class="lb-nav lb-next" onclick="event.stopPropagation();navLb(1)"><i class="bi bi-chevron-right"></i></button>
        <div class="lb-bottom">
            <div class="lb-info">
                <span class="lb-kegiatan" id="lbKegiatan"></span>
                <span class="lb-date" id="lbDate"></span>
            </div>
            <div class="lb-caption" id="lbCaption"></div>
            <div class="lb-thumbs" id="lbThumbs"></div>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal-overlay" id="modalUpload">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-title"><div class="m-icon"><i class="bi bi-cloud-upload-fill"></i></div> Upload Foto</div>
                <button class="btn-close-m" onclick="closeModal()"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
                <div class="drop-zone" id="dropZone" ondragover="dzOver(event)" ondragleave="dzLeave(event)" ondrop="dzDrop(event)">
                    <input type="file" id="fileInput" accept="image/*" multiple onchange="handleFiles(this.files)" />
                    <div class="drop-icon"><i class="bi bi-cloud-arrow-up-fill"></i></div>
                    <div class="drop-title">Drag & drop foto di sini</div>
                    <div class="drop-sub">atau klik untuk pilih dari perangkat</div>
                </div>
                <div class="upload-preview" id="uploadPreview"></div>
                <div style="margin-top:16px;">
                    <div class="fgroup">
                        <div class="flabel">Kegiatan <span class="req">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-calendar3-fill f-icon"></i>
                            <select class="fctrl" id="f-kegiatan">
                                <option value="">-- Pilih Kegiatan --</option>
                            </select>
                        </div>
                    </div>
                    <div class="fgroup">
                        <div class="flabel">Keterangan</div>
                        <div class="fwrap">
                            <i class="bi bi-card-text f-icon"></i>
                            <input type="text" class="fctrl" id="f-keterangan" placeholder="Keterangan singkat foto..." />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-m-secondary" onclick="closeModal()">Batal</button>
                <button class="btn-m-primary" id="btnUpload" onclick="doUpload()">Upload Sekarang</button>
            </div>
        </div>
    </div>

    @push('js')
    <script>
        const GRADS = [
            'linear-gradient(135deg,#4f46e5,#7c3aed)', 'linear-gradient(135deg,#10b981,#06b6d4)',
            'linear-gradient(135deg,#f59e0b,#f97316)', 'linear-gradient(135deg,#ec4899,#f472b6)',
            'linear-gradient(135deg,#8b5cf6,#a78bfa)', 'linear-gradient(135deg,#ef4444,#f87171)',
            'linear-gradient(135deg,#0891b2,#22d3ee)', 'linear-gradient(135deg,#059669,#34d399)'
        ];
        const EMOJIS = ['📷','📸','🎞','🖼','📅','👥','🏛','📋'];
        
        let ALL_PHOTOS = [];
        let filteredPhotos = [];
        let visibleCount = 24;
        let selectedIds = new Set();
        let currentView = 'grid';
        let lbIndex = 0;
        let lbPhotos = [];

        // Mock data generator
        function initMockData() {
            for(let i=1; i<=60; i++) {
                ALL_PHOTOS.push({
                    id: i,
                    kegiatan: `Kegiatan Contoh #${Math.ceil(i/5)}`,
                    kegiatanId: Math.ceil(i/5),
                    unit: ['Diskominfo', 'Disdik', 'Dinkes', 'Humas'][i%4],
                    bulan: '04',
                    tanggal: 'Mei 2024',
                    caption: `Dokumentasi foto ke-${i}`,
                    emoji: EMOJIS[i%8],
                    gradId: i%8,
                    isMain: i%10 === 1,
                    size: (Math.random() * 3 + 0.5).toFixed(1)
                });
            }
            filteredPhotos = [...ALL_PHOTOS];
            render();
            updateStats();
            
            // Fill kegiatan select
            const kSel = document.getElementById('filterKegiatan');
            const fKSel = document.getElementById('f-kegiatan');
            for(let i=1; i<=12; i++) {
                const opt = `<option value="${i}">Kegiatan Contoh #${i}</option>`;
                kSel.insertAdjacentHTML('beforeend', opt);
                fKSel.insertAdjacentHTML('beforeend', opt);
            }
        }

        function updateStats() {
            document.getElementById('sc1').textContent = ALL_PHOTOS.length;
            document.getElementById('sc2').textContent = 12;
            document.getElementById('sc3').textContent = Math.round(ALL_PHOTOS.reduce((s,p)=>s+parseFloat(p.size),0));
            document.getElementById('sc4').textContent = ALL_PHOTOS.length;
        }

        function filterData() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const kid = document.getElementById('filterKegiatan').value;
            const uid = document.getElementById('filterUnit').value;
            
            filteredPhotos = ALL_PHOTOS.filter(p => 
                (!q || p.kegiatan.toLowerCase().includes(q)) &&
                (!kid || p.kegiatanId == kid) &&
                (!uid || p.unit === uid)
            );
            visibleCount = 24;
            render();
        }

        function render() {
            if(currentView === 'grid') renderGrid(); else renderList();
        }

        function renderGrid() {
            const grid = document.getElementById('photoGrid');
            const slice = filteredPhotos.slice(0, visibleCount);
            lbPhotos = filteredPhotos;
            
            if(slice.length === 0) {
                grid.innerHTML = '';
                document.getElementById('emptyGrid').classList.remove('d-none');
                return;
            }
            document.getElementById('emptyGrid').classList.add('d-none');
            
            grid.innerHTML = slice.map((p, i) => {
                const aspect = getAspect(i);
                return `
                <div class="photo-item ${selectedIds.has(p.id)?'checked':''}" data-id="${p.id}" onclick="handleCardClick(event, ${i}, ${p.id})">
                    <div class="photo-content" style="background:${GRADS[p.gradId]}; padding-bottom:${aspect}%;">
                        <div style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center;">
                            <span class="photo-emoji">${p.emoji}</span>
                        </div>
                    </div>
                    ${p.isMain ? '<span class="photo-main-badge"><i class="bi bi-star-fill"></i> Utama</span>' : ''}
                    <div class="photo-check-wrap"></div>
                    <div class="photo-overlay">
                        <div class="photo-overlay-actions" onclick="event.stopPropagation()">
                            <button class="photo-ov-btn pob-view" onclick="openLightbox(${i})"><i class="bi bi-eye-fill"></i></button>
                            <button class="photo-ov-btn pob-delete" onclick="deletePhoto(${p.id})"><i class="bi bi-trash3-fill"></i></button>
                        </div>
                        <div class="photo-overlay-info">
                            <div class="photo-kegiatan">${p.kegiatan}</div>
                            <div class="photo-date"><i class="bi bi-calendar3"></i> ${p.tanggal} · ${p.unit}</div>
                        </div>
                    </div>
                </div>
            `}).join('');
            
            document.getElementById('loadMoreWrap').style.display = filteredPhotos.length > visibleCount ? 'block' : 'none';
        }

        function getAspect(i) {
            // Varying aspect ratios for masonry feel: 1:1, 4:3, 3:4, 3:2, 2:3
            const ratios = [100, 75, 125, 66, 110, 85, 140, 90];
            return ratios[i % ratios.length];
        }

        function renderList() {
            const list = document.getElementById('photoList');
            document.getElementById('listCount').textContent = `${filteredPhotos.length} foto`;
            lbPhotos = filteredPhotos;
            
            list.innerHTML = filteredPhotos.map((p, i) => `
                <div class="list-row" onclick="openLightbox(${i})">
                    <div class="list-thumb-placeholder" style="background:${GRADS[p.gradId]};">${p.emoji}</div>
                    <div class="list-info">
                        <div class="list-title">${p.kegiatan}</div>
                        <div class="list-meta">
                            <span><i class="bi bi-calendar3"></i> ${p.tanggal}</span>
                            <span><i class="bi bi-building"></i> ${p.unit}</span>
                        </div>
                    </div>
                    <div class="list-actions" onclick="event.stopPropagation()">
                        <button class="list-btn lb-view" onclick="openLightbox(${i})"><i class="bi bi-eye-fill"></i></button>
                        <button class="list-btn lb-delete" onclick="deletePhoto(${p.id})"><i class="bi bi-trash3-fill"></i></button>
                    </div>
                </div>
            `).join('');
        }

        function setView(v) {
            currentView = v;
            document.getElementById('btnGrid').classList.toggle('active', v==='grid');
            document.getElementById('btnList').classList.toggle('active', v==='list');
            document.getElementById('gridViewWrap').style.display = v==='grid' ? '' : 'none';
            document.getElementById('listViewWrap').style.display = v==='list' ? '' : 'none';
            render();
        }

        function loadMore() {
            visibleCount += 24;
            renderGrid();
        }

        function handleCardClick(e, idx, id) {
            if(e.ctrlKey || selectedIds.size > 0) {
                selectedIds.has(id) ? selectedIds.delete(id) : selectedIds.add(id);
                document.getElementById('selBar').classList.toggle('show', selectedIds.size > 0);
                document.getElementById('selCountText').textContent = selectedIds.size;
                render();
            } else {
                openLightbox(idx);
            }
        }

        function clearSelection() {
            selectedIds.clear();
            document.getElementById('selBar').classList.remove('show');
            render();
        }

        function openLightbox(idx) {
            lbIndex = idx;
            const p = lbPhotos[idx];
            document.getElementById('lbImg').src = `data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='800' height='600'><rect width='100%' height='100%' fill='gray'/><text x='50%' y='50%' font-size='100' text-anchor='middle'>${p.emoji}</text></svg>`;
            document.getElementById('lbKegiatan').textContent = p.kegiatan;
            document.getElementById('lbDate').textContent = p.tanggal;
            document.getElementById('lbCaption').textContent = p.caption;
            document.getElementById('lightbox').classList.add('show');
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('show');
        }

        function navLb(dir) {
            lbIndex = (lbIndex + dir + lbPhotos.length) % lbPhotos.length;
            openLightbox(lbIndex);
        }

        function openUploadModal() { document.getElementById('modalUpload').classList.add('show'); }
        function closeModal() { document.getElementById('modalUpload').classList.remove('show'); }
        
        function deletePhoto(id) {
            DKA.deleteConfirm({ title: 'Hapus Foto?', message: 'Foto akan dihapus permanen.' }).then(r => {
                if(r) {
                    ALL_PHOTOS = ALL_PHOTOS.filter(p => p.id !== id);
                    filterData();
                    DKA.toast({ type:'success', title:'Terhapus', message:'Foto berhasil dihapus' });
                }
            });
        }

        initMockData();
    </script>
    @endpush
</x-master-layout>
