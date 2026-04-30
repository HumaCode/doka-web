<x-guest-layout>
    @push('js')
        <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
        <script>
            $(document).ready(function() {
                const $loginForm = $('#loginForm');
                const $btnLogin = $('#btnLogin');
                const $errorContainer = $('#errorContainer');

                $loginForm.on('submit', function(e) {
                    e.preventDefault();

                    // If we are in OTP mode, this form submit shouldn't happen via regular button
                    if ($('#otpSection').is(':visible')) return;

                    // Reset state
                    $errorContainer.fadeOut().empty();
                    $('.form-ctrl').removeClass('is-error');
                    $('.invalid-feedback').remove();

                    $btnLogin.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm"></span> Memverifikasi...');

                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {action: 'login'}).then(function(token) {
                            // Prepare data
                            let formData = $loginForm.serializeArray();
                            formData.push({name: 'username', value: $('#login_identifier').val()});
                            formData.push({name: 'g_recaptcha_response', value: token});

                            $.ajax({
                                url: $loginForm.attr('action'),
                                method: 'POST',
                                data: formData,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.success) {
                                        window.location.href = response.redirect;
                                    }
                                },
                                error: function(xhr) {
                                    $btnLogin.prop('disabled', false).html(
                                        '<i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem');

                                    if (xhr.status === 422) {
                                        let errors = xhr.responseJSON.errors;
                                        let errorHtml = '<div class="alert-auth alert-danger-auth"><i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i><div>';
                                        $.each(errors, function(key, messages) {
                                            errorHtml += `<div>${messages[0]}</div>`;
                                        });
                                        errorHtml += '</div></div>';
                                        $errorContainer.html(errorHtml).fadeIn();
                                    }
                                }
                            });
                        });
                    });
                });

                /* ======================================================
                   OTP LOGIC
                   ====================================================== */
                let timerInterval;

                function startTimer(duration) {
                    clearInterval(timerInterval);
                    let timer = duration, minutes, seconds;
                    $('#timerContainer').show();
                    $('#resendContainer').hide();
                    
                    timerInterval = setInterval(function () {
                        minutes = parseInt(timer / 60, 10);
                        seconds = parseInt(timer % 60, 10);

                        minutes = minutes < 10 ? "0" + minutes : minutes;
                        seconds = seconds < 10 ? "0" + seconds : seconds;

                        $('#timer').text(minutes + ":" + seconds);

                        if (--timer < 0) {
                            clearInterval(timerInterval);
                            $('#timerContainer').hide();
                            $('#resendContainer').fadeIn();
                        }
                    }, 1000);
                }

                $('#btnSwitchOtp').on('click', function() {
                    $('#passwordField, #passwordSubmit, #loginExtras, #btnSwitchOtp').hide();
                    $('#otpInitSubmit, #btnSwitchPassword').fadeIn();
                    $('#login_identifier').attr('placeholder', 'Masukkan alamat email').attr('type', 'email');
                    $('.form-label[for="login_identifier"]').text('Alamat Email');
                });

                $('#btnSwitchPassword').on('click', function() {
                    $('#otpStep, #otpInitSubmit, #btnSwitchPassword').hide();
                    $('#emailStep, #passwordField, #passwordSubmit, #loginExtras, #btnSwitchOtp').fadeIn();
                    $('#login_identifier').attr('placeholder', 'Masukkan email atau username').attr('type', 'text');
                    $('.form-label[for="login_identifier"]').text('Email atau Username');
                });

                $('#btnBackToEmail').on('click', function() {
                    $('#otpStep').hide();
                    $('#emailStep').fadeIn();
                });

                $('#btnSendOtp').on('click', function() {
                    sendOtpRequest();
                });

                $('#resendOtp').on('click', function() {
                    sendOtpRequest();
                });

                function sendOtpRequest() {
                    const email = $('#login_identifier').val();
                    if (!email || !email.includes('@')) {
                        DKA.toast({ type: 'error', title: 'Error', message: 'Silakan masukkan email yang valid.' });
                        return;
                    }

                    const $btn = $('#btnSendOtp');
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Mengirim...');

                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {action: 'send_otp'}).then(function(token) {
                            $.ajax({
                                url: "{{ route('auth.otp.send') }}",
                                method: 'POST',
                                data: { 
                                    _token: "{{ csrf_token() }}", 
                                    email: email,
                                    g_recaptcha_response: token
                                },
                                success: function(response) {
                                    DKA.toast({ type: 'success', title: 'Berhasil', message: response.message });
                                    $btn.prop('disabled', false).html('<i class="bi bi-send-fill"></i> Kirim Kode OTP');
                                    
                                    // Switch to OTP step
                                    $('#displayEmail').text(email);
                                    $('#emailStep').hide();
                                    $('#otpStep').fadeIn();
                                    
                                    // Reset & Focus OTP inputs
                                    $('.otp-input').val('');
                                    $('.otp-input').first().focus();
                                    
                                    // Start Timer
                                    startTimer(180); // 3 minutes
                                },
                                error: function(xhr) {
                                    $btn.prop('disabled', false).html('<i class="bi bi-send-fill"></i> Kirim Kode OTP');
                                    DKA.toast({ type: 'error', title: 'Gagal', message: xhr.responseJSON.message || 'Gagal mengirim OTP.' });
                                }
                            });
                        });
                    });
                }

                // Handle OTP Input Focus
                $('.otp-input').on('keyup', function(e) {
                    const $this = $(this);
                    if ($this.val().length === 1) {
                        $this.next('.otp-input').focus();
                    }
                    if (e.keyCode === 8) { // backspace
                        $this.prev('.otp-input').focus();
                    }
                });

                $('#btnVerifyOtp').on('click', function() {
                    const email = $('#login_identifier').val();
                    let otp = '';
                    $('.otp-input').each(function() {
                        otp += $(this).val();
                    });

                    if (otp.length < 6) {
                        DKA.toast({ type: 'error', title: 'Error', message: 'Silakan masukkan 6 digit kode OTP.' });
                        return;
                    }

                    const $btn = $(this);
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Memverifikasi...');

                    grecaptcha.ready(function() {
                        grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {action: 'verify_otp'}).then(function(token) {
                            $.ajax({
                                url: "{{ route('auth.otp.verify') }}",
                                method: 'POST',
                                data: { 
                                    _token: "{{ csrf_token() }}", 
                                    email: email, 
                                    otp: otp,
                                    g_recaptcha_response: token
                                },
                                success: function(response) {
                                    if (response.success) {
                                        DKA.toast({ type: 'success', title: 'Berhasil', message: response.message });
                                        setTimeout(() => window.location.href = response.redirect, 1000);
                                    }
                                },
                                error: function(xhr) {
                                    $btn.prop('disabled', false).html('<i class="bi bi-check2-circle"></i> Verifikasi & Masuk');
                                    DKA.toast({ type: 'error', title: 'Gagal', message: xhr.responseJSON.message || 'Kode OTP salah.' });
                                }
                            });
                        });
                    });
                });
            });

            /* Custom checkbox logic */
            document.querySelectorAll('.check-wrap').forEach(wrap => {
                const cb = wrap.querySelector('input[type=checkbox]');
                const box = wrap.querySelector('.check-box');
                const lbl = wrap.querySelector('.check-label');
                [box, lbl].forEach(el => el.addEventListener('click', () => {
                    cb.checked = !cb.checked;
                }));
            });
        </script>
    @endpush

    @section('title', 'Login')

    @section('bg-style')
        background:
        radial-gradient(ellipse 80% 60% at 10% 20%, #c7d2fe 0%, transparent 60%),
        radial-gradient(ellipse 70% 60% at 90% 80%, #a5f3fc 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 50% 50%, #fbcfe8 0%, transparent 70%),
        linear-gradient(135deg, #e0e7ff 0%, #cffafe 50%, #fce7f3 100%);
    @endsection

    @push('css')
        <style>
            .otp-container {
                display: flex;
                gap: 10px;
                justify-content: center;
                margin: 20px 0;
            }
            .otp-input {
                width: 45px;
                height: 55px;
                text-align: center;
                font-size: 1.5rem;
                font-weight: 800;
                border: 2px solid var(--c-border);
                border-radius: 12px;
                background: #f8fafc;
                color: var(--c-primary);
                transition: all 0.3s ease;
            }
            .otp-input:focus {
                border-color: var(--c-primary);
                background: #fff;
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
                outline: none;
            }
            .timer-text {
                font-size: 0.875rem;
                color: var(--c-muted);
                text-align: center;
                margin-top: 10px;
            }
            .timer-text span {
                color: var(--c-primary);
                font-weight: 700;
            }
            .btn-resend {
                color: var(--c-primary);
                font-weight: 700;
                text-decoration: none;
                font-size: 0.875rem;
                transition: all 0.2s;
            }
            .btn-resend:hover {
                text-decoration: underline;
                opacity: 0.8;
            }
            .btn-resend.disabled {
                color: #cbd5e1;
                pointer-events: none;
                text-decoration: none;
            }
        </style>
    @endpush


    <div class="auth-card"
        style="max-width:960px;grid-template-columns:1fr 1fr;box-shadow:0 24px 64px rgba(79,70,229,.18),0 4px 16px rgba(6,182,212,.10);">

        {{-- ══ LEFT: Brand Panel ══ --}}
        <div class="brand-panel"
            style="background:linear-gradient(145deg,#4f46e5 0%,#7c3aed 50%,#ec4899 100%);padding:56px 40px;">
            <div class="brand-deco bd1"></div>
            <div class="brand-deco bd2"></div>
            <div class="brand-deco bd3"></div>

            <div>
                <a href="{{ url('/') }}" class="brand-logo">
                    <div class="logo-icon-wrap"><i class="bi bi-camera-reels-fill"></i></div>
                    <div>
                        <div class="brand-name">Doka<span>Kegiatan</span></div>
                        <div class="brand-sub">DOKUMENTASI KEGIATAN</div>
                    </div>
                </a>
                <div class="brand-tagline">
                    <h2>Catat Setiap<br />Momen Berharga</h2>
                    <p>Platform dokumentasi kegiatan modern — upload foto, tambahkan uraian, dan simpan kenangan dengan
                        102: mudah.</p>
                </div>
            </div>

            <div class="feature-pills brand-side-extras">
                <div class="feature-pill"><i class="bi bi-images"></i><span>Upload foto lebih dari 1 per kegiatan</span>
                </div>
                <div class="feature-pill"><i class="bi bi-calendar3"></i><span>Dokumentasi per hari &amp; tanggal</span>
                </div>
                <div class="feature-pill"><i class="bi bi-phone"></i><span>Responsif di semua perangkat</span></div>
                <div class="feature-pill"><i class="bi bi-shield-check"></i><span>Aman &amp; terenkripsi</span></div>
            </div>
        </div>

        {{-- ══ RIGHT: Form Panel ══ --}}
        <div class="form-panel" style="justify-content:center;">

            {{-- Icon ring --}}
            <div class="icon-ring"
                style="background:linear-gradient(135deg,#4f46e5,#06b6d4);box-shadow:0 8px 24px rgba(79,70,229,.35);">
                <i class="bi bi-person-fill"></i>
            </div>

            <div class="form-heading">
                <h1>Selamat Datang 👋</h1>
                <p>Masuk ke akun Anda untuk mulai mendokumentasikan kegiatan</p>
            </div>

            {{-- AJAX Error Container --}}
            <div id="errorContainer" style="display: none;"></div>

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                {{-- STEP 1: Email / Username Input --}}
                <div id="emailStep">
                    <label class="form-label" for="login_identifier">Email atau Username</label>
                    <div class="field-wrap" id="wrap-email">
                        <i class="bi bi-person-badge-fill input-icon"></i>
                        <input type="text" id="login_identifier" name="login_identifier" class="form-ctrl" value="{{ old('username') }}"
                            placeholder="Masukkan email atau username" required autofocus />
                    </div>

                    {{-- Password Input (Optional inside Step 1) --}}
                    <div id="passwordField">
                        <label class="form-label" for="password">Password</label>
                        <div class="field-wrap">
                            <i class="bi bi-lock-fill input-icon"></i>
                            <input type="password" id="password" name="password" class="form-ctrl"
                                placeholder="Masukkan password" autocomplete="current-password" style="padding-right:42px;"
                                required />
                            <button type="button" class="toggle-pw" data-target="password" data-icon="pwEyeIcon">
                                <i class="bi bi-eye-fill" id="pwEyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2" id="loginExtras">
                        <label class="check-wrap" for="remember">
                            <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} />
                            <span class="check-box"><i class="bi bi-check2"></i></span>
                            <span class="check-label">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="color:var(--c-primary);font-weight:600;font-size:.875rem;text-decoration:none;">Lupa password?</a>
                        @endif
                    </div>

                    <div id="passwordSubmit">
                        <button type="submit" class="btn-auth btn-indigo mt-3" id="btnLogin">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                        </button>
                    </div>

                    <div id="otpInitSubmit" style="display: none;">
                        <button type="button" class="btn-auth btn-indigo mt-3" id="btnSendOtp">
                            <i class="bi bi-send-fill"></i> Kirim Kode OTP
                        </button>
                    </div>
                </div>

                {{-- STEP 2: OTP Boxes --}}
                <div id="otpStep" style="display: none;">
                    <div class="text-center mb-4">
                        <div style="font-size: 0.9rem; color: var(--c-muted);">Kode verifikasi telah dikirim ke:</div>
                        <div id="displayEmail" style="font-weight: 700; color: var(--c-text);">email@anda.com</div>
                    </div>

                    <div class="otp-container">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                        <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric">
                    </div>

                    <div class="timer-text" id="timerContainer">
                        Berlaku dalam <span><strong id="timer">03:00</strong></span>
                    </div>

                    <div class="text-center mt-3" id="resendContainer" style="display: none;">
                        <span style="font-size: 0.875rem; color: var(--c-muted);">Tidak menerima kode?</span>
                        <a href="javascript:void(0)" id="resendOtp" class="btn-resend">Kirim Ulang</a>
                    </div>

                    <button type="button" class="btn-auth btn-indigo mt-4" id="btnVerifyOtp">
                        <i class="bi bi-check2-circle"></i> Verifikasi & Masuk
                    </button>

                    <button type="button" class="btn-link mt-2" id="btnBackToEmail" style="width:100%; border:none; background:none; font-size:0.875rem; color:var(--c-muted);">
                        Ganti Email
                    </button>
                </div>

                {{-- Divider --}}
                <div class="auth-divider">atau masuk dengan</div>

                <div class="d-grid gap-2">
                    <button type="button" class="btn-social" id="btnSwitchOtp" style="justify-content:center; background:#fff; border:2px solid var(--c-primary); color:var(--c-primary);">
                        <i class="bi bi-envelope-at-fill"></i> Masuk dengan Kode OTP (Email)
                    </button>
                    <button type="button" class="btn-social" id="btnSwitchPassword" style="display:none; justify-content:center; background:#fff; border:2px solid #64748b; color:#64748b;">
                        <i class="bi bi-key-fill"></i> Masuk dengan Password
                    </button>
                    <a href="{{ route('auth.google') }}" class="btn-social" style="text-decoration:none; justify-content:center;">
                        <i class="bi bi-google" style="color:#ea4335;"></i> Masuk dengan Email Google
                    </a>
                </div>
            </form>

            <div class="form-footer">
                @if (Route::has('register'))
                    Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                @else
                    Belum punya akun? <a href="#">Hubungi Administrator</a>
                @endif
            </div>
        </div>

    </div>
</x-guest-layout>
