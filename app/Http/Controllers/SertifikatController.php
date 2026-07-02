<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sertifikat;

class SertifikatController extends Controller
{
    public function index()
{
    $user   = Auth::user();
    $profil = $user->profilPeserta;

    $sertifikatModel = Sertifikat::where('peserta_id', $profil->id)->first();

    // Cek semua syarat
    $checklist = [
        ['label' => 'Masa Magang Selesai',      'selesai' => $profil->status_magang === 'Selesai'],
        ['label' => 'Logbook Diverifikasi',      'selesai' => $profil->logbook()->where('status', 'Disetujui')->count() > 0],
        ['label' => 'Absensi Tercatat',          'selesai' => $profil->absensi()->count() > 0],
        ['label' => 'Laporan Akhir Disetujui',   'selesai' => $profil->laporanAkhir && $profil->laporanAkhir->status === 'Diterima'],
        ['label' => 'Penilaian Mentor Lengkap',  'selesai' => $profil->penilaianAkhir !== null],
    ];

    $selesaiCount = collect($checklist)->where('selesai', true)->count();
    $persentase   = round($selesaiCount / count($checklist) * 100);

    $progress = [
        'persentase' => $persentase,
        'checklist'  => $checklist,
    ];

    // Tentukan status sertifikat
    if ($sertifikatModel && $sertifikatModel->status === 'Terbit') {
        $statusSertifikat = 'sudah_diterbitkan';
    } else {
        $statusSertifikat = 'belum_diterbitkan';
    }

    // Data untuk preview sertifikat
    $profilMentor = \App\Models\ProfilMentor::find($profil->mentor_id);
    $sertifikat = [
        'instansi'         => $profil->instansi ?? 'PT PLN (Persero)',
        'periode'          => ($profil->periode_mulai && $profil->periode_selesai)
                                ? \Carbon\Carbon::parse($profil->periode_mulai)->format('d M Y') . ' – ' .
                                  \Carbon\Carbon::parse($profil->periode_selesai)->format('d M Y')
                                : '-',
        'status'           => $statusSertifikat,
        'file'             => $sertifikatModel?->file_path,
        'nomor'            => $sertifikatModel?->nomor_sertifikat ?? '-',
        'tanggal_terbit'   => $sertifikatModel?->diterbitkan_pada
                                ? \Carbon\Carbon::parse($sertifikatModel->diterbitkan_pada)->format('d M Y')
                                : '-',
        'nama_peserta'     => $user->name,
        'divisi'           => $profil->divisi ?? '-',
        'nama_mentor'      => $profilMentor?->user?->name ?? '-',
    ];

    // Riwayat sertifikat
    $riwayatKlaim = $sertifikatModel ? collect([[
        'tanggal'      => \Carbon\Carbon::parse($sertifikatModel->created_at)->format('d M Y'),
        'nama_dokumen' => 'Sertifikat_' . $user->name . '.pdf',
        'status'       => $sertifikatModel->status,
        'nomor'        => $sertifikatModel->nomor_sertifikat ?? '-',
        'file'         => $sertifikatModel->file_path,
    ]]) : collect();

    return view('sertifikat.index', compact('profil', 'progress', 'sertifikat', 'sertifikatModel', 'riwayatKlaim'));
}

    public function klaim(Request $request)
    {
        $user       = Auth::user();
        $profil     = $user->profilPeserta;
        $sertifikat = Sertifikat::where('peserta_id', $profil->id)->first();

        // Cek sertifikat ada dan sudah terbit
        if (!$sertifikat || $sertifikat->status !== 'Terbit') {
            return back()->with('error', 'Sertifikat belum tersedia untuk diunduh.');
        }

        // Download file sertifikat
        return response()->download(
            storage_path('app/public/' . $sertifikat->file_path),
            'Sertifikat_' . $user->name . '.pdf'
        );
    }
} 