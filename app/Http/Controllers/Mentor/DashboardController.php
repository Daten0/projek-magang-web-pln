<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Logbook;
use App\Models\LaporanAkhir;
use App\Models\PenilaianAkhir;
use App\Models\ProfilPeserta;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();

        // Semua peserta bimbingan mentor ini
        $profilMentor = $user->profilMentor;
        $pesertaIds = $profilMentor
            ? ProfilPeserta::where('mentor_id', $profilMentor->id)->pluck('id')
            : collect();

        $jumlahPeserta       = $pesertaIds->count();
        $jumlahLogbookMenunggu = Logbook::whereIn('peserta_id', $pesertaIds)
                                    ->where('status', 'Menunggu Verifikasi')->count();
        $penilaianBelum      = ProfilPeserta::where('mentor_id', $profilMentor->id)
                                    ->whereDoesntHave('penilaianAkhir', fn($q) =>
                                        $q->where('status_kelulusan', '!=', 'Belum Dinilai')
                                    )->count();
        $laporanBelum        = LaporanAkhir::whereIn('peserta_id', $pesertaIds)
                                    ->where('status', 'Review')->count();
        $pesertaAktif        = ProfilPeserta::where('mentor_id', $profilMentor->id)
                                    ->where('status_magang', 'Aktif')->count();

        $stats = [
            'jumlah_peserta'   => $jumlahPeserta,
            'logbook_menunggu' => $jumlahLogbookMenunggu,
            'penilaian_belum'  => $penilaianBelum,
            'laporan_belum'    => $laporanBelum,
            'peserta_aktif'    => $pesertaAktif,
        ];

        // Route urgent
        $antrian = [
            'mentor.verifikasi-logbook'       => $jumlahLogbookMenunggu,
            'mentor.penilaian-akhir'          => $penilaianBelum,
            'mentor.verifikasi-laporan-akhir' => $laporanBelum,
        ];
        $namaRouteUrgent = array_search(max($antrian), $antrian);
        $urgentRoute     = route($namaRouteUrgent);

        // Hal yang perlu perhatian
        $perhatian = [];
        if ($jumlahLogbookMenunggu > 0) {
            $perhatian[] = $jumlahLogbookMenunggu . ' logbook menunggu verifikasi';
        }
        if ($penilaianBelum > 0) {
            $perhatian[] = $penilaianBelum . ' peserta belum mendapatkan penilaian akhir';
        }
        if ($laporanBelum > 0) {
            $perhatian[] = $laporanBelum . ' laporan akhir belum diperiksa';
        }

        // Logbook menunggu verifikasi (untuk tabel di view)
        $logbookMenunggu = Logbook::whereIn('peserta_id', $pesertaIds)
            ->where('status', 'Menunggu Verifikasi')
            ->with('peserta.user')
            ->orderByDesc('created_at')
            ->take(5)
            ->get()
            ->map(fn($l) => [
                'nama'      => $l->peserta->user->name ?? '-',
                'tanggal'   => Carbon::parse($l->tanggal)->format('d M Y'),
                'aktivitas' => $l->judul_aktivitas,
                'status'    => 'PENDING VERIFIKASI',
                'id'        => $l->id,
            ]);

        // Aktivitas terbaru
        $aktivitasLogbook = Logbook::whereIn('peserta_id', $pesertaIds)
            ->with('peserta.user')
            ->orderByDesc('created_at')
            ->take(3)
            ->get()
            ->map(fn($l) => [
                'judul' => ($l->peserta->user->name ?? '-') . ' mengirim logbook harian baru.',
                'waktu' => $l->created_at->diffForHumans(),
                'sort'  => $l->created_at,
            ]);
        $aktivitasAbsensi = Absensi::whereIn('peserta_id', $pesertaIds)
            ->with('peserta.user')
            ->orderByDesc('created_at')
            ->take(2)
            ->get()
            ->map(fn($a) => [
                'judul' => ($a->peserta->user->name ?? '-') . ' melakukan absensi ' . $a->status . '.',
                'waktu' => $a->created_at->diffForHumans(),
                'sort'  => $a->created_at,
            ]);

        $aktivitasLaporan = LaporanAkhir::whereIn('peserta_id', $pesertaIds)
            ->with('peserta.user')
            ->orderByDesc('created_at')
            ->take(2)
            ->get()
            ->map(fn($l) => [
                'judul' => ($l->peserta->user->name ?? '-') . ' mengunggah laporan akhir.',
                'waktu' => $l->created_at->diffForHumans(),
                'sort'  => $l->created_at,
            ]);

        $aktivitasPenilaian = PenilaianAkhir::whereIn('peserta_id', $pesertaIds)
            ->with('peserta.user')
            ->orderByDesc('updated_at')
            ->take(2)
            ->get()
            ->map(fn($p) => [
                'judul' => 'Penilaian akhir ' . ($p->peserta->user->name ?? '-') . ' telah diisi.',
                'waktu' => $p->updated_at->diffForHumans(),
                'sort'  => $p->updated_at,
            ]);

        $aktivitas = $aktivitasLogbook
            ->concat($aktivitasAbsensi)
            ->concat($aktivitasLaporan)
            ->concat($aktivitasPenilaian)
            ->sortByDesc('sort')
            ->take(4)
            ->values()
            ->map(fn($a) => ['judul' => $a['judul'], 'waktu' => $a['waktu']]);

        // Daftar anak bimbingan
        $anakBimbingan = ProfilPeserta::where('mentor_id', $profilMentor->id)
            ->with('user')
            ->take(3)
            ->get()
            ->map(fn($p) => [
                'inisial' => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
                'nama'    => $p->user->name ?? '-',
                'asal'    => $p->instansi ?? '-',
                'divisi'  => $p->divisi ?? '-',
                'status'  => strtoupper($p->status_magang),
            ]);

        // Progress rata-rata
        $totalPeserta    = max($jumlahPeserta, 1);
        $totalAbsensi    = Absensi::whereIn('peserta_id', $pesertaIds)->count();
        $hadirAbsensi    = Absensi::whereIn('peserta_id', $pesertaIds)->where('status', 'Hadir')->count();
        $rataKehadiran   = $totalAbsensi > 0 ? round($hadirAbsensi / $totalAbsensi * 100) : 0;

        $totalLogbook     = Logbook::whereIn('peserta_id', $pesertaIds)->count();
        $disetujuiLogbook = Logbook::whereIn('peserta_id', $pesertaIds)->where('status', 'Disetujui')->count();
        $rataLogbook      = $totalLogbook > 0 ? round($disetujuiLogbook / $totalLogbook * 100) : 0;

        $totalLaporan  = LaporanAkhir::whereIn('peserta_id', $pesertaIds)->count();
        $rataLaporan   = round($totalLaporan / $totalPeserta * 100);

        $sudahDinilai  = PenilaianAkhir::whereIn('peserta_id', $pesertaIds)
                             ->where('status_kelulusan', '!=', 'Belum Dinilai')->count();
        $rataPenilaian = round($sudahDinilai / $totalPeserta * 100);

        $progress = [
            ['label' => 'Kehadiran (Rata-rata)', 'persen' => $rataKehadiran, 'warna' => 'bg-blue-600'],
            ['label' => 'Kelengkapan Logbook',   'persen' => $rataLogbook,   'warna' => 'bg-amber-400'],
            ['label' => 'Laporan Akhir',          'persen' => $rataLaporan,   'warna' => 'bg-blue-600'],
            ['label' => 'Penilaian Akhir',        'persen' => $rataPenilaian, 'warna' => 'bg-amber-400'],
        ];

        $hideTopbar = true;

        return view('mentor.dashboard', compact(
            'user', 'stats', 'urgentRoute', 'perhatian',
            'logbookMenunggu', 'aktivitas', 'anakBimbingan',
            'progress', 'hideTopbar'
        ));
    }
}