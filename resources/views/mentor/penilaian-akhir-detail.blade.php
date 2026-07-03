@extends('layouts.mentor')

@php($hideTopbar = true)

@section('title', 'Penilaian Akhir - ' . $peserta['nama'])

@section('content')

    {{--
        Topbar khusus halaman ini (breadcrumb + tombol kembali),
        dibuat manual di sini karena bentuknya beda dari topbar biasa
        (ada panah kembali, bukan kotak pencarian).
    --}}
    <div class="-mt-8 -mx-8 mb-8 bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between gap-4">
        <a href="{{ route('mentor.penilaian-akhir') }}" class="flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/>
            </svg>
            Penilaian Akhir - {{ $peserta['nama'] }}
        </a>

        <div class="flex items-center gap-4 flex-shrink-0">
            <button type="button" class="text-slate-400 hover:text-slate-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 17h12a1 1 0 0 0 .8-1.6L18 14V10a6 6 0 0 0-12 0v4l-.8 1.4A1 1 0 0 0 6 17Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19a2 2 0 0 0 4 0"/>
                </svg>
            </button>
            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm">
                {{ strtoupper(substr(auth()->user()->name ?? 'M', 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI: KARTU PESERTA ================= --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm h-fit">

            <div class="flex flex-col items-center text-center">
                {{--
                    Placeholder avatar (huruf depan nama). Ganti dengan foto asli, misalnya:
                    <img src="{{ asset('images/peserta/' . $peserta['id'] . '.jpg') }}" class="w-24 h-24 rounded-2xl object-cover" alt="{{ $peserta['nama'] }}">
                --}}
                <div class="w-24 h-24 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-3xl mb-3">
                    {{ $peserta['inisial'] }}
                </div>

                <span class="inline-block text-xs font-bold text-amber-900 bg-amber-400 px-3 py-1 rounded-full mb-3">INTERN</span>

                <p class="text-lg font-bold text-slate-800">{{ $peserta['nama'] }}</p>
                <p class="text-sm text-slate-500 mt-0.5">{{ $peserta['universitas'] }}</p>

                <span class="inline-block text-xs font-medium text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full mt-3">
                    Divisi {{ $peserta['divisi'] }}
                </span>
            </div>

            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mt-6 mb-3">Performance Metrics</p>

            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <rect x="4" y="5" width="16" height="16" rx="2"/>
                            <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-600 flex-1">Kehadiran</span>
                    <span class="text-sm font-bold text-slate-800">{{ $peserta['kehadiran'] }}%</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-600 flex-1">Logbook Disetujui</span>
                    <span class="text-sm font-bold text-slate-800">{{ $peserta['logbook_disetujui'] }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.5 15.5 1-3 4-4 2 2-4 4-3 1Z"/>
                        </svg>
                    </div>
                    <span class="text-sm text-slate-600 flex-1">Laporan Akhir</span>
                    <span class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ $peserta['laporan_akhir'] === 'Selesai' ? 'bg-green-50 text-green-600' : 'bg-amber-50 text-amber-600' }}">
                        {{ $peserta['laporan_akhir'] }}
                    </span>
                </div>
            </div>

            <div class="bg-blue-50 rounded-xl p-4 mt-6 flex items-start gap-2.5">
                <svg class="w-4 h-4 text-blue-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 8h.01"/>
                    <path stroke-linecap="round" d="M12 11v5"/>
                </svg>
                <p class="text-xs text-blue-700 leading-relaxed">
                    "Penilaian akhir ini bersifat permanen dan akan digunakan untuk penerbitan sertifikat magang."
                </p>
            </div>
        </div>

        {{-- ================= KOLOM KANAN: FORM EVALUASI ================= --}}
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm">

            <div class="flex items-start justify-between mb-6">
                <div>
                    <h2 class="font-bold text-slate-800">Formulir Evaluasi Mentor</h2>
                    <p class="text-sm text-slate-500 mt-1">Berikan penilaian objektif berdasarkan performa selama periode magang.</p>
                </div>
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3M9 15.5h6"/>
                </svg>
            </div>

            <form action="{{ route('mentor.penilaian-akhir.store', $peserta['id']) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 mb-6">

                    {{-- Keterampilan Teknis --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="keterampilan_teknis" class="text-sm font-semibold text-slate-700">Keterampilan Teknis (Work Quality)</label>
                            <span class="text-sm font-bold text-blue-600" id="teknisValue">{{ $peserta['nilai']['technicalAbility'] }}</span>
                        </div>
                        <input type="range" id="keterampilan_teknis" name="keterampilan_teknis" min="0" max="100" value="{{ $peserta['nilai']['technicalAbility'] }}"
                               class="w-full accent-blue-600" oninput="updateSkor()">
                        <p class="text-xs text-slate-400 mt-1">Penguasaan materi pekerjaan, kualitas hasil tugas, serta kelancaran menggunakan alat atau sistem kerja perusahaan</p>
                    </div>

                    {{-- Pemecahan Masalah & Inovasi --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="pemecahan_masalah" class="text-sm font-semibold text-slate-700">Pemecahan Masalah & Inovasi</label>
                            <span class="text-sm font-bold text-blue-600" id="masalahValue">{{ $peserta['nilai']['problemSolve'] }}</span>
                        </div>
                        <input type="range" id="pemecahan_masalah" name="pemecahan_masalah" min="0" max="100" value="{{ $peserta['nilai']['problemSolve'] }}"
                               class="w-full accent-blue-600" oninput="updateSkor()">
                        <p class="text-xs text-slate-400 mt-1">Inisiatif dan Kreativitas dalam mencari solusi atau memberikan ide baru saat bekerja</p>
                    </div>

                    {{-- Kedisiplinan & Sikap Kerja --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="kedisiplinan" class="text-sm font-semibold text-slate-700">Kedisiplinan & Sikap Kerja</label>
                            <span class="text-sm font-bold text-blue-600" id="disiplinValue">{{ $peserta['nilai']['disiplin'] }}</span>
                        </div>
                        <input type="range" id="kedisiplinan" name="kedisiplinan" min="0" max="100" value="{{ $peserta['nilai']['disiplin'] }}"
                               class="w-full accent-blue-600" oninput="updateSkor()">
                        <p class="text-xs text-slate-400 mt-1">Etos Kerja, Tanggung Jawab.</p>
                    </div>

                    {{-- Kerjasama Tim & Komunikasi --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="kerjasama" class="text-sm font-semibold text-slate-700">Kerjasama Tim & Komunikasi</label>
                            <span class="text-sm font-bold text-blue-600" id="kerjasamaValue">{{ $peserta['nilai']['kerjasama'] }}</span>
                        </div>
                        <input type="range" id="kerjasama" name="kerjasama" min="0" max="100" value="{{ $peserta['nilai']['kerjasama'] }}"
                               class="w-full accent-blue-600" oninput="updateSkor()">
                        <p class="text-xs text-slate-400 mt-1">Proaktifitas dalam kolaborasi tim.</p>
                    </div>

                    {{-- Kehadiran --}}
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="kehadiran" class="text-sm font-semibold text-slate-700">Kehadiran</label>
                            <span class="text-sm font-bold text-blue-600" id="kehadiranValue">{{ $peserta['nilai']['kehadiran'] }}</span>
                        </div>
                        <input type="range" id="kehadiran" name="kehadiran" min="0" max="100" value="{{ $peserta['nilai']['kehadiran'] }}"
                               class="w-full accent-blue-600" oninput="updateSkor()">
                        <p class="text-xs text-slate-400 mt-1">Kehadiran</p>
                    </div>

                </div>

                <div class="mb-6">
                    <label for="catatan" class="block text-sm font-semibold text-slate-700 mb-2">Catatan dan Evaluasi Tambahan</label>
                    <textarea id="catatan" name="catatan" rows="3" placeholder="Tuliskan feedback konstruktif untuk peserta..."
                              class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white resize-none">{{ $peserta['catatan'] }}</textarea>
                </div>

                {{-- Skor Akhir Terhitung --}}
                <div class="bg-gradient-to-r from-[#0B1437] to-blue-700 rounded-2xl px-6 py-5 flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wide">Skor Akhir Terhitung</p>
                        <p class="text-2xl font-bold text-white mt-1"><span id="skorAkhir">0</span> / 100</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-semibold text-blue-200 uppercase tracking-wide">Kategori</p>
                        <p class="text-lg font-bold text-amber-400 mt-1" id="kategoriSkor">-</p>
                    </div>
                </div>

                <hr class="border-slate-100 mb-5">

                <div class="flex items-center gap-3">
                    <a href="{{ route('mentor.penilaian-akhir') }}" class="border border-slate-200 text-slate-600 text-sm font-semibold px-5 py-2.5 rounded-xl flex items-center gap-2 hover:bg-slate-50 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl flex items-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4 12.5 5 5L20 6"/>
                        </svg>
                        Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>

    </div>

    {{-- Hitung otomatis skor akhir & kategori setiap kali slider digeser --}}
    <script>
        function updateSkor() {
            // Ambil nilai dari 5 input (gunakan || 0 untuk mencegah error jika input kosong)
            const teknis    = parseInt(document.getElementById('keterampilan_teknis').value) || 0;
            const masalah   = parseInt(document.getElementById('pemecahan_masalah').value) || 0;
            const disiplin  = parseInt(document.getElementById('kedisiplinan').value) || 0;
            const kerjasama = parseInt(document.getElementById('kerjasama').value) || 0;
            const kehadiran = parseInt(document.getElementById('kehadiran').value) || 0;

            // Update text/label di samping slider jika ada (sesuaikan ID text content-nya)
            if(document.getElementById('teknisValue')) document.getElementById('teknisValue').textContent = teknis;
            if(document.getElementById('masalahValue')) document.getElementById('masalahValue').textContent = masalah;
            if(document.getElementById('disiplinValue')) document.getElementById('disiplinValue').textContent = disiplin;
            if(document.getElementById('kerjasamaValue')) document.getElementById('kerjasamaValue').textContent = kerjasama;
            if(document.getElementById('kehadiranValue')) document.getElementById('kehadiranValue').textContent = kehadiran;

            // Hitung Rata-rata
            const skor = (teknis + masalah + disiplin + kerjasama + kehadiran) / 5;
            document.getElementById('skorAkhir').textContent = skor.toFixed(2);

            // Logika predikat
            let kategori;
            if (skor >= 90)      kategori = 'Sangat Baik';
            else if (skor >= 80) kategori = 'Baik';
            else if (skor >= 70) kategori = 'Cukup';
            else                 kategori = 'Perlu Bimbingan';

            document.getElementById('kategoriSkor').textContent = kategori;
        }

        // Panggil fungsi ini jika menggunakan input slider (oninput/onchange)
        // updateSkor(); 
    </script>

@endsection