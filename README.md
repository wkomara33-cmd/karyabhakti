# 🌿 Sistem Informasi Manajemen Karang Taruna "Karya Bhakti"

Aplikasi web modern berbasis **Laravel 12** yang dirancang untuk mengelola keanggotaan, agenda kegiatan, absensi kehadiran (dengan konfirmasi RSVP & export PDF), manajemen buku kas/keuangan (dengan auto-running balance, export PDF & Excel), serta papan pengumuman organisasi kepemudaan.

---

## 🚀 Fitur Utama & Modul

### 1. 🔐 Autentikasi & Role-Based Access Control (RBAC)
- Autentikasi aman menggunakan session & role permission berbasis `spatie/laravel-permission`.
- Peran (Role):
  - **Admin / Pengurus (Ketua, Sekretaris, Bendahara)**: Akses menyeluruh ke semua modul, CRUD data, absensi manual, laporan keuangan, dan manajemen akun.
  - **Anggota**: Dashboard khusus anggota, RSVP konfirmasi kehadiran kegiatan, melihat transparansi saldo kas, dan membaca pengumuman.
- **Quick Demo Login**: Tersedia tombol switcher akun demo (Admin, Sekretaris, Bendahara, Anggota) di halaman login untuk pengujian cepat.

### 2. 👥 Manajemen Anggota
- **CRUD Anggota**: Data NIK, Nama Lengkap, Alamat, No HP/WhatsApp, Tanggal Lahir, Jabatan, Status (Aktif/Nonaktif), Tanggal Bergabung, dan Foto Profil.
- **Search & Filter**: Pencarian instan dan filter berdasarkan status keaktifan atau jabatan kepengurusan.
- **Detail Profil Anggota**: Menampilkan statistik persentase kehadiran kegiatan, riwayat kehadiran, dan status akun tertaut.
- Opsi pembuatan akun login langsung saat mendaftarkan anggota baru.

### 3. 📅 Kegiatan & Absensi
- **Manajemen Jadwal**: Buat, edit, dan hapus jadwal kegiatan beserta deskripsi, tanggal/waktu, lokasi, status, dan banner kegiatan.
- **Konfirmasi Kehadiran (RSVP)**: Anggota dapat melakukan konfirmasi *Akan Hadir* atau *Tidak Bisa Hadir* sebelum acara dimulai.
- **Absensi Manual Admin**: Pengurus dapat mencatat kehadiran langsung saat kegiatan (*Hadir*, *Izin*, *Tidak Hadir*, *Belum Absen*) baik per individu maupun secara batch serentak.
- **Export PDF Rekap Absensi**: Unduh berita acara dan rekapitulasi kehadiran kegiatan dalam format PDF siap cetak (`barryvdh/laravel-dompdf`).

### 4. 💰 Keuangan & Kas Organisasi
- **Pencatatan Kas Masuk & Keluar**: Catat penerimaan (iuran anggota, donasi, sponsor) dan pengeluaran operasional dilengkapi bukti nota/transaksi.
- **Perhitungan Saldo Otomatis (Real-time Running Balance)**: Saldo berjalan dihitung dan diperbarui secara otomatis menggunakan Eloquent Model Events.
- **Filter Laporan**: Filter berdasarkan rentang tanggal/bulan, tipe transaksi (pemasukan/pengeluaran), dan kategori.
- **Export Laporan PDF & Excel**: Unduh laporan buku kas dalam format PDF (`barryvdh/laravel-dompdf`) atau spreadsheet Excel XLSX (`maatwebsite/excel`).
- **Akses Anggota**: Anggota dapat melihat transparansi saldo kas dan ringkasan arus kas secara read-only.

### 5. 📢 Papan Pengumuman
- Buat dan kelola pengumuman dengan label prioritas (*Biasa*, *Penting*, *Mendesak*) dan lampiran dokumen/file.
- Tampilan kartu pengumuman interaktif di dashboard admin dan anggota.

---

## 🛠️ Tech Stack & Konfigurasi

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: PostgreSQL di [NeonDB](https://neon.tech/) (dengan SSL Mode `require`)
- **Frontend**: Blade Templating + Tailwind CSS + Alpine.js + Chart.js
- **Packages**:
  - `spatie/laravel-permission`: Manajemen Peran & Hak Akses
  - `barryvdh/laravel-dompdf`: Generator Laporan PDF
  - `maatwebsite/excel`: Generator Laporan Excel

---

## ⚙️ Petunjuk Instalasi & Setup NeonDB

### 1. Clone & Konfigurasi `.env`
Salin template konfigurasi lingkungan:
```bash
cp .env.example .env
```

Buka file `.env` dan masukkan kredensial koneksi PostgreSQL dari NeonDB:
```env
DB_CONNECTION=pgsql
DB_HOST=ep-your-project-id-pooler.ap-southeast-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=neondb
DB_USERNAME=neondb_owner
DB_PASSWORD=your_neon_password
DB_SSLMODE=require
```

### 2. Jalankan Migrasi & Seeder Database
Eksekusi migrasi tabel dan data awal (pengurus, anggota, kegiatan, kas, pengumuman):
```bash
php artisan migrate:fresh --seed
```

### 3. Generate App Key & Storage Link
```bash
php artisan key:generate
php artisan storage:link
```

### 4. Jalankan Aplikasi
Jalankan development server Laravel:
```bash
php artisan serve
```
Akses aplikasi melalui browser: **`http://localhost:8000`**

---

## 🔑 Akun Demo Bawaan (Seeder)

| Peran | Email | Password |
|---|---|---|
| **Admin / Ketua** | `admin@karangtaruna.org` | `password` |
| **Sekretaris** | `sekretaris@karangtaruna.org` | `password` |
| **Bendahara** | `bendahara@karangtaruna.org` | `password` |
| **Anggota** | `anggota1@karangtaruna.org` | `password` |

*(Di halaman login juga disediakan tombol **Demo Login 1-Klik** untuk kemudahan pengujian).*
