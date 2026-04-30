<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP - DokaKegiatan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            padding: 40px 16px;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            max-width: 520px;
            margin: 0 auto;
        }

        /* Top brand bar */
        .brand-bar {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-bar span {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6c4de6;
        }

        /* Main card */
        .card {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 8px 32px rgba(0, 0, 0, 0.06);
        }

        /* Header */
        .header {
            background: #5b3fd4;
            padding: 36px 40px 32px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -20px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .header-icon svg {
            width: 24px;
            height: 24px;
            fill: #fff;
        }

        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.3px;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.65);
            font-weight: 400;
        }

        /* Body */
        .body {
            padding: 40px 40px 32px;
        }

        .greeting {
            font-size: 15px;
            color: #374151;
            line-height: 1.6;
            margin-bottom: 8px;
        }

        .description {
            font-size: 14px;
            color: #6b7280;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        .description strong {
            color: #374151;
            font-weight: 600;
        }

        /* OTP Block */
        .otp-block {
            background: #fafafa;
            border: 1px solid #eeebf8;
            border-radius: 16px;
            padding: 28px 24px;
            margin-bottom: 32px;
        }

        .otp-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #9ca3af;
            text-align: center;
            margin-bottom: 14px;
        }

        .otp-digits {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 16px;
        }

        .otp-digit {
            width: 52px;
            height: 60px;
            background: #ffffff;
            border: 1.5px solid #e5e0f8;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: 700;
            color: #5b3fd4;
            letter-spacing: 0;
            box-shadow: 0 2px 6px rgba(91, 63, 212, 0.06);
        }

        .otp-timer {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 12px;
            color: #9ca3af;
        }

        .otp-timer svg {
            width: 13px;
            height: 13px;
            stroke: #9ca3af;
            fill: none;
        }

        .otp-timer strong {
            color: #e05a00;
            font-weight: 600;
        }

        /* Divider */
        .divider {
            height: 1px;
            background: #f3f4f6;
            margin: 0 0 28px;
        }

        /* Notice */
        .notice {
            display: flex;
            gap: 12px;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 14px 16px;
        }

        .notice-icon {
            flex-shrink: 0;
            width: 18px;
            height: 18px;
            margin-top: 1px;
        }

        .notice-icon svg {
            width: 18px;
            height: 18px;
            fill: #d97706;
        }

        .notice p {
            font-size: 13px;
            color: #92400e;
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: #f9fafb;
            border-top: 1px solid #f3f4f6;
            padding: 24px 40px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 14px;
        }

        .footer-links a {
            font-size: 12px;
            color: #9ca3af;
            text-decoration: none;
        }

        .footer-copy {
            text-align: center;
            font-size: 11px;
            color: #c4c9d4;
        }

        .footer-copy a {
            color: #9ca3af;
            text-decoration: none;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <div class="brand-bar">
            <span>DokaKegiatan</span>
        </div>

        <div class="card">

            <!-- Header -->
            <div class="header">
                <div class="header-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                    </svg>
                </div>
                <h1>Verifikasi Akun Anda</h1>
                <p>Permintaan masuk terdeteksi · Harap konfirmasi identitas Anda</p>
            </div>

            <!-- Body -->
            <div class="body">

                <p class="greeting">Halo,</p>
                <p class="description">
                    Kami menerima permintaan untuk masuk ke akun DokaKegiatan Anda.
                    Gunakan kode di bawah ini untuk melanjutkan. Kode hanya berlaku selama
                    <strong>5 menit</strong> dan hanya dapat digunakan satu kali.
                </p>

                <div class="otp-block">
                    <p class="otp-label">Kode Verifikasi OTP</p>
                    <div class="otp-digits">
                        @php $otpArray = str_split($otp); @endphp
                        @foreach($otpArray as $digit)
                            <div class="otp-digit">{{ $digit }}</div>
                        @endforeach
                    </div>
                    <div class="otp-timer">
                        <svg viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        Kedaluwarsa dalam <strong>3 menit</strong>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="notice">
                    <div class="notice-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>
                    <p>
                        Jika Anda tidak merasa meminta kode ini, abaikan email ini. Akun Anda tetap aman dan tidak ada
                        tindakan lebih lanjut yang diperlukan.
                    </p>
                </div>

            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="footer-links">
                    <a href="#">Pusat Bantuan</a>
                    <a href="#">Kebijakan Privasi</a>
                    <a href="#">Hubungi Kami</a>
                </div>
                <p class="footer-copy">
                    &copy; {{ date('Y') }} <a href="#">DokaKegiatan</a>. Seluruh Hak Cipta Dilindungi.<br>
                    Email ini dikirim otomatis, mohon tidak membalas.
                </p>
            </div>

        </div>

    </div>
</body>

</html>
