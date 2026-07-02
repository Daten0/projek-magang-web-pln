@extends('layouts.app')

@section('title', 'Absensi')

@section('content')

    @if (session('success'))
        <div class="mb-4 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- ================= STATUS KEHADIRAN HARI INI ================= --}}
    <div class="bg-white rounded-2xl p-8 shadow-sm mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6">

        <div>
            <p class="text-xs font-bold text-blue-600 tracking-wide uppercase leading-relaxed">Status Kehadiran<br>Hari Ini</p>
            <p class="text-4xl font-bold text-slate-800 mt-3 tabular-nums" id="liveClock">--:--:--</p>
            <p class="text-slate-500 mt-2" id="liveDate">-</p>
        </div>

        @if ($absensiHariIni)
            {{-- Sudah absen hari ini --}}
            <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-5 py-4">
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    @if($absensiHariIni->status === 'Hadir') bg-green-100 text-green-600
                    @elseif($absensiHariIni->status === 'Izin') bg-amber-100 text-amber-600
                    @elseif($absensiHariIni->status === 'Sakit') bg-blue-100 text-blue-600
                    @else bg-red-100 text-red-600 @endif">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700">Sudah Absen Hari Ini</p>
                    <p class="text-xs text-slate-400 mt-0.5">Status:
                        <span class="font-medium
                            @if($absensiHariIni->status === 'Hadir') text-green-600
                            @elseif($absensiHariIni->status === 'Izin') text-amber-600
                            @elseif($absensiHariIni->status === 'Sakit') text-blue-600
                            @else text-red-600 @endif">
                            {{ $absensiHariIni->status }}
                        </span>
                        @if($absensiHariIni->jam_masuk)
                            · {{ substr($absensiHariIni->jam_masuk, 0, 5) }}
                        @endif
                    </p>
                </div>
            </div>
        @else
            {{-- Belum absen --}}
            <div class="flex items-center gap-3">
                {{-- Form Absen Masuk --}}
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="Hadir">
                    <button type="submit"
                            class="bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center gap-2.5 transition w-36">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l4-4-4-4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 4h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H9"/>
                        </svg>
                        <span class="leading-tight">Absen Masuk</span>
                    </button>
                </form>

                {{-- Tombol Ajukan Izin/Sakit → buka modal --}}
                <button type="button" onclick="document.getElementById('modalIzin').classList.remove('hidden')"
                        class="border border-slate-200 text-slate-600 text-sm font-semibold px-5 py-3.5 rounded-xl flex items-center gap-2.5 hover:bg-slate-50 transition w-36">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 15.5 1-3 4-4 2 2-4 4-3 1Z"/>
                    </svg>
                    <span class="leading-tight">Ajukan Izin / Sakit</span>
                </button>
            </div>
        @endif

    </div>

    {{-- ================= MODAL IZIN / SAKIT ================= --}}
    <div id="modalIzin" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm mx-4 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-1">Ajukan Izin / Sakit</h3>
            <p class="text-sm text-slate-500 mb-5">Pilih jenis ketidakhadiran kamu hari ini.</p>

            <div class="flex flex-col gap-3">

                {{-- Izin --}}
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="Izin">
                    <button type="submit"
                            class="w-full flex items-center gap-4 px-4 py-4 rounded-xl border border-amber-200 bg-amber-50 hover:bg-amber-100 transition text-left">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4M9 12h6M9 15h4"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-amber-700 text-sm">Izin</p>
                            <p class="text-xs text-amber-600 mt-0.5">Tidak hadir dengan keterangan izin</p>
                        </div>
                    </button>
                </form>

                {{-- Sakit --}}
                <form action="{{ route('absensi.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="Sakit">
                    <button type="submit"
                            class="w-full flex items-center gap-4 px-4 py-4 rounded-xl border border-blue-200 bg-blue-50 hover:bg-blue-100 transition text-left">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-blue-700 text-sm">Sakit</p>
                            <p class="text-xs text-blue-600 mt-0.5">Tidak hadir karena kondisi kesehatan</p>
                        </div>
                    </button>
                </form>

            </div>

            <button type="button" onclick="document.getElementById('modalIzin').classList.add('hidden')"
                    class="mt-4 w-full text-sm text-slate-400 hover:text-slate-600 text-center">
                Batal
            </button>
        </div>
    </div>

    {{-- ================= RIWAYAT ABSENSI ================= --}}
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Riwayat Absensi</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-500 text-xs font-semibold uppercase tracking-wide bg-indigo-50/60">
                        <th class="px-6 py-3.5">Tanggal</th>
                        <th class="px-6 py-3.5">Jam Masuk</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($riwayat as $r)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-700">
                                {{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-slate-700">
                               {{ $r->jam_masuk ? substr($r->jam_masuk, 0, 5) : '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($r->status === 'Hadir')
                                    <span class="inline-block text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full bg-green-50 text-green-600">Hadir</span>
                                @elseif ($r->status === 'Izin')
                                    <span class="inline-block text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full bg-amber-50 text-amber-600">Izin</span>
                                @elseif ($r->status === 'Sakit')
                                    <span class="inline-block text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full bg-blue-50 text-blue-600">Sakit</span>
                                @else
                                    <span class="inline-block text-[11px] font-bold uppercase tracking-wide px-2.5 py-1 rounded-full bg-red-50 text-red-600">Alfa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-500 text-xs">
                                {{ $r->keterangan ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-sm">
                                Belum ada riwayat absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-slate-100 text-sm">
            <span class="text-slate-400">Total {{ $totalEntri }} entri</span>
            {{ $riwayat->links() }}
        </div>
    </div>

    <script>
        function updateClock() {
            const now  = new Date();
            const pad  = (n) => n.toString().padStart(2, '0');

            document.getElementById('liveClock').textContent =
                `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;

            const hari  = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
                           'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            document.getElementById('liveDate').textContent =
                `${hari[now.getDay()]}, ${now.getDate()} ${bulan[now.getMonth()]} ${now.getFullYear()}`;
        }

        updateClock();
        setInterval(updateClock, 1000);

        // Tutup modal kalau klik di luar
        document.getElementById('modalIzin').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>

@endsection