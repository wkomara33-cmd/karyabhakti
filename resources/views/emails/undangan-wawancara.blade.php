<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Wawancara - Karang Taruna Karya Bhakti</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #1e293b;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #059669 0%, #047857 100%); padding: 32px 24px; text-align: center;">
                <h1 style="color: #ffffff; font-size: 22px; font-weight: 800; margin: 0; letter-spacing: 0.5px;">KARANG TARUNA KARYA BHAKTI</h1>
                <p style="color: #a7f3d0; font-size: 13px; margin: 6px 0 0 0; font-weight: 500;">Pemberitahuan Undangan Wawancara Calon Anggota</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 32px 24px;">
                <p style="font-size: 15px; line-height: 1.6; margin-top: 0;">Halo, <strong>{{ $anggota->nama }}</strong>,</p>
                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                    Terima kasih atas antusiasme Anda mendaftar sebagai calon anggota Karang Taruna Karya Bhakti. Berkas pendaftaran Anda telah kami tinjau dan kami mengundang Anda untuk mengikuti sesi wawancara tatap muka (offline) dengan rincian jadwal sebagai berikut:
                </p>

                <!-- Interview Info Box -->
                <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 20px; margin: 24px 0;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="6">
                        <tr>
                            <td width="30%" style="font-size: 13px; font-weight: bold; color: #166534;">📅 Waktu</td>
                            <td style="font-size: 13px; color: #1e293b; font-weight: 600;">
                                {{ $anggota->tanggal_wawancara ? $anggota->tanggal_wawancara->isoFormat('dddd, D MMMM Y • HH:mm') . ' WIB' : 'Akan dihubungi pengurus' }}
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 13px; font-weight: bold; color: #166534;">📍 Lokasi</td>
                            <td style="font-size: 13px; color: #1e293b; font-weight: 600;">
                                {{ $anggota->lokasi_wawancara ?? 'Sekretariat Karang Taruna Karya Bhakti' }}
                            </td>
                        </tr>
                        @if($anggota->catatan_wawancara)
                        <tr>
                            <td style="font-size: 13px; font-weight: bold; color: #166534; vertical-align: top;">📝 Catatan</td>
                            <td style="font-size: 13px; color: #1e293b;">
                                {{ $anggota->catatan_wawancara }}
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>

                <div style="background-color: #f8fafc; border-left: 4px solid #059669; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px;">
                    <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.5;">
                        <strong>Catatan Penting:</strong> Harap hadir 15 menit sebelum waktu wawancara dan berpakaian rapi serta sopan. Jika berhalangan hadir pada waktu di atas, silakan hubungi pengurus kami melalui kontak WhatsApp.
                    </p>
                </div>

                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
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
