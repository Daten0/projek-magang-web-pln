@extends('layouts.mentor')

@php($hideTopbar = true)

@section('title', 'Tinjau Logbook - ' . $logbook['nama'])

@section('content')

    {{--
        Topbar khusus halaman ini (breadcrumb + badge status),
        dibuat manual karena bentuknya beda dari topbar biasa.
    --}}
    <div class="-mt-8 -mx-8 mb-8 bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between gap-4">
        <div>
            <div class="text-sm text-slate-400 mb-1">
                <a href="{{ route('mentor.verifikasi-logbook') }}" class="hover:text-blue-600">Verifikasi Logbook</a>
                <span class="mx-1.5">/</span>
                <span class="text-blue-600 font-medium">Tinjau Logbook</span>
            </div>
            <h1 class="text-xl font-bold text-blue-700">Tinjau Logbook</h1>
        </div>

        @if ($logbook['status'] === 'Menunggu Verifikasi')
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-blue-600 bg-blue-50 px-3.5 py-1.5 rounded-full whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                </svg>
                Menunggu Review
            </span>
        @elseif ($logbook['status'] === 'Disetujui')
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-green-600 bg-green-50 px-3.5 py-1.5 rounded-full whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
                Disetujui
            </span>
        @else
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-600 bg-red-50 px-3.5 py-1.5 rounded-full whitespace-nowrap">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <rect x="4" y="4" width="16" height="16" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4M12 16h.01"/>
                </svg>
                Perlu Revisi
            </span>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Kartu peserta --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm flex items-center gap-4">
                {{--
                    Placeholder avatar (huruf depan nama). Ganti dengan foto asli, misalnya:
                    <img src="{{ asset('images/peserta/' . $logbook['id'] . '.jpg') }}" class="w-14 h-14 rounded-full object-cover" alt="{{ $logbook['nama'] }}">
                --}}
                <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-lg flex-shrink-0">
                    {{ $logbook['inisial'] }}
                </div>
                <div>
                    <p class="font-bold text-slate-800">{{ $logbook['nama'] }}</p>
                    <p class="text-sm text-slate-500 mt-0.5">NIM: {{ $logbook['nim'] }} | {{ $logbook['divisi'] }}</p>
                </div>
            </div>

            {{-- Detail Aktivitas Harian --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 bg-blue-50/60">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        </svg>
                        <h2 class="font-bold text-slate-800 text-sm">Detail Aktivitas Harian</h2>
                    </div>
                    <span class="text-xs text-slate-400">{{ $logbook['tanggal_aktivitas'] }}</span>
                </div>

                <div class="p-6">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">Judul Aktivitas</p>
                    <p class="font-bold text-slate-800 mb-5">{{ $logbook['judul'] }}</p>

                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1.5">Deskripsi Detail</p>
                    <p class="text-sm text-slate-600 leading-relaxed mb-3">{{ $logbook['deskripsi'] }}</p>

                    <ul class="space-y-2 mb-3 pl-1">
                        @foreach ($logbook['rincian'] as $poin)
                            <li class="flex items-start gap-2 text-sm text-slate-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400 flex-shrink-0 mt-2"></span>
                                <span>{{ $poin }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <p class="text-sm text-slate-600 leading-relaxed mb-6">{{ $logbook['penutup'] }}</p>

                   <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-2.5">Dokumentasi Terlampir</p>
                @if (!empty($logbook['dokumentasi']))
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ asset('storage/' . $logbook['dokumentasi']) }}" target="_blank">
                            <img src="{{ asset('storage/' . $logbook['dokumentasi']) }}"
                                alt="Dokumentasi"
                                class="w-40 h-28 rounded-xl object-cover border border-slate-200 hover:opacity-90 transition">
                        </a>
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">Tidak ada dokumentasi terlampir.</p>
                @endif
                </div>
            </div>

        </div>

        {{-- ================= KOLOM KANAN ================= --}}
        <div class="space-y-5">

            {{-- Tindakan Mentor --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm">
                <h2 class="font-bold text-slate-800 mb-1.5">Tindakan Mentor</h2>
                <p class="text-sm text-slate-500 leading-relaxed mb-4">Berikan umpan balik konstruktif terhadap progres pengerjaan mentee hari ini.</p>

                <form action="{{ route('mentor.verifikasi-logbook.setujui', $logbook['id']) }}" method="POST">
                    @csrf

                    <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-2">Catatan Mentor</label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Tuliskan saran atau masukan untuk {{ $logbook['nama'] }} di sini..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white resize-none mb-4"></textarea>

                    <button type="submit" class="w-full bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition mb-2.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 12.5 5 5L20 6"/>
                        </svg>
                        Setujui Logbook
                    </button>
                </form>

                <form action="{{ route('mentor.verifikasi-logbook.minta-revisi', $logbook['id']) }}" method="POST">
                    @csrf
                    <input type="hidden" name="catatan_mentor" value="">
                    <button type="submit" onclick="this.form.catatan_mentor.value = document.getElementById('catatan').value"
                            class="w-full border-2 border-amber-400 text-amber-600 text-sm font-semibold py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-amber-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10a8 8 0 1 1 2.3 5.6M3 10v5M3 10h5"/>
                        </svg>
                        Minta Revisi
                    </button>
                </form>
            </div>

            {{-- Progres --}}
            @php($persenProgres = $logbook['progres']['total'] > 0 ? round(($logbook['progres']['terverifikasi'] / $logbook['progres']['total']) * 100) : 0)
            <div class="bg-blue-50 rounded-2xl p-5">
                <p class="text-sm font-bold text-blue-700 mb-3">Progres {{ $logbook['nama'] }}</p>
                <div class="flex items-center justify-between text-sm mb-1.5">
                    <span class="text-slate-600">Logbook Terverifikasi</span>
                    <span class="font-bold text-slate-800">{{ $logbook['progres']['terverifikasi'] }} / {{ $logbook['progres']['total'] }}</span>
                </div>
                <div class="h-2 bg-blue-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-600 rounded-full" style="width: {{ $persenProgres }}%"></div>
                </div>
            </div>

            {{-- Logbook Sebelumnya --}}
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-2.5">Logbook Sebelumnya</p>
                <div class="space-y-2">
                    @foreach ($logbook['riwayat'] as $riwayat)
                        <a href="{{ route('mentor.verifikasi-logbook.show', $riwayat['id']) }}" class="bg-white rounded-xl px-4 py-3 shadow-sm flex items-center justify-between hover:bg-slate-50 transition">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8 12.5 2.5 2.5 5-5.5"/>
                                </svg>
                                <span class="text-sm text-slate-700">{{ $riwayat['tanggal'] }}</span>
                            </div>
                            <svg class="w-4 h-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

@endsection