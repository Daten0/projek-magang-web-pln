@extends('layouts.app')

@php($hideSearch = true)

@section('title', 'Laporan Akhir')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Laporan Akhir</h1>
        <p class="text-slate-500 mt-1 max-w-2xl">Unggah laporan akhir sebagai salah satu syarat penyelesaian program magang.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ================= KOLOM KIRI ================= --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Upload box --}}
            <form action="{{ route('laporan-akhir.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl p-6 shadow-sm">
                @csrf

                <div id="dropZone" class="border-2 border-dashed border-slate-200 rounded-2xl py-12 px-6 flex flex-col items-center text-center transition">
                    <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 18a4 4 0 0 1-1-7.87A5 5 0 0 1 16 9a4 4 0 1 1 1 8H7Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16v-5M9.5 13.5 12 11l2.5 2.5"/>
                        </svg>
                    </div>

                    <p class="font-semibold text-slate-700">Tarik dan lepas file di sini</p>
                    <p class="text-sm text-slate-500 mt-1 max-w-xs" id="dropHint">atau klik tombol di bawah untuk memilih file dari komputer Anda</p>

                    <button type="button" id="pickFileBtn" class="mt-5 bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                        Pilih File
                    </button>
                    <input type="file" id="fileInput" name="laporan" accept=".pdf" class="hidden">

                    <p class="text-xs text-slate-400 mt-4">Format yang didukung: PDF (Maksimal 10 MB)</p>
                </div>

                <button type="submit" class="mt-5 w-full bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm py-3.5 rounded-xl flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12.5 2.5 2.5 5-5.5"/>
                    </svg>
                    Upload Laporan Akhir
                </button>
            </form>

            {{-- Riwayat Pengunggahan --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                    <h2 class="font-bold text-slate-800">Riwayat Pengunggahan</h2>
                    <span class="text-sm text-slate-400">Menampilkan {{ count($riwayat) }} data terakhir</span>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-slate-400 text-xs uppercase tracking-wide border-b border-slate-100">
                            <th class="px-6 py-3.5 font-medium">Tanggal</th>
                            <th class="px-6 py-3.5 font-medium">Nama File</th>
                            <th class="px-6 py-3.5 font-medium">Status</th>
                            <th class="px-6 py-3.5 font-medium text-right">Aksi</th>
                        </tr>
                    </thead>
                    @if (count($riwayat) > 0)
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($riwayat as $item)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 text-slate-700">{{ $item['tanggal'] }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $item['nama_file'] }}</td>
                                    <td class="px-6 py-4 text-slate-700">{{ $item['status'] }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" class="text-slate-400 hover:text-slate-600">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                                                <circle cx="12" cy="5" r="1.4"/>
                                                <circle cx="12" cy="12" r="1.4"/>
                                                <circle cx="12" cy="19" r="1.4"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>

                @if (count($riwayat) === 0)
                    <div class="flex flex-col items-center justify-center py-14 text-center">
                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <rect x="5" y="3" width="14" height="18" rx="2"/>
                            <path stroke-linecap="round" d="M5 21 19 3"/>
                        </svg>
                        <p class="text-slate-400 text-sm mt-3">Belum ada riwayat pengunggahan laporan.</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- ================= KOLOM KANAN: PERSYARATAN ================= --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm h-fit">

            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 5 6v5c0 5 3 8.5 7 10 4-1.5 7-5 7-10V6l-7-3Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4.5"/>
                </svg>
                <h2 class="font-bold text-slate-800">Persyaratan Laporan</h2>
            </div>

            <ul class="space-y-3 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12.5 9 17l11-11"/>
                    </svg>
                    <span>Laporan harus dalam format PDF.</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12.5 9 17l11-11"/>
                    </svg>
                    <span>Ukuran file maksimal adalah 10 MB.</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12.5 9 17l11-11"/>
                    </svg>
                    <span>Diunggah selambat-lambatnya <span class="text-red-500 font-semibold">3 hari</span> sebelum masa magang berakhir.</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12.5 9 17l11-11"/>
                    </svg>
                    <span>Laporan merupakan syarat mutlak untuk penerbitan Sertifikat Magang.</span>
                </li>
            </ul>

            <hr class="my-5 border-slate-100">

            <a href="#" class="text-sm font-medium text-blue-600 hover:underline flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v11M8 11.5 12 15l4-3.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14"/>
                </svg>
                Download Template Laporan
            </a>

        </div>

    </div>

    {{-- Interaksi pilih file & drag-drop (baru tampilan, belum upload sungguhan) --}}
    <script>
        const dropZone   = document.getElementById('dropZone');
        const fileInput  = document.getElementById('fileInput');
        const pickFileBtn = document.getElementById('pickFileBtn');
        const dropHint   = document.getElementById('dropHint');

        pickFileBtn.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', () => {
            if (fileInput.files.length > 0) {
                dropHint.textContent = `File terpilih: ${fileInput.files[0].name}`;
            }
        });

        ['dragover', 'dragleave', 'drop'].forEach((eventName) => {
            dropZone.addEventListener(eventName, (e) => e.preventDefault());
        });

        dropZone.addEventListener('dragover', () => {
            dropZone.classList.add('border-blue-400', 'bg-blue-50/40');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50/40');
        });

        dropZone.addEventListener('drop', (e) => {
            dropZone.classList.remove('border-blue-400', 'bg-blue-50/40');
            if (e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                dropHint.textContent = `File terpilih: ${e.dataTransfer.files[0].name}`;
            }
        });
    </script>

@endsection