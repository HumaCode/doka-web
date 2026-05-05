<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $settings['app_name'] ?? 'DokaWeb' }} — {{ $settings['app_description'] ?? 'Sistem Dokumentasi Kegiatan Kota Pekalongan' }}</title>

  <!-- SEO Tags -->
  <meta name="description" content="{{ $settings['app_description'] ?? '-' }}">
  <meta name="keywords" content="{{ $settings['meta_keywords'] ?? '-' }}">
  <meta name="author" content="{{ $settings['site_author'] ?? 'Kota Pekalongan' }}">
  
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ $settings['favicon_url'] ?? asset('assets/img/favicon.png') }}" type="image/x-icon">

  <!-- Bootstrap 5.3.3 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
  <!-- AOS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&family=Nunito:wght@700;800;900&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet" />

  <!-- Custom CSS (Separated) -->
  <link rel="stylesheet" href="{{ asset('assets/css/frontend.css') }}" />
</head>
<body>

<!-- Animated background -->
<canvas id="bgCanvas"></canvas>

<!-- ═══════════════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════════════ -->
<nav class="site-nav" id="siteNav">
  <div class="container-xl px-3 px-md-4">
    <a href="#hero" class="nav-brand">
      <div class="nav-brand-icon"><i class="bi bi-camera-reels-fill"></i></div>
      <span class="nav-brand-text">{{ $settings['app_name'] ?? 'Doka' }}<span>Web</span></span>
    </a>

    <ul class="nav-links">
      <li><a href="#fitur"><i class="bi bi-grid-1x2-fill"></i> Fitur</a></li>
      <li><a href="#cara-kerja"><i class="bi bi-diagram-3-fill"></i> Cara Kerja</a></li>
      <li><a href="#statistik"><i class="bi bi-bar-chart-fill"></i> Statistik</a></li>
      <li><a href="#modul"><i class="bi bi-grid-3x2-gap-fill"></i> Modul</a></li>
      <li><a href="#teknologi"><i class="bi bi-cpu-fill"></i> Teknologi</a></li>
    </ul>

    @auth
      <a href="{{ route('dashboard') }}" class="btn-nav-cta">
        <i class="bi bi-grid-1x2-fill"></i> Dashboard
      </a>
    @else
      <a href="{{ route('login') }}" class="btn-nav-cta">
        <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
      </a>
    @endauth

    <button class="nav-hamburger" id="navHamburger" onclick="toggleMobileMenu()">
      <i class="bi bi-list"></i>
    </button>
  </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
  <div class="mobile-drawer">
    <div class="mobile-drawer-head">
      <div class="nav-brand">
        <div class="nav-brand-icon" style="width:32px;height:32px;"><i class="bi bi-camera-reels-fill" style="font-size:.9rem;"></i></div>
        <span class="nav-brand-text" style="font-size:1rem;">Doka<span>Web</span></span>
      </div>
      <button class="mobile-drawer-close" onclick="closeMobileMenu()"><i class="bi bi-x-lg"></i></button>
    </div>
    <div class="mobile-drawer-links">
      <a href="#fitur" onclick="closeMobileMenu()"><i class="bi bi-grid-1x2-fill"></i> Fitur</a>
      <a href="#cara-kerja" onclick="closeMobileMenu()"><i class="bi bi-diagram-3-fill"></i> Cara Kerja</a>
      <a href="#statistik" onclick="closeMobileMenu()"><i class="bi bi-bar-chart-fill"></i> Statistik</a>
      <a href="#modul" onclick="closeMobileMenu()"><i class="bi bi-grid-3x2-gap-fill"></i> Modul</a>
      <a href="#teknologi" onclick="closeMobileMenu()"><i class="bi bi-cpu-fill"></i> Teknologi</a>
    </div>
    <div class="mobile-drawer-foot">
      @auth
        <a href="{{ route('dashboard') }}" class="btn-hero-primary w-100 justify-content-center">Dashboard</a>
      @else
        <a href="{{ route('login') }}" class="btn-hero-primary w-100 justify-content-center">Masuk ke Sistem</a>
      @endauth
    </div>
  </div>
</div>

<!-- ═══════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════ -->
<section id="hero" class="above-bg">
  <div class="container-xl px-3 px-md-4">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6">
        <div class="hero-eyebrow">Kota Pekalongan · Sistem Dokumentasi</div>
        <h1 class="hero-title" data-aos="fade-up">
          {{ $settings['app_name'] ?? 'DokaWeb' }}<br/>
          <span class="hl">Lebih Cepat,</span><br/>
          Lebih Terstruktur
        </h1>
        <p class="hero-desc" data-aos="fade-up" data-aos-delay="100">
          {{ $settings['app_description'] ?? 'Platform dokumentasi kegiatan pemerintah berbasis web yang memudahkan seluruh OPD merekam, mengelola, dan melaporkan kegiatan secara terpusat.' }}
        </p>
        <div class="hero-btns" data-aos="fade-up" data-aos-delay="200">
          <a href="{{ route('login') }}" class="btn-hero-primary">
            <i class="bi bi-box-arrow-in-right"></i> Mulai Sekarang
          </a>
          <a href="#fitur" class="btn-hero-secondary">
            <i class="bi bi-play-circle-fill"></i> Lihat Fitur
          </a>
        </div>
        <div class="hero-stats" data-aos="fade-up" data-aos-delay="300">
          <div class="hero-stat">
            <div class="hero-stat-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);"><i class="bi bi-building-fill"></i></div>
            <div><div class="hero-stat-val">{{ $stats['total_unit'] ?? 0 }}</div><div class="hero-stat-lbl">OPD Terdaftar</div></div>
          </div>
          <div class="hero-stat">
            <div class="hero-stat-icon" style="background:linear-gradient(135deg,#10b981,#06b6d4);"><i class="bi bi-calendar3-fill"></i></div>
            <div><div class="hero-stat-val">{{ number_format($stats['total_kegiatan'] ?? 0, 0, ',', '.') }}</div><div class="hero-stat-lbl">Kegiatan Tercatat</div></div>
          </div>
        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left">
        <div class="hero-visual">
          <!-- Floating cards -->
          <div class="float-card fc-tl d-none d-xl-flex">
            <div class="fc-icon" style="background:linear-gradient(135deg,#10b981,#06b6d4);"><i class="bi bi-check-circle-fill"></i></div>
            <div><div class="fc-label">Kegiatan Selesai</div><div class="fc-sub">Update otomatis</div></div>
          </div>
          <div class="float-card fc-tr d-none d-xl-flex">
            <div class="fc-icon" style="background:linear-gradient(135deg,#ec4899,#f472b6);"><i class="bi bi-images"></i></div>
            <div><div class="fc-label">{{ number_format($stats['total_foto'] ?? 0, 0, ',', '.') }} Foto</div><div class="fc-sub">Telah diunggah</div></div>
          </div>
          <div class="float-card fc-br d-none d-xl-flex">
            <div class="fc-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
            <div><div class="fc-label">Laporan PDF</div><div class="fc-sub">Export 1-klik</div></div>
          </div>

          <!-- Main mockup -->
          <div class="hero-mockup">
            <div class="mockup-topbar">
              <div class="mockup-dot" style="background:#ef4444;"></div>
              <div class="mockup-dot" style="background:#f59e0b;"></div>
              <div class="mockup-dot" style="background:#10b981;"></div>
              <div class="mockup-title">dashboard.html — {{ $settings['app_name'] ?? 'DokaWeb' }}</div>
            </div>
            <div class="mockup-stat-row">
              <div class="mockup-stat"><div class="mockup-stat-val" style="color:#4f46e5;">{{ $stats['total_kegiatan'] ?? 0 }}</div><div class="mockup-stat-lbl">Kegiatan</div></div>
              <div class="mockup-stat"><div class="mockup-stat-val" style="color:#10b981;">{{ $stats['total_foto'] ?? 0 }}</div><div class="mockup-stat-lbl">Foto</div></div>
              <div class="mockup-stat"><div class="mockup-stat-val" style="color:#f59e0b;">{{ $stats['total_unit'] ?? 0 }}</div><div class="mockup-stat-lbl">Unit</div></div>
            </div>
            <div class="mockup-bar"><div class="mockup-bar-fill" style="width:78%;background:linear-gradient(90deg,#4f46e5,#06b6d4);"></div></div>
            <div class="mockup-bar"><div class="mockup-bar-fill" style="width:55%;background:linear-gradient(90deg,#10b981,#34d399);animation-delay:.3s;"></div></div>
            <div class="mockup-bar" style="margin-bottom:14px;"><div class="mockup-bar-fill" style="width:40%;background:linear-gradient(90deg,#f59e0b,#f97316);animation-delay:.6s;"></div></div>
            <div class="mockup-row">
              <div class="mockup-av" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);">A</div>
              <div class="mockup-line-big"></div>
              <div class="mockup-badge" style="background:#f0fdf4;color:#059669;">Selesai</div>
            </div>
            <div class="mockup-row">
              <div class="mockup-av" style="background:linear-gradient(135deg,#10b981,#06b6d4);">U</div>
              <div class="mockup-line-big"></div>
              <div class="mockup-badge" style="background:#eff6ff;color:#4f46e5;">Berjalan</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FITUR
═══════════════════════════════════════════════════════ -->
<section id="fitur" class="above-bg">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-eyebrow"><i class="bi bi-stars"></i> Fitur Unggulan</div>
      <h2 class="section-title">Semua yang Anda Butuhkan<br/><span class="hl">dalam Satu Platform</span></h2>
      <p class="section-desc mx-auto">Dirancang khusus untuk kebutuhan dokumentasi pemerintah daerah dengan antarmuka modern dan mudah digunakan.</p>
    </div>

    <div class="row g-4">
      <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
        <div class="feature-card fc1">
          <div class="feat-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);"><i class="bi bi-calendar3-fill"></i></div>
          <div class="feat-title">Manajemen Kegiatan</div>
          <div class="feat-desc">Input, edit, dan kelola dokumentasi kegiatan lengkap dengan uraian, foto, petugas, dan status kegiatan secara real-time.</div>
          <div class="feat-tags"><span class="feat-tag"><i class="bi bi-check2"></i> CRUD Lengkap</span><span class="feat-tag"><i class="bi bi-check2"></i> Status Tracking</span></div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="60">
        <div class="feature-card fc2">
          <div class="feat-icon" style="background:linear-gradient(135deg,#10b981,#06b6d4);"><i class="bi bi-images"></i></div>
          <div class="feat-title">Galeri Foto Dokumentasi</div>
          <div class="feat-desc">Upload, kelola, dan tampilkan foto kegiatan dengan galeri masonry elegan, lightbox, dan fitur unduh massal.</div>
          <div class="feat-tags"><span class="feat-tag"><i class="bi bi-check2"></i> Drag & Drop</span><span class="feat-tag"><i class="bi bi-check2"></i> Lightbox</span></div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="120">
        <div class="feature-card fc3">
          <div class="feat-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);"><i class="bi bi-bar-chart-fill"></i></div>
          <div class="feat-title">Laporan Bulanan Otomatis</div>
          <div class="feat-desc">Generate laporan bulanan lengkap dengan statistik, grafik distribusi, dan rekap per unit kerja secara otomatis.</div>
          <div class="feat-tags"><span class="feat-tag"><i class="bi bi-check2"></i> Auto Generate</span><span class="feat-tag"><i class="bi bi-check2"></i> Filter Dinamis</span></div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
        <div class="feature-card fc4">
          <div class="feat-icon" style="background:linear-gradient(135deg,#ec4899,#f472b6);"><i class="bi bi-file-earmark-pdf-fill"></i></div>
          <div class="feat-title">Export PDF Profesional</div>
          <div class="feat-desc">Export berbagai jenis laporan ke PDF dengan tampilan profesional, preview halaman, dan opsi kustomisasi konten.</div>
          <div class="feat-tags"><span class="feat-tag"><i class="bi bi-check2"></i> 6 Jenis Dokumen</span><span class="feat-tag"><i class="bi bi-check2"></i> Preview Langsung</span></div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="60">
        <div class="feature-card fc5">
          <div class="feat-icon" style="background:linear-gradient(135deg,#8b5cf6,#a78bfa);"><i class="bi bi-shield-lock-fill"></i></div>
          <div class="feat-title">Manajemen Role & Akses</div>
          <div class="feat-desc">Kelola hak akses pengguna dengan matrix permission yang detail per fitur. Dukung multi-role dan verifikasi akun.</div>
          <div class="feat-tags"><span class="feat-tag"><i class="bi bi-check2"></i> Multi Role</span><span class="feat-tag"><i class="bi bi-check2"></i> Permission Matrix</span></div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="120">
        <div class="feature-card fc6">
          <div class="feat-icon" style="background:linear-gradient(135deg,#ef4444,#f87171);"><i class="bi bi-activity"></i></div>
          <div class="feat-title">Monitoring Aktivitas</div>
          <div class="feat-desc">Pantau seluruh aktivitas pengguna secara real-time. Log lengkap setiap modifikasi data dengan filter canggih.</div>
          <div class="feat-tags"><span class="feat-tag"><i class="bi bi-check2"></i> Real-time Log</span><span class="feat-tag"><i class="bi bi-check2"></i> Auto Refresh</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     CARA KERJA
═══════════════════════════════════════════════════════ -->
<section id="cara-kerja" class="above-bg">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-eyebrow"><i class="bi bi-diagram-3-fill"></i> Cara Kerja</div>
      <h2 class="section-title">Sederhana, <span class="hl">Efisien, Efektif</span></h2>
      <p class="section-desc mx-auto">Hanya 4 langkah mudah untuk mendokumentasikan seluruh kegiatan dengan lengkap dan profesional.</p>
    </div>

    <div class="steps-grid">
      <!-- Step 1 -->
      <div class="step-item" data-aos="fade-up" data-aos-delay="0">
        <div class="step-num-wrap"><div class="step-num" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);">1</div></div>
        <div class="step-body">
          <div class="step-badge" style="background:rgba(79,70,229,.1);color:#4f46e5;"><i class="bi bi-person-plus-fill"></i> Langkah 1</div>
          <div class="step-title">Daftar & Verifikasi</div>
          <div class="step-desc">Buat akun baru, lengkapi profil, pilih instansi / unit kerja Anda, dan tunggu persetujuan Administrator.</div>
          <div class="step-tags"><span class="step-tag">Daftar Online</span><span class="step-tag">Pilih Instansi</span></div>
        </div>
      </div>
      <!-- Step 2 -->
      <div class="step-item" data-aos="fade-up" data-aos-delay="80">
        <div class="step-num-wrap"><div class="step-num" style="background:linear-gradient(135deg,#10b981,#06b6d4);">2</div></div>
        <div class="step-body">
          <div class="step-badge" style="background:rgba(16,185,129,.1);color:#059669;"><i class="bi bi-calendar3-fill"></i> Langkah 2</div>
          <div class="step-title">Input Kegiatan</div>
          <div class="step-desc">Tambahkan kegiatan lengkap — isi judul, uraian, tanggal, lokasi, petugas, kategori, dan tag.</div>
          <div class="step-tags"><span class="step-tag">Editor Lengkap</span><span class="step-tag">Multi Kategori</span></div>
        </div>
      </div>
      <!-- Step 3 -->
      <div class="step-item" data-aos="fade-up" data-aos-delay="160">
        <div class="step-num-wrap"><div class="step-num" style="background:linear-gradient(135deg,#f59e0b,#f97316);">3</div></div>
        <div class="step-body">
          <div class="step-badge" style="background:rgba(245,158,11,.1);color:#d97706;"><i class="bi bi-images"></i> Langkah 3</div>
          <div class="step-title">Upload Foto</div>
          <div class="step-desc">Upload foto dokumentasi dengan drag & drop. Sistem menyusun otomatis ke galeri kegiatan.</div>
          <div class="step-tags"><span class="step-tag">Drag & Drop</span><span class="step-tag">Auto Gallery</span></div>
        </div>
      </div>
      <!-- Step 4 -->
      <div class="step-item" data-aos="fade-up" data-aos-delay="240">
        <div class="step-num-wrap"><div class="step-num" style="background:linear-gradient(135deg,#ec4899,#f472b6);">4</div></div>
        <div class="step-body">
          <div class="step-badge" style="background:rgba(236,72,153,.1);color:#be185d;"><i class="bi bi-file-earmark-pdf-fill"></i> Langkah 4</div>
          <div class="step-title">Export Laporan</div>
          <div class="step-desc">Generate laporan bulanan otomatis ke PDF atau Excel dengan 1 klik. Siap dikirim ke pimpinan.</div>
          <div class="step-tags"><span class="step-tag">Export PDF</span><span class="step-tag">1-Klik Rekap</span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     STATISTIK
═══════════════════════════════════════════════════════ -->
<section id="statistik" class="above-bg">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-eyebrow"><i class="bi bi-graph-up-arrow"></i> Data & Statistik</div>
      <h2 class="section-title">Dipercaya OPD se-<span class="hl">Kota Pekalongan</span></h2>
      <p class="section-desc mx-auto">Angka nyata dari penggunaan sistem {{ $settings['app_name'] ?? 'DokaWeb' }} sejak diluncurkan.</p>
    </div>
    <div class="row g-4 mb-5">
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="0">
        <div class="stat-big-card sb1">
          <div class="stat-big-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);"><i class="bi bi-building-fill"></i></div>
          <div class="stat-big-num" data-counter data-val="{{ $stats['total_unit'] ?? 0 }}" data-suf="">0</div>
          <div class="stat-big-lbl">Unit Kerja / OPD</div>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="80">
        <div class="stat-big-card sb2">
          <div class="stat-big-icon" style="background:linear-gradient(135deg,#10b981,#34d399);"><i class="bi bi-calendar3-fill"></i></div>
          <div class="stat-big-num" data-counter data-val="{{ $stats['total_kegiatan'] ?? 0 }}" data-suf="+">0</div>
          <div class="stat-big-lbl">Kegiatan Terdokumentasi</div>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="160">
        <div class="stat-big-card sb3">
          <div class="stat-big-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);"><i class="bi bi-images"></i></div>
          <div class="stat-big-num" data-counter data-val="{{ $stats['total_foto'] ?? 0 }}" data-suf="+">0</div>
          <div class="stat-big-lbl">Foto Terupload</div>
        </div>
      </div>
      <div class="col-6 col-lg-3" data-aos="zoom-in" data-aos-delay="240">
        <div class="stat-big-card sb4">
          <div class="stat-big-icon" style="background:linear-gradient(135deg,#ec4899,#f472b6);"><i class="bi bi-people-fill"></i></div>
          <div class="stat-big-num" data-counter data-val="{{ $stats['total_user'] ?? 0 }}" data-suf="+">0</div>
          <div class="stat-big-lbl">Pengguna Aktif</div>
        </div>
      </div>
    </div>

    <!-- Progress bars by unit (Visual As-Is) -->
    <div class="row g-4" data-aos="fade-up" data-aos-delay="100">
      <div class="col-md-6">
        <div style="background:rgba(255,255,255,.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.7);border-radius:var(--radius-lg);padding:28px;box-shadow:var(--shadow-sm);">
          <div class="mb-4" style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1rem;color:var(--c-text);display:flex;align-items:center;gap:8px;"><i class="bi bi-building-fill" style="color:#4f46e5;"></i> Kegiatan per Unit Kerja</div>
          <div id="unitBars">
              <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                  <span style="font-size:.82rem;font-weight:700;color:var(--c-text);">Diskominfo</span>
                  <span style="font-family:'DM Mono',monospace;font-size:.75rem;color:var(--c-muted);">100%</span>
                </div>
                <div style="height:7px;background:var(--c-border);border-radius:99px;overflow:hidden;">
                  <div style="height:100%;width:0%;border-radius:99px;background:linear-gradient(90deg,#4f46e5,#06b6d4);transition:width 1.2s cubic-bezier(.22,1,.36,1);" data-w="100%" class="prog-fill"></div>
                </div>
              </div>
              <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                  <span style="font-size:.82rem;font-weight:700;color:var(--c-text);">Setda</span>
                  <span style="font-family:'DM Mono',monospace;font-size:.75rem;color:var(--c-muted);">65%</span>
                </div>
                <div style="height:7px;background:var(--c-border);border-radius:99px;overflow:hidden;">
                  <div style="height:100%;width:0%;border-radius:99px;background:linear-gradient(90deg,#10b981,#34d399);transition:width 1.2s cubic-bezier(.22,1,.36,1);" data-w="65%" class="prog-fill"></div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div style="background:rgba(255,255,255,.8);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,.7);border-radius:var(--radius-lg);padding:28px;box-shadow:var(--shadow-sm);">
          <div class="mb-4" style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1rem;color:var(--c-text);display:flex;align-items:center;gap:8px;"><i class="bi bi-pie-chart-fill" style="color:#10b981;"></i> Distribusi Kategori</div>
          <div id="katBars">
              <div style="margin-bottom:14px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:5px;">
                  <span style="font-size:.82rem;font-weight:700;color:var(--c-text);">Rapat Koordinasi</span>
                  <span style="font-family:'DM Mono',monospace;font-size:.75rem;color:var(--c-muted);">45%</span>
                </div>
                <div style="height:7px;background:var(--c-border);border-radius:99px;overflow:hidden;">
                  <div style="height:100%;width:0%;border-radius:99px;background:linear-gradient(90deg,#4f46e5,#06b6d4);transition:width 1.2s cubic-bezier(.22,1,.36,1);" data-w="45%" class="prog-fill"></div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     MODUL
═══════════════════════════════════════════════════════ -->
<section id="modul" class="above-bg">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-eyebrow"><i class="bi bi-grid-3x2-gap-fill"></i> Modul Sistem</div>
      <h2 class="section-title">Lengkap untuk <span class="hl">Semua Kebutuhan</span></h2>
      <p class="section-desc mx-auto">20+ halaman dan modul yang terintegrasi penuh untuk manajemen dokumentasi kegiatan pemerintah.</p>
    </div>
    <div class="row g-3">
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
        <div class="modul-card"><div class="modul-icon" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);"><i class="bi bi-grid-1x2-fill"></i></div><div><div class="modul-name">Dashboard</div><div class="modul-desc">Ringkasan statistik & aktivitas terkini</div></div><i class="bi bi-chevron-right modul-arrow"></i></div>
      </div>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="40">
        <div class="modul-card"><div class="modul-icon" style="background:linear-gradient(135deg,#10b981,#06b6d4);"><i class="bi bi-calendar3-fill"></i></div><div><div class="modul-name">Manajemen Kegiatan</div><div class="modul-desc">CRUD + detail + galeri kegiatan</div></div><i class="bi bi-chevron-right modul-arrow"></i></div>
      </div>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="80">
        <div class="modul-card"><div class="modul-icon" style="background:linear-gradient(135deg,#ec4899,#f472b6);"><i class="bi bi-images"></i></div><div><div class="modul-name">Galeri Foto</div><div class="modul-desc">Upload massal, lightbox, filter & unduh</div></div><i class="bi bi-chevron-right modul-arrow"></i></div>
      </div>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
        <div class="modul-card"><div class="modul-icon" style="background:linear-gradient(135deg,#f59e0b,#f97316);"><i class="bi bi-bar-chart-fill"></i></div><div><div class="modul-name">Laporan Bulanan</div><div class="modul-desc">Rekap statistik dengan filter lengkap</div></div><i class="bi bi-chevron-right modul-arrow"></i></div>
      </div>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="40">
        <div class="modul-card"><div class="modul-icon" style="background:linear-gradient(135deg,#ef4444,#f87171);"><i class="bi bi-file-earmark-pdf-fill"></i></div><div><div class="modul-name">Export PDF</div><div class="modul-desc">6 jenis dokumen PDF + preview full</div></div><i class="bi bi-chevron-right modul-arrow"></i></div>
      </div>
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="80">
        <div class="modul-card"><div class="modul-icon" style="background:linear-gradient(135deg,#8b5cf6,#a78bfa);"><i class="bi bi-people-fill"></i></div><div><div class="modul-name">Manajemen Pengguna</div><div class="modul-desc">Kelola akun, role, dan verifikasi</div></div><i class="bi bi-chevron-right modul-arrow"></i></div>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     TEKNOLOGI
═══════════════════════════════════════════════════════ -->
<section id="teknologi" class="above-bg">
  <div class="container-xl px-3 px-md-4">
    <div class="text-center mb-5" data-aos="fade-up">
      <div class="section-eyebrow"><i class="bi bi-cpu-fill"></i> Stack Teknologi</div>
      <h2 class="section-title">Dibangun dengan <span class="hl">Teknologi Modern</span></h2>
      <p class="section-desc mx-auto">Kombinasi teknologi terpilih yang stabil, aman, dan mudah dipelihara untuk lingkungan pemerintahan.</p>
    </div>
    <div class="d-flex flex-wrap gap-3 justify-content-center" data-aos="fade-up" data-aos-delay="80">
      <div class="tech-pill"><div class="tech-pill-icon" style="background:#ff2d20;"><i class="bi bi-code-slash"></i></div>Laravel 11</div>
      <div class="tech-pill"><div class="tech-pill-icon" style="background:#4479A1;"><i class="bi bi-database-fill"></i></div>MySQL 8</div>
      <div class="tech-pill"><div class="tech-pill-icon" style="background:#7952b3;"><i class="bi bi-bootstrap-fill"></i></div>Bootstrap 5.3</div>
      <div class="tech-pill"><div class="tech-pill-icon" style="background:#f7df1e;color:#000;"><i class="bi bi-filetype-js"></i></div>JavaScript ES6</div>
    </div>
  </div>
</section>


<!-- ═══════════════════════════════════════════════════════
     CTA
═══════════════════════════════════════════════════════ -->
<section id="cta" class="above-bg" style="padding:100px 0;">
  <div class="container-xl px-3 px-md-4">
    <div class="cta-inner text-center">
      <div class="section-eyebrow mx-auto mb-4" style="background:rgba(255,255,255,.18);border-color:rgba(255,255,255,.3);color:#fff;" data-aos="fade-up">
        <i class="bi bi-rocket-takeoff-fill"></i> Mulai Sekarang
      </div>
      <h2 class="cta-title" data-aos="fade-up" data-aos-delay="60">
        Siap Transformasikan<br/>Dokumentasi Kegiatan Anda?
      </h2>
      <p class="cta-desc mx-auto" style="max-width:520px;" data-aos="fade-up" data-aos-delay="120">
        Bergabung dengan 15+ OPD Kota Pekalongan yang sudah merasakan manfaat {{ $settings['app_name'] ?? 'DokaWeb' }}.
      </p>
      <div class="d-flex gap-3 justify-content-center flex-wrap mb-4" data-aos="fade-up" data-aos-delay="180">
        <a href="{{ route('register') }}" class="btn-cta-white"><i class="bi bi-person-plus-fill"></i> Daftar Gratis</a>
        <a href="{{ route('login') }}" class="btn-cta-ghost"><i class="bi bi-box-arrow-in-right"></i> Sudah Punya Akun</a>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════ -->
<footer class="site-footer">
  <div class="container-xl px-3 px-md-4">
    <div class="row g-5">
      <div class="col-lg-4">
        <div class="d-flex align-items-center gap-10 mb-3" style="gap:10px;">
          <div class="footer-brand-icon"><i class="bi bi-camera-reels-fill"></i></div>
          <div class="footer-brand-name">{{ $settings['app_name'] ?? 'Doka' }}<span>Web</span></div>
        </div>
        <div class="footer-desc">Sistem dokumentasi kegiatan berbasis web untuk OPD Pemerintah Kota Pekalongan.</div>
      </div>
      <div class="col-6 col-lg-2">
        <div class="footer-col-title">Fitur</div>
        <ul class="footer-links-list">
          <li><a href="#fitur">Manajemen Kegiatan</a></li>
          <li><a href="#fitur">Galeri Foto</a></li>
          <li><a href="#fitur">Laporan Bulanan</a></li>
        </ul>
      </div>
      <div class="col-6 col-lg-2">
        <div class="footer-col-title">Sistem</div>
        <ul class="footer-links-list">
          <li><a href="{{ route('login') }}">Masuk</a></li>
          <li><a href="{{ route('register') }}">Daftar</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-divider"></div>
    <div class="footer-bottom">
      <div>&copy; {{ date('Y') }} {{ $settings['app_name'] ?? 'DokaWeb' }} — Pemerintah Kota Pekalongan.</div>
      <div>Handcrafted with <i class="bi bi-heart-fill" style="color:#ec4899;"></i> for better service.</div>
    </div>
  </div>
</footer>

<!-- FAB -->
<button class="fab-scroll" id="fabScroll" onclick="window.scrollTo({top:0, behavior:'smooth'})" title="Kembali ke atas">
  <i class="bi bi-arrow-up"></i>
</button>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="{{ asset('assets/js/frontend.js') }}"></script>
</body>
</html>
