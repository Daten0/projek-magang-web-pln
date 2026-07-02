@extends('layouts.app')

@php($hideTopbar = true)

@section('title', isset($logbook) ? 'Edit Logbook' : 'Tambah Logbook Harian')

@section('content')

    {{-- Breadcrumb --}}
    <div class="text-sm text-slate-400 mb-2">
        <a href="{{ route('logbook.index') }}" class="hover:text-blue-600">Logbook</a>
        <span class="mx-1.5">/</span>
        <span class="text-slate-500">{{ isset($logbook) ? 'Edit Logbook' : 'Tambah Harian' }}</span>
    </div>

    <h1 class="text-2xl font-bold text-slate-800 mb-6">
        {{ isset($logbook) ? 'Edit Logbook' : 'Tambah Logbook Harian' }}
    </h1>

    @if ($sudahIsi && !isset($logbook))
        <div class="bg-amber-50 border border-amber-200 text-amber-700 rounded-xl px-5 py-4 mb-6 flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
            </svg>
            <p class="text-sm font-medium">Kamu sudah mengisi logbook hari ini. Kamu bisa mengisi kembali besok.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= FORM ================= --}}
        <form action="{{ isset($logbook) ? route('logbook.update', $logbook->id) : route('logbook.store') }}"
              method="POST" enctype="multipart/form-data"
              class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm space-y-5"
              onkeydown="return event.key !== 'Enter'">
            @csrf
            @if(isset($logbook))
                @method('PUT')
            @endif

            {{-- Tanggal Kegiatan --}}
            <div>
                <label for="tanggal_kegiatan" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Tanggal Kegiatan <span class="text-red-500">*</span>
                </label>
                <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan"
                       value="{{ old('tanggal_kegiatan', isset($logbook) ? \Carbon\Carbon::parse($logbook->tanggal_kegiatan ?? $logbook->tanggal)->format('Y-m-d') : date('Y-m-d')) }}"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('tanggal_kegiatan') border-red-400 @enderror">
                @error('tanggal_kegiatan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jam Kegiatan --}}
            <div>
                <label for="jam_kegiatan" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Jam Kegiatan <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/>
                        </svg>
                    </span>
                    <input type="time" id="jam_kegiatan" name="jam_kegiatan"
                           value="{{ old('jam_kegiatan', isset($logbook) ? $logbook->jam_kegiatan : '08:00') }}"
                           lang="id" required
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('jam_kegiatan') border-red-400 @enderror">
                </div>
                @error('jam_kegiatan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Judul Aktivitas --}}
            <div>
                <label for="judul_aktivitas" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Judul Aktivitas <span class="text-red-500">*</span>
                </label>
                <input type="text" id="judul_aktivitas" name="judul_aktivitas"
                       value="{{ old('judul_aktivitas', $logbook->judul_aktivitas ?? '') }}"
                       placeholder="Contoh: Membuat laporan bulanan divisi IT"
                       required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white @error('judul_aktivitas') border-red-400 @enderror">
                @error('judul_aktivitas')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1.5">
                    Deskripsi Kegiatan <span class="text-red-500">*</span>
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="6" required
                          placeholder="Ceritakan detail aktivitas, tantangan yang dihadapi, dan hasil yang dicapai..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white resize-none @error('deskripsi') border-red-400 @enderror">{{ old('deskripsi', $logbook->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Dokumentasi (Opsional) --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">
                    Upload Dokumentasi <span class="text-slate-400 font-normal">(opsional)</span>
                </label>
                <div id="dropZone" class="border-2 border-dashed border-slate-200 bg-blue-50/30 rounded-2xl py-10 px-6 flex flex-col items-center text-center cursor-pointer transition">
                    <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 18a4 4 0 0 1-1-7.87A5 5 0 0 1 16 9a4 4 0 1 1 1 8H7Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-5M9.5 13.5 12 11l2.5 2.5"/>
                        </svg>
                    </div>
                    <p class="font-semibold text-slate-700 text-sm" id="dropHint">
                        {{ isset($logbook) && $logbook->dokumentasi ? 'File lama: ' . $logbook->dokumentasi : 'Klik untuk upload atau tarik file ke sini' }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1">PNG, JPG, JPEG (Maks. 5MB)</p>
                    <input type="file" id="fileInput" name="dokumentasi" accept=".png,.jpg,.jpeg" class="hidden">
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('logbook.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold text-sm px-6 py-3 rounded-xl flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit" {{ ($sudahIsi && !isset($logbook)) ? 'disabled' : '' }}
                        class="bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm px-6 py-3 rounded-xl flex items-center gap-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>
                    {{ isset($logbook) ? 'Simpan Perubahan' : 'Submit Logbook' }}
                </button>
            </div>
        </form>

        {{-- ================= TIPS PENGISIAN ================= --}}
        <div class="bg-indigo-50 rounded-2xl p-5 h-fit">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18h6M10 21h4M12 3a6 6 0 0 0-3.5 10.9c.4.3.6.8.6 1.3V16h5.8v-.8c0-.5.2-1 .6-1.3A6 6 0 0 0 12 3Z"/>
                </svg>
                <h2 class="font-bold text-slate-800">Tips Pengisian</h2>
            </div>
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">1</span>
                    <p class="text-sm text-slate-600 leading-relaxed">Tuliskan Judul Aktivitas secara singkat dan jelas agar mudah diidentifikasi oleh mentor.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">2</span>
                    <p class="text-sm text-slate-600 leading-relaxed">Tuliskan Deskripsi secara spesifik, mencakup APA yang dilakukan dan BAGAIMANA hasilnya.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">3</span>
                    <p class="text-sm text-slate-600 leading-relaxed">Dokumentasi bersifat opsional — upload foto kegiatan jika ada untuk memperkuat logbook kamu.</p>
                </div>
                <div class="flex items-start gap-3">
                    <span class="w-5 h-5 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center flex-shrink-0">4</span>
                    <p class="text-sm text-slate-600 leading-relaxed">Isi logbook setiap hari agar detail pekerjaan tidak terlupakan dan mempermudah mentor melakukan review.</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        const dropZone  = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const dropHint  = document.getElementById('dropHint');

        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                dropHint.textContent = `File terpilih: ${fileInput.files[0].name}`;
            }
        });

        ['dragover', 'dragleave', 'drop'].forEach((e) => {
            dropZone.addEventListener(e, (ev) => ev.preventDefault());
        });

        dropZone.addEventListener('dragover', () => dropZone.classList.add('border-blue-400', 'bg-blue-50'));
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-blue-400', 'bg-blue-50'));
        dropZone.addEventListener('drop', (e) => {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                dropHint.textContent = `File terpilih: ${e.dataTransfer.files[0].name}`;
            }
        });
    </script>

@endsection