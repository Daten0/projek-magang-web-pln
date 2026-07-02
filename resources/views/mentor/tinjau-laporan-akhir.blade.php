@extends('layouts.mentor')

@php($hideTopbar = true)

@section('title', 'Tinjau Laporan - ' . $laporan['nama'])

@section('content')

    {{-- Header + breadcrumb --}}
    <div class="-mt-8 -mx-8 mb-6 px-8 pt-8">
        <div class="text-sm text-slate-400 mb-1">
            <a href="{{ route('mentor.dashboard') }}" class="hover:text-blue-600">Beranda</a>
            <span class="mx-1.5">/</span>
            <a href="{{ route('mentor.verifikasi-laporan-akhir') }}" class="hover:text-blue-600">Verifikasi Laporan Akhir</a>
            <span class="mx-1.5">/</span>
            <span class="text-blue-600 font-medium">Tinjau Laporan</span>
        </div>
        <h1 class="text-xl font-bold text-blue-700">Tinjau Laporan</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ================= KOLOM KIRI: PROFIL PESERTA ================= --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Kartu profil --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm text-center">
                {{-- Placeholder avatar (huruf depan nama) — ganti dengan foto asli nanti --}}
                <div class="w-16 h-16 rounded-full {{ $laporan['warna_avatar'] }} flex items-center justify-center font-bold text-xl mx-auto mb-3">
                    {{ $laporan['inisial'] }}
                </div>
                <p class="font-bold text-slate-800">{{ $laporan['nama'] }}</p>
                <p class="text-sm text-blue-600 mt-0.5">{{ $laporan['jabatan_magang'] }}</p>

                <hr class="my-4 border-slate-100">

                <div class="text-left space-y-3">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Instansi</p>
                        <p class="text-sm text-slate-700 mt-0.5">{{ $laporan['asal'] }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Divisi</p>
                        <p class="text-sm text-slate-700 mt-0.5">{{ $laporan['divisi'] }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wide">Periode</p>
                        <p class="text-sm text-slate-700 mt-0.5">{{ $laporan['periode'] }}</p>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Aktivitas --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <h2 class="font-bold text-slate-800 text-sm mb-3">Ringkasan Aktivitas</h2>
                <div class="space-y-2">
                    <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-slate-50">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="3.5" y="4.5" width="17" height="16" rx="2"/>
                                <path stroke-linecap="round" d="M3.5 9.5h17M8 3v3M16 3v3"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 14 1.8 1.8L15 12"/>
                            </svg>
                            Kehadiran
                        </div>
                        <span class="font-bold text-slate-800 text-sm">{{ $laporan['ringkasan']['kehadiran'] }}%</span>
                    </div>

                    <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-slate-50">
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                            </svg>
                            Total Logbook
                        </div>
                        <span class="font-bold text-slate-800 text-sm">{{ $laporan['ringkasan']['total_logbook'] }}</span>
                    </div>

                    <div class="flex items-center justify-between px-3 py-2.5 rounded-xl bg-blue-50">
                        <div class="flex items-center gap-2 text-sm text-blue-700">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                            </svg>
                            Disetujui
                        </div>
                        <span class="font-bold text-blue-700 text-sm">{{ $laporan['ringkasan']['logbook_disetujui'] }}/{{ $laporan['ringkasan']['total_logbook'] }}</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= KOLOM TENGAH: PREVIEW DOKUMEN ================= --}}
        <div class="lg:col-span-6">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                {{-- Header file --}}
                <div class="flex items-center gap-3 px-5 py-4 bg-blue-50/60">
                    <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center text-red-500 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-slate-700 text-sm truncate">{{ $laporan['nama_file'] }}</p>
                        <p class="text-xs text-slate-400">{{ $laporan['ukuran_file'] }} &middot; Diunggah {{ $laporan['tanggal'] }}</p>
                    </div>
                </div>

                {{--
                    Preview PDF asli lewat <iframe>. Browser modern (Chrome, Edge, Firefox)
                    punya PDF viewer bawaan, jadi file akan tampil lengkap dengan
                    scroll, zoom, dan kontrol halaman tanpa perlu library tambahan.
                --}}
                @if ($laporan['file_url'])
                    <div class="bg-slate-100">
                        <iframe
                            src="{{ $laporan['file_url'] }}#toolbar=1&navpanes=0"
                            class="w-full"
                            style="height: 640px; border: none;"
                            title="Preview {{ $laporan['nama_file'] }}">
                        </iframe>
                    </div>
                @else
                    <div class="bg-slate-50 p-10 flex flex-col items-center gap-3 text-center">
                        <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4M9 14l3 3 3-3M12 17V9"/>
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-slate-500">File tidak ditemukan di server.</p>
                        <p class="text-xs text-slate-400">Peserta mungkin belum mengunggah ulang, atau file telah dipindahkan.</p>
                    </div>
                @endif

                {{-- Tautan unduh file asli --}}
                <div class="flex items-center justify-center py-4 border-t border-slate-100">
                    @if ($laporan['file_url'])
                        <a href="{{ $laporan['file_url'] }}" download="{{ $laporan['nama_file'] }}" class="flex items-center gap-2 text-sm font-medium text-blue-600 hover:underline">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                            </svg>
                            Unduh Dokumen
                        </a>
                    @else
                        <span class="flex items-center gap-2 text-sm font-medium text-slate-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                            </svg>
                            Unduh Dokumen
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- ================= KOLOM KANAN: VERIFIKASI ================= --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                    <h2 class="font-bold text-slate-800 text-sm">Verifikasi Laporan</h2>
                </div>

                <form id="form-aksi-laporan" method="POST" action="{{ route('mentor.verifikasi-laporan-akhir.setujui', $laporan['id']) }}">
                    @csrf

                    {{-- Toggle pilihan aksi: Setuju / Revisi --}}
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <button type="button" onclick="pilihAksiLaporan('setuju', this)" data-aksi="setuju"
                                class="toggle-aksi-btn border-2 border-blue-600 bg-blue-50 text-blue-700 rounded-xl py-2.5 flex flex-col items-center gap-1 text-xs font-semibold transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                            </svg>
                            Setuju
                        </button>
                        <button type="button" onclick="pilihAksiLaporan('revisi', this)" data-aksi="revisi"
                                class="toggle-aksi-btn border border-slate-200 text-slate-500 rounded-xl py-2.5 flex flex-col items-center gap-1 text-xs font-semibold hover:bg-slate-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5 19 6l-9.5 9.5-3 .5.5-3L16.5 3.5Z"/>
                            </svg>
                            Revisi
                        </button>
                    </div>

                    <label for="catatan" class="block text-[11px] font-bold text-slate-400 uppercase tracking-wide mb-2">Catatan Mentor</label>
                    <textarea id="catatan" name="catatan" rows="4" placeholder="Tuliskan feedback atau detail revisi di sini..."
                              class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white resize-none mb-4"></textarea>

                    <button type="submit" class="w-full bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 4 12 8-12 8V4Z"/>
                        </svg>
                        Simpan
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{--
        JS kecil: tombol toggle "Setuju" / "Revisi" cuma untuk mengganti tujuan
        form (action) dan tampilan aktif, supaya 1 tombol "Simpan" bisa
        memanggil 2 route yang berbeda (setujui / minta-revisi).
    --}}
    <script>
        function pilihAksiLaporan(aksi, btn) {
            document.querySelectorAll('.toggle-aksi-btn').forEach((b) => {
                b.classList.remove('border-2', 'border-blue-600', 'bg-blue-50', 'text-blue-700');
                b.classList.add('border', 'border-slate-200', 'text-slate-500');
            });
            btn.classList.remove('border', 'border-slate-200', 'text-slate-500');
            btn.classList.add('border-2', 'border-blue-600', 'bg-blue-50', 'text-blue-700');

            const form = document.getElementById('form-aksi-laporan');
            form.action = aksi === 'setuju'
                ? @json(route('mentor.verifikasi-laporan-akhir.setujui', $laporan['id']))
                : @json(route('mentor.verifikasi-laporan-akhir.minta-revisi', $laporan['id']));
        }
    </script>

@endsection