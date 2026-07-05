<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilPeserta;
use App\Models\Sertifikat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SertifikatController extends Controller
{
    public function index()
    {
        $stats = [
            'total_selesai'    => ProfilPeserta::where('status_magang', 'Selesai')->count(),
            'siap_diterbitkan' => ProfilPeserta::whereHas('penilaianAkhir', function ($q) {
                                      $q->where('status_kelulusan', 'Lulus');
                                  })->where(function ($q) {
                                      $q->whereDoesntHave('sertifikat')
                                        ->orWhereHas('sertifikat', fn ($q2) => $q2->where('status', 'Belum Terbit'));
                                  })->count(),
            'sudah_terbit'     => Sertifikat::where('status', 'Terbit')->count(),
        ];

        $pesertaRaw = ProfilPeserta::with([
            'user', 'profilMentor.user', 'laporanAkhir', 'penilaianAkhir', 'sertifikat',
        ])->whereHas('user', fn($q) => $q->where('status_pendaftaran', 'aktif'))
        ->whereIn('status_magang', ['Aktif', 'Selesai', 'Tidak Aktif'])
        ->paginate(10);

        $peserta = $pesertaRaw->map(function ($p) {
            $nilai        = $p->penilaianAkhir;
            $sertifikat   = $p->sertifikat;
            $statusKelulusan = $nilai?->status_kelulusan ?? 'Belum Dinilai';

            if ($sertifikat && $sertifikat->status === 'Terbit') {
                $statusSertifikat = 'sudah_diterbitkan';
            } elseif ($statusKelulusan === 'Lulus') {
                $statusSertifikat = 'siap_diterbitkan';
            } else {
                $statusSertifikat = 'belum_memenuhi_syarat';
            }

            $nama    = $p->user->name ?? '-';
            $inisial = strtoupper(substr(str_replace(' ', '', $nama), 0, 2));

            return [
                'id'                => $p->id,
                'inisial'           => $inisial,
                'avatar_color'      => 'bg-blue-100 text-blue-700',
                'nama'              => $nama,
                'foto'              => $p->foto,
                'posisi'            => 'Intern - ' . ($p->jurusan ?? '-'),
                'divisi'            => $p->divisi ?? '-',
                'mentor'            => $p->profilMentor?->user?->name ?? '-',
                'laporan'           => $p->laporanAkhir?->status ?? 'Belum Ada',
                'penilaian'         => $nilai?->nilai_akhir,
                'status_sertifikat' => $statusSertifikat,
            ];
        });

        $pagination = [
            'dari'    => $pesertaRaw->firstItem(),
            'sampai'  => $pesertaRaw->lastItem(),
            'total'   => $pesertaRaw->total(),
            'current' => $pesertaRaw->currentPage(),
            'pages'   => range(1, min($pesertaRaw->lastPage(), 5)),
        ];

        return view('admin.sertifikat', compact('stats', 'peserta', 'pagination'));
    }

    public function show($id)
    {
        $p = ProfilPeserta::with([
            'user', 'profilMentor.user', 'laporanAkhir', 'penilaianAkhir', 'sertifikat',
        ])->findOrFail($id);

        $sertifikat      = $p->sertifikat;
        $penilaian       = $p->penilaianAkhir;
        $statusKelulusan = $penilaian?->status_kelulusan ?? 'Belum Dinilai';

        if ($sertifikat && $sertifikat->status === 'Terbit') {
            $statusSertifikat = 'sudah_diterbitkan';
        } elseif ($statusKelulusan === 'Lulus') {
            $statusSertifikat = 'siap_diterbitkan';
        } else {
            $statusSertifikat = 'belum_memenuhi_syarat';
        }

        $periode = ($p->periode_mulai ? $p->periode_mulai->format('M Y') : '-')
            . ' - ' .
            ($p->periode_selesai ? $p->periode_selesai->format('M Y') : '-');

        $peserta = [
            'id'                => $p->id,
            'nama'              => $p->user->name ?? '-',
            'inisial'           => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
            'foto'              => null,
            'universitas'       => $p->instansi ?? '-',
            'divisi'            => $p->divisi ?? '-',
            'mentor'            => $p->profilMentor?->user?->name ?? '-',
            'periode'           => $periode,
            'tanggal_terbit'    => $sertifikat?->diterbitkan_pada
                                     ? Carbon::parse($sertifikat->diterbitkan_pada)->translatedFormat('d F Y')
                                     : '-',
            'status_sertifikat' => $statusSertifikat,
            'status_magang'     => $p->status_magang ?? '-', 
        ];

        // Syarat penerbitan sertifikat — dicek dari data asli
        $syarat = [
            [
                'label'     => 'Pendaftaran Diterima',
                'terpenuhi' => $p->user->status_pendaftaran === 'aktif',
            ],
            [
                'label'     => 'Masa Magang Selesai',
                'terpenuhi' => in_array($p->status_magang, ['Selesai', 'Menunggu Penilaian']),
            ],
            [
                'label'     => 'Logbook Diverifikasi',
                'terpenuhi' => $p->logbook()->where('status', 'Disetujui')->exists(),
            ],
            [
                'label'     => 'Laporan Akhir Diunggah',
                'terpenuhi' => $p->laporanAkhir !== null,
            ],
            [
                'label'     => 'Penilaian Mentor Lengkap',
                'terpenuhi' => $penilaian && $statusKelulusan !== 'Belum Dinilai',
            ],
        ];

        // Riwayat sertifikat
        $riwayat = [];
        if ($sertifikat) {
            $riwayat[] = [
                'tanggal' => $sertifikat->diterbitkan_pada
                    ? Carbon::parse($sertifikat->diterbitkan_pada)->format('d M Y')
                    : '-',
                'nomor'   => $sertifikat->nomor_sertifikat ?? '-',
                'status'  => $sertifikat->status,
                'admin'   => $sertifikat->diterbitkanOleh?->name ?? 'Admin',
            ];
        }

        $penilaianakhir = $p->penilaianAkhir ? [
            'keterampilan_teknis' => $p->penilaianAkhir->keterampilan_teknis,
            'pemecahan_masalah' => $p->penilaianAkhir->pemecahan_masalah,
            'kedisiplinan' => $p->penilaianAkhir->kedisiplinan,
            'kerjasama' => $p->penilaianAkhir->kerjasama,
            'kehadiran' => $p->penilaianAkhir->kehadiran,
            'catatan' => $p->penilaianAkhir->catatan,
            'nilai_akhir' => $p->penilaianAkhir->nilai_akhir,
            'status_kelulusan' => $p->penilaianAkhir->status_kelulusan,
        ] : null;

        return view('admin.sertifikat-detail', compact('peserta', 'syarat', 'riwayat', 'penilaianakhir'));
    }

    public function terbitkan(Request $request, $id)
    {
        $p = ProfilPeserta::with(['penilaianAkhir', 'sertifikat'])->findOrFail($id);

        // Pastikan sudah lulus sebelum terbitkan
        if ($p->penilaianAkhir?->status_kelulusan !== 'Lulus') {
            return back()->withErrors(['error' => 'Peserta belum dinyatakan lulus oleh mentor.']);
        }

        $request->validate([
            'file_sertifikat' => 'required|file|mimes:pdf|max:10240',
        ]);

        $file     = $request->file('file_sertifikat');
        $filePath = $file->store('sertifikat', 'public');
        $nomorSertifikat = 'PLN/CERT/' . date('Y') . '/' . str_pad($p->id, 4, '0', STR_PAD_LEFT);

        Sertifikat::updateOrCreate(
            ['peserta_id' => $p->id],
            [
                'nomor_sertifikat'   => $nomorSertifikat,
                'file_path'          => $filePath,
                'status'             => 'Terbit',
                'diterbitkan_oleh'   => Auth::id(),
                'diterbitkan_pada'   => now(),
            ]
        );

        return redirect()
            ->route('admin.sertifikat.show', $id)
            ->with('success', 'Sertifikat berhasil diterbitkan.');
    }

    public function download($id)
    {
        $p = ProfilPeserta::with('sertifikat')->findOrFail($id);
        $sertifikat = $p->sertifikat;

        if (!$sertifikat || $sertifikat->status !== 'Terbit' || !$sertifikat->file_path) {
            return back()->withErrors(['error' => 'File sertifikat belum tersedia atau belum diterbitkan.']);
        }

        $path = storage_path('app/public/' . $sertifikat->file_path);
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, 'Sertifikat_' . preg_replace('/[^A-Za-z0-9\-_]/', '_', $p->user->name) . '.pdf');
    }
}