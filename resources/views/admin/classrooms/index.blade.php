<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Kelas Proyek | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex overflow-hidden" x-data="{ sidebarOpen: false, openCreate: false }">

    <div class="flex flex-1 overflow-hidden relative w-full">

        <!-- OVERLAY SIDEBAR MOBILE -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- SIDEBAR -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-100">

            <!-- HEADER -->
            <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-4 lg:px-8 z-30 shrink-0 shadow-sm">
                <div class="flex items-center gap-3 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate flex-1 min-w-0">
                        <h1 class="text-lg md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Manajemen <span class="text-emerald-600">Kelas</span></h1>
                        <p class="text-[9px] md:text-xs text-slate-500 font-bold hidden sm:block mt-1">Kelola instruksi, pantau progres, dan berikan penilaian langsung.</p>
                    </div>
                </div>

                <div class="flex items-center shrink-0">
                    <button @click="openCreate = true" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 md:px-6 md:py-3 rounded-xl text-[10px] md:text-xs font-black transition-all flex items-center gap-2 active:scale-95 gsap-btn uppercase tracking-widest shadow-md">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        <span class="hidden sm:inline">Buat Kelas Baru</span>
                        <span class="sm:hidden">Buat Kelas</span>
                    </button>
                </div>
            </header>

            <!-- KONTEN SCROLLABLE -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 lg:p-10 custom-scrollbar relative w-full pb-20">
                <div class="max-w-[1400px] mx-auto space-y-6 md:space-y-8 w-full">

                    @if(session('success'))
                        <div class="bg-emerald-50 border-2 border-emerald-200 text-emerald-800 p-4 rounded-xl mb-6 flex items-center gap-3 shadow-sm font-bold text-xs md:text-sm animate-fade-in-up">
                            <span class="w-8 h-8 bg-emerald-600 text-white rounded-lg flex items-center justify-center shrink-0">✓</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-8">
                        @forelse($classrooms as $class)
                        <div class="group bg-white rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm hover:shadow-xl hover:border-emerald-500 transition-all duration-300 overflow-hidden gsap-card flex flex-col cursor-pointer" onclick="window.location='{{ route('admin.classrooms.show', $class->id) }}'">

                            <div class="h-28 md:h-36 bg-slate-900 p-5 md:p-6 relative border-b-4 border-emerald-500 shrink-0 flex flex-col justify-center">
                                <div class="absolute top-4 right-4 bg-white text-slate-900 px-3 py-1.5 rounded-lg border-2 border-slate-200 text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $class->code }}
                                </div>
                                <h3 class="text-lg md:text-xl font-black text-white leading-tight uppercase group-hover:text-emerald-400 transition-colors pr-20 truncate">{{ $class->name }}</h3>
                                <p class="text-[10px] md:text-xs font-bold text-emerald-300 mt-1 uppercase tracking-wider truncate">{{ $class->subject }}</p>
                            </div>

                            <div class="p-5 md:p-6 flex-1 flex flex-col justify-between bg-white w-full">
                                <div class="flex items-center justify-between mb-5 md:mb-6">
                                    <div class="flex -space-x-3">
                                        @for($i=0; $i<3; $i++)
                                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-slate-200 border-2 border-white flex items-center justify-center text-[10px] md:text-xs font-black text-slate-500 shadow-sm">M</div>
                                        @endfor
                                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[10px] md:text-xs font-black text-emerald-700 shadow-sm z-10">+{{ $class->students_count }}</div>
                                    </div>
                                    <span class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest bg-slate-100 px-2 py-1 rounded">{{ $class->assignments_count }} Tugas</span>
                                </div>

                                <button class="w-full text-center py-3 bg-slate-100 border-2 border-slate-200 rounded-xl text-[10px] md:text-xs font-black text-slate-600 group-hover:bg-emerald-600 group-hover:text-white group-hover:border-emerald-600 transition-all uppercase tracking-widest">
                                    Buka Dashboard Kelas
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-16 md:py-24 text-center bg-white rounded-2xl md:rounded-[3rem] border-2 border-dashed border-slate-300 shadow-sm">
                            <span class="text-5xl md:text-6xl block mb-4 grayscale opacity-30">🏫</span>
                            <h3 class="text-lg md:text-xl font-black text-slate-500">Belum Ada Kelas Proyek</h3>
                            <p class="text-xs text-slate-400 mt-2 font-bold">Klik tombol 'Buat Kelas Baru' di atas untuk memulai.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- MODAL CREATE -->
    <div x-show="openCreate" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 w-screen h-[100dvh] overflow-hidden">
        <div @click.away="openCreate = false" class="bg-white w-full max-w-md rounded-2xl md:rounded-[2.5rem] shadow-2xl p-6 md:p-8 border-2 border-slate-200 flex flex-col max-h-[90vh]">

            <div class="flex justify-between items-center mb-6 border-b-2 border-slate-100 pb-4 shrink-0">
                <h2 class="text-lg md:text-2xl font-black text-slate-900 flex items-center gap-3 uppercase tracking-tight">
                    <span class="p-2.5 bg-emerald-100 text-emerald-600 rounded-xl text-lg border border-emerald-200">🏛️</span> Bangun Kelas
                </h2>
                <button @click="openCreate = false" class="text-slate-400 hover:text-rose-500 bg-slate-100 hover:bg-rose-100 p-2 rounded-xl transition-all border border-transparent hover:border-rose-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2">
                <form action="{{ route('admin.classrooms.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Nama Kelas / Judul Proyek</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-emerald-600 outline-none transition-all shadow-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Subjek / Kategori</label>
                        <input type="text" name="subject" class="w-full px-4 py-3 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-emerald-600 outline-none transition-all shadow-sm" placeholder="Contoh: Energi Terbarukan">
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 md:py-4 bg-emerald-600 text-white rounded-xl font-black uppercase tracking-widest text-[10px] md:text-xs hover:bg-emerald-700 transition-all shadow-md active:scale-95 border border-emerald-700">Publikasikan Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <!-- KODE JAVASCRIPT GSAP (DIPERBAIKI) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(typeof gsap !== 'undefined') {
                // Memastikan elemen pasti berawal dari opacity 0 dan berakhir di 1 (Normal)
                gsap.fromTo(".gsap-header",
                    { y: -20, opacity: 0 },
                    { y: 0, opacity: 1, duration: 0.6, ease: "power2.out" }
                );

                gsap.fromTo(".gsap-card",
                    { y: 30, opacity: 0 },
                    { y: 0, opacity: 1, duration: 0.5, stagger: 0.1, ease: "back.out(1.2)", delay: 0.2 }
                );
            }
        });
    </script>
</body>
</html>

