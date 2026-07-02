<?php

namespace App\Http\Controllers;

use App\Models\ProfilPeserta;
use App\Models\ProfilMentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ProfilController extends Controller
{
    private function rangkumProfil($u, $peserta)
    {
        $sisaHari = $peserta?->periode_selesai
            ? max(0, Carbon::parse($peserta->periode_selesai)->diffInDays(now(), false) * -1)
            : null;

        $user = [
            'name'       => $u->name,
            'prodi'      => $peserta->jurusan ?? '-',
            'status'     => $peserta->status_magang ?? '-',
            'divisi'     => $peserta->divisi ?? '-',
            'sisa_waktu' => $sisaHari !== null ? $sisaHari . ' hari lagi' : '-',
        ];

        $dataPribadi = [
            'nama_lengkap'      => $u->name,
            'email'             => $u->email,
            'nomor_telepon'     => $peserta->nomor_telepon ?? '-',
            'instansi'          => $peserta->instansi ?? '-',
            'jurusan'           => $peserta->jurusan ?? '-',
            'jenis_pendaftaran' => $peserta->jenis_pendaftaran ?? '-',
        ];

        return [$user, $dataPribadi];
    }

    public function index()
    {
        $u       = Auth::user();
        $peserta = $u->profilPeserta;

        [$user, $dataPribadi] = $this->rangkumProfil($u, $peserta);

        // Ambil nama mentor lewat profil_mentor → user
        $profilMentor = ProfilMentor::find($peserta?->mentor_id);

        $mulai   = $peserta?->periode_mulai
                    ? Carbon::parse($peserta->periode_mulai)->format('d M Y')
                    : '-';
        $selesai = $peserta?->periode_selesai
                    ? Carbon::parse($peserta->periode_selesai)->format('d M Y')
                    : '-';
        $durasi  = ($peserta?->periode_mulai && $peserta?->periode_selesai)
                    ? Carbon::parse($peserta->periode_mulai)
                        ->diffInDays(Carbon::parse($peserta->periode_selesai)) . ' Hari'
                    : '-';

        $infoMagang = [
            'unit_divisi'   => $peserta->divisi ?? '-',
            'nama_mentor'   => $profilMentor?->user?->name ?? '-',
            'mulai'         => $mulai,
            'selesai'       => $selesai,
            'durasi'        => $durasi,
            'status_magang' => $peserta->status_magang ?? '-',
        ];

        return view('profil.index', compact('user', 'dataPribadi', 'infoMagang', 'peserta'));
    }

    public function edit()
    {
        $u       = Auth::user();
        $peserta = $u->profilPeserta;

        [$user, $dataPribadi] = $this->rangkumProfil($u, $peserta);

        return view('profil.edit', compact('user', 'dataPribadi', 'peserta'));
    }

    public function update(Request $request)
    {
        $u = Auth::user();

        $data = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => 'required|email|max:255|unique:users,email,' . $u->id,
            'nomor_telepon'     => 'nullable|string|max:20',
            'instansi'          => 'nullable|string|max:255',
            'jurusan'           => 'nullable|string|max:255',
            'jenis_pendaftaran' => 'nullable|in:Praktik Industri,KKN,Magang Mandiri',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $u->update([
            'name'  => $data['nama_lengkap'],
            'email' => $data['email'],
        ]);

        $updatePeserta = [
            'nomor_telepon'     => $data['nomor_telepon'] ?? null,
            'instansi'          => $data['instansi'] ?? null,
            'jurusan'           => $data['jurusan'] ?? null,
            'jenis_pendaftaran' => $data['jenis_pendaftaran'] ?? null,
        ];

        if ($request->hasFile('foto')) {
            $peserta = $u->profilPeserta;
            if ($peserta->foto) {
                Storage::disk('public')->delete($peserta->foto);
            }
            $filename = 'peserta_' . $u->id . '_' . time() . '.' . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('foto-profil', $filename, 'public');
            $updatePeserta['foto'] = 'foto-profil/' . $filename;
        }

        ProfilPeserta::where('user_id', $u->id)->update($updatePeserta);

        return redirect()
            ->route('profil.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $u = Auth::user();

        if (!Hash::check($data['current_password'], $u->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $u->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('profil.index')
            ->with('success', 'Password berhasil diubah.');
    }

    public function hapusAkun(Request $request)
{
    $u = Auth::user();

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    $u->delete();

    return redirect()->route('login')->with('success', 'Akun Anda telah berhasil dihapus.');
}
}