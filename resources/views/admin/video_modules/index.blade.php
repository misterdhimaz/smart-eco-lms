<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Video Pembelajaran | SMART-ECO Admin</title>

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

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- OVERLAY MOBILE -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

    <!-- SIDEBAR -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
        <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 bg-slate-100 w-full">

        <!-- HEADER KECIL -->
        <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
            <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="truncate">
                    <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Video <span class="text-emerald-600">Pembelajaran</span></h1>
                </div>
            </div>
            <div class="shrink-0">
                <a href="{{ route('admin.video-modules.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 md:px-5 py-2 md:py-2.5 rounded-lg md:rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-md active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                    <span class="hidden sm:inline">Tambah Modul</span>
                </a>
            </div>
        </header>

        <!-- KONTEN SCROLLABLE -->
        <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-8 custom-scrollbar w-full relative z-10 pb-20">
            <div class="max-w-[1200px] mx-auto w-full space-y-6">

                <!-- HERO BANNER (SOLID DESIGN) -->
                <div class="bg-slate-900 rounded-2xl md:rounded-[2rem] p-6 md:p-10 text-white relative overflow-hidden shadow-md border-b-4 border-emerald-500 gsap-fade">
                    <div class="relative z-10">
                        <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-600 text-white rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-4">
                            Manajemen Konten
                        </span>
                        <h2 class="text-xl sm:text-3xl md:text-4xl font-black tracking-tight mb-2 md:mb-3">Modul Video Pembelajaran</h2>
                        <p class="text-[10px] md:text-sm text-slate-400 font-medium max-w-2xl leading-relaxed">Kelola album modul, atur thumbnail cover, dan susun playlist video materi (dukungan integrasi YouTube & MP4 Upload).</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-50 border-2 border-emerald-200 text-emerald-800 p-3 md:p-4 rounded-xl flex items-center gap-3 font-bold text-xs md:text-sm shadow-sm">
                        <span class="w-6 h-6 md:w-8 md:h-8 bg-emerald-600 text-white rounded-md md:rounded-lg flex items-center justify-center shrink-0">✓</span>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- TABEL DATA -->
                <div class="bg-white rounded-2xl md:rounded-[2rem] border-2 border-slate-200 overflow-hidden shadow-sm flex flex-col gsap-fade w-full">
                    <div class="p-4 md:p-6 border-b-2 border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50 shrink-0">
                        <h3 class="font-black text-slate-900 text-sm md:text-base uppercase tracking-widest">Daftar Modul Video</h3>
                        <form action="{{ route('admin.video-modules.index') }}" method="GET" class="relative w-full sm:w-72">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul modul..." class="w-full bg-white border-2 border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </form>
                    </div>

                    <div class="w-full overflow-x-auto custom-scrollbar flex-1">
                        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px] md:min-w-[900px]">
                            <thead>
                                <tr class="bg-white border-b border-slate-100 text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <th class="p-4 md:p-5 text-center w-16">Cover</th>
                                    <th class="p-4 md:p-5">Informasi Modul</th>
                                    <th class="p-4 md:p-5">Daftar Video</th>
                                    <th class="p-4 md:p-5 text-center">Aksi (CRUD)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($modules as $module)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-4 md:p-5 text-center">
                                        <div class="w-16 h-12 md:w-20 md:h-14 rounded-lg md:rounded-xl overflow-hidden bg-slate-100 border-2 border-slate-200 shrink-0 mx-auto">
                                            @if($module->cover_image)
                                                <img src="{{ asset('storage/' . $module->cover_image) }}" alt="Cover" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[8px] md:text-[9px] font-black text-slate-400">NO COVER</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 md:p-5">
                                        <span class="px-2 py-1 bg-slate-100 text-slate-600 border border-slate-200 rounded text-[8px] md:text-[9px] font-black uppercase tracking-widest inline-block mb-1 shadow-sm">{{ $module->badge }}</span>
                                        <h3 class="font-black text-slate-900 text-xs md:text-sm truncate max-w-[200px] sm:max-w-[300px]">{{ $module->title }}</h3>
                                        <p class="text-[9px] md:text-[11px] font-bold text-slate-500 mt-1 truncate max-w-[200px] sm:max-w-[300px]">{{ $module->description }}</p>
                                    </td>
                                    <td class="p-4 md:p-5">
                                        <span class="font-black text-slate-800 text-[10px] md:text-xs block mb-1.5">{{ $module->videos->count() }} Video Tersedia</span>
                                        <div class="space-y-1">
                                            @foreach($module->videos->take(2) as $vid)
                                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 truncate max-w-[150px] md:max-w-[200px]">
                                                    <span class="{{ $vid->type == 'youtube' ? 'text-rose-600' : 'text-blue-600' }}">[{{ strtoupper($vid->type) }}]</span> {{ $vid->title }}
                                                </p>
                                            @endforeach
                                            @if($module->videos->count() > 2)
                                                <p class="text-[8px] md:text-[9px] font-black text-emerald-600 mt-1">+{{ $module->videos->count() - 2 }} video lainnya...</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 md:p-5 text-center">
                                        <div class="flex items-center justify-center gap-1.5 md:gap-2">
                                            <a href="{{ route('admin.video-modules.edit', $module->id) }}" class="p-2 bg-white border-2 border-slate-200 text-slate-500 hover:text-amber-600 hover:border-amber-400 hover:bg-amber-50 rounded-lg md:rounded-xl transition-all shadow-sm active:scale-95" title="Edit Modul">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <button onclick="confirmDelete({{ $module->id }}, '{{ addslashes($module->title) }}')" class="p-2 bg-white border-2 border-slate-200 text-slate-500 hover:text-rose-600 hover:border-rose-400 hover:bg-rose-50 rounded-lg md:rounded-xl transition-all shadow-sm active:scale-95" title="Hapus Modul">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                            <form id="delete-form-{{ $module->id }}" action="{{ route('admin.video-modules.destroy', $module->id) }}" method="POST" class="hidden">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 md:py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-4xl md:text-5xl opacity-40 mb-3 grayscale">🎥</span>
                                            <p class="text-xs md:text-sm font-black text-slate-500">Belum Ada Modul Video</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($modules->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50 shrink-0">
                        {{ $modules->links() }}
                    </div>
                    @endif
                </div>

            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(typeof gsap !== 'undefined') {
                gsap.from(".gsap-header", { y: -10, opacity: 0, duration: 0.5, ease: "power2.out" });
                gsap.from(".gsap-fade", { y: 20, opacity: 0, duration: 0.5, stagger: 0.1, ease: "power2.out", delay: 0.1 });
            }
        });

        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Hapus Modul?', text: "Modul video beserta seluruh daftar playlist videonya akan terhapus permanen!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!', customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-6', cancelButton: 'rounded-xl font-bold px-6' }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
            });
        }
    </script>
</body>
</html>
