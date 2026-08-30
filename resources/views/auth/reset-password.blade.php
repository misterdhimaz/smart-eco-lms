<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Sandi | SMART-ECO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-[100dvh] p-4">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 border border-slate-200">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-black text-slate-800">Buat Sandi Baru</h2>
            <p class="text-sm font-medium text-slate-500 mt-2">OTP tervalidasi. Silakan masukkan kata sandi baru Anda yang kuat dan mudah diingat.</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-bold">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-rose-50 text-rose-600 text-xs font-bold">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <!-- Simpan email dan otp secara tersembunyi untuk keamanan final -->
            <input type="hidden" name="email" value="{{ request('email') }}">
            <input type="hidden" name="otp" value="{{ request('otp') }}">

            <div x-data="{ showPass1: false }" class="relative">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Sandi Baru</label>
                <input :type="showPass1 ? 'text' : 'password'" name="password" required placeholder="••••••••" class="w-full px-4 py-3 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:border-rose-500 transition-all">
                <button type="button" @click="showPass1 = !showPass1" class="absolute bottom-0 right-0 h-[46px] pr-3 text-slate-400">👁️</button>
            </div>

            <div x-data="{ showPass2: false }" class="relative">
                <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Ulangi Sandi Baru</label>
                <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" required placeholder="••••••••" class="w-full px-4 py-3 pr-10 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:border-rose-500 transition-all">
                <button type="button" @click="showPass2 = !showPass2" class="absolute bottom-0 right-0 h-[46px] pr-3 text-slate-400">👁️</button>
            </div>

            <button type="submit" class="w-full py-4 mt-2 rounded-xl shadow-lg shadow-rose-500/30 text-xs font-black uppercase tracking-widest text-white bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 transition-all active:scale-95">
                Simpan Sandi Baru
            </button>
        </form>
    </div>
</body>
</html>
