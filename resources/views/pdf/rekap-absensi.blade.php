<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Absensi - {{ $kegiatan->nama_kegiatan }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            font-size: 11px;
            line-height: 1.4;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #059669;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 16px;
            margin: 0 0 4px 0;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .header h2 {
            font-size: 13px;
            margin: 0 0 4px 0;
            color: #059669;
        }
        .header p {
            margin: 0;
            font-size: 10px;
            color: #64748b;
        }
        .meta-table {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .meta-table td {
            padding: 4px 8px;
            font-size: 10px;
        }
        .meta-table td.label {
            width: 18%;
            font-weight: bold;
            color: #475569;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 16px;
            border-collapse: collapse;
        }
        .stats-grid td {
            width: 25%;
            padding: 8px;
            text-align: center;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }
        .stats-grid .num {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
        }
        .stats-grid .txt {
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th {
            background-color: #059669;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 6px 8px;
            text-align: left;
            border: 1px solid #047857;
        }
        .data-table td {
            padding: 6px 8px;
            border: 1px solid #e2e8f0;
            font-size: 10px;
        }
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-hadir { background-color: #d1fae5; color: #065f46; }
        .badge-izin { background-color: #fef3c7; color: #92400e; }
        .badge-tidak_hadir { background-color: #ffe4e6; color: #9f1239; }
        .badge-belum_absen { background-color: #f1f5f9; color: #475569; }
        
        .footer {
            margin-top: 30px;
            width: 100%;
        }
        .signature-box {
            width: 200px;
            float: right;
            text-align: center;
        }
        .signature-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>KARANG TARUNA KARYA BHAKTI</h1>
        <h2>BERITA ACARA & REKAPITULASI DAFTAR HADIR KEGIATAN</h2>
        <p>Sekretariat: Jl. Pemuda Bhakti No. 45 | Email: info@karyabhakti.org</p>
    </div>

    <table class="meta-table">
        <tr>
            <td class="label">Nama Kegiatan:</td>
            <td><strong>{{ $kegiatan->nama_kegiatan }}</strong></td>
            <td class="label">Status Acara:</td>
            <td>{{ ucfirst(str_replace('_', ' ', $kegiatan->status)) }}</td>
        </tr>
        <tr>
            <td class="label">Hari / Tanggal:</td>
            <td>{{ $kegiatan->tanggal->isoFormat('dddd, D MMMM Y') }} ({{ $kegiatan->tanggal->format('H:i') }} WIB)</td>
            <td class="label">Lokasi:</td>
            <td>{{ $kegiatan->lokasi }}</td>
        </tr>
    </table>

    <table class="stats-grid">
        <tr>
            <td>
                <div class="num">{{ $stats['total_anggota'] }}</div>
                <div class="txt">Total Anggota</div>
            </td>
            <td>
                <div class="num" style="color: #059669;">{{ $stats['hadir'] }}</div>
                <div class="txt">Hadir Fisik</div>
            </td>
            <td>
                <div class="num" style="color: #d97706;">{{ $stats['izin'] }}</div>
                <div class="txt">Izin / Sakit</div>
            </td>
            <td>
                <div class="num" style="color: #e11d48;">{{ $stats['tidak_hadir'] }}</div>
                <div class="txt">Tidak Hadir</div>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 28%;">Nama Anggota</th>
                <th style="width: 15%;">NIK</th>
                <th style="width: 14%;">Jabatan</th>
                <th style="width: 14%; text-align: center;">Konfirmasi RSVP</th>
                <th style="width: 12%; text-align: center;">Status Absensi</th>
                <th style="width: 12%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $index => $absensi)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><strong>{{ $absensi->anggota->nama ?? '-' }}</strong></td>
                <td>{{ $absensi->anggota->nik ?? '-' }}</td>
                <td>{{ $absensi->anggota->jabatan ?? '-' }}</td>
                <td style="text-align: center;">
                    {{ ucfirst(str_replace('_', ' ', $absensi->konfirmasi_kehadiran)) }}
                </td>
                <td style="text-align: center;">
                    <span class="badge badge-{{ $absensi->status_kehadiran }}">
                        {{ ucfirst(str_replace('_', ' ', $absensi->status_kehadiran)) }}
                    </span>
                </td>
                <td>{{ $absensi->catatan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; color: #94a3b8; padding: 20px;">
                    Belum ada data kehadiran tercatat.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p style="margin-bottom: 4px;">Ditetapkan di Tempat,</p>
            <p style="margin: 0; font-size: 9px; color: #64748b;">Tanggal: {{ date('d F Y') }}</p>
            <p style="font-weight: bold; margin-top: 4px;">Ketua / Sekretaris Panitia,</p>
            <div class="signature-space"></div>
            <p style="font-weight: bold; text-decoration: underline; margin-bottom: 2px;">( .................................................. )</p>
            <p style="margin: 0; font-size: 9px; color: #64748b;">Pengurus Karang Taruna Karya Bhakti</p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>
