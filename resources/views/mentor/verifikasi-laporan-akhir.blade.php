@extends('layouts.mentor')

@php($hideTopbar = true)

@section('title', 'Verifikasi Laporan Akhir')

@section('content')

    {{-- Header --}}
    <div class="-mt-8 -mx-8 mb-6 px-8 pt-8">
        <h1 class="text-2xl font-bold text-blue-700">Verifikasi Laporan Akhir</h1>
        <p class="text-slate-500 mt-1">Tinjau dan verifikasi laporan akhir peserta magang sebelum proses penilaian akhir dilakukan.</p>
    </div>

    @if (session('success'))
        <div class="mb-5 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="5" y="3" width="14" height="18" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 8h6M9 12h6M9 16h3"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Total Laporan Masuk</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['total_masuk'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
                <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['menunggu_verifikasi'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Disetujui</p>
                <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['disetujui'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5 19 6l-9.5 9.5-3 .5.5-3L16.5 3.5Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 21h14"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Perlu Revisi</p>
                <p class="text-2xl font-bold text-red-500 mt-1">{{ $stats['perlu_revisi'] }}</p>
            </div>
        </div>
    </div>

    {{-- ================= FILTER STATUS ================= --}}
    <div class="mb-5 flex items-center gap-3">
        <select id="filter-status" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Status: Semua</option>
            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
            <option value="Disetujui">Disetujui</option>
            <option value="Perlu Revisi">Perlu Revisi</option>
        </select>
        <p class="text-sm text-slate-400" id="filter-info">Menampilkan semua laporan</p>
    </div>

    {{-- ================= TABEL LAPORAN ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 bg-slate-50 border-b border-slate-100">
                        <th class="py-3 px-5 font-medium">Nama Peserta</th>
                        <th class="py-3 px-2 font-medium">Judul Laporan</th>
                        <th class="py-3 px-2 font-medium">Tanggal Upload</th>
                        <th class="py-3 px-2 font-medium">Status</th>
                        <th class="py-3 px-5 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="tabel-body">
                    @forelse ($laporanList as $item)
                        <tr class="hover:bg-slate-50 transition row-data" data-status="{{ $item['status'] }}">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    @if (!empty($item['foto']))
                                        <img src="{{ asset('storage/' . $item['foto']) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $item['nama'] }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                            {{ $item['inisial'] }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-700">{{ $item['nama'] }}</p>
                                        <p class="text-xs text-slate-400">{{ $item['nim'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2">
                                <p class="font-medium text-slate-700">{{ $item['judul'] }}</p>
                                <p class="text-xs text-slate-400">Divisi {{ $item['divisi'] }}</p>
                            </td>
                            <td class="py-4 px-2 whitespace-nowrap">
                                <p class="text-slate-600">{{ $item['tanggal'] }}</p>
                                <p class="text-xs text-slate-400">{{ $item['waktu'] }}</p>
                            </td>
                            <td class="py-4 px-2">
                                @if ($item['status'] === 'Menunggu Verifikasi')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu Verifikasi
                                    </span>
                                @elseif ($item['status'] === 'Disetujui')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Perlu Revisi
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('mentor.verifikasi-laporan-akhir.show', $item['id']) }}"
                                   class="inline-block border border-blue-200 text-blue-600 bg-white hover:bg-blue-50 text-xs font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
                                    Tinjau Laporan
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr id="empty-row">
                            <td colspan="5" class="py-10 text-center text-slate-400 text-sm">Belum ada laporan akhir.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500" id="pagination-info">
                Menampilkan {{ $pagination['awal'] }}-{{ $pagination['akhir'] }} dari {{ $pagination['total'] }} data
            </p>
            <div class="flex items-center gap-1.5">
                <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-400 flex items-center justify-center hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6"/></svg>
                </button>
                <button class="w-8 h-8 rounded-lg text-sm font-semibold flex items-center justify-center bg-blue-600 text-white">1</button>
                <button class="w-8 h-8 rounded-lg border border-slate-200 text-slate-400 flex items-center justify-center hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        const filterStatus = document.getElementById('filter-status');
        const rows         = document.querySelectorAll('.row-data');
        const filterInfo   = document.getElementById('filter-info');
        const paginasiInfo = document.getElementById('pagination-info');

        filterStatus.addEventListener('change', function () {
            const selected = this.value;
            let visible = 0;

            rows.forEach(row => {
                const status = row.dataset.status;
                if (selected === 'semua' || status === selected) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            filterInfo.textContent = selected === 'semua'
                ? 'Menampilkan semua laporan'
                : `Menampilkan ${visible} laporan dengan status "${selected}"`;

            paginasiInfo.textContent = `Menampilkan ${visible} dari {{ $pagination['total'] }} data`;
        });
    </script>

@endsection