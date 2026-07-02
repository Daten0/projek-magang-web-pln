<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logbook;
use App\Models\ProfilPeserta;
use Carbon\Carbon;

class VerifikasiLogbookController extends Controller
{
    public function index(Request $request)
    {
        $user   = Auth::user();
        $profil = $user->profilMentor;

        $baseQuery = fn() => Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $profil->id));

        $totalMasuk     = $baseQuery()->count();
        $totalMenunggu  = $baseQuery()->where('status', 'Menunggu Verifikasi')->count();
        $totalDisetujui = $baseQuery()->where('status', 'Disetujui')->count();
        $totalRevisi    = $baseQuery()->where('status', 'Perlu Revisi')->count();

        $stats = [
            'total_masuk'         => $totalMasuk,
            'menunggu_verifikasi' => $totalMenunggu,
            'disetujui'           => $totalDisetujui,
            'perlu_revisi'        => $totalRevisi,
        ];

        // Daftar peserta untuk dropdown filter
        $pesertaList = ProfilPeserta::with('user')
            ->where('mentor_id', $profil->id)
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'nama' => $p->user->name ?? '-']);

        // Parameter filter dari query string
        $search      = $request->query('search', '');
        $filterStatus = $request->query('status', '');
        $filterPeserta = $request->query('peserta_id', '');
        $perPage     = 10;
        $halaman     = max(1, (int) $request->query('halaman', 1));

        // Query utama dengan filter
        $query = $baseQuery()->with('peserta.user');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('judul_aktivitas', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('peserta.user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($filterStatus !== '') {
            $query->where('status', $filterStatus);
        }

        if ($filterPeserta !== '') {
            $query->where('peserta_id', $filterPeserta);
        }

        $total        = $query->count();
        $totalHalaman = max(1, (int) ceil($total / $perPage));
        $halaman      = min($halaman, $totalHalaman);
        $offset       = ($halaman - 1) * $perPage;

        $logbookList = $query->orderBy('tanggal', 'desc')
            ->skip($offset)->take($perPage)->get()
            ->map(fn($l) => [
                'id'        => $l->id,
                'inisial'   => strtoupper(substr(str_replace(' ', '', $l->peserta->user->name ?? '-'), 0, 2)),
                'nama'      => $l->peserta->user->name ?? '-',
                'asal'      => $l->peserta->instansi ?? '-',
                'judul'     => $l->judul_aktivitas,
                'deskripsi' => $l->deskripsi,
                'tanggal'   => Carbon::parse($l->tanggal)->format('d M Y'),
                'foto'      => $l->peserta->foto,
                'status'    => $l->status,
            ]);

        $awal = $total > 0 ? $offset + 1 : 0;
        $akhir = min($offset + $perPage, $total);

        $pagination = [
            'awal'          => $awal,
            'akhir'         => $akhir,
            'total'         => $total,
            'total_halaman' => $totalHalaman,
            'halaman'       => $halaman,
        ];

        $topbarTitle = 'Verifikasi Logbook';

        return view('mentor.verifikasi-logbook', compact(
            'stats', 'logbookList', 'pagination', 'topbarTitle',
            'pesertaList', 'search', 'filterStatus', 'filterPeserta'
        ));
    }

public function show($id)
{
    $user   = Auth::user();
    $profil = $user->profilMentor;

    $l = Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $profil->id))
        ->with('peserta.user')
        ->findOrFail($id);

    // Riwayat logbook peserta ini
    $riwayat = Logbook::where('peserta_id', $l->peserta_id)
    ->orderByDesc('tanggal')->take(5)->get()
    ->map(fn($r) => [
        'id'      => $r->id,
        'tanggal' => \Carbon\Carbon::parse($r->tanggal)->format('d M Y'),
        'judul'   => $r->judul_aktivitas,
        'status'  => $r->status,
        'aktif'   => $r->id === $l->id,
    ]);

    $logbook = [
        'id'               => $l->id,
        'inisial'          => strtoupper(substr(str_replace(' ', '', $l->peserta->user->name ?? '-'), 0, 2)),
        'nama'             => $l->peserta->user->name ?? '-',
        'nim'              => $l->peserta->nim ?? '-',
        'divisi'           => $l->peserta->divisi ?? '-',
        'judul'            => $l->judul_aktivitas,
        'deskripsi'        => $l->deskripsi,
        'rincian'          => [],
        'penutup'          => '',
        'tanggal_aktivitas'=> \Carbon\Carbon::parse($l->tanggal)->format('d M Y'),
        'status'           => $l->status,
        'dokumentasi'      => $l->dokumentasi,
        'progres' => [
                    'total'        => Logbook::where('peserta_id', $l->peserta_id)->count(),
                    'terverifikasi'=> Logbook::where('peserta_id', $l->peserta_id)->where('status', 'Disetujui')->count(),
                ],
        'riwayat'          => $riwayat,
    ];
    return view('mentor.tinjau-logbook', compact('logbook'));
}

    public function setujui($id)
    {
        $user   = Auth::user();
        $profil = $user->profilMentor;

        $logbook = Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $profil->id))
            ->findOrFail($id);

        $logbook->update([
            'status'            => 'Disetujui',
            'catatan_mentor'    => null,
            'diverifikasi_oleh' => $user->id,
            'diverifikasi_pada' => Carbon::now(),
        ]);

        return back()->with('success', 'Logbook berhasil disetujui.');
    }

    public function mintaRevisi(Request $request, $id)
    {
        $user   = Auth::user();
        $profil = $user->profilMentor;

        $request->validate([
            'catatan_mentor' => 'required|string|max:500',
        ], [
            'catatan_mentor.required' => 'Catatan revisi wajib diisi.',
        ]);

        $logbook = Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $profil->id))
            ->findOrFail($id);

        $logbook->update([
            'status'            => 'Perlu Revisi',
            'catatan_mentor'    => $request->catatan_mentor,
            'diverifikasi_oleh' => $user->id,
            'diverifikasi_pada' => Carbon::now(),
        ]);

        return back()->with('success', 'Permintaan revisi berhasil dikirim.');
    }
}