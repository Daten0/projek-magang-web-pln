@extends('layouts.mentor')

@section('title', 'Penilaian Akhir')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Penilaian Akhir Peserta Magang</h1>
        <p class="text-slate-500 mt-1">Berikan penilaian akhir kepada peserta magang berdasarkan performa selama masa magang.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        {{-- Total Anak Bimbingan --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="9" cy="8" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                    <circle cx="17" cy="8.5" r="2.4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 tracking-wide">TOTAL ANAK<br>BIMBINGAN</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_bimbingan'] }}</p>
            </div>
        </div>

        {{-- Belum Dinilai --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="4" y="6" width="16" height="14" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 tracking-wide">BELUM DINILAI</p>
                <p class="text-2xl font-bold text-red-500 mt-1">{{ $stats['belum_dinilai'] }}</p>
            </div>
        </div>

        {{-- Sudah Dinilai --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 tracking-wide">SUDAH DINILAI</p>
                <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['sudah_dinilai'] }}</p>
            </div>
        </div>

        {{-- Menunggu Penyelesaian --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3.5 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 tracking-wide">MENUNGGU<br>PENYELESAIAN</p>
                <p class="text-2xl font-bold text-blue-500 mt-1">{{ $stats['menunggu'] }}</p>
            </div>
        </div>

    </div>

    {{-- ================= FILTER BAR ================= --}}
    <div class="bg-white rounded-2xl px-5 py-4 shadow-sm mb-5 flex flex-wrap items-center gap-3">
        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Status Penilaian: Semua</option>
            <option>Sudah Dinilai</option>
            <option>Belum Dinilai</option>
        </select>

        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Periode: 2024 Genap</option>
            <option>Periode: 2024 Ganjil</option>
            <option>Periode: 2025 Genap</option>
        </select>

        <p class="text-sm text-slate-400 ml-auto">
            Menampilkan {{ $pagination['awal'] }}-{{ $pagination['akhir'] }} dari {{ $pagination['total'] }} peserta
        </p>
    </div>

    {{-- ================= TABEL PENILAIAN ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs font-bold text-slate-400 tracking-wide bg-blue-50/60 border-b border-slate-100">
                        <th class="py-3.5 px-5 font-bold">NAMA PESERTA</th>
                        <th class="py-3.5 px-2 font-bold">DIVISI</th>
                        <th class="py-3.5 px-2 font-bold">PERIODE<br>MAGANG</th>
                        <th class="py-3.5 px-2 font-bold">STATUS<br>PENILAIAN</th>
                        <th class="py-3.5 px-5 font-bold text-right">AKSI</th>
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
                                    <span class="font-semibold text-slate-700">{{ $p['nama'] }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-slate-500">{{ $p['divisi'] }}</td>
                            <td class="py-4 px-2 text-slate-500 whitespace-nowrap">{{ $p['periode'] }}</td>
                            <td class="py-4 px-2">
                                @if ($p['status'] === 'Sudah Dinilai')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sudah Dinilai
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Belum Dinilai
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('mentor.penilaian-akhir.show', $p['id']) }}" class="inline-block border border-blue-200 text-blue-600 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-50 transition whitespace-nowrap">
                                    Beri Nilai
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-center gap-1.5 px-5 py-4 border-t border-slate-100">
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-400 flex items-center justify-center hover:bg-slate-50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
            </button>
            @for ($i = 1; $i <= $pagination['total_halaman']; $i++)
                <button class="w-8 h-8 rounded-lg text-sm font-semibold flex items-center justify-center
                    {{ $i === $pagination['halaman'] ? 'bg-blue-600 text-white' : 'text-slate-500 hover:bg-slate-50' }}">
                    {{ $i }}
                </button>
            @endfor
            <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-400 flex items-center justify-center hover:bg-slate-50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
            </button>
        </div>
    </div>

@endsection