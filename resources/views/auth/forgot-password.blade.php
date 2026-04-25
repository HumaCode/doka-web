<x-guest-layout>
    @section('title', 'Lupa Password')

    @section('bg-style')
    background:
        radial-gradient(ellipse 75% 55% at  8% 15%, #fef3c7 0%, transparent 55%),
        radial-gradient(ellipse 65% 55% at 92% 85%, #fed7aa 0%, transparent 55%),
        radial-gradient(ellipse 55% 50% at 50% 50%, #fce7f3 0%, transparent 65%),
        radial-gradient(ellipse 50% 40% at 78% 12%, #ddd6fe 0%, transparent 50%),
        linear-gradient(135deg, #fffbeb 0%, #fef3c7 40%, #fce7f3 100%);
    @endsection

    @section('particle-emojis', "['🔑','🔒','🔓','📧','✉️','💌','✨','⭐','💫','🌟']")
    @section('particle-colors',  "['#f59e0b','#f97316','#ef4444','#ec4899','#8b5cf6','#06b6d4']")

    <div class="auth-card" style="max-width:760px;grid-template-columns:300px 1fr;box-shadow:0 24px 64px rgba(245,158,11,.15),0 4px 20px rgba(249,115,22,.10);">

        {{-- ══ LEFT: Brand Panel ══ --}}
        <div class="brand-panel" style="background:linear-gradient(160deg,#f59e0b 0%,#f97316 40%,#ef4444 75%,#ec4899 100%);">
            <div class="brand-deco bd1"></div>
            <div class="brand-deco bd2" style="background:#fde68a;"></div>
            <div class="brand-deco bd3" style="background:#fbcfe8;"></div>
            <div class="brand-deco bd4" style="background:#4f46e5;"></div>

            <a href="{{ url('/') }}" class="brand-logo">
                <div class="logo-icon-wrap"><i class="bi bi-camera-reels-fill"></i></div>
                <div>
                    <div class="brand-name">Doka<span>Kegiatan</span></div>
                    <div class="brand-sub">DOKUMENTASI KEGIATAN</div>
                </div>
            </a>

            <div class="brand-tagline">
                <h2>Pulihkan Akses<br />ke Akun Anda 🔑</h2>
                <p>Jangan khawatir — masukkan email Anda dan kami akan mengirimkan tautan untuk mereset password.</p>
            </div>

            <div class="step-track brand-side-extras">
                <div class="step-item">
                    <div class="step-num active">1</div>
                    <div class="step-text"><strong>Masukkan Email</strong><span>Email terdaftar di akun</span></div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div class="step-text"><strong>Cek Inbox Email</strong><span>Klik tautan reset password</span></div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text"><strong>Buat Password Baru</strong><span>Password kuat &amp; aman</span></div>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: Form Panel ══ --}}
        <div class="form-panel" style="justify-content:center;">

            <a href="{{ route('login') }}" class="back-link">
                <i class="bi bi-arrow-left-circle-fill"></i> Kembali ke halaman login
            </a>

            <div class="icon-ring"
                style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 8px 24px rgba(249,115,22,.38);">
                <i class="bi bi-envelope-open-fill"></i>
            </div>

            <div class="form-heading">
                <h1>Lupa Password? 😓</h1>
                <p>Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk mereset password Anda.</p>
            </div>

            {{-- Session status (link sent) --}}
            @if (session('status'))
                <div class="alert-auth alert-success-auth">
                    <i class="bi bi-check-circle-fill flex-shrink-0 mt-1"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            {{-- Errors --}}
            @if ($errors->any())
                <div class="alert-auth alert-danger-auth">
                    <i class="bi bi-exclamation-circle-fill flex-shrink-0 mt-1"></i>
                    <div>
                        @foreach ($errors->all() as $err)
                            <div>{{ $err }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="fpForm" novalidate>
                @csrf

                <label class="form-label" for="email">Alamat Email <span class="req">*</span></label>
                <div class="field-wrap" id="wrap-email">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" id="email" name="email"
                        class="form-ctrl @error('email') is-error @enderror" value="{{ old('email') }}"
                        placeholder="nama@instansi.go.id" autocomplete="email" required autofocus />
                </div>
                <div class="field-hint" style="margin-top:-14px; margin-bottom:18px; font-size:.75rem; color:var(--c-muted);">Gunakan email yang terdaftar di akun DokaKegiatan Anda.</div>
                @error('email')
                    <div class="invalid-feedback" style="margin-top:-14px; margin-bottom:18px;">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-auth btn-orange" id="btnSend">
                    <i class="bi bi-send-fill"></i> Kirim Tautan Reset Password
                </button>
            </form>

            <div class="form-footer">
                Ingat password? <a href="{{ route('login') }}">Masuk sekarang</a>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            document.getElementById('fpForm').addEventListener('submit', function() {
                const btn = document.getElementById('btnSend');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Mengirim...';
            });
        </script>
    @endpush
</x-guest-layout>

