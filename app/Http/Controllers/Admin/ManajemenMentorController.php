<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilMentor;
use App\Models\ProfilPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManajemenMentorController extends Controller
{
    public function index()
    {
        $mentors = ProfilMentor::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Stat cards
        $stats = [
            'total_mentor'      => ProfilMentor::count(),
            'mentor_aktif'      => ProfilMentor::where('status', 'Aktif')->count(),
            'peserta_dibimbing' => ProfilPeserta::whereNotNull('mentor_id')->count(),
        ];

        // Format data untuk tabel
        $mentorList = $mentors->map(function ($m) {
            $namaArr = explode(' ', $m->user->name ?? '');
            $inisial = strtoupper(substr($namaArr[0], 0, 1) . (isset($namaArr[1]) ? substr($namaArr[1], 0, 1) : ''));

            return [
                'id'      => $m->id,
                'inisial' => $inisial,
                'nama'    => $m->user->name ?? '-',
                'email'   => $m->user->email ?? '-',
                'foto'    => $m->foto,
                'jabatan' => $m->jabatan ?? '-',
                'divisi'  => $m->divisi ?? '-',
                'peserta' => ProfilPeserta::where('mentor_id', $m->id)->count(),
                'status'  => $m->status,
            ];
        });

        // Pagination info
        $pagination = [
            'total'         => $mentors->total(),
            'awal'          => $mentors->firstItem() ?? 0,
            'akhir'         => $mentors->lastItem() ?? 0,
            'halaman'       => $mentors->currentPage(),
            'total_halaman' => $mentors->lastPage(),
        ];

        return view('admin.manajemen-mentor', compact('mentorList', 'stats', 'pagination'));
    }

    public function create()
    {
        $jabatanList = [
            'Senior Engineer',
            'Staff IT',
            'Project Manager',
            'HR Specialist',
            'Lead Engineer',
            'Supervisor',
        ];

        $divisiList = [
            'IT Development',
            'Sistem Informasi',
            'SDM & Umum',
            'Distribusi',
            'Transmisi',
            'Keuangan',
            'K3 & Lingkungan',
        ];

        return view('admin.manajemen-mentor-tambah', compact('jabatanList', 'divisiList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8|confirmed',
            'nip'           => 'nullable|string|max:50',
            'nomor_telepon' => 'nullable|string|max:20',
            'jabatan'       => 'nullable|string|max:255',
            'divisi'        => 'nullable|string|max:255',
        ], [
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah terdaftar.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'               => $request->nama_lengkap,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'role'               => 'mentor',
            'status_pendaftaran' => 'aktif',
        ]);

        ProfilMentor::create([
            'user_id'       => $user->id,
            'nip'           => $request->nip,
            'nomor_telepon' => $request->nomor_telepon,
            'jabatan'       => $request->jabatan,
            'divisi'        => $request->divisi,
            'status'        => 'Aktif',
        ]);

        return redirect()->route('admin.manajemen-mentor')
            ->with('success', "Mentor {$request->nama_lengkap} berhasil ditambahkan.");
    }

    /**
     * Tampilkan form edit mentor.
     *
     * $mentor dikirim sebagai array (bukan Eloquent Model) dengan key
     * sesuai nama field di form, supaya old('field', $mentor['field'])
     * di Blade bisa bekerja dengan tepat.
     */
    public function edit($id)
    {
        $m = ProfilMentor::with('user')->findOrFail($id);

        $mentor = [
            'id'            => $m->id,
            'nama_lengkap'  => $m->user->name ?? '',
            'email'         => $m->user->email ?? '',
            'nip'           => $m->nip ?? '',
            'nomor_telepon' => $m->nomor_telepon ?? '',
            'jabatan'       => $m->jabatan ?? '',
            'divisi'        => $m->divisi ?? '',
            'status'        => $m->status ?? 'Aktif',
        ];

        $jabatanList = [
            'Senior Engineer',
            'Staff IT',
            'Project Manager',
            'HR Specialist',
            'Lead Engineer',
            'Supervisor',
        ];

        $divisiList = [
            'IT Development',
            'Sistem Informasi',
            'SDM & Umum',
            'Distribusi',
            'Transmisi',
            'Keuangan',
            'K3 & Lingkungan',
        ];

        return view('admin.manajemen-mentor-edit', compact('mentor', 'jabatanList', 'divisiList'));
    }

    /**
     * Simpan perubahan data mentor. Password & konfirmasi opsional —
     * kalau diisi keduanya wajib cocok (confirmed), kalau dikosongkan
     * password lama tetap dipakai.
     */
    public function update(Request $request, $id)
    {
        $mentor = ProfilMentor::with('user')->findOrFail($id);

        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $mentor->user_id,
            'nip'           => 'nullable|string|max:50',
            'nomor_telepon' => 'nullable|string|max:20',
            'jabatan'       => 'nullable|string|max:255',
            'divisi'        => 'nullable|string|max:255',
            'status'        => 'nullable|in:Aktif,Tidak Aktif',
            'password'      => 'nullable|min:8|confirmed',
        ], [
            'nama_lengkap.required' => 'Nama wajib diisi.',
            'email.required'        => 'Email wajib diisi.',
            'email.unique'          => 'Email sudah digunakan.',
            'password.min'          => 'Password minimal 8 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $mentor->user->update([
            'name'  => $request->nama_lengkap,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $mentor->user->update(['password' => Hash::make($request->password)]);
        }

        $mentor->update([
            'nip'           => $request->nip,
            'nomor_telepon' => $request->nomor_telepon,
            'jabatan'       => $request->jabatan,
            'divisi'        => $request->divisi,
            'status'        => $request->status ?? $mentor->status,
        ]);

        return redirect()->route('admin.manajemen-mentor')
            ->with('success', "Data mentor {$request->nama_lengkap} berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $mentor = ProfilMentor::with('user')->findOrFail($id);
        $nama   = $mentor->user->name;
        $mentor->user->delete();

        return redirect()->route('admin.manajemen-mentor')
            ->with('success', "Mentor {$nama} berhasil dihapus.");
    }
}