<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProfilPeserta;
use App\Models\Absensi;

class TandaiAlfaOtomatis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'absensi:tandai-alfa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menandai peserta yang belum absen hari ini (sebelum jam 15:00) sebagai Alfa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Skip kalau hari ini Sabtu atau Minggu
        if (now()->isWeekend()) {
            $this->info('Hari ini libur (Sabtu/Minggu). Tidak ada yang ditandai Alfa.');
            return;
        }

        // Skip kalau belum jam 15:00
        if (now()->format('H:i') < '15:00') {
            $this->info('Belum waktunya. Penandaan Alfa hanya berjalan setelah jam 15:00.');
            return;
        }

        $pesertaAktif = ProfilPeserta::where('status_magang', 'Aktif')
        ->whereHas('user', fn($q) => $q->where('status_pendaftaran', 'aktif'))
        ->get();
        $jumlahDitandai = 0;

        foreach ($pesertaAktif as $peserta) {
            $sudahAbsen = Absensi::where('peserta_id', $peserta->id)
                ->whereDate('tanggal', today())
                ->exists();

            if (!$sudahAbsen) {
                Absensi::create([
                    'peserta_id' => $peserta->id,
                    'tanggal'    => today(),
                    'status'     => 'Alfa',
                    'jam_masuk'  => null,
                    'jam_keluar' => null,
                ]);
                $jumlahDitandai++;
            }
        }

        $this->info($jumlahDitandai . ' peserta ditandai Alfa untuk tanggal ' . today()->format('d-m-Y') . '.');
    }
}