# 🔐 DokaWeb Authentication System

Dokumen ini menjelaskan detail teknis implementasi sistem autentikasi **Passwordless OTP** dan keamanan **Google reCAPTCHA v3**.

## 📩 Passwordless OTP System

Sistem ini menggantikan password tradisional dengan kode OTP yang dikirim ke email.

### Komponen Backend
- **Model**: `App\Models\Auth\EmailOtp` (Menyimpan email, kode, expiry, dan percobaan).
- **Controller**: `App\Http\Controllers\Auth\OTPController`
- **Mail**: `App\Mail\Auth\OTPMail`
- **Konfigurasi**:
    - **Expiry**: 3 Menit (diatur di `OTPController`).
    - **Max Attempts**: 3 Kali.
    - **Rate Limit**: 60 Detik antar pengiriman.

### Alur Kerja (Flow)
1. User memasukkan email.
2. Sistem memvalidasi email dan mengirimkan 6 digit kode via Mailtrap/SMTP.
3. User memasukkan kode ke 6 kotak input (Frontend otomatis melakukan transisi antar kotak).
4. Jika valid, user langsung login (atau diarahkan ke form registrasi jika email baru).

---

## 🛡️ Google reCAPTCHA v3 Integration

Setiap proses autentikasi dilindungi oleh reCAPTCHA v3 untuk mencegah bot.

### Backend Verification
Gunakan class `App\Helpers\ReCaptchaHelper` untuk memverifikasi token:

```php
if (!\App\Helpers\ReCaptchaHelper::verify($request->g_recaptcha_response)) {
    // Return error / blocked
}
```

### Frontend Execution
Setiap form harus memuat script reCAPTCHA menggunakan site key dari `.env`:

```html
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
```

Eksekusi dilakukan saat submit form:

```javascript
grecaptcha.ready(function() {
    grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}", {action: 'login'}).then(function(token) {
        // Kirim token ke backend sebagai 'g_recaptcha_response'
    });
});
```

---

## ⏳ Sistem Aktivasi Akun (Pending)

Setiap akun baru yang terdaftar (manual maupun Google) memiliki status default **Nonaktif** (`is_active = 0`).

### Komponen Sistem
- **Middleware**: `App\Http\Middleware\EnsureAccountIsActive` (Alias: `active`).
- **Status Database**: Kolom `is_active` (enum `0, 1`) pada tabel `users`.
- **Halaman Penangguhan**: `/pending-activation` (`resources/views/auth/pending.blade.php`).

### Alur Kerja
1. User login (baik via OTP maupun Google).
2. Middleware `active` memeriksa status `is_active`.
3. Jika `is_active == 0`, user diarahkan ke halaman `/pending-activation`.
4. User mengisi data instansi tambahan (NIP, Jabatan, dll).
5. Administrator memverifikasi dan mengubah status menjadi `1`.
6. User dapat mengakses dashboard dan fitur lainnya.
