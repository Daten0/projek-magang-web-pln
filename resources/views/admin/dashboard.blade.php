@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Dashboard Admin')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-blue-700">Dashboard Admin</h1>
        <p class="text-slate-500 mt-1">Pantau dan kelola seluruh aktivitas program magang secara terpusat.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="9" cy="8" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                    <circle cx="17" cy="8.5" r="2.4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">TOTAL<br>PESERTA</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['total_peserta'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="7.5" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">MENTOR<br>AKTIF</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['mentor_aktif'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="4" y="6" width="16" height="14" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">MENUNGGU VERIFIKASI PENDAFTARAN</p>
            <p class="text-xl font-bold text-amber-500 mt-1">{{ $stats['menunggu'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center text-red-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4M9 13h6M9 17h4"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">MENUNGGU VERIFIKASI LOGBOOK</p>
            <p class="text-xl font-bold text-red-500 mt-1">{{ $stats['logbook'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="9" cy="8" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                    <circle cx="17" cy="8.5" r="2.4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">PESERTA AKTIF</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['aktif'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="3" y="4" width="18" height="13" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">SERTIKAT SUDAH DITERBITKAN</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['sertifikat'] }}</p>
        </div>

    </div>

    {{-- ================= PENDAFTARAN TERBARU + AKSI CEPAT ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">

        {{-- Pendaftaran Terbaru --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-bold text-slate-800">Pendaftaran Terbaru</h2>
                <a href="{{ route('admin.validasi-pendaftaran') }}" class="text-sm font-medium text-blue-600 hover:underline">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-slate-400 border-b border-slate-100">
                            <th class="py-2 font-medium">Nama</th>
                            <th class="py-2 font-medium">Instansi</th>
                            <th class="py-2 font-medium">Tanggal Daftar</th>
                            <th class="py-2 font-medium">Status</th>
                            <th class="py-2 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($pendaftaranTerbaru as $item)
                            <tr>
                                <td class="py-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-xs flex-shrink-0">
                                            {{ $item['inisial'] }}
                                        </div>
                                        <span class="font-medium text-slate-700">{{ $item['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-slate-500">{{ $item['instansi'] }}</td>
                                <td class="py-3 text-slate-500 whitespace-nowrap">{{ $item['tanggal'] }}</td>
                                <td class="py-3">
                                    @if ($item['status'] === 'Pending')
                                        <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">Menunggu</span>
                                    @elseif ($item['status'] === 'Diterima')
                                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">Diterima</span>
                                    @else
                                        <span class="text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full whitespace-nowrap">Ditolak</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right">
                                    <button type="button" class="text-slate-400 hover:text-slate-600">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="6" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="12" cy="18" r="1.6"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4">Aksi Cepat</h2>
            <div class="space-y-2.5">
                <a href="{{ route('admin.validasi-pendaftaran') }}" class="flex items-center gap-3 bg-blue-50 hover:bg-[#0B1437] hover:text-white text-blue-700 text-sm font-semibold px-4 py-3 rounded-xl transition">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.5 9.5 2 2 3.5-4"/>
                    </svg>
                    Validasi Pendaftaran
                </a>
                <a href="{{ route('admin.manajemen-mentor') }}" class="flex items-center gap-3 bg-blue-50 hover:bg-[#0B1437] hover:text-white text-blue-700 text-sm font-semibold px-4 py-3 rounded-xl transition">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="10" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 19c0-3.3 2.9-5.5 6.5-5.5s6.5 2.2 6.5 5.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8v4M16 10h4"/>
                    </svg>
                    Tambah Mentor
                </a>
                <a href="{{ route('admin.manajemen-peserta') }}" class="flex items-center gap-3 bg-blue-50 hover:bg-[#0B1437] hover:text-white text-blue-700 text-sm font-semibold px-4 py-3 rounded-xl transition">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                        <circle cx="17" cy="8.5" r="2.4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                    </svg>
                    Kelola Peserta
                </a>
                <a href="{{ route('admin.sertifikat') }}" class="flex items-center gap-3 bg-blue-50 hover:bg-[#0B1437] hover:text-white text-blue-700 text-sm font-semibold px-4 py-3 rounded-xl transition">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4M9 13h6M9 17h4"/>
                    </svg>
                    Buat Sertifikat
                </a>
            </div>
        </div>

    </div>

    {{-- ================= MONITORING MAGANG + AKTIVITAS TERBARU ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Monitoring Magang --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-5">Monitoring Magang</h2>

            <div class="space-y-5">
                @foreach ($monitoring as $item)
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
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-slate-800 mb-4">Aktivitas Terbaru</h2>
            <div class="space-y-4">
                @foreach ($aktivitasTerbaru as $item)
                    <div class="flex items-start gap-3">
                        <span class="w-2 h-2 rounded-full {{ $item['warna'] }} flex-shrink-0 mt-1.5"></span>
                        <div>
                            <p class="text-sm font-medium text-slate-700 leading-snug">{{ $item['judul'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $item['waktu'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

@endsection