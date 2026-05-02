<aside class="sidebar" id="sidebar">

    <!-- Brand -->
    <a href="{{ route('dashboard') }}" class="sidebar-brand">
        <div class="brand-icon-wrap">
            <i class="bi bi-camera-reels-fill"></i>
        </div>
        <div class="brand-text">
            <div class="brand-title">Doka<span>Kegiatan</span></div>
            <div class="brand-sub">DOKUMENTASI</div>
        </div>
    </a>

    <!-- Nav -->
    <nav class="sidebar-nav" id="sidebarNav">

        <!-- MAIN -->
        <div class="nav-category">MAIN</div>
        <div class="nav-item-wrap">
            <a href="{{ route('dashboard') }}"
                class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-label="Dashboard">
                <i class="bi bi-grid-1x2-fill nav-icon"></i>
                <span class="nav-label">Dashboard</span>
            </a>
        </div>

        <!-- MASTER -->
        <div class="nav-category">MASTER</div>
        <div class="nav-item-wrap">
            <a href="{{ route('pengguna.index') }}"
                class="nav-link-item {{ request()->routeIs('pengguna.index') ? 'active' : '' }}" data-label="Pengguna">
                <i class="bi bi-people-fill nav-icon"></i>
                <span class="nav-label">Pengguna</span>
                @if($sidebarNewUserCount > 0)
                    <span class="nav-badge">{{ $sidebarNewUserCount }}</span>
                @endif
            </a>
        </div>
        <div class="nav-item-wrap">
            <a href="{{ route('kategori.index') }}"
                class="nav-link-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}" data-label="Kategori">
                <i class="bi bi-tags-fill nav-icon"></i>
                <span class="nav-label">Kategori</span>
            </a>
        </div>
        <div class="nav-item-wrap">
            <a href="{{ route('unit-kerja.index') }}"
                class="nav-link-item {{ request()->routeIs('unit-kerja.index') ? 'active' : '' }}" data-label="Unit Kerja">
                <i class="bi bi-building-fill nav-icon"></i>
                <span class="nav-label">Unit Kerja</span>
            </a>
        </div>

        <!-- KEGIATAN -->
        <div class="nav-category">KEGIATAN</div>
        <div class="nav-item-wrap">
            <a href="{{ route('kegiatan.index') }}"
                class="nav-link-item {{ request()->routeIs('kegiatan.*') ? 'active' : '' }}" data-label="Semua Kegiatan">
                <i class="bi bi-calendar3-fill nav-icon"></i>
                <span class="nav-label">Semua Kegiatan</span>
                @if($sidebarNewKegiatanCount > 0)
                    <span class="nav-badge" style="background:var(--c-green);">{{ $sidebarNewKegiatanCount }}</span>
                @endif
            </a>
        </div>
        <div class="nav-item-wrap">
            <a href="{{ route('kegiatan.create') }}"
                class="nav-link-item {{ request()->routeIs('kegiatan.create') ? 'active' : '' }}" data-label="Tambah Kegiatan">
                <i class="bi bi-plus-circle-fill nav-icon"></i>
                <span class="nav-label">Tambah Kegiatan</span>
            </a>
        </div>
        <div class="nav-item-wrap">
            <a href="#" class="nav-link-item" data-label="Galeri Foto">
                <i class="bi bi-images nav-icon"></i>
                <span class="nav-label">Galeri Foto</span>
            </a>
        </div>

        <!-- LAPORAN -->
        <div class="nav-category">LAPORAN</div>
        <div class="nav-item-wrap">
            <a href="#" class="nav-link-item" data-label="Laporan Bulanan">
                <i class="bi bi-bar-chart-fill nav-icon"></i>
                <span class="nav-label">Laporan Bulanan</span>
            </a>
        </div>
        <div class="nav-item-wrap">
            <a href="#" class="nav-link-item" data-label="Export PDF">
                <i class="bi bi-file-earmark-pdf-fill nav-icon"></i>
                <span class="nav-label">Export PDF</span>
            </a>
        </div>

        <!-- PENGATURAN -->
        <div class="nav-category">PENGATURAN</div>
        <div class="nav-item-wrap">
            <a href="#" class="nav-link-item" data-label="Profil Saya">
                <i class="bi bi-person-fill-gear nav-icon"></i>
                <span class="nav-label">Profil Saya</span>
            </a>
        </div>
        <div class="nav-item-wrap">
            <a href="#" class="nav-link-item" data-label="Pengaturan Sistem">
                <i class="bi bi-gear-wide-connected nav-icon"></i>
                <span class="nav-label">Pengaturan Sistem</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar footer -->
    <div class="sidebar-footer">
        <div class="sidebar-user-mini">
            <div class="sidebar-avatar-sm">{{ auth()->user()->name[0] }}</div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Administrator</div>
            </div>
        </div>
    </div>
</aside>
