<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Logbook;
use App\Models\PenilaianAkhir;
use App\Models\ProfilPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PenilaianAkhirController extends Controller
{
    private function getMentorId()
    {
        return Auth::user()->profilMentor->id ?? 0;
    }

    private function pesertaBimbingan()
    {
        return ProfilPeserta::with(['user', 'penilaianAkhir', 'logbook', 'laporanAkhir'])
            ->where('mentor_id', $this->getMentorId());
    }

    public function index()
    {
        $peserta = $this->pesertaBimbingan()->with(['user', 'penilaianAkhir'])->get();

        $totalPembimbingan = $peserta->count();
        $sudahDinilai = $peserta->filter(fn($p) => $p->penilaianAkhir && $p->penilaianAkhir->status_kelulusan !== 'Belum Dinilai')->count();
        $belumDinilai = $totalPembimbingan - $sudahDinilai;
        $menunggu = max(0, $totalPembimbingan - $sudahDinilai);

        $stats = [
            'total_bimbingan' => $totalPembimbingan,
            'belum_dinilai'   => $belumDinilai,
            'sudah_dinilai'   => $sudahDinilai,
            'menunggu'        => $menunggu,
        ];

        $pesertaList = $peserta->map(fn($p) => [
            'id'       => $p->id,
            'inisial'  => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
            'nama'     => $p->user->name ?? '-',
            'divisi'   => $p->divisi ?? '-',
            'periode'  => ($p->periode_mulai ? $p->periode_mulai->format('d M Y') : '-')
                          . ' - ' .
                          ($p->periode_selesai ? $p->periode_selesai->format('d M Y') : '-'),
            'status'   => $p->penilaianAkhir && $p->penilaianAkhir->status_kelulusan !== 'Belum Dinilai'
                          ? 'Sudah Dinilai'
                          : 'Belum Dinilai',
        ])->toArray();

        $pagination = [
            'awal'          => $totalPembimbingan > 0 ? 1 : 0,
            'akhir'         => $totalPembimbingan,
            'total'         => $totalPembimbingan,
            'total_halaman' => 1,
            'halaman'       => 1,
        ];

        $hideTopbar = false;

        return view('mentor.penilaian-akhir', compact('stats', 'pesertaList', 'pagination', 'hideTopbar'));
    }

    public function show($id)
    {
        $p = $this->pesertaBimbingan()
            ->with(['user', 'penilaianAkhir', 'logbook', 'laporanAkhir'])
            ->findOrFail($id);

        $totalAbsensi = $p->absensi()->count();
        $hadirAbsensi = $p->absensi()->where('status', 'Hadir')->count();
        $persenKehadiran = $totalAbsensi > 0 ? round($hadirAbsensi / $totalAbsensi * 100) : 0;

        $laporanStatus = $p->laporanAkhir && $p->laporanAkhir->status === 'Diterima'
            ? 'Selesai'
            : 'Belum';

        $penilaian = $p->penilaianAkhir;

        $peserta = [
            'id'                => $p->id,
            'nama'              => $p->user->name ?? '-',
            'inisial'           => strtoupper(substr(str_replace(' ', '', $p->user->name ?? '-'), 0, 2)),
            'universitas'       => $p->instansi ?? '-',
            'divisi'            => $p->divisi ?? '-',
            'kehadiran'         => $persenKehadiran,
            'logbook_disetujui' => $p->logbook()->where('status', 'Disetujui')->count(),
            'laporan_akhir'     => $laporanStatus,
            'nilai' => [
                'teknis'    => $penilaian->nilai_keterampilan_teknis ?? 0,
                'masalah'   => $penilaian->nilai_pemecahan_masalah ?? 0,
                'disiplin'  => $penilaian->nilai_kedisiplinan ?? 0,
                'kerjasama' => $penilaian->nilai_kerjasama ?? 0,
                'kehadiran' => $penilaian->nilai_kehadiran ?? 0,
            ],
            'catatan' => $penilaian->catatan ?? '',
        ];

        $hideTopbar = true;

        return view('mentor.penilaian-akhir-detail', compact('peserta', 'hideTopbar'));
    }

    public function store(Request $request, $id)
    {
        $p = $this->pesertaBimbingan()->findOrFail($id);

        $data = $request->validate([
            'keterampilan_teknis' => 'required|integer|min:0|max:100',
            'pemecahan_masalah'   => 'required|integer|min:0|max:100',
            'kedisiplinan'        => 'required|integer|min:0|max:100',
            'kerjasama'           => 'required|integer|min:0|max:100',
            'kehadiran'           => 'required|integer|min:0|max:100',
            'catatan'             => 'nullable|string',
        ]);

        $totalNilai = $data['keterampilan_teknis']
            + $data['pemecahan_masalah']
            + $data['kedisiplinan']
            + $data['kerjasama']
            + $data['kehadiran'];
        $nilaiRataRata = round($totalNilai / 5);

        $statusKelulusan = $nilaiRataRata >= 70 ? 'Lulus' : 'Tidak Lulus';
        $statusPerforma = 'BELUM DINILAI';
        if ($nilaiRataRata >= 90) {
            $statusPerforma = 'SANGAT BAIK';
        } elseif ($nilaiRataRata >= 80) {
            $statusPerforma = 'BAIK';
        } elseif ($nilaiRataRata >= 70) {
            $statusPerforma = 'CUKUP';
        }

        PenilaianAkhir::updateOrCreate(
            ['peserta_id' => $p->id],
            [
                'mentor_id'                 => Auth::user()->id,
                'nilai_keterampilan_teknis' => $data['keterampilan_teknis'],
                'nilai_pemecahan_masalah'   => $data['pemecahan_masalah'],
                'nilai_kedisiplinan'        => $data['kedisiplinan'],
                'nilai_kerjasama'           => $data['kerjasama'],
                'nilai_kehadiran'           => $data['kehadiran'],
                'nilai_akhir'               => $nilaiRataRata,
                'status_kelulusan'          => $statusKelulusan,
                'status_performa'           => $statusPerforma,
                'catatan'                   => $data['catatan'],
                'dinilai_pada'              => Carbon::now(),
            ]
        );

        return redirect()->route('mentor.penilaian-akhir')
            ->with('success', 'Penilaian berhasil disimpan!');
    }
}
