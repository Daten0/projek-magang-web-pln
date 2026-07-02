<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ProfilPeserta;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PenilaianAkhirController extends Controller
{
    private function getMentorId()
    {
        return Auth::user()->profilMentor->id ?? 0;
    }

    private function pesertaBimbingan()
    {
        return ProfilPeserta::with(['user', 'penilaianAkhir', 'absensi', 'logbook'])
            ->where('mentor_id', $this->getMentorId());
    }

    public function index()
    {
        $semua = $this->pesertaBimbingan()->get();

        $stats = [
            'total_bimbingan' => $semua->count(),
            'belum_dinilai'   => $semua->filter(fn($p) =>
                !$p->penilaianAkhir || $p->penilaianAkhir->status_kelulusan === 'Belum Dinilai'
            )->count(),
            'sudah_dinilai'   => $semua->filter(fn($p) =>
                $p->penilaianAkhir && $p->penilaianAkhir->status_kelulusan !== 'Belum Dinilai'
            )->count(),
            'menunggu'        => $semua->filter(fn($p) => !$p->penilaianAkhir)->count(),
        ];

        $pesertaList = $semua->map(fn($p) => [
            'id'      => $p->id,
            'inisial' => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
            'nama'    => $p->user->name ?? '-',
            'divisi'  => $p->divisi ?? '-',
            'foto'    => $p->foto,
            'periode' => ($p->periode_mulai && $p->periode_selesai)
                ? Carbon::parse($p->periode_mulai)->format('d M Y') . ' – ' . Carbon::parse($p->periode_selesai)->format('d M Y')
                : '-',
            'status'  => ($p->penilaianAkhir && $p->penilaianAkhir->status_kelulusan !== 'Belum Dinilai')
                ? 'Sudah Dinilai'
                : 'Belum Dinilai',
        ]);

        $pagination = [
            'awal'          => $pesertaList->count() > 0 ? 1 : 0,
            'akhir'         => $pesertaList->count(),
            'total'         => $pesertaList->count(),
            'total_halaman' => 1,
            'halaman'       => 1,
        ];

        return view('mentor.penilaian-akhir', compact('stats', 'pesertaList', 'pagination'));
    }

    public function show($id)
    {
        $p = $this->pesertaBimbingan()->findOrFail($id);

        $totalAbsensi = $p->absensi()->count();
        $totalHadir   = $p->absensi()->where('status', 'Hadir')->count();
        $totalLogbook = $p->logbook()->count();
        $logbookOk    = $p->logbook()->where('status', 'Disetujui')->count();

        // Nilai existing (kalau sudah pernah dinilai)
        $existing = $p->penilaianAkhir;

        $peserta = [
            'id'               => $p->id,
            'inisial'          => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
            'nama'             => $p->user->name ?? '-',
            'universitas'      => $p->instansi ?? '-',
            'divisi'           => $p->divisi ?? '-',
            'kehadiran'        => $totalAbsensi > 0 ? round($totalHadir / $totalAbsensi * 100) : 0,
            'logbook_disetujui'=> $logbookOk,
            'laporan_akhir'    => $p->laporanAkhir ? $p->laporanAkhir->status : 'Belum Ada',
            'catatan'          => $existing->catatan ?? '',
            'nilai' => [
                'kinerja'     => $existing->nilai_laporan_akhir ?? 75,
                'sikap'       => $existing->nilai_sikap ?? 75,
                'komunikasi'  => $existing->nilai_logbook ?? 75,
                'kerjasama'   => $existing->nilai_kehadiran ?? 75,
            ],
        ];

        return view('mentor.penilaian-akhir-detail', compact('peserta'));
    }

    public function store(Request $request, $id)
    {
        $p = $this->pesertaBimbingan()->findOrFail($id);

        $data = $request->validate([
            'kinerja'      => 'required|integer|min:0|max:100',
            'sikap'        => 'required|integer|min:0|max:100',
            'komunikasi'   => 'required|integer|min:0|max:100',
            'kerjasama'    => 'required|integer|min:0|max:100',
            'catatan'      => 'nullable|string',
        ]);

        $nilaiAkhir = round(($data['kinerja'] + $data['sikap'] + $data['komunikasi'] + $data['kerjasama']) / 4);
        $status     = $nilaiAkhir >= 70 ? 'Lulus' : 'Tidak Lulus';

        PenilaianAkhir::updateOrCreate(
            ['peserta_id' => $p->id],
            [
                'mentor_id'           => Auth::user()->id,
                'nilai_kehadiran'     => $data['kerjasama'],
                'nilai_logbook'       => $data['komunikasi'],
                'nilai_laporan_akhir' => $data['kinerja'],
                'nilai_sikap'         => $data['sikap'],
                'nilai_akhir'         => $nilaiAkhir,
                'status_kelulusan'    => $status,
                'catatan'             => $data['catatan'] ?? null,
                'dinilai_pada'        => now(),
            ]
        );

        return redirect()->route('mentor.penilaian-akhir')
            ->with('success', 'Penilaian akhir berhasil disimpan.');
    }
}