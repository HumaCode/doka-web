<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #334155;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            padding: 40px 30px;
            color: #ffffff;
            position: relative;
        }
        .badge {
            background-color: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            margin-bottom: 20px;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.8;
        }
        .content {
            padding: 30px;
        }
        .section-label {
            font-size: 11px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 15px;
            display: block;
        }
        .user-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }
        .avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            border-radius: 12px;
            margin-right: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
        .user-info h3 {
            margin: 0;
            font-size: 18px;
            color: #1e293b;
        }
        .user-info p {
            margin: 2px 0;
            font-size: 14px;
            color: #64748b;
        }
        .data-grid {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-bottom: 20px;
        }
        .data-row {
            display: table-row;
        }
        .data-item {
            display: table-cell;
            width: 50%;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 15px;
            vertical-align: top;
        }
        .data-label {
            font-size: 10px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .data-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }
        .message-box {
            background-color: #f5f3ff;
            border-left: 4px solid #8b5cf6;
            border-radius: 0 12px 12px 0;
            padding: 20px;
            margin-bottom: 30px;
            position: relative;
        }
        .message-box::before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 40px;
            color: #ddd6fe;
            font-family: serif;
            line-height: 1;
        }
        .message-text {
            font-style: italic;
            font-size: 14px;
            color: #5b21b6;
            margin: 0;
            position: relative;
            z-index: 1;
        }
        .action-area {
            text-align: center;
            padding: 20px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        .btn-primary {
            background-color: #4f46e5;
            color: #ffffff !important;
            margin-right: 10px;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }
        .btn-secondary {
            background-color: #ffffff;
            color: #4f46e5 !important;
            border: 1px solid #e2e8f0;
        }
        .warning-box {
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 12px;
            padding: 15px;
            margin-top: 30px;
            font-size: 13px;
            color: #92400e;
        }
        .footer {
            padding: 30px;
            text-align: center;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }
        .footer-links {
            margin-bottom: 15px;
        }
        .footer-links a {
            color: #64748b;
            text-decoration: none;
            font-size: 12px;
            margin: 0 10px;
        }
        .copyright {
            font-size: 11px;
            color: #94a3b8;
        }
        .dot {
            height: 8px;
            width: 8px;
            background-color: #f59e0b;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="badge">● AKSI DIPERLUKAN</span>
            <div style="float: right; font-size: 12px; opacity: 0.6;">{{ date('d M Y H:i') }}</div>
            <div style="clear: both;"></div>
            <h1>Pendaftaran Akun Baru</h1>
            <p>Seorang pengguna baru telah mendaftar dan menunggu aktivasi dari administrator.</p>
        </div>

        <div class="content">
            <span class="section-label">Informasi Pengguna</span>
            <div class="user-card">
                <div class="avatar">{{ substr($user->name, 0, 1) }}</div>
                <div class="user-info">
                    <h3>{{ $user->name }}</h3>
                    <p>{{ $user->email }}</p>
                    <p style="font-size: 12px; color: #94a3b8;">
                        <span style="margin-right: 15px;">👤 {{ $user->roles->first()->name ?? 'Pengguna Baru' }}</span>
                        <span>📅 Daftar {{ $user->created_at->format('d/m/Y') }}</span>
                    </p>
                </div>
            </div>

            <table class="data-grid">
                <tr>
                    <td class="data-item" style="border-right: 5px solid transparent;">
                        <div class="data-label">NO. TELEPON</div>
                        <div class="data-value">{{ $user->phone ?? '-' }}</div>
                    </td>
                    <td class="data-item" style="border-left: 5px solid transparent;">
                        <div class="data-label">INSTANSI / ORGANISASI</div>
                        <div class="data-value">{{ $user->unitKerja->nama_instansi ?? '-' }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="data-item" style="border-right: 5px solid transparent;">
                        <div class="data-label">STATUS AKUN</div>
                        <div class="data-value"><span class="dot"></span> Menunggu Aktivasi</div>
                    </td>
                    <td class="data-item" style="border-left: 5px solid transparent;">
                        <div class="data-label">ID PENGGUNA</div>
                        <div class="data-value">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</div>
                    </td>
                </tr>
                @if(!empty($user->nip) || !empty($user->nik))
                <tr>
                    <td class="data-item" style="border-right: 5px solid transparent;">
                        <div class="data-label">{{ !empty($user->nip) ? 'NIP' : 'NIK' }}</div>
                        <div class="data-value">{{ $user->nip ?? $user->nik }}</div>
                    </td>
                    <td class="data-item" style="border-left: 5px solid transparent;">
                        <div class="data-label">JABATAN</div>
                        <div class="data-value">{{ $user->jabatan ?? '-' }}</div>
                    </td>
                </tr>
                @endif
            </table>

            <span class="section-label">Pesan dari Pengguna</span>
            <div class="message-box">
                <p class="message-text">
                    {{ $user->keterangan ?? 'Tidak ada pesan yang ditambahkan oleh pengguna.' }}
                </p>
            </div>

            <div style="font-size: 13px; color: #64748b; text-align: center; margin-bottom: 20px;">
                Tinjau informasi di atas dan aktifkan akun pengguna ini jika data sudah sesuai dan terverifikasi.
            </div>

            <div class="action-area">
                <a href="{{ $loginUrl }}" class="btn btn-primary">Aktifkan Akun Pengguna</a>
            </div>

            <div class="warning-box">
                <strong>⚠️ Perlu diperhatikan:</strong> Pastikan identitas dan data pengguna telah diverifikasi sebelum mengaktifkan akun. Jangan aktifkan akun jika terdapat informasi yang mencurigakan atau tidak lengkap.
            </div>
        </div>

        <div class="footer">
            <div class="footer-links">
                <a href="#">Panel Admin</a>
                <a href="#">Manajemen Pengguna</a>
                <a href="#">Panduan Aktivasi</a>
            </div>
            <div class="copyright">
                &copy; {{ date('Y') }} <strong>DokaKegiatan</strong>. Seluruh Hak Cipta Dilindungi.<br>
                Email ini dikirim otomatis ke administrator. Mohon tidak membalas email ini.
            </div>
        </div>
    </div>
</body>
</html>
