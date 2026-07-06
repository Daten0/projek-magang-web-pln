# File Tree: projek-magang-web-pln

**Root Path:** `/home/qiddis/Documents/SIM-PLN/projek-magang-web-pln`

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
│   │   ├── 🐘 2026_06_30_000000_add_nilai_akhir_to_penilaian_akhir_table.php
│   │   └── 🐘 2026_06_30_194341_add_menunggu_to_status_magang_enum.php
│   ├── 📁 seeders
│   │   ├── 🐘 AdminSeeder.php
│   │   ├── 🐘 DatabaseSeeder.php
│   │   └── 🐘 MentorSeeder.php
│   └── ⚙️ .gitignore
├── 📁 docker
│   ├── 🐳 Dockerfile
│   └── 📄 entrypoint.sh
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
│       │   ├── 🐘 admin.blade.php
│       │   ├── 🐘 app.blade.php
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
├── 📁 serti-template
│   ├── 🖼️ 1.svg
│   └── 🖼️ 2.svg
├── 📁 storage
│   ├── 📁 app
│   │   ├── 📁 private
│   │   │   └── ⚙️ .gitignore
│   │   ├── 📁 public
│   │   │   ├── 📁 foto-profil
│   │   │   │   └── 🖼️ peserta_1_1783164308.jpeg
│   │   │   ├── 📁 laporan-akhir
│   │   │   │   ├── 📕 1783164266_1.pdf
│   │   │   │   └── 📕 1783241785_2.pdf
│   │   │   ├── 📁 logbook
│   │   │   │   └── 📁 dokumentasi
│   │   │   │       ├── 🖼️ EwzWfzb4DvoAef55oYXDrdro0qtt2ZL6qtLVFLcV.jpg
│   │   │   │       └── 🖼️ FeTXSC1KElTjkCplkGZ1LuELBIr19CYmSwK9V4KW.png
│   │   │   └── ⚙️ .gitignore
│   │   └── ⚙️ .gitignore
│   ├── 📁 framework
│   │   ├── 📁 views
│   │   │   ├── 🐘 0046b8ce08896c592cc959db78262c9f.php
│   │   │   ├── 🐘 073b9d7a091e537681e7593ca7d85e86.php
│   │   │   ├── 🐘 09ee47cb6b2ead6fe59c09eda6d900b2.php
│   │   │   ├── 🐘 0cd3f42f50837d1c0987bdb8d9888ff2.php
│   │   │   ├── 🐘 0d91cc84ca3ef31e353ece892735402b.php
│   │   │   ├── 🐘 0fdbe6bcb315d419e053f9ac0bfe2f13.php
│   │   │   ├── 🐘 10dff0909b8a94de80b97e2c4716bd99.php
│   │   │   ├── 🐘 132b834a0a58f1e712afb341f8622879.php
│   │   │   ├── 🐘 136a7c656d1a0ed4e2d0901fc10aa84a.php
│   │   │   ├── 🐘 19d1ca22cd8db231f88e0685e9c3a20e.php
│   │   │   ├── 🐘 1bbc6102c081b21bf9f2f593a9b0e218.php
│   │   │   ├── 🐘 1f6f28ada5553c44383f888b8866edbc.php
│   │   │   ├── 🐘 2070f05d6fa72d208ce707d64c3187cf.php
│   │   │   ├── 🐘 223ff35cfc2f3b6a868c0a81ecc2d5ed.php
│   │   │   ├── 🐘 25559de93bb3f75197f65d31431cc854.php
│   │   │   ├── 🐘 25b0d221b0b3a2f9f0f84bf62ea8d4d3.php
│   │   │   ├── 🐘 26328897c1aa10f79e9e2d0d5329b82e.php
│   │   │   ├── 🐘 269b0fee0189e73c1136e66adf27750b.php
│   │   │   ├── 🐘 2cd01824a837fcbad18f4451278dfa3d.php
│   │   │   ├── 🐘 36e7918443d9960a525a81246d8c7970.php
│   │   │   ├── 🐘 419551074a50fbe34ef86a0e07ca7190.php
│   │   │   ├── 🐘 4ee3ab6db1fa8b9c29091a68e99cacf9.php
│   │   │   ├── 🐘 5087af5d64edde46f728b35be06b7035.php
│   │   │   ├── 🐘 508f1950e4e8efe8ee069df2bd0b7937.php
│   │   │   ├── 🐘 5d354b2893d50f9829507cb5db08ec2b.php
│   │   │   ├── 🐘 60db1e3a48454ed222d3563f1556a933.php
│   │   │   ├── 🐘 6718a7c479908e07da7b34c90b21582c.php
│   │   │   ├── 🐘 6ba13fe3feb1e91b2e1ad2bef44af903.php
│   │   │   ├── 🐘 6f7d30915538961ccb48e148b50dff1e.php
│   │   │   ├── 🐘 6f8dc7bde97ea89b8aa5e7e3c794d591.php
│   │   │   ├── 🐘 77e5874297b5e2755c4b2c711719b72b.php
│   │   │   ├── 🐘 79654808a81b7b6e1bc536931aec473c.php
│   │   │   ├── 🐘 7ab7d5c4b4b95b090d192a15c186d211.php
│   │   │   ├── 🐘 7b3bd2b65f1a4525a46d40f675c64c44.php
│   │   │   ├── 🐘 80206a5900f7d9f27081a913e0b15676.php
│   │   │   ├── 🐘 8200d78d1269662c2e1ba8b7bf12d0c9.php
│   │   │   ├── 🐘 877fecd6624682dc6dd40714d395260c.php
│   │   │   ├── 🐘 87edc39a90c57c9848cd7b2d6ed4cd69.php
│   │   │   ├── 🐘 8af96f1aa4ca539680bbb419b6450c05.php
│   │   │   ├── 🐘 8b77322ea40de4645844c2e3622c3810.php
│   │   │   ├── 🐘 8c2da46ec4c83d4f3a4a8806fe1bffb0.php
│   │   │   ├── 🐘 8d82578c6b7f2296eff92bdd034ec3f8.php
│   │   │   ├── 🐘 92b723efff48ff59a4baed38fab1e075.php
│   │   │   ├── 🐘 959c5cd7988d05248e5f95f9f4611ac9.php
│   │   │   ├── 🐘 95e3164b72bdaa6d9137dfc0a56b4aae.php
│   │   │   ├── 🐘 9745f6a6f3fcc1ddd95648c9a006bc71.php
│   │   │   ├── 🐘 9b6f00baea4740b6b87f01413a6f5ddc.php
│   │   │   ├── 🐘 a202868bb66eed136d25c8ec64eb89ec.php
│   │   │   ├── 🐘 a34d9827dfc8527753f9f7423a54e2cf.php
│   │   │   ├── 🐘 ac4c02a786db2cf28ea74e9136b850c9.php
│   │   │   ├── 🐘 affded853153289f369efb3d89e81856.php
│   │   │   ├── 🐘 b0160d9ee887b000436a549b742bcf73.php
│   │   │   ├── 🐘 b9bba494dff869a9d2ecea7a3b371b35.php
│   │   │   ├── 🐘 bae129cef9e600352d1c88ca55b5c61c.php
│   │   │   ├── 🐘 bb04908ad74416bffa86447ccc8af74d.php
│   │   │   ├── 🐘 bff06be78bce3fed83e9c65b8001e4b4.php
│   │   │   ├── 🐘 c30bce2ab2e7db924fb6024a52ab0a8a.php
│   │   │   ├── 🐘 c597eabc01b3b531b9dda87258a1b39e.php
│   │   │   ├── 🐘 cacad9aa301188bb671ec61542d90cdf.php
│   │   │   ├── 🐘 ccde63dd95671553f40eb4eb40d2b489.php
│   │   │   ├── 🐘 cfb3b0d08523933b25d0e9e498df3235.php
│   │   │   ├── 🐘 d1f36e3de69f0a26360ce06ac4b749a6.php
│   │   │   ├── 🐘 d54b4b1eb6bf70ee3b6a52e36ce7e503.php
│   │   │   ├── 🐘 d8023e53ca38edd3353749f456935467.php
│   │   │   ├── 🐘 d87da7e0a7843b2ff34479e8e216a9f9.php
│   │   │   ├── 🐘 dd310000961f2d208873a737c27d849a.php
│   │   │   ├── 🐘 de54b63ec3ab71aaa6d71eb783fbdb15.php
│   │   │   ├── 🐘 e042785c1ac6ad8a56dcc4e5b83bea34.php
│   │   │   ├── 🐘 ed53e6526bfb3c939b903194d34698dc.php
│   │   │   ├── 🐘 ed6d86ec5660851da9f9a0dad3f4f308.php
│   │   │   ├── 🐘 f188496d5460aa7137f13bb1da4b2db1.php
│   │   │   ├── 🐘 f497199d26d29b5bb4d0007bbb834737.php
│   │   │   ├── 🐘 f8bdec3cd7cf1a9c4ce8b885ddae0cd2.php
│   │   │   ├── 🐘 f905b6dee768cbfc0ad33952a263d185.php
│   │   │   └── 🐘 fa93212804ec7ca81b74e723e8d4bffc.php
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
├── 📝 Docker-README.md
├── 📝 README.md
├── 📄 artisan
├── ⚙️ composer.json
├── ⚙️ docker-compose.yml
├── 📝 login.md
├── ⚙️ package.json
├── ⚙️ phpunit.xml
└── 📄 vite.config.js
```

---