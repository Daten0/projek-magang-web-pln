<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY status_pendaftaran ENUM('menunggu','ditolak','aktif','nonaktif') NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY status_pendaftaran ENUM('menunggu','ditolak','aktif') NOT NULL DEFAULT 'menunggu'");
    }
};