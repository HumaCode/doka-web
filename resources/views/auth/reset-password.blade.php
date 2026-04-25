<x-guest-layout>
    @section('title', 'Reset Password')

    @section('bg-style')
    background:
        radial-gradient(ellipse 75% 55% at  8% 15%, #fef3c7 0%, transparent 55%),
        radial-gradient(ellipse 65% 55% at 92% 85%, #fed7aa 0%, transparent 55%),
        radial-gradient(ellipse 55% 50% at 50% 50%, #fce7f3 0%, transparent 65%),
        radial-gradient(ellipse 50% 40% at 78% 12%, #ddd6fe 0%, transparent 50%),
        linear-gradient(135deg, #fffbeb 0%, #fef3c7 40%, #fce7f3 100%);
    @endsection

    @section('particle-emojis', "['🔑','🔒','🔓','🛡','✨','⭐','💫','🌟']")
    @section('particle-colors',  "['#10b981','#06b6d4','#4f46e5','#f59e0b','#f97316','#8b5cf6']")

    <div class="auth-card" style="max-width:760px;grid-template-columns:300px 1fr;box-shadow:0 24px 64px rgba(16,185,129,.15),0 4px 20px rgba(6,182,212,.10);">

        {{-- ══ LEFT: Brand Panel ══ --}}
        <div class="brand-panel" style="background:linear-gradient(160deg,#10b981 0%,#059669 30%,#0891b2 65%,#4f46e5 100%);">
            <div class="brand-deco bd1"></div>
            <div class="brand-deco bd2" style="background:#fde68a;"></div>
            <div class="brand-deco bd3"></div>
            <div class="brand-deco bd4"></div>

            <a href="{{ url('/') }}" class="brand-logo">
                <div class="logo-icon-wrap"><i class="bi bi-camera-reels-fill"></i></div>
                <div>
                    <div class="brand-name">Doka<span>Kegiatan</span></div>
                    <div class="brand-sub">DOKUMENTASI KEGIATAN</div>
                </div>
            </a>

            <div class="brand-tagline">
                <h2>Buat Password<br />Baru Anda 🔐</h2>
                <p>Buat password baru yang kuat dan berbeda dari sebelumnya. Pastikan mudah diingat namun sulit ditebak.</p>
            </div>

            {{-- Password tips --}}
            <div class="step-track brand-side-extras">
                <div class="step-item">
                    <div class="step-num done"><i class="bi bi-check2"></i></div>
                    <div class="step-text"><strong>Email Terverifikasi</strong><span>Tautan reset valid</span></div>
                </div>
                <div class="step-item">
                    <div class="step-num active">2</div>
                    <div class="step-text"><strong>Buat Password Baru</strong><span>Min. 8 karakter + campuran</span></div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text"><strong>Selesai &amp; Masuk</strong><span>Login dengan password baru</span></div>
                </div>
            </div>
        </div>

        {{-- ══ RIGHT: Form Panel ══ --}}
        <div class="form-panel" style="justify-content:center;">

            <div class="icon-ring"
                style="background:linear-gradient(135deg,#10b981,#06b6d4);box-shadow:0 8px 24px rgba(16,185,129,.38);">
                <i class="bi bi-lock-fill"></i>
            </div>

            <div class="form-heading">
                <h1>Reset Password 🔐</h1>
                <p>Buat password baru yang kuat untuk akun DokaKegiatan Anda.</p>
            </div>

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

            <form method="POST" action="{{ route('password.store') }}" id="resetForm" novalidate>
                @csrf

                {{-- Token hidden --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}" />

                {{-- Email hidden / prefilled --}}
                <label class="form-label" for="email">Alamat Email</label>
                <div class="field-wrap">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input type="email" id="email" name="email" class="form-ctrl @error('email') is-error @enderror"
                        value="{{ old('email', $request->email) }}" placeholder="nama@instansi.go.id" required readonly
                        style="background:rgba(240,253,244,.8);color:var(--c-muted);" />
                </div>
                @error('email')
                    <div class="invalid-feedback" style="margin-top:-14px; margin-bottom:18px;">{{ $message }}</div>
                @enderror

                {{-- New password --}}
                <label class="form-label" for="password">Password Baru <span class="req">*</span></label>
                <div class="field-wrap" id="wrap-password">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" id="password" name="password"
                        class="form-ctrl @error('password') is-error @enderror" placeholder="Min. 8 karakter"
                        style="padding-right:42px;" autocomplete="new-password" required />
                    <button type="button" class="toggle-pw" data-target="password" data-icon="eye1">
                        <i class="bi bi-eye-fill" id="eye1"></i>
                    </button>
                </div>
                <div class="pw-strength-wrap" style="margin-top:-14px; margin-bottom:18px;">
                    <div class="pw-strength-bar">
                        <div class="pw-strength-fill" id="pwFill"></div>
                    </div>
                    <span class="pw-strength-label" id="pwLabel">Belum diisi</span>
                </div>
                @error('password')
                    <div class="invalid-feedback" style="margin-top:-14px; margin-bottom:18px;">{{ $message }}</div>
                @enderror

                {{-- Password rules --}}
                <div class="pw-rules" style="margin-bottom:16px;">
                    <div class="pw-rule" id="rule-len"><i class="bi bi-check-circle-fill"></i> Minimal 8 karakter</div>
                    <div class="pw-rule" id="rule-upper"><i class="bi bi-check-circle-fill"></i> Mengandung huruf kapital (A–Z)</div>
                    <div class="pw-rule" id="rule-num"><i class="bi bi-check-circle-fill"></i> Mengandung angka (0–9)</div>
                    <div class="pw-rule" id="rule-sym"><i class="bi bi-check-circle-fill"></i> Mengandung simbol (!@#$...)</div>
                </div>

                {{-- Confirm password --}}
                <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="req">*</span></label>
                <div class="field-wrap" id="wrap-cpw">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-ctrl"
                        placeholder="Ulangi password baru" style="padding-right:42px;" autocomplete="new-password"
                        required />
                    <button type="button" class="toggle-pw" data-target="password_confirmation" data-icon="eye2">
                        <i class="bi bi-eye-fill" id="eye2"></i>
                    </button>
                </div>
                <div class="field-error" id="err-cpw" style="display:none;font-size:.75rem;color:#ef4444;margin-top:-14px; margin-bottom:18px;">Password tidak cocok.</div>

                <button type="submit" class="btn-auth btn-green" id="btnReset">
                    <i class="bi bi-check2-circle"></i> Simpan Password Baru
                </button>
            </form>

            <div class="form-footer">
                Ingat password? <a href="{{ route('login') }}">Masuk sekarang</a>
            </div>
        </div>

    </div>

    @push('js')
        <script>
            const LEVELS = [{
                    min: 0,
                    c: '#e5e7eb',
                    l: 'Belum diisi',
                    p: '0%'
                },
                {
                    min: 1,
                    c: '#f87171',
                    l: 'Sangat lemah',
                    p: '20%'
                },
                {
                    min: 4,
                    c: '#fb923c',
                    l: 'Lemah',
                    p: '40%'
                },
                {
                    min: 6,
                    c: '#facc15',
                    l: 'Sedang',
                    p: '60%'
                },
                {
                    min: 8,
                    c: '#4ade80',
                    l: 'Kuat',
                    p: '80%'
                },
                {
                    min: 10,
                    c: '#10b981',
                    l: 'Sangat kuat 💪',
                    p: '100%'
                },
            ];
            document.getElementById('password').addEventListener('input', function() {
                const v = this.value;
                let s = v.length;
                if (/[A-Z]/.test(v)) s++;
                if (/[0-9]/.test(v)) s++;
                if (/[^A-Za-z0-9]/.test(v)) s += 2;
                let lv = LEVELS[0];
                for (const l of LEVELS)
                    if (s >= l.min) lv = l;
                document.getElementById('pwFill').style.width = lv.p;
                document.getElementById('pwFill').style.background = lv.c;
                const lb = document.getElementById('pwLabel');
                lb.textContent = lv.l;
                lb.style.color = lv.c === '#e5e7eb' ? 'var(--c-muted)' : lv.c;
                const toggle = (id, ok) => {
                    const el = document.getElementById(id);
                    el.classList.toggle('ok', ok);
                };
                toggle('rule-len', v.length >= 8);
                toggle('rule-upper', /[A-Z]/.test(v));
                toggle('rule-num', /[0-9]/.test(v));
                toggle('rule-sym', /[^A-Za-z0-9]/.test(v));
            });

            document.getElementById('resetForm').addEventListener('submit', function(e) {
                const pw = document.getElementById('password').value;
                const cpw = document.getElementById('password_confirmation').value;
                const err = document.getElementById('err-cpw');
                const wrap = document.getElementById('wrap-cpw');
                if (pw !== cpw) {
                    e.preventDefault();
                    err.style.display = 'block';
                    wrap.classList.add('has-error');
                    return;
                }
                err.style.display = 'none';
                wrap.classList.remove('has-error');
                const btn = document.getElementById('btnReset');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';
            });
        </script>
    @endpush
</x-guest-layout>

