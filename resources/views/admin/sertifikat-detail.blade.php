@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Detail Sertifikat')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>›</span>
        <a href="{{ route('admin.sertifikat') }}" class="hover:text-blue-600 transition">Sertifikat</a>
        <span>›</span>
        <span class="text-slate-600 font-medium">Detail Sertifikat</span>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Detail Sertifikat:</h1>
        @if ($peserta['status_sertifikat'] === 'siap_diterbitkan')
                <form method="POST" action="{{ route('admin.sertifikat.terbitkan', $peserta['id']) }}"
            enctype="multipart/form-data" class="flex items-center gap-3">
            @csrf

            {{-- Input upload file PDF sertifikat --}}
            <label class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-600 bg-white hover:bg-slate-50 cursor-pointer transition">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                </svg>
                <span id="namaFile">Pilih file PDF...</span>
                <input type="file" name="file_sertifikat" accept=".pdf" required class="hidden"
                    onchange="document.getElementById('namaFile').textContent = this.files[0]?.name ?? 'Pilih file PDF...'">
            </label>

            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/>
                </svg>
                Terbitkan Sertifikat
            </button>
        </form>
        @else
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-100 text-green-700 text-sm font-semibold rounded-xl">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
                Sudah Diterbitkan
            </span>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-5">

        {{-- ================= KIRI ================= --}}
        <div class="w-full lg:w-72 flex-shrink-0 space-y-4">

            {{-- Kartu Profil --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 flex-shrink-0">
                        @if ($peserta['foto'])
                            <img src="{{ $peserta['foto'] }}" alt="{{ $peserta['nama'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-lg font-bold text-slate-500">
                                {{ $peserta['inisial'] }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-base leading-tight">{{ $peserta['nama'] }}</p>
                        <p class="text-sm text-slate-500">{{ $peserta['universitas'] }}</p>
                        @if ($peserta['status_magang'] === 'Aktif')
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                AKTIF
                            </span>
                        @elseif ($peserta['status_magang'] === 'Selesai')
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                SELESAI
                            </span>
                        @else
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-500 rounded-full">
                                TIDAK AKTIF
                            </span>
                        @endif
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Divisi</span>
                        <span class="font-semibold text-slate-700 text-right">{{ $peserta['divisi'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Mentor</span>
                        <span class="font-semibold text-slate-700">{{ $peserta['mentor'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Periode</span>
                        <span class="font-semibold text-slate-700">{{ $peserta['periode'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Persyaratan Kelulusan --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 1 4 0M9 12l2 2 4-4"/>
                    </svg>
                    <h3 class="font-semibold text-blue-700">Persyaratan Kelulusan</h3>
                </div>
                <div class="space-y-3">
                    @foreach ($syarat as $item)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">{{ $item['label'] }}</span>
                        @if ($item['terpenuhi'])
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Info --}}
                <div class="mt-4 flex gap-2 p-3 bg-blue-50 rounded-xl">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v1M12 11v5"/>
                    </svg>
                    <p class="text-xs text-blue-600 leading-relaxed">
                        Semua persyaratan telah terpenuhi secara otomatis melalui validasi sistem. Sertifikat siap diterbitkan.
                    </p>
                </div>
            </div>

        </div>

        {{-- ================= KANAN ================= --}}
        <div class="flex-1 min-w-0 space-y-4">

            {{-- Preview Sertifikat --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700">Preview Sertifikat</h3>
                    <div class="flex items-center gap-2 text-slate-400">
                        <button class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0Z"/>
                            </svg>
                        </button>
                        <button class="w-7 h-7 rounded-lg hover:bg-slate-100 flex items-center justify-center transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 8V5a1 1 0 0 1 1-1h3M4 16v3a1 1 0 0 0 1 1h3M16 4h3a1 1 0 0 1 1 1v3M16 20h3a1 1 0 0 0 1-1v-3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Sertifikat --}}
                <div class="p-6">
                    <div class="border-4 border-blue-800 rounded-xl p-6 bg-white relative overflow-hidden">

                        {{-- Ornamen sudut --}}
                        <div class="absolute top-0 left-0 w-16 h-16 border-t-4 border-l-4 border-blue-300 rounded-tl-xl opacity-40"></div>
                        <div class="absolute bottom-0 right-0 w-16 h-16 border-b-4 border-r-4 border-blue-300 rounded-br-xl opacity-40"></div>

                        <div class="text-right mb-3">
                            <p class="text-xs font-bold text-blue-700">Sertifikat Kompetensi</p>
                            <p class="text-xs text-slate-400">ID: PLN/CERT/2024/0042</p>
                        </div>

                        <div class="text-center">
                            <p class="text-2xl font-extrabold text-blue-800 tracking-widest mb-1">SERTIFIKAT MAGANG</p>
                            <p class="text-xs text-slate-500 mb-3">Diberikan kepada:</p>
                            <p class="text-3xl font-black text-blue-900 tracking-wide mb-4">{{ strtoupper($peserta['nama']) }}</p>
                            <p class="text-xs text-slate-600 max-w-xs mx-auto leading-relaxed">
                                Telah menyelesaikan program magang di PT PLN (Persero) Pusat pada Divisi {{ $peserta['divisi'] }}
                                periode {{ $peserta['periode'] }} dengan hasil sangat memuaskan.
                            </p>
                        </div>

                        <div class="mt-5 flex justify-between items-end text-xs text-slate-500">
                            <span>Jakarta, {{ $peserta['tanggal_terbit'] }}</span>
                            <div class="text-center">
                                <div class="w-20 border-b border-slate-300 mb-1"></div>
                                <p class="font-semibold text-slate-600">Direktur Human Capital</p>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Tombol Preview & Download --}}
                <div class="px-6 pb-6 flex gap-3">
                    <button class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        Preview Fullscreen
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 bg-amber-400 hover:bg-amber-500 text-white text-sm font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v13M8 12l4 4 4-4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16"/>
                        </svg>
                        Download PDF (High-Res)
                    </button>
                </div>
            </div>

            {{-- Riwayat Sertifikat --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700">Riwayat Sertifikat</h3>
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/>
                    </svg>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Nomor Sertifikat</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($riwayat as $r)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-600">{{ $r['tanggal'] }}</td>
                            <td class="px-4 py-4 font-semibold text-blue-600">{{ $r['nomor'] }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 tracking-wide">
                                    {{ strtoupper($r['status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ $r['admin'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection