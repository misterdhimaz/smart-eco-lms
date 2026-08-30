<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar | SMART-ECO LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        @keyframes float { 0%, 100% { transform: translateY(0px); opacity: 0.5; } 50% { transform: translateY(-20px); opacity: 0.8; } }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .del-1 { animation-delay: 1s; animation-duration: 7s; }
        .del-2 { animation-delay: 2s; animation-duration: 8s; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-[100dvh] flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Efek Background -->
    <div class="absolute top-[-10%] left-[-10%] w-72 h-72 md:w-96 md:h-96 bg-cyan-400/30 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-72 h-72 md:w-96 md:h-96 bg-emerald-400/30 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="absolute top-1/4 left-10 w-4 h-4 bg-cyan-400 rounded-full blur-sm animate-float del-1 pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/2 w-5 h-5 bg-cyan-300 rounded-full blur-sm animate-float del-2 pointer-events-none"></div>

    <!-- Container Utama -->
    <div class="w-full max-w-5xl bg-white/90 rounded-3xl md:rounded-[2.5rem] shadow-2xl flex flex-col lg:flex-row relative z-10 border border-white/50 backdrop-blur-md overflow-hidden max-h-[90dvh]">

        <!-- Sisi Kiri (Gambar & Info - Sembunyi di HP) -->
        <div class="hidden lg:flex lg:w-5/12 relative bg-[#050B14] flex-col justify-center items-center p-12 shrink-0">
            <div class="absolute w-80 h-80 bg-emerald-500/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col items-center text-center">
                <img src="{{ asset('images/earth.png') }}" alt="Logo" class="w-56 h-auto rounded-[2.5rem] shadow-2xl mb-8 hover:scale-105 transition-transform duration-500">
                <h2 class="text-3xl font-black text-white tracking-tight mb-4 leading-tight">Mulai Perjalanan<br>Edukasi Anda.</h2>
                <p class="text-slate-400 font-medium text-sm max-w-sm leading-relaxed">
                    Buat akun <span class="text-cyan-400 font-bold">SMART-ECO</span>. Dapatkan akses ke ruang kelas dan bantu ciptakan masa depan hijau.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan (Formulir Pendaftaran) -->
        <div class="w-full lg:w-7/12 flex flex-col justify-start p-6 sm:p-10 lg:p-12 bg-white overflow-y-auto custom-scrollbar">
            <div class="w-full max-w-lg mx-auto py-4">

                <div class="mb-6 text-center lg:text-left">
                    <div class="inline-flex lg:hidden items-center justify-center w-14 h-14 rounded-2xl bg-[#050B14] mb-4 overflow-hidden">
                        <img src="{{ asset('images/earth.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Buat Akun Baru 🚀</h1>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 mt-2">Lengkapi data untuk bergabung ke kelas.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-bold space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                    @csrf

                    <!-- Kode Kelas (Full Width) -->
                    <div>
                        <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1 text-emerald-600">Kode Kelas (Wajib)</label>
                        <input type="text" name="kode_kelas" value="{{ old('kode_kelas') }}" required placeholder="Contoh: X7F9Q"
                               class="w-full px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-emerald-500 transition-all uppercase placeholder:normal-case">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Budi Santoso"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-cyan-500 transition-all">
                        </div>
                        <!-- Nama Panggilan -->
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Panggilan</label>
                            <input type="text" name="nama_panggilan" value="{{ old('nama_panggilan') }}" required placeholder="Budi"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-cyan-500 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Email -->
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Email Aktif</label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-cyan-500 transition-all">
                        </div>
                        <!-- Jenis Kelamin -->
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Gender</label>
                            <select name="jenis_kelamin" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-cyan-500 transition-all cursor-pointer">
    <option value="">Pilih Gender</option>
    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
</select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password -->
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Sandi</label>
                            <div x-data="{ showPass1: false }" class="relative">
                                <input :type="showPass1 ? 'text' : 'password'" name="password" required placeholder="••••••••"
                                       class="w-full px-4 py-3 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-cyan-500 transition-all">
                                <button type="button" @click="showPass1 = !showPass1" tabindex="-1" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-cyan-600 outline-none">
                                    <svg x-show="!showPass1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPass1" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 015.82-1.618c4.477 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1 truncate">Ulangi Sandi</label>
                            <div x-data="{ showPass2: false }" class="relative">
                                <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" required placeholder="••••••••"
                                       class="w-full px-4 py-3 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-cyan-500 transition-all">
                                <button type="button" @click="showPass2 = !showPass2" tabindex="-1" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-cyan-600 outline-none">
                                    <svg x-show="!showPass2" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    <svg x-show="showPass2" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 015.82-1.618c4.477 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl shadow-lg shadow-cyan-500/30 text-xs font-black uppercase tracking-widest text-white bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 transition-all mt-6 active:scale-95">
                        Daftar & Terima OTP
                    </button>
                </form>

                <div class="mt-6 text-center text-xs font-bold text-slate-500">
                    Sudah memiliki akun? <a href="{{ route('login') }}" class="text-cyan-600 hover:text-cyan-700 hover:underline transition-colors">Masuk di sini</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
