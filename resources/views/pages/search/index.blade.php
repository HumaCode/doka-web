<x-master-layout>
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-search"></i> Hasil Pencarian</h1>
            <p>Menampilkan hasil untuk kata kunci: <strong>"{{ $q }}"</strong></p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current">Pencarian</span>
        </nav>
    </div>

    <div class="content-row">
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- KEGIATAN RESULTS -->
            <div class="panel fade-up">
                <div class="panel-header">
                    <div class="panel-title"><i class="bi bi-calendar3"></i> Kegiatan ({{ $kegiatans->count() }})</div>
                </div>
                <div class="panel-body">
                    @forelse($kegiatans as $k)
                    <div class="search-result-item">
                        <div class="res-icon i-kegiatan"><i class="bi bi-calendar-event"></i></div>
                        <div class="res-info">
                            <a href="{{ route('kegiatan.show', $k->id) }}" class="res-title">{{ $k->judul }}</a>
                            <div class="res-meta">
                                <span><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }}</span>
                                <span><i class="bi bi-tag"></i> {{ $k->kategori->nama_kategori ?? 'Umum' }}</span>
                            </div>
                        </div>
                        <a href="{{ route('kegiatan.show', $k->id) }}" class="btn-res-go"><i class="bi bi-arrow-right"></i></a>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">Tidak ada kegiatan yang cocok.</div>
                    @endforelse
                </div>
            </div>

            <!-- USER RESULTS -->
            <div class="panel fade-up">
                <div class="panel-header">
                    <div class="panel-title"><i class="bi bi-people"></i> Pengguna ({{ $users->count() }})</div>
                </div>
                <div class="panel-body">
                    @forelse($users as $u)
                    <div class="search-result-item">
                        <div class="res-icon i-user"><i class="bi bi-person-fill"></i></div>
                        <div class="res-info">
                            <div class="res-title">{{ $u->name }}</div>
                            <div class="res-meta">
                                <span><i class="bi bi-envelope"></i> {{ $u->email }}</span>
                                <span><i class="bi bi-shield-check"></i> {{ $u->roles->pluck('name')->implode(', ') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">Tidak ada pengguna yang cocok.</div>
                    @endforelse
                </div>
            </div>

        </div>

        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- UNIT KERJA RESULTS -->
            <div class="panel fade-up">
                <div class="panel-header">
                    <div class="panel-title"><i class="bi bi-building"></i> Unit Kerja ({{ $unitKerjas->count() }})</div>
                </div>
                <div class="panel-body">
                    @forelse($unitKerjas as $uk)
                    <div class="search-result-item">
                        <div class="res-icon i-unit"><i class="bi bi-building"></i></div>
                        <div class="res-info">
                            <div class="res-title">{{ $uk->nama_instansi }}</div>
                            <div class="res-meta">
                                <span><i class="bi bi-geo-alt"></i> {{ $uk->alamat ?? 'Alamat -' }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">Tidak ada unit kerja yang cocok.</div>
                    @endforelse
                </div>
            </div>
            
            <div class="panel fade-up" style="background: var(--c-surface2);">
                <div class="panel-body text-center" style="padding: 30px;">
                    <i class="bi bi-lightbulb" style="font-size: 2rem; color: var(--c-accent);"></i>
                    <h4 style="margin-top: 15px; font-weight: 800;">Tips Pencarian</h4>
                    <p style="font-size: 0.85rem; color: var(--c-muted);">Gunakan kata kunci yang lebih spesifik seperti nama kegiatan atau nama lengkap personil untuk hasil yang lebih akurat.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .search-result-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px;
            border-radius: 12px;
            transition: all 0.2s;
            border-bottom: 1px solid var(--c-border);
        }
        .search-result-item:last-child { border-bottom: none; }
        .search-result-item:hover { background: var(--c-surface2); }
        
        .res-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            font-size: 1.2rem;
            color: #fff;
            flex-shrink: 0;
        }
        .i-kegiatan { background: linear-gradient(135deg, var(--c-primary), var(--c-secondary)); }
        .i-user { background: linear-gradient(135deg, var(--c-pink), #f472b6); }
        .i-unit { background: linear-gradient(135deg, var(--c-green), #34d399); }
        
        .res-info { flex: 1; min-width: 0; }
        .res-title { font-weight: 700; font-size: 0.95rem; color: var(--c-text); text-decoration: none; display: block; margin-bottom: 2px; }
        .res-title:hover { color: var(--c-primary); }
        .res-meta { display: flex; gap: 12px; font-size: 0.75rem; color: var(--c-muted); }
        .res-meta span { display: flex; align-items: center; gap: 4px; }
        
        .btn-res-go {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--c-muted);
            transition: all 0.2s;
            text-decoration: none;
        }
        .search-result-item:hover .btn-res-go {
            background: var(--c-primary);
            color: #fff;
            transform: translateX(3px);
        }

        @media (max-width: 768px) {
            .content-row { grid-template-columns: 1fr; }
            .res-meta { flex-direction: column; gap: 4px; }
        }
    </style>
</x-master-layout>
