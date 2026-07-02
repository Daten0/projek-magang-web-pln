@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Manajemen Peserta')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Manajemen Peserta Magang</h1>
        <p class="text-slate-500 mt-1">Kelola data peserta magang, penempatan divisi, mentor pembimbing, dan status program magang secara efisien dalam satu portal terpadu.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6 max-w-4xl">

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Total Peserta</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                        <circle cx="17" cy="8.5" r="2.4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['total_peserta'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Peserta Aktif</p>
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-500 flex-shrink-0">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2 4 14h6l-1 8 9-12h-6l1-8Z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['peserta_aktif'] }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Saat ini sedang magang</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Magang Selesai</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['magang_selesai'] }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Tahun akademik 2026</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-sm text-slate-500">Peserta Tidak Aktif</p>
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" d="M9 9l6 6M15 9l-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">{{ $stats['peserta_tidak_aktif'] }}</p>
            <p class="text-xs text-slate-400 mt-0.5">Nonaktif/bermasalah</p>
        </div>

    </div>

    {{-- ================= SEARCH & FILTER ================= --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-5 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="6.5"/>
                    <path stroke-linecap="round" d="m20 20-3.5-3.5"/>
                </svg>
            </span>
            <input type="text" placeholder="Nama, instansi, divisi..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>

        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Selesai</option>
            <option>Tidak Aktif</option>
        </select>

        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Semua Divisi</option>
            <option>Sistem Informasi</option>
            <option>SDM & Umum</option>
            <option>Distribusi</option>
            <option>Transmisi</option>
        </select>

    </div>

    {{-- ================= TABEL PESERTA ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 border-b border-slate-100">
                        <th class="py-3 px-5 font-medium">NAMA PESERTA</th>
                        <th class="py-3 px-2 font-medium">INSTANSI</th>
                        <th class="py-3 px-2 font-medium">DIVISI</th>
                        <th class="py-3 px-2 font-medium">MENTOR</th>
                        <th class="py-3 px-2 font-medium">PERIODE<br>MAGANG</th>
                        <th class="py-3 px-2 font-medium">STATUS</th>
                        <th class="py-3 px-5 font-medium text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($pesertaList as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    @if (!empty($p['foto']))
                                        <img src="{{ asset('storage/' . $p['foto']) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $p['nama'] }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                            {{ $p['inisial'] }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-blue-700">{{ $p['nama'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $p['nim'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-slate-500">{{ $p['instansi'] }}</td>
                            <td class="py-4 px-2">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                    {{ $p['divisi'] }}
                                </span>
                            </td>
                            <td class="py-4 px-2">
                                <p class="text-slate-700">{{ $p['mentor'] }}</p>
                                <p class="text-xs text-slate-400">{{ $p['mentor_jabatan'] }}</p>
                            </td>
                            <td class="py-4 px-2 text-slate-500 whitespace-nowrap">{{ $p['periode'] }}</td>
                            <td class="py-4 px-2">
                                @if ($p['status'] === 'Aktif')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                    </span>
                                @elseif ($p['status'] === 'Selesai')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-100 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('admin.manajemen-peserta.edit', $p['id']) }}" class="inline-flex text-slate-400 hover:text-slate-600">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="6" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="12" cy="18" r="1.6"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $pagination['awal'] }}-{{ $pagination['akhir'] }} dari {{ $pagination['total'] }} peserta
            </p>
            <div class="flex items-center gap-1.5">
                <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-400 flex items-center justify-center hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
                </button>
                <button class="w-8 h-8 rounded-lg text-sm font-semibold flex items-center justify-center bg-blue-600 text-white">1</button>
                <button class="w-8 h-8 rounded-lg text-sm font-semibold flex items-center justify-center text-slate-500 hover:bg-slate-50">2</button>
                <button class="w-8 h-8 rounded-lg text-sm font-semibold flex items-center justify-center text-slate-500 hover:bg-slate-50">3</button>
                <span class="text-slate-400 text-sm px-1">...</span>
                <button class="w-8 h-8 rounded-lg text-sm font-semibold flex items-center justify-center text-slate-500 hover:bg-slate-50">{{ $pagination['total_halaman'] }}</button>
                <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-400 flex items-center justify-center hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>

@endsection