<header class="h-[64px] md:h-[76px] bg-white border-b border-slate-200 flex items-center justify-between px-3 md:px-6 shrink-0 z-50 shadow-sm relative">

    <!-- BAGIAN KIRI: Menu, Logo, dan Judul -->
    <div class="flex items-center gap-1.5 md:gap-4 flex-1 min-w-0">
        <!-- Tombol Menu Mobile -->
        <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
            <svg class="w-6 h-6 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
        </button>

        <a href="{{ route('student.dashboard') }}" class="flex items-center gap-1 md:gap-3 shrink-0">
            <!-- Logo (Pop-out effect) -->
            <div class="relative flex-shrink-0 w-[35px] md:w-[60px] flex items-center justify-center z-20">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-auto object-contain scale-[1.7] md:scale-[2] drop-shadow-md -translate-y-1 md:-translate-y-1.5">
            </div>
            <!-- Tulisan (Sekarang tampil di mobile) -->
            <div class="flex flex-col justify-center mt-1 md:mt-0 md:ml-2">
                <h1 class="text-sm sm:text-lg md:text-2xl font-black leading-none tracking-tight text-[#1e3a8a]">
                    SMART<span class="text-[#047857]">-ECO</span>
                </h1>
                <!-- Sub-judul hanya tampil di Desktop/Tablet agar tidak penuh -->
                <p class="mt-0.5 text-[8px] md:text-[9px] font-bold italic tracking-wide text-slate-500 hidden md:block">
                    Learning Physics for a Sustainable Future
                </p>
            </div>
        </a>
    </div>

    <!-- BAGIAN TENGAH: Search bar (Hanya Desktop/Tablet) -->
    <div class="hidden lg:flex flex-1 max-w-[450px] mx-4">
        <form action="{{ route('student.search') }}" method="GET" class="flex w-full border border-slate-300 rounded-lg overflow-hidden bg-white focus-within:border-[#047857] focus-within:ring-1 focus-within:ring-[#047857] transition-all shadow-sm">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari materi, tugas..." class="w-full px-4 py-2 text-xs text-slate-700 outline-none">
            <button type="submit" class="bg-[#047857] hover:bg-[#065f46] text-white px-4 transition-colors flex items-center justify-center shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

        <div class="h-5 w-px bg-slate-200 hidden sm:block mx-1"></div>

        <!-- Tombol Profil -->
        <div @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="relative flex items-center gap-2 cursor-pointer group hover:bg-slate-50 p-1 md:p-1.5 rounded-lg transition-colors shrink-0">
            @php
                $user = Auth::user();
                $nameParts = explode(' ', trim($user->name));
                $firstName = $nameParts[0];
                $initials = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));
            @endphp

            <!-- Foto Profil / Inisial -->
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-7 h-7 md:w-9 md:h-9 rounded-full object-cover shadow-sm border border-slate-200 group-hover:ring-2 ring-[#047857]/30 transition-all shrink-0 relative z-10">
            @else
                <div class="w-7 h-7 md:w-9 md:h-9 rounded-full bg-[#047857] flex items-center justify-center text-white font-bold text-[10px] md:text-xs shadow-sm group-hover:ring-2 ring-[#047857]/30 transition-all shrink-0 relative z-10">
                    {{ $initials }}
                </div>
            @endif

            <!-- Nama (Hanya Desktop) -->
            <div class="hidden lg:block text-left ml-1">
                <p class="text-xs font-black text-slate-800 leading-none truncate max-w-[100px]">Halo, {{ $firstName }}</p>
                <p class="text-[9px] font-semibold text-slate-500 mt-0.5">Siswa Aktif</p>
            </div>

            <svg class="w-4 h-4 text-slate-400 hidden sm:block transition-transform" :class="profileOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>

            <!-- Dropdown Profil Box -->
            <div x-show="profileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute top-12 right-0 md:top-14 w-56 md:w-60 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                <div class="px-4 py-3 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#047857] flex items-center justify-center text-white font-bold text-sm shrink-0">{{ $initials }}</div>
                    <div class="overflow-hidden">
                        <p class="text-xs font-black text-slate-800 truncate">{{ $user->name }}</p>
                        <p class="text-[9px] md:text-[10px] text-slate-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>
                <div class="py-2">
                    <a href="{{ route('student.settings') }}" class="flex items-center gap-3 px-4 py-2 text-xs font-bold text-slate-600 hover:text-[#047857] hover:bg-[#047857]/5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan Profil
                    </a>
                </div>
                <div class="px-3 pt-1 border-t border-slate-100">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 w-full px-2 py-2 text-xs font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar (Log Out)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
