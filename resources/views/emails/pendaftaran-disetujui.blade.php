<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Diterima - Karang Taruna Karya Bhakti</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #1e293b;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 32px 24px; text-align: center;">
                <div style="font-size: 40px; margin-bottom: 8px;">🎉</div>
                <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0; letter-spacing: 0.5px;">SELAMAT BERGABUNG!</h1>
                <p style="color: #a7f3d0; font-size: 13px; margin: 6px 0 0 0; font-weight: 500;">Karang Taruna Karya Bhakti</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 32px 24px;">
                <p style="font-size: 15px; line-height: 1.6; margin-top: 0;">Halo, <strong>{{ $anggota->nama }}</strong>,</p>
                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                    Berdasarkan hasil wawancara dan musyawarah pengurus, kami dengan bangga menginformasikan bahwa pendaftaran Anda telah <strong>DISETUJUI</strong> dan Anda resmi menjadi bagian dari keluarga besar Karang Taruna Karya Bhakti!
                </p>

                <!-- Credentials Info Box -->
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px; margin: 24px 0;">
                    <h3 style="margin-top: 0; margin-bottom: 12px; font-size: 14px; color: #166534; font-weight: 700;">
                        🔐 Informasi Akun Portal Anggota Anda:
                    </h3>
                    <table width="100%" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                            <td width="35%" style="font-size: 13px; font-weight: bold; color: #166534;">Email / Username</td>
                            <td style="font-size: 13px; color: #1e293b; font-family: monospace; font-weight: 600;">
                                {{ $email }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: bold; color: #166534;">Password Sementara</td>
                            <td style="font-size: 13px; color: #047857; font-family: monospace; font-weight: 700; background-color: #dcfce7; padding: 4px 8px; border-radius: 6px; display: inline-block;">
                                {{ $password }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: bold; color: #166534;">Status Keanggotaan</td>
                            <td style="font-size: 13px; color: #1e293b; font-weight: 600;">
                                Aktif (Anggota)
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- CTA Button -->
                <div style="text-align: center; margin: 30px 0;">
                    <a href="{{ route('login') }}" style="display: inline-block; background-color: #059669; color: #ffffff; text-decoration: none; padding: 12px 28px; border-radius: 10px; font-weight: 700; font-size: 14px; box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.3);">
                        Masuk ke Portal Anggota &rarr;
                    </a>
                </div>

                <div style="background-color: #f8fafc; border-left: 4px solid #059669; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px;">
                    <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.5;">
                        <strong>Saran Keamanan:</strong> Demi keamanan akun, segera ubah kata sandi sementara Anda setelah berhasil masuk melalui menu <em>Profil &gt; Ganti Kata Sandi</em>.
                    </p>
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                    Selamat berkarya dan mari bersama membangun kepemudaan yang aktif, kreatif, dan berbakti!<br><br>
                    Salam hangat,<br>
                    <strong>Pengurus Karang Taruna Karya Bhakti</strong>
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f1f5f9; padding: 18px 24px; text-align: center; border-top: 1px solid #e2e8f0;">
                <p style="margin: 0; font-size: 11px; color: #64748b;">
                    Email ini dikirim otomatis oleh Sistem Informasi Karang Taruna Karya Bhakti.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
