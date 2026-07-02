<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPeserta;
use App\Models\Absensi;
use App\Models\Logbook;
use App\Models\LaporanAkhir;
use Illuminate\Support\Carbon;

class MonitoringController extends Controller
{
    public function index()
    {
        $stats = [
            'total_peserta_aktif' => ProfilPeserta::whereHas('user', fn($q) => 
        $q->where('status_pendaftaran', 'aktif'))
        ->where('status_magang', 'Aktif')->count(),
                'hadir_hari_ini'      => Absensi::whereDate('tanggal', today())->where('status', 'Hadir')->count(),
                'verifikasi_logbook'  => Logbook::where('status', 'Menunggu Verifikasi')->count(),
                'laporan_akhir'       => LaporanAkhir::where('status', 'Review')->count(),
                'selesai_magang'      => ProfilPeserta::where('status_magang', 'Selesai')->count(),
                'sertifikat_siap'     => ProfilPeserta::whereHas('penilaianAkhir', function ($q) {
                                            $q->where('status_kelulusan', 'Lulus');
                                        })->where(function ($q) {
                                            $q->whereDoesntHave('sertifikat')
                                                ->orWhereHas('sertifikat', fn ($q2) => $q2->where('status', 'Belum Terbit'));
                                        })->count(),
        ];

        $totalHadir = Absensi::where('status', 'Hadir')->count();
        $totalIzin  = Absensi::where('status', 'Izin')->count();
        $totalSakit = Absensi::where('status', 'Sakit')->count();
        $totalAlfa  = Absensi::where('status', 'Alfa')->count();
        $totalAbsen = $totalHadir + $totalIzin + $totalSakit + $totalAlfa;

        $kehadiran = [
            'persen' => $totalAbsen > 0 ? round($totalHadir / $totalAbsen * 100) : 0,
            'hadir'  => $totalHadir,
            'izin'   => $totalIzin,
            'sakit'  => $totalSakit,
            'alfa'   => $totalAlfa,
        ];

        $logbook = [
            'total'     => Logbook::count(),
            'disetujui' => Logbook::where('status', 'Disetujui')->count(),
            'menunggu'  => Logbook::where('status', 'Menunggu Verifikasi')->count(),
            'direvisi'  => Logbook::where('status', 'Perlu Revisi')->count(),
        ];

            $pesertaPaginator = ProfilPeserta::with(['user', 'profilMentor.user'])
        ->whereHas('user', fn($q) => $q->where('status_pendaftaran', 'aktif'))
        ->whereIn('status_magang', ['Aktif', 'Selesai', 'Tidak Aktif'])
        ->paginate(10);

        $pesertaList = $pesertaPaginator->map(function ($p) {
            $totalAbsensiPeserta = $p->absensi()->count();
            $hadirPeserta        = $p->absensi()->where('status', 'Hadir')->count();
            $totalLogbookPeserta = $p->logbook()->count();
            $disetujuiPeserta    = $p->logbook()->where('status', 'Disetujui')->count();

            return [
                'id'        => $p->id,
                'inisial'   => strtoupper(substr($p->user->name ?? '-', 0, 2)),
                'foto'      => $p->foto,
                'nama'      => $p->user->name ?? '-',
                'email'     => $p->user->email ?? '-',
                'divisi'    => $p->divisi ?? '-',
                'mentor' => optional(optional($p->profilMentor)->user)->name ?? '-',
                'kehadiran' => $totalAbsensiPeserta > 0 ? round($hadirPeserta / $totalAbsensiPeserta * 100) : 0,
                'logbook'   => $disetujuiPeserta . '/' . $totalLogbookPeserta,
                'laporan'   => $p->laporanAkhir->status ?? 'Belum Ada',
                'status'    => $p->status_magang,
            ];
        });

        $pagination = [
            'menampilkan'   => $pesertaPaginator->firstItem() . '-' . $pesertaPaginator->lastItem(),
            'total'         => $pesertaPaginator->total(),
            'halaman'       => $pesertaPaginator->currentPage(),
            'total_halaman' => $pesertaPaginator->lastPage(),
        ];

        $circumference = round(2 * M_PI * 54, 4);

        $hadirLen  = $totalAbsen > 0 ? round(($kehadiran['hadir']  / $totalAbsen) * $circumference, 4) : 0;
        $izinLen   = $totalAbsen > 0 ? round(($kehadiran['izin']   / $totalAbsen) * $circumference, 4) : 0;
        $sakitLen  = $totalAbsen > 0 ? round(($kehadiran['sakit']  / $totalAbsen) * $circumference, 4) : 0;
        $alfaLen   = $totalAbsen > 0 ? round(($kehadiran['alfa']   / $totalAbsen) * $circumference, 4) : 0;

        $totalLogbookUtkDonut = $logbook['disetujui'] + $logbook['menunggu'] + $logbook['direvisi'];
        $disetujuiLen = $totalLogbookUtkDonut > 0 ? round(($logbook['disetujui'] / $totalLogbookUtkDonut) * $circumference, 4) : 0;
        $menungguLen  = $totalLogbookUtkDonut > 0 ? round(($logbook['menunggu']  / $totalLogbookUtkDonut) * $circumference, 4) : 0;
        $direvisiLen  = $totalLogbookUtkDonut > 0 ? round(($logbook['direvisi']  / $totalLogbookUtkDonut) * $circumference, 4) : 0;

        return view('admin.monitoring', compact(
            'stats', 'kehadiran', 'logbook', 'pesertaList', 'pagination',
            'circumference',
            'hadirLen', 'izinLen', 'sakitLen', 'alfaLen',
            'disetujuiLen', 'menungguLen', 'direvisiLen'
        ));
    }

    public function show($id)
    {
        $p = ProfilPeserta::with([
    'user',
    'profilMentor',
    'laporanAkhir',
    'penilaianAkhir',
    'sertifikat'
])->findOrFail($id);

        $totalAbsensi = $p->absensi()->count();
        $totalHadir   = $p->absensi()->where('status', 'Hadir')->count();
        $totalLogbook = $p->logbook()->count();
        $logbookOk    = $p->logbook()->where('status', 'Disetujui')->count();

        $progresStep = 1; // Pendaftaran Diterima
        if ($p->profilMentor) $progresStep = 2; // Mentor Ditentukan
        if ($totalLogbook > 0) $progresStep = 3; // Logbook Berjalan
        if ($p->laporanAkhir) $progresStep = 4; // Laporan Akhir Diunggah
        if ($p->penilaianAkhir && $p->penilaianAkhir->status_kelulusan !== 'Belum Dinilai') $progresStep = 5; // Penilaian Mentor
        if ($p->sertifikat && $p->sertifikat->status === 'Terbit') $progresStep = 6; // Sertifikat Diterbitkan
        if ($p->sertifikat && $p->sertifikat->status === 'Terbit') $progresStep = 7; // semua selesai
        
        $periode = ($p->periode_mulai ? Carbon::parse($p->periode_mulai)->translatedFormat('M Y') : '-')
            . ' - ' .
            ($p->periode_selesai ? Carbon::parse($p->periode_selesai)->translatedFormat('M Y') : '-');

        $peserta = [
            'id'                => $p->id,
            'nama'              => $p->user->name ?? '-',
            'foto'              => $p->foto ?? null,
            'foto_inisial'      => strtoupper(substr($p->user->name ?? '-', 0, 2)),
            'posisi'            => 'Intern - ' . ($p->jurusan ?? '-'),
            'instansi'          => $p->instansi ?? '-',
            'mentor' => optional(optional($p->profilMentor)->user)->name ?? '-',
            'periode'           => $periode,
            'kehadiran'         => $totalAbsensi > 0 ? round($totalHadir / $totalAbsensi * 100) : 0,
            'logbook_terisi'    => $totalLogbook,
            'logbook_total'     => $totalLogbook,
            'logbook_disetujui' => $logbookOk,
            'laporan_akhir'     => $p->laporanAkhir->status ?? 'Belum Ada',
            'penilaian_mentor'  => ($p->penilaianAkhir && $p->penilaianAkhir->status_kelulusan !== 'Belum Dinilai') ? 'Selesai' : 'Terkunci',
            'sertifikat'        => $p->sertifikat->status ?? 'Belum Terbit',
            'progres_step'      => $progresStep,
        ];

        $ringkasanLogbook = $p->logbook()
            ->orderByDesc('tanggal')
            ->take(3)
            ->get()
            ->map(fn ($l) => [
                'tanggal'  => Carbon::parse($l->tanggal)->translatedFormat('d M Y'),
                'kegiatan' => $l->judul_aktivitas,
                'status'   => $l->status,
            ]);

        $ringkasanAbsensi = $p->absensi()
            ->orderByDesc('tanggal')
            ->take(3)
            ->get()
            ->map(fn ($a) => [
                'hari_tanggal' => Carbon::parse($a->tanggal)->translatedFormat('l, d M Y'),
                'jam_masuk'    => $a->jam_masuk ?? '-',
                'jam_keluar'   => $a->jam_keluar ?? '-',
                'status'       => $a->status,
            ]);

        // Semua logbook peserta
$semuaLogbook = $p->logbook()
    ->orderByDesc('tanggal')
    ->get()
    ->map(fn($l) => [
        'tanggal'  => Carbon::parse($l->tanggal)->translatedFormat('d M Y'),
        'kegiatan' => $l->judul_aktivitas,
        'deskripsi'=> $l->deskripsi,
        'status'   => $l->status,
    ]);

// Semua absensi peserta
$semuaAbsensi = $p->absensi()
    ->orderByDesc('tanggal')
    ->get()
    ->map(fn($a) => [
        'tanggal'   => Carbon::parse($a->tanggal)->translatedFormat('d M Y'),
        'jam_masuk' => $a->jam_masuk ?? '-',
        'jam_keluar'=> $a->jam_keluar ?? '-',
        'status'    => $a->status,
        'keterangan'=> $a->keterangan ?? '-',
    ]);

        $riwayatLogbook = $p->logbook()->orderByDesc('created_at')->take(3)->get()->map(fn ($l) => [
            'tipe'  => 'logbook',
            'teks'  => ($p->user->name ?? '-') . ' mengirim logbook untuk tanggal ' . Carbon::parse($l->tanggal)->translatedFormat('d M') . '.',
            'waktu' => $l->created_at->diffForHumans(),
            'warna' => 'blue',
            'sort'  => $l->created_at,
        ]);

        $riwayatAbsensi = $p->absensi()->orderByDesc('created_at')->take(3)->get()->map(fn ($a) => [
            'tipe'  => 'absensi',
            'teks'  => 'Presensi ' . $a->status . ' tercatat untuk tanggal ' . Carbon::parse($a->tanggal)->translatedFormat('d M') . '.',
            'waktu' => $a->created_at->diffForHumans(),
            'warna' => $a->status === 'Hadir' ? 'green' : 'slate',
            'sort'  => $a->created_at,
        ]);

        $riwayatLaporan = $p->laporanAkhir ? collect([[
            'tipe'  => 'laporan',
            'teks'  => $p->user->name . ' mengunggah laporan akhir.',
            'waktu' => $p->laporanAkhir->updated_at->diffForHumans(),
            'warna' => 'purple',
            'sort'  => $p->laporanAkhir->updated_at,
        ]]) : collect();

        $riwayatPenilaian = $p->penilaianAkhir ? collect([[
            'tipe'  => 'penilaian',
            'teks'  => 'Penilaian akhir ' . $p->user->name . ' telah diisi.',
            'waktu' => $p->penilaianAkhir->updated_at->diffForHumans(),
            'warna' => 'amber',
            'sort'  => $p->penilaianAkhir->updated_at,
        ]]) : collect();

        $riwayatAktivitas = $riwayatLogbook
            ->concat($riwayatAbsensi)
            ->concat($riwayatLaporan)
            ->concat($riwayatPenilaian)
            ->sortByDesc('sort')
            ->take(4)
            ->values();

        return view('admin.monitoring-detail', compact(
        'peserta', 'ringkasanLogbook', 'ringkasanAbsensi', 
        'riwayatAktivitas', 'semuaLogbook', 'semuaAbsensi'
    ));
    }
}