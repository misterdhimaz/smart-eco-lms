<aside class="w-full lg:w-[260px] h-full bg-[#0f172a] text-slate-300 flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.08)] lg:rounded-[1.5rem] overflow-hidden border-r border-slate-800 lg:border-none relative z-40">

    <!-- HEADER SIDEBAR (MOBILE ONLY) -->
    <div class="lg:hidden flex items-center justify-between p-4 border-b border-slate-800 bg-[#0B1120] shrink-0 relative z-50 shadow-sm">

        <!-- LOGO SAMA DENGAN HEADER: Pop-out Effect -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            <div class="relative flex-shrink-0 w-[40px] md:w-[45px] flex items-center justify-center z-20">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-auto object-contain scale-[1.7] md:scale-[1.8] drop-shadow-md -translate-y-1 md:-translate-y-1.5">
            </div>
            <div class="flex flex-col justify-center ml-1">
                <h1 class="text-sm sm:text-lg font-black leading-none tracking-tight text-[#93c5fd]">
                    SMART<span class="text-[#34d399]">-ECO</span>
                </h1>
                <p class="mt-0.5 text-[8px] font-bold italic tracking-wide text-slate-400">
                    Learning Physics
                </p>
            </div>
        </div>

        <button @click="sidebarOpen = false" class="text-slate-400 hover:text-white p-2 rounded-lg hover:bg-rose-500/20 hover:text-rose-500 transition-colors shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>

    <!-- AREA SCROLL MENU -->
    <div class="flex-1 overflow-y-auto custom-scrollbar-sidebar pt-6 pb-6 relative z-10">

        <div class="px-4 mb-6">
            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('student.dashboard') ? 'bg-gradient-to-r from-emerald-500 to-emerald-400 text-white shadow-lg shadow-emerald-500/30 font-bold border border-emerald-400' : 'hover:bg-slate-800 hover:text-white text-slate-400 font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('student.dashboard') ? '' : 'opacity-70 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                <span>Beranda</span>
            </a>
        </div>

        <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest px-8 mb-3">Menu Utama</p>

        <nav class="space-y-1.5 px-4">
            <a href="{{ route('student.climate') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('student.climate') ? 'bg-emerald-500/10 text-emerald-400 font-bold border border-emerald-500/30' : 'text-slate-400 hover:bg-slate-800 hover:text-slate-200 font-medium border border-transparent' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[13px]">Dashboard Iklim</span>
            </a>

            <a href="{{ route('student.modul') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.modul') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Modul Pembelajaran</span>
            </a>

            <a href="{{ route('student.simulasi') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.simulasi') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Simulasi Interaktif</span>
            </a>

            <a href="{{ route('student.video') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.video') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                <span>Video Pembelajaran</span>
            </a>

            <a href="{{ route('student.games') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.games') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"></path></svg>
                <span>Games Edukasi</span>
            </a>

            <a href="{{ route('student.latihan') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.latihan') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                <span>Latihan Soal</span>
            </a>

            <a href="{{ route('student.proyek') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.proyek') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <span>Proyek & Tugas</span>
            </a>

            <a href="{{ route('student.carbon') ?? '#' }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.carbon') ? 'bg-slate-800 text-emerald-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 opacity-70 text-emerald-500 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <span>Carbon Calculator</span>
                </div>
                <span class="text-[9px] bg-emerald-500/20 text-emerald-400 px-2 py-0.5 rounded-full font-bold border border-emerald-500/30">AI</span>
            </a>

            <a href="{{ route('student.advisor') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.advisor') ? 'bg-slate-800 text-indigo-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 text-indigo-400 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                <span>AI Advisor</span>
            </a>
        </nav>

        <div class="my-5 mx-6 border-t border-slate-800/80"></div>
        <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest px-8 mb-3">Akun Saya</p>

        <nav class="space-y-1.5 px-4">
            <a href="{{ route('student.progress') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.progress') ? 'bg-slate-800 text-blue-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                <span>Progress Saya</span>
            </a>

            <a href="{{ route('student.ranks') ?? '#' }}" class="flex items-center justify-between px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.ranks') ? 'bg-slate-800 text-amber-400 font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('student.ranks') ? 'text-amber-400 opacity-100' : 'opacity-70 text-amber-500 group-hover:opacity-100' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span>Peta Peringkat</span>
                </div>
            </a>

            <a href="{{ route('student.settings') ?? '#' }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all duration-300 {{ request()->routeIs('student.settings') ? 'bg-slate-800 text-white font-bold border border-slate-700' : 'hover:bg-slate-800 hover:text-white text-slate-400 text-[13px] font-medium group border border-transparent' }}">
                <svg class="w-5 h-5 opacity-70 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span>Pengaturan</span>
            </a>
        </nav>
    </div>

    <!-- LOGIKA KALKULASI XP OTOMATIS -->
    @php
        $user = Auth::user();
        $level = $user->level ?? 1;
        $currentXp = $user->xp ?? 0;

        $currentLvlXp = method_exists(\App\Models\User::class, 'calculateXpForLevel')
            ? \App\Models\User::calculateXpForLevel($level)
            : (($level - 1) * 100) + (pow(max($level - 1, 0), 2) * 15);

        $nextLvlXp = method_exists(\App\Models\User::class, 'calculateXpForLevel')
            ? \App\Models\User::calculateXpForLevel($level + 1)
            : ($level * 100) + (pow($level, 2) * 15);

        $xpGainedThisLevel = $currentXp - $currentLvlXp;
        $xpNeededForNext = $nextLvlXp - $currentLvlXp;

        $xpPercent = $xpNeededForNext > 0 ? ($xpGainedThisLevel / $xpNeededForNext) * 100 : 100;
        $xpPercent = min(max($xpPercent, 0), 100);

        $rankName = $user->rank_name ?? '🌱 Eco Seedling';
        $rankIcon = explode(' ', $rankName)[0] ?? '🌱';
        $rankTitle = substr(strstr($rankName, ' '), 1) ?: 'Eco Seedling';
    @endphp

    <!-- FOOTER PROFILE -->
    <div class="p-4 border-t border-slate-800 bg-[#0B1120] shrink-0 relative z-20">

        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-400 text-lg shrink-0">{{ $rankIcon }}</div>
                <div class="truncate pr-2">
                    <p class="text-[11px] font-bold text-white line-clamp-1 truncate">{{ $rankTitle }}</p>
                    <p class="text-[9px] font-semibold text-emerald-400 uppercase tracking-widest">Level {{ $level }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="m-0 shrink-0">
                @csrf
                <button type="submit" class="p-2 bg-slate-800 hover:bg-rose-500 hover:text-white text-slate-400 rounded-lg transition-colors" title="Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>

        <div class="w-full bg-slate-800 rounded-full h-1.5 mb-1.5 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $xpPercent }}%"></div>
        </div>
        <div class="flex justify-between items-center">
            <p class="text-[8px] text-slate-500 font-bold uppercase">{{ round($xpPercent) }}% To Next Level</p>
            <p class="text-[9px] text-slate-400 font-bold tracking-wide">{{ number_format($currentXp) }} / {{ number_format($nextLvlXp) }} XP</p>
        </div>
    </div>
</aside>
