# SIORMAWA - Manajemen Organisasi Kemahasiswaan

## Status Pengembangan

**SIORMAWA** digunakan untuk memanajemen organisasi di lingkungan kampus, membantu pengelolaan data anggota, kegiatan, serta administrasi organisasi secara efisien dan terstruktur. Aplikasi ini memudahkan kolaborasi antar anggota, distribusi informasi, serta dokumentasi aktivitas organisasi, sehingga proses manajemen menjadi lebih transparan dan terorganisir, 

Proyek ini masih dalam tahap pengembangan awal dan telah mencapai sekitar 40% dari target fitur utama.


![SS AWAL](./siormawa.png)

### Hak Akses Pengguna

**Admin Sistem**
- ✅ CRUD semua data
- ✅ Kelola users dan organisasi
- ✅ Akses semua fitur sistem

**Admin Organisasi**
- ✅ CRUD data organisasinya
- ✅ Kelola anggota organisasi
- ❌ Tidak bisa akses organisasi lain

**Member**
- ✅ READ data organisasinya
- ✅ Download dokumen published
- ❌ Tidak bisa CRUD data

**Status:** Pengembangan (40%)

---

#### Konteks: Universitas (15 organisasi kemahasiswaan)

- **Setup**
    - 1 Admin Sistem (Staff IT)
    - 15 Admin Organisasi (Ketua/Sekretaris organisasi)
    - 500+ Member (Mahasiswa anggota organisasi)
- **Penggunaan**
    - Admin Sistem: Setup awal, maintenance, monitoring
    - Admin Organisasi: Kelola kegiatan rutin, rekrutmen anggota
    - Member: Akses info kegiatan, download dokumen

#### Konteks: SMA (OSIS & 8 ekstrakurikuler)

- **Setup**
    - 1 Admin Sistem (Guru TI)
    - 9 Admin Organisasi (Pembina ekskul)
    - 200+ Member (Siswa)
- **Penggunaan**
    - Koordinasi kegiatan sekolah
    - Manajemen anggota ekskul
    - Distribusi informasi dan dokumen
## Fitur Utama (Rencana)

- Manajemen data anggota organisasi
- Pengelolaan agenda dan kegiatan organisasi
- Dokumentasi dan arsip surat-menyurat
- Laporan dan statistik aktivitas organisasi

## Lisensi

Aplikasi ini direncanakan akan menggunakan lisensi open source. Detail lisensi akan diumumkan setelah pengembangan mencapai tahap stabil.

---

**Bug Fixing**  
Mulai Laravel 11 ke atas (termasuk Laravel 12), file `app/Http/Kernel.php` sudah tidak digunakan lagi untuk daftar route middleware. Semua konfigurasi sekarang dipusatkan di file: `bootstrap/app.php`

Login Website

| Email                  | Password   | Role    |
| ---------------------- | ---------- | ------- |
| `admin@siormawa.ac.id` | `password` | `admin` |

| Nama Organisasi | Email Admin                       | Password   | Role                 |
| --------------- | --------------------------------- | ---------- | -------------------- |
| HMTI            | `hmti.admin@university.ac.id`     | `password` | `organization_admin` |
| BEM             | `bem.admin@university.ac.id`      | `password` | `organization_admin` |
| UKM SENI        | `ukm seni.admin@university.ac.id` | `password` | `organization_admin` |

| Email (sama dgn anggota) | Password   | Role     |
| ------------------------ | ---------- | -------- |
| email random             | `password` | `member` |

Setelah Login baru bisa update Profil Masing-masing.