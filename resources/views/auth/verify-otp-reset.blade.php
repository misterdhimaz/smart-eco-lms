<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Reset | SMART-ECO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-[100dvh] p-4">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8 border border-slate-200 text-center">
        <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h2 class="text-2xl font-black text-slate-800">Masukkan Kode OTP</h2>
        <p class="text-sm font-medium text-slate-500 mt-2 mb-6">Cek email <strong class="text-slate-800">{{ request('email') }}</strong>. Masukkan OTP sebelum batas waktu (2 Menit).</p>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-xl bg-emerald-50 text-emerald-600 text-xs font-bold">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-3 rounded-xl bg-rose-50 text-rose-600 text-xs font-bold">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('password.verify_otp.post') }}">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">
            <input type="text" name="otp" required maxlength="6" placeholder="------" autocomplete="off" class="w-full text-center tracking-[0.75em] px-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-2xl font-black text-slate-800 outline-none focus:border-rose-500 transition-all mb-6">

            <button type="submit" class="w-full py-4 rounded-xl shadow-lg shadow-rose-500/30 text-xs font-black uppercase tracking-widest text-white bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 transition-all active:scale-95">
                Verifikasi OTP
            </button>
        </form>
    </div>
</body>
</html>
