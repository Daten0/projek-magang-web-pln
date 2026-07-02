<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Magang PLN UP2D</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        /* ===== Page transition (slide in/out) ===== */
        body {
            animation: pageSlideIn 0.45s cubic-bezier(0.22, 1, 0.36, 1);
        }
        body.page-leaving {
            animation: pageSlideOut 0.35s cubic-bezier(0.55, 0, 1, 0.45) forwards;
        }
        @keyframes pageSlideIn {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes pageSlideOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(-40px); }
        }

        /* Wrapper utama */
        #auth-wrapper {
            display: flex;
            width: 200%;
            transition: transform 0.6s cubic-bezier(0.77, 0, 0.18, 1);
        }

        /* Mode login: posisi normal */
        #auth-wrapper.mode-login  { transform: translateX(0); }

        /* Mode register: geser ke kiri 50% (= lebar 1 panel) */
        #auth-wrapper.mode-register { transform: translateX(-50%); }

        /* Tiap panel = 50% dari wrapper (= 100vw) */
        .auth-panel {
            width: 50%;
            flex-shrink: 0;
        }

        /* Animasi fade konten form */
        .form-content {
            transition: opacity 0.25s ease;
        }
        .form-content.fading {
            opacity: 0;
        }
    </style>
</head>
<body class="relative min-h-screen overflow-y-auto bg-gradient-to-br from-[#0B1437] via-[#071029] to-[#020611]">

    {{-- Efek cahaya biru di kiri atas --}}
    <div class="absolute -top-32 -left-32 w-[550px] h-[550px] bg-blue-600/30 rounded-full blur-3xl pointer-events-none"></div>

    {{-- Viewport: overflow hidden supaya panel kedua tidak kelihatan --}}
    <div class="relative z-10 min-h-screen overflow-hidden">

        <div id="auth-wrapper" class="mode-login min-h-screen">

            {{-- ===================== PANEL 1: LOGIN ===================== --}}
            <div class="auth-panel min-h-screen flex items-center justify-center px-6 py-12">
                <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center gap-10">

                    {{-- Kiri: branding --}}
                    <div class="w-full max-w-md text-white">
                        <div class="w-14 h-16 rounded-xl overflow-hidden shadow-lg">
                            <img src="{{ asset('gambar/pln-login2.png') }}"
                                alt="PLN Logo"
                                class="w-full h-full object-cover">
                        </div>
                        <h1 class="mt-8 text-3xl lg:text-4xl font-extrabold leading-tight">
                            <span class="text-amber-400">SISTEM MANAJEMEN</span><br>
                            <span class="text-white">MAGANG PLN UP2D</span>
                        </h1>
                        <p class="mt-4 text-slate-300 text-sm leading-relaxed">
                            Berkomitmen memberikan pelayanan yang andal, amanah, dan kolaboratif demi kenyamanan Anda.
                        </p>
                       <div class="mt-8 w-full relative">
                    <img src="{{ asset('gambar/pln-login.png') }}"
                        alt="PLN UP2D"
                        class="w-full object-cover object-center"
                        style="mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%),
                                            linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 15%, rgba(0,0,0,1) 85%, rgba(0,0,0,0) 100%);
                                -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 40%, rgba(0,0,0,0) 100%),
                                                    linear-gradient(to right, rgba(0,0,0,0) 0%, rgba(0,0,0,1) 15%, rgba(0,0,0,1) 85%, rgba(0,0,0,0) 100%);
                                mask-composite: intersect;
                                -webkit-mask-composite: source-in;">
                </div>
                    </div>

                    {{-- Kanan: form login --}}
                    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
                        <div class="form-content" id="login-content">
                            <h2 class="text-2xl font-bold text-slate-800">Silahkan Login</h2>
                            <p class="text-slate-500 text-sm mt-1">Silahkan masuk ke akun anda untuk melanjutkan.</p>

                            @if ($errors->any())
                                <div class="mt-5 bg-red-50 text-red-600 text-sm rounded-lg px-4 py-3">
                                    {{ $errors->first() }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-5">
                                @csrf
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <circle cx="12" cy="8" r="3.2"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 19c0-3.3 3.13-5.5 7-5.5s7 2.2 7 5.5"/>
                                            </svg>
                                        </span>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                               placeholder="Silahkan masukkan email"
                                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                                            </svg>
                                        </span>
                                        <input type="password" id="login-pass" name="password"
                                               placeholder="Masukkan password"
                                               class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white">
                                        <button type="button" onclick="togglePass('login-pass')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                                <circle cx="12" cy="12" r="3"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="w-full bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm py-3 rounded-xl flex items-center justify-center gap-2 transition">
                                    Masuk
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                    </svg>
                                </button>
                            </form>

                            <p class="text-center text-sm text-slate-500 mt-5">
                                Belum memiliki akun?
                                <button onclick="goToRegister()" class="text-blue-600 font-medium hover:underline">Daftar Sekarang</button>
                            </p>
                            <div class="flex items-center justify-between mt-4 text-sm">
                                <a href="#" class="text-slate-500 hover:text-blue-600">Lupa password?</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>{{-- end auth-wrapper --}}
    </div>

    <script>
        function navigateWithTransition(url) {
            document.body.classList.add('page-leaving');
            setTimeout(function () {
                window.location.href = url;
            }, 320);
        }

        function goToRegister() {
            navigateWithTransition('/register');
        }

        function goToLogin() {
            document.getElementById('auth-wrapper').classList.replace('mode-register', 'mode-login');
        }

        function togglePass(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>