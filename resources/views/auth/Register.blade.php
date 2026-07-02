<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Sistem Manajemen Magang PLN UP2D</title>
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

        /* Step indicator connector */
        .step-connector {
            flex: 1;
            height: 2px;
            background: #e2e8f0;
            margin: 0 4px;
            margin-top: -22px;
            transition: background 0.4s ease;
        }
        .step-connector.active { background: #0B1437; }

        /* Step circle */
        .step-circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            border: 2px solid #e2e8f0;
            background: #fff;
            color: #94a3b8;
            transition: all 0.4s ease;
            flex-shrink: 0;
        }
        .step-circle.active {
            border-color: #0B1437;
            background: #0B1437;
            color: #fff;
        }
        .step-circle.done {
            border-color: #10b981;
            background: #10b981;
            color: #fff;
        }

        /* Step panel transition */
        .step-panel {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        .step-panel.active { display: block; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Input focus */
        .input-field {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-size: 0.875rem;
            color: #334155;
            outline: none;
            transition: all 0.2s;
        }
        .input-field::placeholder { color: #94a3b8; }
        .input-field:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }
        .input-field-no-icon {
            width: 100%;
            padding: 0.625rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-size: 0.875rem;
            color: #334155;
            outline: none;
            transition: all 0.2s;
        }
        .input-field-no-icon::placeholder { color: #94a3b8; }
        .input-field-no-icon:focus {
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
        }
        select.input-field-no-icon {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 2.5rem;
        }

        /* Status badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 500;
        }
    </style>
</head>
<body class="relative min-h-screen overflow-y-auto bg-gradient-to-br from-[#0B1437] via-[#071029] to-[#020611]">

    {{-- Viewport: overflow hidden supaya panel kedua tidak kelihatan --}}
<div class="relative z-10 min-h-screen overflow-hidden">

    {{-- Efek cahaya biru kiri atas --}}
    <div class="absolute -top-32 -left-32 w-[550px] h-[550px] bg-blue-600/30 rounded-full blur-3xl pointer-events-none"></div>
    {{-- Efek cahaya amber kanan bawah --}}
    <div class="absolute -bottom-40 -right-40 w-[400px] h-[400px] bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 min-h-screen flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-5xl flex flex-col lg:flex-row items-center gap-10">

            {{-- ===== KIRI: BRANDING ===== --}}
            <div class="w-full max-w-md text-white flex-shrink-0">
                {{-- Logo --}}
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

                {{-- Panduan langkah --}}
                <div class="mt-8 space-y-3">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest">Panduan Pendaftaran</p>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-400/20 border border-amber-400/40 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-amber-400 text-xs font-bold">1</span>
                        </div>
                        <p class="text-slate-300 text-sm">Isi data akun (email & password)</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-400/20 border border-amber-400/40 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-amber-400 text-xs font-bold">2</span>
                        </div>
                        <p class="text-slate-300 text-sm">Lengkapi data diri dan asal instansi</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-amber-400/20 border border-amber-400/40 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-amber-400 text-xs font-bold">3</span>
                        </div>
                        <p class="text-slate-300 text-sm">Isi rencana periode magang yang diinginkan</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-slate-500/30 border border-slate-500/40 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-slate-400 text-xs font-bold">4</span>
                        </div>
                        <p class="text-slate-400 text-sm">Menunggu persetujuan dari admin</p>
                    </div>
                </div>
            </div>

            {{-- ===== KANAN: FORM CARD ===== --}}
            <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-1">
                    <h2 class="text-2xl font-bold text-slate-800">Daftar Akun</h2>
                    <span class="text-xs text-slate-400 font-medium" id="step-label">Langkah 1 dari 3</span>
                </div>
                <p class="text-slate-500 text-sm mb-6">Lengkapi semua data untuk mendaftar magang.</p>

                {{-- Step Indicator --}}
                <div class="flex items-start mb-7">
                    {{-- Step 1 --}}
                    <div class="flex flex-col items-center">
                        <div class="step-circle active" id="sc-1">1</div>
                        <span class="text-xs text-slate-500 mt-1.5 font-medium" id="sl-1">Akun</span>
                    </div>
                    <div class="step-connector mt-[18px]" id="conn-1"></div>
                    {{-- Step 2 --}}
                    <div class="flex flex-col items-center">
                        <div class="step-circle" id="sc-2">2</div>
                        <span class="text-xs text-slate-400 mt-1.5" id="sl-2">Data Diri</span>
                    </div>
                    <div class="step-connector mt-[18px]" id="conn-2"></div>
                    {{-- Step 3 --}}
                    <div class="flex flex-col items-center">
                        <div class="step-circle" id="sc-3">3</div>
                        <span class="text-xs text-slate-400 mt-1.5" id="sl-3">Magang</span>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="mb-5 bg-red-50 text-red-600 text-sm rounded-lg px-4 py-3">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-5 bg-green-50 text-green-700 text-sm rounded-lg px-4 py-3 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

               <form method="POST" action="{{ route('register.store') }}" id="register-form" onkeydown="return event.key !== 'Enter'">
                    @csrf

                    {{-- ===== STEP 1: DATA AKUN ===== --}}
                    <div class="step-panel active" id="panel-1">
                        <div class="space-y-5">
                            {{-- Nama Lengkap --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <circle cx="12" cy="8" r="3.2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 19c0-3.3 3.13-5.5 7-5.5s7 2.2 7 5.5"/>
                                        </svg>
                                    </span>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           placeholder="Masukkan nama lengkap"
                                           class="input-field">
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9 6 9-6"/>
                                        </svg>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           placeholder="contoh@email.com"
                                           class="input-field">
                                </div>
                            </div>

                            {{-- Nomor Telepon --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.6 10.8c1.4 2.8 3.8 5.1 6.6 6.6l2.2-2.2c.3-.3.7-.4 1-.2 1.1.4 2.3.6 3.6.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1-9.4 0-17-7.6-17-17 0-.6.4-1 1-1h3.5c.6 0 1 .4 1 1 0 1.3.2 2.5.6 3.6.1.3 0 .7-.2 1L6.6 10.8z"/>
                                        </svg>
                                    </span>
                                    <input type="tel" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                                           placeholder="08xx-xxxx-xxxx"
                                           class="input-field">
                                </div>
                            </div>

                            {{-- Password --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                                        </svg>
                                    </span>
                                    <input type="password" id="reg-pass" name="password"
                                           placeholder="Minimal 8 karakter"
                                           class="input-field" style="padding-right:2.75rem">
                                    <button type="button" onclick="togglePass('reg-pass')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Ulangi Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <rect x="5" y="10.5" width="14" height="9" rx="2"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10.5V8a4 4 0 0 1 8 0v2.5"/>
                                        </svg>
                                    </span>
                                    <input type="password" id="reg-pass-confirm" name="password_confirmation"
                                           placeholder="Ulangi password"
                                           class="input-field" style="padding-right:2.75rem">
                                    <button type="button" onclick="togglePass('reg-pass-confirm')"
                                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12S6 5 12 5s9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z"/>
                                            <circle cx="12" cy="12" r="3"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="nextStep(2)"
                                class="mt-6 w-full bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm py-3 rounded-xl flex items-center justify-center gap-2 transition">
                            Lanjut
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </button>
                    </div>

                    {{-- ===== STEP 2: DATA DIRI ===== --}}
                    <div class="step-panel" id="panel-2">
                        <div class="space-y-5">
                            {{-- Jenis Pendaftar --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Pendaftar</label>
                                <select name="jenis_pendaftar" class="input-field-no-icon" id="jenis-pendaftar" onchange="toggleJenis()">
                                    <option value="" disabled selected>Pilih jenis pendaftar</option>
                                    <option value="mahasiswa" {{ old('jenis_pendaftar') === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                    <option value="siswa" {{ old('jenis_pendaftar') === 'siswa' ? 'selected' : '' }}>Siswa SMK/SMA</option>
                                </select>
                            </div>

                            {{-- Instansi --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5" id="label-instansi">Universitas / Instansi</label>
                                <input type="text" name="instansi" value="{{ old('instansi') }}"
                                       placeholder="Nama universitas atau sekolah"
                                       id="input-instansi"
                                       class="input-field-no-icon">
                            </div>

                            {{-- Jurusan / Prodi --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5" id="label-jurusan">Program Studi / Jurusan</label>
                                <input type="text" name="jurusan" value="{{ old('jurusan') }}"
                                       placeholder="Contoh: Teknik Informatika"
                                       class="input-field-no-icon">
                            </div>

                            {{-- NIM / NIS --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5" id="label-nim">NIM / NIS</label>
                                <input type="text" name="nim" value="{{ old('nim') }}"
                                       placeholder="Nomor induk mahasiswa atau siswa"
                                       class="input-field-no-icon">
                            </div>

                            {{-- Alamat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2"
                                          placeholder="Jl. contoh No. 1, Kota, Provinsi"
                                          class="input-field-no-icon resize-none">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="button" onclick="prevStep(1)"
                                    class="flex items-center gap-1.5 px-4 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali
                            </button>
                            <button type="button" onclick="nextStep(3)"
                                    class="flex-1 bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm py-3 rounded-xl flex items-center justify-center gap-2 transition">
                                Lanjut
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- ===== STEP 3: DATA MAGANG ===== --}}
                    <div class="step-panel" id="panel-3">
                        <div class="space-y-5">
                            {{-- Jenis Magang --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jenis Magang</label>
                                <select name="jenis_magang" class="input-field-no-icon">
                                    <option value="" disabled selected>Pilih jenis magang</option>
                                    <option value="Praktik Industri" {{ old('jenis_magang') === 'Praktik Industri' ? 'selected' : '' }}>Praktik Industri</option>
                                    <option value="Kerja Praktek" {{ old('jenis_magang') === 'Kerja Praktek' ? 'selected' : '' }}>Kerja Praktek (KP)</option>
                                    <option value="Magang Kampus Merdeka" {{ old('jenis_magang') === 'Magang Kampus Merdeka' ? 'selected' : '' }}>Magang Kampus Merdeka</option>
                                    <option value="PKL" {{ old('jenis_magang') === 'PKL' ? 'selected' : '' }}>PKL (Praktek Kerja Lapangan)</option>
                                    <option value="KKN" {{ old('jenis_magang') === 'KKN' ? 'selected' : '' }}>KKN (Kuliah Kerja Nyata)</option>
                                    <option value="Magang Mandiri" {{ old('jenis_magang') === 'Magang Mandiri' ? 'selected' : '' }}>Magang Mandiri</option>
                                </select>
                            </div>

                            {{-- Tanggal Mulai --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Rencana Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                       class="input-field-no-icon">
                            </div>

                            {{-- Tanggal Selesai --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Rencana Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                       class="input-field-no-icon">
                            </div>

                            {{-- Bidang Minat --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Bidang / Divisi yang Diminati</label>
                                <select name="bidang_minat" class="input-field-no-icon">
                                    <option value="" disabled selected>Pilih bidang minat</option>
                                    <option value="Sistem Informasi" {{ old('bidang_minat') === 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                                    <option value="IT Development" {{ old('bidang_minat') === 'IT Development' ? 'selected' : '' }}>IT Development</option>
                                    <option value="SDM & Umum" {{ old('bidang_minat') === 'SDM & Umum' ? 'selected' : '' }}>SDM & Umum</option>
                                    <option value="Distribusi" {{ old('bidang_minat') === 'Distribusi' ? 'selected' : '' }}>Distribusi</option>
                                    <option value="Transmisi" {{ old('bidang_minat') === 'Transmisi' ? 'selected' : '' }}>Transmisi</option>
                                    <option value="Keuangan & Akuntansi" {{ old('bidang_minat') === 'Keuangan & Akuntansi' ? 'selected' : '' }}>Keuangan & Akuntansi</option>
                                    <option value="Legal & Compliance" {{ old('bidang_minat') === 'Legal & Compliance' ? 'selected' : '' }}>Legal & Compliance</option>
                                </select>
                            </div>

                            {{-- Info status --}}
                            <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex items-start gap-3">
                                <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
                                </svg>
                                <p class="text-amber-700 text-xs leading-relaxed">
                                    Setelah mendaftar, status pendaftaran Anda akan menjadi <strong>Menunggu Persetujuan</strong> hingga diverifikasi oleh admin.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="button" onclick="prevStep(2)"
                                    class="flex items-center gap-1.5 px-4 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-medium hover:bg-slate-50 transition">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Kembali
                            </button>
                            <button type="submit"
                                    class="flex-1 bg-[#0B1437] hover:bg-blue-900 text-white font-semibold text-sm py-3 rounded-xl flex items-center justify-center gap-2 transition">
                                Kirim Pendaftaran
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </form>

                {{-- Link ke login --}}
                <p class="text-center text-sm text-slate-500 mt-5">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" onclick="return navigateWithTransition(event, '{{ route('login') }}')" class="text-blue-600 font-medium hover:underline">Masuk di sini</a>
                </p>

            </div>
            {{-- end card --}}

        </div>
    </div>
</div>

    <script>
        function navigateWithTransition(event, url) {
            event.preventDefault();
            document.body.classList.add('page-leaving');
            setTimeout(function () {
                window.location.href = url;
            }, 320);
            return false;
        }

                    let currentStep = 1;

            // Arahkan ke step yang bermasalah saat ada error dari server
            @if ($errors->has('name') || $errors->has('email') || $errors->has('password') || $errors->has('nomor_telepon'))
                currentStep = 1;
            @elseif ($errors->has('jenis_pendaftar') || $errors->has('instansi') || $errors->has('jurusan') || $errors->has('nim'))
                currentStep = 2;
            @elseif ($errors->any())
                currentStep = 3;
            @endif

// Tampilkan panel yang benar saat halaman load
document.addEventListener('DOMContentLoaded', function() {
    if (currentStep > 1) showStep(currentStep);
});

        function nextStep(to) {
            if (!validateStep(currentStep)) return;
            showStep(to);
        }

        function prevStep(to) {
            showStep(to);
        }

        function showStep(to) {
            document.getElementById('panel-' + currentStep).classList.remove('active');
            currentStep = to;
            document.getElementById('panel-' + currentStep).classList.add('active');
            document.getElementById('step-label').textContent = 'Langkah ' + currentStep + ' dari 3';
            updateStepUI();
        }

        function updateStepUI() {
            for (let i = 1; i <= 3; i++) {
                const circle = document.getElementById('sc-' + i);
                const label  = document.getElementById('sl-' + i);
                circle.classList.remove('active', 'done');
                label.className = 'text-xs mt-1.5';

                if (i < currentStep) {
                    circle.classList.add('done');
                    circle.innerHTML = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
                    label.classList.add('text-emerald-600', 'font-medium');
                } else if (i === currentStep) {
                    circle.classList.add('active');
                    circle.innerHTML = i;
                    label.classList.add('text-slate-700', 'font-medium');
                } else {
                    circle.innerHTML = i;
                    label.classList.add('text-slate-400');
                }

                if (i < 3) {
                    const conn = document.getElementById('conn-' + i);
                    conn.classList.toggle('active', i < currentStep);
                }
            }
        }

        function validateStep(step) {
            if (step === 1) {
                const name  = document.querySelector('[name="name"]').value.trim();
                const email = document.querySelector('[name="email"]').value.trim();
                const phone = document.querySelector('[name="nomor_telepon"]').value.trim();
                const pass  = document.getElementById('reg-pass').value;
                const conf  = document.getElementById('reg-pass-confirm').value;

                if (!name)  { alert('Nama lengkap wajib diisi.'); return false; }
                if (!email) { alert('Email wajib diisi.'); return false; }
                if (!phone) { alert('Nomor telepon wajib diisi.'); return false; }
                if (pass.length < 8) { alert('Password minimal 8 karakter.'); return false; }
                if (pass !== conf)   { alert('Password dan konfirmasi tidak cocok.'); return false; }
            }
            if (step === 2) {
                const jenis    = document.getElementById('jenis-pendaftar').value;
                const instansi = document.querySelector('[name="instansi"]').value.trim();
                const jurusan  = document.querySelector('[name="jurusan"]').value.trim();
                const nim      = document.querySelector('[name="nim"]').value.trim();

                if (!jenis)    { alert('Pilih jenis pendaftar.'); return false; }
                if (!instansi) { alert('Instansi wajib diisi.'); return false; }
                if (!jurusan)  { alert('Jurusan / Prodi wajib diisi.'); return false; }
                if (!nim)      { alert('NIM / NIS wajib diisi.'); return false; }
            }
            return true;
        }

        function toggleJenis() {
            const val = document.getElementById('jenis-pendaftar').value;
            const lblInstansi = document.getElementById('label-instansi');
            const lblJurusan  = document.getElementById('label-jurusan');
            const lblNim      = document.getElementById('label-nim');
            const inputInstansi = document.getElementById('input-instansi');

            if (val === 'siswa') {
                lblInstansi.textContent = 'Nama Sekolah';
                lblJurusan.textContent  = 'Kompetensi Keahlian / Jurusan';
                lblNim.textContent      = 'NIS (Nomor Induk Siswa)';
                inputInstansi.placeholder = 'Nama SMK / SMA';
            } else {
                lblInstansi.textContent = 'Universitas / Instansi';
                lblJurusan.textContent  = 'Program Studi / Jurusan';
                lblNim.textContent      = 'NIM (Nomor Induk Mahasiswa)';
                inputInstansi.placeholder = 'Nama universitas atau sekolah';
            }
        }

        function togglePass(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>