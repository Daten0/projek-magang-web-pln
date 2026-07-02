@extends('layouts.mentor')

@php($topbarTitle = 'Mentor Dashboard')

@section('title', 'Verifikasi Logbook')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-800">Verifikasi Logbook</h1>
        <p class="text-slate-500 mt-1">Tinjau dan verifikasi aktivitas harian peserta magang yang berada dalam bimbingan Anda.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        {{-- Total Logbook Masuk --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-slate-600">Total Logbook Masuk</p>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total_masuk'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Sejak awal periode magang</p>
        </div>

        {{-- Menunggu Verifikasi (highlight kuning) --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border-2 border-amber-400">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-slate-600">Menunggu Verifikasi</p>
                <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-500 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="4" y="6" width="16" height="14" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-amber-500">{{ $stats['menunggu_verifikasi'] }}</p>
            <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-full mt-2">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2 2 21h20L12 2Zm0 6 6 11H6l6-11Z"/></svg>
                Perlu Segera
            </span>
        </div>

        {{-- Disetujui --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-slate-600">Disetujui</p>
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-green-600">{{ $stats['disetujui'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Aktivitas tervalidasi</p>
        </div>

        {{-- Perlu Revisi --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <p class="text-sm font-medium text-slate-600">Perlu Revisi</p>
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="4" y="4" width="16" height="16" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4M12 16h.01"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-red-500">{{ $stats['perlu_revisi'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Menunggu perbaikan mentee</p>
        </div>

    </div>

    {{-- ================= SEARCH & FILTER BAR ================= --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-5 flex flex-wrap items-center gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="6.5"/>
                    <path stroke-linecap="round" d="m20 20-3.5-3.5"/>
                </svg>
            </span>
            <input type="text" id="search-input" placeholder="Cari nama atau aktivitas..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>

        <select id="filter-status" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Semua Status</option>
            <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
            <option value="Disetujui">Disetujui</option>
            <option value="Perlu Revisi">Perlu Revisi</option>
        </select>

        <select id="filter-peserta" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Semua Peserta</option>
            @foreach ($logbookList->unique('nama') as $item)
                <option value="{{ $item['nama'] }}">{{ $item['nama'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- ================= TABEL LOGBOOK ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-slate-400 border-b border-slate-100">
                        <th class="py-3 px-5 font-medium">Nama Peserta</th>
                        <th class="py-3 px-2 font-medium">Tanggal</th>
                        <th class="py-3 px-2 font-medium">Judul Aktivitas</th>
                        <th class="py-3 px-2 font-medium">Status</th>
                        <th class="py-3 px-5 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100" id="tabel-body">
                    @foreach ($logbookList as $item)
                        <tr class="row-data hover:bg-slate-50 transition"
                            data-nama="{{ strtolower($item['nama']) }}"
                            data-status="{{ $item['status'] }}"
                            data-peserta="{{ $item['nama'] }}">
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
                                        <p class="text-xs text-slate-400">{{ $item['asal'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-2 text-slate-500 whitespace-nowrap">{{ $item['tanggal'] }}</td>
                            <td class="py-4 px-2">
                                <p class="font-medium text-slate-700">{{ $item['judul'] }}</p>
                                <p class="text-xs text-slate-400">{{ $item['deskripsi'] }}</p>
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
                            <td class="py-4 px-5">
                                <a href="{{ route('mentor.verifikasi-logbook.show', $item['id']) }}" class="inline-block bg-[#0B1437] hover:bg-blue-900 text-white text-xs font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
                                    Tinjau Logbook
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500" id="pagination-info">
                Menampilkan {{ $pagination['awal'] }}-{{ $pagination['akhir'] }} dari {{ $pagination['total'] }} logbook
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
        const searchInput   = document.getElementById('search-input');
        const filterStatus  = document.getElementById('filter-status');
        const filterPeserta = document.getElementById('filter-peserta');
        const rows          = document.querySelectorAll('.row-data');
        const paginasiInfo  = document.getElementById('pagination-info');

        function filterTable() {
            const keyword  = searchInput.value.toLowerCase();
            const status   = filterStatus.value;
            const peserta  = filterPeserta.value;
            let visible    = 0;

            rows.forEach(row => {
                const matchSearch  = row.dataset.nama.includes(keyword) ||
                                     row.querySelector('td:nth-child(3) p')?.textContent.toLowerCase().includes(keyword);
                const matchStatus  = status === 'semua' || row.dataset.status === status;
                const matchPeserta = peserta === 'semua' || row.dataset.peserta === peserta;

                if (matchSearch && matchStatus && matchPeserta) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            paginasiInfo.textContent = `Menampilkan ${visible} dari {{ $pagination['total'] }} logbook`;
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);
        filterPeserta.addEventListener('change', filterTable);
    </script>
@endsection