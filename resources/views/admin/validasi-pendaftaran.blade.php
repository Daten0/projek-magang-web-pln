@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Validasi Pendaftaran')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Validasi Pendaftaran Magang</h1>
        <p class="text-slate-500 mt-1">Tinjau dan verifikasi pengajuan pendaftaran peserta magang sebelum ditetapkan ke divisi dan mentor.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $stats['total_pengajuan_naik'] >= 0 ? '+' : '' }}{{ $stats['total_pengajuan_naik'] }}</span>
            </div>
            <p class="text-sm text-slate-500">Total Pengajuan</p>
            <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['total_pengajuan'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="4" y="6" width="16" height="14" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full">Aktif</span>
            </div>
            <p class="text-sm text-slate-500">Menunggu Verifikasi</p>
            <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['menunggu_verifikasi'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full">Disetujui</span>
            </div>
            <p class="text-sm text-slate-500">Diterima</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['diterima'] }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 9.5 5 5m0-5-5 5"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full">Ditolak</span>
            </div>
            <p class="text-sm text-slate-500">Ditolak</p>
            <p class="text-2xl font-bold text-red-500 mt-1">{{ $stats['ditolak'] }}</p>
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
            <input type="text" id="search-input" placeholder="Cari nama atau instansi..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>

        {{-- Filter Status --}}
        <select id="filter-status" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Status: Semua</option>
            <option value="menunggu">Menunggu Verifikasi</option>
            <option value="aktif">Diterima</option>
            <option value="ditolak">Ditolak</option>
        </select>

        {{-- Filter Jenis --}}
        <select id="filter-jenis" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Jenis: Semua</option>
            <option value="Praktik Industri">Praktik Industri</option>
            <option value="Kerja Praktek">Kerja Praktek</option>
            <option value="Magang Kampus Merdeka">Kampus Merdeka</option>
            <option value="PKL">PKL</option>
        </select>
    </div>

    {{-- ================= TABEL PENGAJUAN ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 bg-slate-50 border-b border-slate-100">
                        <th class="py-3 px-5 font-medium">Nama Peserta</th>
                        <th class="py-3 px-2 font-medium">Instansi</th>
                        <th class="py-3 px-2 font-medium">Jenis</th>
                        <th class="py-3 px-2 font-medium">Tanggal Pengajuan</th>
                        <th class="py-3 px-2 font-medium">Status</th>
                        <th class="py-3 px-5 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="tabel-body">
                    @forelse ($pengajuanList as $item)
                        <tr class="hover:bg-slate-50 transition row-data"
                            data-nama="{{ strtolower($item['nama']) }}"
                            data-instansi="{{ strtolower($item['instansi']) }}"
                            data-status="{{ $item['status'] }}"
                            data-jenis="{{ $item['jenis'] }}">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    @if (!empty($item['foto']))
                                        <img src="{{ asset('storage/' . $item['foto']) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $item['nama'] }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                            {{ $item['inisial'] }}
                                        </div>
                                    @endif
                                    <span class="font-semibold text-slate-700">{{ $item['nama'] }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-slate-500">{{ $item['instansi'] }}</td>
                            <td class="py-4 px-2">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                    {{ $item['jenis'] }}
                                </span>
                            </td>
                            <td class="py-4 px-2 text-slate-500 whitespace-nowrap">{{ $item['tanggal'] }}</td>
                            <td class="py-4 px-2">
                                @if ($item['status'] === 'menunggu')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu Verifikasi
                                    </span>
                                @elseif ($item['status'] === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Diterima
                                    </span>
                                @elseif ($item['status'] === 'ditolak')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-500 bg-red-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <a href="{{ route('admin.validasi-pendaftaran.show', $item['id']) }}"
                                   class="inline-block border border-blue-200 text-blue-600 text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-50 transition whitespace-nowrap">
                                    Tinjau
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-400 text-sm">Tidak ada data pendaftaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500" id="pagination-info">
                Menampilkan {{ $pagination['menampilkan'] }} dari {{ $pagination['total'] }} pengajuan
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
    </div>

    <script>
        const searchInput  = document.getElementById('search-input');
        const filterStatus = document.getElementById('filter-status');
        const filterJenis  = document.getElementById('filter-jenis');
        const rows         = document.querySelectorAll('.row-data');
        const paginasiInfo = document.getElementById('pagination-info');

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const status  = filterStatus.value;
            const jenis   = filterJenis.value;
            let visible   = 0;

            rows.forEach(row => {
                const nama     = row.dataset.nama;
                const instansi = row.dataset.instansi;
                const rowStatus = row.dataset.status;
                const rowJenis  = row.dataset.jenis;

                const matchSearch = nama.includes(keyword) || instansi.includes(keyword);
                const matchStatus = status === 'semua' || rowStatus === status;
                const matchJenis  = jenis === 'semua' || rowJenis === jenis;

                if (matchSearch && matchStatus && matchJenis) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            paginasiInfo.textContent = 'Menampilkan ' + visible + ' dari {{ $pagination["total"] }} pengajuan';
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);
        filterJenis.addEventListener('change', filterTable);
    </script>

@endsection