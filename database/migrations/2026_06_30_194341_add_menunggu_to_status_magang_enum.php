<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE profil_peserta MODIFY status_magang ENUM('Menunggu','Aktif','Selesai','Tidak Aktif') NOT NULL DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE profil_peserta MODIFY status_magang ENUM('Aktif','Selesai','Tidak Aktif') NOT NULL DEFAULT 'Aktif'");
    }
};