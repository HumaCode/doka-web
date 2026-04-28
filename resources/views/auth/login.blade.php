<x-guest-layout>
    @push('js')
        <script>
            $(document).ready(function() {
                const $loginForm = $('#loginForm');
                const $btnLogin = $('#btnLogin');
                const $errorContainer = $('#errorContainer');

                $loginForm.on('submit', function(e) {
                    e.preventDefault();

                    // Reset state
                    $errorContainer.fadeOut().empty();
                    $('.form-ctrl').removeClass('is-error');
                    $('.invalid-feedback').remove();

                    $btnLogin.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm"></span> Memverifikasi...');

                    $.ajax({
                        url: $loginForm.attr('action'),
                        method: 'POST',
                        data: $loginForm.serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                const loader = DKA.loading({
                                    title: 'Memproses...',
                                    message: 'Sistem sedang bekerja.',
                                    style: 'dots'
                                });
                                setTimeout(() => {
                                    loader.close();
                                    DKA.toast({
                                        type: 'success',
                                        title: 'Berhasil!',
                                        message: response.message,
                                        position: 'bottom-right'
                                    });
                                    setTimeout(() => {
                                        window.location.href = response.redirect;
                                    }, 1000);
                                }, 1500);
                            }
                        },
                        error: function(xhr) {
                            $btnLogin.prop('disabled', false).html(
                                '<i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem');

                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                let errorHtml =
                                    '<div class="alert-auth alert-danger-auth"><i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i><div>';

                                $.each(errors, function(key, messages) {
                                    // Highlight input
                                    const $input = $(`#${key}`);
                                    $input.addClass('is-error');
                                    $input.closest('.field-wrap').after(
                                        `<div class="invalid-feedback" style="margin-top:-14px; margin-bottom:18px;">${messages[0]}</div>`
                                    );

                                    // Build alert html
                                    errorHtml += `<div>${messages[0]}</div>`;
                                });

                                errorHtml += '</div></div>';
                                $errorContainer.html(errorHtml).fadeIn();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'
                                });
                            }
                        }
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

                {{-- Username --}}
                <label class="form-label" for="username">Username</label>
                <div class="field-wrap">
                    <i class="bi bi-person-badge-fill input-icon"></i>
                    <input type="text" id="username" name="username" class="form-ctrl" value="{{ old('username') }}"
                        placeholder="Masukkan username" autocomplete="username" required autofocus />
                </div>

                {{-- Password --}}
                <label class="form-label" for="password">Password</label>
                <div class="field-wrap">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" id="password" name="password" class="form-ctrl"
                        placeholder="Masukkan password" autocomplete="current-password" style="padding-right:42px;"
                        required />
                    <button type="button" class="toggle-pw" data-target="password" data-icon="pwEyeIcon"
                        aria-label="Toggle password">
                        <i class="bi bi-eye-fill" id="pwEyeIcon"></i>
                    </button>
                </div>

                {{-- Remember & Forgot --}}
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                    <label class="check-wrap" for="remember">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} />
                        <span class="check-box"><i class="bi bi-check2"></i></span>
                        <span class="check-label">Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            style="color:var(--c-primary);font-weight:600;font-size:.875rem;text-decoration:none;">
                            Lupa password?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-auth btn-indigo mt-3" id="btnLogin">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
                </button>

                {{-- Divider --}}
                <div class="auth-divider">atau masuk dengan</div>

                {{-- Social login --}}
                <div class="d-grid">
                    <a href="{{ route('auth.google') }}" class="btn-social"
                        style="text-decoration:none; justify-content:center;">
                        <i class="bi bi-google" style="color:#ea4335;"></i> Masuk dengan menggunakan Email Google
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
