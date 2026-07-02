@extends('layouts.app')

@php($hideTopbar = true)

@section('title', 'Logbook Magang')

@section('content')

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Logbook Magang</h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau seluruh aktivitas magang harian Anda.</p>
        </div>
        <a href="{{ route('logbook.create') }}" class="bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-4 py-2.5 rounded-xl flex items-center gap-2 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Logbook
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

        {{-- Total --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-slate-500 tracking-wide">TOTAL</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Seluruh Logbook</p>
        </div>

        {{-- Disetujui --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-green-600 tracking-wide">DISETUJUI</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['disetujui'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Telah diverifikasi mentor</p>
        </div>

        {{-- Menunggu --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-amber-600 tracking-wide">MENUNGGU</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['menunggu'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Menunggu Verifikasi</p>
        </div>

        {{-- Revisi --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" d="M12 8v5"/>
                        <path stroke-linecap="round" d="M12 16h.01"/>
                    </svg>
                </div>
                <span class="text-xs font-semibold text-red-600 tracking-wide">REVISI</span>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['revisi'] }}</p>
            <p class="text-sm text-slate-500 mt-1">Perlu Perbaikan</p>
        </div>

    </div>

    {{-- ================= FILTER ROW ================= --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm mb-6 flex flex-col sm:flex-row gap-3">

        <div class="relative flex-1">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="11" cy="11" r="6.5"/>
                    <path stroke-linecap="round" d="m20 20-3.5-3.5"/>
                </svg>
            </span>
            <input type="text" id="searchInput" placeholder="Cari berdasarkan aktivitas..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>

        <div class="relative w-full sm:w-48">
            <select id="filterStatus" class="w-full pl-4 pr-9 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                <option value="">Semua Status</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                <option value="Perlu Revisi">Perlu Revisi</option>
            </select>
            <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 pointer-events-none">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6"/>
                </svg>
            </span>
        </div>

    </div>

    {{-- ================= TABEL LOGBOOK ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" id="logbookTable">
                <thead>
                    <tr class="text-left text-slate-400 text-xs uppercase tracking-wide border-b border-slate-100">
                        <th class="px-6 py-4 font-medium">Tanggal</th>
                        <th class="px-6 py-4 font-medium">Aktivitas</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logbooks as $log)
                        <tr class="hover:bg-slate-50 logbook-row"
                            data-status="{{ $log['status'] }}"
                            data-judul="{{ strtolower($log['judul']) }}">
                            <td class="px-6 py-4 align-top whitespace-nowrap">
                                <p class="font-medium text-slate-700">{{ $log['tanggal'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $log['minggu'] }}</p>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <p class="font-medium text-slate-700">{{ $log['judul'] }}</p>
                                <p class="text-xs text-slate-400 mt-0.5 max-w-md truncate">{{ $log['deskripsi'] }}</p>
                            </td>
                            <td class="px-6 py-4 align-top">
                                @if ($log['status'] === 'Disetujui')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full bg-green-50 text-green-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Disetujui
                                    </span>
                                @elseif ($log['status'] === 'Menunggu Verifikasi')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full bg-amber-50 text-amber-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Verifikasi
                                    </span>
                                @elseif ($log['status'] === 'Perlu Revisi')
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full bg-red-50 text-red-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                        Perlu Revisi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-full bg-slate-100 text-slate-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                        {{ $log['status'] }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <a href="{{ route('logbook.edit', $log['id']) }}" class="text-slate-400 hover:text-slate-600">
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                        <circle cx="12" cy="5" r="1.4"/>
                                        <circle cx="12" cy="12" r="1.4"/>
                                        <circle cx="12" cy="19" r="1.4"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm">
                                Belum ada logbook yang diisi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 text-sm">
            <span class="text-slate-400">Total {{ $stats['total'] }} logbook</span>
            {{ $logbooks->links() }}
        </div>
    </div>

    <script>
        const searchInput  = document.getElementById('searchInput');
        const filterStatus = document.getElementById('filterStatus');
        const rows         = document.querySelectorAll('.logbook-row');

        function filterTable() {
            const keyword = searchInput.value.toLowerCase();
            const status  = filterStatus.value;

            rows.forEach(row => {
                const judulMatch  = row.dataset.judul.includes(keyword);
                const statusMatch = status === '' || row.dataset.status === status;
                row.style.display = judulMatch && statusMatch ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);
    </script>

@endsection