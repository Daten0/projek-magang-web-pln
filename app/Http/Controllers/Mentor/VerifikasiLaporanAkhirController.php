<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class VerifikasiLaporanAkhirController extends Controller
{
    private function getMentorId()
    {
        return Auth::user()->profilMentor->id ?? 0;
    }

    private function laporanBimbingan()
    {
        return LaporanAkhir::with('peserta.user')
            ->whereHas('peserta', fn($q) => $q->where('mentor_id', $this->getMentorId()));
    }

    public function index()
    {
        $mentorId = $this->getMentorId();

        $semua = $this->laporanBimbingan()->get();

        $stats = [
            'total_masuk'         => $semua->count(),
            'menunggu_verifikasi' => $semua->where('status', 'Review')->count(),
            'disetujui'           => $semua->where('status', 'Diterima')->count(),
            'perlu_revisi'        => $semua->where('status', 'Revisi')->count(),
        ];

        $colors = ['bg-blue-100 text-blue-700', 'bg-amber-100 text-amber-700', 'bg-green-100 text-green-700', 'bg-purple-100 text-purple-700'];
        $colorIdx = 0;

        $laporanList = $this->laporanBimbingan()
            ->orderByDesc('diunggah_pada')
            ->get()
            ->map(function($l) use (&$colorIdx, $colors) {
                $item = [
                    'id'           => $l->id,
                    'inisial'      => strtoupper(substr(str_replace(' ', '', $l->peserta->user->name ?? '-'), 0, 2)),
                    'nama'         => $l->peserta->user->name ?? '-',
                    'nim'          => $l->peserta->nim ?? '-',
                    'foto'         => $l->peserta->foto,
                    'divisi'       => $l->peserta->divisi ?? '-',
                    'judul'        => $l->nama_file_asli ?? 'Laporan Akhir',
                    'tanggal'      => Carbon::parse($l->diunggah_pada)->format('d M Y'),
                    'waktu'        => Carbon::parse($l->diunggah_pada)->diffForHumans(),
                    'status' => match($l->status) {
                    'Review'   => 'Menunggu Verifikasi',
                    'Diterima' => 'Disetujui',
                    'Revisi'   => 'Perlu Revisi',
                    default    => $l->status,
                    },
                    'warna_avatar' => $colors[$colorIdx % count($colors)],
                ];
                $colorIdx++;
                return $item;
            });

        $pagination = [
            'awal'          => $laporanList->count() > 0 ? 1 : 0,
            'akhir'         => $laporanList->count(),
            'total'         => $laporanList->count(),
            'total_halaman' => 1,
        ];

        $hideTopbar = false;

        return view('mentor.verifikasi-laporan-akhir', compact(
            'stats', 'laporanList', 'pagination', 'hideTopbar'
        ));
    }

    /**
     * Tampilkan detail satu laporan akhir untuk ditinjau.
     *
     * View mentor.tinjau-laporan-akhir butuh array lengkap (bukan model
     * Eloquent mentah), termasuk sub-array 'ringkasan' untuk kehadiran
     * dan progres logbook peserta.
     */
    public function show($id)
    {
        $model   = $this->laporanBimbingan()->findOrFail($id);
        $peserta = $model->peserta;
        $user    = $peserta->user;

        $totalAbsensi = $peserta->absensi()->count();
        $totalHadir   = $peserta->absensi()->where('status', 'Hadir')->count();
        $totalLogbook = $peserta->logbook()->count();
        $logbookOk    = $peserta->logbook()->where('status', 'Disetujui')->count();
        $persenHadir  = $totalAbsensi > 0 ? round($totalHadir / $totalAbsensi * 100) : 0;

        $periode = ($peserta->periode_mulai && $peserta->periode_selesai)
            ? Carbon::parse($peserta->periode_mulai)->format('d M Y') . ' – ' . Carbon::parse($peserta->periode_selesai)->format('d M Y')
            : '-';

        $ukuranFile = '-';
        if ($model->file_path && Storage::disk('public')->exists($model->file_path)) {
            $bytes = Storage::disk('public')->size($model->file_path);
            $ukuranFile = $bytes >= 1048576
                ? round($bytes / 1048576, 1) . ' MB'
                : round($bytes / 1024) . ' KB';
        }

        $laporan = [
            'id'             => $model->id,
            'nama'           => $user->name ?? '-',
            'inisial'        => strtoupper(substr(str_replace(' ', '', $user->name ?? '-'), 0, 2)),
            'warna_avatar'   => 'bg-blue-100 text-blue-700',
            'jabatan_magang' => $peserta->jenis_pendaftaran ?? '-',
            'asal'           => $peserta->instansi ?? '-',
            'divisi'         => $peserta->divisi ?? '-',
            'periode'        => $periode,
            'status'         => $model->status,
            'catatan_mentor' => $model->catatan_mentor,

            'nama_file'      => $model->nama_file_asli ?? 'laporan-akhir.pdf',
            'ukuran_file'    => $ukuranFile,
            'tanggal'        => $model->diunggah_pada
                ? Carbon::parse($model->diunggah_pada)->format('d M Y')
                : '-',
            'file_url'       => $model->file_path
                ? Storage::url($model->file_path)
                : null,

            'ringkasan' => [
                'kehadiran'         => $persenHadir,
                'total_logbook'     => $totalLogbook,
                'logbook_disetujui' => $logbookOk,
            ],
        ];

        return view('mentor.tinjau-laporan-akhir', compact('laporan'));
    }

    public function setujui(Request $request, $id)
    {
        $laporan = $this->laporanBimbingan()->findOrFail($id);

        $request->validate([
            'catatan' => 'nullable|string',
        ]);

        $laporan->update([
            'status'         => 'Diterima',
            'catatan_mentor' => $request->catatan,
            'diperiksa_oleh' => Auth::id(),
            'diperiksa_pada' => now(),
        ]);

        return redirect()->route('mentor.verifikasi-laporan-akhir')
            ->with('success', 'Laporan akhir berhasil disetujui.');
    }

    public function mintaRevisi(Request $request, $id)
    {
        $laporan = $this->laporanBimbingan()->findOrFail($id);

        $request->validate([
            'catatan' => 'required|string',
        ], [
            'catatan.required' => 'Catatan revisi wajib diisi.',
        ]);

        $laporan->update([
            'status'         => 'Revisi',
            'catatan_mentor' => $request->catatan,
            'diperiksa_oleh' => Auth::id(),
            'diperiksa_pada' => now(),
        ]);

        return redirect()->route('mentor.verifikasi-laporan-akhir')
            ->with('success', 'Permintaan revisi berhasil dikirim ke peserta.');
    }
}