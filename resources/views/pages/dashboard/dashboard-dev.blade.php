<x-master-layout>

    @push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Select2 Premium Styling for Dashboard */
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid var(--c-border) !important;
            border-radius: 10px !important;
            display: flex !important;
            align-items: center !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--c-text) !important;
            font-size: 0.85rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }
        .select2-dropdown {
            border: 1px solid var(--c-border) !important;
            border-radius: 10px !important;
            box-shadow: var(--shadow-lg) !important;
            z-index: 9999 !important;
        }
        .select2-search__field {
            border-radius: 6px !important;
            padding: 6px 10px !important;
        }
    </style>
    @endpush

    @push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        const MONTHLY_EVENTS = @json($monthly_kegiatans);
        let curMonth = new Date().getMonth();
        let curYear = new Date().getFullYear();

        $(document).ready(function() {
            // Animate Stats
            animCounter('cnt1', {{ $stats['total_kegiatan'] }});
            animCounter('cnt2', {{ $stats['total_foto'] }});
            animCounter('cnt3', {{ $stats['total_user'] }});
            animCounter('cnt4', {{ $stats['kegiatan_month'] }});

            // Sparklines Simulation
            for(let i=1; i<=4; i++) renderSpark(`spark${i}`, i==4 ? 'down' : 'up');

            // Initial Calendar
            renderCalendar(curMonth, curYear);
        });

        function animCounter(id, target) {
            const el = document.getElementById(id); if(!el) return;
            let cur = 0; const inc = Math.max(1, target / 50);
            const t = setInterval(() => {
                cur += inc;
                if(cur >= target) { cur = target; clearInterval(t); }
                el.textContent = Math.floor(cur).toLocaleString('id-ID');
            }, 20);
        }

        function renderSpark(id, type) {
            const el = document.getElementById(id); if(!el) return;
            let h = ''; const count = 7;
            const color = type == 'up' ? '#10b981' : (type == 'down' ? '#ef4444' : '#94a3b8');
            for(let i=0; i<count; i++) {
                let val = 30 + Math.random() * 70;
                h += `<div style="height:${val}%; background:${color}; opacity:${0.3 + (i/count)*0.7}"></div>`;
            }
            el.innerHTML = h;
        }

        function renderCalendar(m, y) {
            const grid = document.getElementById('calGrid'); if(!grid) return;
            const names = document.getElementById('calDayNames');
            const title = document.getElementById('calTitle');
            
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            title.innerText = `${monthNames[m]} ${y}`;
            
            names.innerHTML = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'].map(d => `<div class="cal-day-name">${d}</div>`).join('');
            
            const firstDay = new Date(y, m, 1).getDay();
            const lastDate = new Date(y, m + 1, 0).getDate();
            
            let h = '';
            for(let i=0; i<firstDay; i++) h += '<div class="cal-day empty"></div>';
            
            for(let d=1; d<=lastDate; d++) {
                const dayOfWeek = new Date(y, m, d).getDay();
                const dateStr = `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
                const eventsOnDay = MONTHLY_EVENTS.filter(ev => {
                    const evDate = new Date(ev.tanggal).toISOString().split('T')[0];
                    return evDate === dateStr;
                });
                
                const isToday = new Date().toDateString() === new Date(y, m, d).toDateString();
                const isSunday = dayOfWeek === 0;
                const hasEvent = eventsOnDay.length > 0;
                
                h += `<div class="cal-day ${isToday?'today':''} ${isSunday?'sunday':''} ${hasEvent?'has-event':''}" 
                           onclick="showDayEvents('${dateStr}', ${d}, '${monthNames[m]}')">
                        ${d}
                      </div>`;
            }
            grid.innerHTML = h;
        }

        window.calPrev = () => { curMonth--; if(curMonth<0){curMonth=11;curYear--;} renderCalendar(curMonth, curYear); };
        window.calNext = () => { curMonth++; if(curMonth>11){curMonth=0;curYear++;} renderCalendar(curMonth, curYear); };

        function showDayEvents(dateStr, d, mName) {
            const events = MONTHLY_EVENTS.filter(ev => new Date(ev.tanggal).toISOString().split('T')[0] === dateStr);
            if(events.length === 0) return;

            const modal = document.getElementById('calModal');
            const body = document.getElementById('calModalBody');
            document.getElementById('calModalTitle').innerText = `Kegiatan ${d} ${mName}`;

            let h = '';
            events.forEach(ev => {
                h += `
                    <div class="cal-act-card">
                        <div class="cal-act-title">${ev.judul}</div>
                        <div class="cal-act-meta">
                            <span><i class="bi bi-clock"></i> ${ev.waktu || '--:--'}</span>
                            <span><i class="bi bi-geo-alt"></i> ${ev.lokasi || 'Lokasi -'}</span>
                        </div>
                        <a href="/kegiatan/${ev.id}" class="btn-cal-detail">Lihat Detail</a>
                    </div>
                `;
            });
            body.innerHTML = h;
            modal.style.display = 'grid';
        }

        window.closeCalModal = () => { document.getElementById('calModal').style.display = 'none'; };
        
        // Quick Actions Modals
        window.openUploadModal = () => { 
            document.getElementById('modalUpload').classList.add('show');
            $('.select2-dash').select2({
                dropdownParent: $('#modalUpload'),
                width: '100%',
                placeholder: "-- Cari Kegiatan --"
            });
        };
        window.openUserModal = () => { document.getElementById('modalUser').classList.add('show'); };
        window.closeDashModal = (id) => { document.getElementById(id).classList.remove('show'); };

        let dashFiles = [];
        window.handleDashFiles = (files) => {
            dashFiles = [...dashFiles, ...Array.from(files)];
            renderDashPreview();
        };

        function renderDashPreview() {
            const container = document.getElementById('dashUploadPreview');
            container.innerHTML = dashFiles.map((file, idx) => {
                const url = URL.createObjectURL(file);
                return `
                    <div class="up-item-dash">
                        <img src="${url}">
                        <button class="up-rm-dash" onclick="removeDashFile(${idx})">&times;</button>
                    </div>
                `;
            }).join('');
        }

        window.removeDashFile = (idx) => { dashFiles.splice(idx, 1); renderDashPreview(); };

        window.doDashUpload = async () => {
            const kid = document.getElementById('dash-f-kegiatan').value;
            const tgl = document.getElementById('dash-f-tanggal').value;
            const ket = document.getElementById('dash-f-keterangan').value;

            if(!kid) return DKA.notify({ type: 'warning', title: 'Data Belum Lengkap', message: 'Silakan pilih kegiatan terlebih dahulu sebelum mengunggah foto.' });
            if(dashFiles.length === 0) return DKA.notify({ type: 'warning', title: 'Foto Kosong', message: 'Anda belum memilih foto. Silakan pilih dari galeri atau gunakan kamera.' });

            // Client-side Validation: Max 5MB per file for mobile stability
            for(let f of dashFiles) {
                if(f.size > 5 * 1024 * 1024) {
                    return DKA.notify({ type: 'danger', title: 'File Terlalu Besar', message: `Foto "${f.name}" melebihi batas 5MB. Silakan kompres atau pilih foto lain.` });
                }
            }

            const btn = document.getElementById('btnDashUpload');
            const originalText = btn.innerHTML;
            btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>...';

            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('kegiatan_id', kid);
            fd.append('tanggal', tgl);
            fd.append('keterangan', ket);
            dashFiles.forEach(f => fd.append('photos[]', f));

            try {
                const res = await fetch('{{ route("galeri.upload") }}', { 
                    method: 'POST', 
                    body: fd,
                    headers: { 'Accept': 'application/json' }
                });
                
                DKA.notify({
                    type: 'success', 
                    title: 'Upload Selesai', 
                    message: `${dashFiles.length} foto dokumentasi telah berhasil diunggah ke server.`
                });
                setTimeout(() => location.reload(), 1500);
            } catch(e) { 
                console.error(e);
                DKA.notify({ type: 'danger', title: 'Gagal Upload', message: e.message }); 
            }
            finally { btn.disabled = false; btn.innerHTML = originalText; }
        };

        window.saveDashUser = async () => {
            const btn = document.getElementById('btnDashSaveUser');
            const originalText = btn.innerHTML;
            btn.disabled = true; btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>...';

            const form = document.getElementById('formDashUser');
            const fd = new FormData(form);

            try {
                const res = await fetch('{{ route("pengguna.store") }}', { 
                    method: 'POST', 
                    body: fd,
                    headers: { 'Accept': 'application/json' }
                });
                DKA.notify({
                    type: 'success', 
                    title: 'Pendaftaran Berhasil', 
                    message: `Akun baru untuk ${fd.get('name')} telah aktif dalam sistem.`
                });
                setTimeout(() => location.reload(), 1500);
            } catch(e) { 
                DKA.notify({ type: 'danger', title: 'Gagal Simpan', message: e.message }); 
            }
            finally { btn.disabled = false; btn.innerHTML = originalText; }
        };

        window.onclick = (e) => { 
            if(e.target == document.getElementById('calModal')) closeCalModal(); 
            if(e.target.classList.contains('modal-overlay')) e.target.classList.remove('show');
        };
    </script>
    @endpush

    <!-- Page Header -->
    <div class="page-header fade-up">
        <div class="page-header-left">
            <h1><i class="bi bi-grid-1x2-fill"></i> Dashboard</h1>
            <p>Selamat datang kembali, {{ auth()->user()->name }}! Berikut ringkasan aktivitas hari ini.</p>
        </div>
        <nav class="breadcrumb-nav">
            <a href="#"><i class="bi bi-house-fill"></i> Home</a>
            <span class="bc-sep"><i class="bi bi-chevron-right"></i></span>
            <span class="bc-current"><i class="bi bi-grid-1x2-fill"></i> Dashboard</span>
        </nav>
    </div>

    <!-- Stat Cards -->
    <div class="stats-grid">
        <div class="stat-card s1 fade-up">
            <div class="stat-change up"><i class="bi bi-arrow-up"></i> {{ rand(5, 15) }}%</div>
            <div class="stat-icon-wrap"><i class="bi bi-calendar3-fill"></i></div>
            <div class="stat-value" id="cnt1">0</div>
            <div class="stat-label">Total Kegiatan</div>
            <div class="stat-sparkline" id="spark1"></div>
        </div>
        <div class="stat-card s2 fade-up">
            <div class="stat-change up"><i class="bi bi-arrow-up"></i> {{ rand(3, 10) }}%</div>
            <div class="stat-icon-wrap"><i class="bi bi-images"></i></div>
            <div class="stat-value" id="cnt2">0</div>
            <div class="stat-label">Total Foto Uploaded</div>
            <div class="stat-sparkline" id="spark2"></div>
        </div>
        <div class="stat-card s3 fade-up">
            <div class="stat-change flat"><i class="bi bi-dash"></i> 0%</div>
            <div class="stat-icon-wrap"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value" id="cnt3">0</div>
            <div class="stat-label">Pengguna Aktif</div>
            <div class="stat-sparkline" id="spark3"></div>
        </div>
        <div class="stat-card s4 fade-up">
            <div class="stat-change {{ $stats['kegiatan_month'] > 0 ? 'up' : 'flat' }}"><i class="bi bi-arrow-{{ $stats['kegiatan_month'] > 0 ? 'up' : 'dash' }}"></i> {{ $stats['kegiatan_month'] > 0 ? 'Baru' : '0%' }}</div>
            <div class="stat-icon-wrap"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="stat-value" id="cnt4">0</div>
            <div class="stat-label">Kegiatan Bulan Ini</div>
            <div class="stat-sparkline" id="spark4"></div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="content-row">

        <!-- Recent Activities -->
        <div class="panel fade-up">
            <div class="panel-header">
                <div class="panel-title"><i class="bi bi-clock-history"></i> Aktivitas Terbaru</div>
                <a href="#" class="panel-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="activity-list">
                @forelse($recent_activities as $act)
                <div class="activity-item">
                    @php
                        $colorMap = [
                            'created' => 'green',
                            'updated' => 'blue',
                            'deleted' => 'red',
                            'login'   => 'purple',
                            'kegiatan'=> 'amber'
                        ];
                        $iconMap = [
                            'created' => 'bi-plus-circle-fill',
                            'updated' => 'bi-pencil-square',
                            'deleted' => 'bi-trash-fill',
                            'login'   => 'bi-box-arrow-in-right',
                            'kegiatan'=> 'bi-calendar-event'
                        ];
                        $type = $act->log_name == 'default' ? $act->description : $act->log_name;
                        $color = $colorMap[$act->description] ?? ($colorMap[$act->log_name] ?? 'blue');
                        $icon = $iconMap[$act->description] ?? ($iconMap[$act->log_name] ?? 'bi-lightning-fill');
                    @endphp
                    <div class="act-icon {{ $color }}"><i class="bi {{ $icon }}"></i></div>
                    <div class="act-info">
                        <div class="act-title">{{ $act->causer->name ?? 'System' }} {{ $act->description }} data</div>
                        <div class="act-info-meta">
                            {{ $act->subject_type ? class_basename($act->subject_type) : 'System Action' }} 
                            &nbsp;·&nbsp; <span class="act-badge done">Selesai</span>
                        </div>
                    </div>
                    <div class="act-time">{{ $act->created_at->diffForHumans() }}</div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">Belum ada aktivitas terbaru.</div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar widgets -->
        <div style="display:flex;flex-direction:column;gap:16px;">

            <!-- Bar chart -->
            <div class="panel fade-up">
                <div class="panel-header">
                    <div class="panel-title"><i class="bi bi-bar-chart-fill"></i> Kegiatan / Bulan</div>
                </div>
                <div class="panel-body" style="padding:15px 20px;">
                    <div class="chart-legend" style="margin-top:0;">
                        @php
                            $colors = ['var(--c-primary)', 'var(--c-green)', 'var(--c-pink)', 'var(--c-accent)', 'var(--c-purple)'];
                        @endphp
                        @foreach($chart_data as $i => $item)
                        <div class="legend-item">
                            <div class="legend-dot" style="background:{{ $colors[$i % 5] }};"></div>
                            <div class="legend-label">{{ $item->kategori->nama_kategori ?? 'Lainnya' }}</div>
                            <div class="legend-bar-wrap" style="height:6px; background:rgba(0,0,0,0.05); border-radius:10px; flex:1; margin:0 10px; overflow:hidden;">
                                <div class="legend-bar"
                                    style="height:100%; width:{{ $stats['total_kegiatan'] > 0 ? max(5, ($item->total / $stats['total_kegiatan'] * 100)) : 0 }}%; background:{{ $colors[$i % 5] }}; border-radius:10px; transition:width 1s ease-in-out;">
                                </div>
                            </div>
                            <div class="legend-val">{{ $item->total }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Calendar mini -->
            <div class="calendar-widget fade-up">
                <div class="cal-header">
                    <button class="cal-nav" onclick="calPrev()"><i class="bi bi-chevron-left"></i></button>
                    <h3 id="calTitle"></h3>
                    <button class="cal-nav" onclick="calNext()"><i class="bi bi-chevron-right"></i></button>
                </div>
                <div style="padding:8px 12px;">
                    <div class="cal-grid" id="calDayNames"></div>
                    <div class="cal-grid" id="calGrid"></div>
                </div>
            </div>

        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions-section" style="margin-top:24px;">
        <h2 style="font-family:'Nunito',sans-serif;font-weight:800;font-size:1rem;color:var(--c-text);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
            <i class="bi bi-lightning-fill" style="color:var(--c-accent);"></i> Aksi Cepat
        </h2>
        <div class="quick-actions fade-up">
            <a href="{{ route('kegiatan.create') }}" class="qa-card">
                <div class="qa-icon i1"><i class="bi bi-plus-circle-fill"></i></div>
                <div class="qa-label">Tambah Kegiatan</div>
            </a>
            <a href="javascript:void(0)" onclick="openUploadModal()" class="qa-card">
                <div class="qa-icon i2"><i class="bi bi-cloud-upload-fill"></i></div>
                <div class="qa-label">Upload Foto</div>
            </a>
            <a href="{{ route('laporan.export') }}" class="qa-card">
                <div class="qa-icon i3"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                <div class="qa-label">Export Laporan</div>
            </a>
            <a href="javascript:void(0)" onclick="openUserModal()" class="qa-card">
                <div class="qa-icon i4"><i class="bi bi-person-plus-fill"></i></div>
                <div class="qa-label">Tambah Pengguna</div>
            </a>
        </div>
    </div>

    <!-- Upload Modal -->
    <div class="modal-overlay" id="modalUpload">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-title-dash"><i class="bi bi-cloud-upload-fill"></i> Upload Foto</div>
                <button class="btn-close-m" onclick="closeDashModal('modalUpload')">&times;</button>
            </div>
            <div class="modal-body">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:16px;">
                    <div class="upload-option-card" onclick="document.getElementById('fileInput').click()">
                        <div class="uoc-icon"><i class="bi bi-images"></i></div>
                        <div class="uoc-text">Pilih Galeri</div>
                        <input type="file" id="fileInput" accept="image/*" multiple onchange="handleDashFiles(this.files)" style="display:none;" />
                    </div>
                    <div class="upload-option-card cam" onclick="document.getElementById('cameraInput').click()">
                        <div class="uoc-icon"><i class="bi bi-camera-fill"></i></div>
                        <div class="uoc-text">Buka Kamera</div>
                        <input type="file" id="cameraInput" accept="image/*" capture="environment" onchange="handleDashFiles(this.files)" style="display:none;" />
                    </div>
                </div>
                
                <div class="drop-zone" id="dropZone" style="padding:20px; border-style:dashed;">
                    <div class="drop-title" style="font-size:0.8rem;">Atau drag & drop foto di sini</div>
                </div>
                
                <div id="dashUploadPreview" class="upload-preview-dash"></div>
                <div style="margin-top:16px;">
                    <div class="fgroup">
                        <label class="flabel">Pilih Kegiatan <span style="color:var(--c-red);">*</span></label>
                        <select class="fctrl select2-dash" id="dash-f-kegiatan">
                            <option value="">-- Cari Kegiatan --</option>
                            @foreach($kegiatans as $k)
                                <option value="{{ $k->id }}">{{ $k->judul }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:12px;">
                        <div class="fgroup">
                            <label class="flabel">Tanggal Foto</label>
                            <input type="date" id="dash-f-tanggal" class="fctrl" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="fgroup">
                            <label class="flabel">Keterangan</label>
                            <input type="text" id="dash-f-keterangan" class="fctrl" placeholder="Contoh: Dokumentasi Utama">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-foot">
                <button class="btn-m-secondary" onclick="closeDashModal('modalUpload')">Batal</button>
                <button class="btn-m-primary" id="btnDashUpload" onclick="doDashUpload()"><i class="bi bi-cloud-arrow-up-fill"></i> Upload</button>
            </div>
        </div>
    </div>

    <!-- User Modal -->
    <div class="modal-overlay" id="modalUser">
        <div class="modal-box" style="max-width:450px;">
            <div class="modal-head">
                <div class="modal-title-dash"><i class="bi bi-person-plus-fill"></i> Tambah Pengguna</div>
                <button class="btn-close-m" onclick="closeDashModal('modalUser')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="formDashUser">
                    @csrf
                    <div class="fgroup">
                        <label class="flabel">Nama Lengkap</label>
                        <input type="text" name="name" class="fctrl" placeholder="John Doe">
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:10px;">
                        <div class="fgroup">
                            <label class="flabel">Email</label>
                            <input type="email" name="email" class="fctrl" placeholder="john@email.com">
                        </div>
                        <div class="fgroup">
                            <label class="flabel">Username</label>
                            <input type="text" name="username" class="fctrl" placeholder="johndoe">
                        </div>
                    </div>
                    <div class="fgroup" style="margin-top:10px;">
                        <label class="flabel">Unit Kerja</label>
                        <select name="unit_kerja_id" class="fctrl">
                            <option value="">Pilih Unit</option>
                            @foreach($unitKerjas as $uk)
                                <option value="{{ $uk->id }}">{{ $uk->nama_instansi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:10px;">
                        <div class="fgroup">
                            <label class="flabel">Role</label>
                            <select name="role" class="fctrl">
                                @foreach($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fgroup">
                            <label class="flabel">Password</label>
                            <input type="password" name="password" class="fctrl" placeholder="******">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-foot">
                <button class="btn-m-secondary" onclick="closeDashModal('modalUser')">Batal</button>
                <button class="btn-m-primary" id="btnDashSaveUser" onclick="saveDashUser()"><i class="bi bi-check-lg"></i> Simpan</button>
            </div>
        </div>
    </div>

    <!-- Activity Detail Modal (Simple) -->
    <div id="calModal" class="cal-modal">
        <div class="cal-modal-content">
            <div class="cal-modal-header">
                <h4 id="calModalTitle">Kegiatan</h4>
                <button onclick="closeCalModal()">&times;</button>
            </div>
            <div id="calModalBody" class="cal-modal-body">
                <!-- Activity list goes here -->
            </div>
        </div>
    </div>

    <style>
        .cal-modal { position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:2000; display:none; place-items:center; backdrop-filter:blur(4px); }
        .cal-modal-content { background:#fff; width:90%; max-width:400px; border-radius:16px; box-shadow:var(--shadow-lg); overflow:hidden; animation:zoomIn .3s ease both; }
        .cal-modal-header { padding:16px 20px; border-bottom:1px solid var(--c-border); display:flex; justify-content:space-between; align-items:center; }
        .cal-modal-header h4 { margin:0; font-family:'Nunito'; font-weight:800; color:var(--c-text); }
        .cal-modal-header button { background:none; border:none; font-size:1.5rem; cursor:pointer; color:var(--c-muted); }
        .cal-modal-body { padding:10px; max-height:300px; overflow-y:auto; }
        .modal-overlay.show { display: grid; opacity: 1; pointer-events: all; }
        .modal-box { background:#fff; width:95%; max-width:500px; border-radius:16px; box-shadow:var(--shadow-lg); overflow:hidden; animation:zoomIn .3s ease both; }
        .modal-head { padding:16px 20px; border-bottom:1px solid var(--c-border); display:flex; justify-content:space-between; align-items:center; }
        .modal-title-dash { font-family:'Nunito'; font-weight:800; color:var(--c-text); display:flex; align-items:center; gap:8px; }
        .modal-title-dash i { color:var(--c-primary); }
        .modal-head button { background:none; border:none; font-size:1.5rem; cursor:pointer; color:var(--c-muted); }
        .modal-body { padding:20px; max-height:80vh; overflow-y:auto; }
        .modal-foot { padding:16px 20px; border-top:1px solid var(--c-border); display:flex; gap:10px; justify-content:flex-end; background:var(--c-surface2); }
        
        .btn-m-primary { padding:8px 20px; border-radius:10px; background:var(--c-primary); color:#fff; border:none; font-weight:700; cursor:pointer; transition:all .2s; }
        .btn-m-primary:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(79,70,229,.3); }
        .btn-m-secondary { padding:8px 20px; border-radius:10px; background:#fff; color:var(--c-text); border:1px solid var(--c-border); font-weight:700; cursor:pointer; }
        
        .upload-option-card { border:1px solid var(--c-border); border-radius:12px; padding:16px; text-align:center; cursor:pointer; transition:all .2s; background:var(--c-surface); }
        .upload-option-card:hover { border-color:var(--c-primary); background:rgba(79,70,229,.05); transform:translateY(-2px); }
        .upload-option-card.cam { background:rgba(236,72,153,.03); border-color:rgba(236,72,153,.1); }
        .upload-option-card.cam:hover { border-color:var(--c-pink); background:rgba(236,72,153,.08); }
        .uoc-icon { font-size:1.5rem; color:var(--c-primary); margin-bottom:4px; }
        .upload-option-card.cam .uoc-icon { color:var(--c-pink); }
        .uoc-text { font-size:0.8rem; font-weight:800; color:var(--c-text); }
        
        .drop-zone { border:2px dashed var(--c-border); border-radius:12px; padding:30px 20px; text-align:center; cursor:pointer; background:var(--c-surface); transition:all .2s; position:relative; }
        .drop-zone:hover { border-color:var(--c-primary); background:rgba(79,70,229,.03); }
        .drop-zone input { position:absolute; inset:0; opacity:0; cursor:pointer; }
        .drop-icon-dash { font-size:2rem; color:var(--c-primary); margin-bottom:8px; }
        .drop-title { font-weight:700; font-size:.9rem; color:var(--c-text); }
        .drop-sub { font-size:.75rem; color:var(--c-muted); }
        
        .upload-preview-dash { display:grid; grid-template-columns:repeat(auto-fill,minmax(70px,1fr)); gap:8px; margin-top:12px; }
        .up-item-dash { position:relative; aspect-ratio:1; border-radius:8px; overflow:hidden; border:1px solid var(--c-border); }
        .up-item-dash img { width:100%; height:100%; object-fit:cover; }
        .up-rm-dash { position:absolute; top:2px; right:2px; width:18px; height:18px; border-radius:50%; background:rgba(239,68,68,.8); border:none; color:#fff; display:grid; place-items:center; cursor:pointer; font-size:12px; }
        
        .fgroup { margin-bottom:0; }
        .flabel { font-size:.8rem; font-weight:700; color:var(--c-text); margin-bottom:6px; display:block; text-align:left; }
        .fctrl { width:100%; padding:10px 14px; border:1px solid var(--c-border); border-radius:10px; font-size:.85rem; outline:none; transition:all .2s; font-family:inherit; }
        .fctrl:focus { border-color:var(--c-primary); box-shadow:0 0 0 3px rgba(79,70,229,.1); }

        .cal-act-card { padding:12px; border-radius:10px; background:var(--c-surface2); border:1px solid var(--c-border); margin-bottom:8px; display:flex; flex-direction:column; gap:6px; text-align:left; }
        .cal-act-card:last-child { margin-bottom:0; }
        .cal-act-title { font-size:.85rem; font-weight:700; color:var(--c-text); }
        .cal-act-meta { font-size:.72rem; color:var(--c-muted); display:flex; align-items:center; gap:8px; }
        .btn-cal-detail { margin-top:4px; padding:6px 12px; border-radius:6px; background:var(--c-primary); color:#fff; font-size:.72rem; font-weight:700; text-decoration:none; text-align:center; display:inline-block; transition:opacity .2s; }
        .btn-cal-detail:hover { opacity:.9; }
        
        .cal-day.has-event { position:relative; font-weight:800; color:var(--c-primary); cursor:pointer; }
        .cal-day-name:first-child { color: var(--c-red); } /* MIN red */
        .cal-day.sunday { color: var(--c-red); }
        .cal-day.today { background: linear-gradient(135deg, var(--c-primary), var(--c-secondary)); color: #fff !important; font-weight: 800; border-radius: 10px; }
        .cal-day.has-event { position:relative; font-weight:700; color:var(--c-text); cursor:pointer; }
        .cal-day.has-event::after { content:''; position:absolute; bottom:6px; left:50%; transform:translateX(-50%); width:5px; height:5px; border-radius:50%; background:var(--c-green); opacity:0.8; box-shadow: 0 0 5px rgba(16,185,129,0.3); }
        .cal-day.sunday.has-event { color: var(--c-red); }
        .cal-day { color: var(--c-text-muted); transition: all .2s; cursor: pointer; }
        .cal-day:hover { background: var(--c-surface2); border-radius: 8px; color: var(--c-primary); }
        
        .act-info-meta { font-size: .75rem; color: var(--c-muted); }
        
        @keyframes zoomIn { from{opacity:0;transform:scale(.9)} to{opacity:1;transform:scale(1)} }
    </style>

</x-master-layout>
