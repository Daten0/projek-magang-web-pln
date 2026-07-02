@extends('layouts.app')

@php($hideTopbar = true)

@section('title', 'Dashboard')

@section('content')

    {{-- Greeting --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Selamat Pagi, {{ $user['name'] }}!</h1>
        <p class="text-slate-500 mt-1">Berikut ringkasan progres magang Anda hari ini.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

        {{-- Total Hari Magang --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="4" y="5" width="16" height="16" rx="2"/>
                        <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                    {{ $stats['status_magang'] }}
                </span>
            </div>
            <p class="text-sm text-slate-500">Total Hari Magang</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_hari_magang'] }} Hari</p>
        </div>

        {{-- Persentase Kehadiran --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                    {{ $stats['status_kehadiran'] }}
                </span>
            </div>
            <p class="text-sm text-slate-500">Persentase Kehadiran</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['persentase_kehadiran'] }}%</p>
        </div>

        {{-- Logbook Terkirim --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-slate-500">Logbook Terkirim</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['logbook_terkirim'] }} Logbook</p>
        </div>

        {{-- Status Laporan Akhir --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="9" r="5.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-slate-500">Status Laporan Akhir</p>
            <p class="text-lg font-bold text-slate-800 mt-1">{{ $stats['status_laporan_akhir'] }}</p>
        </div>

    </div>

    {{-- ================= PROGRES + SERTIFIKAT ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">

        {{-- Progres Capaian Magang --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h2 class="font-bold text-slate-800">Progres Capaian Magang</h2>
                <span class="text-xs font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                    Periode: {{ $progres['periode'] }}
                </span>
            </div>

            <div class="space-y-5">

                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-slate-600">Durasi Magang</span>
                        <span class="font-semibold text-slate-800">{{ $progres['durasi_magang'] }}%</span>
                    </div>
                    <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" style="width: {{ $progres['durasi_magang'] }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-slate-600">Kehadiran Terverifikasi</span>
                        <span class="font-semibold text-slate-800">{{ $progres['kehadiran_terverifikasi'] }}%</span>
                    </div>
                    <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" style="width: {{ $progres['kehadiran_terverifikasi'] }}%"></div>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between text-sm mb-1.5">
                        <span class="text-slate-600">Penyelesaian Logbook</span>
                        <span class="font-semibold text-slate-800">{{ $progres['penyelesaian_logbook'] }}%</span>
                    </div>
                    <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-400 rounded-full" style="width: {{ $progres['penyelesaian_logbook'] }}%"></div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Status Sertifikat --}}
        <div class="bg-gradient-to-br from-blue-900 to-blue-600 rounded-2xl p-6 text-white flex flex-col justify-between shadow-sm">
            <div>
                <div class="w-10 h-10 rounded-xl bg-white/15 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="9" r="5.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                    </svg>
                </div>
                <h2 class="font-bold text-lg">Status Sertifikat</h2>
                <p class="text-blue-200 text-sm mt-0.5">{{ $sertifikat['instansi'] }}</p>

                <div class="flex items-center gap-2 mt-4">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span class="text-sm text-amber-300 font-medium">{{ $sertifikat['status'] }}</span>
                </div>
            </div>

            <a href="{{ route('sertifikat.index') }}" class="mt-6 bg-white text-blue-700 font-semibold text-sm py-2.5 rounded-xl flex items-center justify-center gap-2 hover:bg-blue-50 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
         <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
         <circle cx="12" cy="12" r="3"/>
     </svg>
    Lihat Sertifikat
    </a>
        </div>

    </div>

    {{-- ================= AKTIVITAS TERBARU ================= --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-bold text-slate-800">Aktivitas Terbaru</h2>
            <a href="#" class="text-sm font-medium text-blue-600 hover:underline">Lihat Semua</a>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach ($aktivitas as $item)
                <div class="flex items-center justify-between py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center
                            @if ($item['tipe'] === 'logbook_sent') bg-blue-100 text-blue-600
                            @elseif ($item['tipe'] === 'absensi') bg-green-100 text-green-600
                            @else bg-purple-100 text-purple-600
                            @endif">

                            @if ($item['tipe'] === 'logbook_sent')
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5 20 4l-7 17-3-7-7-2.5Z"/>
                                </svg>
                            @elseif ($item['tipe'] === 'absensi')
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l4-4-4-4"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H9"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 18a4 4 0 0 1-1-7.87A5 5 0 0 1 16 9a4 4 0 1 1 1 8H7Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-5M9.5 13.5 12 11l2.5 2.5"/>
                                </svg>
                            @endif

                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ $item['judul'] }}</span>
                    </div>
                    <span class="text-xs text-slate-400">{{ $item['waktu'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

@endsection