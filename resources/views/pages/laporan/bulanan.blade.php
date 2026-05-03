<x-master-layout title="Laporan Bulanan — DokaKegiatan">
    @push('css')
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
    <style>
        :root {
            --c-purple: #7c3aed;
            --c-red: #ef4444;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        @keyframes iconWiggle {

            0%,
            80%,
            100% {
                transform: rotate(0)
            }

            85% {
                transform: rotate(-8deg)
            }

            90% {
                transform: rotate(8deg)
            }

            95% {
                transform: rotate(-4deg)
            }
        }

        @keyframes dotPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(236, 72, 153, .5)
            }

            50% {
                box-shadow: 0 0 0 5px rgba(236, 72, 153, 0)
            }
        }

        /* ═══ FILTER BAR ═══ */
        .filter-bar {
            background: #fff;
            border: 1px solid var(--c-border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: 20px 24px;
            margin-bottom: 22px;
            animation: fadeUp .4s ease .05s both;
            display: flex;
            align-items: flex-end;
            gap: 14px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .filter-label {
            font-size: .75rem;
            font-weight: 700;
            color: var(--c-text);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .filter-label i {
            color: var(--c-primary);
            font-size: .8rem;
        }

        .filter-select {
            padding: 10px 14px;
            border: 1.5px solid var(--c-border);
            border-radius: 10px;
            font-size: .875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--c-surface2);
            color: var(--c-text);
            outline: none;
            cursor: pointer;
            transition: border-color var(--trans);
            min-width: 140px;
        }

        .filter-select:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .1);
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            margin-left: auto;
            align-items: flex-end;
        }

        .btn-tb {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: .875rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            border: none;
            transition: transform var(--trans), box-shadow var(--trans);
        }

        .btn-tb:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--c-primary), var(--c-purple));
            color: #fff;
            box-shadow: 0 4px 12px rgba(79, 70, 229, .3);
        }

        .btn-primary:hover {
            box-shadow: 0 6px 18px rgba(79, 70, 229, .45);
        }

        .btn-green {
            background: linear-gradient(135deg, var(--c-green), var(--c-secondary));
            color: #fff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, .3);
        }

        .btn-green:hover {
            box-shadow: 0 6px 18px rgba(16, 185, 129, .45);
        }

        .btn-red {
            background: linear-gradient(135deg, var(--c-red), var(--c-orange));
            color: #fff;
            box-shadow: 0 4px 12px rgba(239, 68, 68, .3);
        }

        .btn-red:hover {
            box-shadow: 0 6px 18px rgba(239, 68, 68, .45);
        }

        .btn-outline {
            background: #fff;
            color: var(--c-text-2);
            border: 1.5px solid var(--c-border);
        }

        .btn-outline:hover {
            border-color: var(--c-primary);
            color: var(--c-primary);
            background: #f5f3ff;
        }

        /* ═══ REPORT HEADER BAND ═══ */
        .report-hero {
            background: linear-gradient(135deg, var(--c-primary) 0%, var(--c-purple) 45%, var(--c-pink) 100%);
            border-radius: var(--radius-lg);
            padding: 28px 32px;
            margin-bottom: 22px;
            position: relative;
            overflow: hidden;
            animation: fadeUp .4s ease .1s both;
        }

        .report-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse 55% 70% at 20% 60%, rgba(255, 255, 255, .12), transparent 60%),
                radial-gradient(ellipse 45% 60% at 80% 30%, rgba(255, 255, 255, .08), transparent 55%);
        }

        .report-hero-inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        .report-hero-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            color: #fff;
            margin-bottom: 5px;
            text-shadow: 0 2px 12px rgba(0, 0, 0, .2);
        }

        .report-hero-sub {
            font-size: .85rem;
            color: rgba(255, 255, 255, .75);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .report-hero-sub i {
            font-size: .85rem;
        }

        .report-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255, 255, 255, .18);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 99px;
            padding: 5px 13px;
            font-size: .72rem;
            font-weight: 800;
            color: #fff;
        }

        /* ═══ STAT CARDS ═══ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 22px;
            animation: fadeUp .45s ease .12s both;
        }

        .stat-card {
            background: #fff;
            border: 1px solid var(--c-border);
            border-radius: var(--radius-md);
            padding: 18px 20px;
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            transition: transform var(--trans), box-shadow var(--trans);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .sc1::after {
            background: linear-gradient(90deg, var(--c-primary), var(--c-secondary));
        }

        .sc2::after {
            background: linear-gradient(90deg, var(--c-green), #34d399);
        }

        .sc3::after {
            background: linear-gradient(90deg, var(--c-accent), var(--c-orange));
        }

        .sc4::after {
            background: linear-gradient(90deg, var(--c-pink), #f472b6);
        }

        .sc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            color: #fff;
            margin-bottom: 12px;
        }

        .sc1 .sc-icon {
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            box-shadow: 0 3px 10px rgba(79, 70, 229, .28);
        }

        .sc2 .sc-icon {
            background: linear-gradient(135deg, var(--c-green), #34d399);
            box-shadow: 0 3px 10px rgba(16, 185, 129, .28);
        }

        .sc3 .sc-icon {
            background: linear-gradient(135deg, var(--c-accent), var(--c-orange));
            box-shadow: 0 3px 10px rgba(245, 158, 11, .28);
        }

        .sc4 .sc-icon {
            background: linear-gradient(135deg, var(--c-pink), #f472b6);
            box-shadow: 0 3px 10px rgba(236, 72, 153, .28);
        }

        .sc-val {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 2rem;
            color: var(--c-text);
            line-height: 1;
            margin-bottom: 3px;
        }

        .sc-lbl {
            font-size: .78rem;
            color: var(--c-muted);
            font-weight: 600;
        }

        .sc-trend {
            font-size: .72rem;
            font-weight: 700;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .sc-trend.up {
            color: var(--c-green);
        }

        .sc-trend.down {
            color: var(--c-red);
        }

        .sc-trend.flat {
            color: var(--c-muted);
        }

        /* ═══ CONTENT GRID ═══ */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        /* ═══ CARD BASE ═══ */
        .rep-card {
            background: #fff;
            border: 1px solid var(--c-border);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            margin-bottom: 20px;
            animation: fadeUp .45s ease .15s both;
        }

        .rep-card:last-child {
            margin-bottom: 0;
        }

        .rep-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--c-border);
            position: relative;
        }

        .rep-card-head::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
        }

        .rch-indigo::before {
            background: linear-gradient(90deg, var(--c-primary), var(--c-secondary));
        }

        .rch-green::before {
            background: linear-gradient(90deg, var(--c-green), var(--c-secondary));
        }

        .rch-amber::before {
            background: linear-gradient(90deg, var(--c-accent), var(--c-orange));
        }

        .rch-pink::before {
            background: linear-gradient(90deg, var(--c-pink), var(--c-purple));
        }

        .rch-slate::before {
            background: linear-gradient(90deg, #64748b, #94a3b8);
        }

        .rep-card-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: .95rem;
            color: var(--c-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rep-card-title i {
            color: var(--c-primary);
        }

        .rep-card-body {
            padding: 20px;
        }

        /* ═══ KEGIATAN TABLE ═══ */
        .kegiatan-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kegiatan-table thead th {
            background: var(--c-surface2);
            padding: 10px 14px;
            font-size: .7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
            color: var(--c-muted);
            border-bottom: 1px solid var(--c-border);
            white-space: nowrap;
            text-align: left;
        }

        .kegiatan-table thead th:last-child {
            text-align: center;
        }

        .kegiatan-table tbody tr {
            border-bottom: 1px solid var(--c-border);
            transition: background var(--trans);
        }

        .kegiatan-table tbody tr:last-child {
            border-bottom: none;
        }

        .kegiatan-table tbody tr:hover {
            background: rgba(79, 70, 229, .025);
        }

        .kegiatan-table tbody td {
            padding: 13px 14px;
            font-size: .85rem;
            color: var(--c-text-2);
            vertical-align: middle;
        }

        .kt-no {
            font-family: 'DM Mono', monospace;
            font-size: .75rem;
            color: var(--c-muted);
            width: 36px;
        }

        .kt-name {
            font-weight: 700;
            color: var(--c-text);
        }

        .kt-name-sub {
            font-size: .72rem;
            color: var(--c-muted);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .kat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 99px;
            font-size: .68rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: .7rem;
            font-weight: 700;
        }

        .sp-selesai {
            background: #f0fdf4;
            color: var(--c-green);
            border: 1px solid #bbf7d0;
        }

        .sp-selesai::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--c-green);
            animation: dotPulse 2s ease infinite;
        }

        .sp-berjalan {
            background: #eff6ff;
            color: var(--c-primary);
            border: 1px solid #bfdbfe;
        }

        .sp-berjalan::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--c-primary);
            animation: dotPulse 2s ease infinite;
        }

        .sp-draft {
            background: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
        }

        .sp-draft::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #f59e0b;
        }

        .foto-count {
            font-family: 'DM Mono', monospace;
            font-size: .78rem;
            font-weight: 600;
            color: var(--c-primary);
            text-align: center;
        }

        .tbl-actions-sm {
            display: flex;
            gap: 4px;
            justify-content: center;
        }

        .tbl-btn-sm {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            display: grid;
            place-items: center;
            font-size: .82rem;
            transition: all var(--trans);
        }

        .tbl-btn-sm:hover {
            transform: scale(1.1);
        }

        .tb-view {
            background: #eff6ff;
            color: var(--c-primary);
        }

        .tb-del {
            background: #fef2f2;
            color: var(--c-red);
        }

        .tb-view:hover {
            background: var(--c-primary);
            color: #fff;
        }

        .tb-del:hover {
            background: var(--c-red);
            color: #fff;
        }

        /* ═══ CHART AREA ═══ */
        .chart-wrap {
            padding: 16px 20px 8px;
        }

        canvas {
            width: 100% !important;
        }

        .chart-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 20px 16px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .75rem;
            color: var(--c-text-2);
            font-weight: 600;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ═══ PROGRESS BAR ═══ */
        .prog-row {
            margin-bottom: 16px;
        }

        .prog-row:last-child {
            margin-bottom: 0;
        }

        .prog-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .prog-name {
            font-size: .82rem;
            font-weight: 700;
            color: var(--c-text);
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .prog-logo-sm {
            width: 22px;
            height: 22px;
            border-radius: 5px;
            display: grid;
            place-items: center;
            font-size: .6rem;
            color: #fff;
            flex-shrink: 0;
        }

        .prog-val {
            font-family: 'DM Mono', monospace;
            font-size: .75rem;
            font-weight: 600;
            color: var(--c-text-2);
        }

        .prog-bar-bg {
            height: 7px;
            background: var(--c-border);
            border-radius: 99px;
            overflow: hidden;
        }

        .prog-fill {
            height: 100%;
            border-radius: 99px;
            transition: width .8s cubic-bezier(.22, 1, .36, 1);
        }

        /* ═══ TIMELINE SUMMARY ═══ */
        .tl-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--c-border);
        }

        .tl-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .tl-item:first-child {
            padding-top: 0;
        }

        .tl-dot {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: .9rem;
            color: #fff;
            flex-shrink: 0;
        }

        .tl-title {
            font-size: .85rem;
            font-weight: 700;
            color: var(--c-text);
        }

        .tl-sub {
            font-size: .72rem;
            color: var(--c-muted);
            margin-top: 1px;
        }

        .tl-badge {
            margin-left: auto;
            flex-shrink: 0;
            font-family: 'DM Mono', monospace;
            font-size: .72rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 99px;
        }

        /* ═══ WEEK SUMMARY ═══ */
        .week-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
        }

        .week-item {
            background: var(--c-surface2);
            border: 1px solid var(--c-border);
            border-radius: 9px;
            padding: 10px 8px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .week-item::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--c-primary), var(--c-secondary));
            transform: scaleX(0);
            transition: transform .4s;
        }

        .week-item:hover::before {
            transform: scaleX(1);
        }

        .week-label {
            font-size: .65rem;
            font-weight: 800;
            color: var(--c-muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }

        .week-count {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.2rem;
            color: var(--c-text);
        }

        .week-sub {
            font-size: .65rem;
            color: var(--c-muted);
            margin-top: 2px;
        }

        /* ═══ MINI BAR CHART (no lib) ═══ */
        .mini-bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 5px;
            height: 80px;
            padding: 0 4px;
        }

        .mbc-bar-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }

        .mbc-bar {
            width: 100%;
            border-radius: 4px 4px 0 0;
            min-height: 4px;
            transition: height .6s ease;
        }

        .mbc-lbl {
            font-size: .58rem;
            color: var(--c-muted);
            font-weight: 700;
        }

        .mbc-val {
            font-size: .6rem;
            font-family: 'DM Mono', monospace;
            color: var(--c-primary);
            font-weight: 700;
        }

        /* ═══ SUMMARY INFO ROWS ═══ */
        .info-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid var(--c-border);
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-row:first-child {
            padding-top: 0;
        }

        .info-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(79, 70, 229, .08);
            display: grid;
            place-items: center;
            color: var(--c-primary);
            font-size: .85rem;
            flex-shrink: 0;
        }

        .info-label {
            font-size: .75rem;
            color: var(--c-muted);
            font-weight: 600;
            margin-bottom: 2px;
        }

        .info-val {
            font-size: .875rem;
            font-weight: 700;
            color: var(--c-text);
        }

        /* ═══ EMPTY STATE ═══ */
        .empty-state {
            padding: 60px 24px;
            text-align: center;
        }

        .empty-state i {
            font-size: 3.5rem;
            color: var(--c-border);
            display: block;
            margin-bottom: 14px;
            animation: emptyFloat 3s ease-in-out infinite;
        }

        @keyframes emptyFloat {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-8px)
            }
        }

        .empty-state h3 {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            color: var(--c-muted);
            margin-bottom: 6px;
        }

        .empty-state p {
            font-size: .85rem;
            color: var(--c-muted);
        }

        /* Print */
        @media print {

            .sidebar,
            .topbar,
            .fab,
            .filter-actions,
            .tbl-actions-sm,
            .btn-tb,
            .main-footer,
            .sidebar-overlay {
                display: none !important;
            }

            .main-wrapper {
                margin-left: 0 !important;
                padding-top: 0 !important;
            }

            .main-content {
                padding: 0 !important;
            }

            body {
                background: #fff;
            }

            .report-hero {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        /* Responsive */
        @media(max-width:1200px) {
            .stat-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .content-grid {
                grid-template-columns: 1fr
            }
        }

        @media(max-width:768px) {
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-actions {
                margin-left: 0;
            }

            .week-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media(max-width:576px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .week-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
    @endpush

    <!-- Page Header -->
    <div class="page-header">
        <div class="ph-left">
            <h1><i class="bi bi-bar-chart-fill"></i> Laporan Bulanan</h1>
            <p>Rekap dokumentasi kegiatan per bulan, per unit kerja, beserta analisis capaian.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <a href="#">Laporan</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-bar-chart-fill"></i> Laporan Bulanan</span>
        </nav>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar" style="position:relative;">
        <div class="filter-group">
            <div class="filter-label"><i class="bi bi-calendar3"></i> Bulan</div>
            <select class="filter-select" id="fBulan" onchange="generateReport()">
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4" selected>April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>
        <div class="filter-group">
            <div class="filter-label"><i class="bi bi-calendar-year"></i> Tahun</div>
            <select class="filter-select" id="fTahun" onchange="generateReport()">
                <option value="2025" selected>2025</option>
                <option value="2024">2024</option>
                <option value="2023">2023</option>
            </select>
        </div>
        <div class="filter-group">
            <div class="filter-label"><i class="bi bi-building-fill"></i> Unit Kerja</div>
            <select class="filter-select" id="fUnit" onchange="generateReport()">
                <option value="">Semua Unit Kerja</option>
                <option value="Diskominfo">Dinas Kominfo</option>
                <option value="Disdik">Dinas Pendidikan</option>
                <option value="Dinkes">Dinas Kesehatan</option>
                <option value="Dinsos">Dinas Sosial</option>
                <option value="Humas">Bagian Humas</option>
                <option value="Setda">Sekretariat Daerah</option>
            </select>
        </div>
        <div class="filter-group">
            <div class="filter-label"><i class="bi bi-tags-fill"></i> Kategori</div>
            <select class="filter-select" id="fKategori" onchange="generateReport()">
                <option value="">Semua Kategori</option>
                <option value="Rapat">Rapat</option>
                <option value="Pelatihan">Pelatihan</option>
                <option value="Kunjungan">Kunjungan</option>
                <option value="Sosialisasi">Sosialisasi</option>
                <option value="Upacara">Upacara</option>
            </select>
        </div>
        <div class="filter-actions">
            <button class="btn-tb btn-outline" onclick="window.print()"><i class="bi bi-printer-fill"></i> Cetak</button>
            <button class="btn-tb btn-green" onclick="exportExcel()"><i class="bi bi-file-earmark-excel-fill"></i> Excel</button>
            <button class="btn-tb btn-red" onclick="exportPDF()"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>
            <button class="btn-tb btn-primary" onclick="generateReport()"><i class="bi bi-arrow-clockwise"></i> Refresh</button>
        </div>
    </div>

    <!-- Report Hero -->
    <div class="report-hero" id="reportHero">
        <div class="report-hero-inner">
            <div>
                <div class="report-hero-title" id="heroTitle">Laporan Kegiatan Bulan April 2025</div>
                <div class="report-hero-sub">
                    <span><i class="bi bi-building-fill"></i> Semua Unit Kerja</span>
                    <span><i class="bi bi-clock-fill"></i> Digenerate: <span id="heroGenTime"></span></span>
                </div>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <span class="report-badge"><i class="bi bi-check-circle-fill" style="font-size:.55rem;"></i> Laporan Resmi</span>
                <span class="report-badge"><i class="bi bi-shield-fill" style="font-size:.55rem;"></i> DokaKegiatan v1.2</span>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="stat-grid" id="statGrid">
        <div class="stat-card sc1">
            <div class="sc-icon"><i class="bi bi-calendar3-fill"></i></div>
            <div class="sc-val" id="scKegiatan">0</div>
            <div class="sc-lbl">Total Kegiatan</div>
            <div class="sc-trend up" id="scKegiatanTrend"><i class="bi bi-arrow-up-short"></i> 0% vs bulan lalu</div>
        </div>
        <div class="stat-card sc2">
            <div class="sc-icon"><i class="bi bi-images"></i></div>
            <div class="sc-val" id="scFoto">0</div>
            <div class="sc-lbl">Total Foto Diupload</div>
            <div class="sc-trend up" id="scFotoTrend"><i class="bi bi-arrow-up-short"></i> 0% vs bulan lalu</div>
        </div>
        <div class="stat-card sc3">
            <div class="sc-icon"><i class="bi bi-check-circle-fill"></i></div>
            <div class="sc-val" id="scSelesai">0</div>
            <div class="sc-lbl">Kegiatan Selesai</div>
            <div class="sc-trend flat" id="scSelesaiTrend"><i class="bi bi-dash"></i> 0% tingkat selesai</div>
        </div>
        <div class="stat-card sc4">
            <div class="sc-icon"><i class="bi bi-building-fill"></i></div>
            <div class="sc-val" id="scUnit">0</div>
            <div class="sc-lbl">Unit Kerja Aktif</div>
            <div class="sc-trend up" id="scUnitTrend"><i class="bi bi-people-fill"></i> 0 petugas terlibat</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">

        <!-- ═══ LEFT ═══ -->
        <div>

            <!-- Daftar Kegiatan -->
            <div class="rep-card">
                <div class="rep-card-head rch-indigo">
                    <div class="rep-card-title"><i class="bi bi-list-ul"></i> Daftar Kegiatan <span id="tableCount" style="font-size:.75rem;font-weight:600;color:var(--c-muted);margin-left:4px;"></span></div>
                    <div style="display:flex;gap:6px;">
                        <button class="btn-tb btn-outline" style="padding:6px 12px;font-size:.75rem;" onclick="sortTable()">
                            <i class="bi bi-sort-down-alt"></i> Urutkan
                        </button>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table class="kegiatan-table" id="kegiatanTable">
                        <thead>
                            <tr>
                                <th class="kt-no">#</th>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Unit Kerja</th>
                                <th>Status</th>
                                <th style="text-align:center;">Foto</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="kegiatanBody"></tbody>
                    </table>
                    <div class="empty-state d-none" id="emptyTable">
                        <i class="bi bi-calendar-x"></i>
                        <h3>Tidak ada data kegiatan</h3>
                        <p>Tidak ada kegiatan yang sesuai filter yang dipilih.</p>
                    </div>
                </div>
            </div>

            <!-- Distribusi Mingguan -->
            <div class="rep-card">
                <div class="rep-card-head rch-amber">
                    <div class="rep-card-title"><i class="bi bi-calendar-week-fill"></i> Distribusi Kegiatan per Minggu</div>
                </div>
                <div class="rep-card-body">
                    <div class="week-grid" id="weekGrid"></div>
                    <div style="margin-top:16px;">
                        <div style="font-size:.72rem;color:var(--c-muted);font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px;">Tren Harian (Kegiatan)</div>
                        <div class="mini-bar-chart" id="miniBarChart"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- ═══ RIGHT ═══ -->
        <div>

            <!-- Kontribusi per Unit -->
            <div class="rep-card">
                <div class="rep-card-head rch-green">
                    <div class="rep-card-title"><i class="bi bi-building-fill"></i> Kontribusi per Unit Kerja</div>
                </div>
                <div class="rep-card-body" id="unitProgBars"></div>
            </div>

            <!-- Distribusi Kategori -->
            <div class="rep-card">
                <div class="rep-card-head rch-pink">
                    <div class="rep-card-title"><i class="bi bi-pie-chart-fill"></i> Distribusi Kategori</div>
                </div>
                <div class="rep-card-body">
                    <div style="display:flex;flex-direction:column;gap:0;" id="katBars"></div>
                </div>
            </div>

            <!-- Ringkasan -->
            <div class="rep-card">
                <div class="rep-card-head rch-slate">
                    <div class="rep-card-title"><i class="bi bi-clipboard-fill"></i> Ringkasan Laporan</div>
                </div>
                <div class="rep-card-body">
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-calendar3-fill"></i></div>
                        <div>
                            <div class="info-label">Periode Laporan</div>
                            <div class="info-val" id="rPeriode">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-calendar-check-fill"></i></div>
                        <div>
                            <div class="info-label">Hari Aktif</div>
                            <div class="info-val" id="rHariAktif">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-graph-up-arrow"></i></div>
                        <div>
                            <div class="info-label">Rata-rata / Hari</div>
                            <div class="info-val" id="rRataHari">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-trophy-fill"></i></div>
                        <div>
                            <div class="info-label">Unit Terbanyak</div>
                            <div class="info-val" id="rTopUnit">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-camera-fill"></i></div>
                        <div>
                            <div class="info-label">Rata-rata Foto/Kegiatan</div>
                            <div class="info-val" id="rRataFoto">—</div>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                        <div>
                            <div class="info-label">Terakhir Diperbarui</div>
                            <div class="info-val" id="rUpdate">—</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('js')
    <script>
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

        const UNIT_CFG = {
            'Diskominfo': {
                gradId: 0,
                short: 'Diskominfo'
            },
            'Disdik': {
                gradId: 1,
                short: 'Disdik'
            },
            'Dinkes': {
                gradId: 2,
                short: 'Dinkes'
            },
            'Dinsos': {
                gradId: 3,
                short: 'Dinsos'
            },
            'Humas': {
                gradId: 4,
                short: 'Humas'
            },
            'Setda': {
                gradId: 5,
                short: 'Setda'
            },
            'DPUPR': {
                gradId: 6,
                short: 'DPUPR'
            },
            'Inspektorat': {
                gradId: 7,
                short: 'Inspektorat'
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

        /* Master data — generate per bulan */
        const MASTER_DATA = {
            /* Bulan 4 — April 2025 */
            4: [{
                    id: 101,
                    nama: 'Rapat Koordinasi Dinas Kominfo TW II 2025',
                    tgl: '2025-04-24',
                    kat: 'Rapat',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 12
                },
                {
                    id: 102,
                    nama: 'Pelatihan SDM Digitalisasi Pelayanan Publik',
                    tgl: '2025-04-22',
                    kat: 'Pelatihan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 8
                },
                {
                    id: 103,
                    nama: 'Kunjungan Lapangan Infrastruktur IT Puskesmas',
                    tgl: '2025-04-20',
                    kat: 'Kunjungan',
                    unit: 'Dinkes',
                    status: 'selesai',
                    foto: 18
                },
                {
                    id: 104,
                    nama: 'Sosialisasi Aplikasi SiPeDas kepada Warga',
                    tgl: '2025-04-18',
                    kat: 'Sosialisasi',
                    unit: 'Humas',
                    status: 'selesai',
                    foto: 6
                },
                {
                    id: 105,
                    nama: 'Upacara Peringatan Hari Kartini Tingkat Kota',
                    tgl: '2025-04-21',
                    kat: 'Upacara',
                    unit: 'Setda',
                    status: 'selesai',
                    foto: 24
                },
                {
                    id: 106,
                    nama: 'Rapat Evaluasi Program Smart City 2025',
                    tgl: '2025-04-17',
                    kat: 'Rapat',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 5
                },
                {
                    id: 107,
                    nama: 'Pelatihan Fotografi Dokumentasi Kegiatan',
                    tgl: '2025-04-15',
                    kat: 'Pelatihan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 32
                },
                {
                    id: 108,
                    nama: 'Kunjungan ke Pusat Data Nasional Surabaya',
                    tgl: '2025-04-14',
                    kat: 'Kunjungan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 14
                },
                {
                    id: 109,
                    nama: 'Sosialisasi Keamanan Siber untuk ASN',
                    tgl: '2025-04-12',
                    kat: 'Sosialisasi',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 9
                },
                {
                    id: 110,
                    nama: 'Rapat Finalisasi Anggaran TIK 2025-2026',
                    tgl: '2025-04-10',
                    kat: 'Rapat',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 4
                },
                {
                    id: 111,
                    nama: 'Workshop Pembuatan Konten Media Sosial Pemerintah',
                    tgl: '2025-04-08',
                    kat: 'Pelatihan',
                    unit: 'Humas',
                    status: 'selesai',
                    foto: 21
                },
                {
                    id: 112,
                    nama: 'Kunjungan Monitoring CCTV Kota Pekalongan',
                    tgl: '2025-04-05',
                    kat: 'Kunjungan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 16
                },
                {
                    id: 113,
                    nama: 'Upacara Hari Pendidikan Nasional Kota Pekalongan',
                    tgl: '2025-04-30',
                    kat: 'Upacara',
                    unit: 'Setda',
                    status: 'berjalan',
                    foto: 0
                },
                {
                    id: 114,
                    nama: 'Rapat Persiapan HUT Kota Pekalongan ke-419',
                    tgl: '2025-04-28',
                    kat: 'Rapat',
                    unit: 'Setda',
                    status: 'berjalan',
                    foto: 0
                },
                {
                    id: 115,
                    nama: 'Pelatihan Pengelolaan Website OPD',
                    tgl: '2025-04-28',
                    kat: 'Pelatihan',
                    unit: 'Disdik',
                    status: 'draft',
                    foto: 0
                },
                {
                    id: 116,
                    nama: 'Sosialisasi PPID Kota Pekalongan ke Masyarakat',
                    tgl: '2025-04-29',
                    kat: 'Sosialisasi',
                    unit: 'Diskominfo',
                    status: 'draft',
                    foto: 0
                },
            ],
            3: [{
                    id: 201,
                    nama: 'Upacara HUT Korpri ke-53 Kota Pekalongan',
                    tgl: '2025-03-01',
                    kat: 'Upacara',
                    unit: 'Setda',
                    status: 'selesai',
                    foto: 15
                },
                {
                    id: 202,
                    nama: 'Kunjungan Studi Banding ke Pemkot Semarang',
                    tgl: '2025-03-05',
                    kat: 'Kunjungan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 19
                },
                {
                    id: 203,
                    nama: 'Rapat Koordinasi E-Government Seluruh OPD',
                    tgl: '2025-03-10',
                    kat: 'Rapat',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 7
                },
                {
                    id: 204,
                    nama: 'Workshop Data Analytics untuk Pemerintahan',
                    tgl: '2025-03-15',
                    kat: 'Pelatihan',
                    unit: 'Disdik',
                    status: 'selesai',
                    foto: 13
                },
                {
                    id: 205,
                    nama: 'Sosialisasi Batik Digital Pekalongan',
                    tgl: '2025-03-18',
                    kat: 'Sosialisasi',
                    unit: 'Humas',
                    status: 'selesai',
                    foto: 22
                },
                {
                    id: 206,
                    nama: 'Rapat Pembahasan Master Plan TIK 2025-2030',
                    tgl: '2025-03-20',
                    kat: 'Rapat',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 6
                },
                {
                    id: 207,
                    nama: 'Kunjungan Kerja Komisi I DPRD ke Kominfo',
                    tgl: '2025-03-25',
                    kat: 'Kunjungan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 9
                },
                {
                    id: 208,
                    nama: 'Upacara Isra Miraj Kota Pekalongan',
                    tgl: '2025-03-28',
                    kat: 'Upacara',
                    unit: 'Setda',
                    status: 'selesai',
                    foto: 11
                },
                {
                    id: 209,
                    nama: 'Rapat Koordinasi Dinas Sosial',
                    tgl: '2025-03-12',
                    kat: 'Rapat',
                    unit: 'Dinsos',
                    status: 'selesai',
                    foto: 5
                },
                {
                    id: 210,
                    nama: 'Pelatihan Aplikasi SIPEKA',
                    tgl: '2025-03-22',
                    kat: 'Pelatihan',
                    unit: 'Diskominfo',
                    status: 'selesai',
                    foto: 10
                },
            ],
        };

        /* Default tahun 2025 — simple mock */
        for (let m = 1; m <= 12; m++) {
            if (!MASTER_DATA[m]) {
                MASTER_DATA[m] = Array.from({
                    length: Math.floor(Math.random() * 10) + 3
                }, (_, i) => ({
                    id: 300 + m * 20 + i,
                    nama: `Kegiatan ${BULAN_STR[m]} 2025 ke-${i+1}`,
                    tgl: `2025-${String(m).padStart(2,'0')}-${String((i+1)*2).padStart(2,'0')}`,
                    kat: ['Rapat', 'Pelatihan', 'Kunjungan', 'Sosialisasi', 'Upacara'][i % 5],
                    unit: ['Diskominfo', 'Disdik', 'Dinkes', 'Humas', 'Setda'][i % 5],
                    status: i < 6 ? 'selesai' : (i === 6 ? 'berjalan' : 'draft'),
                    foto: i < 6 ? Math.floor(Math.random() * 20) + 3 : 0,
                }));
            }
        }

        /* ════════════════════════════════════
           STATE
           ════════════════════════════════════ */
        let currentData = [];
        let sortAsc = false;

        /* ════════════════════════════════════
           INIT
           ════════════════════════════════════ */
        function fmtDate(s) {
            if (!s) return '—';
            const [y, m, d] = s.split('-');
            return `${+d} ${BULAN_STR[+m]} ${y}`;
        }

        function generateReport() {
            const bulan = +document.getElementById('fBulan').value;
            const tahun = +document.getElementById('fTahun').value;
            const unit = document.getElementById('fUnit').value;
            const kat = document.getElementById('fKategori').value;

            const pool = MASTER_DATA[bulan] || [];
            currentData = pool.filter(d =>
                (!unit || d.unit === unit) &&
                (!kat || d.kat === kat)
            );

            updateHero(bulan, tahun, unit);
            updateStats(bulan);
            renderTable();
            renderUnitBars();
            renderKatBars();
            renderWeek(bulan, tahun);
            renderSummary(bulan, tahun);
        }

        /* ════════════════════════════════════
           HERO
           ════════════════════════════════════ */
        function updateHero(bulan, tahun, unit) {
            document.getElementById('heroTitle').textContent =
                `Laporan Kegiatan Bulan ${BULAN_STR[bulan]} ${tahun}${unit ? ` — ${unit}` : ''}`;
            document.getElementById('heroGenTime').textContent = new Date().toLocaleString('id-ID', {
                dateStyle: 'long',
                timeStyle: 'short'
            });
        }

        /* ════════════════════════════════════
           STATS
           ════════════════════════════════════ */
        const PREV = {
            4: {
                k: 10,
                f: 120,
                s: 8,
                u: 5
            },
            3: {
                k: 8,
                f: 90,
                s: 7,
                u: 4
            }
        };

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

        function updateStats(bulan) {
            const totalK = currentData.length;
            const totalF = currentData.reduce((s, d) => s + d.foto, 0);
            const selesai = currentData.filter(d => d.status === 'selesai').length;
            const units = [...new Set(currentData.map(d => d.unit))].length;
            const prev = PREV[bulan] || {
                k: 8,
                f: 90,
                s: 7,
                u: 4
            };

            animC('scKegiatan', totalK);
            animC('scFoto', totalF);
            animC('scSelesai', selesai);
            animC('scUnit', units);

            const pctK = prev.k ? Math.round(((totalK - prev.k) / prev.k) * 100) : 0;
            const pctF = prev.f ? Math.round(((totalF - prev.f) / prev.f) * 100) : 0;
            const pctS = totalK ? Math.round((selesai / totalK) * 100) : 0;

            setTrend('scKegiatanTrend', pctK, `${pctK>0?'+':''}${pctK}% vs bulan lalu`);
            setTrend('scFotoTrend', pctF, `${pctF>0?'+':''}${pctF}% vs bulan lalu`);
            document.getElementById('scSelesaiTrend').innerHTML = `<i class="bi bi-bar-chart-fill"></i> ${pctS}% tingkat selesai`;
            document.getElementById('scSelesaiTrend').className = `sc-trend ${pctS>=75?'up':pctS>=50?'flat':'down'}`;

            const petugas = [...new Set(currentData.map(d => d.unit))].length * 2;
            document.getElementById('scUnitTrend').innerHTML = `<i class="bi bi-people-fill"></i> ${petugas} petugas terlibat`;
            document.getElementById('scUnitTrend').className = 'sc-trend flat';
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

            cnt.textContent = currentData.length ? `(${currentData.length} kegiatan)` : '';

            if (!currentData.length) {
                tbody.innerHTML = '';
                empty.classList.remove('d-none');
                return;
            }
            empty.classList.add('d-none');

            /* Static rows */
            tbody.innerHTML = currentData.map((d, i) => {
                const sc = STATUS_CFG[d.status];
                const kc = KAT_CFG[d.kat] || {
                    bg: 'rgba(100,116,139,.1)',
                    color: '#64748b'
                };
                const uc = UNIT_CFG[d.unit] || {
                    gradId: 0
                };
                return `
      <tr>
        <td class="kt-no">${String(i+1).padStart(2,'0')}</td>
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
            <span style="font-size:.82rem;font-weight:600;">${d.unit}</span>
          </div>
        </td>
        <td><span class="status-pill ${sc.cls}">${sc.label}</span></td>
        <td class="foto-count">${d.foto > 0 ? `<span style="background:rgba(79,70,229,.08);padding:3px 9px;border-radius:99px;"><i class="bi bi-images" style="color:var(--c-primary);font-size:.75rem;"></i> ${d.foto}</span>` : '<span style="color:var(--c-muted);">—</span>'}</td>
        <td>
          <div class="tbl-actions-sm">
            <button class="tbl-btn-sm tb-view" onclick="viewKegiatan(${d.id})" title="Detail"><i class="bi bi-eye-fill"></i></button>
            <button class="tbl-btn-sm tb-del"  onclick="delKegiatan(${d.id}, '${d.nama.replace(/'/g,"\\'")}')" title="Hapus"><i class="bi bi-trash3-fill"></i></button>
          </div>
        </td>
      </tr>`;
            }).join('');
        }

        function sortTable() {
            sortAsc = !sortAsc;
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
           UNIT PROGRESS BARS
           ════════════════════════════════════ */
        function renderUnitBars() {
            const unitMap = {};
            currentData.forEach(d => {
                if (!unitMap[d.unit]) unitMap[d.unit] = {
                    k: 0,
                    f: 0
                };
                unitMap[d.unit].k++;
                unitMap[d.unit].f += d.foto;
            });
            const sorted = Object.entries(unitMap).sort((a, b) => b[1].k - a[1].k);
            const maxK = sorted.length ? sorted[0][1].k : 1;

            document.getElementById('unitProgBars').innerHTML = sorted.map(([unit, val]) => {
                const uc = UNIT_CFG[unit] || {
                    gradId: 0,
                    short: unit
                };
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
                const kc = KAT_CFG[kat] || {
                    bg: 'rgba(100,116,139,.1)',
                    color: '#64748b',
                    bar: 'linear-gradient(90deg,#64748b,#94a3b8)'
                };
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
            // Distribute kegiatan into 5 weeks
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

            // Mini bar chart — daily distribution (mock 20 days)
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
                const pct = Math.round((d.val / maxVal) * 68);
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
                        if (MASTER_DATA[bulan]) {
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
            if (typeof DKA !== 'undefined') {
                const l = DKA.loading({
                    title: 'Membuat laporan PDF...',
                    message: 'Menyiapkan data dan grafik.',
                    style: 'wave'
                });
                const bulan = BULAN_STR[+document.getElementById('fBulan').value];
                const tahun = document.getElementById('fTahun').value;
                setTimeout(() => l.update('Menyusun halaman...'), 1000);
                setTimeout(() => {
                    l.close();
                    DKA.notify({
                        type: 'success',
                        title: 'PDF Siap Diunduh!',
                        message: `Laporan_Bulanan_${bulan}_${tahun}.pdf (${(Math.random()*2+1).toFixed(1)} MB) berhasil dibuat.`,
                        duration: 7000
                    });
                }, 2500);
            }
        }

        function exportExcel() {
            if (typeof DKA !== 'undefined') {
                const l = DKA.loading({
                    title: 'Membuat file Excel...',
                    message: 'Mengekspor data kegiatan.',
                    style: 'dots'
                });
                const bulan = BULAN_STR[+document.getElementById('fBulan').value];
                const tahun = document.getElementById('fTahun').value;
                setTimeout(() => {
                    l.close();
                    DKA.toast({
                        type: 'success',
                        title: 'Excel Siap Diunduh!',
                        message: `Laporan_Bulanan_${bulan}_${tahun}.xlsx`,
                        position: 'top-right',
                        duration: 5000
                    });
                }, 1600);
            }
        }

        /* ── INIT ── */
        document.addEventListener('DOMContentLoaded', () => {
            generateReport();
        });
    </script>
    @endpush
</x-master-layout>
