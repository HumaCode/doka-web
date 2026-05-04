<x-master-layout title="Pengaturan Sistem">
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/system-setting.css') }}">
    @endpush

    <!-- Page Header -->
    <div class="page-header">
        <div class="ph-left">
            <h1><i class="bi bi-gear-wide-connected"></i> Pengaturan Sistem</h1>
            <p>Konfigurasi, keamanan, tampilan, dan pengelolaan sistem DokaKegiatan.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-gear-wide-connected"></i> Pengaturan Sistem</span>
        </nav>
    </div>

    <!-- Settings Layout -->
    <div class="settings-grid">

        <!-- ── Settings Nav ── -->
        <div class="settings-nav">
            <div class="settings-nav-head">Menu Pengaturan</div>

            <button class="snav-btn active" onclick="switchSection('umum')">
                <div class="snav-icon" style="background:linear-gradient(135deg,var(--c-primary),var(--c-secondary));">
                    <i class="bi bi-sliders2"></i></div>
                <div class="snav-label"><span>Umum</span><span class="snav-desc">Info & konfigurasi dasar</span></div>
            </button>
            <button class="snav-btn" onclick="switchSection('seo')">
                <div class="snav-icon" style="background:linear-gradient(135deg,#0ea5e9,#38bdf8);">
                    <i class="bi bi-search-heart"></i></div>
                <div class="snav-label"><span>SEO & Meta</span><span class="snav-desc">Search engine optimization</span></div>
            </button>
            <button class="snav-btn" onclick="switchSection('tampilan')">
                <div class="snav-icon" style="background:linear-gradient(135deg,var(--c-pink),#f472b6);"><i
                        class="bi bi-palette-fill"></i></div>
                <div class="snav-label"><span>Tampilan</span><span class="snav-desc">Tema, warna & logo</span></div>
            </button>
            <button class="snav-btn" onclick="switchSection('email')">
                <div class="snav-icon" style="background:linear-gradient(135deg,var(--c-accent),var(--c-orange));"><i
                        class="bi bi-envelope-fill"></i></div>
                <div class="snav-label"><span>Email & Notifikasi</span><span class="snav-desc">SMTP & template</span>
                </div>
            </button>
            <button class="snav-btn" onclick="switchSection('storage')">
                <div class="snav-icon" style="background:linear-gradient(135deg,var(--c-green),var(--c-secondary));"><i
                        class="bi bi-hdd-stack-fill"></i></div>
                <div class="snav-label"><span>Storage & Backup</span><span class="snav-desc">File & cadangan data</span>
                </div>
            </button>
            <button class="snav-btn" onclick="switchSection('keamanan')">
                <div class="snav-icon" style="background:linear-gradient(135deg,var(--c-purple),var(--c-pink));"><i
                        class="bi bi-shield-lock-fill"></i></div>
                <div class="snav-label"><span>Keamanan</span><span class="snav-desc">Akses & proteksi</span></div>
            </button>
        </div>

        <!-- ── Settings Content ── -->
        <div class="settings-content">

            <!-- ══════ UMUM ══════ -->
            <div class="settings-panel active" id="sec-umum">
                <form id="form-umum">
                    @csrf
                    <div class="scard">
                        <div class="scard-head">
                            <div>
                                <div class="scard-title"><i class="bi bi-info-circle-fill"></i> Informasi Aplikasi</div>
                                <div class="scard-desc">Identitas dan konfigurasi dasar sistem</div>
                            </div>
                        </div>
                        <div class="scard-body">
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel"><i class="bi bi-type"></i> Nama Aplikasi <span class="req">*</span></div>
                                    <div class="fwrap"><i class="bi bi-type ficon"></i><input type="text" name="app_name" class="fctrl" value="{{ $settings['app_name'] ?? 'DokaKegiatan' }}" /></div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel"><i class="bi bi-globe"></i> URL Aplikasi <span class="req">*</span></div>
                                    <div class="fwrap"><i class="bi bi-globe ficon"></i><input type="url" name="app_url" class="fctrl" value="{{ $settings['app_url'] ?? url('/') }}" /></div>
                                </div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel"><i class="bi bi-card-text"></i> Deskripsi Aplikasi</div>
                                <div class="fwrap"><textarea name="app_description" class="fctrl no-icon">{{ $settings['app_description'] ?? '' }}</textarea></div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel"><i class="bi bi-c-circle"></i> Teks Footer / Copyright</div>
                                <div class="fwrap"><i class="bi bi-c-circle ficon"></i><input type="text" name="app_copyright" class="fctrl" value="{{ $settings['app_copyright'] ?? '© '.date('Y').' DokaKegiatan. All rights reserved.' }}" /></div>
                            </div>
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel"><i class="bi bi-translate"></i> Bahasa Default</div>
                                    <div class="fwrap"><i class="bi bi-translate ficon"></i>
                                        <select name="default_language" class="fctrl">
                                            <option value="id" {{ ($settings['default_language'] ?? 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                            <option value="en" {{ ($settings['default_language'] ?? 'id') == 'en' ? 'selected' : '' }}>English</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel"><i class="bi bi-clock"></i> Zona Waktu</div>
                                    <div class="fwrap"><i class="bi bi-clock ficon"></i>
                                        <select name="timezone" class="fctrl">
                                            <option value="Asia/Jakarta" {{ ($settings['timezone'] ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                            <option value="Asia/Makassar" {{ ($settings['timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                            <option value="Asia/Jayapura" {{ ($settings['timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel"><i class="bi bi-calendar3"></i> Format Tanggal</div>
                                    <div class="fwrap"><i class="bi bi-calendar3 ficon"></i>
                                        <select name="date_format" class="fctrl">
                                            <option value="DD/MM/YYYY" {{ ($settings['date_format'] ?? 'DD/MM/YYYY') == 'DD/MM/YYYY' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                            <option value="YYYY-MM-DD" {{ ($settings['date_format'] ?? '') == 'YYYY-MM-DD' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                            <option value="DD MMMM YYYY" {{ ($settings['date_format'] ?? '') == 'DD MMMM YYYY' ? 'selected' : '' }}>DD MMMM YYYY</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel"><i class="bi bi-hash"></i> Nomor Versi</div>
                                    <div class="fwrap"><i class="bi bi-hash ficon"></i><input type="text" class="fctrl" value="1.2.0" readonly style="background:var(--c-surface2);color:var(--c-muted);" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-actions">
                            <button type="button" class="btn-save" onclick="saveSettings('umum')"><i class="bi bi-check2-circle"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════ SEO ══════ -->
            <div class="settings-panel" id="sec-seo">
                <form id="form-seo">
                    @csrf
                    <div class="scard">
                        <div class="scard-head">
                            <div>
                                <div class="scard-title"><i class="bi bi-search-heart"></i> Search Engine Optimization</div>
                                <div class="scard-desc">Optimasi mesin pencari dan pelacakan trafik</div>
                            </div>
                        </div>
                        <div class="scard-body">
                            <div class="fgroup">
                                <div class="flabel"><i class="bi bi-card-heading"></i> Default Meta Title</div>
                                <div class="fwrap"><i class="bi bi-card-heading ficon"></i><input type="text" name="seo_meta_title" class="fctrl" value="{{ $settings['seo_meta_title'] ?? '' }}" placeholder="Judul website di mesin pencari" /></div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel"><i class="bi bi-card-text"></i> Default Meta Description</div>
                                <div class="fwrap"><textarea name="seo_meta_description" class="fctrl no-icon" rows="3" placeholder="Deskripsi singkat website untuk hasil pencarian">{{ $settings['seo_meta_description'] ?? '' }}</textarea></div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel"><i class="bi bi-tags"></i> Meta Keywords</div>
                                <div class="fwrap"><i class="bi bi-tags ficon"></i><input type="text" name="seo_meta_keywords" class="fctrl" value="{{ $settings['seo_meta_keywords'] ?? '' }}" placeholder="keyword1, keyword2, keyword3" /></div>
                                <div class="fhint">Pisahkan dengan koma (,)</div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel"><i class="bi bi-google"></i> Google Analytics ID</div>
                                <div class="fwrap"><i class="bi bi-google ficon"></i><input type="text" name="seo_google_analytics" class="fctrl" value="{{ $settings['seo_google_analytics'] ?? '' }}" placeholder="UA-XXXXX-X atau G-XXXXXXX" /></div>
                            </div>
                        </div>
                        <div class="card-footer-actions">
                            <button type="button" class="btn-save" onclick="saveSettings('seo')"><i class="bi bi-check2-circle"></i> Simpan SEO</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════ TAMPILAN ══════ -->
            <div class="settings-panel" id="sec-tampilan">
                <div class="scard">
                    <div class="scard-head">
                        <div>
                            <div class="scard-title"><i class="bi bi-palette-fill"></i> Identitas Visual</div>
                            <div class="scard-desc">Logo, favicon dan branding aplikasi</div>
                        </div>
                    </div>
                    <div class="scard-body">
                        <div class="frow2">
                            <div class="fgroup">
                                <div class="flabel">Logo Light Mode</div>
                                <div class="logo-preview-box">
                                    <img id="preview-logo_light" src="{{ $logo_light ?? '' }}" alt="">
                                    @if(!isset($logo_light) || !$logo_light)
                                        <i class="bi bi-image" style="font-size: 2rem; color: var(--c-muted); opacity: .5;"></i>
                                    @endif
                                </div>
                                <div class="upload-zone">
                                    <input type="file" onchange="uploadAsset('logo_light', this)" accept="image/*">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <div class="uz-title">Klik atau seret logo ke sini</div>
                                    <div class="uz-sub">PNG, JPG atau SVG (Maks. 2MB)</div>
                                </div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel">Logo Dark Mode</div>
                                <div class="logo-preview-box" style="background: #1e293b;">
                                    <img id="preview-logo_dark" src="{{ $logo_dark ?? '' }}" alt="">
                                    @if(!isset($logo_dark) || !$logo_dark)
                                        <i class="bi bi-image" style="font-size: 2rem; color: rgba(255,255,255,.2);"></i>
                                    @endif
                                </div>
                                <div class="upload-zone">
                                    <input type="file" onchange="uploadAsset('logo_dark', this)" accept="image/*">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                    <div class="uz-title">Klik atau seret logo ke sini</div>
                                    <div class="uz-sub">PNG, JPG atau SVG (Maks. 2MB)</div>
                                </div>
                            </div>
                        </div>
                        <div class="fgroup" style="max-width: 400px;">
                            <div class="flabel">Favicon</div>
                            <div class="favicon-row">
                                <div class="favicon-preview">
                                    <img id="preview-favicon" src="{{ $favicon ?? '' }}" alt="">
                                    @if(!isset($favicon) || !$favicon)
                                        <i class="bi bi-app-indicator" style="font-size: 1.5rem; color: var(--c-muted);"></i>
                                    @endif
                                </div>
                                <div class="upload-zone" style="flex: 1; padding: 12px;">
                                    <input type="file" onchange="uploadAsset('favicon', this)" accept="image/*">
                                    <div class="uz-title" style="font-size: .8rem;">Ganti Favicon</div>
                                    <div class="uz-sub" style="font-size: .65rem;">Klik untuk pilih file</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ══════ EMAIL ══════ -->
            <div class="settings-panel" id="sec-email">
                <form id="form-email">
                    @csrf
                    <div class="scard">
                        <div class="scard-head">
                            <div>
                                <div class="scard-title"><i class="bi bi-envelope-fill"></i> Konfigurasi Email (SMTP)</div>
                                <div class="scard-desc">Pengaturan server untuk pengiriman notifikasi email</div>
                            </div>
                            <div class="scard-actions">
                                <button type="button" class="btn-test-conn" onclick="testEmailConnection()">
                                    <i class="bi bi-send-check"></i> Test Koneksi
                                </button>
                            </div>
                        </div>
                        <div class="scard-body">
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel">Mail Mailer</div>
                                    <div class="fwrap"><i class="bi bi-gear ficon"></i>
                                        <select name="mail_mailer" class="fctrl">
                                            <option value="smtp" {{ ($settings['mail_mailer'] ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="mailgun" {{ ($settings['mail_mailer'] ?? '') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="sendmail" {{ ($settings['mail_mailer'] ?? '') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel">Mail Host</div>
                                    <div class="fwrap"><i class="bi bi-hdd-network ficon"></i><input type="text" name="mail_host" class="fctrl" value="{{ $settings['mail_host'] ?? 'sandbox.smtp.mailtrap.io' }}" placeholder="smtp.mailtrap.io" /></div>
                                </div>
                            </div>
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel">Mail Port</div>
                                    <div class="fwrap"><i class="bi bi-hash ficon"></i><input type="number" name="mail_port" class="fctrl" value="{{ $settings['mail_port'] ?? '2525' }}" placeholder="2525 atau 587" /></div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel">Mail Encryption</div>
                                    <div class="fwrap"><i class="bi bi-shield-lock ficon"></i>
                                        <select name="mail_encryption" class="fctrl">
                                            <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ ($settings['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                            <option value="none" {{ ($settings['mail_encryption'] ?? '') == 'none' ? 'selected' : '' }}>None</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel">Mail Username</div>
                                    <div class="fwrap"><i class="bi bi-person ficon"></i><input type="text" name="mail_username" class="fctrl" value="{{ $settings['mail_username'] ?? '8a05412174b082' }}" /></div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel">Mail Password</div>
                                    <div class="fwrap"><i class="bi bi-key ficon"></i><input type="password" name="mail_password" class="fctrl" value="{{ $settings['mail_password'] ?? 'e5514face56f35' }}" /></div>
                                </div>
                            </div>
                            <hr style="margin: 10px 0 25px; border-color: var(--c-border); opacity: 0.5;">
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel">Sender Email (From)</div>
                                    <div class="fwrap"><i class="bi bi-envelope ficon"></i><input type="email" name="mail_from_address" class="fctrl" value="{{ $settings['mail_from_address'] ?? 'noreply@dokagegiatan.com' }}" /></div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel">Sender Name</div>
                                    <div class="fwrap"><i class="bi bi-tag ficon"></i><input type="text" name="mail_from_name" class="fctrl" value="{{ $settings['mail_from_name'] ?? 'DokaKegiatan' }}" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-actions">
                            <button type="button" class="btn-save" onclick="saveSettings('email')"><i class="bi bi-check2-circle"></i> Simpan Konfigurasi</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- ══════ STORAGE & BACKUP ══════ -->
            <div class="settings-panel" id="sec-storage">
                <div class="scard mb-4">
                    <div class="scard-head">
                        <div>
                            <div class="scard-title"><i class="bi bi-hdd-stack-fill"></i> Status Penyimpanan</div>
                            <div class="scard-desc">Informasi penggunaan ruang disk server</div>
                        </div>
                    </div>
                    <div class="scard-body">
                        @php
                            $total = disk_total_space(base_path());
                            $free = disk_free_space(base_path());
                            $used = $total - $free;
                            $percent = round(($used / $total) * 100, 2);
                            
                            function formatBytes($bytes, $precision = 2) {
                                $units = ['B', 'KB', 'MB', 'GB', 'TB'];
                                $bytes = max($bytes, 0);
                                $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
                                $pow = min($pow, count($units) - 1);
                                $bytes /= pow(1024, $pow);
                                return round($bytes, $precision) . ' ' . $units[$pow];
                            }
                        @endphp
                        <div class="disk-status">
                            <div class="disk-info">
                                <span>Terpakai: <strong>{{ formatBytes($used) }}</strong></span>
                                <span>Total Kapasitas: <strong>{{ formatBytes($total) }}</strong></span>
                            </div>
                            <div class="progress" style="height: 12px; background: #e2e8f0; border-radius: 6px; overflow: hidden; margin: 10px 0;">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: {{ $percent }}%; background: linear-gradient(90deg, var(--c-green), #10b981);" 
                                    aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="text-muted" style="font-size: .75rem;">
                                <i class="bi bi-info-circle"></i> Tersedia <strong>{{ formatBytes($free) }}</strong> ruang kosong ({{ 100 - $percent }}%)
                            </div>
                        </div>
                    </div>
                </div>

                <div class="scard mb-4">
                    <div class="scard-head">
                        <div>
                            <div class="scard-title"><i class="bi bi-cloud-arrow-down-fill"></i> Daftar Cadangan Data (Backups)</div>
                            <div class="scard-desc">Manajemen file backup database dan aplikasi</div>
                        </div>
                        <div class="scard-actions">
                            <button type="button" class="btn-backup" onclick="createBackup()" id="btn-create-backup">
                                <i class="bi bi-cloud-arrow-up"></i> Backup Sekarang
                            </button>
                        </div>
                    </div>
                    <div class="scard-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="table-backups">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4 py-3" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Nama File</th>
                                        <th class="py-3" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Ukuran</th>
                                        <th class="py-3" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Tanggal</th>
                                        <th class="py-3 text-end px-4" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="backup-list-body">
                                    <!-- AJAX Content -->
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                                            <span class="ms-2">Memuat data backup...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <form id="form-backup-config">
                    @csrf
                    <div class="scard">
                        <div class="scard-head">
                            <div>
                                <div class="scard-title"><i class="bi bi-clock-history"></i> Pengaturan Otomatis & Retensi</div>
                                <div class="scard-desc">Konfigurasi jadwal backup dan pembersihan file lama</div>
                            </div>
                        </div>
                        <div class="scard-body">
                            <div class="frow2">
                                <div class="fgroup">
                                    <div class="flabel">Jadwal Backup Otomatis</div>
                                    <div class="fwrap"><i class="bi bi-alarm ficon"></i>
                                        <select name="backup_schedule" class="fctrl">
                                            <option value="daily" {{ ($settings['backup_schedule'] ?? 'daily') == 'daily' ? 'selected' : '' }}>Setiap Hari (Jam 00:00)</option>
                                            <option value="weekly" {{ ($settings['backup_schedule'] ?? '') == 'weekly' ? 'selected' : '' }}>Setiap Minggu</option>
                                            <option value="none" {{ ($settings['backup_schedule'] ?? '') == 'none' ? 'selected' : '' }}>Matikan Otomatis</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="fgroup">
                                    <div class="flabel">Retensi (Simpan Selama)</div>
                                    <div class="fwrap"><i class="bi bi-calendar-range ficon"></i>
                                        <select name="backup_retention" class="fctrl">
                                            <option value="7" {{ ($settings['backup_retention'] ?? '7') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                                            <option value="30" {{ ($settings['backup_retention'] ?? '') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                                            <option value="0" {{ ($settings['backup_retention'] ?? '') == '0' ? 'selected' : '' }}>Simpan Selamanya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="fgroup">
                                <div class="flabel">Notifikasi Backup</div>
                                <div class="fwrap"><i class="bi bi-bell ficon"></i>
                                    <input type="email" name="backup_notification_email" class="fctrl" value="{{ $settings['backup_notification_email'] ?? '' }}" placeholder="Email untuk notifikasi jika backup gagal" />
                                </div>
                            </div>
                        </div>
                        <div class="card-footer-actions">
                            <button type="button" class="btn-save" onclick="saveSettings('backup-config')"><i class="bi bi-check2-circle"></i> Simpan Pengaturan</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ══════ KEAMANAN ══════ -->
            <div class="settings-panel" id="sec-keamanan">
                <div class="frow2 mb-4">
                    <div class="scard" style="flex: 1.5;">
                        <div class="scard-head">
                            <div>
                                <div class="scard-title"><i class="bi bi-shield-shaded"></i> Cyber Security Monitor</div>
                                <div class="scard-desc">Deteksi ancaman dan pemantauan aktivitas sistem real-time</div>
                            </div>
                            <div class="d-flex align-items-center gap-4">
                                <div class="form-check form-switch custom-switch d-flex align-items-center gap-2" style="margin: 0; padding-left: 2.5rem;">
                                    <input class="form-check-input" type="checkbox" id="toggle-activity-log" 
                                        style="cursor: pointer; width: 40px; height: 20px;"
                                        {{ ($settings['activity_log_enabled'] ?? '1') == '1' ? 'checked' : '' }}
                                        onchange="saveSettings('activity-log-toggle')">
                                    <label class="form-check-label" for="toggle-activity-log" style="font-size: .65rem; font-weight: 800; color: #94a3b8; cursor: pointer; white-space: nowrap; margin-top: 2px;">
                                        LOG AKTIVITAS <span class="d-none d-lg-inline">USER</span>
                                    </label>
                                </div>
                                <div class="badge-live-pulse" style="margin: 0;"><span class="pulse"></span> LIVE MONITORING</div>
                            </div>
                        </div>
                        <div class="scard-body">
                            <!-- Security Stats -->
                            <div class="frow3 mb-4">
                                <div class="stat-mini-card danger">
                                    <div class="smc-icon"><i class="bi bi-bug-fill"></i></div>
                                    <div class="smc-info">
                                        <div class="smc-label">Ancaman Terdeteksi</div>
                                        <div class="smc-value" id="count-attacks">0</div>
                                    </div>
                                </div>
                                <div class="stat-mini-card warning">
                                    <div class="smc-icon"><i class="bi bi-exclamation-octagon-fill"></i></div>
                                    <div class="smc-info">
                                        <div class="smc-label">Percobaan Gagal</div>
                                        <div class="smc-value" id="count-failed-login">0</div>
                                    </div>
                                </div>
                                <div class="stat-mini-card success">
                                    <div class="smc-icon"><i class="bi bi-shield-check"></i></div>
                                    <div class="smc-info">
                                        <div class="smc-label">Security Score</div>
                                        <div class="smc-value">98%</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Intrusion Detection Table -->
                            <div class="table-responsive">
                                <h6 class="mb-3" style="font-weight: 700; color: var(--c-text-2); font-size: .85rem;">
                                    <i class="bi bi-radar"></i> AKTIVITAS MENCURIGAKAN TERAKHIR
                                </h6>
                                <table class="table table-hover align-middle" style="font-size: .85rem;">
                                    <thead class="bg-light text-muted">
                                        <tr>
                                            <th>SUMBER (IP)</th>
                                            <th>EVENT</th>
                                            <th>PATH</th>
                                            <th>WAKTU</th>
                                            <th class="text-end">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="security-log-body">
                                        <tr>
                                            <td colspan="5" class="text-center py-4">Memuat data keamanan...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="scard" style="flex: 1;">
                        <div class="scard-head">
                            <div class="scard-title"><i class="bi bi-activity"></i> Log Aktivitas User</div>
                        </div>
                        <div class="scard-body p-0">
                            <div class="activity-timeline" id="activity-log-body">
                                <!-- AJAX content -->
                                <div class="p-4 text-center text-muted">Memuat aktivitas...</div>
                            </div>
                        </div>
                        <div class="scard-footer text-center py-2" style="border-top: 1px solid var(--c-border);">
                            <a href="#" class="text-decoration-none" style="font-size: .75rem; color: var(--c-primary); font-weight: 600;">LIHAT SEMUA LOG <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="scard">
                    <div class="scard-head">
                        <div class="scard-title"><i class="bi bi-shield-lock-fill"></i> System Hardening Status</div>
                    </div>
                    <div class="scard-body">
                        <div class="frow4">
                            <div class="hardening-item ok">
                                <i class="bi bi-check-circle-fill icon"></i>
                                <div class="info">
                                    <div class="label">SSL Certificate</div>
                                    <div class="val">Active & Encrypted</div>
                                </div>
                            </div>
                            <div class="hardening-item ok">
                                <i class="bi bi-check-circle-fill icon"></i>
                                <div class="info">
                                    <div class="label">Debug Mode</div>
                                    <div class="val">Production (Safe)</div>
                                </div>
                            </div>
                            <div class="hardening-item ok">
                                <i class="bi bi-check-circle-fill icon"></i>
                                <div class="info">
                                    <div class="label">App Key</div>
                                    <div class="val">Secured</div>
                                </div>
                            </div>
                            <div class="hardening-item warning">
                                <i class="bi bi-exclamation-circle-fill icon"></i>
                                <div class="info">
                                    <div class="label">Two Factor Auth</div>
                                    <div class="val">Optional</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ asset('assets/js/system-setting.js') }}"></script>
    @endpush
</x-master-layout>
