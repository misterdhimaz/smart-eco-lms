<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Admin Panel') | SMART-ECO</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased font-sans h-[100dvh] flex overflow-hidden" x-data="{ sidebarOpen: false }">

    @if(View::exists('components.admin-sidebar'))
        <x-admin-sidebar :admin="auth()->user()" />
    @else
        @include('layouts.partials.admin_sidebar')
    @endif

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">

        <header class="h-16 md:h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 md:px-8 flex items-center justify-between shrink-0 z-30">
            <div class="flex items-center gap-3 md:gap-4">
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 -ml-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 lg:hidden transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <p class="text-[9px] md:text-[10px] font-black text-emerald-600 uppercase tracking-widest hidden sm:block">SMART-ECO Dashboard</p>
                    <h2 class="text-sm md:text-lg font-black text-slate-800 leading-tight">Panel Administrator</h2>
                </div>
            </div>

            <div class="flex items-center gap-3 md:gap-4">
                <div class="hidden sm:flex flex-col text-right">
                    <p class="text-xs font-black text-slate-800 truncate max-w-[120px]">{{ auth()->user()->name ?? 'Administrator' }}</p>
                    <p class="text-[9px] font-bold text-slate-400 uppercase">Super Admin</p>
                </div>
                <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-800 text-white rounded-xl flex items-center justify-center font-black text-xs shadow-md shrink-0">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar">
            @yield('content')
        </main>

    </div>
</body>
</html>
