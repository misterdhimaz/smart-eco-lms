@props(['admin'])

<div x-show="sidebarOpen"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40 lg:hidden"
     @click="sidebarOpen = false"
     x-cloak></div>

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       class="fixed inset-y-0 left-0 z-50 w-72 h-full bg-[#0f172a] text-slate-300 flex flex-col transition-transform duration-500 ease-out lg:translate-x-0 lg:static lg:h-screen shadow-[10px_0_30px_rgba(0,0,0,0.5)] lg:shadow-none shrink-0 border-r border-slate-800 relative overflow-hidden">

    <div class="absolute top-0 left-0 w-full h-64 bg-[#047857]/5 blur-[80px] pointer-events-none"></div>

    <div class="flex-1 overflow-y-auto custom-scrollbar relative z-10 flex flex-col">

        <div class="relative pt-6 pb-5 px-5 border-b border-slate-800/80 bg-gradient-to-br from-[#0f172a] via-[#111827] to-[#047857]/20 sticky top-0 z-20 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-[#34d399]/10 blur-[30px] rounded-full pointer-events-none"></div>

            <a href="{{ route('admin.dashboard') }}" class="relative flex items-center gap-3 group">

                <div class="shrink-0 relative">
                    <div class="absolute inset-2 bg-[#34d399] rounded-full blur-xl opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>

                    <img src="{{ asset('images/logoo1.png') }}"
                         alt="SMART-ECO Logo"
                         class="relative w-[72px] h-[72px] object-contain transform transition-transform duration-300 group-hover:scale-105 drop-shadow-[0_5px_15px_rgba(0,0,0,0.4)]">
                </div>

                <div class="flex flex-col min-w-0">
                    <h1 class="text-[20px] font-black leading-none tracking-tight text-[#93c5fd] group-hover:text-blue-300 transition-colors truncate">
                        SMART<span class="text-[#34d399]">-ECO</span>
                    </h1>
                    <p class="mt-1 text-[8px] font-bold italic tracking-wide text-slate-400 leading-tight">
                        Learning Physics for a<br>Sustainable Future
                    </p>
                    <div class="mt-1.5 flex items-start">
                        <span class="inline-flex bg-gradient-to-r from-[#047857]/50 to-[#047857]/10 border border-[#047857]/50 text-[#34d399] text-[8px] font-black uppercase tracking-[0.2em] px-2 py-0.5 rounded shadow-sm">
                            Admin Panel
                        </span>
                    </div>
                </div>
            </a>
        </div>

        <nav class="py-5 space-y-1">
            <p class="text-[10px] text-slate-500 mb-3 px-5 uppercase tracking-[0.15em] font-black menu-animate" style="--delay: 0.1s">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}"
               class="menu-animate flex items-center gap-3.5 px-4 py-3 mx-2 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-[#047857]/20 to-transparent text-[#34d399] border border-[#047857]/30 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}" style="--delay: 0.15s">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.dashboard') ? 'text-[#34d399]' : 'text-slate-500 group-hover:text-[#34d399]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                <span class="text-sm font-bold tracking-wide">Command Center</span>
            </a>

            <a href="{{ route('admin.users') ?? '#' }}"
               class="menu-animate flex items-center gap-3.5 px-4 py-3 mx-2 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.users') ? 'bg-gradient-to-r from-[#047857]/20 to-transparent text-[#34d399] border border-[#047857]/30 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}" style="--delay: 0.2s">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.users') ? 'text-[#34d399]' : 'text-slate-500 group-hover:text-[#34d399]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <span class="text-sm font-bold tracking-wide">Manajemen Pengguna</span>
            </a>

            <a href="{{ route('admin.modules') }}"
               class="menu-animate flex items-center gap-3.5 px-4 py-3 mx-2 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.modules*') ? 'bg-gradient-to-r from-[#047857]/20 to-transparent text-[#34d399] border border-[#047857]/30 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}" style="--delay: 0.25s">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.modules*') ? 'text-[#34d399]' : 'text-slate-500 group-hover:text-[#34d399]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span class="text-sm font-bold tracking-wide">Modul Pembelajaran</span>
            </a>

            <a href="{{ route('admin.assessments') ?? '#' }}"
               class="menu-animate flex items-center gap-3.5 px-4 py-3 mx-2 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.assessments*') ? 'bg-gradient-to-r from-[#047857]/20 to-transparent text-[#34d399] border border-[#047857]/30 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}" style="--delay: 0.3s">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.assessments*') ? 'text-[#34d399]' : 'text-slate-500 group-hover:text-[#34d399]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span class="text-sm font-bold tracking-wide">Evaluasi & Tugas</span>
            </a>

            <a href="{{ route('admin.classrooms.index') ?? '#' }}"
               class="menu-animate flex items-center gap-3.5 px-4 py-3 mx-2 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.classrooms.*') ? 'bg-gradient-to-r from-[#047857]/20 to-transparent text-[#34d399] border border-[#047857]/30 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}" style="--delay: 0.35s">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.classrooms.*') ? 'text-[#34d399]' : 'text-slate-500 group-hover:text-[#34d399]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <span class="text-sm font-bold tracking-wide">Ruang Kelas & Proyek</span>
            </a>

            <a href="{{ route('admin.video-modules.index') ?? '#' }}"
               class="menu-animate flex items-center gap-3.5 px-4 py-3 mx-2 rounded-xl transition-all duration-300 group {{ request()->routeIs('admin.video-modules.*') ? 'bg-gradient-to-r from-[#047857]/20 to-transparent text-[#34d399] border border-[#047857]/30 shadow-inner' : 'text-slate-400 hover:bg-slate-800/50 hover:text-slate-200 border border-transparent' }}" style="--delay: 0.4s">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110 {{ request()->routeIs('admin.video-modules.*') ? 'text-[#34d399]' : 'text-slate-500 group-hover:text-[#34d399]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <span class="text-sm font-bold tracking-wide">Modul & Video</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors text-slate-400 hover:text-white hover:bg-slate-800">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
    Laporan Mahasiswa
</a>
        </nav>
    </div>

    <div class="p-4 bg-[#0B1121] border-t border-slate-800/80 shrink-0 relative z-20">
        <div class="bg-[#131B2F] border border-slate-700/50 p-2.5 rounded-2xl flex items-center justify-between hover:border-[#047857]/50 hover:bg-slate-800/80 transition-all duration-300 group shadow-md">

            <div class="flex items-center gap-3 overflow-hidden px-1">
                <div class="w-9 h-9 shrink-0 bg-gradient-to-br from-[#047857] to-teal-600 rounded-xl flex items-center justify-center text-white font-black shadow-md shadow-[#047857]/20 group-hover:scale-105 transition-transform duration-300">
                    {{ substr($admin->name ?? 'A', 0, 1) }}
                </div>
                <div class="truncate flex-1">
                    <p class="text-xs font-black text-slate-100 truncate">{{ $admin->name ?? 'Admin' }}</p>
                    <p class="text-[9px] text-[#34d399] uppercase tracking-widest font-bold mt-0.5">Administrator</p>
                </div>
            </div>

            <form action="{{ route('logout') ?? '#' }}" method="POST" class="m-0 shrink-0 pl-1">
                @csrf
                <button type="submit"
                        class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-xl transition-all duration-300 active:scale-90 hover:rotate-12"
                        title="Logout dari sistem">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                </button>
            </form>

        </div>
    </div>
</aside>

<style>
    /* Styling Scrollbar Modern & Elegan */
    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #334155; }

    /* CSS KEYFRAMES ANIMATION */
    @keyframes slideInUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .menu-animate {
        opacity: 0;
        animation: slideInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: var(--delay, 0s);
    }
</style>
