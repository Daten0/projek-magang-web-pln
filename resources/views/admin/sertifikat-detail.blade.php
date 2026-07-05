@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Detail Sertifikat')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-slate-400 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>›</span>
        <a href="{{ route('admin.sertifikat') }}" class="hover:text-blue-600 transition">Sertifikat</a>
        <span>›</span>
        <span class="text-slate-600 font-medium">Detail Sertifikat</span>
    </div>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Detail Sertifikat:</h1>
        @if ($peserta['status_sertifikat'] === 'siap_diterbitkan')
                <form method="POST" action="{{ route('admin.sertifikat.terbitkan', $peserta['id']) }}"
            enctype="multipart/form-data" class="flex items-center gap-3">
            @csrf

            {{-- Input upload file PDF sertifikat --}}
            <label class="flex items-center gap-2 px-4 py-2.5 border border-slate-200 rounded-xl text-sm text-slate-600 bg-white hover:bg-slate-50 cursor-pointer transition">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                </svg>
                <span id="namaFile">Pilih file PDF...</span>
                <input type="file" name="file_sertifikat" accept=".pdf" required class="hidden"
                    onchange="document.getElementById('namaFile').textContent = this.files[0]?.name ?? 'Pilih file PDF...'">
            </label>

            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l2.5 2.5"/>
                </svg>
                Terbitkan Sertifikat
            </button>
        </form>
        @else
            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-green-100 text-green-700 text-sm font-semibold rounded-xl">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                </svg>
                Sudah Diterbitkan
            </span>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-5">

        {{-- ================= KIRI ================= --}}
        <div class="w-full lg:w-72 flex-shrink-0 space-y-4">

            {{-- Kartu Profil --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-200 flex-shrink-0">
                        @if ($peserta['foto'])
                            <img src="{{ $peserta['foto'] }}" alt="{{ $peserta['nama'] }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-lg font-bold text-slate-500">
                                {{ $peserta['inisial'] }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-bold text-slate-800 text-base leading-tight">{{ $peserta['nama'] }}</p>
                        <p class="text-sm text-slate-500">{{ $peserta['universitas'] }}</p>
                        @if ($peserta['status_magang'] === 'Aktif')
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                AKTIF
                            </span>
                        @elseif ($peserta['status_magang'] === 'Selesai')
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700 rounded-full">
                                SELESAI
                            </span>
                        @else
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-500 rounded-full">
                                TIDAK AKTIF
                            </span>
                        @endif
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-slate-400">Divisi</span>
                        <span class="font-semibold text-slate-700 text-right">{{ $peserta['divisi'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Mentor</span>
                        <span class="font-semibold text-slate-700">{{ $peserta['mentor'] }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-400">Periode</span>
                        <span class="font-semibold text-slate-700">{{ $peserta['periode'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Persyaratan Kelulusan --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 1 4 0M9 12l2 2 4-4"/>
                    </svg>
                    <h3 class="font-semibold text-blue-700">Persyaratan Kelulusan</h3>
                </div>
                <div class="space-y-3">
                    @foreach ($syarat as $item)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">{{ $item['label'] }}</span>
                        @if ($item['terpenuhi'])
                            <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Info --}}
                <div class="mt-4 flex gap-2 p-3 bg-blue-50 rounded-xl">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v1M12 11v5"/>
                    </svg>
                    <p class="text-xs text-blue-600 leading-relaxed">
                        Semua persyaratan telah terpenuhi secara otomatis melalui validasi sistem. Sertifikat siap diterbitkan.
                    </p>
                </div>
            </div>

        </div>

        {{-- ================= KANAN ================= --}}
        <div class="flex-1 min-w-0 space-y-4">

            {{-- Preview Sertifikat --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h3 class="font-semibold text-slate-700">Preview Sertifikat</h3>
                        <p class="text-sm text-slate-500">Tampilkan satu halaman, geser untuk melihat halaman berikutnya.</p>
                    </div>
                    <div class="flex items-center gap-2 text-slate-400">
                        <button id="slidePrevBtn" type="button" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition" aria-label="Halaman sebelumnya">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button id="slideNextBtn" type="button" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 flex items-center justify-center transition" aria-label="Halaman berikutnya">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Sertifikat slider --}}
                <div class="p-6">
                    <div class="space-y-5">
                        <div id="sertifikatSlider" class="relative overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-sm">

                            {{-- Slide 1 --}}
                            <div data-sertifikat-slide class="slide block">
                                <div class="relative">
                                    <img src="{{ route('serti-template.file', '53.svg') }}" alt="Template 53" class="w-full h-auto block" />
                                    <div class="absolute inset-0 pointer-events-none">
                                        <div class="absolute inset-x-0 top-[18%] text-center px-4">
                                            <p class="text-xs font-semibold text-slate-600 tracking-[0.35em] uppercase">Sertifikat Magang</p>
                                            <p class="mt-4 text-3xl sm:text-4xl font-black text-slate-900 uppercase tracking-[0.12em] leading-tight">{{ strtoupper($peserta['nama']) }}</p>
                                            <p class="mt-4 text-sm text-slate-700 max-w-xl mx-auto leading-relaxed">
                                                Telah menyelesaikan program magang di PT PLN (Persero) pada Divisi {{ $peserta['divisi'] }} periode {{ $peserta['periode'] }}.
                                            </p>
                                        </div>
                                        <div class="absolute left-5 bottom-24 text-sm text-slate-700 space-y-2">
                                            <div><span class="font-semibold">Universitas</span>: {{ $peserta['universitas'] }}</div>
                                            <div><span class="font-semibold">Mentor</span>: {{ $peserta['mentor'] }}</div>
                                            <div><span class="font-semibold">Tanggal Terbit</span>: {{ $peserta['tanggal_terbit'] }}</div>
                                        </div>
                                        <div class="absolute right-5 bottom-24 text-sm text-slate-700 text-right space-y-2">
                                            <div><span class="font-semibold">Nomor</span>: PLN/CERT/{{ date('Y') }}/{{ str_pad($peserta['id'], 4, '0', STR_PAD_LEFT) }}</div>
                                            <div><span class="font-semibold">Status</span>: {{ $penilaianakhir['status_kelulusan'] ?? 'Belum Dinilai' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Slide 2 --}}
                            <div data-sertifikat-slide class="slide hidden">
                                <div class="relative">
                                    <img src="{{ route('serti-template.file', '54.svg') }}" alt="Template 54" class="w-full h-auto block" />
                                    <div class="absolute inset-0 pointer-events-none">
                                        <div class="absolute inset-x-0 top-[14%] text-center px-4">
                                            <p class="text-xs font-semibold text-slate-600 tracking-[0.35em] uppercase">Ringkasan Penilaian Akhir</p>
                                            <p class="mt-3 text-xl font-bold text-slate-900 tracking-tight">Hasil Kriteria Penilaian</p>
                                        </div>
                                        <div class="absolute inset-x-5 top-[34%] grid grid-cols-1 gap-3 text-sm text-slate-700">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="rounded-2xl bg-white/95 p-3 border border-slate-200">
                                                    <p class="font-semibold text-slate-700">Keterampilan Teknis</p>
                                                    <p class="mt-2 text-blue-600 font-bold">{{ $penilaianakhir['keterampilan_teknis'] ?? '—' }}%</p>
                                                </div>
                                                <div class="rounded-2xl bg-white/95 p-3 border border-slate-200">
                                                    <p class="font-semibold text-slate-700">Pemecahan Masalah</p>
                                                    <p class="mt-2 text-blue-600 font-bold">{{ $penilaianakhir['pemecahan_masalah'] ?? '—' }}%</p>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="rounded-2xl bg-white/95 p-3 border border-slate-200">
                                                    <p class="font-semibold text-slate-700">Kedisiplinan</p>
                                                    <p class="mt-2 text-blue-600 font-bold">{{ $penilaianakhir['kedisiplinan'] ?? '—' }}%</p>
                                                </div>
                                                <div class="rounded-2xl bg-white/95 p-3 border border-slate-200">
                                                    <p class="font-semibold text-slate-700">Kerjasama</p>
                                                    <p class="mt-2 text-blue-600 font-bold">{{ $penilaianakhir['kerjasama'] ?? '—' }}%</p>
                                                </div>
                                            </div>
                                            <div class="rounded-2xl bg-white/95 p-3 border border-slate-200">
                                                <p class="font-semibold text-slate-700">Kehadiran</p>
                                                <p class="mt-2 text-blue-600 font-bold">{{ $penilaianakhir['kehadiran'] ?? '—' }}%</p>
                                            </div>
                                        </div>
                                        <div class="absolute left-5 bottom-32 w-[46%] text-sm text-slate-700 bg-white/90 rounded-3xl p-4 border border-slate-200">
                                            <p class="font-semibold text-slate-700">Catatan Mentor</p>
                                            <p class="mt-3 leading-relaxed text-slate-600">{{ $penilaianakhir['catatan'] ?? 'Belum ada catatan.' }}</p>
                                        </div>
                                        <div class="absolute right-5 bottom-28 w-[42%] text-right text-slate-700 bg-white/90 rounded-3xl p-4 border border-slate-200">
                                            <p class="text-xs uppercase font-semibold tracking-[0.18em] text-slate-500">Nilai Akhir</p>
                                            <p class="mt-3 text-4xl font-black text-slate-900">{{ $penilaianakhir['nilai_akhir'] ?? '0' }}</p>
                                            <p class="mt-2 uppercase tracking-[0.18em] font-semibold {{ ($penilaianakhir['status_kelulusan'] ?? '') === 'Lulus' ? 'text-emerald-600' : 'text-amber-500' }}">
                                                {{ $penilaianakhir['status_kelulusan'] ?? 'Belum Dinilai' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-2 justify-center sm:justify-start">
                                <button data-slide-index="0" type="button" class="slide-tab inline-flex items-center justify-center px-3 py-2 rounded-2xl border border-slate-200 bg-white text-slate-700 text-sm font-semibold transition">Halaman 1</button>
                                <button data-slide-index="1" type="button" class="slide-tab inline-flex items-center justify-center px-3 py-2 rounded-2xl border border-slate-200 bg-white text-slate-700 text-sm font-semibold transition">Halaman 2</button>
                            </div>
                            <div class="text-sm text-slate-500">Halaman <span id="slideIndicator">1</span> dari 2</div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <a href="{{ route('serti-template.file', '53.svg') }}" download="template-53.svg" class="inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                                Download Template Halaman 1
                            </a>
                            <a href="{{ route('serti-template.file', '54.svg') }}" download="template-54.svg" class="inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl border border-slate-200 bg-white text-slate-700 text-sm font-semibold hover:bg-slate-50 transition">
                                Download Template Halaman 2
                            </a>
                            <a href="{{ route('admin.sertifikat.download', $peserta['id']) }}" class="inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-amber-400 text-white text-sm font-semibold hover:bg-amber-500 transition">
                                Download Sertifikat PDF
                            </a>
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const slides = Array.from(document.querySelectorAll('[data-sertifikat-slide]'));
                        const prevBtn = document.getElementById('slidePrevBtn');
                        const nextBtn = document.getElementById('slideNextBtn');
                        const indicator = document.getElementById('slideIndicator');
                        const tabs = Array.from(document.querySelectorAll('[data-slide-index]'));
                        let current = 0;

                        function updateSlide(index) {
                            if (index < 0 || index >= slides.length) {
                                return;
                            }
                            slides[current].classList.add('hidden');
                            slides[current].classList.remove('block');
                            slides[index].classList.remove('hidden');
                            slides[index].classList.add('block');
                            tabs[current].classList.remove('bg-slate-900', 'text-white');
                            tabs[current].classList.add('bg-white', 'text-slate-700');
                            tabs[index].classList.remove('bg-white', 'text-slate-700');
                            tabs[index].classList.add('bg-slate-900', 'text-white');
                            current = index;
                            indicator.textContent = current + 1;
                            prevBtn.disabled = current === 0;
                            nextBtn.disabled = current === slides.length - 1;
                        }

                        prevBtn.addEventListener('click', function () {
                            updateSlide(current - 1);
                        });

                        nextBtn.addEventListener('click', function () {
                            updateSlide(current + 1);
                        });

                        tabs.forEach(function (tab) {
                            tab.addEventListener('click', function () {
                                updateSlide(parseInt(this.dataset.slideIndex, 10));
                            });
                        });

                        updateSlide(0);
                    });
                </script>

            {{-- Riwayat Sertifikat --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-700">Riwayat Sertifikat</h3>
                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 3"/>
                    </svg>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                            <th class="px-6 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Nomor Sertifikat</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Admin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($riwayat as $r)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-slate-600">{{ $r['tanggal'] }}</td>
                            <td class="px-4 py-4 font-semibold text-blue-600">{{ $r['nomor'] }}</td>
                            <td class="px-4 py-4">
                                <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 tracking-wide">
                                    {{ strtoupper($r['status']) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-slate-600">{{ $r['admin'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection