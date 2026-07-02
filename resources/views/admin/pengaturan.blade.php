@extends('layouts.admin')

@php($hideTopbar = true)

@section('title', 'Pengaturan Sistem')

@section('content')

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-blue-700">Pengaturan Sistem</h1>
        <p class="text-slate-500 mt-1">Kelola akun admin dan mentor dalam satu panel kontrol terpadu.</p>
    </div>

    @if (session('success'))
        <div class="mb-5 bg-green-50 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 bg-red-50 text-red-700 text-sm rounded-xl px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-5">

        {{-- ================= KIRI: STAT CARDS + TABEL ================= --}}
        <div class="flex-1 min-w-0">

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">ADMIN AKTIF</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['admin_aktif'] }}</p>
                        <p class="text-xs text-blue-500 mt-0.5">Sistem Terkelola</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14c-4.5 0-7 2-7 4v.5h14V18c0-2-2.5-4-7-4Z"/>
                        </svg>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">MENTOR AKTIF</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['mentor_aktif'] }}</p>
                        <p class="text-xs text-blue-500 mt-0.5">Bimbingan Aktif</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="9" cy="8" r="3"/>
                            <circle cx="16" cy="8" r="3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 19c0-3 2.5-5 7-5M13 19c0-3 2.5-5 7-5"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tabel Daftar Akun --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100">
                    <h2 class="font-semibold text-slate-700">Daftar Akun Pengguna</h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-4 py-3 text-left">Email</th>
                                <th class="px-4 py-3 text-left">Role</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($akun as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">{{ $item['nama'] }}</td>
                                <td class="px-4 py-4 text-slate-500">{{ $item['email'] }}</td>
                                <td class="px-4 py-4">
                                    @if ($item['role'] === 'Admin')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Admin</span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">Mentor</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @if ($item['status'] === 'Aktif')
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                    @else
                                        <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <button type="button"
                                        onclick="bukaModalEdit({{ $item['id'] }}, '{{ addslashes($item['nama']) }}', '{{ $item['email'] }}', '{{ $item['role'] }}', '{{ $item['status'] }}')"
                                        class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-50 hover:text-blue-600 flex items-center justify-center text-slate-500 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487a2.1 2.1 0 1 1 2.97 2.97L7.5 19.79l-4 1 1-4 12.362-12.303Z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada akun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
                    <div class="flex items-center gap-1">
                        <a href="?page={{ max(1, $pagination['current'] - 1) }}"
                           class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        @foreach ($pagination['pages'] as $page)
                            <a href="?page={{ $page }}" class="w-8 h-8 rounded-lg text-sm font-medium flex items-center justify-center transition
                                {{ $page == $pagination['current'] ? 'bg-blue-600 text-white' : 'border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                        <a href="?page={{ min(count($pagination['pages']), $pagination['current'] + 1) }}"
                           class="w-8 h-8 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= KANAN: FORM TAMBAH AKUN ================= --}}
        <div class="w-full lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="8" r="3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14c-4.5 0-7 2-7 4v.5h14V18c0-2-2.5-4-7-4Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 6v4M16 8h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-800 text-sm">Tambah Akun</p>
                        <p class="text-xs text-slate-400">Buat kredensial admin atau mentor baru.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.pengaturan.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap..."
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@pln.co.id"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                    </div>
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <input type="password" name="password" placeholder="••••••••"
                                   class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        </div>
                        <div class="w-28">
                            <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                            <select name="role"
                                    class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Mentor" {{ old('role') === 'Mentor' ? 'selected' : '' }}>Mentor</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                    </div>
                    <button type="submit"
                            class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition mt-1">
                        Simpan Akun Baru
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- ===== MODAL EDIT AKUN ===== --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800">Edit Akun</h3>
                <button onclick="tutupModalEdit()" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form id="form-edit" method="POST" action="" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="edit-nama" name="nama"
                           class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" id="edit-email" name="email"
                           class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>
                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                        <select id="edit-role" name="role"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <option value="Admin">Admin</option>
                            <option value="Mentor">Mentor</option>
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select id="edit-status" name="status"
                                class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password Baru <span class="text-slate-400 font-normal">(kosongkan jika tidak ingin mengubah)</span></label>
                    <input type="password" name="password" placeholder="••••••••"
                           class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                           class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" onclick="tutupModalEdit()"
                            class="flex-1 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition">
                        Simpan
                    </button>
                </div>
            </form>

            {{-- Tombol Hapus — form terpisah --}}
            <form id="form-hapus" method="POST" action="" class="px-6 pb-6">
                @csrf
                @method('DELETE')
                <p id="pesan-hapus-sendiri" class="hidden text-xs text-red-500 text-center mb-2">
                    Tidak bisa menghapus akun yang sedang digunakan.
                </p>
                <button type="button" id="btn-hapus"
                        onclick="konfirmasiHapus()"
                        class="w-full py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold rounded-xl transition">
                    Hapus Akun Ini
                </button>
            </form>
        </div>
    </div>

    {{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
    <div id="modal-hapus" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/50 px-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-sm shadow-2xl">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0Z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-slate-800">Hapus Akun</h3>
            </div>
            <p class="text-sm text-slate-600 mb-1">Apakah Anda yakin ingin menghapus akun:</p>
            <p class="text-sm font-bold text-slate-800 mb-2" id="modal-hapus-nama"></p>
            <p class="text-sm text-red-500 font-medium mb-6">Tindakan ini tidak bisa dibatalkan dan akun akan terhapus permanen.</p>
            <div class="flex gap-3">
                <button type="button"
                        onclick="document.getElementById('modal-hapus').classList.add('hidden')"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">
                    Batal
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-hapus').classList.add('hidden'); document.getElementById('form-hapus').submit();"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

    <script>
        function bukaModalEdit(id, nama, email, role, status) {
            document.getElementById('edit-nama').value   = nama;
            document.getElementById('edit-email').value  = email;
            document.getElementById('edit-role').value   = role;
            document.getElementById('edit-status').value = status;
            document.getElementById('form-edit').action  = '/admin/pengaturan/' + id;
            document.getElementById('form-hapus').action = '/admin/pengaturan/' + id;

            // Cek apakah akun yang diedit adalah akun sendiri
            const akunSendiri = (id == {{ auth()->id() }});
            const btnHapus = document.getElementById('btn-hapus');
            const pesanSendiri = document.getElementById('pesan-hapus-sendiri');
            btnHapus.disabled = akunSendiri;
            btnHapus.classList.toggle('opacity-50', akunSendiri);
            btnHapus.classList.toggle('cursor-not-allowed', akunSendiri);
            pesanSendiri.classList.toggle('hidden', !akunSendiri);

            document.getElementById('modal-edit').classList.remove('hidden');
        }

        function konfirmasiHapus() {
            document.getElementById('modal-hapus-nama').textContent = document.getElementById('edit-nama').value;
            document.getElementById('modal-hapus').classList.remove('hidden');
        }

        function tutupModalEdit() {
            document.getElementById('modal-edit').classList.add('hidden');
        }

        document.getElementById('modal-edit').addEventListener('click', function(e) {
            if (e.target === this) tutupModalEdit();
        });

        document.getElementById('modal-hapus').addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    </script>

@endsection