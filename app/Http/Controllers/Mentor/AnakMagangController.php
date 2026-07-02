<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ProfilPeserta;
use App\Models\Absensi;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnakMagangController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $profilMentor = $user->profilMentor;

        $pesertaBimbingan = ProfilPeserta::with(['user', 'penilaianAkhir'])
            ->where('mentor_id', $profilMentor ? $profilMentor->id : 0)
            ->get();

        $stats = [
            'jumlah_peserta' => $pesertaBimbingan->count(),
            'peserta_aktif'  => $pesertaBimbingan->where('status_magang', 'Aktif')->count(),
            'magang_selesai' => $pesertaBimbingan->where('status_magang', 'Selesai')->count(),
            'tidak_aktif' => $pesertaBimbingan->where('status_magang', 'Tidak Aktif')->count(),
        ];

        $instansiList = $pesertaBimbingan->pluck('instansi')->filter()->unique()->values();

        // Peserta yang dipilih untuk panel detail
        $selectedId = (int) $request->query('peserta', $pesertaBimbingan->first()?->id);

        // Map ke array untuk tabel
        $pesertaList = $pesertaBimbingan->map(fn($p) => [
            'id'       => $p->id,
            'inisial'  => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
            'foto'     => $p->foto,
            'nama'     => $p->user->name ?? '-',
            'instansi' => $p->instansi ?? '-',
            'jurusan'  => $p->jurusan ?? '-',
            'periode'  => ($p->periode_mulai && $p->periode_selesai)
                ? Carbon::parse($p->periode_mulai)->format('d M Y') . ' – ' . Carbon::parse($p->periode_selesai)->format('d M Y')
                : '-',
            'status'   => $p->status_magang ?? 'Tidak Aktif',
            'selected' => $p->id == $selectedId,
        ]);

        $pagination = [
            'menampilkan'   => $pesertaList->count(),
            'total'         => $pesertaList->count(),
            'total_halaman' => 1,
            'halaman'       => 1,
        ];

        // Panel detail peserta terpilih
        $detail = null;
        if ($selectedId) {
            $peserta = $pesertaBimbingan->firstWhere('id', $selectedId);

            if ($peserta) {
                $totalAbsensi = $peserta->absensi()->count();
                $totalHadir   = $peserta->absensi()->where('status', 'Hadir')->count();
                $totalLogbook = $peserta->logbook()->count();
                $logbookOk    = $peserta->logbook()->where('status', 'Disetujui')->count();

                $persen_kehadiran = $totalAbsensi > 0 ? round($totalHadir / $totalAbsensi * 100) : 0;
                $persen_logbook   = $totalLogbook > 0 ? round($logbookOk / $totalLogbook * 100) : 0;

                // Aktivitas terbaru
                // Aktivitas terbaru
                $aktLogbook = Logbook::where('peserta_id', $peserta->id)
                    ->orderByDesc('created_at')->take(4)->get()
                    ->map(fn($l) => [
                        'judul'      => 'Logbook "' . $l->judul_aktivitas . '" dikirim.',
                        'waktu'      => $l->created_at->diffForHumans(),
                        'waktu_sort' => $l->created_at,
                        'warna'      => 'bg-blue-400',
                    ]);

                $aktAbsensi = Absensi::where('peserta_id', $peserta->id)
                    ->orderByDesc('created_at')->take(4)->get()
                    ->map(fn($a) => [
                        'judul'      => 'Absensi ' . $a->status . ' tercatat.',
                        'waktu'      => $a->created_at->diffForHumans(),
                        'waktu_sort' => $a->created_at,
                        'warna'      => $a->status === 'Hadir' ? 'bg-green-400' : 'bg-amber-400',
                    ]);

                $aktLaporan = \App\Models\LaporanAkhir::where('peserta_id', $peserta->id)
                    ->orderByDesc('created_at')->take(2)->get()
                    ->map(fn($l) => [
                        'judul'      => 'Laporan akhir diunggah.',
                        'waktu'      => $l->created_at->diffForHumans(),
                        'waktu_sort' => $l->created_at,
                        'warna'      => 'bg-purple-400',
                    ]);

                $aktPenilaian = \App\Models\PenilaianAkhir::where('peserta_id', $peserta->id)
                    ->orderByDesc('updated_at')->take(2)->get()
                    ->map(fn($p) => [
                        'judul'      => 'Penilaian akhir telah diisi.',
                        'waktu'      => $p->updated_at->diffForHumans(),
                        'waktu_sort' => $p->updated_at,
                        'warna'      => 'bg-amber-500',
                    ]);

                $aktivitas = $aktLogbook
                    ->concat($aktAbsensi)
                    ->concat($aktLaporan)
                    ->concat($aktPenilaian)
                    ->sortByDesc('waktu_sort')->take(4)->values();

                $detail = [
                    'nama'     => $peserta->user->name ?? '-',
                    'posisi'   => $peserta->jenis_pendaftaran ?? '-',
                    'progress' => [
                        ['label' => 'Kehadiran',  'persen' => $persen_kehadiran, 'warna' => 'bg-blue-500'],
                        ['label' => 'Logbook',    'persen' => $persen_logbook,   'warna' => 'bg-amber-400'],
                    ],
                    'aktivitas' => $aktivitas->isEmpty()
                        ? [['judul' => 'Belum ada aktivitas.', 'waktu' => '-', 'warna' => 'bg-slate-300']]
                        : $aktivitas->toArray(),
                ];
            }
        }

        // Fallback kalau tidak ada peserta sama sekali
        if (!$detail) {
            $detail = [
                'nama'      => '-',
                'posisi'    => '-',
                'progress'  => [
                    ['label' => 'Kehadiran', 'persen' => 0, 'warna' => 'bg-blue-500'],
                    ['label' => 'Logbook',   'persen' => 0, 'warna' => 'bg-amber-400'],
                ],
                'aktivitas' => [['judul' => 'Belum ada aktivitas.', 'waktu' => '-', 'warna' => 'bg-slate-300']],
            ];
        }

        $hideTopbar = false;

        return view('mentor.anak-magang', compact(
            'stats', 'pesertaList', 'detail', 'selectedId',
            'instansiList', 'pagination', 'hideTopbar'
        ));
    }
}