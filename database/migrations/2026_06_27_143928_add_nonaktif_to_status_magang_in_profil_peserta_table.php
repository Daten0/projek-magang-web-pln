<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    DB::statement("ALTER TABLE profil_peserta MODIFY COLUMN status_magang 
        ENUM('Aktif', 'Selesai', 'Bermasalah', 'Menunggu Penilaian', 'Nonaktif') 
        NULL DEFAULT NULL");
}

public function down(): void
{
    DB::statement("ALTER TABLE profil_peserta MODIFY COLUMN status_magang 
        ENUM('Aktif', 'Selesai', 'Bermasalah', 'Menunggu Penilaian') 
        NULL DEFAULT NULL");
}
};
