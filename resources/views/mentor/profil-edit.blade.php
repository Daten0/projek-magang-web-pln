@extends('layouts.mentor')

@php($hideSearch = true)

@section('title', 'Edit Profil')

@section('content')

    {{-- Breadcrumb --}}
    <div class="text-sm text-slate-400 mb-2">
        <a href="{{ route('mentor.dashboard') }}" class="hover:text-blue-600">Beranda</a>
        <span class="mx-1.5">/</span>
        <a href="{{ route('mentor.profil') }}" class="hover:text-blue-600">Profil Mentor</a>
        <span class="mx-1.5">/</span>
        <span class="text-blue-600 font-medium">Edit Profil</span>
    </div>

    <h1 class="text-2xl font-bold text-slate-800 mb-6">Pengaturan Akun</h1>

    @if (session('success'))
        <div class="mb-6 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('mentor.profil.edit.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ================= KOLOM KIRI: FOTO ================= --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm h-fit text-center">

                <div class="relative w-28 h-28 mx-auto mb-4">
                    {{--
                        Placeholder avatar (huruf depan nama). Ganti dengan foto asli, misalnya:
                        <img src="{{ asset('images/mentor-budi.jpg') }}" class="w-28 h-28 rounded-full object-cover" alt="{{ $user['name'] }}">
                    --}}
                    <div class="w-28 h-28 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-3xl">
                        {{ strtoupper(substr($user['name'], 0, 1)) }}
                    </div>
                    <label for="foto" class="absolute bottom-0 right-0 w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-700 flex items-center justify-center text-white cursor-pointer transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 8a2 2 0 0 1 2-2h1.5l1-1.5h7l1 1.5H18a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8Z"/>
                            <circle cx="12" cy="12.5" r="3.2"/>
                        </svg>
                    </label>
                    <input type="file" id="foto" name="foto" accept=".jpg,.jpeg,.png,.gif" class="hidden">
                </div>

                <p class="font-bold text-slate-800">{{ $user['name'] }}</p>
                <p class="text-xs text-slate-400 mt-0.5">NIP: {{ $infoPerusahaan['nip'] }}</p>

                <label for="foto" class="block mt-4 bg-blue-50 hover:bg-blue-100 text-blue-600 text-sm font-semibold py-2.5 rounded-xl cursor-pointer transition">
                    Unggah Foto Baru
                </label>
                <button type="button" id="hapusFotoBtn" class="block w-full mt-2 text-red-500 hover:text-red-600 text-sm font-semibold py-1">
                    Hapus Foto
                </button>

                <p class="text-xs text-slate-400 mt-3 leading-relaxed">Format JPG, PNG atau GIF. Maksimal 2MB.</p>
            </div>

            {{-- ================= KOLOM KANAN ================= --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Informasi Pribadi --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-5">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                        </svg>
                        <h2 class="font-bold text-slate-800">Informasi Pribadi</h2>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="nama_lengkap" class="block text-xs font-medium text-slate-500 mb-1.5">Nama Lengkap</label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $dataPribadi['nama_lengkap'] }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="email" class="block text-xs font-medium text-slate-500 mb-1.5">Alamat Email</label>
                                <input type="email" id="email" name="email" value="{{ $dataPribadi['email'] }}"
                                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            </div>
                            <div>
                                <label for="nomor_telepon" class="block text-xs font-medium text-slate-500 mb-1.5">Nomor Telepon</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 text-sm">+62</span>
                                    <input type="text" id="nomor_telepon" name="nomor_telepon" value="{{ $dataPribadi['nomor_telepon'] }}"
                                           class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Perusahaan (read-only) --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="4" y="4" width="16" height="17" rx="2"/>
                                <path stroke-linecap="round" d="M8 9h2M8 13h2M8 17h2M14 9h2M14 13h2"/>
                            </svg>
                            <h2 class="font-bold text-slate-800">Informasi Perusahaan</h2>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full tracking-wide">READ-ONLY</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-5">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">NIP / ID Pegawai</label>
                            <input type="text" value="{{ $infoPerusahaan['nip'] }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">Jabatan</label>
                            <input type="text" value="{{ $infoPerusahaan['jabatan'] }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">Unit Kerja</label>
                            <input type="text" value="{{ $infoPerusahaan['unit_kerja'] }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1.5">Divisi</label>
                            <input type="text" value="{{ $infoPerusahaan['divisi'] }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-5 text-xs text-blue-700 bg-blue-50 rounded-xl px-4 py-3">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="9"/>
                            <path stroke-linecap="round" d="M12 8h.01"/>
                            <path stroke-linecap="round" d="M12 11v5"/>
                        </svg>
                        Hubungi HR Admin jika terdapat kesalahan pada data korporat Anda.
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('mentor.profil') }}" class="border border-slate-200 text-slate-600 text-sm font-semibold px-6 py-2.5 rounded-xl hover:bg-slate-50 transition">
                        Batalkan
                    </a>
                    <button type="submit" class="bg-[#0B1437] hover:bg-blue-900 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">
                        Simpan Perubahan
                    </button>
                </div>

            </div>

        </div>
    </form>

    {{-- Tampilkan nama file saat foto baru dipilih, plus tombol "Hapus Foto" (baru sisi tampilan) --}}
    <script>
        document.getElementById('foto').addEventListener('change', function () {
            if (this.files.length > 0) {
                alert('Foto terpilih: ' + this.files[0].name + ' (akan terunggah saat Anda klik "Simpan Perubahan")');
            }
        });

        document.getElementById('hapusFotoBtn').addEventListener('click', function () {
            document.getElementById('foto').value = '';
            alert('Foto akan dihapus saat Anda klik "Simpan Perubahan" (placeholder, belum benar-benar terhapus).');
        });
    </script>

@endsection