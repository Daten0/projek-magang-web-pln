<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\ProfilPeserta;
use App\Models\ProfilMentor;
use App\Models\Logbook;
use App\Models\PenilaianAkhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $mentor = $user->profilMentor;

        $dataPribadi = [
            'nama_lengkap'  => $user->name,
            'email'         => $user->email,
            'nomor_telepon' => $mentor->nomor_telepon ?? '-',
            'nip'           => $mentor->nip ?? '-',
            'jabatan'       => $mentor->jabatan ?? '-',
            'unit_kerja'    => $mentor->unit_kerja ?? '-',
        ];

        $jumlahPeserta  = ProfilPeserta::where('mentor_id', $mentor->id)->count();
        $logbookCount   = Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $mentor->id))->count();
        $penilaianCount = PenilaianAkhir::whereHas('peserta', fn($q) => $q->where('mentor_id', $mentor->id))->count();
        $alumniCount    = ProfilPeserta::where('mentor_id', $mentor->id)->where('status_magang', 'Selesai')->count();

        $infoPenugasan = [
            'anak_bimbingan' => ['nilai' => $jumlahPeserta,  'label' => 'Peserta aktif'],
            'logbook'        => ['nilai' => $logbookCount,   'label' => 'Total logbook masuk'],
            'penilaian'      => ['nilai' => $penilaianCount, 'label' => 'Sudah dinilai'],
            'total_alumni'   => ['nilai' => $alumniCount,    'label' => 'Magang selesai'],
        ];

        // Aktivitas: logbook masuk
        $aktLogbookMasuk = Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $mentor->id))
            ->where('status', 'Menunggu Verifikasi')
            ->with('peserta.user')
            ->orderByDesc('created_at')->take(5)->get()
            ->map(fn($l) => [
                'teks'       => ($l->peserta->user->name ?? '-') . ' mengirim logbook baru.',
                'waktu'      => $l->created_at->diffForHumans(),
                'waktu_sort' => $l->created_at,
                'tipe'       => 'logbook',
            ]);

        // Aktivitas: logbook yang sudah diverifikasi mentor
        $aktLogbookVerif = Logbook::whereHas('peserta', fn($q) => $q->where('mentor_id', $mentor->id))
            ->whereIn('status', ['Disetujui', 'Perlu Revisi'])
            ->with('peserta.user')
            ->orderByDesc('updated_at')->take(5)->get()
            ->map(fn($l) => [
                'teks'       => 'Logbook ' . ($l->peserta->user->name ?? '-') . ' ' .
                                ($l->status === 'Disetujui' ? 'disetujui' : 'diminta revisi') . '.',
                'waktu'      => $l->updated_at->diffForHumans(),
                'waktu_sort' => $l->updated_at,
                'tipe'       => $l->status === 'Disetujui' ? 'approve' : 'revisi',
            ]);

        // Aktivitas: penilaian akhir
        $aktPenilaian = PenilaianAkhir::whereHas('peserta', fn($q) => $q->where('mentor_id', $mentor->id))
            ->with('peserta.user')
            ->orderByDesc('updated_at')->take(5)->get()
            ->map(fn($p) => [
                'teks'       => 'Penilaian akhir ' . ($p->peserta->user->name ?? '-') . ' telah diisi.',
                'waktu'      => $p->updated_at->diffForHumans(),
                'waktu_sort' => $p->updated_at,
                'tipe'       => 'penilaian',
            ]);

        $riwayatAktivitas = $aktLogbookMasuk
            ->concat($aktLogbookVerif)
            ->concat($aktPenilaian)
            ->sortByDesc('waktu_sort')
            ->take(5)
            ->values();

        $aktivitas = $riwayatAktivitas;

        return view('mentor.profil', compact(
            'user', 'mentor', 'dataPribadi', 'infoPenugasan', 'aktivitas', 'riwayatAktivitas'
        ));
    }

    public function edit()
    {
        $user   = Auth::user();
        $mentor = $user->profilMentor;

        $dataPribadi = [
            'nama_lengkap'  => $user->name,
            'email'         => $user->email,
            'nomor_telepon' => $mentor->nomor_telepon ?? '',
        ];

        $infoPerusahaan = [
            'nip'        => $mentor->nip ?? '',
            'jabatan'    => $mentor->jabatan ?? '',
            'divisi'     => $mentor->divisi ?? '',
            'unit_kerja' => $mentor->unit_kerja ?? '',
        ];

        // $user sebagai array supaya view bisa akses $user['name']
        $userArr = [
            'name' => $user->name,
            'id'   => $user->id,
        ];

        return view('mentor.profil-edit', [
            'user'           => $userArr,
            'mentor'         => $mentor,
            'dataPribadi'    => $dataPribadi,
            'infoPerusahaan' => $infoPerusahaan,
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user   = Auth::user();
        $mentor = $user->profilMentor;

        $data = $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'nip'           => 'nullable|string|max:50',
            'jabatan'       => 'nullable|string|max:255',
            'divisi'        => 'nullable|string|max:255',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user->update([
            'name'  => $data['nama_lengkap'],
            'email' => $data['email'],
        ]);

        $mentorData = [
            'nip'           => $data['nip'] ?? $mentor->nip,
            'nomor_telepon' => $data['nomor_telepon'] ?? $mentor->nomor_telepon,
            'jabatan'       => $data['jabatan'] ?? $mentor->jabatan,
            'divisi'        => $data['divisi'] ?? $mentor->divisi,
        ];

if ($request->hasFile('foto')) {
    $file     = $request->file('foto');
    $filename = 'mentor_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('foto_profil', $filename, 'public');
   $mentorData['foto'] = 'foto_profil/' . $filename;// simpan hanya nama file, tanpa prefix folder
}

        $mentor->update($mentorData);

        return redirect()->route('mentor.profil')->with('success', 'Profil berhasil diperbarui.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($data['password_lama'], $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama salah.']);
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('mentor.profil')->with('success', 'Password berhasil diubah.');
    }
}