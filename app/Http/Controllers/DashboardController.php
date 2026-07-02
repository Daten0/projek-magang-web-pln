<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\Logbook;
use App\Models\LaporanAkhir;
use App\Models\PenilaianAkhir;
use App\Models\Sertifikat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        // Hitung hari magang
        $totalHari   = 0;
        $hariTersisa = 0;
        $periodeLabel = '-';

        if ($profil && $profil->periode_mulai && $profil->periode_selesai) {
            $mulai   = Carbon::parse($profil->periode_mulai);
            $selesai = Carbon::parse($profil->periode_selesai);
            $today   = Carbon::today();

            $totalHari    = $mulai->diffInDays($selesai);
            $hariTersisa  = $today->lessThan($selesai) ? $today->diffInDays($selesai) : 0;
            $periodeLabel = $mulai->format('d M Y') . ' – ' . $selesai->format('d M Y');

            // Durasi magang (berapa persen sudah berjalan)
            $hariBerjalan = $today->greaterThan($mulai)
                ? min($mulai->diffInDays($today), $totalHari)
                : 0;
            $durasiPersen = $totalHari > 0 ? round($hariBerjalan / $totalHari * 100) : 0;
        } else {
            $durasiPersen = 0;
        }

        // Statistik absensi
        $totalAbsensi = $profil ? Absensi::where('peserta_id', $profil->id)->count() : 0;
        $totalHadir   = $profil ? Absensi::where('peserta_id', $profil->id)->where('status', 'Hadir')->count() : 0;
        $persentaseKehadiran = $totalAbsensi > 0 ? round($totalHadir / $totalAbsensi * 100) : 0;

        // Statistik logbook
        $totalLogbook     = $profil ? Logbook::where('peserta_id', $profil->id)->count() : 0;
        $logbookDisetujui = $profil ? Logbook::where('peserta_id', $profil->id)->where('status', 'Disetujui')->count() : 0;
        $penyelesaianLogbook = $totalHari > 0 ? min(round($totalLogbook / $totalHari * 100), 100) : 0;

        // Laporan akhir
        $laporanAkhir = $profil ? LaporanAkhir::where('peserta_id', $profil->id)->first() : null;

        // Penilaian & sertifikat
        $penilaian      = $profil ? PenilaianAkhir::where('peserta_id', $profil->id)->first() : null;
        $sertifikatModel = $profil ? Sertifikat::where('peserta_id', $profil->id)->first() : null;

        // $stats
        $stats = [
            'status_magang'        => $profil->status_magang ?? 'Aktif',
            'total_hari_magang'    => $totalHari,
            'persentase_kehadiran' => $persentaseKehadiran,
            'status_kehadiran'     => $persentaseKehadiran >= 80 ? 'Baik' : ($persentaseKehadiran >= 60 ? 'Cukup' : 'Kurang'),
            'logbook_terkirim'     => $totalLogbook,
            'status_laporan_akhir' => $laporanAkhir ? ucfirst($laporanAkhir->status) : 'Belum Ada',
        ];

        // $progres (array asosiatif tunggal)
        $progres = [
            'periode'                 => $periodeLabel,
            'durasi_magang'           => $durasiPersen,
            'kehadiran_terverifikasi' => $persentaseKehadiran,
            'penyelesaian_logbook'    => $penyelesaianLogbook,
        ];

        // $sertifikat (array asosiatif)
        $sertifikat = [
            'instansi' => $profil->instansi ?? '-',
            'status'   => $sertifikatModel
                ? ($sertifikatModel->status === 'Terbit' ? 'Sertifikat Tersedia' : 'Belum Terbit')
                : 'Belum Tersedia',
        ];

        // $aktivitas terbaru
        $aktivitasLogbook = $profil ? Logbook::where('peserta_id', $profil->id)
            ->orderByDesc('created_at')->take(3)->get()
            ->map(fn($l) => [
                'tipe'  => 'logbook_sent',
                'judul' => 'Logbook "' . $l->judul_aktivitas . '" terkirim.',
                'waktu' => $l->created_at->diffForHumans(),
                'sort'  => $l->created_at,
            ]) : collect();

        $aktivitasAbsensi = $profil ? Absensi::where('peserta_id', $profil->id)
            ->orderByDesc('created_at')->take(2)->get()
            ->map(fn($a) => [
                'tipe'  => 'absensi',
                'judul' => 'Absensi ' . $a->status . ' tercatat pada ' . Carbon::parse($a->tanggal)->format('d M Y') . '.',
                'waktu' => $a->created_at->diffForHumans(),
                'sort'  => $a->created_at,
            ]) : collect();

        $aktivitas = $aktivitasLogbook->concat($aktivitasAbsensi)
            ->sortByDesc('sort')->take(5)->values();

        $hideTopbar = false;

        return view('Dashboard', compact(
            'user', 'profil', 'stats', 'progres', 'sertifikat', 'aktivitas', 'hideTopbar'
        ));
    }
}