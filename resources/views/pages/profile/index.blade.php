<x-master-layout title="Profil Saya">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/profile.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header" style="animation:fadeUp .4s ease both;">
        <div class="page-header-left">
            <h1><i class="bi bi-person-fill-gear"></i> Profil Saya</h1>
            <p>Kelola informasi akun, keamanan, dan preferensi notifikasi Anda.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-person-fill-gear"></i> Profil Saya</span>
        </nav>
    </div>

    <!-- ═══ PROFILE HERO ═══ -->
    <div class="profile-hero">

        <!-- Cover -->
        <div class="profile-cover" id="profileCover" style="{{ $user->getFirstMediaUrl('cover') ? 'background-image:url('.$user->getFirstMediaUrl('cover').');background-size:cover;background-position:center;' : '' }}">
            <div class="cover-mesh"></div>
            <canvas id="coverCanvas" style="position:absolute;inset:0;pointer-events:none;"></canvas>
            <button class="cover-edit-btn" onclick="document.getElementById('coverInput').click()">
                <i class="bi bi-camera-fill"></i> Ganti Cover
            </button>
            <input type="file" id="coverInput" accept="image/*" style="display:none;" onchange="changeCover(this)" />
        </div>

        <!-- Body -->
        <div class="profile-body">
            <!-- Avatar -->
            <div class="profile-avatar-wrap">
                <div class="profile-avatar" id="profileAvatar">
                    <input type="file" accept="image/*" onchange="changeAvatar(this)" title="Ganti foto profil" />
                    @php
                        $avatarUrl = $user->getFirstMediaUrl('avatar');
                        if (!$avatarUrl && $user->avatar) {
                            $avatarUrl = str_contains($user->avatar, 'http') ? $user->avatar : asset('storage/' . $user->avatar);
                        }
                    @endphp
                    <span id="avatarLetter" style="{{ $avatarUrl ? 'display:none;' : '' }}">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    <img id="avatarImg" src="{{ $avatarUrl }}" alt="{{ $user->name }}" style="{{ $avatarUrl ? 'display:block;' : 'display:none;' }}" />
                    <div class="avatar-edit-overlay"><i class="bi bi-camera-fill"></i></div>
                </div>
                <div class="avatar-status"></div>
            </div>

            <!-- Info -->
            <div class="profile-info">
                <div class="profile-name">
                    <span class="profile-name-text">{{ $user->name }}</span>
                    @if($user->email_verified_at)
                        <span class="verified-badge"><i class="bi bi-patch-check-fill"></i> Terverifikasi</span>
                    @endif
                </div>
                <div class="profile-role-row">
                    <span class="role-pill role-admin"><i class="bi bi-shield-fill"></i> {{ $user->roles->first()->name ?? 'Pengguna' }}</span>
                    <span class="status-pill">Online</span>
                </div>
                <div class="profile-meta">
                    <div class="profile-meta-item"><i class="bi bi-building-fill"></i> {{ $user->unitKerja->nama_unit ?? '-' }}</div>
                    <div class="profile-meta-item"><i class="bi bi-geo-alt-fill"></i> {{ $user->address ?? 'Lokasi belum diatur' }}</div>
                    <div class="profile-meta-item"><i class="bi bi-calendar3"></i> Bergabung {{ $user->created_at->translatedFormat('M Y') }}</div>
                </div>
            </div>

            <!-- Actions -->
            <div class="profile-actions">
                <button class="btn-profile-edit" onclick="switchTab('tab-profil')">
                    <i class="bi bi-pencil-fill"></i> Edit Profil
                </button>
                <button class="btn-profile-outline" onclick="showToast('Fitur bagikan belum tersedia','info')">
                    <i class="bi bi-share-fill"></i> Bagikan
                </button>
                <button class="btn-profile-outline" onclick="showToast('Fitur ekspor belum tersedia','info')">
                    <i class="bi bi-download"></i> Export
                </button>
            </div>
        </div>

        <!-- Stats -->
        <div class="profile-stats">
            <div class="profile-stat">
                <div class="ps-val" id="stat-kegiatan">0</div>
                <div class="ps-lbl">Total Kegiatan</div>
            </div>
            <div class="profile-stat">
                <div class="ps-val" id="stat-foto">0</div>
                <div class="ps-lbl">Foto Diupload</div>
            </div>
            <div class="profile-stat">
                <div class="ps-val" id="stat-bulan">0</div>
                <div class="ps-lbl">Aktif (Bulan)</div>
            </div>
        </div>
    </div>

    <!-- ═══ CONTENT GRID ═══ -->
    <div class="profile-grid">

        <!-- LEFT SIDEBAR -->
        <div style="display:flex;flex-direction:column;gap:20px;">

            <!-- Info Card -->
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="bi bi-person-lines-fill"></i> Informasi Kontak</div>
                </div>
                <div class="panel-body">
                    <div class="info-list">
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-envelope-fill"></i></div>
                            <div>
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-telephone-fill"></i></div>
                            <div>
                                <div class="info-label">Telepon</div>
                                <div class="info-value">{{ $user->phone ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-at"></i></div>
                            <div>
                                <div class="info-label">Username</div>
                                <div class="info-value">{{ '@' . ($user->username ?? str_replace(' ', '.', strtolower($user->name))) }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="bi bi-building-fill"></i></div>
                            <div>
                                <div class="info-label">Unit Kerja</div>
                                <div class="info-value">{{ $user->unitKerja->nama_unit ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon" style="background:rgba(16,185,129,.1);color:var(--c-green);"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <div class="info-label">Login Terakhir</div>
                                <div class="info-value" style="color:var(--c-green);">{{ $user->last_login_at ? $user->last_login_at->translatedFormat('d M Y, H:i') : 'Belum pernah login' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills (Documentation Performance) -->
            <div class="panel">
                <div class="panel-head">
                    <div class="panel-title"><i class="bi bi-graph-up"></i> Performa Dokumentasi</div>
                </div>
                <div class="panel-body">
                    <div class="skill-row">
                        <div class="skill-top"><span class="skill-name">Konsistensi Upload</span><span class="skill-pct">{{ $stats['consistency'] }}%</span></div>
                        <div class="skill-bar-bg"><div class="skill-bar-fill" style="width:{{ $stats['consistency'] }}%;background:linear-gradient(90deg,var(--c-primary),var(--c-secondary));animation-delay:.1s;"></div></div>
                    </div>
                    <div class="skill-row">
                        <div class="skill-top"><span class="skill-name">Kelengkapan Data</span><span class="skill-pct">{{ $stats['completeness'] }}%</span></div>
                        <div class="skill-bar-bg"><div class="skill-bar-fill" style="width:{{ $stats['completeness'] }}%;background:linear-gradient(90deg,var(--c-green),#34d399);animation-delay:.2s;"></div></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT TABS -->
        <div class="tabs-wrap">
            <!-- Tab nav -->
            <div class="tabs-nav">
                <button class="tab-btn active" id="tab-profil" onclick="switchTab('tab-profil')">
                    <i class="bi bi-person-fill"></i> Profil
                </button>
                <button class="tab-btn" id="tab-keamanan" onclick="switchTab('tab-keamanan')">
                    <i class="bi bi-shield-lock-fill"></i> Keamanan
                </button>
                <button class="tab-btn" id="tab-aktivitas" onclick="switchTab('tab-aktivitas')">
                    <i class="bi bi-clock-history"></i> Aktivitas
                </button>
            </div>

            <!-- ══ TAB: PROFIL ══ -->
            <div class="tab-panel active" id="panel-profil">
                <form id="formProfile" onsubmit="event.preventDefault(); saveProfile();">
                    @csrf
                    <!-- Informasi Dasar -->
                    <div class="form-section-title">Informasi Dasar</div>
                    <div class="form-row-2">
                        <div class="form-group-p">
                            <div class="flabel"><i class="bi bi-person-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Nama Lengkap <span class="req">*</span></div>
                            <div class="fwrap">
                                <i class="bi bi-person-fill ficon"></i>
                                <input type="text" name="name" class="fctrl" value="{{ $user->name }}" required />
                            </div>
                        </div>
                        <div class="form-group-p">
                            <div class="flabel"><i class="bi bi-at" style="color:var(--c-muted);font-size:.85rem;"></i> Username</div>
                            <div class="fwrap">
                                <i class="bi bi-at ficon"></i>
                                <input type="text" name="username" class="fctrl" value="{{ $user->username ?? '' }}" placeholder="{{ str_replace(' ', '.', strtolower($user->name)) }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group-p">
                        <div class="flabel"><i class="bi bi-envelope-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Alamat Email <span class="req">*</span></div>
                        <div class="fwrap">
                            <i class="bi bi-envelope-fill ficon"></i>
                            <input type="email" name="email" class="fctrl" value="{{ $user->email }}" required />
                        </div>
                        <div class="fhint"><i class="bi bi-info-circle"></i> Perubahan email mungkin memerlukan verifikasi ulang.</div>
                    </div>
                    <div class="form-row-2">
                        <div class="form-group-p">
                            <div class="flabel"><i class="bi bi-telephone-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Nomor Telepon</div>
                            <div class="fwrap">
                                <i class="bi bi-telephone-fill ficon"></i>
                                <input type="tel" name="phone" class="fctrl" value="{{ $user->phone }}" />
                            </div>
                        </div>
                        <div class="form-group-p">
                            <div class="flabel"><i class="bi bi-geo-alt-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Lokasi</div>
                            <div class="fwrap">
                                <i class="bi bi-geo-alt-fill ficon"></i>
                                <input type="text" name="address" class="fctrl" value="{{ $user->address }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group-p">
                        <div class="flabel"><i class="bi bi-card-text" style="color:var(--c-muted);font-size:.85rem;"></i> Bio / Deskripsi</div>
                        <div class="fwrap">
                            <textarea name="bio" class="fctrl no-icon" rows="3" style="padding-left:13px;">{{ $user->bio }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="location.reload()"><i class="bi bi-x-circle"></i> Batal</button>
                        <button type="submit" class="btn-save" id="btnSaveProfil"><i class="bi bi-check2-circle"></i> Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- ══ TAB: KEAMANAN ══ -->
            <div class="tab-panel" id="panel-keamanan">
                <div class="form-section-title">Ubah Password</div>
                <div class="form-group-p" style="margin-bottom:14px;">
                    <div class="flabel"><i class="bi bi-lock-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Password Saat Ini <span class="req">*</span></div>
                    <div class="fwrap pw-wrap" style="position:relative;">
                        <i class="bi bi-lock-fill ficon"></i>
                        <input type="password" class="fctrl" id="curPw" placeholder="Password saat ini" style="padding-right:38px;" />
                        <button type="button" class="pw-toggle-btn" onclick="togglePw('curPw','eye1')"><i class="bi bi-eye-fill" id="eye1"></i></button>
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-group-p">
                        <div class="flabel"><i class="bi bi-lock-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Password Baru <span class="req">*</span></div>
                        <div class="fwrap" style="position:relative;">
                            <i class="bi bi-lock-fill ficon"></i>
                            <input type="password" class="fctrl" id="newPw" placeholder="Min. 8 karakter" style="padding-right:38px;" oninput="checkPwStrength(this.value)" />
                            <button type="button" class="pw-toggle-btn" onclick="togglePw('newPw','eye2')"><i class="bi bi-eye-fill" id="eye2"></i></button>
                        </div>
                        <div style="margin-top:6px;">
                            <div style="height:4px;background:var(--c-border);border-radius:99px;overflow:hidden;margin-bottom:4px;">
                                <div id="pwStrBar" style="height:100%;border-radius:99px;transition:width .4s,background .4s;width:0%;"></div>
                            </div>
                            <span id="pwStrLabel" style="font-size:.72rem;font-weight:600;color:var(--c-muted);">Belum diisi</span>
                        </div>
                    </div>
                    <div class="form-group-p">
                        <div class="flabel"><i class="bi bi-lock-fill" style="color:var(--c-muted);font-size:.85rem;"></i> Konfirmasi Password <span class="req">*</span></div>
                        <div class="fwrap" style="position:relative;">
                            <i class="bi bi-lock-fill ficon"></i>
                            <input type="password" class="fctrl" id="confPw" placeholder="Ulangi password baru" style="padding-right:38px;" />
                            <button type="button" class="pw-toggle-btn" onclick="togglePw('confPw','eye3')"><i class="bi bi-eye-fill" id="eye3"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-actions" style="padding-top:12px;">
                    <button class="btn-save" onclick="savePw()"><i class="bi bi-key-fill"></i> Perbarui Password</button>
                </div>
            </div>

            <!-- ══ TAB: AKTIVITAS ══ -->
            <div class="tab-panel" id="panel-aktivitas">
                <div class="activity-timeline" id="actTimeline">
                    <p class="text-center text-muted py-4">Riwayat aktivitas akan muncul di sini.</p>
                </div>
            </div>

        </div><!-- /tabs-wrap -->
    </div><!-- /profile-grid -->

    @push('js')
        <script src="{{ asset('assets/js/profile.js') }}"></script>
        <script>
            $(document).ready(function() {
                animCounter('stat-kegiatan', {{ $stats['total_kegiatan'] }});
                animCounter('stat-foto', {{ $stats['total_foto'] }});
                animCounter('stat-bulan', {{ max(0, (int) now()->diffInMonths($user->created_at)) }});
            });
        </script>
    @endpush
</x-master-layout>
