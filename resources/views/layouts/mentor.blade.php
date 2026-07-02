<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Mentor') - Sistem Manajemen Magang PLN UP2D</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="flex min-h-screen">

        {{-- ================= SIDEBAR MENTOR ================= --}}
        <aside class="w-64 bg-[#0B1437] text-slate-300 flex flex-col fixed inset-y-0 left-0 z-20">

            <div class="px-6 py-8">
                <h1 class="text-white font-bold text-lg leading-snug">
                    Sistem Manajemen<br>Magang PLN UP2D
                </h1>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">

                {{-- Dashboard --}}
                <a href="{{ route('mentor.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('mentor.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="8" height="8" rx="2"/>
                        <rect x="13" y="3" width="8" height="8" rx="2"/>
                        <rect x="3" y="13" width="8" height="8" rx="2"/>
                        <rect x="13" y="13" width="8" height="8" rx="2"/>
                    </svg>
                    Dashboard
                </a>

                {{-- Anak Magang --}}
                <a href="{{ route('mentor.anak-magang') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('mentor.anak-magang*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="9" cy="8" r="3.2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 19c0-3.3 2.7-5.5 6-5.5s6 2.2 6 5.5"/>
                        <circle cx="17" cy="8.5" r="2.4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 13.3c2.5.4 4 2.2 4 5.2"/>
                    </svg>
                    Anak Magang
                </a>

                {{-- Verifikasi Logbook --}}
                <a href="{{ route('mentor.verifikasi-logbook') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('mentor.verifikasi-logbook*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l4 4v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 3v4h4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.5 13.5 2 2 4-4.5"/>
                    </svg>
                    Verifikasi Logbook
                </a>

               {{-- Verifikasi Laporan Akhir --}}
                <a href="{{ route('mentor.verifikasi-laporan-akhir') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('mentor.verifikasi-laporan-akhir*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <rect x="5" y="3" width="14" height="18" rx="2"/>
                        <path stroke-linecap="round" d="M5 21 19 3"/>
                    </svg>
                    Verifikasi Laporan Akhir
                </a>

                {{-- Penilaian Akhir --}}
                <a href="{{ route('mentor.penilaian-akhir') }}"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                        {{ request()->routeIs('mentor.penilaian-akhir*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.6 5.3 5.9.8-4.3 4.1 1 5.8L12 16.3l-5.2 2.7 1-5.8-4.3-4.1 5.9-.8L12 3Z"/>
                    </svg>
                    Penilaian Nilai Akhir
                </a>

                {{-- Profil Mentor --}}
                <a href="{{ route('mentor.profil') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition
                          {{ request()->routeIs('mentor.profil*') ? 'bg-blue-600 text-white' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="12" cy="8" r="3.5"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20c0-3.5 3.13-6 7-6s7 2.5 7 6"/>
                    </svg>
                    Profil Mentor
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

            @unless ($hideTopbar ?? false)
                <header class="bg-white border-b border-slate-100 px-8 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">

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
                        @php $mentorFoto = Auth::user()->profilMentor->foto ?? null; @endphp
                        @if ($mentorFoto)
                            <img src="{{ asset('storage/' . $mentorFoto) }}"
                                class="w-9 h-9 rounded-full object-cover"
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