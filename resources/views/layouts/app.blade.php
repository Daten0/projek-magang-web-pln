<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sistem Manajemen Magang PLN UP2D</title>

    {{--
        Tailwind lewat CDN supaya bisa langsung jalan tanpa npm/vite.
        Kalau project Anda sudah pakai Laravel Breeze/Vite + Tailwind,
        hapus baris <script> ini dan ganti dengan @vite([...]) punya Anda.
    --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="flex min-h-screen">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="w-64 bg-[#0B1437] text-slate-300 flex flex-col fixed inset-y-0 left-0 z-20">

            <div class="px-6 py-8">
                <h1 class="text-white font-bold text-lg leading-snug">
                    Sistem Manajemen<br>Magang PLN UP2D
                </h1>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">

                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="8" height="8" rx="2"/>
                        <rect x="13" y="3" width="8" height="8" rx="2"/>
                        <rect x="3" y="13" width="8" height="8" rx="2"/>
                        <rect x="13" y="13" width="8" height="8" rx="2"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Logbook --}}
                <a href="{{ route('logbook.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('logbook.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v18H6.5A2.5 2.5 0 0 1 4 18.5v-13Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v18h5.5a2.5 2.5 0 0 0 2.5-2.5v-13Z"/>
                    </svg>
                    Logbook
                </a>

                {{-- Absensi --}}
                <a href="{{ route('absensi.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('absensi.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="5" y="4" width="14" height="17" rx="2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3.5h6v2H9v-2Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13 2 2 4-4.5"/>
                    </svg>
                    Absensi
                </a>

                {{-- Laporan Akhir --}}
                <a href="{{ route('laporan-akhir.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('laporan-akhir.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 15.5h6M9 8.5h3"/>
                    </svg>
                    Laporan Akhir
                </a>

                {{-- Sertifikat --}}
                <a href="{{ route('sertifikat.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('sertifikat.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="9" r="5.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5-1.5 7 5-2.5 5 2.5-1.5-7"/>
                    </svg>
                    Sertifikat
                </a>

                {{-- Profil Peserta --}}
                <a href="{{ route('profil.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('profil.*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                    Profil Peserta
                </a>

            </nav>

            {{-- Keluar / Logout --}}
            <div class="px-4 py-6 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 4H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h3"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 16l4-4-4-4"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H9"/>
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>

        </aside>

        {{-- ================= MAIN CONTENT ================= --}}
        <main class="flex-1 ml-64 flex flex-col min-h-screen">

            {{-- Topbar: gunakan $hideTopbar = true untuk sembunyi, $hideSearch = true untuk tanpa search --}}
            @unless ($hideTopbar ?? false)
                <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">

                    {{-- Kiri: judul halaman ATAU search --}}
                    @if ($topbarTitle ?? false)
                        <h2 class="text-base font-bold text-slate-800">{{ $topbarTitle }}</h2>
                    @elseif (!($hideSearch ?? false))
                        <div class="relative w-full max-w-md">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="11" cy="11" r="6.5"/>
                                    <path stroke-linecap="round" d="m20 20-3.5-3.5"/>
                                </svg>
                            </span>
                            <input type="text" placeholder="Cari..."
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                        </div>
                    @else
                        <div></div>
                    @endif

                    <div class="flex items-center gap-4 flex-shrink-0">
                        <button type="button" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 17h12a1 1 0 0 0 .8-1.6L18 14V10a6 6 0 0 0-12 0v4l-.8 1.4A1 1 0 0 0 6 17Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19a2 2 0 0 0 4 0"/>
                            </svg>
                        </button>
                        <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name }}</span>
                        @php $fotoPeserta = Auth::user()->profilPeserta?->foto ?? null; @endphp
                        @if ($fotoPeserta)
                            <img src="{{ asset('storage/' . $fotoPeserta) }}"
                                class="w-9 h-9 rounded-full object-cover flex-shrink-0"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                </header>
            @endunless

            <div class="flex-1 p-8">
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>