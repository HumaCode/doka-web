<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'DokaKegiatan') — DokaKegiatan</title>

    {{-- Bootstrap 5.3.3 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    {{-- Bootstrap Icons 1.11.3 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Nunito:wght@400;600;700;900&display=swap"
        rel="stylesheet" />

    <style>
        /* ═══════════════════════════════════════════════
       GLOBAL AUTH VARIABLES & RESET
       ═══════════════════════════════════════════════ */
        :root {
            --c-primary: #4f46e5;
            --c-secondary: #06b6d4;
            --c-accent: #f59e0b;
            --c-pink: #ec4899;
            --c-green: #10b981;
            --c-orange: #f97316;
            --c-card: rgba(255, 255, 255, 0.84);
            --c-text: #1e1b4b;
            --c-muted: #6b7280;
            --c-border: #e5e7eb;
            --radius: 20px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            min-height: 100%;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--c-text);
        }

        /* ═══════════════════════════════════════════════
       PARTICLE CANVAS
       ═══════════════════════════════════════════════ */
        #particle-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
        }

        /* ═══════════════════════════════════════════════
       BG MESH — overridden per-page via @yield('bg')

        ═══════════════════════════════════════════════ */ .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            animation: meshShift 13s ease-in-out infinite alternate;
        }

        @keyframes meshShift {
            0% {
                filter: hue-rotate(0deg) brightness(1.00);
            }

            50% {
                filter: hue-rotate(12deg) brightness(1.03);
            }

            100% {
                filter: hue-rotate(-8deg) brightness(1.01);
            }
        }

        /* ═══════════════════════════════════════════════
       PAGE WRAPPER
       ═══════════════════════════════════════════════ */
        .auth-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px 40px;
            overflow-y: auto;
        }

        /* ═══════════════════════════════════════════════
       CARD SHARED
       ═══════════════════════════════════════════════ */
        .auth-card {
            width: 100%;
            background: var(--c-card);
            backdrop-filter: blur(28px) saturate(180%);
            -webkit-backdrop-filter: blur(28px) saturate(180%);
            border-radius: var(--radius);
            border: 1px solid rgba(255, 255, 255, .75);
            display: grid;
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

        /* ═══════════════════════════════════════════════
       BRAND PANEL (LEFT)
       ═══════════════════════════════════════════════ */
        .brand-panel {
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, .12) 0%, transparent 50%),
                radial-gradient(circle at 85% 15%, rgba(255, 255, 255, .09) 0%, transparent 40%);
        }

        .brand-deco {
            position: absolute;
            border-radius: 50%;
            opacity: .18;
            animation: floatDeco 7s ease-in-out infinite alternate;
        }

        @keyframes floatDeco {
            from {
                transform: translate(0, 0) scale(1);
            }

            to {
                transform: translate(6px, -14px) scale(1.06);
            }
        }

        .bd1 {
            width: 200px;
            height: 200px;
            background: #fff;
            top: -70px;
            right: -70px;
            animation-delay: 0s;
        }

        .bd2 {
            width: 130px;
            height: 130px;
            background: var(--c-accent);
            bottom: 80px;
            left: -45px;
            animation-delay: 2s;
        }

        .bd3 {
            width: 88px;
            height: 88px;
            background: var(--c-pink);
            bottom: -35px;
            right: 48px;
            animation-delay: 4s;
        }

        .bd4 {
            width: 56px;
            height: 56px;
            background: var(--c-secondary);
            top: 42%;
            left: 58%;
            animation-delay: 1.2s;
        }

        /* Logo */
        .brand-logo {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon-wrap {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, .22);
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 26px;
            color: #fff;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .35);
            animation: logoRock 8s ease-in-out infinite;
        }

        @keyframes logoRock {

            0%,
            100% {
                transform: rotate(0deg) scale(1);
            }

            25% {
                transform: rotate(6deg) scale(1.06);
            }

            75% {
                transform: rotate(-6deg) scale(1.06);
            }
        }

        .brand-name {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.5rem;
            color: #fff;
            letter-spacing: -.5px;
            line-height: 1;
        }

        .brand-name span {
            color: #fde68a;
        }

        .brand-sub {
            color: rgba(255, 255, 255, .6);
            font-size: .72rem;
            margin-top: 2px;
            letter-spacing: .5px;
        }

        /* Tagline */
        .brand-tagline {
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, .95);
            margin-top: 32px;
        }

        .brand-tagline h2 {
            font-size: clamp(1.3rem, 2.5vw, 1.9rem);
            font-weight: 800;
            line-height: 1.3;
            margin-bottom: 10px;
        }

        .brand-tagline p {
            font-size: .9rem;
            opacity: .82;
            line-height: 1.65;
        }

        /* ═══════════════════════════════════════════════
       FORM PANEL (RIGHT)
       ═══════════════════════════════════════════════ */
        .form-panel {
            padding: 48px 48px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Progress bar */
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
            background: linear-gradient(90deg, var(--c-accent), var(--c-orange));
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

        /* Icon ring */
        .icon-ring {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            margin-bottom: 18px;
            animation: iconPulse 3s ease-in-out infinite;
            position: relative;
            transition: background .5s, box-shadow .5s;
        }

        .icon-ring::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: 50%;
            border: 2px dashed rgba(79, 70, 229, .3);
            animation: iconRingSpin 9s linear infinite;
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        @keyframes iconRingSpin {
            to {
                transform: rotate(360deg);
            }
        }

        .icon-ring i {
            font-size: 2rem;
            color: #fff;
        }

        /* Heading */
        .form-heading {
            margin-bottom: 28px;
        }

        .form-heading h1 {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: clamp(1.4rem, 2.5vw, 1.9rem);
            color: var(--c-text);
            margin-bottom: 6px;
        }

        .form-heading p {
            color: var(--c-muted);
            font-size: .875rem;
            line-height: 1.6;
        }

        /* Form label */
        .form-label {
            font-weight: 600;
            font-size: .875rem;
            color: var(--c-text);
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .req {
            color: var(--c-pink);
            font-size: 1rem;
            line-height: 1;
        }

        /* Field wrap */
        .field-wrap {
            position: relative;
            margin-bottom: 18px;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.05rem;
            z-index: 2;
            pointer-events: none;
            transition: color .25s;
        }

        .field-wrap:focus-within .input-icon {
            color: var(--c-primary);
        }

        .form-ctrl {
            width: 100%;
            padding: 13px 14px 13px 43px;
            border: 2px solid var(--c-border);
            border-radius: 12px;
            font-size: .9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: rgba(255, 255, 255, .92);
            color: var(--c-text);
            transition: border-color .25s, box-shadow .25s;
            outline: none;
        }

        .form-ctrl:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, .1);
            background: #fff;
        }

        .form-ctrl.is-error {
            border-color: #f87171;
            box-shadow: 0 0 0 4px rgba(248, 113, 113, .1);
        }

        .form-ctrl.is-valid {
            border-color: var(--c-green);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, .1);
        }

        .form-ctrl.no-icon {
            padding-left: 14px;
        }

        /* Laravel validation error styling */
        .form-ctrl.@error('*')
            is-invalid
        @enderror
            {
            border-color: #f87171;
        }

        {{-- placeholder, handled per-field --}} .invalid-feedback {
            display: block;
            font-size: .75rem;
            color: #ef4444;
            margin-top: 5px;
        }

        /* Toggle password */
        .toggle-pw {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--c-muted);
            font-size: 1rem;
            padding: 4px;
            z-index: 2;
            transition: color .2s;
        }

        .toggle-pw:hover {
            color: var(--c-primary);
        }

        /* Custom checkbox */
        .check-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .check-wrap input[type="checkbox"] {
            display: none;
        }

        .check-box {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            border: 2px solid var(--c-border);
            border-radius: 6px;
            display: grid;
            place-items: center;
            transition: background .2s, border-color .2s;
        }

        .check-box i {
            font-size: .75rem;
            color: #fff;
            display: none;
        }

        .check-wrap input:checked~.check-box {
            background: var(--c-primary);
            border-color: var(--c-primary);
        }

        .check-wrap input:checked~.check-box i {
            display: block;
        }

        .check-label {
            font-size: .875rem;
            color: var(--c-muted);
        }

        /* Alert */
        .alert-auth {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: .875rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
        }

        .alert-danger-auth {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success-auth {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }

        .alert-info-auth {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: .875rem;
            font-weight: 700;
            color: var(--c-muted);
            text-decoration: none;
            margin-bottom: 24px;
            transition: color .2s, transform .2s;
        }

        .back-link:hover {
            color: var(--c-primary);
            transform: translateX(-3px);
        }

        /* Footer */
        .form-footer {
            text-align: center;
            margin-top: 22px;
            font-size: .85rem;
            color: var(--c-muted);
        }

        .form-footer a {
            color: var(--c-primary);
            font-weight: 700;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Divider */
        .auth-divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 20px 0;
            color: var(--c-muted);
            font-size: .78rem;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--c-border);
        }

        /* Hint text */
        .field-hint {
            font-size: .75rem;
            color: var(--c-muted);
            margin-top: 5px;
        }

        /* ═══════════════════════════════════════════════
       BUTTONS
       ═══════════════════════════════════════════════ */
        .btn-auth {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 12px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            color: #fff;
            background-size: 200% 100%;
            cursor: pointer;
            transition: background-position .4s, transform .2s, box-shadow .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-auth:hover {
            background-position: right center;
            transform: translateY(-2px);
        }

        .btn-auth:active {
            transform: translateY(0);
        }

        .btn-auth:disabled {
            opacity: .6;
            cursor: not-allowed;
            transform: none;
        }

        /* Colour variants */
        .btn-indigo {
            background: linear-gradient(135deg, var(--c-primary) 0%, #7c3aed 55%, var(--c-pink) 100%);
            box-shadow: 0 6px 20px rgba(79, 70, 229, .4);
        }

        .btn-green {
            background: linear-gradient(135deg, var(--c-green) 0%, var(--c-secondary) 55%, var(--c-primary) 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, .35);
        }

        .btn-orange {
            background: linear-gradient(135deg, var(--c-accent) 0%, var(--c-orange) 50%, #ef4444 100%);
            box-shadow: 0 6px 20px rgba(249, 115, 22, .38);
        }

        .btn-outline-auth {
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

        .btn-outline-auth:hover {
            border-color: var(--c-primary);
            background: #f5f3ff;
            transform: translateY(-2px);
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

        /* Social login buttons */
        .btn-social {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px;
            border: 1.5px solid var(--c-border);
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            font-size: .875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            color: var(--c-text);
            transition: border-color .2s, background .2s, transform .2s;
        }

        .btn-social:hover {
            border-color: var(--c-primary);
            background: #f5f3ff;
            transform: translateY(-2px);
        }

        .btn-social i {
            font-size: 1.1rem;
        }

        /* ═══════════════════════════════════════════════
       STEP PANELS (for multi-step forms)
       ═══════════════════════════════════════════════ */
        .step-panel {
            display: none;
            animation: stepIn .4s cubic-bezier(.22, 1, .36, 1) both;
        }

        .step-panel.active {
            display: block;
        }

        @keyframes stepIn {
            from {
                opacity: 0;
                transform: translateX(16px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Side step track */
        .step-track {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            padding: 13px 0;
            position: relative;
        }

        .step-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 17px;
            top: 44px;
            width: 2px;
            height: calc(100% - 18px);
            background: rgba(255, 255, 255, .22);
        }

        .step-num {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            flex-shrink: 0;
            background: rgba(255, 255, 255, .2);
            border: 2px solid rgba(255, 255, 255, .45);
            display: grid;
            place-items: center;
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: .88rem;
            color: #fff;
            backdrop-filter: blur(6px);
            transition: background .3s;
        }

        .step-num.active {
            background: rgba(255, 255, 255, .38);
            border-color: rgba(255, 255, 255, .85);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, .15);
        }

        .step-num.done {
            background: rgba(255, 255, 255, .65);
            border-color: #fff;
        }

        .step-num.done i {
            font-size: .8rem;
            color: #059669;
        }

        .step-text strong {
            display: block;
            font-size: .87rem;
            color: #fff;
            font-weight: 700;
            margin-bottom: 1px;
        }

        .step-text span {
            font-size: .77rem;
            color: rgba(255, 255, 255, .65);
        }

        /* Feature pills */
        .feature-pills {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .feature-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 12px;
            padding: 10px 16px;
            color: #fff;
            backdrop-filter: blur(8px);
            font-size: .875rem;
            font-weight: 600;
            transition: transform .3s, background .3s;
        }

        .feature-pill:hover {
            background: rgba(255, 255, 255, .25);
            transform: translateX(4px);
        }

        .feature-pill i {
            font-size: 1.2rem;
            color: #fde68a;
        }

        /* Info box */
        .info-box {
            background: linear-gradient(135deg, rgba(245, 158, 11, .08), rgba(249, 115, 22, .06));
            border: 1.5px solid rgba(245, 158, 11, .25);
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .info-box-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--c-accent), var(--c-orange));
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 1.1rem;
        }

        .info-box-text strong {
            display: block;
            font-size: .9rem;
            font-weight: 700;
            color: var(--c-text);
            margin-bottom: 3px;
        }

        .info-box-text span {
            font-size: .8rem;
            color: var(--c-muted);
            line-height: 1.55;
        }

        .email-highlight {
            color: var(--c-orange);
            font-weight: 700;
        }

        /* OTP boxes */
        .otp-row {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 8px 0 6px;
        }

        .otp-box {
            width: 52px;
            height: 62px;
            border-radius: 12px;
            border: 2px solid var(--c-border);
            text-align: center;
            font-size: 1.6rem;
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            color: var(--c-text);
            background: rgba(255, 255, 255, .9);
            outline: none;
            transition: border-color .25s, box-shadow .25s, transform .15s;
            caret-color: var(--c-orange);
        }

        .otp-box:focus {
            border-color: var(--c-orange);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, .15);
            transform: scale(1.08);
        }

        .otp-box.filled {
            border-color: var(--c-green);
            background: #f0fdf4;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, .12);
        }

        .otp-box.error {
            border-color: #f87171;
            background: #fef2f2;
            animation: shake .35s ease;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-5px);
            }

            40%,
            80% {
                transform: translateX(5px);
            }
        }

        .otp-separator {
            display: flex;
            align-items: center;
            color: var(--c-muted);
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Countdown */
        .countdown-wrap {
            text-align: center;
            margin-top: 14px;
            font-size: .85rem;
            color: var(--c-muted);
        }

        .countdown-num {
            font-weight: 800;
            color: var(--c-orange);
            font-family: 'Nunito', sans-serif;
        }

        .resend-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--c-primary);
            font-weight: 700;
            font-size: .85rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 0;
            text-decoration: underline;
            transition: color .2s;
            display: none;
        }

        .resend-btn:hover {
            color: #7c3aed;
        }

        /* Password strength */
        .pw-strength-wrap {
            margin-top: 8px;
        }

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

        .pw-strength-label {
            font-size: .75rem;
            font-weight: 600;
            color: var(--c-muted);
        }

        /* Password rules checklist */
        .pw-rules {
            margin-top: 12px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .pw-rule {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: .78rem;
            color: var(--c-muted);
        }

        .pw-rule i {
            font-size: .85rem;
            color: var(--c-border);
            transition: color .25s;
        }

        .pw-rule.ok i {
            color: var(--c-green);
        }

        .pw-rule.ok {
            color: var(--c-green);
        }

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

        .avatar-upload-zone input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }

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

        .avatar-label {
            font-size: .875rem;
            font-weight: 600;
            color: var(--c-text);
        }

        .avatar-sub {
            font-size: .75rem;
            color: var(--c-muted);
            margin-top: 3px;
        }

        /* Field section label */
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

        /* Terms box */
        .terms-wrap {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(79, 70, 229, .06), rgba(6, 182, 212, .04));
            border: 1px solid rgba(79, 70, 229, .12);
            margin-bottom: 20px;
        }

        .terms-text {
            font-size: .82rem;
            color: var(--c-muted);
            line-height: 1.6;
        }

        .terms-text a {
            color: var(--c-primary);
            font-weight: 600;
            text-decoration: none;
        }

        .terms-text a:hover {
            text-decoration: underline;
        }

        /* Success screen */
        .success-screen {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 32px 20px;
            animation: cardIn .6s cubic-bezier(.22, 1, .36, 1) both;
        }

        .success-screen.show {
            display: flex;
        }

        .success-icon-wrap {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--c-green), var(--c-secondary));
            display: grid;
            place-items: center;
            margin-bottom: 24px;
            box-shadow: 0 12px 36px rgba(16, 185, 129, .4);
            animation: successPop .6s cubic-bezier(.34, 1.56, .64, 1) both;
        }

        @keyframes successPop {
            from {
                transform: scale(0);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-icon-wrap i {
            font-size: 3rem;
            color: #fff;
        }

        .success-screen h2 {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: var(--c-text);
        }

        .success-screen p {
            color: var(--c-muted);
            font-size: .92rem;
            line-height: 1.65;
            max-width: 300px;
        }

        /* ═══════════════════════════════════════════════
       RESPONSIVE
       ═══════════════════════════════════════════════ */
        @media (max-width: 860px) {
            .auth-card {
                grid-template-columns: 1fr !important;
            }

            .brand-panel {
                padding: 30px 26px;
            }

            .brand-side-extras {
                display: none;
            }

            .brand-tagline h2 {
                font-size: 1.25rem;
            }

            .form-panel {
                padding: 32px 24px;
            }
        }

        @media (max-width: 480px) {
            .auth-page {
                padding: 14px 10px 32px;
            }

            .form-panel {
                padding: 26px 16px;
            }

            .brand-panel {
                padding: 24px 16px;
            }

            .otp-box {
                width: 44px;
                height: 54px;
                font-size: 1.3rem;
            }
        }

        @media (max-width: 360px) {
            .otp-box {
                width: 38px;
                height: 48px;
                font-size: 1.1rem;
            }

            .otp-row {
                gap: 5px;
            }
        }
    </style>

    @stack('css')
</head>

<body>

    {{-- Animated background --}}
    <div class="bg-mesh" style="@yield('bg-style')"></div>
    <canvas id="particle-canvas"></canvas>

    <div class="auth-page">
        {{ $slot }}
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Shared particle engine --}}
    {{-- jQuery 3.7.1 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function() {
            const canvas = document.getElementById('particle-canvas');
            const ctx = canvas.getContext('2d');
            let W, H, particles = [];

            const EMOJIS = ['📷', '📸', '🎞', '🖼', '📅', '✨', '⭐', '💫', '🌟'];
            const COLORS = ['#4f46e5', '#06b6d4', '#ec4899', '#f59e0b', '#10b981', '#7c3aed'];
            const COUNT = Math.min(42, Math.floor(window.innerWidth / 27));

            function resize() {
                W = canvas.width = window.innerWidth;
                H = canvas.height = window.innerHeight;
            }

            function rnd(a, b) {
                return a + Math.random() * (b - a);
            }

            function make() {
                const e = Math.random() > .53;
                return {
                    x: rnd(0, W),
                    y: rnd(0, H),
                    vx: rnd(-.3, .3),
                    vy: rnd(-.5, -.1),
                    size: rnd(e ? 13 : 4, e ? 24 : 9),
                    alpha: rnd(.07, .22),
                    color: COLORS[Math.floor(Math.random() * COLORS.length)],
                    emoji: e ? EMOJIS[Math.floor(Math.random() * EMOJIS.length)] : null,
                    rotate: rnd(0, Math.PI * 2),
                    rotV: rnd(-.012, .012),
                    pulse: rnd(0, Math.PI * 2),
                    pulseV: rnd(.01, .04),
                };
            }

            function init() {
                resize();
                particles = Array.from({
                    length: COUNT
                }, make);
            }

            function draw() {
                ctx.clearRect(0, 0, W, H);
                for (const p of particles) {
                    ctx.save();
                    ctx.globalAlpha = p.alpha + .05 * Math.sin(p.pulse);
                    ctx.translate(p.x, p.y);
                    ctx.rotate(p.rotate);
                    if (p.emoji) {
                        ctx.font = `${p.size}px serif`;
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        ctx.fillText(p.emoji, 0, 0);
                    } else {
                        ctx.beginPath();
                        ctx.arc(0, 0, p.size / 2, 0, Math.PI * 2);
                        ctx.fillStyle = p.color;
                        ctx.fill();
                    }
                    ctx.restore();
                    p.x += p.vx;
                    p.y += p.vy;
                    p.rotate += p.rotV;
                    p.pulse += p.pulseV;
                    if (p.y < -50) p.y = H + 50;
                    if (p.x < -50) p.x = W + 50;
                    if (p.x > W + 50) p.x = -50;
                }
                requestAnimationFrame(draw);
            }
            window.addEventListener('resize', resize);
            init();
            draw();
        })();

        /* Shared toggle-password */
        document.querySelectorAll('.toggle-pw').forEach(btn => {
            btn.addEventListener('click', () => {
                const inp = document.getElementById(btn.dataset.target);
                const icon = document.getElementById(btn.dataset.icon);
                const show = inp.type === 'password';
                inp.type = show ? 'text' : 'password';
                icon.className = show ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill';
            });
        });
    </script>

    @stack('js')
</body>

</html>
