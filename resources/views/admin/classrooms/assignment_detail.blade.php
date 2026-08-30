<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Penilaian Tugas: {{ $assignment->title }} | SMART-ECO</title>

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

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex flex-col overflow-hidden w-full" x-data="{ sidebarOpen: false }">

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
            <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
                <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate">
                        <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Penilaian <span class="text-emerald-600">Tugas</span></h1>
                    </div>
                </div>
            </header>

            <!-- KONTEN SCROLLABLE -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-10 custom-scrollbar w-full relative z-10 pb-20">
                <div class="max-w-[1200px] mx-auto w-full space-y-6 md:space-y-8">

                    <!-- TOMBOL KEMBALI -->
                    <a href="{{ route('admin.classrooms.show', $assignment->classroom_id) }}" class="inline-flex items-center gap-1.5 md:gap-2 px-3 py-1.5 bg-white border-2 border-slate-200 rounded-lg text-[10px] md:text-xs font-bold text-slate-600 hover:text-emerald-700 hover:border-emerald-300 hover:bg-emerald-50 transition-all shadow-sm w-fit active:scale-95 gsap-fade">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Kelas
                    </a>

                    <!-- HERO BANNER TUGAS -->
                    <div class="bg-slate-900 rounded-2xl md:rounded-[2.5rem] p-6 md:p-10 text-white shadow-xl border-b-4 border-indigo-500 relative overflow-hidden gsap-header w-full">
                        <div class="absolute -left-20 -bottom-20 w-64 md:w-80 h-64 md:h-80 bg-emerald-500/20 blur-[80px] md:blur-[90px] rounded-full pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 md:gap-8">
                            <div class="flex-1 w-full min-w-0">
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-800 rounded-lg border border-slate-700 text-emerald-400 text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-4 shadow-sm truncate max-w-full">
                                    TUGAS KELAS: {{ $assignment->classroom->name }}
                                </div>
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black tracking-tight mb-3 uppercase drop-shadow-md leading-tight line-clamp-2">{{ $assignment->title }}</h1>

                                <div class="flex flex-wrap items-center gap-2 md:gap-3 mt-3 text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-300">
                                    <span class="flex items-center gap-1 bg-white/10 px-2.5 py-1 rounded border border-white/10"><svg class="w-3 h-3 md:w-4 md:h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> Dibuat: {{ $assignment->created_at->format('d M Y') }}</span>
                                    @if($assignment->due_date)
                                        <span class="text-rose-300 flex items-center gap-1 bg-rose-500/20 px-2.5 py-1 rounded border border-rose-500/30"><svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Tenggat: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-row md:flex-col gap-3 md:gap-4 shrink-0 w-full md:w-auto">
                                <div class="flex-1 md:flex-none bg-slate-800 px-5 md:px-6 py-3 md:py-4 rounded-xl md:rounded-2xl border border-slate-700 text-center shadow-md">
                                    <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-emerald-400 mb-0.5 md:mb-1">Terkumpul</p>
                                    <p class="text-2xl md:text-3xl font-black text-white">{{ $assignment->submissions->count() }} <span class="text-[10px] md:text-xs text-slate-400 font-bold ml-1">dari {{ $assignment->classroom->students->count() }}</span></p>
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

                    <div class="flex items-center gap-2 md:gap-3 mb-4 md:mb-6 gsap-fade border-b-2 border-slate-200 pb-3">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-600 text-white rounded-lg md:rounded-xl flex items-center justify-center font-black text-sm md:text-xl shadow-sm shrink-0">📥</div>
                        <h2 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight uppercase">Daftar Pengumpulan</h2>
                    </div>

                    <div class="space-y-4 w-full">
                        @forelse($assignment->submissions as $submission)
                        <div x-data="{ openGrade: false }" class="bg-white p-4 md:p-6 rounded-2xl md:rounded-[2rem] border-2 border-slate-200 hover:border-indigo-400 hover:shadow-lg transition-all duration-300 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 md:gap-6 group gsap-item w-full">

                            <div class="flex items-start gap-3 md:gap-5 flex-1 w-full min-w-0">
                                <div class="w-10 h-10 md:w-14 md:h-14 bg-slate-900 text-white border-2 border-slate-700 rounded-xl md:rounded-2xl flex items-center justify-center text-lg md:text-xl font-black shrink-0 shadow-sm group-hover:bg-indigo-600 group-hover:border-indigo-500 transition-colors">
                                    {{ substr($submission->student->name, 0, 1) }}
                                </div>
                                <div class="flex-1 overflow-hidden min-w-0">
                                    <h3 class="text-sm md:text-lg font-black text-slate-900 uppercase tracking-tight truncate group-hover:text-indigo-700 transition-colors">{{ $submission->student->name }}</h3>
                                    <p class="text-[9px] md:text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5 truncate">{{ $submission->student->email }}</p>

                                    @if($submission->file_path)
                                    <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 md:gap-2 mt-2.5 md:mt-3 px-3 py-1.5 md:px-4 md:py-2 bg-slate-50 border-2 border-slate-200 rounded-lg md:rounded-xl hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700 transition-colors text-[10px] md:text-xs font-black text-slate-600 shadow-sm">
                                        📎 Buka File Tugas
                                    </a>
                                    @else
                                    <span class="inline-block mt-2.5 md:mt-3 px-2 md:px-3 py-1 md:py-1.5 bg-rose-50 text-rose-600 text-[8px] md:text-[9px] font-black uppercase tracking-widest rounded-md border border-rose-200">
                                        Hanya Kirim Teks
                                    </span>
                                    @endif

                                    @if($submission->student_comment)
                                    <div class="mt-2.5 md:mt-3 p-3 bg-slate-50 border border-slate-200 rounded-xl text-[10px] md:text-xs font-bold text-slate-600 italic">
                                        "{{ $submission->student_comment }}"
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="w-full md:w-auto flex flex-row md:flex-col md:items-end justify-between md:justify-center gap-3 md:gap-2 shrink-0 border-t border-slate-100 md:border-t-0 pt-4 md:pt-0">
                                @if($submission->grade !== null)
                                    <div class="text-left md:text-right">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-emerald-600 mb-0.5">Sudah Dinilai</p>
                                        <p class="text-2xl md:text-3xl font-black text-slate-900 leading-none">{{ $submission->grade }}<span class="text-xs md:text-sm text-slate-400">/100</span></p>
                                    </div>
                                    <button @click="openGrade = true" class="bg-white border-2 border-slate-200 text-slate-600 hover:border-indigo-600 hover:bg-indigo-50 hover:text-indigo-700 px-4 py-2 md:px-5 md:py-2.5 rounded-lg md:rounded-xl font-black text-[9px] md:text-[10px] uppercase tracking-widest text-center transition-all shadow-sm active:scale-95 shrink-0">
                                        Revisi Nilai
                                    </button>
                                @else
                                    <div class="text-left md:text-right">
                                        <p class="text-[9px] font-black uppercase tracking-widest text-rose-500 mb-0.5">Status</p>
                                        <p class="text-[10px] md:text-sm font-black text-slate-700 leading-none uppercase tracking-wider">Menunggu Nilai</p>
                                    </div>
                                    <button @click="openGrade = true" class="bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2 md:px-5 md:py-2.5 rounded-lg md:rounded-xl font-black text-[9px] md:text-[10px] uppercase tracking-widest text-center transition-all shadow-md active:scale-95 shrink-0 border border-indigo-700">
                                        Beri Nilai
                                    </button>
                                @endif
                            </div>

                            <!-- MODAL PENILAIAN -->
                            <div x-show="openGrade" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 w-screen h-[100dvh] overflow-hidden">
                                <div @click.away="openGrade = false" class="bg-white w-full max-w-md rounded-2xl md:rounded-[2.5rem] shadow-2xl p-6 md:p-8 border-2 border-slate-200 flex flex-col max-h-[90vh]">

                                    <div class="flex justify-between items-center mb-5 md:mb-6 border-b-2 border-slate-100 pb-4 shrink-0">
                                        <h2 class="text-lg md:text-xl font-black text-slate-900 uppercase tracking-tight flex items-center gap-2">
                                            <span class="p-2 bg-indigo-100 text-indigo-600 rounded-lg text-sm border border-indigo-200">📝</span> Penilaian
                                        </h2>
                                        <button @click="openGrade = false" class="text-slate-400 hover:text-rose-500 bg-slate-100 hover:bg-rose-100 p-1.5 md:p-2 rounded-lg md:rounded-xl transition-all border border-transparent hover:border-rose-200">
                                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>

                                    <div class="flex-1 overflow-y-auto custom-scrollbar pr-1 md:pr-2">
                                        <div class="flex items-center gap-3 p-3 md:p-4 bg-slate-50 rounded-xl md:rounded-2xl border-2 border-slate-200 mb-5 md:mb-6">
                                            <div class="w-8 h-8 md:w-10 md:h-10 bg-slate-900 text-white rounded-lg md:rounded-xl flex items-center justify-center font-black text-sm">
                                                {{ substr($submission->student->name, 0, 1) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-0.5">Mahasiswa</p>
                                                <p class="text-xs md:text-sm font-bold text-slate-900 truncate">{{ $submission->student->name }}</p>
                                            </div>
                                        </div>

                                        <form action="{{ route('admin.classrooms.grade', $submission->id) }}" method="POST" class="space-y-4 md:space-y-5">
                                            @csrf
                                            <div>
                                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Nilai (0 - 100)</label>
                                                <input type="number" name="grade" min="0" max="100" value="{{ $submission->grade }}" required class="w-full text-center text-2xl md:text-3xl font-black py-3 md:py-4 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl focus:bg-white focus:border-indigo-500 outline-none transition-all placeholder:text-slate-300 shadow-inner" placeholder="0">
                                            </div>

                                            <div>
                                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Umpan Balik / Catatan Admin</label>
                                                <textarea name="admin_feedback" rows="3" class="w-full px-4 md:px-5 py-3 md:py-4 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl text-xs font-bold text-slate-800 focus:bg-white focus:border-indigo-500 outline-none transition-all placeholder:text-slate-400 resize-none shadow-inner" placeholder="Berikan komentar membangun atas tugas ini...">{{ $submission->admin_feedback }}</textarea>
                                            </div>

                                            <div class="pt-2">
                                                <button type="submit" class="w-full py-3.5 md:py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl md:rounded-2xl font-black uppercase tracking-widest text-[10px] md:text-[11px] transition-all shadow-md active:scale-95 border border-indigo-700">
                                                    Simpan Nilai
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-16 md:py-24 text-center bg-white rounded-2xl md:rounded-[3rem] border-2 border-dashed border-slate-300 shadow-sm gsap-item w-full">
                            <span class="text-5xl md:text-6xl block mb-3 md:mb-4 grayscale opacity-30">🛌</span>
                            <h3 class="text-sm md:text-lg font-black text-slate-800 uppercase tracking-widest">Belum Ada Pengumpulan</h3>
                            <p class="text-[10px] md:text-xs font-bold text-slate-500 mt-1 max-w-sm mx-auto px-4">Belum ada mahasiswa yang mengumpulkan tugas ini ke sistem.</p>
                        </div>
                        @endforelse
                    </div>

                </div>
            </main>
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
