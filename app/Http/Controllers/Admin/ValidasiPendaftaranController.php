<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilMentor;
use Illuminate\Http\Request;
use App\Models\ProfilPeserta;

class ValidasiPendaftaranController extends Controller
{
    public function index()
    {
        $totalPengajuan = User::where('role', 'peserta')->count();
        $totalBulanLalu = User::where('role', 'peserta')
                             ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
                             ->count();

        $stats = [
            'total_pengajuan'      => $totalPengajuan,
            'total_pengajuan_naik' => $totalPengajuan - $totalBulanLalu,
            'menunggu_verifikasi'  => User::where('role', 'peserta')->where('status_pendaftaran', 'menunggu')->count(),
            'diterima'             => User::where('role', 'peserta')->where('status_pendaftaran', 'aktif')->count(),
            'ditolak'              => User::where('role', 'peserta')->where('status_pendaftaran', 'ditolak')->count(),
        ];

        $pengajuanList = User::where('role', 'peserta')
            ->with('profilPeserta')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($u) => [
                'id'       => $u->id,
                'inisial'  => strtoupper(substr(str_replace(' ', '', $u->name ?? '-'), 0, 2)),
                'nama'     => $u->name ?? '-',
                'instansi' => $u->profilPeserta?->instansi ?? '-',
                'foto'     => $u->profilPeserta?->foto,
                'jurusan'  => $u->profilPeserta?->jurusan ?? '-',
                'jenis'    => $u->profilPeserta?->jenis_pendaftaran ?? '-',
                'tanggal'  => $u->created_at->format('d M Y'),
                'status'   => $u->status_pendaftaran,
            ]);

        $pagination = [
            'menampilkan'   => $pengajuanList->count(),
            'total'         => $pengajuanList->count(),
            'total_halaman' => 1,
            'halaman'       => 1,
        ];

        $hideTopbar = false;

        return view('admin.validasi-pendaftaran', compact(
            'stats', 'pengajuanList', 'pagination', 'hideTopbar'
        ));
    }

    public function show($id)
    {
        $peserta = User::where('role', 'peserta')
            ->with('profilPeserta')
            ->findOrFail($id);

        $mentorOptions = ProfilMentor::with('user')
            ->where('status', 'Aktif')
            ->get()
            ->map(fn($m) => [
                'id'   => $m->id,
                'nama' => $m->user->name ?? '-',
            ]);

        $divisiOptions = [
            'Sistem Informasi',
            'IT Development',
            'SDM & Umum',
            'Distribusi',
            'Transmisi',
            'Keuangan & Akuntansi',
            'Legal & Compliance',
        ];

        $pendaftar = [
            'id'              => $peserta->id,
            'nama_lengkap'    => $peserta->name,
            'email'           => $peserta->email,
            'foto'            => $peserta->profilPeserta?->foto,
            'institusi'       => $peserta->profilPeserta?->instansi ?? '-',
            'jurusan'         => $peserta->profilPeserta?->jurusan ?? '-',
            'nim'             => $peserta->profilPeserta?->nim ?? '-',
            'nomor_telepon'   => $peserta->profilPeserta?->nomor_telepon ?? '-',
            'jenis'           => $peserta->profilPeserta?->jenis_pendaftaran ?? '-',
            'tanggal_daftar'  => $peserta->created_at->format('d M Y'),
            'status_awal'     => 'Menunggu Persetujuan',
            'periode_mulai'   => $peserta->profilPeserta?->periode_mulai ?? '',
            'periode_selesai' => $peserta->profilPeserta?->periode_selesai ?? '',
            'alasan_ditolak'  => $peserta->profilPeserta?->alasan_ditolak ?? '',
            'status'          => $peserta->status_pendaftaran,
        ];

        return view('admin.validasi-pendaftaran-detail', compact(
            'pendaftar', 'mentorOptions', 'divisiOptions'
        ));
    }

    public function update(Request $request, $id)
    {
        $user   = User::where('role', 'peserta')->findOrFail($id);
        $profil = $user->profilPeserta;

        if ($request->aksi === 'terima') {
            $request->validate([
                'mentor_id'       => 'required|exists:profil_mentor,id',
                'divisi'          => 'required|string|max:255',
                'periode_mulai'   => 'required|date',
                'periode_selesai' => 'required|date|after:periode_mulai',
            ], [
                'mentor_id.required'       => 'Mentor wajib dipilih.',
                'mentor_id.exists'         => 'Mentor tidak valid.',
                'divisi.required'          => 'Divisi wajib diisi.',
                'periode_mulai.required'   => 'Periode mulai wajib diisi.',
                'periode_selesai.required' => 'Periode selesai wajib diisi.',
                'periode_selesai.after'    => 'Periode selesai harus setelah periode mulai.',
            ]);

            $user->update(['status_pendaftaran' => 'aktif']);

            ProfilPeserta::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'mentor_id'       => $request->mentor_id,
                    'divisi'          => $request->divisi,
                    'periode_mulai'   => $request->periode_mulai,
                    'periode_selesai' => $request->periode_selesai,
                    'status_magang'   => 'Aktif',
                    'alasan_ditolak'  => null,
                ]
            );

            return redirect()->route('admin.validasi-pendaftaran')
                ->with('success', "Pendaftaran {$user->name} berhasil disetujui.");

        } elseif ($request->aksi === 'tolak') {
            $request->validate([
                'alasan_ditolak' => 'required|string|max:500',
            ], [
                'alasan_ditolak.required' => 'Alasan penolakan wajib diisi.',
            ]);

            $user->update(['status_pendaftaran' => 'ditolak']);

            if ($profil) {
                $profil->update(['alasan_ditolak' => $request->alasan_ditolak]);
            } else {
                ProfilPeserta::create([
                    'user_id'        => $user->id,
                    'alasan_ditolak' => $request->alasan_ditolak,
                ]);
            }

            return redirect()->route('admin.validasi-pendaftaran')
                ->with('success', "Pendaftaran {$user->name} telah ditolak.");
        }

        return redirect()->route('admin.validasi-pendaftaran')
            ->with('error', 'Aksi tidak valid.');
    }
}