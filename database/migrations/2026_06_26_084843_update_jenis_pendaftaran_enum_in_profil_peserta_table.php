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
        DB::statement("ALTER TABLE profil_peserta MODIFY COLUMN jenis_pendaftaran 
            ENUM('Praktik Industri', 'Kerja Praktek', 'Magang Kampus Merdeka', 'PKL', 'KKN', 'Magang Mandiri') 
            NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE profil_peserta MODIFY COLUMN jenis_pendaftaran 
            ENUM('Praktik Industri', 'KKN', 'Magang Mandiri') 
            NULL");
    }
};
