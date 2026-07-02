<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilPeserta;
use App\Models\ProfilMentor;
use App\Models\Absensi;
use App\Models\Logbook;
use App\Models\LaporanAkhir;
use App\Models\Sertifikat;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== STAT CARDS =====
        $stats = [
            'total_peserta' => User::where('role', 'peserta')->where('status_pendaftaran', 'aktif')->count(),
            'mentor_aktif' => User::where('role', 'mentor')
                        ->where('status_pendaftaran', 'aktif')
                        ->count(),
            'menunggu'      => User::where('role', 'peserta')->where('status_pendaftaran', 'menunggu')->count(),
            'aktif' => ProfilPeserta::whereHas('user', function($q) {
                $q->where('status_pendaftaran', 'aktif');
            })->where('status_magang', 'Aktif')->count(),
            'logbook'       => Logbook::where('status', 'Menunggu Verifikasi')->count(),
            'sertifikat'    => Sertifikat::where('status', 'Terbit')->count(),
        ];

        // ===== PENDAFTARAN TERBARU =====
        $pendaftaranTerbaru = User::where('role', 'peserta')
            ->where('status_pendaftaran', 'menunggu')
            ->with('profilPeserta')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'inisial'  => strtoupper(substr(str_replace(' ', '', $u->name ?? '-'), 0, 2)),
                'nama'     => $u->name ?? '-',
                'instansi' => $u->profilPeserta->instansi ?? '-',
                'tanggal'  => $u->created_at->format('d M Y'),
                'status'   => 'Pending',
                'id'       => $u->id,
            ]);

        // ===== PESERTA AKTIF =====
        $pesertaAktif = User::where('role', 'peserta')
            ->where('status_pendaftaran', 'aktif')
            ->with('profilPeserta.profilMentor.user')
            ->latest()
            ->take(5)
            ->get();

        // ===== MONITORING MAGANG =====
        $totalPeserta  = max(ProfilPeserta::count(), 1);
        $totalAbsensi  = Absensi::count();
        $hadirAbsensi  = Absensi::where('status', 'Hadir')->count();
        $totalLogbook  = Logbook::count();
        $logbookOk     = Logbook::where('status', 'Disetujui')->count();
        $totalLaporan  = LaporanAkhir::count();

        $monitoring = [
            [
                'label'  => 'Kehadiran Peserta',
                'persen' => $totalAbsensi > 0 ? round($hadirAbsensi / $totalAbsensi * 100) : 0,
                'warna'  => 'bg-blue-500',
            ],
            [
                'label'  => 'Kelengkapan Logbook',
                'persen' => $totalLogbook > 0 ? round($logbookOk / $totalLogbook * 100) : 0,
                'warna'  => 'bg-amber-400',
            ],
            [
                'label'  => 'Laporan Akhir',
                'persen' => round($totalLaporan / $totalPeserta * 100),
                'warna'  => 'bg-blue-500',
            ],
        ];

        // ===== AKTIVITAS TERBARU =====
        
        // Aktivitas: pendaftaran baru
        $aktPendaftaran = User::where('role', 'peserta')
            ->latest()
            ->take(5)
            ->get()
            ->map(fn($u) => [
                'judul'      => $u->name . ' mendaftar sebagai peserta magang.',
                'waktu'      => $u->created_at->diffForHumans(),
                'waktu_sort' => $u->created_at,
                'warna'      => $u->status_pendaftaran === 'aktif' ? 'bg-green-400' : 'bg-amber-400',
            ]);

        // Aktivitas: logbook masuk
        $aktLogbook = Logbook::with('peserta.user')
            ->orderByDesc('created_at')->take(5)->get()
            ->map(fn($l) => [
                'judul'      => ($l->peserta->user->name ?? '-') . ' mengirim logbook baru.',
                'waktu'      => $l->created_at->diffForHumans(),
                'waktu_sort' => $l->created_at,
                'warna'      => 'bg-blue-400',
            ]);

        // Aktivitas: absensi
        $aktAbsensi = Absensi::with('peserta.user')
            ->orderByDesc('created_at')->take(5)->get()
            ->map(fn($a) => [
                'judul'      => ($a->peserta->user->name ?? '-') . ' melakukan absensi ' . $a->status . '.',
                'waktu'      => $a->created_at->diffForHumans(),
                'waktu_sort' => $a->created_at,
                'warna'      => $a->status === 'Hadir' ? 'bg-green-400' : 'bg-amber-400',
            ]);

        // Aktivitas: laporan akhir
        $aktLaporan = LaporanAkhir::with('peserta.user')
            ->orderByDesc('created_at')->take(5)->get()
            ->map(fn($l) => [
                'judul'      => ($l->peserta->user->name ?? '-') . ' mengunggah laporan akhir.',
                'waktu'      => $l->created_at->diffForHumans(),
                'waktu_sort' => $l->created_at,
                'warna'      => 'bg-purple-400',
            ]);

        // Aktivitas: penilaian akhir
        $aktPenilaian = \App\Models\PenilaianAkhir::with('peserta.user')
            ->orderByDesc('updated_at')->take(5)->get()
            ->map(fn($p) => [
                'judul'      => 'Penilaian akhir ' . ($p->peserta->user->name ?? '-') . ' telah diisi.',
                'waktu'      => $p->updated_at->diffForHumans(),
                'waktu_sort' => $p->updated_at,
                'warna'      => 'bg-amber-500',
            ]);

        $aktivitasTerbaru = $aktPendaftaran
            ->concat($aktLogbook)
            ->concat($aktAbsensi)
            ->concat($aktLaporan)
            ->concat($aktPenilaian)
            ->sortByDesc('waktu_sort')
            ->take(5)
            ->values()
            ->map(fn($a) => ['judul' => $a['judul'], 'waktu' => $a['waktu'], 'warna' => $a['warna']]);

        $hideTopbar = true;

        return view('admin.dashboard', compact(
            'stats',
            'pendaftaranTerbaru',
            'pesertaAktif',
            'monitoring',
            'aktivitasTerbaru',
            'hideTopbar'
        ));
    }
}