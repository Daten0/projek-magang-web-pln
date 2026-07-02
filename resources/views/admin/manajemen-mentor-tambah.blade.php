@extends('layouts.admin')

@php($topbarTitle = 'Tambah Mentor')

@section('title', 'Tambah Mentor')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-5">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>&rsaquo;</span>
        <a href="{{ route('admin.manajemen-mentor') }}" class="hover:text-blue-600 transition">Manajemen Mentor</a>
        <span>&rsaquo;</span>
        <span class="text-blue-600 font-medium">Tambah Mentor</span>
    </div>

    <h1 class="text-2xl font-bold text-blue-700">Tambah Mentor Baru</h1>
    <p class="text-slate-500 mt-1 mb-6">Lengkapi informasi personal, jabatan, dan akun login mentor baru.</p>

    <div class="bg-white rounded-2xl shadow-sm">

        <form id="form-tambah-mentor" action="{{ route('admin.manajemen-mentor.store') }}" method="POST">
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
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               placeholder="Masukkan nama sesuai KTP"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        @error('nama_lengkap')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nip" class="block text-sm font-medium text-slate-700 mb-1.5">NIP</label>
                        <input type="text" id="nip" name="nip" value="{{ old('nip') }}"
                               placeholder="Contoh: 85132049ZY"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
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
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama.pegawai@pln.co.id"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
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
                            <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                   placeholder="+62 812 3456 7890"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
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
                    <p class="text-sm text-slate-400 mt-1">Informasi mengenai posisi dan divisi penugasan di PLN.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-slate-700 mb-1.5">Jabatan</label>
                        <select id="jabatan" name="jabatan"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <option value="" disabled {{ old('jabatan') ? '' : 'selected' }}>Pilih Jabatan</option>
                            @foreach ($jabatanList as $jabatan)
                                <option value="{{ $jabatan }}" {{ old('jabatan') == $jabatan ? 'selected' : '' }}>{{ $jabatan }}</option>
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
                            <option value="" disabled {{ old('divisi') ? '' : 'selected' }}>Pilih Divisi</option>
                            @foreach ($divisiList as $divisi)
                                <option value="{{ $divisi }}" {{ old('divisi') == $divisi ? 'selected' : '' }}>{{ $divisi }}</option>
                            @endforeach
                        </select>
                        @error('divisi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100"></div>

            {{-- ================= AKUN LOGIN MENTOR ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-[220px_1fr] gap-x-8 gap-y-4 p-6">
                <div>
                    <h2 class="font-bold text-slate-800">Akun Login Mentor</h2>
                    <p class="text-sm text-slate-400 mt-1">Password ini akan digunakan mentor untuk masuk ke sistem.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required minlength="8"
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
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8"
                                   placeholder="Ulangi password"
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

            <div class="px-6 pb-6">
                <div class="flex items-start gap-3 bg-blue-50 text-blue-700 rounded-xl px-4 py-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v5M12 8h.01"/>
                    </svg>
                    <p class="text-sm">Akun login mentor akan otomatis dibuat menggunakan email dan password ini begitu data disimpan.</p>
                </div>
            </div>
        </form>

        {{-- ================= FOOTER ACTIONS ================= --}}
        <div class="flex items-center justify-end gap-3 px-6 py-5 border-t border-slate-100">
            <a href="{{ route('admin.manajemen-mentor') }}"
               class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-2.5 rounded-xl transition">
                Batal
            </a>

            <button type="submit" form="form-tambah-mentor" class="flex items-center gap-2 bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Mentor
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