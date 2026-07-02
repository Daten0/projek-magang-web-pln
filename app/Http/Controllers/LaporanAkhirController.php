<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\LaporanAkhir;
use Carbon\Carbon;

class LaporanAkhirController extends Controller
{
    public function index()
    {
        $user         = Auth::user();
        $profil       = $user->profilPeserta;
        $laporanAkhir = LaporanAkhir::where('peserta_id', $profil->id)->first();

        // Buat riwayat sebagai array supaya cocok dengan $item['tanggal'] di view
        $riwayat = $laporanAkhir ? collect([[
            'tanggal'   => $laporanAkhir->diunggah_pada
                            ? $laporanAkhir->diunggah_pada->format('d M Y')
                            : $laporanAkhir->created_at->format('d M Y'),
            'nama_file' => $laporanAkhir->nama_file_asli,
            'status'    => $laporanAkhir->status,
            'file_path' => $laporanAkhir->file_path,
        ]]) : collect();

        return view('laporan-akhir.index', compact('profil', 'laporanAkhir', 'riwayat'));
    }
    public function store(Request $request)
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        $request->validate([
            'laporan' => 'required|file|mimes:pdf|max:10240',
        ], [
            'laporan.required' => 'File laporan wajib diunggah.',
            'laporan.mimes'    => 'File harus berformat PDF.',
            'laporan.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        $file           = $request->file('laporan');
        $namaFileAsli   = $file->getClientOriginalName();
        $namaFileSimpan = time() . '_' . $profil->id . '.' . $file->getClientOriginalExtension();
        $filePath       = $file->storeAs('laporan-akhir', $namaFileSimpan, 'public');

        $laporan = LaporanAkhir::where('peserta_id', $profil->id)->first();

        if ($laporan) {
            Storage::disk('public')->delete($laporan->file_path);
            $laporan->update([
                'file_path'      => $filePath,
                'nama_file_asli' => $namaFileAsli,
                'status'         => 'Review',
                'catatan_mentor' => null,
                'diunggah_pada'  => Carbon::now(),
                'diperiksa_oleh' => null,
                'diperiksa_pada' => null,
            ]);
        } else {
            LaporanAkhir::create([
                'peserta_id'    => $profil->id,
                'file_path'     => $filePath,
                'nama_file_asli'=> $namaFileAsli,
                'status'        => 'Review',
                'diunggah_pada' => Carbon::now(),
            ]);
        }

        return back()->with('success', 'Laporan akhir berhasil diunggah.');
    }
}