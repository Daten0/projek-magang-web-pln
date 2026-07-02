# File Tree: projek-magang-web-pln

**Generated:** 7/2/2026, 10:40:03 AM
**Root Path:** `/home/qiddis/Documents/projek-magang-web-pln`

```
├── 📁 app
│   ├── 📁 Console
│   │   └── 📁 Commands
│   │       └── 🐘 TandaiAlfaOtomatis.php
│   ├── 📁 Http
│   │   ├── 📁 Controllers
│   │   │   ├── 📁 Admin
│   │   │   │   ├── 🐘 DashboardController.php
│   │   │   │   ├── 🐘 ManajemenMentorController.php
│   │   │   │   ├── 🐘 ManajemenPesertaController.php
│   │   │   │   ├── 🐘 MonitoringController.php
│   │   │   │   ├── 🐘 PengaturanController.php
│   │   │   │   ├── 🐘 SertifikatController.php
│   │   │   │   └── 🐘 ValidasiPendaftaranController.php
│   │   │   ├── 📁 Mentor
│   │   │   │   ├── 🐘 AnakMagangController.php
│   │   │   │   ├── 🐘 DashboardController.php
│   │   │   │   ├── 🐘 PenilaianAkhirController.php
│   │   │   │   ├── 🐘 ProfilController.php
│   │   │   │   ├── 🐘 VerifikasiLaporanAkhirController.php
│   │   │   │   └── 🐘 VerifikasiLogbookController.php
│   │   │   ├── 🐘 AbsensiController.php
│   │   │   ├── 🐘 AuthController.php
│   │   │   ├── 🐘 Controller.php
│   │   │   ├── 🐘 DashboardController.php
│   │   │   ├── 🐘 LaporanAkhirController.php
│   │   │   ├── 🐘 LogbookController.php
│   │   │   ├── 🐘 ProfilController.php
│   │   │   └── 🐘 SertifikatController.php
│   │   └── 📁 Middleware
│   │       ├── 🐘 RoleAdmin.php
│   │       ├── 🐘 RoleMentor.php
│   │       └── 🐘 RolePeserta.php
│   ├── 📁 Models
│   │   ├── 🐘 Absensi.php
│   │   ├── 🐘 LaporanAkhir.php
│   │   ├── 🐘 Logbook.php
│   │   ├── 🐘 PenilaianAkhir.php
│   │   ├── 🐘 ProfilMentor.php
│   │   ├── 🐘 ProfilPeserta.php
│   │   ├── 🐘 Sertifikat.php
│   │   └── 🐘 User.php
│   └── 📁 Providers
│       └── 🐘 AppServiceProvider.php
├── 📁 bootstrap
│   ├── 🐘 app.php
│   └── 🐘 providers.php
├── 📁 config
│   ├── 🐘 app.php
│   ├── 🐘 auth.php
│   ├── 🐘 cache.php
│   ├── 🐘 database.php
│   ├── 🐘 filesystems.php
│   ├── 🐘 logging.php
│   ├── 🐘 mail.php
│   ├── 🐘 queue.php
│   ├── 🐘 services.php
│   └── 🐘 session.php
├── 📁 database
│   ├── 📁 factories
│   │   └── 🐘 UserFactory.php
│   ├── 📁 migrations
│   │   ├── 🐘 0001_01_01_000000_create_users_table.php
│   │   ├── 🐘 0001_01_01_000001_create_cache_table.php
│   │   ├── 🐘 0001_01_01_000002_create_jobs_table.php
│   │   ├── 🐘 2026_06_23_081624_add_role_and_status_to_users_table.php
│   │   ├── 🐘 2026_06_23_082328_create_profil_peserta_table.php
│   │   ├── 🐘 2026_06_23_082808_create_profil_mentor_table.php
│   │   ├── 🐘 2026_06_23_082937_create_absensi_table.php
│   │   ├── 🐘 2026_06_23_083032_create_logbook_table.php
│   │   ├── 🐘 2026_06_23_083123_create_laporan_akhir_table.php
│   │   ├── 🐘 2026_06_23_083213_create_penilaian_akhir_table.php
│   │   ├── 🐘 2026_06_23_083303_create_sertifikat_table.php
│   │   ├── 🐘 2026_06_25_012723_add_jam_and_tanggal_kegiatan_to_logbook_table.php
│   │   ├── 🐘 2026_06_25_015933_add_sakit_to_absensi_status.php
│   │   ├── 🐘 2026_06_25_104733_change_jam_masuk_to_string_in_absensi_table.php
│   │   ├── 🐘 2026_06_25_143229_add_foto_to_profil_mentor_table.php
│   │   ├── 🐘 2026_06_25_160011_add_foto_to_profil_peserta_table.php
│   │   ├── 🐘 2026_06_26_084843_update_jenis_pendaftaran_enum_in_profil_peserta_table.php
│   │   ├── 🐘 2026_06_27_143928_add_nonaktif_to_status_magang_in_profil_peserta_table.php
│   │   ├── 🐘 2026_06_27_172928_add_nonaktif_to_status_pendaftaran_enum.php
│   │   ├── 🐘 2026_06_29_090809_update_status_magang_enum_on_profil_peserta.php
│   │   ├── 🐘 2026_06_29_105525_add_dokumentasi_to_logbook_table.php
│   │   └── 🐘 2026_06_30_194341_add_menunggu_to_status_magang_enum.php
│   ├── 📁 seeders
│   │   ├── 🐘 AdminSeeder.php
│   │   ├── 🐘 DatabaseSeeder.php
│   │   └── 🐘 MentorSeeder.php
│   └── ⚙️ .gitignore
├── 📁 public
│   ├── 📁 gambar
│   │   ├── 🖼️ pln-login.png
│   │   └── 🖼️ pln-login2.png
│   ├── ⚙️ .htaccess
│   ├── 📄 favicon.ico
│   ├── 🐘 index.php
│   └── 📄 robots.txt
├── 📁 resources
│   ├── 📁 css
│   │   └── 🎨 app.css
│   ├── 📁 js
│   │   ├── 📄 app.js
│   │   └── 📄 bootstrap.js
│   └── 📁 views
│       ├── 📁 absensi
│       │   └── 🐘 index.blade.php
│       ├── 📁 admin
│       │   ├── 🐘 dashboard.blade.php
│       │   ├── 🐘 manajemen-mentor-edit.blade.php
│       │   ├── 🐘 manajemen-mentor-tambah.blade.php
│       │   ├── 🐘 manajemen-mentor.blade.php
│       │   ├── 🐘 manajemen-peserta-edit.blade.php
│       │   ├── 🐘 manajemen-peserta.blade.php
│       │   ├── 🐘 monitoring-detail.blade.php
│       │   ├── 🐘 monitoring.blade.php
│       │   ├── 🐘 pengaturan.blade.php
│       │   ├── 🐘 placeholder.blade.php
│       │   ├── 🐘 sertifikat-detail.blade.php
│       │   ├── 🐘 sertifikat.blade.php
│       │   ├── 🐘 validasi-pendaftaran-detail.blade.php
│       │   └── 🐘 validasi-pendaftaran.blade.php
│       ├── 📁 auth
│       │   ├── 🐘 Login.blade.php
│       │   └── 🐘 Register.blade.php
│       ├── 📁 laporan-akhir
│       │   └── 🐘 index.blade.php
│       ├── 📁 layouts
│       │   ├── 🐘 App.blade.php
│       │   ├── 🐘 admin.blade.php
│       │   └── 🐘 mentor.blade.php
│       ├── 📁 logbook
│       │   ├── 🐘 create.blade.php
│       │   └── 🐘 index.blade.php
│       ├── 📁 mentor
│       │   ├── 🐘 anak-magang.blade.php
│       │   ├── 🐘 dashboard.blade.php
│       │   ├── 🐘 penilaian-akhir-detail.blade.php
│       │   ├── 🐘 penilaian-akhir.blade.php
│       │   ├── 🐘 profil-edit.blade.php
│       │   ├── 🐘 profil.blade.php
│       │   ├── 🐘 tinjau-laporan-akhir.blade.php
│       │   ├── 🐘 tinjau-logbook.blade.php
│       │   ├── 🐘 verifikasi-laporan-akhir.blade.php
│       │   └── 🐘 verifikasi-logbook.blade.php
│       ├── 📁 profil
│       │   ├── 🐘 edit.blade.php
│       │   └── 🐘 index.blade.php
│       ├── 📁 sertifikat
│       │   └── 🐘 index.blade.php
│       ├── 🐘 Dashboard.blade.php
│       └── 🐘 welcome.blade.php
├── 📁 routes
│   ├── 🐘 console.php
│   └── 🐘 web.php
├── 📁 storage
│   ├── 📁 app
│   │   ├── 📁 private
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 public
│   │   │   └── ⚙️ .gitignore
│   │   └── ⚙️ .gitignore
│   ├── 📁 framework
│   │   └── ⚙️ .gitignore
│   └── 📁 logs
│       └── ⚙️ .gitignore
├── 📁 tests
│   ├── 📁 Feature
│   │   └── 🐘 ExampleTest.php
│   ├── 📁 Unit
│   │   └── 🐘 ExampleTest.php
│   └── 🐘 TestCase.php
├── ⚙️ .editorconfig
├── ⚙️ .env.example
├── ⚙️ .gitattributes
├── ⚙️ .gitignore
├── 📝 README.md
├── 📄 artisan
├── ⚙️ composer.json
├── ⚙️ package.json
├── ⚙️ phpunit.xml
└── 📄 vite.config.js
```

---
