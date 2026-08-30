<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detail Kelas: {{ $classroom->name }} | SMART-ECO</title>

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

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex flex-col overflow-hidden w-full" x-data="{ tab: 'tugas', openCreate: false, sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden relative w-full">

        <!-- OVERLAY SIDEBAR MOBILE -->
        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <!-- SIDEBAR -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-100">

            <!-- HEADER KECIL -->
            <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
                <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate">
                        <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Dashboard <span class="text-emerald-600">Kelas</span></h1>
                    </div>
                </div>
            </header>

            <!-- KONTEN SCROLLABLE -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-10 custom-scrollbar w-full relative z-10 pb-20">
                <div class="max-w-[1400px] mx-auto w-full space-y-6 md:space-y-8">

                    <!-- TOMBOL KEMBALI -->
                    <a href="{{ route('admin.classrooms.index') }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border-2 border-slate-200 rounded-lg text-[10px] md:text-xs font-bold text-slate-600 hover:text-emerald-700 hover:border-emerald-300 hover:bg-emerald-50 transition-all shadow-sm w-fit active:scale-95 gsap-fade">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Kelas
                    </a>

                    <!-- HERO BANNER SOLID -->
                    <div class="bg-slate-900 rounded-2xl md:rounded-[2.5rem] p-6 md:p-10 text-white shadow-xl border-b-4 border-emerald-500 relative overflow-hidden gsap-header w-full">
                        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 md:gap-8">
                            <div class="flex-1 w-full min-w-0">
                                <div class="inline-flex items-center gap-2 px-3 md:px-4 py-1.5 bg-slate-800 rounded-lg border border-slate-700 text-emerald-400 text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-4 shadow-inner">
                                    KODE AKSES: <span class="text-white text-xs md:text-sm ml-1 select-all tracking-[0.2em]">{{ $classroom->code }}</span>
                                </div>
                                <h1 class="text-2xl sm:text-4xl md:text-5xl font-black tracking-tight mb-2 uppercase drop-shadow-md leading-tight line-clamp-2">{{ $classroom->name }}</h1>
                                <p class="text-emerald-400 font-bold tracking-widest text-[10px] md:text-sm uppercase mb-3 md:mb-4">{{ $classroom->subject ?? 'Kelas Umum' }}</p>
                                <p class="text-slate-300 text-[11px] md:text-sm max-w-2xl leading-relaxed line-clamp-3">{{ $classroom->description ?? 'Tidak ada deskripsi untuk kelas ini.' }}</p>
                            </div>

                            <div class="flex flex-row md:flex-col gap-3 md:gap-4 shrink-0 w-full md:w-auto">
                                <div class="flex-1 md:flex-none bg-slate-800 px-4 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl border border-slate-700 text-center shadow-md">
                                    <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-1">Total Mahasiswa</p>
                                    <p class="text-2xl md:text-3xl font-black text-white">{{ $classroom->students->count() }}<span class="text-[10px] md:text-xs text-slate-400 ml-1">org</span></p>
                                </div>
                                <div class="flex-1 md:flex-none bg-slate-800 px-4 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl border border-slate-700 text-center shadow-md">
                                    <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-1">Total Tugas</p>
                                    <p class="text-2xl md:text-3xl font-black text-white">{{ $classroom->assignments->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-emerald-50 border-2 border-emerald-200 p-3 md:p-4 rounded-xl md:rounded-2xl flex items-center gap-3 text-emerald-800 font-bold text-xs md:text-sm shadow-sm animate-fade-in-up">
                            <span class="w-6 h-6 md:w-8 md:h-8 bg-emerald-600 text-white rounded-md md:rounded-lg flex items-center justify-center shrink-0">✓</span>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- TAB MENU -->
                    <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-2 px-1 snap-x gsap-fade w-full">
                        <button @click="tab = 'tugas'" :class="tab === 'tugas' ? 'bg-emerald-600 text-white shadow-md border-emerald-700' : 'bg-white text-slate-500 hover:bg-slate-100 border-slate-200'" class="px-5 md:px-8 py-2.5 md:py-3 rounded-xl md:rounded-2xl border-2 font-black text-[10px] md:text-xs uppercase tracking-widest transition-all shrink-0 snap-start">
                            📝 Daftar Tugas & Proyek
                        </button>
                        <button @click="tab = 'siswa'" :class="tab === 'siswa' ? 'bg-emerald-600 text-white shadow-md border-emerald-700' : 'bg-white text-slate-500 hover:bg-slate-100 border-slate-200'" class="px-5 md:px-8 py-2.5 md:py-3 rounded-xl md:rounded-2xl border-2 font-black text-[10px] md:text-xs uppercase tracking-widest transition-all shrink-0 snap-start">
                            👥 Anggota Kelas ({{ $classroom->students->count() }})
                        </button>
                    </div>

                    <!-- TAB KONTEN TUGAS -->
                    <div x-show="tab === 'tugas'" x-cloak class="space-y-4 md:space-y-6 w-full">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-4 md:p-6 rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm gsap-item w-full">
                            <div>
                                <h2 class="text-base md:text-xl font-black text-slate-900 uppercase tracking-tight">Tugas Kelas</h2>
                                <p class="text-[10px] md:text-xs font-bold text-slate-500 mt-1">Berikan instruksi proyek atau tugas untuk mahasiswa.</p>
                            </div>
                            <button @click="openCreate = true" class="w-full sm:w-auto bg-slate-900 hover:bg-emerald-600 text-white px-5 md:px-6 py-3 md:py-3.5 rounded-xl font-black text-[10px] md:text-xs uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2 shrink-0 border border-slate-800 hover:border-emerald-700">
                                <div class="w-5 h-5 md:w-6 md:h-6 bg-white/20 rounded-md flex items-center justify-center text-sm">➕</div>
                                Buat Tugas Baru
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-4 w-full">
                            @forelse($classroom->assignments as $assignment)
                            <div x-data="{ openEdit: false }" class="bg-white p-4 md:p-6 rounded-2xl md:rounded-[2rem] border-2 border-slate-200 hover:border-emerald-500 hover:shadow-lg transition-all duration-300 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-6 group gsap-item w-full">

                                <div class="flex items-start gap-3 md:gap-5 flex-1 w-full cursor-pointer min-w-0" onclick="window.location='{{ route('admin.classrooms.assignment.show', $assignment->id) }}'">
                                    <div class="w-10 h-10 md:w-14 md:h-14 bg-slate-100 text-slate-500 border-2 border-slate-200 rounded-xl md:rounded-2xl flex items-center justify-center text-lg md:text-2xl shrink-0 group-hover:bg-emerald-50 group-hover:border-emerald-200 group-hover:text-emerald-600 transition-colors">
                                        📁
                                    </div>
                                    <div class="overflow-hidden flex-1 min-w-0 pt-0.5">
                                        <h3 class="text-sm md:text-lg font-black text-slate-900 uppercase tracking-tight group-hover:text-emerald-700 transition-colors truncate">{{ $assignment->title }}</h3>
                                        <div class="flex flex-wrap items-center gap-2 md:gap-3 mt-1.5 md:mt-2 text-[9px] md:text-[10px] font-black uppercase tracking-widest">
                                            <span class="text-slate-500 bg-slate-100 px-2 py-0.5 rounded">📅 Post: {{ $assignment->created_at->format('d M') }}</span>
                                            @if($assignment->due_date)
                                                <span class="text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-200">⏳ Tenggat: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M, H:i') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full md:w-auto flex items-center gap-2 shrink-0 border-t border-slate-100 md:border-0 pt-3 md:pt-0 mt-1 md:mt-0">
                                    <button @click="openEdit = true" class="p-2 md:p-3 bg-white border-2 border-slate-200 text-slate-500 hover:border-amber-500 hover:bg-amber-50 hover:text-amber-600 rounded-xl transition-all shadow-sm active:scale-95" title="Edit Tugas">
                                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <a href="{{ route('admin.classrooms.assignment.show', $assignment->id) }}" class="flex-1 md:flex-none bg-slate-800 text-white hover:bg-emerald-600 px-4 md:px-6 py-2.5 md:py-3.5 rounded-xl font-black text-[9px] md:text-[10px] uppercase tracking-widest text-center transition-colors shadow-sm active:scale-95 flex items-center justify-center gap-1.5">
                                        Nilai <span class="hidden sm:inline">Tugas</span> &rarr;
                                    </a>
                                </div>

                                <!-- MODAL EDIT TUGAS -->
                                <div x-show="openEdit" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-3 md:p-4 bg-slate-900/80 w-screen h-[100dvh] overflow-hidden">
                                    <div @click.away="openEdit = false" class="bg-white w-full max-w-2xl rounded-2xl md:rounded-[2.5rem] shadow-2xl p-5 md:p-8 border-2 border-slate-200 flex flex-col max-h-[90vh]">

                                        <div class="flex justify-between items-center mb-5 md:mb-6 border-b-2 border-slate-100 pb-4 shrink-0">
                                            <div class="flex items-center gap-3">
                                                <span class="p-2 md:p-3 bg-amber-100 text-amber-600 rounded-xl text-sm md:text-xl border border-amber-200">✏️</span>
                                                <h2 class="text-sm md:text-xl font-black uppercase tracking-tight text-slate-900">Edit Tugas</h2>
                                            </div>
                                            <button @click="openEdit = false" class="w-8 h-8 md:w-10 md:h-10 bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-500 rounded-lg md:rounded-xl flex items-center justify-center text-lg md:text-xl font-black transition-colors shrink-0">&times;</button>
                                        </div>

                                        <div class="flex-1 overflow-y-auto custom-scrollbar pr-1 md:pr-2">
                                            <form action="{{ route('admin.classrooms.assignment.update', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6 text-left" x-data="{ fileName: '' }">
                                                @csrf @method('PUT')
                                                <div>
                                                    <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Judul Tugas / Proyek</label>
                                                    <input type="text" name="title" value="{{ $assignment->title }}" required class="w-full px-4 py-3 md:px-5 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-amber-500 outline-none transition-all shadow-sm">
                                                </div>

                                                <div>
                                                    <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Deskripsi & Instruksi</label>
                                                    <textarea name="description" rows="4" required class="w-full px-4 py-3 md:px-5 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-amber-500 outline-none transition-all resize-none shadow-sm">{{ $assignment->description }}</textarea>
                                                </div>

                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                                                    <div>
                                                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Tenggat (Deadline)</label>
                                                        <input type="datetime-local" name="due_date" value="{{ $assignment->due_date ? date('Y-m-d\TH:i', strtotime($assignment->due_date)) : '' }}" class="w-full px-4 py-3 md:px-5 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-amber-500 outline-none transition-all shadow-sm">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Ganti Lampiran (Opsional)</label>
                                                        <div class="relative group cursor-pointer h-[46px] md:h-[54px]">
                                                            <input type="file" name="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="fileName = $event.target.files[0].name">
                                                            <div x-show="!fileName" class="w-full h-full px-4 md:px-5 flex items-center justify-center gap-2 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl md:rounded-2xl group-hover:border-amber-500 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest transition-all">
                                                                📎 Ganti File
                                                            </div>
                                                            <div x-show="fileName" x-cloak class="w-full h-full px-4 md:px-5 flex items-center justify-center bg-amber-50 border-2 border-amber-400 rounded-xl md:rounded-2xl text-[9px] md:text-[10px] font-black text-amber-700 uppercase tracking-widest truncate" x-text="fileName"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="pt-2 md:pt-4">
                                                    <button type="submit" class="w-full py-3 md:py-3.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl md:rounded-2xl font-black uppercase tracking-widest text-[10px] md:text-[11px] transition-all shadow-md active:scale-95">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="py-12 md:py-20 text-center bg-white rounded-2xl md:rounded-[3rem] border-2 border-dashed border-slate-300 shadow-sm gsap-item w-full">
                                <span class="text-5xl md:text-6xl block mb-3 md:mb-4 grayscale opacity-30">📝</span>
                                <h3 class="text-sm md:text-xl font-black text-slate-500 uppercase tracking-widest">Belum Ada Tugas</h3>
                                <p class="text-[10px] md:text-xs font-bold text-slate-400 mt-1">Klik tombol Buat Tugas Baru untuk memulai.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- TAB KONTEN SISWA -->
                    <div x-show="tab === 'siswa'" x-cloak class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 w-full">
                        @forelse($classroom->students as $student)
                        <div class="bg-white p-4 md:p-6 rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm hover:shadow-lg hover:border-emerald-400 transition-all flex items-center gap-4 gsap-item group w-full">
                            <div class="w-10 h-10 md:w-14 md:h-14 rounded-xl md:rounded-2xl bg-slate-900 text-white flex items-center justify-center text-lg md:text-xl font-black shadow-inner shrink-0 border border-slate-700 group-hover:bg-emerald-600 group-hover:border-emerald-500 transition-colors">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden flex-1 min-w-0">
                                <h4 class="text-xs md:text-sm font-black text-slate-900 uppercase truncate group-hover:text-emerald-700 transition-colors">{{ $student->name }}</h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5 truncate">{{ $student->email }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-16 md:py-20 text-center bg-white rounded-2xl md:rounded-[3rem] border-2 border-dashed border-slate-300 shadow-sm gsap-item w-full">
                            <span class="text-5xl md:text-6xl block mb-3 md:mb-4 grayscale opacity-30">👻</span>
                            <h3 class="text-sm md:text-xl font-black text-slate-500 uppercase tracking-widest">Kelas Masih Kosong</h3>
                            <p class="text-[10px] md:text-xs font-bold text-slate-400 mt-1">Siswa belum ada yang bergabung menggunakan kode kelas ini.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- MODAL CREATE TUGAS -->
    <div x-show="openCreate" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-3 md:p-4 bg-slate-900/80 w-screen h-[100dvh] overflow-hidden">
        <div @click.away="openCreate = false" class="bg-white w-full max-w-2xl rounded-2xl md:rounded-[2.5rem] shadow-2xl p-5 md:p-8 border-2 border-slate-200 flex flex-col max-h-[90vh]">

            <div class="flex justify-between items-center mb-5 md:mb-6 border-b-2 border-slate-100 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <span class="p-2.5 md:p-3 bg-emerald-100 text-emerald-600 rounded-xl text-sm md:text-xl border border-emerald-200">➕</span>
                    <h2 class="text-sm md:text-2xl font-black text-slate-900 uppercase tracking-tight">Buat Tugas Baru</h2>
                </div>
                <button @click="openCreate = false" class="w-8 h-8 md:w-10 md:h-10 bg-slate-100 hover:bg-rose-100 text-slate-500 hover:text-rose-500 rounded-lg md:rounded-xl flex items-center justify-center text-lg md:text-xl font-black transition-colors shrink-0">&times;</button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-1 md:pr-2">
                <form action="{{ route('admin.classrooms.assignment.store', $classroom->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-5" x-data="{ fileName: '' }">
                    @csrf
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Judul Tugas / Proyek</label>
                        <input type="text" name="title" required class="w-full px-4 py-3 md:px-5 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-emerald-600 outline-none transition-all placeholder:text-slate-400 shadow-sm" placeholder="Contoh: Laporan Observasi Lingkungan">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Deskripsi & Instruksi</label>
                        <textarea name="description" rows="4" required class="w-full px-4 py-3 md:px-5 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-emerald-600 outline-none transition-all placeholder:text-slate-400 resize-none shadow-sm" placeholder="Jelaskan instruksi tugas di sini..."></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-5">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Tenggat (Deadline)</label>
                            <input type="datetime-local" name="due_date" class="w-full px-4 py-3 md:px-5 md:py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs md:text-sm font-bold text-slate-800 focus:bg-white focus:border-emerald-600 outline-none transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Lampiran Dokumen (Opsional)</label>
                            <div class="relative group cursor-pointer h-[46px] md:h-[54px]">
                                <input type="file" name="attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="fileName = $event.target.files[0].name">
                                <div x-show="!fileName" class="w-full h-full px-4 md:px-5 flex items-center justify-center bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl md:rounded-2xl group-hover:border-emerald-500 text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest transition-all">📎 Pilih File PDF/Doc</div>
                                <div x-show="fileName" x-cloak class="w-full h-full px-4 md:px-5 flex items-center justify-center bg-emerald-50 border-2 border-emerald-400 rounded-xl md:rounded-2xl text-[9px] md:text-[10px] font-black text-emerald-700 uppercase truncate" x-text="fileName"></div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 md:pt-4">
                        <button type="submit" class="w-full py-3.5 md:py-4 bg-emerald-600 text-white rounded-xl md:rounded-2xl font-black uppercase tracking-widest text-[10px] md:text-[11px] hover:bg-emerald-700 transition-all shadow-md active:scale-95 border border-emerald-700">Publikasikan Tugas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(typeof gsap !== 'undefined') {
                gsap.from(".gsap-fade", { y: -10, opacity: 0, duration: 0.5, ease: "power2.out" });
                gsap.from(".gsap-header", { scale: 0.98, opacity: 0, duration: 0.6, ease: "power2.out" });
                gsap.from(".gsap-item", { y: 20, opacity: 0, duration: 0.4, stagger: 0.1, ease: "power2.out", delay: 0.2 });
            }
        });
    </script>
</body>
</html>
