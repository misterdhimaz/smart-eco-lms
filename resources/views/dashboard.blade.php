<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased p-8">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex justify-between items-center bg-slate-800 p-6 rounded-3xl border border-slate-700">
            <div>
                <h1 class="text-2xl font-black text-white">Halo, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-xs text-slate-400 mt-1">Role: <span class="uppercase text-indigo-400 font-bold">{{ Auth::user()->role }}</span></p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-rose-600 hover:bg-rose-500 text-white px-4 py-2 rounded-xl text-xs font-bold">
                    Logout
                </button>
            </form>
        </div>
    </div>
</body>
</html>
