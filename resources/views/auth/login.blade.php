<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login | SMART-ECO LMS</title>
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
        .del-3 { animation-delay: 3s; animation-duration: 9s; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-[100dvh] flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Efek Background -->
    <div class="absolute top-[-10%] left-[-10%] w-72 h-72 md:w-96 md:h-96 bg-emerald-400/20 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-72 h-72 md:w-96 md:h-96 bg-cyan-400/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="absolute top-1/4 left-10 w-4 h-4 bg-emerald-400 rounded-full blur-sm animate-float del-1 pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-1/2 w-5 h-5 bg-emerald-300 rounded-full blur-sm animate-float del-2 pointer-events-none"></div>
    <div class="absolute top-10 right-1/4 w-4 h-4 bg-cyan-400 rounded-full blur-sm animate-float del-1 pointer-events-none"></div>

    <!-- Container Utama -->
    <div class="w-full max-w-5xl bg-white/90 rounded-3xl md:rounded-[2.5rem] shadow-2xl flex flex-col lg:flex-row relative z-10 border border-white/50 backdrop-blur-md overflow-hidden max-h-[90dvh]">

        <!-- Sisi Kiri (Gambar & Info - Sembunyi di HP) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-[#050B14] flex-col justify-center items-center p-12 shrink-0">
            <div class="absolute w-80 h-80 bg-emerald-500/20 rounded-full blur-[100px] pointer-events-none"></div>
            <div class="relative z-10 flex flex-col items-center text-center">
                <img src="{{ asset('images/earth.png') }}" alt="Logo" class="w-64 h-auto rounded-[2.5rem] shadow-2xl shadow-emerald-900/30 mb-8 hover:scale-105 transition-transform duration-500">
                <h2 class="text-3xl font-black text-white tracking-tight mb-4 leading-tight">Masa Depan Bumi<br>Dimulai dari Ruang Kelas.</h2>
                <p class="text-slate-400 font-medium text-sm max-w-sm leading-relaxed">
                    Bergabunglah di platform <span class="text-emerald-400 font-bold">SMART-ECO</span>. Pelajari sains keberlanjutan untuk masa depan hijau.
                </p>
            </div>
        </div>

        <!-- Sisi Kanan (Formulir Login) -->
        <div class="w-full lg:w-1/2 flex flex-col justify-center p-6 sm:p-12 lg:p-16 bg-white overflow-y-auto custom-scrollbar">
            <div class="w-full max-w-sm mx-auto py-4">

                <div class="mb-8 text-center lg:text-left">
                    <div class="inline-flex lg:hidden items-center justify-center w-16 h-16 rounded-2xl bg-[#050B14] mb-4 overflow-hidden shadow-lg shadow-emerald-500/20">
                        <img src="{{ asset('images/earth.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Selamat Datang 👋</h1>
                    <p class="text-xs sm:text-sm font-medium text-slate-500 mt-2">Silakan masuk menggunakan akun Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-600 text-xs font-bold space-y-1">
                        @foreach ($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('success'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-600 text-xs font-bold">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Alamat Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="contoh@email.com"
                                   class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-emerald-500 transition-all">
                        </div>
                    </div>

                    <div x-data="{ showPass: false }">
                        <div class="flex items-center justify-between mb-1.5 pl-1">
                            <label for="password" class="block text-[11px] font-black text-slate-500 uppercase tracking-widest">Kata Sandi</label>
                            <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700">Lupa sandi?</a>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <input id="password" :type="showPass ? 'text' : 'password'" name="password" required placeholder="••••••••"
                                   class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-emerald-500 transition-all">
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 outline-none">
                                <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="showPass" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a9.953 9.953 0 015.82-1.618c4.477 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center pl-1">
                        <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-emerald-600 bg-slate-100 border-slate-300 rounded cursor-pointer">
                        <label for="remember_me" class="ml-2 block text-xs font-bold text-slate-500 cursor-pointer">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" class="w-full py-4 rounded-xl shadow-lg shadow-emerald-500/30 text-xs font-black uppercase tracking-widest text-white bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-emerald-600 hover:to-cyan-600 transition-all mt-2 active:scale-95">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="mt-8 text-center text-xs font-bold text-slate-500">
                    Belum memiliki akun? <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 hover:underline">Daftar sekarang</a>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
