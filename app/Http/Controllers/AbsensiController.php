<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        // Cek absensi hari ini
        $today          = Carbon::today();
        $absensiHariIni = Absensi::where('peserta_id', $profil->id)
            ->where('tanggal', $today)
            ->first();

        // Riwayat absensi
        $riwayat = Absensi::where('peserta_id', $profil->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        // Statistik
        $totalHadir = Absensi::where('peserta_id', $profil->id)->where('status', 'Hadir')->count();
        $totalIzin  = Absensi::where('peserta_id', $profil->id)->where('status', 'Izin')->count();
        $totalSakit = Absensi::where('peserta_id', $profil->id)->where('status', 'Sakit')->count();
        $totalAlfa  = Absensi::where('peserta_id', $profil->id)->where('status', 'Alfa')->count();
        $totalEntri = $totalHadir + $totalIzin + $totalSakit + $totalAlfa;

        return view('absensi.index', compact(
            'profil',
            'absensiHariIni',
            'riwayat',
            'totalHadir',
            'totalIzin',
            'totalSakit',
            'totalAlfa',
            'totalEntri'
        ));
    }

    public function store(Request $request)
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;
        $today  = Carbon::today();

        // Cek sudah absen hari ini belum
        $sudahAbsen = Absensi::where('peserta_id', $profil->id)
            ->where('tanggal', $today)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah melakukan absensi hari ini.');
        }

        $request->validate([
            'status'     => 'required|in:Hadir,Izin,Sakit,Alfa',
            'keterangan' => 'nullable|string|max:500',
        ]);


        Absensi::create([
            'peserta_id' => $profil->id,
            'tanggal'    => $today,
            'jam_masuk' => date('H:i:s'),
            'status'     => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Absensi berhasil dicatat.');
    }
}