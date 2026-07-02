@extends('layouts.mentor')

@section('title', 'Profil Mentor')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Profil Mentor</h1>
        <p class="text-slate-500 mt-1">Kelola informasi pribadi, data penugasan, dan keamanan akun Anda.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Kartu profil singkat --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm flex items-center gap-5 mb-6">
        @if ($mentor->foto)
            <img src="{{ asset('storage/' . $mentor->foto) }}"
                 class="w-20 h-20 rounded-2xl object-cover flex-shrink-0"
                 alt="{{ $user->name }}">
        @else
            <div class="w-20 h-20 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-2xl flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <p class="text-lg font-bold text-slate-800">{{ $user->name }}</p>
            <a href="{{ route('mentor.profil.edit') }}" class="mt-2 inline-flex items-center gap-2 bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-4 py-2 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h4l10-10-4-4L4 16v4Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m13 7 4 4"/>
                </svg>
                Edit Profil
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Pribadi --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                    <h2 class="font-bold text-slate-800">Informasi Pribadi</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Nama Lengkap</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['nama_lengkap'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Alamat Email</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['email'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Nomor Telepon</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['nomor_telepon'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">NIP</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['nip'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Jabatan</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['jabatan'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Unit Kerja</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['unit_kerja'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Keamanan & Akun --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <svg class="w-5 h-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                    </svg>
                    <h2 class="font-bold text-slate-800">Keamanan & Akun</h2>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 text-sm rounded-xl px-4 py-3 mb-5">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('mentor.profil.update') }}" method="POST" class="space-y-5">
                    @csrf

                    <p class="text-sm font-semibold text-slate-700">Ubah Kata Sandi</p>

                    <div>
                        <label for="password_lama" class="block text-xs font-medium text-slate-500 mb-1.5">Kata Sandi Saat Ini</label>
                        <input type="password" id="password_lama" name="password_lama" placeholder="••••••••"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('password_lama') border-red-400 @enderror">
                        @error('password_lama')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-xs font-medium text-slate-500 mb-1.5">Kata Sandi Baru</label>
                            <input type="password" id="password" name="password" placeholder="Min. 8 karakter"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('password') border-red-400 @enderror">
                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-xs font-medium text-slate-500 mb-1.5">Konfirmasi Sandi Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi sandi baru"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        </div>
                    </div>

                    <button type="submit" class="bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm px-6 py-2.5 rounded-xl transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="space-y-6">

            {{-- Informasi Penugasan --}}
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Informasi Penugasan</p>
                <div class="grid grid-cols-2 gap-3">

                    <div class="bg-white rounded-2xl p-4 shadow-sm">
                        <p class="text-xs text-slate-400 mb-1">Anak Bimbingan</p>
                        <p class="text-xl font-bold text-slate-800">{{ str_pad($infoPenugasan['anak_bimbingan']['nilai'], 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-xs text-blue-600 font-medium mt-0.5">{{ $infoPenugasan['anak_bimbingan']['label'] }}</p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 shadow-sm">
                        <p class="text-xs text-slate-400 mb-1">Total Alumni</p>
                        <p class="text-xl font-bold text-slate-800">{{ $infoPenugasan['total_alumni']['nilai'] }}</p>
                        <p class="text-xs text-green-600 font-medium mt-0.5">{{ $infoPenugasan['total_alumni']['label'] }}</p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 shadow-sm">
                        <p class="text-xs text-slate-400 mb-1">Logbook</p>
                        <p class="text-xl font-bold text-slate-800">{{ str_pad($infoPenugasan['logbook']['nilai'], 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-xs text-amber-600 font-medium mt-0.5">{{ $infoPenugasan['logbook']['label'] }}</p>
                    </div>

                    <div class="bg-white rounded-2xl p-4 shadow-sm">
                        <p class="text-xs text-slate-400 mb-1">Penilaian</p>
                        <p class="text-xl font-bold text-slate-800">{{ str_pad($infoPenugasan['penilaian']['nilai'], 2, '0', STR_PAD_LEFT) }}</p>
                        <p class="text-xs text-red-600 font-medium mt-0.5">{{ $infoPenugasan['penilaian']['label'] }}</p>
                    </div>

                </div>
            </div>

            {{-- Riwayat Aktivitas --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="font-bold text-slate-800 mb-5">Riwayat Aktivitas</h2>

                <ul class="space-y-4">
                    @forelse ($riwayatAktivitas as $aktivitas)
                        <li class="flex items-start gap-3">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5
                                @if ($aktivitas['tipe'] === 'approve') bg-blue-100 text-blue-600
                                @elseif ($aktivitas['tipe'] === 'revisi') bg-amber-100 text-amber-600
                                @elseif ($aktivitas['tipe'] === 'penilaian') bg-purple-100 text-purple-600
                                @else bg-slate-100 text-slate-500
                                @endif">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h4l10-10-4-4L4 16v4Z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-slate-700 leading-snug">{{ $aktivitas['teks'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $aktivitas['waktu'] }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-slate-400">Belum ada aktivitas.</li>
                    @endforelse
                </ul>
            </div>

        </div>

    </div>

@endsection