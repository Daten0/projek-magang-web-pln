@extends('layouts.app')

@php($topbarTitle = 'Edit Profil')

@section('title', 'Edit Profil')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-4">
        <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>›</span>
        <a href="{{ route('profil.index') }}" class="hover:text-blue-600 transition">Profil Peserta</a>
        <span>›</span>
        <span class="text-slate-600 font-medium">Edit Profil</span>
    </div>

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Akun</h1>
        <p class="text-slate-500 mt-1">Kelola informasi pribadi dan keamanan akun magang Anda.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="space-y-4">

            {{-- Kartu Avatar --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col items-center text-center">
                <div class="relative mb-4">
                    <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-3xl overflow-hidden">
                        {{ strtoupper(substr($user['name'], 0, 1)) }}
                    </div>
                </div>
                <p class="text-base font-bold text-slate-800">{{ $user['name'] }}</p>
                <p class="text-slate-500 text-sm mt-0.5">{{ $user['prodi'] }}</p>
                <div class="w-full mt-4 pt-4 border-t border-slate-100 space-y-2 text-sm text-left">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Status</span>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">{{ $user['status'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500">Sisa Waktu</span>
                        <span class="font-semibold text-slate-800">{{ $user['sisa_waktu'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Tips Keamanan --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-3">
                <div class="text-blue-500 flex-shrink-0 mt-0.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4M12 16h.01"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-700">Tips Keamanan</p>
                    <p class="text-xs text-blue-600 mt-0.5 leading-relaxed">
                        Gunakan kombinasi huruf besar, angka, dan simbol untuk password yang lebih kuat.
                    </p>
                </div>
            </div>

        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- ===== FORM 1: Informasi Akun ===== --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                    Informasi Akun
                </h2>

                {{-- ACTION: profil.update | METHOD: POST --}}
                <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Upload Foto --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Foto Profil <span class="text-slate-400 font-normal">(opsional)</span></label>
                        <input type="file" name="foto" accept="image/jpg,image/jpeg,image/png"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-slate-400 mt-1">Format: JPG, JPEG, PNG. Maks: 2MB.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $dataPribadi['nama_lengkap']) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $dataPribadi['email']) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $dataPribadi['nomor_telepon']) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Instansi / Universitas</label>
                            <input type="text" name="instansi" value="{{ old('instansi', $dataPribadi['instansi']) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $dataPribadi['jurusan']) }}"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Jenis Pendaftaran</label>
                            <select name="jenis_pendaftaran"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option {{ old('jenis_pendaftaran', $dataPribadi['jenis_pendaftaran']) === 'Praktik Industri' ? 'selected' : '' }}>Praktik Industri</option>
                                <option {{ old('jenis_pendaftaran', $dataPribadi['jenis_pendaftaran']) === 'KKN' ? 'selected' : '' }}>KKN</option>
                                <option {{ old('jenis_pendaftaran', $dataPribadi['jenis_pendaftaran']) === 'Magang Mandiri' ? 'selected' : '' }}>Magang Mandiri</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('profil.index') }}"
                            class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- ===== FORM 2: Ganti Password ===== --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                    </svg>
                    Ganti Password
                </h2>

                {{-- ACTION: profil.password.update | METHOD: POST --}}
                <form action="{{ route('profil.password.update') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Password Saat Ini</label>
                        <div class="relative">
                            <input type="password" name="current_password" id="current_password"
                                placeholder="••••••••"
                                class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="button" onclick="togglePass('current_password')"
                                class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Password Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1.5">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl border border-[#0B1437] text-[#0B1437] hover:bg-slate-50 text-sm font-semibold transition">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            {{-- Hapus Akun --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4">
                <div>
                    <p class="font-bold text-red-600">Hapus Akun</p>
                    <p class="text-sm text-slate-500 mt-0.5">
                        Menghapus akun akan menghilangkan akses ke seluruh data magang secara permanen.
                    </p>
                </div>
                <button type="button" onclick="document.getElementById('modalHapusAkun').classList.remove('hidden')"
                    class="flex-shrink-0 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition text-center leading-tight">
                    Hapus<br>Akun
                </button>
            </div>

            {{-- Modal Konfirmasi Hapus Akun --}}
            <div id="modalHapusAkun" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4">
                <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">Hapus Akun</h3>
                    </div>
                    <p class="text-sm text-slate-600 mb-2">Apakah Anda yakin ingin menghapus akun ini?</p>
                    <p class="text-sm text-red-500 font-medium mb-6">Seluruh data magang Anda (logbook, absensi, laporan) akan terhapus secara permanen dan tidak dapat dipulihkan.</p>
                    <div class="flex gap-3">
                        <button type="button" onclick="document.getElementById('modalHapusAkun').classList.add('hidden')"
                            class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">
                            Batal
                        </button>
                        <form method="POST" action="{{ route('profil.hapus-akun') }}" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                                Ya, Hapus Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function togglePass(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

@endsection