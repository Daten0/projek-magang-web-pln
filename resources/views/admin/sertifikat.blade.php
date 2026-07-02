@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Manajemen Sertifikat')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Manajemen Sertifikat Magang</h1>
        <p class="text-slate-500 mt-1">Kelola penerbitan sertifikat, verifikasi kelulusan peserta, dan proses klaim sertifikat magang.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6 max-w-3xl">

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Total Peserta Selesai</p>
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                        <circle cx="17" cy="8.5" r="2.4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['total_selesai'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Siap Diterbitkan</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5 2 2 4-4.5"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['siap_diterbitkan'] }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Menunggu diterbitkan</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Sudah Terbit</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="9" r="5.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['sudah_terbit'] }}</p>
        </div>

    </div>

    {{-- ================= FILTER & SEARCH ================= --}}
    <div class="bg-white rounded-2xl shadow-sm mb-5">

        <div class="p-5 flex flex-col sm:flex-row items-stretch sm:items-center gap-3">

            {{-- Search --}}
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                    </svg>
                </span>
                <input type="text" placeholder="Cari Nama, Divisi, atau Mentor..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
            </div>

            {{-- Filter Divisi --}}
            <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                <option>Semua Divisi</option>
                <option>Ti &amp; Komunikasi</option>
                <option>Distribusi</option>
                <option>SDM &amp; Umum</option>
                <option>Transmisi</option>
            </select>

            {{-- Filter Status --}}
            <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                <option>Semua Status</option>
                <option>Sudah Diterbitkan</option>
                <option>Siap Diterbitkan</option>
                <option>Belum Memenuhi Syarat</option>
            </select>

        </div>

        {{-- ================= TABEL ================= --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-t border-slate-100 bg-slate-50 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        <th class="px-6 py-3 text-left">Nama Peserta</th>
                        <th class="px-4 py-3 text-left">Divisi</th>
                        <th class="px-4 py-3 text-left">Mentor</th>
                        <th class="px-4 py-3 text-left">Laporan</th>
                        <th class="px-4 py-3 text-left">Penilaian</th>
                        <th class="px-4 py-3 text-left">Status Sertifikat</th>
                        <th class="px-4 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">

                    @foreach ($peserta as $item)
                    <tr class="hover:bg-slate-50 transition">

                        {{-- Nama --}}
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                 @if (!empty($item['foto']))
                                        <img src="{{ asset('storage/' . $item['foto']) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $item['nama'] }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                            {{ $item['inisial'] }}
                                        </div>
                                    @endif
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $item['nama'] }}</p>
                                    <p class="text-xs text-slate-400">{{ $item['posisi'] }}</p>
                                </div>
                            </div>
                        </td>

                        {{-- Divisi --}}
                        <td class="px-4 py-4 text-slate-600">{{ $item['divisi'] }}</td>

                        {{-- Mentor --}}
                        <td class="px-4 py-4 text-slate-600">{{ $item['mentor'] }}</td>

                        {{-- Laporan --}}
                        <td class="px-4 py-4">
                            @if ($item['laporan'] === 'Selesai' || $item['laporan'] === 'Diterima')
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/>
                                    </svg>
                                    Menunggu
                                </span>
                            @endif
                        </td>

                        {{-- Penilaian --}}
                        <td class="px-4 py-4">
                            @if ($item['penilaian'])
                                <span class="font-semibold text-slate-800">{{ $item['penilaian'] }}</span>
                                <span class="text-slate-400 text-xs"> / 100</span>
                            @else
                                <span class="text-slate-400 text-xs">Belum dinilai</span>
                            @endif
                        </td>

                        {{-- Status Sertifikat --}}
                        <td class="px-4 py-4">
                            @if ($item['status_sertifikat'] === 'sudah_diterbitkan')
                                <span class="text-xs font-bold text-blue-700 tracking-wide">SUDAH<br>DITERBITKAN</span>
                            @elseif ($item['status_sertifikat'] === 'siap_diterbitkan')
                                <span class="text-xs font-bold text-amber-500 tracking-wide">SIAP<br>DITERBITKAN</span>
                            @else
                                <span class="text-xs font-bold text-red-400 tracking-wide">BELUM<br>MEMENUHI SYARAT</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td class="px-4 py-4">
                            @if ($item['status_sertifikat'] === 'sudah_diterbitkan')
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.sertifikat.show', $item['id']) }}"
                                       class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center text-slate-500 transition"
                                       title="Lihat Sertifikat">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </a>
                                    <a href="#"
                                       class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-green-50 hover:text-green-600 flex items-center justify-center text-slate-500 transition"
                                       title="Unduh Sertifikat">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v13M8 12l4 4 4-4"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16"/>
                                        </svg>
                                    </a>
                                </div>
                            @elseif ($item['status_sertifikat'] === 'siap_diterbitkan')
                                <a href="{{ route('admin.sertifikat.show', $item['id']) }}"
                                   class="inline-block px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition">
                                    Terbitkan
                                </a>
                            @else
                                <a href="{{ route('admin.sertifikat.show', $item['id']) }}"
                                   class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-400 transition"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v1M12 11v5"/>
                                    </svg>
                                </a>
                            @endif
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="px-6 py-4 flex items-center justify-between border-t border-slate-100">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $pagination['dari'] }}-{{ $pagination['sampai'] }} dari {{ $pagination['total'] }} peserta
            </p>
            <div class="flex items-center gap-1">
                <a href="#" class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                @foreach ($pagination['pages'] as $page)
                    <a href="#" class="w-8 h-8 rounded-lg text-sm font-medium flex items-center justify-center transition
                        {{ $page == $pagination['current'] ? 'bg-blue-600 text-white' : 'border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                        {{ $page }}
                    </a>
                @endforeach
                <a href="#" class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>

@endsection