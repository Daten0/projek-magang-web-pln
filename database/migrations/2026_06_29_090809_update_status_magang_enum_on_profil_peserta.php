<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Langkah 1: perluas dulu enum supaya menampung nilai lama + nilai baru sekaligus,
        // supaya proses pindah data di langkah 2 tidak ditolak database.
        DB::statement("ALTER TABLE profil_peserta MODIFY status_magang ENUM('Aktif','Selesai','Bermasalah','Menunggu Penilaian','Tidak Aktif') NOT NULL DEFAULT 'Aktif'");

        // Langkah 2: pindahkan data lama ke nilai baru.
        DB::table('profil_peserta')
            ->whereIn('status_magang', ['Bermasalah', 'Menunggu Penilaian'])
            ->update(['status_magang' => 'Tidak Aktif']);

        // Langkah 3: baru persempit enum jadi cuma 3 pilihan final.
        DB::statement("ALTER TABLE profil_peserta MODIFY status_magang ENUM('Aktif','Selesai','Tidak Aktif') NOT NULL DEFAULT 'Aktif'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE profil_peserta MODIFY status_magang ENUM('Aktif','Selesai','Bermasalah','Menunggu Penilaian') NOT NULL DEFAULT 'Aktif'");
    }
};