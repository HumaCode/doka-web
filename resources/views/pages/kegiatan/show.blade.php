<x-master-layout>
    <x-slot:title>DokaKegiatan — {{ $data['judul'] }}</x-slot:title>

    @push('css')
        <link rel="stylesheet" href="{{ asset('assets/css/kegiatan-detail.css') }}">
        <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />
    @endpush

    <!-- Reading Progress Bar -->
    <div class="reading-progress"><div class="reading-progress-fill" id="readingBar"></div></div>

    <!-- Page Header -->
    <div class="page-header">
        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
            <a href="{{ route('kegiatan.index') }}" class="ph-back"><i class="bi bi-arrow-left"></i> Kembali</a>
            <nav class="breadcrumb-nav">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
                <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
                <a href="{{ route('kegiatan.index') }}">Semua Kegiatan</a>
                <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
                <span class="bc-current"><i class="bi bi-calendar3-fill"></i> Detail</span>
            </nav>
        </div>
        <div class="ph-actions">
            <button class="btn-act btn-print-act" onclick="printPage()"><i class="bi bi-printer-fill"></i> Cetak</button>
            <button class="btn-act btn-export-act" onclick="exportPDF()"><i class="bi bi-file-earmark-pdf-fill"></i> Export PDF</button>
            <a href="{{ route('kegiatan.edit', $data['id']) }}" class="btn-toolbar btn-add" style="height: 38px;"><i class="bi bi-pencil-fill"></i> Edit</a>
            <button class="btn-act btn-delete-act" onclick="deleteKegiatan('{{ $data['id'] }}', '{{ $data['judul'] }}')"><i class="bi bi-trash3-fill"></i> Hapus</button>
        </div>
    </div>

    <!-- ═══ HERO COVER ═══ -->
    <div class="hero-cover" id="heroCover">
        <img src="{{ $data['cover'] }}" class="hero-cover-img" alt="Cover">
        <div class="hero-cover-overlay"></div>
        
        @if($data['foto_count'] > 0)
            <div class="cover-foto-pill" onclick="openLightbox(0)">
                <i class="bi bi-images"></i> <span id="fotoCount">{{ $data['foto_count'] }} foto</span> — Klik untuk lihat semua
            </div>
        @endif

        <div class="hero-cover-info">
            <div class="hero-badges">
                @php
                    $statusCls = [
                        'selesai' => 'hb-status-selesai',
                        'berjalan' => 'hb-status-berjalan',
                        'draft' => 'hb-status-draft'
                    ][$data['status']] ?? 'hb-status-draft';
                    
                    $statusIcon = [
                        'selesai' => 'bi-check-circle-fill',
                        'berjalan' => 'bi-play-circle-fill',
                        'draft' => 'bi-file-earmark-text-fill'
                    ][$data['status']] ?? 'bi-info-circle-fill';
                @endphp
                <span class="hero-badge {{ $statusCls }}"><i class="bi {{ $statusIcon }}" style="font-size:.5rem;"></i> {{ ucfirst($data['status']) }}</span>
                <span class="hero-badge hb-kat" style="background: {{ $data['kategori']['warna'] }}cc">
                    <i class="bi {{ $data['kategori']['icon'] }}" style="font-size:.7rem;"></i> {{ $data['kategori']['nama'] }}
                </span>
                @if($data['unit']['nama'] !== 'Semua Unit')
                    <span class="hero-badge hb-kat"><i class="bi bi-building-fill" style="font-size:.7rem;"></i> {{ $data['unit']['singkatan'] }}</span>
                @endif
            </div>
            <h1 class="hero-title" id="heroTitle">{{ $data['judul'] }}</h1>
            <div class="hero-meta">
                <div class="hero-meta-item"><i class="bi bi-calendar3"></i> <span>{{ $data['tanggal'] }}</span></div>
                @if($data['waktu'])
                    <div class="hero-meta-item"><i class="bi bi-clock-fill"></i> {{ $data['waktu'] }} WIB</div>
                @endif
                @if($data['lokasi'])
                    <div class="hero-meta-item"><i class="bi bi-geo-alt-fill"></i> {{ $data['lokasi'] }}</div>
                @endif
                <div class="hero-meta-item"><i class="bi bi-person-fill"></i> {{ $data['petugas']['name'] }}</div>
            </div>
        </div>
    </div>

    <!-- ═══ DETAIL GRID ═══ -->
    <div class="detail-grid">

        <!-- ══ LEFT: MAIN CONTENT ══ -->
        <div>
            <!-- Uraian Kegiatan -->
            <div class="det-card">
                <div class="det-card-head dch-indigo">
                    <div class="det-card-title"><i class="bi bi-file-text-fill"></i> Uraian Kegiatan</div>
                    <div style="font-family:'DM Mono',monospace;font-size:.72rem;color:var(--c-muted);" id="wordCount">~0 kata</div>
                </div>
                <div class="det-card-body">
                    <div class="uraian-content" id="uraianContent">
                        {!! $data['uraian'] !!}
                    </div>
                </div>
            </div>

            <!-- Galeri Foto -->
            @if($data['foto_count'] > 0)
                <div class="det-card">
                    <div class="det-card-head dch-amber">
                        <div class="det-card-title"><i class="bi bi-images"></i> Galeri Foto Dokumentasi</div>
                        <button class="btn-act btn-export-act" style="padding:7px 14px;font-size:.75rem;" onclick="downloadAllPhotos()">
                            <i class="bi bi-download"></i> Unduh Semua
                        </button>
                    </div>
                    <div class="det-card-body">
                        <div class="gallery-grid" id="galleryGrid">
                            @foreach($data['foto'] as $index => $foto)
                                <div class="gallery-item" onclick="openLightbox({{ $index }})">
                                    <img src="{{ $foto['url'] }}" alt="Foto {{ $index + 1 }}" loading="lazy">
                                    <div class="gallery-item-overlay"><i class="bi bi-search"></i></div>
                                    <div class="gallery-item-num">{{ $index + 1 }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Kegiatan Terkait -->
            @if(count($relatedData) > 0)
                <div class="det-card">
                    <div class="det-card-head dch-slate">
                        <div class="det-card-title"><i class="bi bi-grid-3x2-gap-fill"></i> Kegiatan Terkait</div>
                        <a href="{{ route('kegiatan.index') }}" style="font-size:.78rem;font-weight:700;color:var(--c-primary);text-decoration:none;display:flex;align-items:center;gap:4px;">
                            Lihat Semua <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <div class="det-card-body">
                        <div class="related-grid">
                            @foreach($relatedData as $rel)
                                <a href="{{ route('kegiatan.show', $rel['id']) }}" class="related-card">
                                    <div class="rc-cover">
                                        <img src="{{ $rel['cover'] }}" alt="{{ $rel['judul'] }}">
                                    </div>
                                    <div class="rc-body">
                                        <div class="rc-kat">{{ $rel['kategori']['nama'] }}</div>
                                        <div class="rc-title">{{ $rel['judul'] }}</div>
                                        <div class="rc-date"><i class="bi bi-calendar3"></i> {{ $rel['tanggal'] }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- ══ RIGHT: INFO SIDEBAR ══ -->
        <aside>
            <!-- Informasi Umum -->
            <div class="side-info-card">
                <div class="sic-head"><div class="sic-title"><i class="bi bi-info-circle-fill"></i> Informasi Kegiatan</div></div>
                <div class="sic-body">
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-circle-fill" style="font-size:.55rem;"></i></div>
                        <div>
                            <div class="info-label">Status</div>
                            <div class="info-val">
                                @php
                                    $sbCls = [
                                        'selesai' => 'sb-selesai',
                                        'berjalan' => 'sb-berjalan',
                                        'draft' => 'sb-draft'
                                    ][$data['status']] ?? 'sb-draft';
                                @endphp
                                <span class="status-badge {{ $sbCls }}">{{ ucfirst($data['status']) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-calendar3"></i></div>
                        <div>
                            <div class="info-label">Tanggal</div>
                            <div class="info-val">{{ $data['tanggal'] }}</div>
                        </div>
                    </div>
                    @if($data['waktu'])
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <div class="info-label">Waktu</div>
                                <div class="info-val">{{ $data['waktu'] }} WIB</div>
                            </div>
                        </div>
                    @endif
                    @if($data['lokasi'])
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <div class="info-label">Lokasi</div>
                                <div class="info-val">{{ $data['lokasi'] }}</div>
                            </div>
                        </div>
                    @endif
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-tags-fill"></i></div>
                        <div>
                            <div class="info-label">Kategori</div>
                            <div class="info-val">
                                <span class="kat-pill" style="background:{{ $data['kategori']['warna'] }}15; color:{{ $data['kategori']['warna'] }};">
                                    <i class="bi {{ $data['kategori']['icon'] }}"></i> {{ $data['kategori']['nama'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-building-fill"></i></div>
                        <div>
                            <div class="info-label">Unit Kerja</div>
                            <div class="info-val">{{ $data['unit']['nama'] }}</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="bi bi-people-fill"></i></div>
                        <div>
                            <div class="info-label">Jumlah Peserta</div>
                            <div class="info-val">{{ $data['jumlah_peserta'] }} orang</div>
                        </div>
                    </div>
                    @if($data['narasumber'])
                        <div class="info-item">
                            <div class="info-icon"><i class="bi bi-person-video3"></i></div>
                            <div>
                                <div class="info-label">Narasumber</div>
                                <div class="info-val">{{ $data['narasumber'] }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistik -->
            <div class="side-info-card">
                <div class="sic-head"><div class="sic-title"><i class="bi bi-bar-chart-fill"></i> Statistik</div></div>
                <div class="sic-body">
                    <div class="stats-row">
                        <div class="stat-box">
                            <div class="stat-box-val">{{ $data['foto_count'] }}</div>
                            <div class="stat-box-lbl">Foto</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-box-val">{{ $data['attachment_count'] }}</div>
                            <div class="stat-box-lbl">Lampiran</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Petugas -->
            <div class="side-info-card">
                <div class="sic-head"><div class="sic-title"><i class="bi bi-person-badge-fill"></i> Petugas</div></div>
                <div class="sic-body">
                    <div class="petugas-item">
                        <div class="p-av" style="background: var(--c-primary);">{{ $data['petugas']['initials'] }}</div>
                        <div>
                            <div class="p-name">{{ $data['petugas']['name'] }}</div>
                            <div class="p-role">Petugas Dokumentasi</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            @if(!empty($data['tags']))
                <div class="side-info-card">
                    <div class="sic-head"><div class="sic-title"><i class="bi bi-hash"></i> Tag</div></div>
                    <div class="sic-body">
                        <div class="tag-list">
                            @php
                                $tags = is_array($data['tags']) ? $data['tags'] : explode(',', $data['tags']);
                            @endphp
                            @foreach($tags as $tag)
                                <span class="tag-chip"><i class="bi bi-hash" style="font-size:.65rem;"></i> {{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Dokumen Lampiran -->
            @if($data['attachment_count'] > 0)
                <div class="side-info-card">
                    <div class="sic-head"><div class="sic-title"><i class="bi bi-paperclip"></i> Dokumen Lampiran</div></div>
                    <div class="sic-body">
                        @foreach($data['attachments'] as $doc)
                            <div class="doc-item">
                                @php
                                    $ext = pathinfo($doc['file_name'], PATHINFO_EXTENSION);
                                    $iconCls = 'bi-file-earmark-fill';
                                    $bg = 'linear-gradient(135deg,#64748b,#94a3b8)';
                                    
                                    if($ext == 'pdf') { $iconCls = 'bi-file-earmark-pdf-fill'; $bg = 'linear-gradient(135deg,#ef4444,#f87171)'; }
                                    elseif(in_array($ext, ['doc','docx'])) { $iconCls = 'bi-file-earmark-word-fill'; $bg = 'linear-gradient(135deg,#2563eb,#3b82f6)'; }
                                    elseif(in_array($ext, ['xls','xlsx'])) { $iconCls = 'bi-file-earmark-excel-fill'; $bg = 'linear-gradient(135deg,#10b981,#34d399)'; }
                                @endphp
                                <div class="doc-icon" style="background:{{ $bg }};"><i class="bi {{ $iconCls }}"></i></div>
                                <div class="doc-info">
                                    <div class="doc-name" title="{{ $doc['file_name'] }}">{{ $doc['file_name'] }}</div>
                                    <div class="doc-size">{{ strtoupper($ext) }} · {{ $doc['size'] }}</div>
                                </div>
                                <a href="{{ $doc['download_url'] }}" class="btn-doc-dl">
                                    <i class="bi bi-download"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </aside>
    </div>

    <!-- ═══════════ LIGHTBOX ═══════════ -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" onclick="closeLightbox()"><i class="bi bi-x-lg"></i></button>
        <button class="lightbox-nav lightbox-prev" onclick="event.stopPropagation();navLightbox(-1)"><i class="bi bi-chevron-left"></i></button>
        <div class="lightbox-inner" onclick="event.stopPropagation()">
            <img src="" id="lightboxImg" class="lightbox-img" alt="" />
        </div>
        <button class="lightbox-nav lightbox-next" onclick="event.stopPropagation();navLightbox(1)"><i class="bi bi-chevron-right"></i></button>
        <div class="lightbox-caption" id="lightboxCaption"></div>
        <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>

    <!-- FAB -->
    <button class="fab" id="fabBtn" onclick="scrollToTop()"><i class="bi bi-arrow-up"></i></button>

    @push('js')
        <script>
            window.kegiatanPhotos = {!! json_encode($data['foto']) !!};
        </script>
        <script src="{{ asset('assets/js/kegiatan-detail.js') }}"></script>
    @endpush
</x-master-layout>
