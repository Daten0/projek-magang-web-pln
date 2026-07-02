@extends('layouts.admin')

@php($topbarTitle = 'Tinjau Pendaftaran')

@section('title', 'Tinjau Pendaftaran')

@section('content')

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-1.5 text-sm text-slate-400 mb-5">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
        <span>›</span>
        <a href="{{ route('admin.validasi-pendaftaran') }}" class="hover:text-blue-600 transition">Validasi Pendaftaran</a>
        <span>›</span>
        <span class="text-blue-600 font-medium">Tinjau Pendaftaran</span>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl px-5 py-3 mb-5">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- ================= DATA PENDAFTAR ================= --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm mb-5">
        <h2 class="font-bold text-slate-800 mb-5">Data Pendaftar</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

            <div>
                <p class="text-xs text-slate-400 mb-1.5">NAMA LENGKAP</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['nama_lengkap'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">EMAIL</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9 6 9-6"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['email'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">NOMOR TELEPON</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['nomor_telepon'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">INSTITUSI PENDIDIKAN</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9.5 12 4l9 5.5-9 5.5-9-5.5Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.5 11.5V17c0 1 2.5 2 5.5 2s5.5-1 5.5-2v-5.5"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['institusi'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">JURUSAN / PRODI</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['jurusan'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">NIM / NIS</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h5"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['nim'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">JENIS PENDAFTARAN</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="6" width="16" height="14" rx="2"/>
                        <path stroke-linecap="round" d="M8 6V4.5A1.5 1.5 0 0 1 9.5 3h5A1.5 1.5 0 0 1 16 4.5V6"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['jenis'] }}</span>
                </div>
            </div>

            <div>
                <p class="text-xs text-slate-400 mb-1.5">TANGGAL PENGAJUAN</p>
                <div class="flex items-center gap-2 bg-blue-50 rounded-xl px-4 py-3">
                    <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="5" width="16" height="16" rx="2"/>
                        <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
                    </svg>
                    <span class="text-sm font-semibold text-blue-700">{{ $pendaftar['tanggal_daftar'] }}</span>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= KEPUTUSAN VALIDASI ================= --}}
    <div class="bg-white rounded-2xl p-6 shadow-sm">
        <h2 class="font-bold text-slate-800 mb-5 flex items-center gap-2">
            <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h13M4 7l3-3M4 7l3 3M20 17H7m13 0-3-3m3 3-3 3"/>
            </svg>
            Keputusan Validasi
        </h2>

        <form action="{{ route('admin.validasi-pendaftaran.update', $pendaftar['id']) }}" method="POST">
            @csrf

            {{-- Pilihan Diterima / Ditolak --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <label class="cursor-pointer">
                    <input type="radio" name="aksi" value="terima" id="aksi-terima" class="sr-only peer"
                        {{ $pendaftar['status'] !== 'ditolak' ? 'checked' : '' }}>
                    <div class="border-2 border-slate-200 peer-checked:border-green-500 peer-checked:bg-green-50/50 rounded-xl p-5 flex flex-col items-center text-center transition">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 mb-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7"/>
                            </svg>
                        </div>
                        <p class="font-bold text-green-600">Diterima</p>
                        <p class="text-xs text-slate-400 mt-1">Kualifikasi peserta sesuai dengan kebutuhan unit kerja.</p>
                    </div>
                </label>

                <label class="cursor-pointer">
                    <input type="radio" name="aksi" value="tolak" id="aksi-tolak" class="sr-only peer"
                        {{ $pendaftar['status'] === 'ditolak' ? 'checked' : '' }}>
                    <div class="border-2 border-slate-200 peer-checked:border-red-400 peer-checked:bg-red-50/50 rounded-xl p-5 flex flex-col items-center text-center transition">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-500 mb-3">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18"/>
                            </svg>
                        </div>
                        <p class="font-bold text-red-500">Ditolak</p>
                        <p class="text-xs text-slate-400 mt-1">Kualifikasi peserta belum memenuhi persyaratan minimum.</p>
                    </div>
                </label>
            </div>

            <hr class="border-slate-100 mb-6">

            {{-- Section Diterima --}}
            <div id="section-terima">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Divisi Penempatan <span class="text-red-400">*</span></label>
                        <select name="divisi" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Divisi</option>
                            @foreach ($divisiOptions as $divisi)
                                <option value="{{ $divisi }}" {{ $pendaftar['status'] === 'aktif' && ($pendaftar['divisi'] ?? '') === $divisi ? 'selected' : '' }}>
                                    {{ $divisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Mentor Pembimbing <span class="text-red-400">*</span></label>
                        <select name="mentor_id" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Mentor</option>
                            @foreach ($mentorOptions as $mentor)
                                <option value="{{ $mentor['id'] }}">{{ $mentor['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Periode Magang <span class="text-red-400">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="periode_mulai"
                                   value="{{ $pendaftar['periode_mulai'] }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span class="text-slate-400 text-sm flex-shrink-0">s/d</span>
                            <input type="date" name="periode_selesai"
                                   value="{{ $pendaftar['periode_selesai'] }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1.5">Status Awal</label>
                        <div class="flex items-center gap-2 bg-slate-100 rounded-xl px-4 py-2.5">
                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="4" y="5" width="16" height="16" rx="2"/>
                                <path stroke-linecap="round" d="M8 3v4M16 3v4M4 10h16"/>
                            </svg>
                            <span class="text-sm text-slate-500">{{ $pendaftar['status_awal'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Section Ditolak --}}
            <div id="section-tolak" class="hidden mb-6">
                <label class="block text-sm font-medium text-slate-600 mb-1.5">Alasan Penolakan <span class="text-red-400">*</span></label>
                <textarea name="alasan_ditolak" rows="4"
                          placeholder="Tuliskan alasan penolakan pendaftaran ini..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $pendaftar['alasan_ditolak'] }}</textarea>
                <p class="text-xs text-slate-400 mt-1">Alasan ini akan dilihat oleh peserta.</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.validasi-pendaftaran') }}"
                   class="px-5 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex items-center gap-2 bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21v-8h10v8M7 3v5h8"/>
                    </svg>
                    Simpan Keputusan
                </button>
            </div>

        </form>
    </div>

    <script>
        const radioTerima = document.getElementById('aksi-terima');
        const radioTolak  = document.getElementById('aksi-tolak');
        const sectionTerima = document.getElementById('section-terima');
        const sectionTolak  = document.getElementById('section-tolak');

        function toggleSection() {
            if (radioTolak.checked) {
                sectionTerima.classList.add('hidden');
                sectionTolak.classList.remove('hidden');
            } else {
                sectionTerima.classList.remove('hidden');
                sectionTolak.classList.add('hidden');
            }
        }

        radioTerima.addEventListener('change', toggleSection);
        radioTolak.addEventListener('change', toggleSection);

        // Init saat load
        toggleSection();
    </script>

@endsection