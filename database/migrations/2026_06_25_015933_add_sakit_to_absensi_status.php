<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL tidak support ALTER COLUMN untuk enum langsung
        // jadi kita pakai DB statement
        \DB::statement("ALTER TABLE absensi MODIFY COLUMN status ENUM('Hadir', 'Izin', 'Sakit', 'Alfa') NOT NULL DEFAULT 'Hadir'");
    }

    public function down(): void
    {
        \DB::statement("ALTER TABLE absensi MODIFY COLUMN status ENUM('Hadir', 'Izin', 'Alfa') NOT NULL DEFAULT 'Hadir'");
    }
};