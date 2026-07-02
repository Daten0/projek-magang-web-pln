@extends('layouts.admin')

@section('title', 'Monitoring Detail: ' . $peserta['nama'])

@section('content')

    {{-- Breadcrumb --}}
    <div class="text-sm text-slate-400 mb-2">
        <a href="{{ route('admin.monitoring') }}" class="hover:text-blue-600">Monitoring Magang</a>
        <span class="mx-1.5">/</span>
        <span class="text-blue-600 font-medium">Detail Peserta</span>
    </div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6">Monitoring Detail: {{ $peserta['nama'] }}</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="space-y-5">

            {{-- Kartu Profil --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col items-center text-center mb-5">
                    <div class="w-20 h-20 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xl mb-3">
                        {{ $peserta['foto_inisial'] }}
                    </div>
                    <p class="font-bold text-slate-800">{{ $peserta['nama'] }}</p>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $peserta['posisi'] }}</p>
                </div>
                <div class="space-y-2.5 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Instansi</span>
                        <span class="font-medium text-blue-600 text-right max-w-36">{{ $peserta['instansi'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Mentor</span>
                        <span class="font-medium text-blue-600">{{ $peserta['mentor'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Periode</span>
                        <span class="font-medium text-slate-700">{{ $peserta['periode'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mx-auto mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <rect x="4" y="5" width="16" height="16" rx="2"/>
                            <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400 leading-tight">Tingkat Kehadiran</p>
                    <p class="text-lg font-bold text-blue-700 mt-1">{{ $peserta['kehadiran'] }}%</p>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm text-center border-t-2 border-amber-400">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600 mx-auto mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400 leading-tight">Logbook Terisi</p>
                    <p class="text-lg font-bold text-amber-500 mt-1">{{ $peserta['logbook_terisi'] }}/{{ $peserta['logbook_total'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 mx-auto mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400 leading-tight">Logbook Disetujui</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $peserta['logbook_disetujui'] }}</p>
                </div>
            </div>

            {{-- Status Cards --}}
            <div class="grid grid-cols-3 gap-3">
                <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400">Laporan Akhir</p>
                    <p class="text-xs font-bold text-slate-700 mt-1 leading-tight">{{ $peserta['laporan_akhir'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400">Penilaian Mentor</p>
                    <p class="text-xs font-bold text-slate-700 mt-1 leading-tight">{{ $peserta['penilaian_mentor'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-4 shadow-sm text-center">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="9" r="5.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                        </svg>
                    </div>
                    <p class="text-xs text-slate-400">Sertifikat</p>
                    <p class="text-xs font-bold text-slate-700 mt-1 leading-tight">{{ $peserta['sertifikat'] }}</p>
                </div>
            </div>

            {{-- Progress Magang --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4">Progress Magang</h3>
                @php
                    $steps = [
                        'Pendaftaran Diterima',
                        'Mentor Ditentukan',
                        'Logbook Berjalan',
                        'Laporan Akhir Diunggah',
                        'Penilaian Mentor',
                        'Sertifikat Diterbitkan',
                    ];
                @endphp
                <div class="space-y-3">
                    @foreach ($steps as $i => $step)
    @php $stepNum = $i + 1; @endphp
    <div class="flex items-center gap-3">
        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0
            {{ $stepNum <= $peserta['progres_step'] +1 ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-400' }}">
            @if ($stepNum <= $peserta['progres_step'])
    {{-- ceklis: sudah selesai --}}
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="m4 12.5 5 5L20 6"/>
    </svg>
@elseif ($stepNum === $peserta['progres_step'] + 1)
    {{-- jam: sedang berjalan --}}
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="9"/>
        <path stroke-linecap="round" d="M12 7v5l3 2"/>
    </svg>
@else
    {{-- angka: belum dicapai --}}
    <span class="text-xs font-bold">{{ $stepNum }}</span>
@endif
        </div>
        <span class="text-sm {{ $stepNum <= $peserta['progres_step'] ? 'text-blue-700 font-semibold' : 'text-slate-400' }}">
            {{ $step }}
        </span>
    </div>
    @if (!$loop->last)
        <div class="ml-3.5 w-px h-3 {{ $stepNum < $peserta['progres_step'] ? 'bg-blue-400' : 'bg-slate-200' }}"></div>
    @endif
@endforeach 
                </div>
            </div>

        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Ringkasan Logbook --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Ringkasan Logbook</h3>
                   <a href="#" onclick="document.getElementById('modal-logbook').classList.remove('hidden')" 
   class="text-sm text-blue-600 hover:underline flex items-center gap-1">
    Lihat Semua Logbook →
</a>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-slate-400 font-medium border-b border-slate-100">
                            <th class="px-6 py-3">TANGGAL</th>
                            <th class="px-6 py-3">KEGIATAN</th>
                            <th class="px-6 py-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($ringkasanLogbook as $log)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 text-slate-500 whitespace-nowrap">{{ $log['tanggal'] }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $log['kegiatan'] }}</td>
                                <td class="px-6 py-4">
                                    @if ($log['status'] === 'Disetujui')
                                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Disetujui</span>
                                    @elseif ($log['status'] === 'Menunggu')
                                        <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Menunggu</span>
                                    @else
                                        <span class="text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full">Direvisi</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Ringkasan Absensi --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Ringkasan Absensi</h3>
                    <a href="#" onclick="document.getElementById('modal-absensi').classList.remove('hidden')"
   class="text-sm text-blue-600 hover:underline flex items-center gap-1">
    Lihat Detail Absensi →
</a>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-slate-400 font-medium border-b border-slate-100">
                            <th class="px-6 py-3">HARI/TANGGAL</th>
                            <th class="px-6 py-3">JAM MASUK</th>
                            <th class="px-6 py-3">JAM KELUAR</th>
                            <th class="px-6 py-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($ringkasanAbsensi as $absen)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 text-slate-700">{{ $absen['hari_tanggal'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $absen['jam_masuk'] }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $absen['jam_keluar'] }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $absen['status'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Riwayat Aktivitas --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4">Riwayat Aktivitas</h3>
                <ul class="space-y-4">
                    @foreach ($riwayatAktivitas as $aktivitas)
                        <li class="flex items-start gap-3">
                            <span class="w-2.5 h-2.5 rounded-full mt-1.5 flex-shrink-0
                                {{ $aktivitas['warna'] === 'blue' ? 'bg-blue-500' : ($aktivitas['warna'] === 'green' ? 'bg-green-500' : 'bg-slate-300') }}"></span>
                            <div>
                                <p class="text-sm text-slate-700 leading-snug">{{ $aktivitas['teks'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $aktivitas['waktu'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>

    </div>


            {{-- ===== MODAL LOGBOOK ===== --}}
<div id="modal-logbook" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[80vh] flex flex-col mx-4">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Semua Logbook — {{ $peserta['nama'] }}</h3>
            <button onclick="document.getElementById('modal-logbook').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto p-6 space-y-3">
            @forelse ($semuaLogbook as $log)
                <div class="border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs text-slate-400">{{ $log['tanggal'] }}</span>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full
                            {{ $log['status'] === 'Disetujui' ? 'bg-green-50 text-green-600' :
                               ($log['status'] === 'Perlu Revisi' ? 'bg-red-50 text-red-500' : 'bg-amber-50 text-amber-600') }}">
                            {{ $log['status'] }}
                        </span>
                    </div>
                    <p class="font-semibold text-slate-800 text-sm">{{ $log['kegiatan'] }}</p>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $log['deskripsi'] }}</p>
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm py-8">Belum ada logbook.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ===== MODAL ABSENSI ===== --}}
<div id="modal-absensi" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[80vh] flex flex-col mx-4">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="font-bold text-slate-800">Detail Absensi — {{ $peserta['nama'] }}</h3>
            <button onclick="document.getElementById('modal-absensi').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="overflow-y-auto p-6 space-y-3">
            @forelse ($semuaAbsensi as $absen)
                <div class="border border-slate-100 rounded-xl p-4 hover:bg-slate-50 transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold text-slate-800 text-sm">{{ $absen['tanggal'] }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Masuk: {{ substr($absen['jam_masuk'], 0, 5) }} 
                                @if($absen['jam_keluar'] !== '-')
                                    · Keluar: {{ substr($absen['jam_keluar'], 0, 5) }}
                                @endif
                            </p>
                            @if($absen['keterangan'] !== '-')
                                <p class="text-xs text-slate-500 mt-1">{{ $absen['keterangan'] }}</p>
                            @endif
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full flex-shrink-0
                            {{ $absen['status'] === 'Hadir' ? 'bg-green-50 text-green-600' :
                               ($absen['status'] === 'Sakit' ? 'bg-blue-50 text-blue-600' :
                               ($absen['status'] === 'Izin' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-500')) }}">
                            {{ $absen['status'] }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm py-8">Belum ada data absensi.</p>
            @endforelse
        </div>
    </div>
</div>

@endsection