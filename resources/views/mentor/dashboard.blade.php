@extends('layouts.mentor')

@php($hideTopbar = true)

@section('title', 'Dashboard Mentor')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Dashboard Mentor</h1>
        <p class="text-slate-500 mt-1">Pantau perkembangan peserta magang dan lakukan verifikasi aktivitas magang harian.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        {{-- Jumlah Peserta --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="9" cy="8" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                    <circle cx="17" cy="8.5" r="2.4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Jumlah Peserta</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['jumlah_peserta'] }} <span class="text-base font-semibold">Peserta</span></p>
            </div>
        </div>

        {{-- Logbook Menunggu --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Logbook Menunggu</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['logbook_menunggu'] }} <span class="text-base font-semibold">Logbook</span></p>
            </div>
        </div>

        {{-- Penilaian Belum --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.6 5.3 5.9.8-4.3 4.1 1 5.8L12 16.3l-5.2 2.7 1-5.8-4.3-4.1 5.9-.8L12 3Z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Penilaian Belum</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['penilaian_belum'] }} <span class="text-base font-semibold">Peserta</span></p>
            </div>
        </div>

        {{-- Peserta Aktif --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="7" width="18" height="13" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Peserta Aktif</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['peserta_aktif'] }} <span class="text-base font-semibold">Peserta</span></p>
            </div>
        </div>

    </div>

    {{-- ================= PERHATIAN DIPERLUKAN ================= --}}
    <div class="bg-[#0B1437] rounded-2xl p-5 mb-6 flex items-center justify-between gap-4 flex-wrap">
        <div class="flex items-start gap-3">
            <div class="w-9 h-9 rounded-full bg-amber-400/20 flex items-center justify-center text-amber-400 flex-shrink-0 mt-0.5">
                <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4M12 17h.01M10.3 3.9 2.7 17a1.8 1.8 0 0 0 1.6 2.7h15.4a1.8 1.8 0 0 0 1.6-2.7L13.7 3.9a1.8 1.8 0 0 0-3.4 0Z"/>
                </svg>
            </div>
            <div>
                <p class="text-white font-bold">Perhatian Diperlukan</p>
                <ul class="text-blue-200 text-sm mt-1 space-y-0.5">
                    @foreach ($perhatian as $item)
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <a href="{{ $urgentRoute }}" class="bg-white text-blue-700 font-semibold text-sm px-5 py-2.5 rounded-xl hover:bg-blue-50 transition flex-shrink-0">
    Periksa Sekarang
</a>
    </div>

    {{-- ================= LOGBOOK MENUNGGU VERIFIKASI + AKTIVITAS TERBARU ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- Logbook Menunggu Verifikasi --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-800">Logbook Menunggu Verifikasi</h2>
                <a href="{{ route('mentor.verifikasi-logbook') }}" class="text-sm font-medium text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-slate-400 border-b border-slate-100">
                            <th class="py-2 font-medium">PESERTA</th>
                            <th class="py-2 font-medium">TANGGAL</th>
                            <th class="py-2 font-medium">AKTIVITAS</th>
                            <th class="py-2 font-medium">STATUS</th>
                            <th class="py-2 font-medium"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($logbookMenunggu as $item)
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-xs flex-shrink-0">
                                            {{ strtoupper(substr($item['nama'], 0, 1)) }}
                                        </div>
                                        <span class="font-medium text-slate-700">{{ $item['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-slate-500">{{ $item['tanggal'] }}</td>
                                <td class="py-3 text-slate-500">{{ $item['aktivitas'] }}</td>
                                <td class="py-3">
                                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        {{ $item['status'] }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <button type="button" class="text-slate-400 hover:text-blue-600">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                @foreach ($aktivitas as $item)
                    <div class="flex items-start gap-3">
                        <span class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0 mt-1.5"></span>
                        <div>
                            <p class="text-sm font-medium text-slate-700 leading-snug">{{ $item['judul'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $item['waktu'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ================= DAFTAR ANAK BIMBINGAN + PROGRESS ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        {{-- Daftar Anak Bimbingan --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-800">Daftar Anak Bimbingan</h2>
                <a href="{{ route('mentor.anak-magang') }}" class="text-sm font-semibold text-blue-600 border border-blue-200 px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @foreach ($anakBimbingan as $anak)
                    <div class="flex items-center justify-between bg-slate-50 rounded-xl p-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                {{ $anak['inisial'] }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-700">{{ $anak['nama'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $anak['asal'] }} • {{ $anak['divisi'] }}</p>
                            </div>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap
                            {{ $anak['status'] === 'AKTIF' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                            {{ $anak['status'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Progress Penyelesaian Magang --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-5">Progress Penyelesaian Magang</h2>

            <div class="space-y-5">
                @foreach ($progress as $item)
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600">{{ $item['label'] }}</span>
                            <span class="font-semibold text-slate-800">{{ $item['persen'] }}%</span>
                        </div>
                        <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $item['warna'] }} rounded-full" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-xs text-slate-400 mt-5 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4M12 16h.01"/>
                </svg>
                Data dihitung berdasarkan rata-rata dari {{ $stats['peserta_aktif'] }} peserta aktif.
            </p>
        </div>

    </div>

@endsection