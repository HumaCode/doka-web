<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title ?? 'LAPORAN' }}</title>
    <style>
        @page { margin: 0; }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 9pt;
            color: #1e293b;
            line-height: 1.5;
        }

        .page {
            position: relative;
            width: 100%;
            min-height: 100%;
            padding: 0;
            page-break-after: always;
        }
        .page:last-child { page-break-after: auto; }

        /* ═══ COVER ═══ */
        .cover {
            text-align: center;
            padding: 200px 80px 60px;
        }
        .cover-icon {
            width: 90px;
            height: 90px;
            border-radius: 20px;
            background: #4f46e5;
            margin: 0 auto 24px;
            text-align: center;
            line-height: 90px;
            color: #fff;
            font-size: 36pt;
            font-weight: bold;
        }
        .cover-org {
            font-size: 13pt;
            font-weight: bold;
            color: #64748b;
            letter-spacing: 2px;
        }
        .cover-sub {
            font-size: 9pt;
            color: #94a3b8;
            margin-top: 4px;
        }
        .cover-line {
            width: 80px;
            height: 3px;
            background: #4f46e5;
            margin: 40px auto;
        }
        .cover-title {
            font-size: 24pt;
            font-weight: bold;
            color: #1e293b;
            text-transform: uppercase;
            line-height: 1.3;
            margin-bottom: 16px;
        }
        .cover-periode {
            font-size: 12pt;
            color: #64748b;
        }
        .cover-bottom {
            margin-top: 120px;
            padding-top: 30px;
            border-top: 1px solid #e2e8f0;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
        .cover-bottom-label {
            font-size: 8pt;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cover-bottom-date {
            font-size: 10pt;
            color: #475569;
            font-weight: bold;
            margin-top: 4px;
        }

        /* ═══ DOC HEADER (gradient bar) ═══ */
        .doc-header {
            background: #4f46e5;
            padding: 22px 36px 18px;
            color: #fff;
            position: relative;
        }
        .doc-header-org {
            font-size: 11pt;
            font-weight: bold;
        }
        .doc-header-sub {
            font-size: 7.5pt;
            color: rgba(255,255,255,0.7);
        }
        .doc-header-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-top: 12px;
            letter-spacing: 0.5px;
        }
        .doc-header-periode {
            font-size: 8.5pt;
            color: rgba(255,255,255,0.8);
            text-align: center;
            margin-top: 2px;
        }
        .doc-divider {
            height: 4px;
            background: #06b6d4;
        }

        /* ═══ BODY ═══ */
        .doc-body {
            padding: 24px 36px 20px;
        }

        /* ═══ STAT BOXES ═══ */
        .stat-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }
        .stat-table td {
            width: 25%;
            text-align: center;
            padding: 14px 8px 10px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            position: relative;
        }
        .stat-table .s1 { border-top: 3px solid #4f46e5; }
        .stat-table .s2 { border-top: 3px solid #10b981; }
        .stat-table .s3 { border-top: 3px solid #f59e0b; }
        .stat-table .s4 { border-top: 3px solid #ec4899; }
        .stat-val {
            font-size: 18pt;
            font-weight: bold;
            color: #1e293b;
            line-height: 1;
        }
        .stat-lbl {
            font-size: 7pt;
            color: #94a3b8;
            font-weight: bold;
            margin-top: 4px;
        }

        /* ═══ SECTION TITLE ═══ */
        .sec-title {
            font-size: 10pt;
            font-weight: bold;
            color: #1e293b;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 5px;
            margin-bottom: 14px;
            margin-top: 8px;
        }

        /* ═══ BAR CHART (table-based) ═══ */
        .chart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .chart-table td {
            text-align: center;
            vertical-align: bottom;
            padding: 0 8px;
        }
        .chart-val {
            font-size: 9pt;
            font-weight: bold;
            color: #4f46e5;
            padding-bottom: 4px;
        }
        .chart-bar-cell {
            height: 100px;
            vertical-align: bottom;
            padding: 0 8px;
        }
        .chart-bar-inner {
            width: 36px;
            margin: 0 auto;
            background: #4f46e5;
            border-radius: 3px 3px 0 0;
        }
        .chart-lbl {
            font-size: 7pt;
            color: #94a3b8;
            padding-top: 6px;
        }

        /* ═══ PROGRESS BAR (unit) ═══ */
        .prog-wrap { margin-bottom: 10px; }
        .prog-label {
            font-size: 8pt;
            margin-bottom: 3px;
        }
        .prog-name { font-weight: bold; }
        .prog-count { color: #94a3b8; }
        .prog-track {
            height: 7px;
            background: #f1f5f9;
            border-radius: 3px;
            overflow: hidden;
        }
        .prog-fill {
            height: 7px;
            background: #4f46e5;
            border-radius: 3px;
        }

        /* ═══ SUB HEADER (data pages) ═══ */
        .sub-hdr {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 10px 36px;
        }
        .sub-hdr-title {
            font-weight: bold;
            font-size: 9pt;
            color: #4f46e5;
        }
        .sub-hdr-page {
            font-size: 7pt;
            color: #94a3b8;
            float: right;
        }

        /* ═══ DATA TABLE ═══ */
        .dtable {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        .dtable thead th {
            background: #4f46e5;
            color: #fff;
            padding: 9px 10px;
            font-weight: bold;
            text-align: left;
            font-size: 8pt;
        }
        .dtable tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
            color: #475569;
            vertical-align: top;
        }
        .dtable tbody tr.even td { background: #fafbfc; }
        .tc { text-align: center; }
        .tb { font-weight: bold; color: #1e293b; }
        .tm { font-family: 'DejaVu Sans Mono', monospace; font-weight: bold; color: #7c3aed; text-align: center; }

        /* badges */
        .badge {
            display: inline-block;
            font-size: 6.5pt;
            font-weight: bold;
            padding: 2px 7px;
            border-radius: 3px;
            text-transform: uppercase;
            color: #fff;
        }
        .bg-selesai  { background: #10b981; }
        .bg-berjalan { background: #4f46e5; }
        .bg-draft    { background: #f59e0b; }

        /* unit group */
        .unit-grp td {
            background: #f0f4ff !important;
            font-weight: bold;
            color: #4f46e5;
            padding: 8px 10px;
            border-left: 4px solid #4f46e5;
            font-size: 9pt;
        }

        /* ═══ GALERI ═══ */
        .galeri-table {
            width: 100%;
            border-collapse: collapse;
        }
        .galeri-table td {
            width: 50%;
            padding: 6px;
            vertical-align: top;
        }
        .galeri-item {
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            overflow: hidden;
        }
        .galeri-thumb {
            height: 110px;
            background: #cbd5e1;
            text-align: center;
            line-height: 110px;
            color: #94a3b8;
            font-size: 28pt;
        }
        .galeri-info { padding: 10px; }
        .galeri-name {
            font-weight: bold;
            font-size: 8pt;
            color: #1e293b;
            line-height: 1.3;
        }
        .galeri-meta {
            font-size: 7pt;
            color: #64748b;
            margin-top: 5px;
        }

        /* ═══ DETAIL CARD ═══ */
        .det-card {
            margin-bottom: 22px;
            padding-bottom: 18px;
            border-bottom: 1px dashed #e2e8f0;
        }
        .det-title {
            font-size: 10pt;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 4px;
        }
        .det-meta {
            font-size: 7.5pt;
            color: #64748b;
            margin-bottom: 8px;
        }
        .det-desc {
            font-size: 8pt;
            color: #475569;
            line-height: 1.7;
            text-align: justify;
        }
        .det-thumb {
            width: 160px;
            height: 110px;
            background: #f1f5f9;
            border-radius: 6px;
            text-align: center;
            line-height: 110px;
            color: #cbd5e1;
            font-size: 24pt;
            float: left;
            margin-right: 16px;
            margin-bottom: 8px;
        }

        /* ═══ FOOTER ═══ */
        .doc-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 10px 36px;
            font-size: 7.5pt;
            color: #94a3b8;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }
        .doc-footer-r { float: right; }

        /* ═══ WATERMARK ═══ */
        .watermark {
            position: fixed;
            top: 38%;
            left: 10%;
            font-size: 56pt;
            color: rgba(79, 70, 229, 0.04);
            font-weight: bold;
            transform: rotate(-35deg);
            letter-spacing: 8px;
        }
    </style>
</head>
<body>
@php
    $kegiatans = $kegiatans->sortBy('tanggal');
    if($type == 'rekap-unit') $kegiatans = $kegiatans->sortBy('unit_id');

    if($type == 'galeri-foto') $perPage = 4;
    elseif($type == 'detail-kegiatan') $perPage = 2;
    else $perPage = 13;

    $chunks = $kegiatans->chunk($perPage);
    $showCover   = $options['include_cover'] ?? true;
    $showCharts  = $options['show_chart'] ?? true;
    $showPhoto   = $options['include_photo'] ?? true;
    $showPageNum = $options['show_page_number'] ?? true;
    $showWatermark = $options['use_watermark'] ?? false;
    $showSummary = !in_array($type, ['galeri-foto','daftar-kegiatan','detail-kegiatan']);

    $pageOffset = ($showCover ? 1 : 0) + ($showSummary ? 1 : 0);
    $totalPages = count($chunks) + $pageOffset;

    $bm = \Carbon\Carbon::create()->month((int)($filters['bulan_mulai'] ?? 1))->translatedFormat('F');
    $ba = \Carbon\Carbon::create()->month((int)($filters['bulan_akhir'] ?? 1))->translatedFormat('F');
    $periode = ($bm == $ba ? $bm : "$bm - $ba") . ' ' . ($filters['tahun'] ?? date('Y'));
@endphp

@if($showWatermark)<div class="watermark">DOKAKEGIATAN</div>@endif

{{-- ══════════ COVER ══════════ --}}
@if($showCover)
<div class="page">
    <div class="cover">
        <div class="cover-icon">&#9670;</div>
        <div class="cover-org">PEMERINTAH KOTA PEKALONGAN</div>
        <div class="cover-sub">Dinas Komunikasi dan Informatika</div>
        <div class="cover-line"></div>
        <div class="cover-title">{{ $title }}</div>
        <div class="cover-periode">Periode: {{ $periode }}</div>
        <div class="cover-bottom">
            <div class="cover-bottom-label">Digenerate Pada</div>
            <div class="cover-bottom-date">{{ now()->translatedFormat('d F Y H:i') }}</div>
        </div>
    </div>
</div>
@endif

{{-- ══════════ SUMMARY ══════════ --}}
@if($showSummary)
<div class="page">
    <div class="doc-header">
        <div class="doc-header-org">PEMERINTAH KOTA PEKALONGAN</div>
        <div class="doc-header-sub">Dinas Komunikasi dan Informatika</div>
        <div class="doc-header-title">{{ strtoupper($title) }}</div>
        <div class="doc-header-periode">Periode: {{ $periode }}</div>
    </div>
    <div class="doc-divider"></div>
    <div class="doc-body">
        @if($showCharts)
        <table class="stat-table">
            <tr>
                <td class="s1"><div class="stat-val">{{ number_format($kegiatans->count()) }}</div><div class="stat-lbl">Total Kegiatan</div></td>
                <td class="s2"><div class="stat-val">{{ number_format($kegiatans->sum('media_count')) }}</div><div class="stat-lbl">Total Foto</div></td>
                <td class="s3"><div class="stat-val">{{ $kegiatans->groupBy('unit_id')->count() }}</div><div class="stat-lbl">Unit Aktif</div></td>
                <td class="s4"><div class="stat-val">100%</div><div class="stat-lbl">Validasi</div></td>
            </tr>
        </table>

        <div class="sec-title">&#9632; Distribusi Kegiatan per Minggu</div>
        @php
            $wc = [1=>0,2=>0,3=>0,4=>0,5=>0];
            foreach($kegiatans as $k) { $w = min(5, ceil($k->tanggal->format('d')/7)); $wc[$w]++; }
            $mx = max($wc) ?: 1;
        @endphp
        <table class="chart-table">
            <tr>
                @foreach($wc as $w => $v)
                <td class="chart-val">{{ $v }}</td>
                @endforeach
            </tr>
            <tr>
                @foreach($wc as $w => $v)
                <td class="chart-bar-cell">
                    <div class="chart-bar-inner" style="height: {{ max(8, ($v/$mx)*90) }}px;"></div>
                </td>
                @endforeach
            </tr>
            <tr>
                @foreach($wc as $w => $v)
                <td class="chart-lbl">Minggu {{ $w }}</td>
                @endforeach
            </tr>
        </table>
        @endif

        @if($type == 'rekap-unit')
        <div class="sec-title">&#9632; Kontribusi Unit Kerja</div>
        @php $uStats = $kegiatans->groupBy('unit_id')->take(10); @endphp
        @foreach($uStats as $uid => $items)
        <div class="prog-wrap">
            <div class="prog-label">
                <span class="prog-name">{{ $items->first()->unitKerja->nama_instansi ?? 'Unit Lainnya' }}</span>
                &nbsp;&mdash;&nbsp;
                <span class="prog-count">{{ $items->count() }} kegiatan ({{ round(($items->count()/$kegiatans->count())*100) }}%)</span>
            </div>
            <div class="prog-track"><div class="prog-fill" style="width:{{ ($items->count()/$kegiatans->count())*100 }}%;"></div></div>
        </div>
        @endforeach
        @endif
    </div>
    @if($showPageNum)
    <div class="doc-footer">
        DokaKegiatan &mdash; Kota Pekalongan &copy; {{ date('Y') }}
        <span class="doc-footer-r">Hal. 1 dari {{ $totalPages }}</span>
    </div>
    @endif
</div>
@endif

{{-- ══════════ DATA PAGES ══════════ --}}
@foreach($chunks as $ci => $chunk)
@php $pg = $ci + $pageOffset + 1; @endphp
<div class="page">
    <div class="sub-hdr">
        <span class="sub-hdr-title">{{ strtoupper($title) }}</span>
        <span class="sub-hdr-page">Hal. {{ $pg }} dari {{ $totalPages }}</span>
        <div style="clear:both;"></div>
    </div>
    <div class="doc-body">

    @if($type == 'galeri-foto')
        <div class="sec-title">&#128247; Album Foto Kegiatan</div>
        <table class="galeri-table">
        @foreach($chunk->chunk(2) as $row)
            <tr>
            @foreach($row as $keg)
                <td>
                    <div class="galeri-item">
                        <div class="galeri-thumb">&#128247;</div>
                        <div class="galeri-info">
                            <div class="galeri-name">{{ $keg->judul }}</div>
                            <div class="galeri-meta">#{{ ($ci*$perPage)+$loop->parent->iteration*2-2+$loop->iteration }} &middot; {{ $keg->tanggal->format('d M Y') }} &middot; {{ $keg->media_count }} Foto</div>
                        </div>
                    </div>
                </td>
            @endforeach
            @if($row->count()==1)<td></td>@endif
            </tr>
        @endforeach
        </table>

    @elseif($type == 'detail-kegiatan')
        <div class="sec-title">&#128196; Detail Laporan Kegiatan</div>
        @foreach($chunk as $keg)
        <div class="det-card">
            <div class="det-thumb">&#128247;</div>
            <div class="det-title">{{ $keg->judul }}</div>
            <div class="det-meta">{{ $keg->tanggal->format('d F Y') }} &middot; {{ $keg->unitKerja->nama_instansi ?? '-' }} &middot; {{ $keg->media_count ?: 0 }} Foto</div>
            <div class="det-desc">{{ $keg->deskripsi ?? 'Kegiatan ini didokumentasikan untuk keperluan laporan resmi Pemerintah Kota Pekalongan.' }}</div>
            <div style="clear:both;"></div>
        </div>
        @endforeach

    @else
        @if($type == 'rekap-unit')
            <div class="sec-title">&#127970; Rekapitulasi Berdasarkan Unit Kerja</div>
        @else
            <div class="sec-title">&#128203; Rincian Data Kegiatan</div>
        @endif

        <table class="dtable">
            <thead><tr>
                <th style="width:30px;" class="tc">No</th>
                <th>Judul Kegiatan</th>
                <th style="width:75px;">Tanggal</th>
                @if($type != 'rekap-unit')<th>Unit</th>@endif
                <th style="width:65px;">Status</th>
                @if($showPhoto)<th style="width:35px;" class="tc">Foto</th>@endif
            </tr></thead>
            <tbody>
            @php $lastU = null; @endphp
            @foreach($chunk as $keg)
                @if($type == 'rekap-unit' && $lastU !== ($keg->unitKerja->nama_instansi ?? 'N/A'))
                <tr class="unit-grp"><td colspan="{{ ($showPhoto ? 4 : 3) }}">&#127970; {{ strtoupper($keg->unitKerja->nama_instansi ?? 'Unit Lainnya') }}</td></tr>
                @php $lastU = $keg->unitKerja->nama_instansi ?? 'N/A'; @endphp
                @endif
                <tr class="{{ $loop->even ? 'even' : '' }}">
                    <td class="tc">{{ ($ci*$perPage)+$loop->iteration }}</td>
                    <td class="tb">{{ $keg->judul }}</td>
                    <td>{{ $keg->tanggal->format('d/m/Y') }}</td>
                    @if($type != 'rekap-unit')<td>{{ $keg->unitKerja->nama_instansi ?? '-' }}</td>@endif
                    <td><span class="badge bg-{{ $keg->status == 'selesai' ? 'selesai' : ($keg->status == 'berjalan' ? 'berjalan' : 'draft') }}">{{ strtoupper($keg->status) }}</span></td>
                    @if($showPhoto)<td class="tm">{{ $keg->media_count ?: 0 }}</td>@endif
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

    </div>
    @if($showPageNum)
    <div class="doc-footer">
        DokaKegiatan &mdash; Kota Pekalongan &copy; {{ date('Y') }}
        <span class="doc-footer-r">Hal. {{ $pg }} dari {{ $totalPages }}</span>
    </div>
    @endif
</div>
@endforeach

</body>
</html>
