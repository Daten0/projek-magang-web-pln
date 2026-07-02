@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Manajemen Mentor')

@section('content')

    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 mb-6 flex-wrap">
        <div>
            <h1 class="text-2xl font-bold text-blue-700">Manajemen Mentor</h1>
            <p class="text-slate-500 mt-1">Kelola data mentor, penugasan peserta magang, dan aktivitas pembimbingan dalam portal magang PLN.</p>
        </div>
        <a href="{{ route('admin.manajemen-mentor.create') }}" class="flex items-center gap-2 bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition flex-shrink-0">
    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
    </svg>
    Tambah Mentor
</a>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6 max-w-3xl">

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
                <p class="text-xs text-slate-400">Total Mentor</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['total_mentor'] }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-green-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="10" cy="8" r="3.2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 19c0-3.3 2.9-5.5 6.5-5.5s6.5 2.2 6.5 5.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.5 8.5 1.2 1.2 2-2.4"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400">Mentor Aktif</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['mentor_aktif'] }}</p>
            </div>
        </div>

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
                <p class="text-xs text-slate-400">Total Peserta Dibimbing</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['peserta_dibimbing'] }}</p>
            </div>
        </div>

    </div>

    {{-- ================= FILTER BAR ================= --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-5 flex flex-wrap items-center gap-3">
        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Semua Divisi</option>
            <option>Sistem Informasi</option>
            <option>SDM & Umum</option>
            <option>Distribusi</option>
            <option>Transmisi</option>
        </select>

        <select class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Tidak Aktif</option>
        </select>

        <p class="text-sm text-slate-400 ml-auto">
            Menampilkan {{ $pagination['awal'] }}-{{ $pagination['akhir'] }} dari {{ $pagination['total'] }} mentor
        </p>

        <div class="flex items-center gap-1.5">
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

    {{-- ================= TABEL MENTOR ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 border-b border-slate-100">
                        <th class="py-3 px-5 font-medium">NAMA MENTOR</th>
                        <th class="py-3 px-2 font-medium">DIVISI</th>
                        <th class="py-3 px-2 font-medium">EMAIL</th>
                        <th class="py-3 px-2 font-medium">PESERTA</th>
                        <th class="py-3 px-2 font-medium">STATUS</th>
                        <th class="py-3 px-5 font-medium text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($mentorList as $m)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    @if (!empty($m['foto']))
                                        <img src="{{ asset('storage/' . $m['foto']) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $m['nama'] }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                            {{ $m['inisial'] }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-blue-700">{{ $m['nama'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $m['jabatan'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                    {{ $m['divisi'] }}
                                </span>
                            </td>
                            <td class="py-4 px-2 text-slate-500">{{ $m['email'] }}</td>
                            <td class="py-4 px-2 text-slate-600 font-medium">{{ $m['peserta'] }}</td>
                            <td class="py-4 px-2">
                                @if ($m['status'] === 'Aktif')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('admin.manajemen-mentor.edit', $m['id']) }}" class="text-slate-400 hover:text-slate-600 inline-flex">
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
    </div>

@endsection