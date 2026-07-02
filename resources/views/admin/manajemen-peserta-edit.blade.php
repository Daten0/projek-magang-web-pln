@extends('layouts.admin')

@php($topbarTitle = 'Edit Peserta')

@section('title', 'Edit Peserta')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-3">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>›</span>
        <a href="{{ route('admin.manajemen-peserta') }}" class="hover:text-blue-600 transition">Manajemen Peserta</a>
        <span>›</span>
        <span class="text-blue-700 font-medium">Edit Peserta</span>
    </div>

    <h1 class="text-2xl font-bold text-blue-700 mb-6">Edit Peserta</h1>

    <form action="{{ route('admin.manajemen-peserta.update', $peserta['id']) }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">

            {{-- ================= KOLOM KIRI: INFORMASI UTAMA ================= --}}
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                    Informasi Utama
                </h2>

                {{-- Nama Peserta (locked) --}}
                <div class="mb-5">
                    <label class="flex items-center gap-1.5 text-sm font-medium text-slate-600 mb-1.5">
                        Nama Peserta
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                        </svg>
                    </label>
                    <div class="flex items-center justify-between bg-slate-100 rounded-xl px-4 py-3">
                        <span class="text-sm font-semibold text-slate-500">{{ $peserta['nama'] }}</span>
                        <span class="text-xs text-slate-400">Internal ID Locked</span>
                    </div>
                </div>

                {{-- Instansi & Periode --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Instansi Pendidikan</label>
                        <input type="text" name="instansi" value="{{ $peserta['instansi'] }}"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
    <label class="block text-sm font-medium text-slate-600 mb-1.5">Periode Magang</label>
    <div class="grid grid-cols-2 gap-2">
        <input type="date" name="periode_mulai" value="{{ $peserta['periode_mulai_raw'] }}"
               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="date" name="periode_selesai" value="{{ $peserta['periode_selesai_raw'] }}"
               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
</div>
                </div>

                {{-- Divisi & Mentor --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Penempatan Divisi</label>
                        <select name="divisi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach ($divisiOptions as $divisi)
                                <option value="{{ $divisi }}" {{ $divisi === $peserta['divisi'] ? 'selected' : '' }}>{{ $divisi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                    <div>
    <label class="block text-sm font-medium text-slate-600 mb-1.5">Mentor Pembimbing</label>
    <div class="relative">
        <select name="mentor_id" class="w-full px-4 py-2.5 pr-10 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none">
            <option value="">— Belum ditentukan —</option>
            @foreach ($mentorOptions as $mentor)
                <option value="{{ $mentor['id'] }}" {{ (string) $mentor['id'] === (string) $peserta['mentor_id'] ? 'selected' : '' }}>{{ $mentor['nama'] }}</option>
            @endforeach
        </select>
                            <span class="absolute inset-y-0 right-3 flex items-center text-slate-400 pointer-events-none">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="8" r="3.5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= KOLOM KANAN: KARTU PROFIL ================= --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <div class="flex flex-col items-center text-center mb-5">
                    <div class="relative mb-3">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-bold text-xl overflow-hidden">
                            {{ strtoupper(substr($peserta['nama'], 0, 1)) }}
                        </div>
                        <button type="button" class="absolute bottom-0 right-0 w-6 h-6 rounded-full bg-slate-700 flex items-center justify-center text-white shadow hover:bg-blue-600 transition">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 0 1 2-2h.5a2 2 0 0 0 1.69-.93L8.5 4h7l1.31 2.07A2 2 0 0 0 18.5 7H19a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"/>
                                <circle cx="12" cy="13" r="3"/>
                            </svg>
                        </button>
                    </div>
                    <p class="font-bold text-slate-800">{{ $peserta['nama'] }}</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600">Kehadiran</span>
                            <span class="font-semibold text-blue-700">{{ $peserta['kehadiran'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $peserta['kehadiran'] }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600">Progress Logbook</span>
                            <span class="font-semibold text-amber-500">{{ $peserta['logbook'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 rounded-full" style="width: {{ $peserta['logbook'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

                {{-- ================= STATUS KEPESERTAAN ================= --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm mb-5">
            <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                </svg>
                Status Kepesertaan
            </h2>

            <div class="grid grid-cols-3 gap-4 max-w-2xl">

                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Aktif" class="sr-only peer" {{ $peserta['status'] === 'Aktif' ? 'checked' : '' }}>
                    <div class="border-2 border-slate-200 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-2xl p-5 flex flex-col items-center gap-3 transition hover:border-green-300">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-bold text-slate-700">Aktif</p>
                            <p class="text-xs text-slate-400 mt-0.5">Sedang magang</p>
                        </div>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Selesai" class="sr-only peer" {{ $peserta['status'] === 'Selesai' ? 'checked' : '' }}>
                    <div class="border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 rounded-2xl p-5 flex flex-col items-center gap-3 transition hover:border-blue-300">
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-bold text-slate-700">Selesai</p>
                            <p class="text-xs text-slate-400 mt-0.5">Magang selesai</p>
                        </div>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="status" value="Tidak Aktif" class="sr-only peer" {{ $peserta['status'] === 'Tidak Aktif' ? 'checked' : '' }}>
                    <div class="border-2 border-slate-200 peer-checked:border-red-400 peer-checked:bg-red-50 rounded-2xl p-5 flex flex-col items-center gap-3 transition hover:border-red-300">
                        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" d="M12 8v4M12 16h.01"/>
                            </svg>
                        </div>
                        <div class="text-center">
                            <p class="text-sm font-bold text-slate-700">Tidak Aktif</p>
                            <p class="text-xs text-slate-400 mt-0.5">Dihentikan</p>
                        </div>
                    </div>
                </label>

            </div>
        </div>

        {{-- ================= TOMBOL AKSI ================= --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.manajemen-peserta') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit"
                    class="flex items-center gap-2 bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21v-8h10v8M7 3v5h8"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>

@endsection