<x-guest-layout>
    @section('title', 'Daftar Akun')

    @section('bg-style')
        background:
        radial-gradient(ellipse 80% 60% at 5% 15%, #c7d2fe 0%, transparent 55%),
        radial-gradient(ellipse 65% 55% at 95% 85%, #a5f3fc 0%, transparent 55%),
        radial-gradient(ellipse 55% 50% at 55% 45%, #fbcfe8 0%, transparent 65%),
        radial-gradient(ellipse 50% 40% at 80% 10%, #d1fae5 0%, transparent 50%),
        linear-gradient(135deg, #e0e7ff 0%, #cffafe 45%, #fce7f3 100%);
    @endsection

    @push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Custom Select2 for Register Page */
            .select2-container--default .select2-selection--single {
                height: 52px;
                border: 2px solid var(--c-border);
                border-radius: 12px;
                background-color: #fff;
                display: flex;
                align-items: center;
                padding: 0 12px 0 42px;
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 600;
                color: var(--c-text);
                transition: all 0.3s ease;
            }
            .select2-container--default.select2-container--open .select2-selection--single {
                border-color: var(--c-primary);
                box-shadow: 0 0 0 5px rgba(79, 70, 229, 0.1);
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: var(--c-text);
                padding-left: 0;
            }
            .select2-container--default .select2-selection--single .select2-selection__placeholder {
                color: #94a3b8;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 50px;
                right: 12px;
            }
            .select2-dropdown {
                border: 1px solid var(--c-border);
                border-radius: 12px;
                box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1), 0 10px 15px -6px rgba(0, 0, 0, 0.05);
                overflow: hidden;
                z-index: 9999;
                margin-top: 5px;
                background: #fff;
            }
            .select2-container--default .select2-search--dropdown .select2-search__field {
                border: 1px solid var(--c-border);
                border-radius: 10px;
                padding: 10px 14px;
                outline: none;
                margin: 8px;
                width: calc(100% - 16px);
            }
            .select2-container--default .select2-search--dropdown .select2-search__field:focus {
                border-color: var(--c-primary);
            }
            .select2-results__option {
                padding: 12px 18px;
                font-size: 0.9rem;
                color: var(--c-text);
                transition: background 0.2s;
            }
            .select2-container--default .select2-results__option--highlighted[aria-selected] {
                background-color: var(--c-primary);
                color: #fff;
            }
            .select2-container--default .select2-results__option[aria-selected=true] {
                background-color: #f1f5f9;
                color: var(--c-primary);
                font-weight: 700;
            }
            #wrap-unit_kerja_id { position: relative; }
            #wrap-unit_kerja_id .input-icon {
                position: absolute;
                left: 18px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 5;
                color: var(--c-primary);
                font-size: 1.1rem;
            }

            /* ── Register Card (wider for multi-field) ── */
            .register-card {
                width: 100%;
                max-width: 1040px;
                background: var(--c-card);
                backdrop-filter: blur(28px) saturate(180%);
                -webkit-backdrop-filter: blur(28px) saturate(180%);
                border-radius: var(--radius);
                box-shadow: 0 24px 64px rgba(79, 70, 229, .18), 0 4px 16px rgba(6, 182, 212, .10);
                border: 1px solid rgba(255, 255, 255, 0.72);
                display: grid;
                grid-template-columns: 300px 1fr;
                overflow: hidden;
                animation: cardIn .7s cubic-bezier(.22, 1, .36, 1) both;
            }

            @keyframes cardIn {
                from {
                    opacity: 0;
                    transform: translateY(36px) scale(.97);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            /* ==============================
               LEFT — Brand Panel
               ============================== */
            .brand-panel-reg {
                background: linear-gradient(160deg, #10b981 0%, #059669 30%, #0891b2 65%, #4f46e5 100%);
                padding: 48px 36px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                position: relative;
                overflow: hidden;
            }

            .brand-panel-reg::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(circle at 25% 75%, rgba(255, 255, 255, .13) 0%, transparent 50%),
                    radial-gradient(circle at 85% 15%, rgba(255, 255, 255, .09) 0%, transparent 40%);
            }

            /* Floating decorative blobs */
            .brand-deco {
                position: absolute;
                border-radius: 50%;
                opacity: .18;
                animation: floatDeco 7s ease-in-out infinite alternate;
            }

            .brand-deco-1 { width: 200px; height: 200px; background: #fff; top: -70px; right: -70px; animation-delay: 0s; }
            .brand-deco-2 { width: 130px; height: 130px; background: var(--c-accent); bottom: 80px; left: -45px; animation-delay: 2s; }
            .brand-deco-3 { width: 90px; height: 90px; background: var(--c-pink); bottom: -35px; right: 50px; animation-delay: 4s; }
            .brand-deco-4 { width: 60px; height: 60px; background: var(--c-secondary); top: 45%; left: 60%; animation-delay: 1s; }

            @keyframes floatDeco {
                from { transform: translate(0, 0) scale(1); }
                to { transform: translate(5px, -14px) scale(1.06); }
            }

            /* Steps indicator */
            .step-track {
                position: relative;
                z-index: 1;
                margin-top: 32px;
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            .step-item {
                display: flex;
                align-items: flex-start;
                gap: 14px;
                padding: 14px 0;
                position: relative;
            }

            .step-item:not(:last-child)::after {
                content: '';
                position: absolute;
                left: 18px;
                top: 44px;
                width: 2px;
                height: calc(100% - 20px);
                background: rgba(255, 255, 255, .25);
            }

            .step-num {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .2);
                border: 2px solid rgba(255, 255, 255, .45);
                display: grid;
                place-items: center;
                font-family: 'Nunito', sans-serif;
                font-weight: 900;
                font-size: .9rem;
                color: #fff;
                flex-shrink: 0;
                backdrop-filter: blur(6px);
                transition: background .3s;
            }

            .step-num.active {
                background: rgba(255, 255, 255, .35);
                border-color: rgba(255, 255, 255, .8);
                box-shadow: 0 0 0 4px rgba(255, 255, 255, .15);
            }

            .step-num.done {
                background: rgba(255, 255, 255, .6);
                border-color: #fff;
            }

            .step-num.done i {
                font-size: .85rem;
                color: #059669;
            }

            .step-text strong {
                display: block;
                font-size: .88rem;
                color: #fff;
                font-weight: 700;
                margin-bottom: 2px;
            }

            .step-text span {
                font-size: .78rem;
                color: rgba(255, 255, 255, .65);
            }

            /* ==============================
               RIGHT — Form Panel
               ============================== */
            .form-panel-reg {
                padding: 44px 48px;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
            }

            /* Top bar: step progress */
            .progress-bar-wrap {
                display: flex;
                gap: 6px;
                margin-bottom: 32px;
            }

            .prog-seg {
                flex: 1;
                height: 5px;
                border-radius: 99px;
                background: var(--c-border);
                overflow: hidden;
                position: relative;
            }

            .prog-seg::after {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, var(--c-green), var(--c-secondary));
                transform: scaleX(0);
                transform-origin: left;
                transition: transform .5s cubic-bezier(.22, 1, .36, 1);
            }

            .prog-seg.done::after {
                transform: scaleX(1);
            }

            .prog-seg.active::after {
                transform: scaleX(.5);
                background: linear-gradient(90deg, var(--c-primary), var(--c-pink));
            }

            /* Animated icon */
            .icon-ring-reg {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--c-green), var(--c-secondary));
                display: grid;
                place-items: center;
                margin-bottom: 18px;
                box-shadow: 0 8px 24px rgba(16, 185, 129, .35);
                animation: iconPulseReg 3s ease-in-out infinite;
                position: relative;
            }

            .icon-ring-reg::after {
                content: '';
                position: absolute;
                inset: -6px;
                border-radius: 50%;
                border: 2px dashed rgba(16, 185, 129, .35);
                animation: iconRingSpinReg 9s linear infinite;
            }

            @keyframes iconPulseReg {
                0%, 100% { transform: scale(1); box-shadow: 0 8px 24px rgba(16, 185, 129, .35); }
                50% { transform: scale(1.07); box-shadow: 0 14px 36px rgba(16, 185, 129, .55); }
            }

            @keyframes iconRingSpinReg { to { transform: rotate(360deg); } }
            .icon-ring-reg i { font-size: 1.9rem; color: #fff; }

            /* Step panels */
            .step-panel {
                display: none;
                animation: stepIn .4s cubic-bezier(.22, 1, .36, 1) both;
            }

            .step-panel.active {
                display: block;
            }

            @keyframes stepIn {
                from { opacity: 0; transform: translateX(18px); }
                to { opacity: 1; transform: translateX(0); }
            }

            /* Section divider label */
            .field-section {
                font-size: .7rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 1.2px;
                color: var(--c-muted);
                margin: 20px 0 14px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .field-section::before {
                content: '';
                flex: 0 0 16px;
                height: 2px;
                background: var(--c-border);
                border-radius: 2px;
            }

            /* Password strength meter */
            .pw-strength-wrap { margin-top: 8px; }
            .pw-strength-bar {
                height: 4px;
                border-radius: 99px;
                background: var(--c-border);
                overflow: hidden;
                margin-bottom: 4px;
            }

            .pw-strength-fill {
                height: 100%;
                border-radius: 99px;
                transition: width .4s, background .4s;
                width: 0%;
            }

            .pw-strength-label { font-size: .75rem; font-weight: 600; color: var(--c-muted); }

            /* Avatar upload */
            .avatar-upload-zone {
                border: 2px dashed var(--c-border);
                border-radius: 16px;
                padding: 24px;
                text-align: center;
                cursor: pointer;
                transition: border-color .25s, background .25s;
                background: rgba(255, 255, 255, .6);
                position: relative;
                overflow: hidden;
            }

            .avatar-upload-zone:hover {
                border-color: var(--c-primary);
                background: rgba(79, 70, 229, .04);
            }

            .avatar-upload-zone input { position: absolute; inset: 0; opacity: 0; cursor: pointer; z-index: 2; }
            .avatar-preview {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                object-fit: cover;
                border: 3px solid var(--c-border);
                display: none;
                margin: 0 auto 10px;
            }

            .avatar-placeholder {
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: linear-gradient(135deg, #e0e7ff, #cffafe);
                display: grid;
                place-items: center;
                margin: 0 auto 12px;
                font-size: 2rem;
                color: var(--c-primary);
                border: 3px solid rgba(79, 70, 229, .2);
            }

            .avatar-label { font-size: .875rem; font-weight: 600; color: var(--c-text); }
            .avatar-sub { font-size: .75rem; color: var(--c-muted); margin-top: 3px; }

            /* Terms checkbox */
            .terms-wrap-reg {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                padding: 16px;
                border-radius: 14px;
                background: linear-gradient(135deg, rgba(79, 70, 229, .06), rgba(6, 182, 212, .04));
                border: 1px solid rgba(79, 70, 229, .12);
                margin-bottom: 20px;
            }

            .terms-wrap-reg input[type=checkbox] { display: none; }

            .check-box-reg {
                width: 22px;
                height: 22px;
                flex-shrink: 0;
                border: 2px solid var(--c-border);
                border-radius: 7px;
                display: grid;
                place-items: center;
                cursor: pointer;
                transition: background .2s, border-color .2s;
                margin-top: 1px;
            }

            .check-box-reg i { font-size: .8rem; color: #fff; display: none; }
            .terms-wrap-reg input:checked~.check-box-reg { background: var(--c-primary); border-color: var(--c-primary); }
            .terms-wrap-reg input:checked~.check-box-reg i { display: block; }
            .terms-text-reg { font-size: .82rem; color: var(--c-muted); line-height: 1.6; }
            .terms-text-reg a { color: var(--c-primary); font-weight: 600; text-decoration: none; }
            .terms-text-reg a:hover { text-decoration: underline; }

            /* Alert */
            .alert-custom-reg {
                padding: 12px 16px;
                border-radius: 12px;
                font-size: .875rem;
                display: flex;
                align-items: flex-start;
                gap: 10px;
                margin-bottom: 18px;
                animation: alertInReg .4s ease both;
            }

            @keyframes alertInReg {
                from { opacity: 0; transform: translateY(-6px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .alert-danger-reg { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
            .alert-success-reg { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }

            /* Success screen */
            .success-screen-reg {
                display: none;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 40px 20px;
                animation: cardIn .6s cubic-bezier(.22, 1, .36, 1) both;
            }

            .success-screen-reg.show { display: flex; }
            .success-icon-wrap-reg {
                width: 100px;
                height: 100px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--c-green), var(--c-secondary));
                display: grid;
                place-items: center;
                margin-bottom: 24px;
                box-shadow: 0 12px 36px rgba(16, 185, 129, .4);
                animation: successPopReg .6s cubic-bezier(.34, 1.56, .64, 1) both;
            }

            @keyframes successPopReg {
                from { transform: scale(0); opacity: 0; }
                to { transform: scale(1); opacity: 1; }
            }

            .success-icon-wrap-reg i { font-size: 3rem; color: #fff; }
            .success-screen-reg h2 { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.8rem; margin-bottom: 10px; color: var(--c-text); }
            .success-screen-reg p { color: var(--c-muted); font-size: .95rem; line-height: 1.6; max-width: 320px; }

            /* Buttons */
            .btn-outline-nav {
                flex: 1;
                padding: 12px;
                border: 2px solid var(--c-border);
                border-radius: 12px;
                background: #fff;
                cursor: pointer;
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 700;
                font-size: .9rem;
                color: var(--c-text);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                transition: border-color .2s, background .2s, transform .2s;
            }

            .btn-outline-nav:hover {
                border-color: var(--c-primary);
                background: #f5f3ff;
                transform: translateY(-2px);
            }

            .btn-primary-grad {
                width: 100%;
                padding: 13px;
                border: none;
                border-radius: 12px;
                font-family: 'Nunito', sans-serif;
                font-weight: 800;
                font-size: 1rem;
                color: #fff;
                background: linear-gradient(135deg, var(--c-green) 0%, var(--c-secondary) 50%, var(--c-primary) 100%);
                background-size: 200% 100%;
                cursor: pointer;
                transition: background-position .4s, transform .2s, box-shadow .2s;
                box-shadow: 0 6px 20px rgba(16, 185, 129, .35);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-primary-grad:hover {
                background-position: right center;
                transform: translateY(-2px);
                box-shadow: 0 10px 28px rgba(16, 185, 129, .5);
            }

            .btn-primary-grad:active {
                transform: translateY(0);
            }

            .btn-next {
                flex: 1;
                padding: 12px;
                border: none;
                border-radius: 12px;
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-weight: 700;
                font-size: .9rem;
                color: #fff;
                background: linear-gradient(135deg, var(--c-primary), #7c3aed);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                transition: transform .2s, box-shadow .2s;
                box-shadow: 0 4px 14px rgba(79, 70, 229, .3);
            }

            .btn-next:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 22px rgba(79, 70, 229, .45);
            }

            /* ── Responsive ── */
            @media (max-width: 1024px) {
                .register-card { max-width: 860px; }
                .form-panel-reg { padding: 36px 36px; }
            }

            @media (max-width: 860px) {
                .register-card { grid-template-columns: 1fr; }
                .brand-panel-reg { padding: 32px 28px; }
                .step-track { display: none; }
                .form-panel-reg { padding: 32px 24px; }
            }

            @media (max-width: 480px) {
                .form-panel-reg { padding: 28px 18px; }
                .brand-panel-reg { padding: 24px 18px; }
            }
        </style>
    @endpush

    <div class="register-card">

        <!-- ===================== LEFT PANEL ===================== -->
        <div class="brand-panel-reg">
            <div class="brand-deco brand-deco-1"></div>
            <div class="brand-deco brand-deco-2"></div>
            <div class="brand-deco brand-deco-3"></div>
            <div class="brand-deco brand-deco-4"></div>

            <!-- Logo -->
            <a href="{{ route('login') }}" class="brand-logo">
                <div class="logo-icon-wrap"><i class="bi bi-camera-reels-fill"></i></div>
                <div>
                    <div class="brand-name">Doka<span>Kegiatan</span></div>
                    <div class="brand-sub">DOKUMENTASI KEGIATAN</div>
                </div>
            </a>

            <div class="brand-tagline">
                <h2>Bergabung &amp;<br />Mulai Dokumentasi</h2>
                <p>Buat akun gratis Anda dan mulai mencatat setiap momen kegiatan secara digital, rapi, dan
                    terstruktur.</p>
            </div>

            <!-- Step track (visible desktop) -->
            <div class="step-track" id="sideStepTrack">
                <div class="step-item" id="side-step-1">
                    <div class="step-num active" id="side-num-1">1</div>
                    <div class="step-text">
                        <strong>Informasi Akun</strong>
                        <span>Email, username & password</span>
                    </div>
                </div>
                <div class="step-item" id="side-step-2">
                    <div class="step-num" id="side-num-2">2</div>
                    <div class="step-text">
                        <strong>Data Pribadi</strong>
                        <span>Nama lengkap & profil</span>
                    </div>
                </div>
                <div class="step-item" id="side-step-3">
                    <div class="step-num" id="side-num-3">3</div>
                    <div class="step-text">
                        <strong>Konfirmasi</strong>
                        <span>Review &amp; buat akun</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===================== RIGHT PANEL ===================== -->
        <div class="form-panel-reg" id="formPanel">

            <!-- Progress bar -->
            <div class="progress-bar-wrap">
                <div class="prog-seg active" id="prog-1"></div>
                <div class="prog-seg" id="prog-2"></div>
                <div class="prog-seg" id="prog-3"></div>
            </div>

            <!-- Animated icon -->
            <div class="icon-ring-reg" id="topIcon">
                <i class="bi bi-person-plus-fill" id="topIconI"></i>
            </div>

            <!-- Heading -->
            <div class="form-heading" id="formHeading">
                <h1 id="stepTitle">Buat Akun Baru 🚀</h1>
                <p id="stepDesc">Langkah 1 dari 3 — isi informasi akun Anda untuk memulai.</p>
            </div>

            <!-- Alert -->
            <div class="alert-custom-reg alert-danger-reg d-none" id="formAlert">
                <i class="bi bi-exclamation-circle-fill flex-shrink-0"></i>
                <span id="formAlertMsg"></span>
            </div>

            <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <!-- ════ STEP 1: Akun ════ -->
                <div class="step-panel active" id="step-1">

                    <div class="field-section">Informasi Login</div>

                    <!-- Username -->
                    <label class="form-label" for="username">
                        Username <span class="required-dot">*</span>
                    </label>
                    <div class="field-wrap" id="wrap-username">
                        <i class="bi bi-at input-icon"></i>
                        <input type="text" id="username" name="username" class="form-ctrl" placeholder="nama_pengguna"
                            autocomplete="username" />
                    </div>
                    <div class="field-hint" style="margin-top:-14px; margin-bottom:18px; font-size:.75rem; color:var(--c-muted);">Gunakan huruf kecil, angka, dan underscore. Minimal 4 karakter.</div>
                    <div class="field-error" id="err-username" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Username wajib diisi.</div>

                    <!-- Email -->
                    <label class="form-label" for="email">
                        Alamat Email <span class="required-dot">*</span>
                    </label>
                    <div class="field-wrap" id="wrap-email">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" id="email" name="email" class="form-ctrl"
                            placeholder="nama@instansi.go.id" value="{{ $verifiedEmail ?? old('email') }}" {{ isset($verifiedEmail) ? 'readonly' : '' }} autocomplete="email" />
                    </div>
                    <div class="field-hint" style="margin-top:-14px; margin-bottom:18px; font-size:.75rem; color:var(--c-muted);">Gunakan email aktif — akan digunakan untuk verifikasi.</div>
                    <div class="field-error" id="err-email" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Email tidak valid.</div>

                    <div class="field-section" style="margin-top:24px;">Password</div>

                    <!-- Password -->
                    <label class="form-label" for="password">
                        Password <span class="required-dot">*</span>
                    </label>
                    <div class="field-wrap" id="wrap-password">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="password" name="password" class="form-ctrl"
                            placeholder="Min. 8 karakter" style="padding-right:42px;" autocomplete="new-password" />
                        <button type="button" class="toggle-pw" data-target="password" data-icon="eye1">
                            <i class="bi bi-eye-fill" id="eye1"></i>
                        </button>
                    </div>
                    <!-- Strength meter -->
                    <div class="pw-strength-wrap" style="margin-top:-10px; margin-bottom:18px;">
                        <div class="pw-strength-bar">
                            <div class="pw-strength-fill" id="pwStrengthFill"></div>
                        </div>
                        <span class="pw-strength-label" id="pwStrengthLabel">Belum diisi</span>
                    </div>
                    <div class="field-error" id="err-password" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Min. 8 karakter.</div>

                    <!-- Confirm Password -->
                    <label class="form-label" for="confirmPassword">
                        Konfirmasi Password <span class="required-dot">*</span>
                    </label>
                    <div class="field-wrap" id="wrap-confirmPassword">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="confirmPassword" name="password_confirmation" class="form-ctrl"
                            placeholder="Ulangi password" style="padding-right:42px;" autocomplete="new-password" />
                        <button type="button" class="toggle-pw" data-target="confirmPassword" data-icon="eye2">
                            <i class="bi bi-eye-fill" id="eye2"></i>
                        </button>
                    </div>
                    <div class="field-error" id="err-confirmPassword" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Password tidak cocok.</div>

                    <button type="button" class="btn-next" onclick="goNext(1)" style="width:100%;margin-top:8px;">
                        Lanjutkan <i class="bi bi-arrow-right"></i>
                    </button>

                    <div class="auth-divider">atau daftar dengan</div>

                    <div class="d-grid">
                        <a href="{{ route('auth.google') }}" class="btn-social"
                            style="text-decoration:none; justify-content:center; border: 2px solid var(--c-border); border-radius: 12px; padding: 12px; display: flex; align-items: center; gap: 10px; font-weight: 700; color: var(--c-text);">
                            <i class="bi bi-google" style="color:#ea4335;"></i> Daftar menggunakan Email Google
                        </a>
                    </div>
                </div>

                <!-- ════ STEP 2: Data Pribadi ════ -->
                <div class="step-panel" id="step-2">

                    <div class="field-section">Foto Profil</div>

                    <!-- Avatar upload -->
                    <div class="avatar-upload-zone" id="avatarZone">
                        <input type="file" id="avatarInput" name="avatar" accept="image/*" />
                        <div class="avatar-placeholder" id="avatarPlaceholder">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <img src="" alt="Preview" class="avatar-preview" id="avatarPreview" />
                        <div class="avatar-label">Klik untuk upload foto profil</div>
                        <div class="avatar-sub">JPG, PNG, WEBP · Maks. 2 MB (opsional)</div>
                    </div>

                    <div class="field-section" style="margin-top:24px;">Data Pribadi</div>

                    <!-- Full name -->
                    <label class="form-label" for="fullname">
                        Nama Lengkap <span class="required-dot">*</span>
                    </label>
                    <div class="field-wrap" id="wrap-fullname">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" id="fullname" name="name" class="form-ctrl"
                            placeholder="Nama sesuai identitas" autocomplete="name" />
                    </div>
                    <div class="field-error" id="err-fullname" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Nama lengkap wajib diisi.</div>

                    <!-- Phone -->
                    <label class="form-label" for="phone">Nomor WhatsApp / Telepon</label>
                    <div class="field-wrap">
                        <i class="bi bi-telephone-fill input-icon"></i>
                        <input type="tel" id="phone" name="phone" class="form-ctrl" placeholder="08xx-xxxx-xxxx"
                            autocomplete="tel" />
                    </div>

                    <div class="field-section" style="margin-top:24px;">Data Instansi</div>

                    <!-- Unit Kerja -->
                    <label class="form-label" for="unit_kerja_id">
                        Instansi / Unit Kerja <span class="required-dot">*</span>
                    </label>
                    <div class="field-wrap" id="wrap-unit_kerja_id">
                        <i class="bi bi-building-fill input-icon"></i>
                        <select id="unit_kerja_id" name="unit_kerja_id" class="form-ctrl select2">
                            <option value="">Pilih Instansi</option>
                            @foreach ($unitKerjas as $uk)
                                <option value="{{ $uk->id }}">{{ $uk->nama_instansi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-error" id="err-unit_kerja_id" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Instansi wajib dipilih.</div>

                    <div class="d-flex gap-3 mt-4">
                        <button type="button" class="btn-outline-nav" onclick="goBack(2)">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        <button type="button" class="btn-next" onclick="goNext(2)">
                            Lanjutkan <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>

                <!-- ════ STEP 3: Konfirmasi ════ -->
                <div class="step-panel" id="step-3">

                    <div class="field-section">Ringkasan Data</div>

                    <!-- Review card -->
                    <div
                        style="background:rgba(79,70,229,.05);border:1px solid rgba(79,70,229,.12);border-radius:16px;padding:20px;margin-bottom:20px;">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div id="reviewAvatar"
                                style="width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#e0e7ff,#cffafe);display:grid;place-items:center;font-size:1.6rem;color:var(--c-primary);border:2px solid rgba(79,70,229,.2);flex-shrink:0;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <div>
                                <div style="font-weight:700;color:var(--c-text);" id="rvFullname">—</div>
                                <div style="font-size:.8rem;color:var(--c-muted);" id="rvInstansi">—</div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <div
                                    style="font-size:.72rem;color:var(--c-muted);font-weight:600;text-transform:uppercase;letter-spacing:.8px;">
                                    Username</div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--c-text);" id="rvUsername">—</div>
                            </div>
                            <div class="col-6">
                                <div
                                    style="font-size:.72rem;color:var(--c-muted);font-weight:600;text-transform:uppercase;letter-spacing:.8px;">
                                    Email</div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--c-text);word-break:break-word;"
                                    id="rvEmail">—</div>
                            </div>
                            <div class="col-6 mt-1">
                                <div
                                    style="font-size:.72rem;color:var(--c-muted);font-weight:600;text-transform:uppercase;letter-spacing:.8px;">
                                    Telepon</div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--c-text);" id="rvPhone">—</div>
                            </div>
                            <div class="col-6 mt-1">
                                <div
                                    style="font-size:.72rem;color:var(--c-muted);font-weight:600;text-transform:uppercase;letter-spacing:.8px;">
                                    Jabatan</div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--c-text);" id="rvJabatan">—</div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms -->
                    <label class="terms-wrap-reg" for="agreeTerms">
                        <input type="checkbox" id="agreeTerms" />
                        <span class="check-box-reg"><i class="bi bi-check2"></i></span>
                        <span class="terms-text-reg">
                            Saya menyetujui <a href="#">Syarat &amp; Ketentuan</a> dan <a href="#">Kebijakan
                                Privasi</a> DokaKegiatan. Data yang saya berikan adalah benar dan dapat
                            dipertanggungjawabkan.
                        </span>
                    </label>

                    <div id="err-terms" style="font-size:.75rem;color:#ef4444;margin-bottom:12px;display:none;">
                        Anda harus menyetujui syarat &amp; ketentuan terlebih dahulu.
                    </div>

                    <div class="d-flex gap-3">
                        <button type="button" class="btn-outline-nav" onclick="goBack(3)">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </button>
                        <button type="submit" class="btn-primary-grad" id="btnSubmit" style="flex:2;">
                            <i class="bi bi-check2-circle"></i> Buat Akun Sekarang
                        </button>
                    </div>

                    <div class="divider">sudah punya akun?</div>
                    <div style="text-align:center;">
                        <a href="{{ route('login') }}"
                            style="color:var(--c-primary);font-weight:700;font-size:.9rem;text-decoration:none;">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                        </a>
                    </div>
                </div>

            </form>

            <!-- ════ SUCCESS SCREEN ════ -->
            <div class="success-screen-reg" id="successScreen">
                <div class="success-icon-wrap-reg"><i class="bi bi-check2-all"></i></div>
                <h2>Akun Berhasil Dibuat! 🎉</h2>
                <p>Selamat datang di DokaKegiatan. Akun Anda sudah aktif. Silakan masuk untuk mulai mendokumentasikan
                    kegiatan.</p>
                <a href="{{ route('login') }}" class="btn-primary-grad"
                    style="width:auto;padding:13px 36px;margin-top:28px;text-decoration:none;">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk Sekarang
                </a>
            </div>

            <!-- Footer (login link) -->
            <div class="form-footer" id="formFooter">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Pilih Instansi",
                    width: '100%'
                });
                
                // Re-validate select2 on change
                $('#unit_kerja_id').on('change', function() {
                    if ($(this).val()) clearErr('unit_kerja_id');
                });
            });

            /* ======================================================
               PASSWORD STRENGTH METER
               ====================================================== */
            const pwInput = document.getElementById('password');
            const strFill = document.getElementById('pwStrengthFill');
            const strLabel = document.getElementById('pwStrengthLabel');

            const LEVELS = [{
                    min: 0,
                    color: '#e5e7eb',
                    label: 'Belum diisi',
                    pct: '0%'
                },
                {
                    min: 1,
                    color: '#f87171',
                    label: 'Sangat lemah',
                    pct: '20%'
                },
                {
                    min: 4,
                    color: '#fb923c',
                    label: 'Lemah',
                    pct: '40%'
                },
                {
                    min: 6,
                    color: '#facc15',
                    label: 'Sedang',
                    pct: '60%'
                },
                {
                    min: 8,
                    color: '#4ade80',
                    label: 'Kuat',
                    pct: '80%'
                },
                {
                    min: 10,
                    color: '#10b981',
                    label: 'Sangat kuat 💪',
                    pct: '100%'
                },
            ];

            pwInput.addEventListener('input', () => {
                const v = pwInput.value;
                let score = v.length;
                if (/[A-Z]/.test(v)) score += 1;
                if (/[0-9]/.test(v)) score += 1;
                if (/[^A-Za-z0-9]/.test(v)) score += 2;
                let lvl = LEVELS[0];
                for (const l of LEVELS)
                    if (score >= l.min) lvl = l;
                strFill.style.width = lvl.pct;
                strFill.style.background = lvl.color;
                strLabel.textContent = lvl.label;
                strLabel.style.color = lvl.color === '#e5e7eb' ? 'var(--c-muted)' : lvl.color;
            });

            /* ======================================================
               AVATAR UPLOAD PREVIEW
               ====================================================== */
            document.getElementById('avatarInput').addEventListener('change', function() {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const prev = document.getElementById('avatarPreview');
                    const ph = document.getElementById('avatarPlaceholder');
                    prev.src = e.target.result;
                    prev.style.display = 'block';
                    ph.style.display = 'none';
                    /* update review avatar */
                    document.getElementById('reviewAvatar').innerHTML =
                        `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />`;
                };
                reader.readAsDataURL(file);
            });

            /* ======================================================
               STEP MACHINE
               ====================================================== */
            let currentStep = 1;
            const TOTAL = 3;

            const stepTitles = [
                '', // placeholder, steps are 1-indexed
                'Buat Akun Baru 🚀',
                'Data Pribadi 👤',
                'Konfirmasi & Selesai ✅',
            ];
            const stepDescs = [
                '',
                'Langkah 1 dari 3 — isi informasi akun Anda untuk memulai.',
                'Langkah 2 dari 3 — lengkapi data diri Anda.',
                'Langkah 3 dari 3 — review dan buat akun.',
            ];
            const stepIcons = ['', 'bi-person-plus-fill', 'bi-person-vcard-fill', 'bi-clipboard2-check-fill'];
            const iconGrads = [
                '',
                'linear-gradient(135deg,#10b981,#06b6d4)',
                'linear-gradient(135deg,#4f46e5,#7c3aed)',
                'linear-gradient(135deg,#f59e0b,#ec4899)',
            ];

            window.setStep = function(n) {
                currentStep = n;

                /* panels */
                document.querySelectorAll('.step-panel').forEach(p => p.classList.remove('active'));
                document.getElementById(`step-${n}`).classList.add('active');

                /* progress bars */
                for (let i = 1; i <= TOTAL; i++) {
                    const seg = document.getElementById(`prog-${i}`);
                    seg.classList.remove('done', 'active');
                    if (i < n) seg.classList.add('done');
                    if (i === n) seg.classList.add('active');
                }

                /* side step nums */
                for (let i = 1; i <= TOTAL; i++) {
                    const num = document.getElementById(`side-num-${i}`);
                    num.classList.remove('active', 'done');
                    num.innerHTML = i < n ? '<i class="bi bi-check2"></i>' : i;
                    if (i === n) num.classList.add('active');
                    if (i < n) num.classList.add('done');
                }

                /* heading */
                document.getElementById('stepTitle').textContent = stepTitles[n];
                document.getElementById('stepDesc').textContent = stepDescs[n];

                /* icon */
                const ring = document.getElementById('topIcon');
                const ico = document.getElementById('topIconI');
                ring.style.background = iconGrads[n];
                ring.style.boxShadow = n === 1 ? '0 8px 24px rgba(16,185,129,.35)' :
                    n === 2 ? '0 8px 24px rgba(79,70,229,.35)' :
                    '0 8px 24px rgba(245,158,11,.35)';
                ico.className = `bi ${stepIcons[n]}`;

                /* scroll form panel to top */
                document.getElementById('formPanel').scrollTop = 0;
                hideAlert();
            }

            /* ── Validation helpers ── */
            window.showErr = function(id, msg) {
                const wrap = document.getElementById(`wrap-${id}`);
                const inp = document.getElementById(id);
                const err = document.getElementById(`err-${id}`);
                if (wrap) wrap.classList.add('has-error');
                if (inp) inp.classList.add('is-error');
                if (err && msg) {
                    err.textContent = msg;
                    err.style.display = 'block';
                }
                return false;
            }
            window.clearErr = function(id) {
                const wrap = document.getElementById(`wrap-${id}`);
                const inp = document.getElementById(id);
                const err = document.getElementById(`err-${id}`);
                if (wrap) wrap.classList.remove('has-error');
                if (inp) {
                    inp.classList.remove('is-error');
                    inp.classList.add('is-valid');
                }
                if (err) {
                    err.textContent = '';
                    err.style.display = 'none';
                }
            }

            window.hideAlert = function() {
                document.getElementById('formAlert').classList.add('d-none');
            }
            window.showAlert = function(msg) {
                const el = document.getElementById('formAlert');
                document.getElementById('formAlertMsg').textContent = msg;
                el.classList.remove('d-none');
            }

            /* ── Validate step 1 ── */
            function validateStep1() {
                let ok = true;

                const uname = document.getElementById('username').value.trim();
                if (uname.length < 4 || !/^[a-z0-9_]+$/.test(uname)) {
                    showErr('username', 'Username minimal 4 karakter, hanya huruf kecil, angka, underscore.');
                    ok = false;
                } else clearErr('username');

                const email = document.getElementById('email').value.trim();
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    showErr('email', 'Masukkan alamat email yang valid.');
                    ok = false;
                } else clearErr('email');

                const pw = document.getElementById('password').value;
                if (pw.length < 8) {
                    showErr('password', 'Password minimal 8 karakter.');
                    ok = false;
                } else clearErr('password');

                const cpw = document.getElementById('confirmPassword').value;
                if (cpw !== pw || cpw === '') {
                    showErr('confirmPassword', 'Password tidak cocok.');
                    ok = false;
                } else clearErr('confirmPassword');

                return ok;
            }

            /* ── Validate step 2 ── */
            function validateStep2() {
                let ok = true;
                const fn = document.getElementById('fullname').value.trim();
                if (!fn) {
                    showErr('fullname', 'Nama lengkap wajib diisi.');
                    ok = false;
                } else clearErr('fullname');

                const unitEl = document.getElementById('unit_kerja_id');
                if (unitEl) {
                    const unitId = unitEl.value;
                    if (!unitId) {
                        showErr('unit_kerja_id', 'Instansi wajib dipilih.');
                        ok = false;
                    } else clearErr('unit_kerja_id');
                }

                return ok;
            }

            /* ── Populate review (step 3) ── */
            function populateReview() {
                document.getElementById('rvFullname').textContent = document.getElementById('fullname').value.trim() || '—';
                document.getElementById('rvUsername').textContent = document.getElementById('username').value.trim() || '—';
                document.getElementById('rvEmail').textContent = document.getElementById('email').value.trim() || '—';
                document.getElementById('rvPhone').textContent = document.getElementById('phone').value.trim() || '—';

                const unitEl = document.getElementById('unit_kerja_id');
                const unitName = unitEl && unitEl.selectedIndex > 0 ? unitEl.options[unitEl.selectedIndex].text : '—';
                document.getElementById('rvInstansi').textContent = unitName;

                const jabEl = document.getElementById('jabatan');
                document.getElementById('rvJabatan').textContent = jabEl ? (jabEl.value.trim() || '—') : '—';
            }

            /* ── Next / Back ── */
            window.goNext = function(from) {
                hideAlert();
                if (from === 1 && !validateStep1()) {
                    showAlert('Harap perbaiki kesalahan di formulir.');
                    return;
                }
                if (from === 2 && !validateStep2()) {
                    showAlert('Harap perbaiki kesalahan di formulir.');
                    return;
                }
                if (from === 2) populateReview();
                setStep(from + 1);
            }
            window.goBack = function(from) {
                hideAlert();
                setStep(from - 1);
            }

            /* ── Custom checkbox click ── */
            document.querySelectorAll('label.terms-wrap-reg').forEach(lbl => {
                const cb = lbl.querySelector('input[type=checkbox]');
                const box = lbl.querySelector('.check-box-reg');
                box.addEventListener('click', e => {
                    e.preventDefault();
                    cb.checked = !cb.checked;
                });
            });

            /* ── Submit ── */
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const agreed = document.getElementById('agreeTerms').checked;
                const errTerms = document.getElementById('err-terms');
                if (!agreed) {
                    errTerms.style.display = 'block';
                    window.scrollTo({ top: errTerms.offsetTop - 100, behavior: 'smooth' });
                    return;
                }
                errTerms.style.display = 'none';

                const btn = document.getElementById('btnSubmit');
                const originalBtnHtml = btn.innerHTML;
                
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Membuat akun...';
                
                hideAlert();
                
                // Clear previous errors
                document.querySelectorAll('.field-error').forEach(el => el.style.display = 'none');
                document.querySelectorAll('.is-error').forEach(el => el.classList.remove('is-error'));

                const formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            /* Hide form, show success */
                            document.getElementById('registerForm').style.display = 'none';
                            document.getElementById('formHeading').style.display = 'none';
                            document.getElementById('formAlert').style.display = 'none';
                            document.querySelector('.icon-ring-reg').style.display = 'none';
                            document.querySelector('.progress-bar-wrap').style.display = 'none';
                            document.getElementById('formFooter').style.display = 'none';
                            document.getElementById('successScreen').classList.add('show');
                            
                            // Optional: redirect after some delay if success screen is just for show
                            // setTimeout(() => window.location.href = response.redirect, 3000);
                        }
                    },
                    error: function(xhr) {
                        btn.disabled = false;
                        btn.innerHTML = originalBtnHtml;

                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let firstErrField = null;

                            for (const field in errors) {
                                // Map field name to ID (some might be different like password_confirmation)
                                let id = field;
                                if (field === 'password') id = 'password';
                                if (field === 'password_confirmation') id = 'confirmPassword';
                                
                                const msg = errors[field][0];
                                showErr(id, msg);
                                
                                if (!firstErrField) firstErrField = id;
                            }

                            showAlert('Harap perbaiki kesalahan pendaftaran Anda.');
                            
                            // If first error is on step 1/2, go back there
                            if (firstErrField === 'username' || firstErrField === 'email' || firstErrField === 'password') {
                                setStep(1);
                            } else if (firstErrField === 'name' || firstErrField === 'phone' || firstErrField === 'avatar' || firstErrField === 'unit_kerja_id') {
                                setStep(2);
                            }
                        } else {
                            showAlert('Terjadi kesalahan sistem. Silakan coba beberapa saat lagi.');
                        }
                    }
                });
            });
        </script>
    @endpush
</x-guest-layout>
