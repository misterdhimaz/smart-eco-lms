<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Laporan Mahasiswa | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex flex-col overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden relative w-full">

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-100">

            <!-- HEADER -->
            <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-4 lg:px-8 z-30 shrink-0 shadow-sm">
                <div class="flex items-center gap-3 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate flex-1 min-w-0">
                        <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Laporan <span class="text-blue-600">Evaluasi</span></h1>
                        <p class="text-[9px] md:text-xs text-slate-500 font-bold hidden sm:block mt-1">Pantau progress, filter kelas, dan cetak rapor belajar mahasiswa.</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 lg:p-8 custom-scrollbar relative z-10 w-full pb-20">
                <div class="max-w-[1400px] mx-auto space-y-6 md:space-y-8 w-full">

                    <div class="bg-slate-900 rounded-2xl md:rounded-[2rem] p-6 md:p-10 text-white relative overflow-hidden shadow-md border-b-4 border-blue-500 gsap-fade">
                        <div class="relative z-10">
                            <span class="inline-block bg-blue-600 text-white px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-4 shadow-sm">
                                Pusat Laporan
                            </span>
                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black mb-2 md:mb-3 leading-tight text-white">
                                Laporan & Evaluasi Akhir
                            </h2>
                            <p class="text-[11px] md:text-sm text-slate-300 font-medium leading-relaxed max-w-2xl">
                                Rekapitulasi penuh hasil pengerjaan modul, penyelesaian tugas, dan kuis. Anda dapat melihat dan mencetak rapor PDF dengan menekan tombol View & Cetak.
                            </p>
                        </div>
                    </div>

                    <div class="bg-white p-4 md:p-6 rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm gsap-fade">
                        <form action="{{ route('admin.reports.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                            <div class="w-full md:flex-1">
                                <label class="block text-[10px] md:text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Cari Mahasiswa</label>
                                <div class="relative group">
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama atau email..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-10 pr-4 py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-blue-500 outline-none transition-all">
                                    <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400 absolute left-4 top-3.5 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>

                            <div class="w-full md:w-48 shrink-0">
                                <label class="block text-[10px] md:text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Filter Kelas</label>
                                <select name="kode_kelas" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none cursor-pointer">
                                    <option value="">Semua Kelas</option>
                                    @foreach($kelasList as $kelas)
                                        <option value="{{ $kelas }}" {{ request('kode_kelas') == $kelas ? 'selected' : '' }}>Kelas: {{ $kelas }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full md:w-48 shrink-0">
                                <label class="block text-[10px] md:text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none cursor-pointer">
                                    <option value="">Semua</option>
                                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="flex gap-2 w-full md:w-auto shrink-0 mt-2 md:mt-0">
                                <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-5 md:px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all active:scale-95 shadow-md">Terapkan</button>
                                @if(request('search') || request('kode_kelas') || request('jenis_kelamin'))
                                    <a href="{{ route('admin.reports.index') }}" class="px-4 py-3 bg-slate-100 hover:bg-rose-100 border-2 border-slate-200 hover:border-rose-300 text-rose-500 rounded-xl text-sm font-black transition-all flex items-center justify-center" title="Reset Filter">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="bg-white rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm overflow-hidden flex flex-col gsap-fade w-full">
                        <div class="px-4 md:px-6 py-4 border-b-2 border-slate-200 bg-slate-50 flex justify-between items-center shrink-0">
                            <h2 class="text-xs md:text-sm font-black text-slate-900 uppercase tracking-widest leading-none">Direktori Rapor Mahasiswa</h2>
                            <span class="text-[9px] font-black text-white bg-slate-800 px-3 py-1 rounded-md uppercase tracking-widest">{{ $students->count() }} Data</span>
                        </div>

                        <div class="w-full overflow-x-auto custom-scrollbar flex-1">
                            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px] md:min-w-[900px]">
                                <thead>
                                    <tr class="bg-slate-100 border-b-2 border-slate-200 text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                        <th class="px-5 md:px-6 py-4">Profil Mahasiswa</th>
                                        <th class="px-5 md:px-6 py-4">Kelas</th>
                                        <th class="px-5 md:px-6 py-4 text-center">Gender</th>
                                        <th class="px-5 md:px-6 py-4 text-center">Aksi Laporan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($students as $student)
                                    <tr class="hover:bg-slate-50 transition-colors group">

                                        <td class="px-5 md:px-6 py-3 md:py-4">
                                            <div class="flex items-center gap-3 md:gap-4">
                                                <div class="w-10 h-10 md:w-12 md:h-12 rounded-xl bg-slate-200 border-2 border-slate-300 shadow-sm overflow-hidden shrink-0">
                                                    @if($student->foto)
                                                        <img src="{{ asset('storage/' . $student->foto) }}" alt="Foto" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center font-black text-slate-500 bg-slate-100 text-lg">
                                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="truncate max-w-[150px] sm:max-w-[250px] md:max-w-none">
                                                    <h3 class="text-xs md:text-sm font-black text-slate-900 truncate">{{ $student->name }}</h3>
                                                    <p class="text-[9px] md:text-[11px] font-bold text-slate-500 truncate mt-0.5">{{ $student->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-5 md:px-6 py-3 md:py-4">
                                            @if($student->classrooms && $student->classrooms->count() > 0)
                                                <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded text-[9px] md:text-[10px] font-black uppercase tracking-wider inline-block">
                                                    {{ $student->classrooms->first()->name }}
                                                </span>
                                            @elseif($student->kode_kelas)
                                                <span class="bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded text-[9px] md:text-[10px] font-black uppercase tracking-wider inline-block">
                                                    {{ $student->kode_kelas }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 text-[10px] md:text-xs font-bold italic">Belum Join Kelas</span>
                                            @endif
                                        </td>

                                        <td class="px-5 md:px-6 py-3 md:py-4 text-center">
                                            @if($student->jenis_kelamin == 'L' || $student->jenis_kelamin == 'Laki-Laki')
                                                <span class="text-indigo-600 text-[10px] md:text-xs font-black uppercase tracking-widest"><span class="mr-1">🚹</span> Laki-laki</span>
                                            @elseif($student->jenis_kelamin == 'P' || $student->jenis_kelamin == 'Perempuan')
                                                <span class="text-pink-600 text-[10px] md:text-xs font-black uppercase tracking-widest"><span class="mr-1">🚺</span> Perempuan</span>
                                            @else
                                                <span class="text-slate-400 text-xs font-bold">-</span>
                                            @endif
                                        </td>

                                        <td class="px-5 md:px-6 py-3 md:py-4 text-center">
                                            <!-- Tombol HANYA view, tanpa tab baru -->
                                            <a href="{{ route('admin.reports.print', $student->id) }}" class="inline-flex items-center justify-center gap-1.5 px-3 md:px-4 py-1.5 md:py-2 bg-slate-900 hover:bg-blue-600 text-white rounded-lg transition-all font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-md active:scale-95">
                                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat Rapor
                                            </a>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="text-4xl md:text-5xl opacity-40 mb-3 grayscale">📁</span>
                                                <p class="text-xs md:text-sm font-black text-slate-500 uppercase tracking-widest">Tidak Ada Data</p>
                                                <p class="text-[10px] md:text-xs font-bold text-slate-400 mt-1">Tidak ada mahasiswa yang sesuai dengan filter pencarian.</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(typeof gsap !== 'undefined') {
                gsap.fromTo(".gsap-fade", { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, stagger: 0.1, ease: "power2.out" });
            }
        });
    </script>
</body>
</html>
