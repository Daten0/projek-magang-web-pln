@extends('layouts.admin')

@section('title', 'Monitoring Magang')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Monitoring Magang</h1>
        <p class="text-slate-500 mt-1">Pantau aktivitas, progres, dan penyelesaian program magang seluruh peserta secara terpusat.</p>
    </div>

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="9" cy="8" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                    <circle cx="17" cy="8.5" r="2.4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">TOTAL PESERTA<br>AKTIF</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['total_peserta_aktif'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center text-green-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="4" y="5" width="16" height="16" rx="2"/>
                    <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 14 2 2 4-4"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">HADIR HARI INI</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['hadir_hari_ini'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center text-red-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4M9 13h6M9 17h4"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">VERIFIKASI<br>LOGBOOK</p>
            <p class="text-xl font-bold text-red-500 mt-1">{{ $stats['verifikasi_logbook'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">LAPORAN AKHIR</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['laporan_akhir'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 mb-3">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">SELESAI MAGANG</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['selesai_magang'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-4 shadow-sm">
            <div class="w-9 h-9 rounded-lg bg-cyan-50 flex items-center justify-center text-cyan-500 mb-3">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="m12 3 2.6 5.3 5.9.8-4.3 4.1 1 5.8L12 16.3l-5.2 2.7 1-5.8-4.3-4.1 5.9-.8L12 3Z"/>
                </svg>
            </div>
            <p class="text-xs text-slate-400 leading-tight">SERTIFIKAT SIAP</p>
            <p class="text-xl font-bold text-blue-700 mt-1">{{ $stats['sertifikat_siap'] }}</p>
        </div>

    </div>

    {{-- GRAFIK KEHADIRAN + AKTIVITAS LOGBOOK --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">

        {{-- Grafik Kehadiran --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-blue-700 mb-5">Grafik Kehadiran</h2>
            <div class="flex items-center gap-8">
                <div class="relative w-36 h-36 flex-shrink-0">
                    <svg viewBox="0 0 120 120" class="w-36 h-36 -rotate-90">
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#eef2ff" stroke-width="10"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#ef4444" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $alfaLen }} {{ $circumference - $alfaLen }}"
                                stroke-dashoffset="0"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#fbbf24" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $izinLen }} {{ $circumference - $izinLen }}"
                                stroke-dashoffset="-{{ $alfaLen }}"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#60a5fa" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $sakitLen }} {{ $circumference - $sakitLen }}"
                                stroke-dashoffset="-{{ $alfaLen + $izinLen }}"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#16a34a" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $hadirLen }} {{ $circumference - $hadirLen }}"
                                stroke-dashoffset="-{{ $alfaLen + $izinLen + $sakitLen }}"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-blue-700">{{ $kehadiran['persen'] }}%</span>
                        <span class="text-xs text-slate-400">Rate</span>
                    </div>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-600 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Hadir: {{ number_format($kehadiran['hadir']) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Izin: {{ $kehadiran['izin'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Alfa: {{ $kehadiran['alfa'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-400 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Sakit: {{ $kehadiran['sakit'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Aktivitas Logbook --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <h2 class="font-bold text-blue-700 mb-5">Aktivitas Logbook</h2>
            <div class="flex items-center gap-8">
                <div class="relative w-36 h-36 flex-shrink-0">
                    <svg viewBox="0 0 120 120" class="w-36 h-36 -rotate-90">
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#eef2ff" stroke-width="10"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#bfdbfe" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $direvisiLen }} {{ $circumference - $direvisiLen }}"
                                stroke-dashoffset="0"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#60a5fa" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $menungguLen }} {{ $circumference - $menungguLen }}"
                                stroke-dashoffset="-{{ $direvisiLen }}"/>
                        <circle cx="60" cy="60" r="54" fill="none" stroke="#1e3a8a" stroke-width="10"
                                stroke-linecap="round"
                                stroke-dasharray="{{ $disetujuiLen }} {{ $circumference - $disetujuiLen }}"
                                stroke-dashoffset="-{{ $direvisiLen + $menungguLen }}"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-blue-700">{{ $logbook['total'] }}</span>
                        <span class="text-xs text-slate-400">Total</span>
                    </div>
                </div>
                <div class="space-y-2.5">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-900 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Disetujui: {{ $logbook['disetujui'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-400 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Menunggu: {{ $logbook['menunggu'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-200 flex-shrink-0"></span>
                        <span class="text-sm text-slate-600">Direvisi: {{ $logbook['direvisi'] }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- FILTER BAR --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-5 flex flex-wrap items-center gap-3">
        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Status Peserta</option>
            <option>Aktif</option>
            <option>Selesai</option>
            <option>Tidak Aktif</option>
        </select>
        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Divisi</option>
            <option>IT Development</option>
            <option>Digital Marketing</option>
            <option>Eng. Transmisi</option>
            <option>Legal & Compliance</option>
        </select>
        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Mentor</option>
            <option>fahrul MENTOR</option>
            <option>RUL mentor</option>
            <option>Dwi Aslam Dzulkhair</option>
            <option>Rizky</option>
        </select>
    </div>

    {{-- TABEL MONITORING --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 bg-blue-50/50 border-b border-slate-100">
                        <th class="py-3 px-5 font-medium">NAMA PESERTA</th>
                        <th class="py-3 px-2 font-medium">DIVISI</th>
                        <th class="py-3 px-2 font-medium">MENTOR</th>
                        <th class="py-3 px-2 font-medium">KEHADIRAN</th>
                        <th class="py-3 px-2 font-medium">LOGBOOK</th>
                        <th class="py-3 px-2 font-medium">LAPORAN</th>
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
                                        <p class="font-semibold text-slate-700">{{ $p['nama'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $p['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-slate-500">{{ $p['divisi'] }}</td>
                            <td class="py-4 px-2 text-slate-500">{{ $p['mentor'] }}</td>
                            <td class="py-4 px-2">
                                <div class="flex items-center gap-2 w-28">
                                    <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full {{ $p['kehadiran'] >= 80 ? 'bg-blue-600' : 'bg-red-400' }}" style="width: {{ $p['kehadiran'] }}%"></div>
                                    </div>
                                    <span class="text-xs text-slate-500 flex-shrink-0">{{ $p['kehadiran'] }}%</span>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-slate-600 font-medium whitespace-nowrap">{{ $p['logbook'] }}</td>
                            <td class="py-4 px-2">
                                @if ($p['laporan'] === 'Diterima')
                                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">Diterima</span>
                                @elseif ($p['laporan'] === 'Review')
                                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">Menunggu<br>Verifikasi</br></span>
                                @else
                                    <span class="text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full whitespace-nowrap">Belum Ada</span>
                                @endif
                            </td>
                            <td class="py-4 px-2">
                                @if ($p['status'] === 'Aktif')
                                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">Aktif</span>
                                @elseif ($p['status'] === 'Selesai')
                                    <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">Selesai</span>
                                @elseif ($p['status'] === 'Bermasalah')
                                    <span class="text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full whitespace-nowrap">Bermasalah</span>
                                @else
                                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full whitespace-nowrap">Menunggu<br>Penilaian</br></span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('admin.monitoring.show', $p['id']) }}" class="text-blue-500 hover:text-blue-700 inline-block">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500">
                Menampilkan {{ $pagination['menampilkan'] }} dari {{ $pagination['total'] }} peserta
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