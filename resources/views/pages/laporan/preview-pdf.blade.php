<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DokaKegiatan — Preview Dokumen PDF</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@700;800;900&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />

    <style>
        :root {
            --c-primary: #4f46e5;
            --c-secondary: #06b6d4;
            --c-accent: #f59e0b;
            --c-pink: #ec4899;
            --c-green: #10b981;
            --c-orange: #f97316;
            --c-red: #ef4444;
            --c-purple: #7c3aed;
            --c-border: #e2e8f0;
            --c-text: #1e293b;
            --c-muted: #94a3b8;
            --toolbar-h: 64px;
            --sidebar-w: 220px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; overflow: hidden; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #1e2329;
            color: var(--c-text);
            display: flex;
            flex-direction: column;
        }

        /* Toolbar */
        .preview-toolbar {
            height: var(--toolbar-h);
            background: #2d3139;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            display: flex; align-items: center;
            padding: 0 20px; gap: 12px;
            flex-shrink: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .tb-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; padding-right: 20px;
            border-right: 1px solid rgba(255, 255, 255, .1);
        }
        .tb-brand-icon {
            width: 34px; height: 34px; border-radius: 8px;
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            display: grid; place-items: center; color: #fff; font-size: .9rem;
        }
        .tb-brand-name {
            font-family: 'Nunito', sans-serif; font-weight: 900;
            font-size: 1rem; color: #fff;
        }
        .tb-brand-name span { color: var(--c-secondary); }

        .tb-doc-info { flex: 1; min-width: 0; padding: 0 15px; }
        .tb-doc-title { font-size: .9rem; font-weight: 800; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .tb-doc-meta { font-size: .7rem; color: rgba(255, 255, 255, .4); margin-top: 2px; }

        .page-nav {
            display: flex; align-items: center; gap: 8px;
            background: rgba(0,0,0,0.2); border-radius: 8px;
            padding: 4px 12px; border: 1px solid rgba(255,255,255,0.1);
        }
        .page-nav-btn {
            width: 28px; height: 28px; border-radius: 6px; border: none;
            background: transparent; color: #fff; cursor: pointer;
            display: grid; place-items: center; transition: all 0.2s;
        }
        .page-nav-btn:hover { background: rgba(255,255,255,0.1); }
        .page-nav-label { font-family: 'DM Mono', monospace; font-weight: 800; color: #fff; font-size: .9rem; }
        .page-nav-total { color: rgba(255,255,255,0.4); font-size: .75rem; }

        .tb-btn {
            height: 38px; border-radius: 10px; border: none; cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
            font-size: .85rem; font-weight: 700; padding: 0 16px;
            transition: all 0.2s;
        }
        .tbb-ghost { background: rgba(255,255,255,0.08); color: #fff; border: 1px solid rgba(255,255,255,0.15); }
        .tbb-ghost:hover { background: var(--c-primary); border-color: var(--c-primary); }
        .tbb-export { background: #ef4444; color: #fff; }

        .tb-divider { width: 1px; height: 24px; background: rgba(255,255,255,0.1); }

        /* Main Layout */
        .preview-main {
            display: flex;
            height: calc(100vh - var(--toolbar-h) - 28px);
            overflow: hidden;
            background: #1e2128;
        }

        /* Sidebar */
        .thumb-sidebar {
            width: var(--sidebar-w);
            background: #1a1f27;
            border-right: 1px solid rgba(255,255,255,0.05);
            overflow-y: auto;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .thumb-item {
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .thumb-page {
            width: 100%;
            aspect-ratio: 210/297;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            border: 2px solid transparent;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .thumb-item.active .thumb-page {
            border-color: var(--c-primary);
            box-shadow: 0 0 15px rgba(79, 70, 229, 0.4);
        }

        .thumb-info {
            margin-top: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 4px;
        }

        .thumb-num {
            background: #334155;
            color: #fff;
            font-size: 7pt;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .thumb-type {
            color: rgba(255,255,255,0.4);
            font-size: 6.5pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Canvas Area (Scrollable) */
        .canvas-area {
            flex: 1;
            overflow-y: auto;
            padding: 40px 20px 300px;
            background: #33373e;
            display: flex;
            flex-direction: column;
            align-items: center;
            scroll-behavior: smooth;
        }

        .page-wrapper {
            margin-bottom: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0.5;
            transition: opacity 0.3s ease;
            width: 100%;
        }

        .page-wrapper.active {
            opacity: 1;
        }

        .page-label {
            color: rgba(255,255,255,0.3);
            font-size: 7pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }

        /* PDF Page Base Style */
        .pdf-page {
            background: #fff;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            transform-origin: top center;
            position: relative;
            transition: transform 0.2s ease;
            flex-shrink: 0;
            overflow: hidden;
        }

        /* Size Variants */
        .size-a4 .pdf-page { width: 794px; min-height: 1123px; }
        .size-a4.orient-landscape .pdf-page { width: 1123px; min-height: 794px; }
        .size-a3 .pdf-page { width: 1123px; min-height: 1587px; }
        .size-a3.orient-landscape .pdf-page { width: 1587px; min-height: 1123px; }
        .size-f4 .pdf-page { width: 812px; min-height: 1247px; }
        .size-f4.orient-landscape .pdf-page { width: 1247px; min-height: 812px; }
        .size-letter .pdf-page { width: 816px; min-height: 1056px; }
        .size-letter.orient-landscape .pdf-page { width: 1056px; min-height: 816px; }

        /* Content Styles */
        .doc-page { padding: 0; color: #1e293b; font-size: 9pt; line-height: 1.5; min-height: 100%; display:flex; flex-direction:column; }
        .doc-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 45%, #ec4899 100%);
            padding: 28px 36px 24px;
            position: relative; overflow: hidden;
            color: #fff;
        }
        .doc-header::before {
            content: ''; position: absolute; inset: 0;
            background: repeating-linear-gradient(45deg, rgba(255, 255, 255, .04) 0, rgba(255, 255, 255, .04) 1px, transparent 0, transparent 50%);
            background-size: 14px 14px;
        }
        .doc-logo-row { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; position: relative; z-index: 1; }
        .doc-logo-box {
            width: 44px; height: 44px; border-radius: 10px;
            background: rgba(255, 255, 255, .2); backdrop-filter: blur(6px);
            display: grid; place-items: center; color: #fff; font-size: 1.2rem;
            border: 1px solid rgba(255, 255, 255, .3);
        }
        .doc-org-name { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 12pt; }
        .doc-org-sub { font-size: 8pt; color: rgba(255, 255, 255, .7); }
        .doc-title-box { text-align: center; position: relative; z-index: 1; }
        .doc-main-title { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 14pt; text-transform: uppercase; letter-spacing: 1px; }
        .doc-sub-title { font-size: 9pt; color: rgba(255, 255, 255, .8); }
        .doc-divider { height: 4px; background: linear-gradient(90deg, var(--c-primary), var(--c-secondary), var(--c-pink)); }
        
        .doc-body { padding: 30px 36px; flex: 1; position: relative; z-index: 1; }
        .doc-stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 25px; }
        .doc-stat-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; text-align: center; position: relative; overflow: hidden; }
        .doc-stat-box::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
        .dsb1::before { background: #4f46e5; }
        .dsb2::before { background: #10b981; }
        .dsb3::before { background: #f59e0b; }
        .dsb4::before { background: #ec4899; }
        .doc-stat-val { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 15pt; color: #1e293b; }
        .doc-stat-lbl { font-size: 7pt; color: #94a3b8; font-weight: 700; margin-top: 2px; }

        .doc-section-title {
            font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 10pt;
            color: #1e293b; border-bottom: 2px solid #4f46e5; padding-bottom: 6px;
            margin-bottom: 15px; display: flex; align-items: center; gap: 8px;
        }
        .doc-section-title i { color: #4f46e5; }

        .doc-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 8.5pt; }
        .doc-table thead th {
            background: #4f46e5; color: #fff; padding: 10px; font-weight: 800; text-align: left;
        }
        .doc-table tbody td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #475569; }

        .doc-footer {
            padding: 12px 36px; border-top: 1px solid #e2e8f0;
            display: flex; justify-content: space-between; align-items: center;
            background: #f8fafc;
        }
        .doc-footer-text { font-size: 7.5pt; color: #94a3b8; }

        /* Watermark KPK Style */
        .doc-watermark-text {
            position: absolute; inset: 0; pointer-events: none; z-index: 0; display: none;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='14' fill='rgba(239, 68, 68, 0.08)' font-family='Arial' font-weight='900' transform='rotate(-30 60 60)' text-anchor='middle'%3EDOKA%3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
        }
        .show-watermark .doc-watermark-text { display: block; }
        
        .feature-charts { display: block; }
        .hide-charts .feature-charts { display: none; }
        
        .feature-photo { display: table-cell; }
        .hide-photo .feature-photo { display: none; }

        .feature-footer { display: flex; }
        .hide-footer .feature-footer { display: none; }

        .feature-cover { display: none; }
        .show-cover .feature-cover { display: flex; }

        /* Zoom & Statusbar */
        .status-bar {
            height: 28px; background: #1a1f27; border-top: 1px solid rgba(255,255,255,0.05);
            display: flex; align-items: center; padding: 0 20px; gap: 20px;
            font-size: .7rem; color: rgba(255,255,255,0.3);
        }
        .sb-dot { width: 6px; height: 6px; border-radius: 50%; background: #10b981; }

        /* PRINT STYLES - Comprehensive */
        @media print {
            @page { 
                margin: 10mm; 
                size: auto; 
            }

            * { 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important; 
            }

            body { 
                background: white !important; 
                margin: 0 !important; 
                padding: 0 !important;
                overflow: visible !important;
            }

            /* Hide all UI chrome */
            .preview-toolbar, 
            .thumb-sidebar, 
            .sidebar-nav,
            .status-bar, 
            .page-label { 
                display: none !important; 
            }

            /* Make preview area flow naturally */
            .preview-main, 
            .canvas-area { 
                display: block !important; 
                height: auto !important; 
                overflow: visible !important; 
                padding: 0 !important;
                margin: 0 !important;
                background: white !important;
            }

            /* Each section gets its own page */
            .page-wrapper { 
                display: block !important; 
                opacity: 1 !important;
                margin: 0 !important; 
                padding: 0 !important;
                height: auto !important;
                width: 100% !important;
                page-break-after: always;
                page-break-inside: avoid;
            }

            .page-wrapper:last-of-type {
                page-break-after: auto;
            }

            /* Clean page appearance */
            .pdf-page { 
                box-shadow: none !important; 
                transform: none !important;
                margin: 0 !important;
                width: 100% !important;
                min-height: auto !important;
                border: none !important;
            }

            .doc-page {
                min-height: auto !important;
            }
        }
    </style>
</head>
<body class="size-a4 orient-portrait">

@php 
    $kegiatans = $kegiatans->sortBy('tanggal');
    if($type == 'rekap-unit') {
        $kegiatans = $kegiatans->sortBy('unit_id');
    }
    
    // Define perPage based on type (max 15 rows for tables = uniform print)
    if($type == 'galeri-foto') $perPage = 6;
    elseif($type == 'detail-kegiatan') $perPage = 3;
    else $perPage = 16;

    $chunks = $kegiatans->chunk($perPage);
    $showSummary = ($type != 'galeri-foto' && $type != 'daftar-kegiatan' && $type != 'detail-kegiatan');
    $totalPages = count($chunks) + ($showSummary ? 1 : 0) + 1; 
@endphp

<div class="preview-toolbar">
    <div class="tb-brand">
        <div class="tb-brand-icon"><i class="bi bi-camera-reels-fill"></i></div>
        <span class="tb-brand-name">Doka<span>Kegiatan</span></span>
    </div>

    <div class="tb-doc-info">
        <div class="tb-doc-title">{{ $title }}</div>
        <div class="tb-doc-meta">PDF Preview · {{ $totalPages }} Halaman</div>
    </div>

    <div class="page-nav">
        <button class="page-nav-btn" onclick="prevPage()"><i class="bi bi-chevron-left"></i></button>
        <span class="page-nav-label" id="currentPageLabel">1</span>
        <span class="page-nav-total">/ {{ $totalPages }}</span>
        <button class="page-nav-btn" onclick="nextPage()"><i class="bi bi-chevron-right"></i></button>
    </div>

    <div class="tb-divider"></div>

    <div style="display:flex; gap:8px;">
        <select class="form-select form-select-sm bg-dark text-white border-secondary" style="width:130px; font-size:.75rem;" onchange="updateLayout(this.value, 'size')">
            <option value="size-a4">A4 (210x297)</option>
            <option value="size-a3">A3 (297x420)</option>
            <option value="size-f4">F4 (215x330)</option>
        </select>
        <select class="form-select form-select-sm bg-dark text-white border-secondary" style="width:110px; font-size:.75rem;" onchange="updateLayout(this.value, 'orient')">
            <option value="orient-portrait">Portrait</option>
            <option value="orient-landscape">Landscape</option>
        </select>
    </div>

    <div class="tb-divider"></div>

    <div class="ms-auto d-flex gap-3 align-items-center">
        <div style="display:flex; gap:10px; color:#fff; font-size:.75rem; font-weight:700; background: rgba(0,0,0,0.2); padding: 5px 12px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
            <label class="d-flex align-items-center gap-2 cursor-pointer"><input type="checkbox" id="toggleCover" {{ request('include_cover') == '1' ? 'checked' : '' }} onchange="toggleFeature('cover', this.checked)"> Cover</label>
            <label class="d-flex align-items-center gap-2 cursor-pointer"><input type="checkbox" id="toggleCharts" {{ request('show_chart') != '0' ? 'checked' : '' }} onchange="toggleFeature('charts', this.checked)"> Chart</label>
            <label class="d-flex align-items-center gap-2 cursor-pointer"><input type="checkbox" id="togglePhoto" {{ request('include_photo') == '1' ? 'checked' : '' }} onchange="toggleFeature('photo', this.checked)"> Foto</label>
            <label class="d-flex align-items-center gap-2 cursor-pointer"><input type="checkbox" id="toggleFooter" {{ request('show_page_number') != '0' ? 'checked' : '' }} onchange="toggleFeature('footer', this.checked)"> Hal</label>
            <label class="d-flex align-items-center gap-2 cursor-pointer"><input type="checkbox" id="toggleWatermark" {{ request('use_watermark') == '1' ? 'checked' : '' }} onchange="toggleFeature('watermark', this.checked)"> Watermark</label>
        </div>
        
        <div class="tb-divider"></div>
        
        <div class="d-flex gap-2">
            <button class="tb-btn tbb-ghost" onclick="window.print()"><i class="bi bi-printer-fill"></i> Cetak</button>
            <button class="tb-btn tbb-export" onclick="window.close()"><i class="bi bi-x-lg"></i> Tutup</button>
        </div>
    </div>
</div>

<div class="preview-main">
    <div class="thumb-sidebar">
        {{-- Cover Thumb --}}
        <div class="thumb-item active feature-cover" onclick="showPage('cover')" id="thumb-cover">
            <div class="thumb-page" style="display:flex; flex-direction:column; align-items:center; justify-content:center; padding:10px;">
                <div style="width:30px; height:30px; background:linear-gradient(135deg, #4f46e5, #ec4899); border-radius:5px; margin-bottom:5px;"></div>
                <div style="width:80%; height:4px; background:#f1f5f9; margin-bottom:3px;"></div>
                <div style="width:60%; height:4px; background:#f1f5f9;"></div>
            </div>
            <div class="thumb-info"><span class="thumb-num">0</span><span class="thumb-type">COVER</span></div>
        </div>

        @if($showSummary)
        {{-- Ringkasan Thumb --}}
        <div class="thumb-item" onclick="showPage(1)" id="thumb-1">
            <div class="thumb-page">
                <div style="background:linear-gradient(90deg, #4f46e5, #7c3aed); height:15px; width:100%; margin-bottom:8px; display:grid; place-items:center;">
                    <i class="bi bi-bar-chart-fill" style="color:rgba(255,255,255,0.5); font-size:6pt;"></i>
                </div>
                <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:6px; padding:0 6px; margin-bottom:8px;">
                    <div style="background:#cbd5e1; height:18px; border-radius:3px;"></div>
                    <div style="background:#cbd5e1; height:18px; border-radius:3px;"></div>
                </div>
                <div style="padding:0 6px;">
                    <div style="background:#94a3b8; height:35px; width:100%; border-radius:3px; display:flex; align-items:flex-end; gap:3px; padding:3px;">
                        <div style="flex:1; height:30%; background:#64748b;"></div>
                        <div style="flex:1; height:90%; background:#4f46e5;"></div>
                        <div style="flex:1; height:50%; background:#64748b;"></div>
                        <div style="flex:1; height:70%; background:#4f46e5;"></div>
                    </div>
                </div>
            </div>
            <div class="thumb-info"><span class="thumb-num">1</span><span class="thumb-type">RINGKASAN</span></div>
        </div>
        @endif

        {{-- Data Chunks Thumbs --}}
        @foreach($chunks as $chunkIndex => $c)
        @php $thumbPage = $showSummary ? ($chunkIndex + 2) : ($chunkIndex + 1); @endphp
        <div class="thumb-item" onclick="showPage({{ $thumbPage }})" id="thumb-{{ $thumbPage }}">
            <div class="thumb-page">
                <div style="background:#06b6d4; height:12px; width:100%; margin-bottom:6px; display:grid; place-items:center;">
                    <i class="bi bi-file-earmark-text-fill" style="color:rgba(255,255,255,0.4); font-size:6pt;"></i>
                </div>
                @if($type == 'galeri-foto')
                    <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:6px; padding:4px 8px;">
                        <div style="aspect-ratio:1; background:#94a3b8; border-radius:3px; display:grid; place-items:center;"><i class="bi bi-image" style="color:#fff; font-size:6pt;"></i></div>
                        <div style="aspect-ratio:1; background:#64748b; border-radius:3px; display:grid; place-items:center;"><i class="bi bi-image" style="color:#fff; font-size:6pt;"></i></div>
                        <div style="aspect-ratio:1; background:#475569; border-radius:3px; display:grid; place-items:center;"><i class="bi bi-image" style="color:#fff; font-size:6pt;"></i></div>
                        <div style="aspect-ratio:1; background:#94a3b8; border-radius:3px; display:grid; place-items:center;"><i class="bi bi-image" style="color:#fff; font-size:6pt;"></i></div>
                    </div>
                @elseif($type == 'detail-kegiatan')
                    <div style="padding:6px 8px; display:flex; flex-direction:column; gap:8px;">
                        @for($i=0; $i<2; $i++)
                            <div style="display:flex; gap:6px;">
                                <div style="width:35px; height:25px; background:#94a3b8; border-radius:3px;"></div>
                                <div style="flex:1;">
                                    <div style="background:#475569; height:5px; width:70%; margin-bottom:4px;"></div>
                                    <div style="background:#cbd5e1; height:4px; width:100%;"></div>
                                </div>
                            </div>
                        @endfor
                    </div>
                @else
                    <div style="padding:6px 8px; display:flex; flex-direction:column; gap:4px;">
                        <div style="background:#4f46e5; height:8px; width:100%; margin-bottom:4px; border-radius:2px;"></div>
                        @for($i=0; $i<8; $i++)
                            <div style="display:flex; gap:4px; align-items:center;">
                                <div style="background:#94a3b8; height:5px; width:15%;"></div>
                                <div style="background:#cbd5e1; height:5px; width:70%;"></div>
                                <div style="background:#94a3b8; height:5px; width:15%;"></div>
                            </div>
                        @endfor
                    </div>
                @endif
            </div>
            <div class="thumb-info"><span class="thumb-num">{{ $thumbPage }}</span><span class="thumb-type">DATA {{ $chunkIndex + 1 }}</span></div>
        </div>
        @endforeach
    </div>

    <div class="canvas-area" id="scrollContainer">
        {{-- PAGE: COVER --}}
        <div class="page-wrapper active feature-cover" id="page-cover">
            <div class="page-label">Halaman Sampul</div>
            <div class="pdf-page" style="display:flex; flex-direction:column; justify-content:center; align-items:center; text-align:center; padding: 60px;">
                <div class="doc-watermark-text"></div>
                <div style="margin-bottom: 50px;">
                    <div style="width: 120px; height: 120px; border-radius: 24px; background: linear-gradient(135deg, #4f46e5, #ec4899); display: grid; place-items: center; color: #fff; font-size: 3.5rem; margin: 0 auto 24px; box-shadow: 0 20px 40px rgba(79, 70, 229, 0.2);">
                        <i class="bi bi-camera-reels-fill"></i>
                    </div>
                    <div style="font-size: 14pt; font-weight: 800; color: #64748b; letter-spacing: 2px;">PEMERINTAH KOTA PEKALONGAN</div>
                    <div style="font-size: 10pt; color: #94a3b8; margin-top: 4px;">Dinas Komunikasi dan Informatika</div>
                </div>
                <div style="width: 100px; height: 4px; background: #4f46e5; margin: 40px auto; border-radius: 2px;"></div>
                <h1 style="font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 28pt; color: #1e293b; line-height: 1.2; margin-bottom: 20px; text-transform: uppercase;">{{ $title }}</h1>
                <div style="font-size: 14pt; color: #64748b; font-weight: 600;">Periode: {{ \Carbon\Carbon::create()->month((int)($filters['bulan_mulai'] ?? 1))->translatedFormat('F') }} - {{ \Carbon\Carbon::create()->month((int)($filters['bulan_akhir'] ?? 1))->translatedFormat('F') }} {{ $filters['tahun'] ?? '' }}</div>
                <div style="margin-top: 100px; padding-top: 40px; border-top: 1px solid #f1f5f9; width: 60%;">
                    <div style="font-size: 9pt; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Digenerate Pada</div>
                    <div style="font-size: 10pt; color: #475569; font-weight: 700; margin-top: 4px;">{{ now()->translatedFormat('d F Y H:i') }}</div>
                </div>
            </div>
        </div>

        @if($showSummary)
        {{-- PAGE: SUMMARY (1) --}}
        <div class="page-wrapper active" id="page-1">
            <div class="page-label">Halaman 1</div>
            <div class="pdf-page">
                <div class="doc-watermark-text"></div>
                <div class="doc-page">
                    <div class="doc-header">
                        <div class="doc-logo-row">
                            <div class="doc-logo-box"><i class="bi bi-camera-reels-fill"></i></div>
                            <div>
                                <div class="doc-org-name">PEMERINTAH KOTA PEKALONGAN</div>
                                <div class="doc-org-sub">Dinas Komunikasi dan Informatika</div>
                            </div>
                        </div>
                        <div class="doc-title-box">
                            <div class="doc-main-title">{{ strtoupper($title) }}</div>
                            <div class="doc-sub-title">Periode: {{ \Carbon\Carbon::create()->month((int)($filters['bulan_mulai'] ?? 1))->translatedFormat('F') }} - {{ \Carbon\Carbon::create()->month((int)($filters['bulan_akhir'] ?? 1))->translatedFormat('F') }} {{ $filters['tahun'] ?? '' }}</div>
                        </div>
                    </div>
                    <div class="doc-divider"></div>
                    <div class="doc-body">
                        <div class="feature-charts">
                            <div class="doc-stat-grid">
                                <div class="doc-stat-box dsb1"><div class="doc-stat-val">{{ number_format($kegiatans->count()) }}</div><div class="doc-stat-lbl">Total Kegiatan</div></div>
                                <div class="doc-stat-box dsb2"><div class="doc-stat-val">{{ number_format($kegiatans->sum('media_count')) }}</div><div class="doc-stat-lbl">Total Foto</div></div>
                                <div class="doc-stat-box dsb3"><div class="doc-stat-val">{{ $kegiatans->groupBy('unit_id')->count() }}</div><div class="doc-stat-lbl">Unit Aktif</div></div>
                                <div class="doc-stat-box dsb4"><div class="doc-stat-val">100%</div><div class="doc-stat-lbl">Validasi</div></div>
                            </div>
                            <div class="doc-section-title"><i class="bi bi-bar-chart-fill"></i> Distribusi Kegiatan per Minggu</div>
                            <div style="display:flex; align-items:flex-end; justify-content:space-between; height:120px; padding:0 40px; margin-bottom:30px;">
                                @php 
                                    $weekCounts = [1=>0, 2=>0, 3=>0, 4=>0, 5=>0];
                                    foreach($kegiatans as $k) { $w = min(5, ceil($k->tanggal->format('d') / 7)); $weekCounts[$w]++; }
                                    $maxW = max($weekCounts) ?: 1;
                                @endphp
                                @foreach($weekCounts as $w => $v)
                                <div style="flex:1; max-width:60px; display:flex; flex-direction:column; align-items:center; gap:6px;">
                                    <div style="font-size:8pt; font-weight:800; color:var(--c-primary);">{{ $v }}</div>
                                    <div style="width:100%; height:{{ ($v/$maxW)*80 }}px; background:linear-gradient(to top, var(--c-primary), var(--c-secondary)); border-radius:4px 4px 0 0;"></div>
                                    <div style="font-size:7pt; color:var(--c-muted);">Mgg {{ $w }}</div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @if($type == 'rekap-unit')
                        <div class="doc-section-title"><i class="bi bi-building-fill"></i> Kontribusi Unit Kerja</div>
                        @php $unitStats = $kegiatans->groupBy('unit_id')->take(10); @endphp
                        @foreach($unitStats as $uid => $items)
                        <div style="margin-bottom:12px;">
                            <div style="display:flex; justify-content:space-between; font-size:8pt; margin-bottom:4px;">
                                <span style="font-weight:700;">{{ $items->first()->unitKerja->nama_instansi ?? 'Unit Lainnya' }}</span>
                                <span style="color:var(--c-muted);">{{ $items->count() }} kegiatan ({{ round(($items->count()/$kegiatans->count())*100) }}%)</span>
                            </div>
                            <div style="height:6px; background:#f1f5f9; border-radius:99px; overflow:hidden;">
                                <div style="width:{{ ($items->count()/$kegiatans->count())*100 }}%; height:100%; background:var(--c-primary);"></div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="doc-footer feature-footer">
                        <span class="doc-footer-text">DokaKegiatan — Kota Pekalongan &copy; {{ date('Y') }}</span>
                        <span class="doc-footer-text">Hal. 1 dari {{ $totalPages }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- PAGE: DATA CHUNKS --}}
        @foreach($chunks as $chunkIndex => $chunk)
        @php $actualPage = $showSummary ? ($chunkIndex + 2) : ($chunkIndex + 1); @endphp
        <div class="page-wrapper active print-data-page" id="page-{{ $actualPage }}">
            <div class="page-label">Halaman {{ $actualPage }}</div>
            <div class="pdf-page">
                <div class="doc-watermark-text"></div>
                <div class="doc-page">
                    <div style="padding:15px 36px; background:#f8fafc; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-weight:800; font-size:9pt; color:var(--c-primary);">{{ strtoupper($title) }}</span>
                        <span style="font-size:7pt; color:var(--c-muted);">Hal. {{ $actualPage }}</span>
                    </div>
                    <div class="doc-body">
                        @if($type == 'galeri-foto')
                            <div class="doc-section-title"><i class="bi bi-images"></i> Album Foto Kegiatan</div>
                            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px;">
                                @foreach($chunk as $keg)
                                    <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; background: #f8fafc;">
                                        <div style="aspect-ratio: 16/9; background: #cbd5e1; display: grid; place-items: center; color: #fff; overflow:hidden;">
                                            @if($keg->media_count > 0)
                                                <i class="bi bi-camera-fill" style="font-size: 2rem; opacity: 0.2;"></i>
                                            @else
                                                <i class="bi bi-image" style="font-size: 2rem; opacity: 0.2;"></i>
                                            @endif
                                        </div>
                                        <div style="padding: 10px;">
                                            <div style="font-weight: 800; font-size: 8pt; color: #1e293b; line-height:1.2;">{{ $keg->judul }}</div>
                                            <div style="display:flex; justify-content:space-between; margin-top:6px; font-size:7pt; color:#64748b;">
                                                <span><i class="bi bi-hash"></i> {{ ($chunkIndex * $perPage) + $loop->iteration }} &nbsp; <i class="bi bi-calendar"></i> {{ $keg->tanggal->format('d M Y') }}</span>
                                                <span><i class="bi bi-image"></i> {{ $keg->media_count }} Foto</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @elseif($type == 'detail-kegiatan')
                            <div class="doc-section-title"><i class="bi bi-file-text"></i> Detail Laporan Kegiatan</div>
                            @foreach($chunk as $keg)
                                <div style="margin-bottom:25px; padding-bottom:20px; border-bottom:1px dashed #e2e8f0;">
                                    <div style="display:flex; gap:15px;">
                                        <div style="width:180px; height:120px; background:#f1f5f9; border-radius:8px; flex-shrink:0; display:grid; place-items:center;">
                                            <i class="bi bi-images" style="font-size:1.5rem; color:#cbd5e1;"></i>
                                        </div>
                                        <div style="flex-grow:1;">
                                            <div style="font-size:10pt; font-weight:900; color:var(--c-primary); margin-bottom:4px;">{{ $keg->judul }}</div>
                                            <div style="display:flex; gap:12px; margin-bottom:8px; font-size:7.5pt; color:#64748b;">
                                                <span><i class="bi bi-calendar-event"></i> {{ $keg->tanggal->format('d F Y') }}</span>
                                                <span><i class="bi bi-building"></i> {{ $keg->unitKerja->nama_instansi ?? '-' }}</span>
                                            </div>
                                            <div style="font-size:8pt; color:#475569; line-height:1.5; text-align:justify;">
                                                {{ $keg->deskripsi ?? 'Kegiatan ini didokumentasikan untuk keperluan laporan resmi Pemerintah Kota Pekalongan.' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @if($type == 'rekap-unit')
                                <div class="doc-section-title"><i class="bi bi-building"></i> Rekapitulasi Berdasarkan Unit Kerja</div>
                            @else
                                <div class="doc-section-title"><i class="bi bi-list-task"></i> Rincian Data Kegiatan</div>
                            @endif

                            <table class="doc-table" style="{{ $type == 'daftar-kegiatan' ? 'font-size:7.5pt;' : '' }}">
                                <thead>
                                    <tr>
                                        <th style="width: 35px; text-align: center;">No</th>
                                        <th>Judul Kegiatan</th>
                                        <th style="width: 90px;">Tanggal</th>
                                        @if($type != 'rekap-unit') <th>Unit</th> @endif
                                        <th style="width: 80px;">Status</th>
                                        <th style="width: 40px; text-align: center;" class="feature-photo">Foto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $lastUnit = null; @endphp
                                    @foreach($chunk as $idx => $keg)
                                        @if($type == 'rekap-unit' && $lastUnit !== ($keg->unitKerja->nama_instansi ?? 'N/A'))
                                            <tr style="background:#f8fafc;">
                                                <td colspan="5" style="font-weight:900; color:var(--c-primary); padding:8px 10px; border-left:4px solid var(--c-primary);">
                                                    <i class="bi bi-building"></i> {{ strtoupper($keg->unitKerja->nama_instansi ?? 'Unit Lainnya') }}
                                                </td>
                                            </tr>
                                            @php $lastUnit = $keg->unitKerja->nama_instansi ?? 'N/A'; @endphp
                                        @endif
                                        <tr>
                                            <td style="text-align: center;">{{ ($chunkIndex * $perPage) + $loop->iteration }}</td>
                                            <td style="font-weight:700;">{{ $keg->judul }}</td>
                                            <td>{{ $keg->tanggal->format('d/m/Y') }}</td>
                                            @if($type != 'rekap-unit') <td>{{ $keg->unitKerja->nama_instansi ?? '-' }}</td> @endif
                                            <td><span class="badge {{ $keg->status == 'selesai' ? 'bg-success' : 'bg-primary' }}" style="font-size:6.5pt;">{{ strtoupper($keg->status) }}</span></td>
                                            <td style="text-align: center; font-family: 'DM Mono', monospace; font-weight: 700; color: #7c3aed;" class="feature-photo">
                                                {{ $keg->media_count ?: 0 }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="doc-footer feature-footer">
                        <span class="doc-footer-text">DokaKegiatan — Kota Pekalongan &copy; {{ date('Y') }}</span>
                        <span class="doc-footer-text">Hal. {{ $actualPage }} dari {{ $totalPages }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="status-bar">
    <div class="sb-item"><span class="sb-dot"></span> Mode Pratinjau Aktif</div>
    <div class="sb-item" style="margin-left:auto;"><i class="bi bi-clock"></i> Digenerate: {{ date('H:i') }}</div>
</div>

<script>
    let currentScale = 1;
    let isManualScrolling = false;
    let currentPage = 0;

    function toggleFeature(feature, isChecked) {
        if (feature === 'cover') document.body.classList.toggle('show-cover', isChecked);
        else if (feature === 'charts') document.body.classList.toggle('hide-charts', !isChecked);
        else if (feature === 'photo') document.body.classList.toggle('hide-photo', !isChecked);
        else if (feature === 'footer') document.body.classList.toggle('hide-footer', !isChecked);
        else if (feature === 'watermark') document.body.classList.toggle('show-watermark', isChecked);
    }

    function updateLayout(val, type) {
        if (type === 'size') {
            document.body.classList.remove('size-a4', 'size-f4', 'size-a3');
            document.body.classList.add(val);
        } else {
            document.body.classList.remove('orient-portrait', 'orient-landscape');
            document.body.classList.add(val);
        }
    }

    function adjustZoom(delta) {
        // Feature removed as requested
    }

    function showPage(num) {
        isManualScrolling = true;
        const pageId = num === 'cover' ? 'page-cover' : 'page-' + num;
        const target = document.getElementById(pageId);
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            updateActiveUI(num);
        }
        setTimeout(() => { isManualScrolling = false; }, 800);
    }

    function updateActiveUI(num) {
        document.querySelectorAll('.page-wrapper').forEach(p => p.classList.remove('active'));
        const pageId = num === 'cover' ? 'page-cover' : 'page-' + num;
        const target = document.getElementById(pageId);
        if(target) target.classList.add('active');

        document.querySelectorAll('.thumb-item').forEach(t => t.classList.remove('active'));
        const thumbId = num === 'cover' ? 'thumb-cover' : 'thumb-' + num;
        const thumb = document.getElementById(thumbId);
        if(thumb) {
            thumb.classList.add('active');
            thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        document.getElementById('currentPageLabel').innerText = num === 'cover' ? '0' : num;
        currentPage = num === 'cover' ? 0 : num;
    }

    document.getElementById('scrollContainer').addEventListener('scroll', function() {
        if (isManualScrolling) return;
        const pages = document.querySelectorAll('.page-wrapper');
        const containerTop = this.getBoundingClientRect().top;
        
        pages.forEach(page => {
            const rect = page.getBoundingClientRect();
            if (rect.top - containerTop < 200 && rect.bottom - containerTop > 100) {
                const id = page.id.replace('page-', '');
                if (id !== currentPage.toString() && (id !== 'cover' || currentPage !== 0)) {
                    updateActiveUI(id === 'cover' ? 'cover' : parseInt(id));
                }
            }
        });
    });

    function prevPage() { 
        if (currentPage === 'cover' || currentPage === 0) return;
        showPage(currentPage === 1 ? 'cover' : currentPage - 1);
    }
    function nextPage() {
        if (currentPage === 'cover' || currentPage === 0) showPage(1);
        else if (currentPage < {{ $totalPages }}) showPage(currentPage + 1);
    }

    window.addEventListener('load', () => {
        toggleFeature('cover', document.getElementById('toggleCover').checked);
        toggleFeature('charts', document.getElementById('toggleCharts').checked);
        toggleFeature('photo', document.getElementById('togglePhoto').checked);
        toggleFeature('footer', document.getElementById('toggleFooter').checked);
        toggleFeature('watermark', document.getElementById('toggleWatermark').checked);
    });
</script>
</body>
</html>
