<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilMentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index()
    {
        $stats = [
            'admin_aktif'  => User::where('role', 'admin')
                                ->where('status_pendaftaran', 'aktif')
                                ->count(),
            'mentor_aktif' => User::where('role', 'mentor')
                                ->where('status_pendaftaran', 'aktif')
                                ->count(),
        ];

        $akunRaw = User::whereIn('role', ['admin', 'mentor'])
            ->orderBy('role')
            ->orderBy('name')
            ->paginate(10);

        $akun = $akunRaw->map(fn($u) => [
            'id'     => $u->id,
            'nama'   => $u->name,
            'email'  => $u->email,
            'role'   => ucfirst($u->role),
            'status' => $u->status_pendaftaran === 'aktif' ? 'Aktif' : 'Nonaktif',
        ]);

        $pagination = [
            'current' => $akunRaw->currentPage(),
            'pages'   => range(1, min($akunRaw->lastPage(), 5)),
        ];

        return view('admin.pengaturan', compact('stats', 'akun', 'pagination'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:8|confirmed',
            'role'                  => 'required|in:Admin,Mentor',
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
        ]);

        $user = User::create([
            'name'               => $request->nama,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'role'               => strtolower($request->role),
            'status_pendaftaran' => 'aktif',
        ]);

        if ($user->role === 'mentor') {
            ProfilMentor::create([
                'user_id' => $user->id,
                'jabatan' => '-',
                'status'  => 'Aktif',
            ]);
        }

        return redirect()
            ->route('admin.pengaturan')
            ->with('success', 'Akun ' . $request->role . ' baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'role'     => 'required|in:Admin,Mentor',
            'status'   => 'required|in:Aktif,Nonaktif',
            'password' => 'nullable|min:8|confirmed',
        ], [
            'nama.required'   => 'Nama wajib diisi.',
            'email.required'  => 'Email wajib diisi.',
            'email.unique'    => 'Email sudah digunakan.',
            'password.min'    => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
        'name'               => $request->nama,
        'email'              => $request->email,
        'role'               => strtolower($request->role),
        'status_pendaftaran' => $request->status === 'Aktif' ? 'aktif' : 'nonaktif',
    ];

    if ($request->filled('password')) {
        $updateData['password'] = Hash::make($request->password);
    }

    $user->update($updateData);

    // Sinkronisasi status ke profil_mentor kalau role mentor
    if ($user->role === 'mentor' && $user->profilMentor) {
        $user->profilMentor->update([
            'status' => $request->status === 'Aktif' ? 'Aktif' : 'Tidak Aktif',
        ]);
    }

        return redirect()
            ->route('admin.pengaturan')
            ->with('success', 'Akun ' . $request->nama . ' berhasil diperbarui.');
    }
    public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->id === auth()->id()) {
        return redirect()->route('admin.pengaturan')
            ->with('error', 'Tidak bisa menghapus akun sendiri.');
    }

    $user->delete();

    return redirect()->route('admin.pengaturan')
        ->with('success', 'Akun ' . $user->name . ' berhasil dihapus.');
}
}