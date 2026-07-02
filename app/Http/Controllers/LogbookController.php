<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Logbook;
use Carbon\Carbon;

class LogbookController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        $stats = [
            'total'     => Logbook::where('peserta_id', $profil->id)->count(),
            'disetujui' => Logbook::where('peserta_id', $profil->id)->where('status', 'Disetujui')->count(),
            'menunggu'  => Logbook::where('peserta_id', $profil->id)->where('status', 'Menunggu Verifikasi')->count(),
            'revisi'    => Logbook::where('peserta_id', $profil->id)->where('status', 'Perlu Revisi')->count(),
        ];

        $rawLogbooks = Logbook::where('peserta_id', $profil->id)
            ->orderBy('tanggal', 'desc')
            ->paginate(15);

        $logbooks = $rawLogbooks->through(function ($l) {
            return [
                'id'        => $l->id,
                'judul'     => $l->judul_aktivitas,
                'deskripsi' => $l->deskripsi,
                'tanggal'   => Carbon::parse($l->tanggal)->format('d M Y'),
                'minggu'    => 'Minggu ke-' . Carbon::parse($l->tanggal)->weekOfYear,
                'status'    => $l->status,
            ];
        });

        return view('logbook.index', compact('stats', 'logbooks'));
    }

    public function create()
    {
        return view('logbook.create', ['sudahIsi' => false]);
    }

    public function store(Request $request)
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'judul_aktivitas'  => 'required|string|max:255',
            'deskripsi'        => 'required|string',
            'dokumentasi'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ], [
            'tanggal_kegiatan.required' => 'Tanggal wajib diisi.',
            'judul_aktivitas.required'  => 'Judul aktivitas wajib diisi.',
            'deskripsi.required'        => 'Deskripsi kegiatan wajib diisi.',
            'dokumentasi.image'         => 'File harus berupa gambar.',
            'dokumentasi.max'           => 'Ukuran foto maksimal 5MB.',
        ]);

        // Upload foto dokumentasi jika ada
        $dokumentasiPath = null;
        if ($request->hasFile('dokumentasi')) {
            $dokumentasiPath = $request->file('dokumentasi')->store('logbook/dokumentasi', 'public');
        }

        Logbook::create([
            'peserta_id'       => $profil->id,
            'tanggal'          => $request->tanggal_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'jam_kegiatan'     => $request->jam_kegiatan,
            'judul_aktivitas'  => $request->judul_aktivitas,
            'deskripsi'        => $request->deskripsi,
            'dokumentasi'      => $dokumentasiPath,
            'status'           => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('logbook.index')
            ->with('success', 'Logbook berhasil disimpan.');
    }

    public function edit($id)
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        $logbook = Logbook::where('peserta_id', $profil->id)->findOrFail($id);

        return view('logbook.create', ['sudahIsi' => false, 'logbook' => $logbook]);
    }

    public function update(Request $request, $id)
    {
        $user   = Auth::user();
        $profil = $user->profilPeserta;

        $logbook = Logbook::where('peserta_id', $profil->id)->findOrFail($id);

        $request->validate([
            'tanggal_kegiatan' => 'required|date',
            'judul_aktivitas'  => 'required|string|max:255',
            'deskripsi'        => 'required|string',
            'dokumentasi'      => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        // Upload foto baru jika ada, hapus yang lama
        // Hapus foto lama kalau ada
        if ($logbook->dokumentasi) {
            Storage::disk('public')->delete($logbook->dokumentasi);
        }

        // Upload foto baru kalau ada
        $dokumentasiPath = null;
        if ($request->hasFile('dokumentasi')) {
            $dokumentasiPath = $request->file('dokumentasi')->store('logbook/dokumentasi', 'public');
        }

        $logbook->update([
            'tanggal'          => $request->tanggal_kegiatan,
            'tanggal_kegiatan' => $request->tanggal_kegiatan,
            'jam_kegiatan'     => $request->jam_kegiatan,
            'judul_aktivitas'  => $request->judul_aktivitas,
            'deskripsi'        => $request->deskripsi,
            'dokumentasi'      => $dokumentasiPath,
            'status'           => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('logbook.index')
            ->with('success', 'Logbook berhasil diperbarui.');
    }
}