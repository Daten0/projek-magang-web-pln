@extends('layouts.app')

@php($hideSearch = true)

@section('title', 'Profil Peserta')

@section('content')

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-blue-700">Profil Peserta</h1>
            <p class="text-slate-500 mt-1">Kelola informasi pribadi dan data magang Anda.</p>
        </div>
        <a href="{{ route('profil.edit') }}" class="border border-blue-200 text-blue-600 text-sm font-semibold px-5 py-2.5 rounded-full flex items-center gap-2 hover:bg-blue-50 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h4l10-10-4-4L4 16v4Z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="m13 7 4 4"/>
            </svg>
            Edit Profil
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Kartu profil singkat --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm flex items-center gap-5">
                {{-- Avatar / Foto Profil --}}
                @if ($peserta->foto)
                    <img src="{{ asset('storage/' . $peserta->foto) }}"
                         class="w-20 h-20 rounded-full object-cover flex-shrink-0"
                         alt="{{ $user['name'] }}">
                @else
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-2xl flex-shrink-0">
                        {{ strtoupper(substr($user['name'], 0, 1)) }}
                    </div>
                @endif
                <div>
                    <div class="flex items-center gap-2">
                        <p class="text-lg font-bold text-slate-800">{{ $user['name'] }}</p>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">{{ strtoupper($user['status']) }}</span>
                    </div>
                    <p class="text-slate-500 text-sm mt-1">Divisi: {{ $user['divisi'] }}</p>
                </div>
            </div>

            {{-- Data Pribadi --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="mb-5">
                    <h2 class="font-bold text-slate-800">Data Pribadi</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Nama Lengkap</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['nama_lengkap'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Email</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['email'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Nomor Telepon</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['nomor_telepon'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Instansi/Universitas</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['instansi'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Jurusan</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['jurusan'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Jenis Pendaftaran</p>
                        <p class="text-slate-700 font-medium">{{ $dataPribadi['jenis_pendaftaran'] }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= KOLOM KANAN: INFORMASI MAGANG ================= --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm h-fit">
            <h2 class="font-bold text-slate-800 mb-5">Informasi Magang</h2>

            <div class="flex items-start gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="6" width="18" height="13" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Unit/Divisi</p>
                    <p class="text-slate-700 font-medium mt-0.5">{{ $infoMagang['unit_divisi'] }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 mb-5">
                <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Nama Mentor</p>
                    <p class="text-slate-700 font-medium mt-0.5">{{ $infoMagang['nama_mentor'] }}</p>
                </div>
            </div>

            <hr class="border-slate-100 mb-5">

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Mulai</p>
                    <p class="text-slate-700 font-medium mt-0.5">{{ $infoMagang['mulai'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400 uppercase tracking-wide">Selesai</p>
                    <p class="text-slate-700 font-medium mt-0.5">{{ $infoMagang['selesai'] }}</p>
                </div>
            </div>

            <hr class="border-slate-100 mb-5">

            <div>
                <p class="text-xs text-slate-400 uppercase tracking-wide mb-1">Durasi</p>
                <div class="flex items-center justify-between">
                    <p class="text-slate-800 font-bold">{{ $infoMagang['durasi'] }}</p>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">{{ $infoMagang['status_magang'] }}</span>
                </div>
            </div>
        </div>

    </div>

@endsection