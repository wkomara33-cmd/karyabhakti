<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pendaftaran - Karang Taruna Karya Bhakti</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 24px; color: #1e293b;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <!-- Header -->
        <tr>
            <td style="background: linear-gradient(135deg, #475569 0%, #334155 100%); padding: 32px 24px; text-align: center;">
                <h1 style="color: #ffffff; font-size: 20px; font-weight: 800; margin: 0; letter-spacing: 0.5px;">KARANG TARUNA KARYA BHAKTI</h1>
                <p style="color: #cbd5e1; font-size: 13px; margin: 6px 0 0 0; font-weight: 500;">Pemberitahuan Hasil Seleksi Calon Anggota</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 32px 24px;">
                <p style="font-size: 15px; line-height: 1.6; margin-top: 0;">Halo, <strong>{{ $anggota->nama }}</strong>,</p>
                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                    Terima kasih atas partisipasi dan waktu yang telah Anda luangkan untuk mengikuti tahapan seleksi calon anggota Karang Taruna Karya Bhakti.
                </p>
                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                    Setelah melalui proses peninjauan berkas dan wawancara serta mempertimbangkan kapasitas kebutuhan kepengurusan periode saat ini, kami menyampaikan bahwa pendaftaran Anda <strong>belum dapat kami terima untuk periode ini</strong>.
                </p>

                @if($alasan)
                <div style="background-color: #f1f5f9; border-left: 4px solid #64748b; padding: 14px 18px; border-radius: 6px; margin: 20px 0;">
                    <p style="margin: 0; font-size: 13px; color: #334155; line-height: 1.5;">
                        <strong>Catatan Pengurus:</strong><br>
                        {{ $alasan }}
                    </p>
                </div>
                @endif

                <p style="font-size: 14px; line-height: 1.6; color: #475569;">
                    Data Anda tetap kami simpan dengan baik sebagai arsip calon relawan. Anda tetap dapat berpartisipasi dalam program-program dan kegiatan umum yang diselenggarakan oleh Karang Taruna Karya Bhakti. Jangan ragu untuk mendaftar kembali pada kesempatan pendaftaran berikutnya.
                </p>

                <p style="font-size: 14px; line-height: 1.6; color: #475569; margin-top: 24px;">
                    Tetap semangat dan terus berkontribusi bagi lingkungan dan masyarakat sekitar.<br><br>
                    Hormat kami,<br>
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
