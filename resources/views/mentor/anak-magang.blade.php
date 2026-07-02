@extends('layouts.mentor')

@php($hideTopbar = true)

@section('title', 'Anak Bimbingan')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Anak Bimbingan</h1>
        <p class="text-slate-500 mt-1">Kelola dan pantau perkembangan peserta magang yang berada dalam bimbingan Anda.</p>
    </div>

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
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
                <p class="text-xs text-slate-400 leading-tight">JUMLAH<br>PESERTA</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['jumlah_peserta'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-green-50 flex items-center justify-center text-green-600 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 leading-tight">PESERTA<br>AKTIF</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['peserta_aktif'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 leading-tight">MAGANG<br>SELESAI</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['magang_selesai'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm flex items-start gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4M12 16h.01"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-slate-400 leading-tight">TIDAK<br>AKTIF</p>
                <p class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['tidak_aktif'] ?? 0 }}</p>
            </div>
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
            <input type="text" id="search-input" placeholder="Cari nama peserta..."
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
        </div>

        <select id="filter-status" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Selesai">Selesai</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>

        <select id="filter-instansi" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="semua">Semua Instansi</option>
            @foreach ($instansiList as $instansi)
                <option value="{{ $instansi }}">{{ $instansi }}</option>
            @endforeach
        </select>
    </div>

    {{-- ================= TABEL PESERTA + PANEL DETAIL ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Tabel List Peserta --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-slate-400 border-b border-slate-100">
                            <th class="py-3 px-5 font-medium">PESERTA</th>
                            <th class="py-3 px-2 font-medium">INSTANSI/<br>JURUSAN</th>
                            <th class="py-3 px-2 font-medium">PERIODE</th>
                            <th class="py-3 px-5 font-medium">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100" id="tabel-body">
                        @forelse ($pesertaList as $p)
                           <tr onclick="window.location.href='{{ route('mentor.anak-magang') }}?peserta={{ $p['id'] }}'"
                                class="row-data cursor-pointer hover:bg-slate-50 transition relative {{ $p['selected'] ? 'bg-blue-50/60' : '' }}"
                                data-nama="{{ strtolower($p['nama']) }}"
                                data-status="{{ $p['status'] }}"
                                data-instansi="{{ $p['instansi'] }}">
                                <td class="py-4 px-5 relative">
                                    @if ($p['selected'])
                                        <span class="absolute left-0 top-0 bottom-0 w-1 bg-blue-600"></span>
                                    @endif
                                    <div class="flex items-center gap-3">
                                        @if (!empty($p['foto']))
                                            <img src="{{ asset('storage/' . $p['foto']) }}" class="w-9 h-9 rounded-full object-cover flex-shrink-0" alt="{{ $p['nama'] }}">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm flex-shrink-0">
                                                {{ $p['inisial'] }}
                                            </div>
                                        @endif
                                        <span class="font-semibold text-slate-700">{{ $p['nama'] }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-2 text-slate-500">
                                    {{ $p['instansi'] }}<br>
                                    <span class="text-xs text-slate-400">{{ $p['jurusan'] }}</span>
                                </td>
                                <td class="py-4 px-2 text-slate-500 text-xs">{{ $p['periode'] }}</td>
                                <td class="py-4 px-5">
                                    @if ($p['status'] === 'Aktif')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Aktif
                                        </span>
                                    @elseif ($p['status'] === 'Selesai')
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400 text-sm">Belum ada peserta bimbingan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex items-center justify-between px-5 py-4 border-t border-slate-100">
                <p class="text-sm text-slate-500" id="pagination-info">
                    Menampilkan {{ $pagination['menampilkan'] }} dari {{ $pagination['total'] }} peserta
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

        {{-- Panel Detail Peserta Terpilih --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm">
            <div class="flex flex-col items-center text-center mb-5">
                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xl mb-3">
                    {{ strtoupper(substr($detail['nama'], 0, 1)) }}
                </div>
                <p class="font-bold text-slate-800">{{ $detail['nama'] }}</p>
                <p class="text-sm text-blue-600 font-medium mt-0.5">{{ $detail['posisi'] }}</p>
            </div>

            <p class="text-xs font-bold text-slate-400 tracking-wide mb-3">PROGRESS OVERVIEW</p>
            <div class="space-y-4 mb-6">
                @foreach ($detail['progress'] as $item)
                    <div>
                        <div class="flex justify-between text-sm mb-1.5">
                            <span class="text-slate-600">{{ $item['label'] }}</span>
                            <span class="font-semibold text-slate-800">{{ $item['persen'] }}%</span>
                        </div>
                        <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $item['warna'] }} rounded-full" style="width: {{ $item['persen'] }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="text-xs font-bold text-slate-400 tracking-wide mb-3">AKTIVITAS TERAKHIR</p>
            <div class="space-y-3 mb-6">
                @foreach ($detail['aktivitas'] as $item)
                    <div class="flex items-start gap-2.5">
                        <span class="w-2 h-2 rounded-full {{ $item['warna'] }} flex-shrink-0 mt-1.5"></span>
                        <div>
                            <p class="text-sm text-slate-700">{{ $item['judul'] }}</p>
                            <p class="text-xs text-slate-400">{{ $item['waktu'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex gap-3">
                <a href="{{ route('mentor.verifikasi-logbook') }}" class="flex-1 border border-slate-200 text-slate-600 font-semibold text-sm py-2.5 rounded-xl hover:bg-slate-50 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z"/>
                    </svg>
                    Logbook
                </a>
                <a href="{{ route('mentor.penilaian-akhir') }}" class="flex-1 bg-amber-400 hover:bg-amber-500 text-white font-semibold text-sm py-2.5 rounded-xl transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="m12 3 2.6 5.3 5.9.8-4.3 4.1 1 5.8L12 16.3l-5.2 2.7 1-5.8-4.3-4.1 5.9-.8L12 3Z"/>
                    </svg>
                    Nilai
                </a>
            </div>
        </div>

    </div>

    <script>
        const searchInput    = document.getElementById('search-input');
        const filterStatus   = document.getElementById('filter-status');
        const filterInstansi = document.getElementById('filter-instansi');
        const rows           = document.querySelectorAll('.row-data');
        const paginasiInfo   = document.getElementById('pagination-info');

        function filterTable() {
            const keyword  = searchInput.value.toLowerCase();
            const status   = filterStatus.value;
            const instansi = filterInstansi.value;
            let visible    = 0;

            rows.forEach(row => {
                const nama        = row.dataset.nama;
                const rowStatus   = row.dataset.status;
                const rowInstansi = row.dataset.instansi;

                const matchSearch   = nama.includes(keyword);
                const matchStatus   = status === 'semua' || rowStatus === status;
                const matchInstansi = instansi === 'semua' || rowInstansi === instansi;

                if (matchSearch && matchStatus && matchInstansi) {
                    row.style.display = '';
                    visible++;
                } else {
                    row.style.display = 'none';
                }
            });

            paginasiInfo.textContent = `Menampilkan ${visible} dari {{ $pagination['total'] }} peserta`;
        }

        searchInput.addEventListener('input', filterTable);
        filterStatus.addEventListener('change', filterTable);
        filterInstansi.addEventListener('change', filterTable);
    </script>

@endsection