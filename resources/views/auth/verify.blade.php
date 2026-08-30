<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Verifikasi OTP | SMART-ECO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-[100dvh] p-4 relative overflow-hidden">

    <div class="w-full max-w-md bg-white rounded-3xl md:rounded-[2rem] shadow-xl p-8 text-center border border-slate-200 relative z-10">
        <div class="w-16 h-16 bg-cyan-50 border border-cyan-100 text-cyan-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>

        <h2 class="text-2xl font-black text-slate-800 mb-2 tracking-tight">Periksa Email Anda</h2>
        <p class="text-sm font-medium text-slate-500 mb-6 leading-relaxed">
            Kami telah mengirimkan 6 digit kode OTP ke email <br><strong class="text-slate-800">{{ request('email') }}</strong>
        </p>

        @if (session('error'))
            <div class="mb-6 p-3.5 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 text-xs font-bold">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="mb-6 p-3.5 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('verify.otp.post') }}">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">

            <input type="text" name="otp" required maxlength="6" placeholder="------" autocomplete="off"
                   class="w-full text-center tracking-[0.75em] px-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-2xl font-black text-slate-800 outline-none focus:bg-white focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/20 mb-6 transition-all placeholder:text-slate-300">

            <button type="submit" class="w-full py-4 rounded-xl shadow-lg shadow-cyan-500/30 text-xs font-black uppercase tracking-widest text-white bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 transition-all active:scale-95">
                Verifikasi Akun
            </button>
        </form>

        <p class="text-xs font-bold text-slate-400 mt-6">
            Salah email? <a href="{{ route('register') }}" class="text-cyan-500 hover:underline">Daftar ulang</a>
        </p>
    </div>

</body>
</html>
