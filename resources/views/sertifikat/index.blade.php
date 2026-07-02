@extends('layouts.app')

@php($hideSearch = true)

@section('title', 'Sertifikat')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Sertifikat Magang</h1>
        <p class="text-slate-500 mt-1 max-w-2xl">Periksa status penyelesaian magang dan lihat sertifikat apabila seluruh persyaratan telah terpenuhi.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="space-y-5">

            {{-- Progress Penyelesaian --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Progress Penyelesaian</p>
                    <span class="font-bold text-slate-800">{{ $progress['persentase'] }}%</span>
                </div>
                <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden mb-6">
                    <div class="h-full bg-blue-600 rounded-full transition-all" style="width: {{ $progress['persentase'] }}%"></div>
                </div>

                <ul class="space-y-3.5">
                    @foreach ($progress['checklist'] as $item)
                        <li class="flex items-center gap-2.5 text-sm">
                            @if ($item['selesai'])
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                                </svg>
                                <span class="text-slate-700">{{ $item['label'] }}</span>
                            @else
                                <svg class="w-5 h-5 text-slate-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="9"/>
                                </svg>
                                <span class="text-slate-400">{{ $item['label'] }}</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Informasi Penting --}}
            <div class="bg-blue-50 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" d="M12 8h.01"/>
                        <path stroke-linecap="round" d="M12 11v5"/>
                    </svg>
                    <h3 class="font-bold text-slate-800 text-sm">Informasi Penting</h3>
                </div>
                <div class="space-y-2.5 text-sm text-slate-600 leading-relaxed">
                    <p>Pastikan data profil (Nama Lengkap) sudah sesuai dengan KTP untuk pencetakan sertifikat.</p>
                    <p>Sertifikat digital dapat diunduh setelah diterbitkan oleh Admin.</p>
                    <p>Sertifikat fisik dapat diambil di kantor pusat PLN unit masing-masing.</p>
                </div>
            </div>

        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Preview Sertifikat --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-slate-800">Preview Sertifikat</h2>

                    {{-- Badge status --}}
                    @if ($sertifikat['status'] === 'sudah_diterbitkan')
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            SIAP DIUNDUH
                        </span>
                    @elseif ($sertifikat['status'] === 'siap_diterbitkan')
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            MENUNGGU PENERBITAN
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            BELUM DITERBITKAN
                        </span>
                    @endif
                </div>

                {{-- Preview sertifikat --}}
                @if ($sertifikat['status'] === 'sudah_diterbitkan')
                    {{-- Tampil preview sertifikat --}}
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl py-10 px-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-white border border-slate-200 mx-auto mb-4 flex items-center justify-center shadow-sm">
                            <svg class="w-7 h-7 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="9" r="5.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                            </svg>
                        </div>
                        <p class="text-blue-900 font-bold tracking-[0.2em] text-sm">SERTIFIKAT MAGANG</p>
                        <p class="text-slate-400 text-xs mt-4">Diberikan Kepada:</p>
                        <p class="text-2xl font-bold text-slate-800 mt-1">{{ $profil->user->name }}</p>
                        <p class="text-xs text-slate-400 mt-3">{{ $sertifikat['divisi'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">Nomor: {{ $sertifikat['nomor'] }}</p>
                        <p class="text-xs text-slate-400 mt-1">Diterbitkan: {{ $sertifikat['tanggal_terbit'] }}</p>
                        <p class="text-slate-500 text-sm mt-3 max-w-md mx-auto leading-relaxed">
                            Atas keberhasilannya menyelesaikan program Internship di {{ $sertifikat['instansi'] }} untuk periode {{ $sertifikat['periode'] }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-5">
                        <a href="{{ $sertifikat['file'] ? asset('storage/' . $sertifikat['file']) : '#' }}"
                           target="_blank"
                           class="bg-amber-400 hover:bg-amber-500 text-slate-900 font-bold text-sm uppercase tracking-wide py-3 rounded-xl flex items-center justify-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Lihat Sertifikat
                        </a>
                        <form action="{{ route('sertifikat.klaim') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-[#0B1437] hover:bg-blue-900 text-white font-bold text-sm uppercase tracking-wide py-3 rounded-xl flex items-center justify-center gap-2 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                                </svg>
                                Download Sertifikat
                            </button>
                        </form>
                    </div>

                @else
                    {{-- Sertifikat belum diterbitkan --}}
                    <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl py-14 px-6 text-center">
                        <div class="w-14 h-14 rounded-full bg-slate-100 mx-auto mb-4 flex items-center justify-center">
                            <svg class="w-7 h-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="9" r="5.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-slate-500">Sertifikat Belum Diterbitkan</p>
                        <p class="text-sm text-slate-400 mt-2 max-w-sm mx-auto leading-relaxed">
                            Sertifikat akan diterbitkan oleh Admin setelah seluruh persyaratan magang terpenuhi dan diverifikasi.
                        </p>
                        @if ($progress['persentase'] < 100)
                            <p class="text-xs text-amber-600 bg-amber-50 px-4 py-2 rounded-full inline-block mt-4">
                                Selesaikan semua persyaratan terlebih dahulu ({{ $progress['persentase'] }}%)
                            </p>
                        @else
                            <p class="text-xs text-blue-600 bg-blue-50 px-4 py-2 rounded-full inline-block mt-4">
                                Semua persyaratan terpenuhi — menunggu Admin menerbitkan sertifikat
                            </p>
                        @endif
                    </div>

                    <div class="mt-4 p-4 bg-slate-50 rounded-xl text-sm text-slate-500 text-center">
                        Tombol Lihat Sertifikat akan aktif setelah sertifikat diterbitkan oleh Admin.
                    </div>
                @endif
            </div>

            {{-- Riwayat Klaim --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                    <h2 class="font-bold text-slate-800">Riwayat Sertifikat</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-400 text-xs uppercase tracking-wide border-b border-slate-100">
                                <th class="px-6 py-3.5 font-medium">Tanggal</th>
                                <th class="px-6 py-3.5 font-medium">Nama Dokumen</th>
                                <th class="px-6 py-3.5 font-medium">Status</th>
                                <th class="px-6 py-3.5 font-medium text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($riwayatKlaim as $klaim)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-slate-700 whitespace-nowrap">{{ $klaim['tanggal'] }}</td>
                                    <td class="px-6 py-4 text-slate-700">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                                            </svg>
                                            <span class="truncate max-w-[220px]">{{ $klaim['nama_dokumen'] }}</span>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-block text-xs font-medium px-2.5 py-1 rounded-full
                                            {{ $klaim['status'] === 'sudah_diterbitkan' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' }}">
                                            {{ $klaim['status'] === 'Terbit' ? 'Diterbitkan' : 'Belum Diterbitkan' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if ($klaim['file'])
                                            <a href="{{ asset('storage/' . $klaim['file']) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                                                </svg>
                                            </a>
                                        @else
                                            <span class="text-slate-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-sm">
                                        Belum ada riwayat sertifikat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

@endsection