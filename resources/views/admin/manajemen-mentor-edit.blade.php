@extends('layouts.admin')

@php($topbarTitle = 'Edit Mentor')

@section('title', 'Edit Mentor')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-5">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>&rsaquo;</span>
        <a href="{{ route('admin.manajemen-mentor') }}" class="hover:text-blue-600 transition">Manajemen Mentor</a>
        <span>&rsaquo;</span>
        <span class="text-blue-600 font-medium">Edit Mentor</span>
    </div>

    <h1 class="text-2xl font-bold text-blue-700">Edit Data Mentor</h1>
    <p class="text-slate-500 mt-1 mb-6">Perbarui informasi personal, jabatan, dan akun login mentor.</p>

    <div class="bg-white rounded-2xl shadow-sm">

        <form id="form-edit-mentor" action="{{ route('admin.manajemen-mentor.update', $mentor['id']) }}" method="POST">
            @csrf

            {{-- ================= INFORMASI PERSONAL ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-4 p-6">
                <div>
                    <h2 class="font-bold text-slate-800">Informasi Personal</h2>
                    <p class="text-sm text-slate-400 mt-1">Informasi identitas dasar dan kontak mentor.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $mentor['nama_lengkap']) }}" required
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        @error('nama_lengkap')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nip" class="block text-sm font-medium text-slate-700 mb-1.5">NIP</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip', $mentor['nip']) }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        @error('nip')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email Perusahaan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3.5" y="5.5" width="17" height="13" rx="2"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 7 7 5.5L18.5 7"/>
                                </svg>
                            </span>
                            <input type="email" id="email" name="email" value="{{ old('email', $mentor['email']) }}" required
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nomor_telepon" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 4h3l1.5 4-2 1.5a12 12 0 0 0 6 6l1.5-2 4 1.5v3a2 2 0 0 1-2 2C9.5 20 4 14.5 4 7a2 2 0 0 1 1-2Z"/>
                                </svg>
                            </span>
                            <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon', $mentor['nomor_telepon']) }}"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        </div>
                        @error('nomor_telepon')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- ================= DETAIL PEKERJAAN ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-4 p-6">
                <div>
                    <h2 class="font-bold text-slate-800">Detail Pekerjaan</h2>
                    <p class="text-sm text-slate-400 mt-1">Informasi mengenai posisi, divisi, dan status keaktifan mentor.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-slate-700 mb-1.5">Jabatan</label>
                        <select id="jabatan" name="jabatan"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <option value="" disabled>Pilih Jabatan</option>
                            @foreach ($jabatanList as $jabatan)
                                <option value="{{ $jabatan }}" {{ old('jabatan', $mentor['jabatan']) == $jabatan ? 'selected' : '' }}>{{ $jabatan }}</option>
                            @endforeach
                        </select>
                        @error('jabatan')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="divisi" class="block text-sm font-medium text-slate-700 mb-1.5">Divisi</label>
                        <select id="divisi" name="divisi" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <option value="" disabled>Pilih Divisi</option>
                            @foreach ($divisiList as $divisi)
                                <option value="{{ $divisi }}" {{ old('divisi', $mentor['divisi']) == $divisi ? 'selected' : '' }}>{{ $divisi }}</option>
                            @endforeach
                        </select>
                        @error('divisi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Status Keaktifan</label>
                        <select id="status" name="status"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <option value="Aktif" {{ old('status', $mentor['status']) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status', $mentor['status']) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- ================= UBAH PASSWORD (OPSIONAL) ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-4 p-6">
                <div>
                    <h2 class="font-bold text-slate-800">Ubah Password</h2>
                    <p class="text-sm text-slate-400 mt-1">Kosongkan jika tidak ingin mengubah password mentor.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" minlength="8"
                                   placeholder="Minimal 8 karakter"
                                   class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <button type="button" onclick="togglePassword('password')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" minlength="8"
                                   placeholder="Ulangi password baru"
                                   class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <button type="button" onclick="togglePassword('password_confirmation')"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- ================= FOOTER ACTIONS ================= --}}
        <div class="flex items-center justify-end gap-3 px-6 py-5 border-t border-slate-100">
            <a href="{{ route('admin.manajemen-mentor') }}"
               class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-2.5 rounded-xl transition">
                Batal
            </a>

            <form action="{{ route('admin.manajemen-mentor.destroy', $mentor['id']) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus mentor ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-semibold text-sm px-5 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V5a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2m2 0-.8 12.1a2 2 0 0 1-2 1.9H9.8a2 2 0 0 1-2-1.9L7 7"/>
                    </svg>
                    Hapus Mentor
                </button>
            </form>

            <button type="submit" form="form-edit-mentor" class="flex items-center gap-2 bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21v-8h10v8M7 3v5h8"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

@endsection