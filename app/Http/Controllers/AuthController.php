<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProfilPeserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==================== REGISTER ====================

    public function showRegisterForm()
    {
        return view('auth.Register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:8|confirmed',
            'nomor_telepon'    => 'nullable|string|max:20',
            'nim'              => 'nullable|string|max:50',
            'instansi'         => 'nullable|string|max:255',
            'jurusan'          => 'nullable|string|max:255',
            'jenis_pendaftar'  => 'required|in:mahasiswa,siswa',
            'jenis_magang'     => 'required|in:Praktik Industri,Kerja Praktek,Magang Kampus Merdeka,PKL,KKN,Magang Mandiri',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after:tanggal_mulai',
            'bidang_minat'     => 'required|string|max:100',
        ], [
            'name.required'            => 'Nama wajib diisi.',
            'email.required'           => 'Email wajib diisi.',
            'email.unique'             => 'Email sudah terdaftar.',
            'password.min'             => 'Password minimal 8 karakter.',
            'password.confirmed'       => 'Konfirmasi password tidak cocok.',
            'jenis_pendaftar.required' => 'Jenis pendaftar wajib dipilih.',
            'jenis_pendaftar.in'       => 'Jenis pendaftar tidak valid.',
            'jenis_magang.required'    => 'Jenis magang wajib dipilih.',
            'jenis_magang.in'          => 'Jenis magang tidak valid.',
            'tanggal_mulai.required'   => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after'    => 'Tanggal selesai harus setelah tanggal mulai.',
            'bidang_minat.required'    => 'Bidang minat wajib dipilih.',
        ]);

        // Buat akun user baru
        $user = User::create([
            'name'               => $request->name,
            'email'              => $request->email,
            'password'           => Hash::make($request->password),
            'role'               => 'peserta',
            'status_pendaftaran' => 'menunggu',
        ]);

        // Buat profil peserta
        ProfilPeserta::create([
            'user_id'           => $user->id,
            'nim'               => $request->nim,
            'nomor_telepon'     => $request->nomor_telepon,
            'instansi'          => $request->instansi,
            'jurusan'           => $request->jurusan,
            'jenis_pendaftaran' => $request->jenis_magang,
            'periode_mulai'     => $request->tanggal_mulai,
            'periode_selesai'   => $request->tanggal_selesai,
            'divisi'            => $request->bidang_minat,
            'status_magang'     => 'Menunggu',                  // Default status magang adalah "Menunggu"
        ]);

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Akun kamu sedang menunggu persetujuan admin.');
    }

    // ==================== LOGIN ====================

    public function showLoginForm()
    {
        return view('auth.Login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        }

        $user = Auth::user();

        // Cek status pendaftaran untuk peserta
        if ($user->role === 'peserta') {
            if ($user->status_pendaftaran === 'menunggu') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun kamu masih menunggu persetujuan admin.',
                ])->withInput($request->only('email'));
            }

            if ($user->status_pendaftaran === 'ditolak') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Pendaftaran kamu ditolak. Silakan hubungi admin untuk informasi lebih lanjut.',
                ])->withInput($request->only('email'));
            }
        }

        $request->session()->regenerate();

        // Redirect sesuai role
        return match($user->role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'mentor' => redirect()->route('mentor.dashboard'),
            default  => redirect()->route('dashboard'),
        };
    }

    // ==================== LOGOUT ====================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}