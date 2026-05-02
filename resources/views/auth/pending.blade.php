<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DokaKegiatan — Akun Menunggu Aktivasi</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@700;800;900&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/dka-alert.css') }}">

    <style>
        :root {
            --c-primary: #4f46e5;
            --c-secondary: #06b6d4;
            --c-accent: #f59e0b;
            --c-pink: #ec4899;
            --c-green: #10b981;
            --c-orange: #f97316;
            --c-red: #ef4444;
            --c-purple: #7c3aed;
            --c-bg: #f1f5f9;
            --c-surface: #ffffff;
            --c-border: #e2e8f0;
            --c-text: #1e293b;
            --c-text-2: #475569;
            --c-muted: #94a3b8;
            --radius-md: 14px;
            --radius-lg: 20px;
            --shadow-lg: 0 12px 48px rgba(0, 0, 0, .14);
            --trans: .25s cubic-bezier(.4, 0, .2, 1);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--c-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* ─── Particle canvas ─── */
        #particleCanvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ─── Background gradient ─── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 70% 60% at 10% 20%, rgba(79, 70, 229, .12), transparent 65%),
                radial-gradient(ellipse 60% 50% at 90% 80%, rgba(6, 182, 212, .10), transparent 60%),
                radial-gradient(ellipse 50% 55% at 50% 50%, rgba(236, 72, 153, .06), transparent 70%),
                linear-gradient(160deg, #f8faff 0%, #eef2ff 40%, #f0fdfa 100%);
        }

        /* ═══════════════════════════════════
       MAIN CARD
    ═══════════════════════════════════ */
        .pending-card {
            position: relative;
            z-index: 10;
            background: var(--c-surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg), 0 0 0 1px rgba(79, 70, 229, .06);
            width: 100%;
            max-width: 560px;
            overflow: hidden;
            animation: cardIn .55s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(32px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* ─── Card top band ─── */
        .card-band {
            height: 5px;
            background: linear-gradient(90deg, var(--c-accent), var(--c-orange), var(--c-pink));
        }

        /* ─── Status hero ─── */
        .status-hero {
            background: linear-gradient(135deg,
                    rgba(245, 158, 11, .08) 0%,
                    rgba(249, 115, 22, .06) 50%,
                    rgba(236, 72, 153, .04) 100%);
            border-bottom: 1px solid rgba(245, 158, 11, .15);
            padding: 32px 36px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .status-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(45deg,
                    rgba(245, 158, 11, .04) 0, rgba(245, 158, 11, .04) 1px,
                    transparent 0, transparent 50%);
            background-size: 18px 18px;
        }

        /* Animated status icon */
        .status-icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border: 3px solid rgba(245, 158, 11, .3);
            display: grid;
            place-items: center;
            margin: 0 auto 18px;
            position: relative;
            animation: iconFloat 4s ease-in-out infinite;
            box-shadow: 0 8px 24px rgba(245, 158, 11, .25);
        }

        .status-icon-wrap::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px dashed rgba(245, 158, 11, .3);
            animation: ringRotate 10s linear infinite;
        }

        .status-icon-wrap::after {
            content: '';
            position: absolute;
            inset: -16px;
            border-radius: 50%;
            border: 1px dashed rgba(245, 158, 11, .15);
            animation: ringRotate 16s linear infinite reverse;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0)
            }

            50% {
                transform: translateY(-6px)
            }
        }

        @keyframes ringRotate {
            to {
                transform: rotate(360deg)
            }
        }

        .status-icon-wrap i {
            font-size: 2rem;
            color: var(--c-accent);
            animation: iconPulse 2s ease-in-out infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.1)
            }
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            color: #d97706;
            border-radius: 99px;
            padding: 5px 14px;
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .4px;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .status-badge::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--c-accent);
            animation: dotPulse 2s ease infinite;
        }

        @keyframes dotPulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(245, 158, 11, .5)
            }

            50% {
                box-shadow: 0 0 0 6px rgba(245, 158, 11, 0)
            }
        }

        .status-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.45rem;
            color: var(--c-text);
            margin-bottom: 8px;
        }

        .status-desc {
            font-size: .875rem;
            color: var(--c-text-2);
            line-height: 1.7;
        }

        /* User info chip */
        .user-chip {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            border: 1px solid var(--c-border);
            border-radius: 99px;
            padding: 6px 14px 6px 6px;
            margin-top: 14px;
        }

        .user-chip-av {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--c-primary), var(--c-pink));
            display: grid;
            place-items: center;
            color: #fff;
            font-size: .78rem;
            font-weight: 800;
        }

        .user-chip-name {
            font-size: .82rem;
            font-weight: 700;
            color: var(--c-text);
        }

        .user-chip-email {
            font-size: .72rem;
            color: var(--c-muted);
        }

        /* ─── Form area ─── */
        .card-form {
            padding: 28px 36px 32px;
        }

        .section-label {
            font-size: .68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--c-muted);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .section-label::before {
            content: '';
            flex: 0 0 16px;
            height: 2px;
            background: linear-gradient(90deg, var(--c-accent), var(--c-orange));
            border-radius: 2px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--c-border);
        }

        /* Form group */
        .fgroup {
            margin-bottom: 18px;
        }

        .fgroup:last-child {
            margin-bottom: 0;
        }

        .flabel {
            font-size: .82rem;
            font-weight: 700;
            color: var(--c-text);
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .flabel .req {
            color: var(--c-pink);
        }

        .fhint {
            font-size: .72rem;
            color: var(--c-muted);
            margin-top: 5px;
        }

        .finvalid {
            font-size: .72rem;
            color: var(--c-red);
            margin-top: 5px;
            display: none;
        }

        .fgroup.has-err .finvalid {
            display: block;
        }

        .fwrap {
            position: relative;
        }

        .ficon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-muted);
            font-size: .9rem;
            pointer-events: none;
            z-index: 1;
            transition: color var(--trans);
        }

        .fwrap:focus-within .ficon {
            color: var(--c-primary);
        }

        .fctrl {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border: 1.5px solid var(--c-border);
            border-radius: 11px;
            font-size: .875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8fafc;
            color: var(--c-text);
            outline: none;
            transition: border-color var(--trans), box-shadow var(--trans), background var(--trans);
        }

        .fctrl:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, .1);
            background: #fff;
        }

        .fgroup.has-err .fctrl {
            border-color: var(--c-red);
        }

        /* ─── Select2 Custom Styling ─── */
        .select2-container {
            width: 100% !important;
        }

        /* Custom Select2 like Register Page */
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
            line-height: 52px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px;
            right: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute;
            right: 38px;
            top: 50%;
            transform: translateY(-50%);
            margin: 0;
            color: var(--c-red);
            font-size: 1.1rem;
            opacity: 0.6;
        }

        .select2-dropdown {
            border: 1px solid var(--c-border);
            border-radius: 12px;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.1), 0 10px 15px -6px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            z-index: 9999;
            margin-top: 5px;
            background: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
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

        .select2-results__options {
            max-height: 350px;
            overflow-y: auto;
        }

        /* Group label styling */
        .select2-results__group {
            font-size: .65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--c-muted);
            padding: 12px 18px 6px;
            background: #f8fafc;
        }

        /* Custom option template */
        .s2-opt {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0;
        }

        .s2-opt-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            font-size: .85rem;
            color: #fff;
            flex-shrink: 0;
        }

        .s2-opt-info {
            flex: 1;
            min-width: 0;
        }

        .s2-opt-name {
            font-size: .875rem;
            font-weight: 700;
            color: var(--c-text);
        }

        .s2-opt-sub {
            font-size: .68rem;
            color: var(--c-muted);
            margin-top: 1px;
            font-family: 'DM Mono', monospace;
        }

        .s2-opt-badge {
            flex-shrink: 0;
            font-size: .62rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 99px;
        }

        /* ─── Alasan / Catatan ─── */
        textarea.fctrl {
            padding-left: 40px;
            resize: vertical;
            min-height: 80px;
            padding-top: 12px;
        }

        /* ─── Info alert box ─── */
        .info-box {
            background: linear-gradient(135deg, rgba(79, 70, 229, .06), rgba(6, 182, 212, .04));
            border: 1px solid rgba(79, 70, 229, .15);
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .info-box-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--c-primary), var(--c-secondary));
            display: grid;
            place-items: center;
            color: #fff;
            font-size: .85rem;
            flex-shrink: 0;
        }

        .info-box-text {
            font-size: .82rem;
            color: var(--c-text-2);
            line-height: 1.65;
        }

        .info-box-text strong {
            color: var(--c-primary);
        }

        /* ─── Step indicator ─── */
        .step-timeline {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-bottom: 22px;
        }

        .step-tl-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .step-tl-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex-shrink: 0;
            width: 28px;
        }

        .step-tl-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            font-size: .75rem;
            color: #fff;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .12);
        }

        .std-done {
            background: linear-gradient(135deg, var(--c-green), #34d399);
        }

        .std-active {
            background: linear-gradient(135deg, var(--c-accent), var(--c-orange));
            animation: dotPulse 2s ease infinite;
        }

        .std-pending {
            background: var(--c-border);
            color: var(--c-muted);
        }

        .step-tl-line {
            width: 2px;
            flex: 1;
            background: var(--c-border);
            min-height: 18px;
            margin: 3px 0;
        }

        .step-tl-item:last-child .step-tl-line {
            display: none;
        }

        .step-tl-content {
            flex: 1;
            padding: 2px 0 16px;
        }

        .step-tl-title {
            font-size: .85rem;
            font-weight: 700;
            color: var(--c-text);
        }

        .step-tl-desc {
            font-size: .74rem;
            color: var(--c-muted);
            margin-top: 2px;
        }

        .step-tl-item.done .step-tl-title {
            color: var(--c-green);
        }

        .step-tl-item.active .step-tl-title {
            color: var(--c-accent);
        }

        /* ─── Submit button ─── */
        .btn-submit {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, var(--c-primary), var(--c-purple));
            color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(79, 70, 229, .35);
            transition: transform var(--trans), box-shadow var(--trans);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(79, 70, 229, .5);
        }

        .btn-submit:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-logout {
            width: 100%;
            padding: 11px;
            border-radius: 12px;
            border: 1.5px solid var(--c-border);
            background: #fff;
            color: var(--c-text-2);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: .875rem;
            cursor: pointer;
            transition: all var(--trans);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-logout:hover {
            border-color: var(--c-red);
            color: var(--c-red);
            background: #fef2f2;
        }

        /* ─── Success state (shown after submit) ─── */
        .success-overlay {
            position: fixed;
            inset: 0;
            z-index: 999;
            background: rgba(15, 23, 42, .75);
            backdrop-filter: blur(8px);
            display: grid;
            place-items: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: opacity .35s;
        }

        .success-overlay.show {
            opacity: 1;
            pointer-events: all;
        }

        .success-card {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 40px 36px;
            max-width: 440px;
            width: 100%;
            text-align: center;
            transform: translateY(20px) scale(.95);
            transition: transform .4s cubic-bezier(.34, 1.56, .64, 1);
            box-shadow: var(--shadow-lg);
        }

        .success-overlay.show .success-card {
            transform: translateY(0) scale(1);
        }

        .success-icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--c-green), #34d399);
            display: grid;
            place-items: center;
            margin: 0 auto 18px;
            box-shadow: 0 8px 24px rgba(16, 185, 129, .3);
            animation: iconFloat 3s ease-in-out infinite;
        }

        .success-icon-wrap i {
            font-size: 2rem;
            color: #fff;
        }

        .success-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: var(--c-text);
            margin-bottom: 8px;
        }

        .success-desc {
            font-size: .875rem;
            color: var(--c-text-2);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .success-info {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: .82rem;
            color: #065f46;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Branding footer */
        .brand-footer {
            text-align: center;
            margin-top: 18px;
            font-size: .72rem;
            color: var(--c-muted);
        }

        .brand-footer strong {
            color: var(--c-primary);
        }

        /* Responsive */
        @media(max-width:576px) {
            .status-hero {
                padding: 24px 20px 20px;
            }

            .card-form {
                padding: 22px 20px 26px;
            }

            .status-title {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    <canvas id="particleCanvas"></canvas>

    <!-- ═══════════ MAIN CARD ═══════════ -->
    <div class="pending-card">
        <div class="card-band"></div>

        <!-- Status Hero -->
        <div class="status-hero">
            <div class="status-icon-wrap">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="status-badge">Menunggu Aktivasi</div>
            <h1 class="status-title">Akun Anda Belum Aktif</h1>
            <p class="status-desc">
                Pendaftaran berhasil! Sebelum dapat mengakses sistem,
                lengkapi data Anda dan tunggu verifikasi dari Administrator.
            </p>
            <div class="user-chip">
                <div class="user-chip-av" id="userChipAv">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</div>
                <div>
                    <div class="user-chip-name" id="userChipName">{{ auth()->user()->name }}</div>
                    <div class="user-chip-email" id="userChipEmail">{{ auth()->user()->email }}</div>
                </div>
            </div>
        </div>

        @php
            $u = auth()->user();
            $showBasic =
                empty($u->unit_kerja_id) ||
                (empty($u->nip) && empty($u->nik)) ||
                empty($u->jabatan) ||
                empty($u->phone);
        @endphp

        <!-- Form -->
        <div class="card-form">

            <!-- Step progress -->
            <div class="section-label">Proses Aktivasi Akun</div>
            <div class="step-timeline">
                <div class="step-tl-item done">
                    <div class="step-tl-col">
                        <div class="step-tl-dot std-done"><i class="bi bi-check-lg"></i></div>
                        <div class="step-tl-line"></div>
                    </div>
                    <div class="step-tl-content">
                        <div class="step-tl-title">Pendaftaran Akun</div>
                        <div class="step-tl-desc">Data akun berhasil disimpan ke sistem</div>
                    </div>
                </div>
                <div class="step-tl-item {{ !$showBasic ? 'done' : 'active' }}">
                    <div class="step-tl-col">
                        <div class="step-tl-dot {{ !$showBasic ? 'std-done' : 'std-active' }}"><i
                                class="bi {{ !$showBasic ? 'bi-check-lg' : 'bi-building-fill' }}"></i></div>
                        <div class="step-tl-line"></div>
                    </div>
                    <div class="step-tl-content">
                        <div class="step-tl-title">Data Instansi & Profil</div>
                        <div class="step-tl-desc">
                            {{ !$showBasic ? 'Data profil Anda sudah lengkap' : 'Lengkapi data instansi tempat Anda bertugas' }}
                        </div>
                    </div>
                </div>
                <div class="step-tl-item {{ !$showBasic ? 'active' : '' }}">
                    <div class="step-tl-col">
                        <div class="step-tl-dot {{ !$showBasic ? 'std-active' : 'std-pending' }}"><i
                                class="bi bi-shield-check"></i></div>
                        <div class="step-tl-line"></div>
                    </div>
                    <div class="step-tl-content">
                        <div class="step-tl-title">Verifikasi Administrator</div>
                        <div class="step-tl-desc">Administrator akan memeriksa dan mengaktifkan akun Anda</div>
                    </div>
                </div>
                <div class="step-tl-item">
                    <div class="step-tl-col">
                        <div class="step-tl-dot std-pending"><i class="bi bi-unlock-fill"></i></div>
                    </div>
                    <div class="step-tl-content">
                        <div class="step-tl-title">Akun Aktif & Siap Digunakan</div>
                        <div class="step-tl-desc">Anda dapat login dan menggunakan seluruh fitur sistem</div>
                    </div>
                </div>
            </div>

            <!-- Info box -->
            <div class="info-box">
                <div class="info-box-icon"><i class="bi bi-info-circle-fill"></i></div>
                <div class="info-box-text">
                    @if ($showBasic)
                        Pilih <strong>instansi / unit kerja</strong> tempat Anda bertugas dengan tepat. Data ini akan
                        digunakan untuk menentukan akses fitur dan laporan yang tersedia untuk Anda.
                    @else
                        Data profil Anda sudah lengkap. Anda bisa menambahkan <strong>catatan tambahan</strong> jika ada
                        informasi lain yang ingin disampaikan ke Administrator, lalu klik tombol kirim di bawah.
                    @endif
                </div>
            </div>

            @if ($showBasic)
                <!-- Form fields -->
                <div class="section-label">Data Instansi</div>
            @endif

            <!-- Select Instansi -->
            <div class="fgroup" id="grp-instansi" {!! !empty($u->unit_kerja_id) ? 'style="display:none;"' : '' !!}>
                <div class="flabel">
                    <i class="bi bi-building-fill" style="color:var(--c-muted);font-size:.85rem;"></i>
                    Instansi / Unit Kerja <span class="req">*</span>
                </div>
                <div class="fwrap" style="position:relative;">
                    <i class="bi bi-building-fill ficon" style="z-index:1;pointer-events:none;"></i>
                    <select id="selectInstansi" style="display:none;">
                        <option value="">-- Pilih Instansi --</option>
                        @foreach ($unitKerjas->groupBy('jenis_opd') as $jenis => $items)
                            <optgroup label="{{ $jenis }}">
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}"
                                        {{ auth()->user()->unit_kerja_id == $item->id ? 'selected' : '' }}
                                        data-singkatan="{{ $item->singkatan }}" data-jenis="{{ $item->jenis_opd }}"
                                        data-icon="{{ $item->icon }}" data-warna="{{ $item->warna }}">
                                        {{ $item->nama_instansi }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                <div class="finvalid"><i class="bi bi-exclamation-circle"></i> Pilih instansi tempat Anda bertugas.
                </div>
                <div class="fhint"><i class="bi bi-search"></i> Ketik nama instansi untuk mencari lebih cepat.</div>
            </div>

            <!-- Status Kepegawaian -->
            <div class="fgroup" {!! !empty($u->nip) || !empty($u->nik) ? 'style="display:none;"' : '' !!}>
                <div class="flabel">
                    <i class="bi bi-person-vcard-fill" style="color:var(--c-muted);font-size:.85rem;"></i>
                    Status Kepegawaian <span class="req">*</span>
                </div>
                <div class="d-flex gap-3 mt-2">
                    <div class="form-check custom-radio">
                        <input class="form-check-input" type="radio" name="status_pegawai" id="statusASN"
                            value="asn" {{ !auth()->user()->nik ? 'checked' : '' }} onchange="toggleIdType()">
                        <label class="form-check-label" for="statusASN"
                            style="font-size:.875rem;font-weight:600;cursor:pointer;">ASN (PNS/PPPK)</label>
                    </div>
                    <div class="form-check custom-radio">
                        <input class="form-check-input" type="radio" name="status_pegawai" id="statusNonASN"
                            value="non-asn" {{ auth()->user()->nik ? 'checked' : '' }} onchange="toggleIdType()">
                        <label class="form-check-label" for="statusNonASN"
                            style="font-size:.875rem;font-weight:600;cursor:pointer;">Non-ASN / THL</label>
                    </div>
                </div>
            </div>

            <!-- NIP / NIK -->
            <div class="fgroup" id="grp-id" {!! !empty($u->nip) || !empty($u->nik) ? 'style="display:none;"' : '' !!}>
                <div class="flabel">
                    <i class="bi bi-person-badge-fill" style="color:var(--c-muted);font-size:.85rem;"></i>
                    <span id="labelID">NIP / ID Pegawai</span> <span class="req">*</span>
                </div>
                <div class="fwrap">
                    <i class="bi bi-person-badge-fill ficon"></i>
                    <input type="text" class="fctrl" id="fID" placeholder="Contoh: 198504172010011004"
                        value="{{ auth()->user()->nip ?? auth()->user()->nik }}" maxlength="30"
                        oninput="clearErr('grp-id');formatID(this)"
                        style="font-family:'DM Mono',monospace;letter-spacing:1px;" />
                </div>
                <div class="finvalid"><i class="bi bi-exclamation-circle"></i> <span id="errID">NIP/ID pegawai
                        wajib diisi.</span></div>
                <div class="fhint" id="hintID">Nomor Induk Pegawai atau ID yang diberikan instansi Anda.</div>
            </div>

            <!-- Jabatan -->
            <div class="fgroup" id="grp-jabatan" {!! !empty($u->jabatan) ? 'style="display:none;"' : '' !!}>
                <div class="flabel">
                    <i class="bi bi-briefcase-fill" style="color:var(--c-muted);font-size:.85rem;"></i>
                    Jabatan / Posisi <span class="req">*</span>
                </div>
                <div class="fwrap">
                    <i class="bi bi-briefcase-fill ficon"></i>
                    <input type="text" class="fctrl" id="fJabatan" placeholder="Contoh: Staf Dokumentasi"
                        value="{{ auth()->user()->jabatan }}" maxlength="60" oninput="clearErr('grp-jabatan')" />
                </div>
                <div class="finvalid"><i class="bi bi-exclamation-circle"></i> Jabatan wajib diisi.</div>
            </div>

            <!-- No HP -->
            <div class="fgroup" {!! !empty($u->phone) ? 'style="display:none;"' : '' !!}>
                <div class="flabel">
                    <i class="bi bi-telephone-fill" style="color:var(--c-muted);font-size:.85rem;"></i>
                    Nomor HP / WhatsApp
                    <span style="color:var(--c-muted);font-weight:500;font-size:.72rem;">(opsional)</span>
                </div>
                <div class="fwrap">
                    <i class="bi bi-telephone-fill ficon"></i>
                    <input type="tel" class="fctrl" id="fHP" placeholder="Contoh: 08123456789"
                        value="{{ auth()->user()->phone ?? '' }}" maxlength="15" />
                </div>
                <div class="fhint">Nomor ini digunakan Admin untuk konfirmasi aktivasi akun.</div>
            </div>

            <!-- Catatan -->
            <div class="fgroup" style="margin-bottom:24px;">
                <div class="flabel">
                    <i class="bi bi-chat-text-fill" style="color:var(--c-muted);font-size:.85rem;"></i>
                    Catatan / Keterangan Tambahan
                    <span style="color:var(--c-muted);font-weight:500;font-size:.72rem;">(opsional)</span>
                </div>
                <div class="fwrap">
                    <i class="bi bi-chat-text-fill ficon" style="top:15px;transform:none;"></i>
                    <textarea class="fctrl" id="fCatatan" rows="3"
                        placeholder="Tambahkan informasi lain yang perlu diketahui Administrator..."></textarea>
                </div>
            </div>

            <!-- Submit -->
            <button class="btn-submit" id="btnSubmit" onclick="submitForm()">
                <i class="bi bi-send-check-fill" style="font-size:1.05rem;"></i>
                Kirim Pengajuan Aktivasi
            </button>
            <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display:none;">
                @csrf
            </form>
            <button class="btn-logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i> Keluar dari Akun
            </button>

            <!-- Branding -->
            <div class="brand-footer">
                <strong>DokaKegiatan</strong> — Sistem Dokumentasi Kegiatan Kota Pekalongan &copy; 2025
            </div>
        </div>
    </div>

    <!-- ─── Success Overlay ─── -->
    <div class="success-overlay" id="successOverlay">
        <div class="success-card">
            <div class="success-icon-wrap"><i class="bi bi-check-circle-fill"></i></div>
            <h2 class="success-title">Pengajuan Terkirim!</h2>
            <p class="success-desc">
                Pengajuan aktivasi akun telah dikirimkan kepada Administrator.
            </p>
            <div class="success-info">
                <i class="bi bi-bell-fill" style="color:var(--c-green);font-size:1rem;"></i>
                Anda akan mendapat notifikasi email/WhatsApp setelah akun diaktifkan.
            </div>
            <div style="height:14px;"></div>
            <div style="font-size:.82rem;color:var(--c-muted);margin-bottom:6px;">Estimasi waktu aktivasi</div>
            <div style="font-family:'DM Mono',monospace;font-size:1.1rem;font-weight:700;color:var(--c-primary);">1 ×
                24 Jam Kerja</div>

            <div style="margin-top: 30px;">
                <button class="btn-submit"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    style="box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);">
                    <i class="bi bi-check2-circle"></i> Selesai & Keluar
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function clearErr(id) {
            document.getElementById(id)?.classList.remove('has-err');
        }

        function setErr(id) {
            document.getElementById(id)?.classList.add('has-err');
        }

        $(document).ready(function() {
            /* Init Select2 */
            $('#selectInstansi').select2({
                placeholder: 'Cari instansi / unit kerja...',
                allowClear: true,
                templateResult: formatInstansiOption,
                templateSelection: formatInstansiSelection,
                width: '100%',
                dropdownAutoWidth: false,
                language: {
                    noResults: () => 'Instansi tidak ditemukan',
                    searching: () => 'Mencari...',
                },
            });

            /* Fix: move select2 container inside fwrap so icon aligns */
            const sel = $('#selectInstansi');
            const fwrap = sel.closest('.fwrap');
            const s2container = sel.next('.select2-container');
            fwrap.append(s2container);

            /* Clear error on change */
            sel.on('change', function() {
                clearErr('grp-instansi');
            });
        });

        function formatInstansiOption(opt) {
            if (!opt.id) return opt.text;
            const sing = $(opt.element).data('singkatan');
            const jenis = $(opt.element).data('jenis');
            const icon = $(opt.element).data('icon') || 'bi-building';
            const warna = $(opt.element).data('warna') || '#4f46e5';

            return $(`
    <div class="s2-opt">
      <div class="s2-opt-icon" style="background:${warna};">
        <i class="bi ${icon}" style="font-size:.85rem;"></i>
      </div>
      <div class="s2-opt-info">
        <div class="s2-opt-name">${opt.text}</div>
        <div class="s2-opt-sub">${sing}</div>
      </div>
      <span class="s2-opt-badge" style="background:rgba(0,0,0,0.05);color:#64748b;">${jenis}</span>
    </div>`);
        }

        function formatInstansiSelection(opt) {
            if (!opt.id) return opt.text;
            const sing = $(opt.element).data('singkatan');
            const icon = $(opt.element).data('icon') || 'bi-building';
            const warna = $(opt.element).data('warna') || '#4f46e5';

            return $(`
    <span style="display:inline-flex;align-items:center;gap:7px;">
      <span style="display:inline-grid;place-items:center;width:20px;height:20px;border-radius:5px;background:${warna};margin-top: 16px !important;">
        <i class="bi ${icon}" style="font-size:.6rem;color:#fff;"></i>
      </span>
      <span style="font-weight:700;font-size:.85rem;padding-top:13px;">${opt.text}</span>
      <span style="font-family:'DM Mono',monospace;font-size:.7rem;color:#94a3b8;margin-top: 16px;">${sing}</span>
    </span>`);
        }

        function toggleIdType() {
            const type = document.querySelector('input[name="status_pegawai"]:checked').value;
            const label = document.getElementById('labelID');
            const input = document.getElementById('fID');
            const err = document.getElementById('errID');
            const hint = document.getElementById('hintID');

            if (type === 'asn') {
                label.innerText = 'NIP (Nomor Induk Pegawai)';
                input.placeholder = 'Contoh: 198504172010011004';
                err.innerText = 'NIP wajib diisi.';
                hint.innerText = 'Masukkan 18 digit NIP Anda.';
            } else {
                label.innerText = 'NIK (Nomor Induk Kependudukan)';
                input.placeholder = 'Contoh: 3375012345678901';
                err.innerText = 'NIK wajib diisi.';
                hint.innerText = 'Masukkan 16 digit NIK Anda sesuai KTP.';
            }
            clearErr('grp-id');
        }

        function formatID(el) {
            el.value = el.value.replace(/\D/g, '');
            const type = document.querySelector('input[name="status_pegawai"]:checked').value;
            if (type === 'asn') el.value = el.value.slice(0, 18);
            else el.value = el.value.slice(0, 16);
        }

        function submitForm() {
            const instansi = $('#selectInstansi').val() || '{{ auth()->user()->unit_kerja_id }}';
            const idValue = document.getElementById('fID').value.trim() ||
                '{{ auth()->user()->nip ?? auth()->user()->nik }}';
            const jabatan = document.getElementById('fJabatan').value.trim() || '{{ auth()->user()->jabatan }}';
            const statusPegawai = document.querySelector('input[name="status_pegawai"]:checked')?.value ||
                '{{ auth()->user()->nik ? 'non-asn' : 'asn' }}';
            const hp = document.getElementById('fHP').value.trim() || '{{ auth()->user()->phone }}';
            const catatan = document.getElementById('fCatatan').value.trim();
            const btn = document.getElementById('btnSubmit');

            const showBasic = {{ $showBasic ? 'true' : 'false' }};
            let ok = true;

            if (showBasic) {
                if (!instansi) {
                    setErr('grp-instansi');
                    ok = false;
                } else clearErr('grp-instansi');

                if (!idValue) {
                    setErr('grp-id');
                    document.getElementById('errID').innerText = 'NIP/NIK wajib diisi.';
                    ok = false;
                } else if (statusPegawai === 'asn' && idValue.length !== 18) {
                    setErr('grp-id');
                    document.getElementById('errID').innerText = 'NIP harus 18 digit.';
                    ok = false;
                } else if (statusPegawai === 'non-asn' && idValue.length !== 16) {
                    setErr('grp-id');
                    document.getElementById('errID').innerText = 'NIK harus 16 digit.';
                    ok = false;
                } else clearErr('grp-id');

                if (!jabatan) {
                    setErr('grp-jabatan');
                    ok = false;
                } else clearErr('grp-jabatan');
            }

            if (!ok) {
                DKA.toast({
                    type: 'danger',
                    title: 'Form Tidak Lengkap',
                    message: 'Harap perbaiki kesalahan pada formulir sebelum mengirim.',
                    position: 'top-right'
                });
                const firstErr = document.querySelector('.fgroup.has-err');
                if (firstErr) firstErr.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                return;
            }

            // Prep data
            const data = {
                _token: '{{ csrf_token() }}',
                unit_kerja_id: instansi,
                jabatan: jabatan,
                phone: hp,
                keterangan: catatan
            };

            if (statusPegawai === 'asn') data.nip = idValue;
            else data.nik = idValue;

            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Mengirim...';

            $.ajax({
                url: '{{ route('pending.activation.submit') }}',
                type: 'POST',
                data: data,
                success: function(res) {
                    if (res.success) {
                        DKA.toast({
                            type: 'success',
                            title: 'Berhasil',
                            message: res.message,
                            position: 'top-right'
                        });
                        document.getElementById('successOverlay').classList.add('show');
                    }
                },
                error: function(err) {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-send-check-fill"></i> Kirim Pengajuan Aktivasi';

                    const msg = err.responseJSON?.message || 'Terjadi kesalahan sistem. Silakan coba lagi.';
                    DKA.toast({
                        type: 'error',
                        title: 'Gagal Mengirim',
                        message: msg,
                        position: 'top-right'
                    });
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/dka-alert.js') }}"></script>

</body>

</html>
