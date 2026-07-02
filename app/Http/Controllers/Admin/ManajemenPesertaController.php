<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilMentor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ManajemenPesertaController extends Controller
{
    /**
     * Daftar semua peserta aktif.
     */
    public function index()
    {
        $semuaPeserta = User::where('role', 'peserta')
            ->where('status_pendaftaran', 'aktif')
            ->with('profilPeserta.profilMentor.user')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_peserta'      => $semuaPeserta->count(),
            'peserta_aktif'      => $semuaPeserta->filter(fn ($u) => $u->profilPeserta?->status_magang === 'Aktif')->count(),
            'magang_selesai'     => $semuaPeserta->filter(fn ($u) => $u->profilPeserta?->status_magang === 'Selesai')->count(),
            'peserta_tidak_aktif' => $semuaPeserta->filter(fn ($u) => $u->profilPeserta?->status_magang === 'Tidak Aktif')->count(),
        ];

        $pesertaList = $semuaPeserta->map(function ($u) {
            $profil = $u->profilPeserta;

            return [
                'id'             => $u->id,
                'inisial'        => strtoupper(substr($u->name ?? '-', 0, 2)),
                'nama'           => $u->name ?? '-',
                'nim'            => $profil->nim ?? '-',
                'instansi'       => $profil->instansi ?? '-',
                'foto'           => $profil->foto,
                'divisi'         => $profil->divisi ?? '-',
                'mentor'         => $profil?->profilMentor?->user?->name ?? '-',
                'mentor_jabatan' => $profil?->profilMentor?->jabatan ?? '-',
                'periode'        => ($profil?->periode_mulai && $profil?->periode_selesai)
                    ? Carbon::parse($profil->periode_mulai)->format('d M Y') . ' – ' . Carbon::parse($profil->periode_selesai)->format('d M Y')
                    : '-',
                'status'         => $profil->status_magang ?? '-',
            ];
        });

        $pagination = [
            'awal'          => $pesertaList->count() > 0 ? 1 : 0,
            'akhir'         => $pesertaList->count(),
            'total'         => $pesertaList->count(),
            'total_halaman' => 1,
        ];

        return view('admin.manajemen-peserta', compact('stats', 'pesertaList', 'pagination'));
    }

    /**
     * Form edit peserta.
     */
    public function edit($id)
    {
        $user   = User::where('role', 'peserta')->with('profilPeserta')->findOrFail($id);
        $profil = $user->profilPeserta;

        $totalAbsensi = $profil ? $profil->absensi()->count() : 0;
        $totalHadir   = $profil ? $profil->absensi()->where('status', 'Hadir')->count() : 0;
        $totalLogbook = $profil ? $profil->logbook()->count() : 0;

        $peserta = [
            'id'                    => $user->id,
            'nama'                  => $user->name,
            'instansi'              => $profil->instansi ?? '',
            'divisi'                => $profil->divisi ?? '',
            'mentor_id'             => $profil->mentor_id ?? '',
            // format Y-m-d supaya cocok dengan <input type="date">
            'periode_mulai_raw'     => $profil->periode_mulai ? Carbon::parse($profil->periode_mulai)->format('Y-m-d') : '',
            'periode_selesai_raw'   => $profil->periode_selesai ? Carbon::parse($profil->periode_selesai)->format('Y-m-d') : '',
            'status'                => $profil->status_magang ?? 'Aktif',
            'kehadiran'             => $totalAbsensi > 0 ? round($totalHadir / $totalAbsensi * 100) : 0,
            'logbook'               => $totalLogbook,
        ];

        $mentorOptions = ProfilMentor::with('user')
            ->where('status', 'Aktif')
            ->get()
            ->map(fn ($m) => ['id' => $m->id, 'nama' => $m->user->name ?? '-'])
            ->values();

        $divisiOptions = [
            'Sistem Informasi',
            'IT Development',
            'SDM & Umum',
            'Distribusi',
            'Transmisi',
            'Keuangan & Akuntansi',
            'Legal & Compliance',
        ];

        return view('admin.manajemen-peserta-edit', compact('peserta', 'mentorOptions', 'divisiOptions'));
    }

    /**
     * Update data peserta.
     *
     * Catatan: form ini cuma menangani field penempatan program
     * (instansi, divisi, mentor, periode, status). Nama/email/NIM/dll
     * milik peserta diedit peserta sendiri lewat halaman Profil mereka,
     * jadi sengaja TIDAK disentuh di sini.
     */
    public function update(Request $request, $id)
    {
        $user   = User::where('role', 'peserta')->findOrFail($id);
        $profil = $user->profilPeserta;

        $data = $request->validate([
            'instansi'        => 'nullable|string|max:255',
            'divisi'          => 'nullable|string|max:255',
            'mentor_id'       => 'nullable|exists:profil_mentor,id',
            'periode_mulai'   => 'nullable|date',
            'periode_selesai' => 'nullable|date|after_or_equal:periode_mulai',
            'status'          => 'required|in:Aktif,Selesai,Tidak Aktif',
        ], [
            'status.required' => 'Status magang wajib dipilih.',
        ]);

        $profil->update([
            'instansi'        => $data['instansi'] ?? null,
            'divisi'          => $data['divisi'] ?? null,
            'mentor_id'       => $data['mentor_id'] ?? null,
            'periode_mulai'   => $data['periode_mulai'] ?? null,
            'periode_selesai' => $data['periode_selesai'] ?? null,
            'status_magang'   => $data['status'],
        ]);

        return redirect()->route('admin.manajemen-peserta')
            ->with('success', "Data peserta {$user->name} berhasil diperbarui.");
    }
}