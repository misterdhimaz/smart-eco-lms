<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Sandi | SMART-ECO</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-[100dvh] p-4">
    <div class="w-full max-w-md bg-white rounded-3xl md:rounded-[2rem] shadow-xl p-8 border border-slate-200">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-rose-50 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800">Lupa Sandi?</h2>
            <p class="text-sm font-medium text-slate-500 mt-2">Masukkan email Anda. Kami akan mengirimkan OTP 6 digit yang berlaku 2 menit.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-rose-50 text-rose-600 text-xs font-bold">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <label class="block text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1.5 pl-1">Alamat Email</label>
            <input type="email" name="email" required placeholder="contoh@email.com" class="w-full px-4 py-4 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 outline-none focus:border-rose-500 transition-all mb-6">

            <button type="submit" class="w-full py-4 rounded-xl shadow-lg shadow-rose-500/30 text-xs font-black uppercase tracking-widest text-white bg-gradient-to-r from-rose-500 to-pink-500 hover:from-rose-600 hover:to-pink-600 transition-all active:scale-95">
                Kirim Kode OTP
            </button>
        </form>

        <p class="text-xs font-bold text-slate-400 mt-6 text-center">
            Ingat sandi Anda? <a href="{{ route('login') }}" class="text-rose-500 hover:underline">Kembali masuk</a>
        </p>
    </div>
</body>
</html>
