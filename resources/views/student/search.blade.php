@extends('layouts.student')
@section('title', 'Pencarian Global | SMART-ECO')

@section('content')
<div class="max-w-[1440px] mx-auto pb-10 md:pb-20 font-sans text-slate-800 px-2 sm:px-4 lg:px-8">

    <!-- HERO SEARCH BANNER -->
    <div class="bg-gradient-to-br from-[#0a2540] via-[#0f4a8a] to-[#047857] rounded-2xl md:rounded-[3rem] p-6 md:p-12 text-white relative overflow-hidden shadow-2xl mb-8 md:mb-12 gsap-header border-2 md:border-4 border-white/10">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="absolute right-0 top-0 w-64 md:w-96 h-64 md:h-96 bg-emerald-400/20 blur-[80px] md:blur-[100px] rounded-full pointer-events-none"></div>
        <div class="absolute left-0 bottom-0 w-48 md:w-80 h-48 md:h-80 bg-cyan-500/20 blur-[80px] md:blur-[100px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col items-center text-center max-w-2xl mx-auto">
            <div class="w-12 h-12 md:w-16 md:h-16 bg-white/10 backdrop-blur-md rounded-xl md:rounded-2xl flex items-center justify-center text-2xl md:text-3xl mb-4 md:mb-6 shadow-inner border border-white/20">
                🔍
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-5xl font-black tracking-tight mb-4 md:mb-8 uppercase">
                Pencarian <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-300">Global</span>
            </h1>

            <!-- FORM PENCARIAN -->
            <form action="{{ route('student.search') }}" method="GET" class="w-full relative group flex items-center">
                <svg class="w-5 h-5 md:w-6 md:h-6 absolute left-4 md:left-6 text-emerald-200 group-focus-within:text-emerald-400 transition-colors pointer-events-none z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>

                <input type="text" name="q" value="{{ $query }}" required autocomplete="off"
                       class="w-full pl-12 md:pl-16 pr-14 md:pr-28 py-3.5 md:py-5 bg-white/10 backdrop-blur-xl border-2 border-white/20 hover:border-white/40 rounded-full text-white placeholder:text-emerald-100/60 text-sm md:text-lg font-bold outline-none focus:border-emerald-400 focus:bg-white/20 transition-all shadow-lg"
                       placeholder="Cari materi, tugas, simulasi, kelas...">

                <button type="submit" class="absolute right-2 md:right-3 bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-slate-900 w-10 h-10 md:w-auto md:px-8 md:py-3 rounded-full flex items-center justify-center font-black text-[10px] md:text-xs uppercase tracking-widest transition-all active:scale-95 shadow-md">
                    <span class="hidden md:inline">Telusuri</span>
                    <svg class="w-4 h-4 md:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </form>
        </div>
    </div>

    <!-- HASIL PENCARIAN -->
    @if($query)
        <div class="mb-6 md:mb-10 flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-1 md:px-2 gsap-fade">
            <h2 class="text-lg md:text-2xl font-black text-slate-800 leading-tight">
                Menampilkan hasil untuk: <br class="sm:hidden"><span class="text-emerald-600">"{{ $query }}"</span>
            </h2>
            <span class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-3 py-1.5 md:px-4 md:py-2 rounded-lg md:rounded-xl text-[10px] md:text-xs font-black tracking-widest uppercase shrink-0 shadow-sm">
                {{ $totalResults }} Ditemukan
            </span>
        </div>

        @if($totalResults > 0)
            <div class="space-y-8 md:space-y-12">

                <!-- 1. RUANG KELAS -->
                @if($classrooms->count() > 0)
                <div class="gsap-section">
                    <h3 class="text-[11px] md:text-sm font-black text-slate-400 uppercase tracking-widest mb-3 md:mb-5 flex items-center gap-2 px-1">
                        <span class="text-lg md:text-xl">🏫</span> Ruang Kelas
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                        @foreach($classrooms as $class)
                        <a href="{{ route('student.proyek.show', $class->id) }}" class="bg-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-emerald-400 hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 md:gap-4 group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-emerald-50 text-emerald-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl group-hover:scale-110 group-hover:bg-emerald-100 transition-all shrink-0">🎓</div>
                            <div class="overflow-hidden flex-1">
                                <h4 class="font-black text-slate-800 text-xs md:text-sm truncate group-hover:text-emerald-600 transition-colors uppercase">{{ $class->name }}</h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 mt-1 truncate">{{ $class->subject ?? 'Kelas Umum' }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- 2. MODUL & MATERI -->
                @if($assessments->count() > 0)
                <div class="gsap-section">
                    <h3 class="text-[11px] md:text-sm font-black text-slate-400 uppercase tracking-widest mb-3 md:mb-5 flex items-center gap-2 px-1">
                        <span class="text-lg md:text-xl">📚</span> Modul & Evaluasi
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                        @foreach($assessments as $assessment)
                        <a href="{{ route('student.modul.read', $assessment->id) }}" class="bg-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-blue-400 hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 md:gap-4 group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-50 text-blue-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl group-hover:scale-110 group-hover:bg-blue-100 transition-all shrink-0">📄</div>
                            <div class="overflow-hidden flex-1">
                                <h4 class="font-black text-slate-800 text-xs md:text-sm truncate group-hover:text-blue-600 transition-colors uppercase">{{ $assessment->module->title ?? $assessment->title }}</h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 mt-1 truncate">Misi: {{ $assessment->title }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- 3. TUGAS & PROYEK -->
                @if($assignments->count() > 0)
                <div class="gsap-section">
                    <h3 class="text-[11px] md:text-sm font-black text-slate-400 uppercase tracking-widest mb-3 md:mb-5 flex items-center gap-2 px-1">
                        <span class="text-lg md:text-xl">📋</span> Tugas & Proyek
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                        @foreach($assignments as $assignment)
                        <a href="{{ route('student.proyek.assignment', $assignment->id) }}" class="bg-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-amber-400 hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 md:gap-4 group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-amber-50 text-amber-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl group-hover:scale-110 group-hover:bg-amber-100 transition-all shrink-0">📝</div>
                            <div class="overflow-hidden flex-1">
                                <h4 class="font-black text-slate-800 text-xs md:text-sm truncate group-hover:text-amber-600 transition-colors uppercase">{{ $assignment->title }}</h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 mt-1 truncate">{{ $assignment->classroom->name ?? 'Tugas Kelas Umum' }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- 4. VIDEO PEMBELAJARAN -->
                @if($videoModules->count() > 0)
                <div class="gsap-section">
                    <h3 class="text-[11px] md:text-sm font-black text-slate-400 uppercase tracking-widest mb-3 md:mb-5 flex items-center gap-2 px-1">
                        <span class="text-lg md:text-xl">🎥</span> Video Pembelajaran
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                        @foreach($videoModules as $video)
                        <a href="{{ route('student.video') }}" class="bg-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-rose-400 hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 md:gap-4 group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-rose-50 text-rose-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl group-hover:scale-110 group-hover:bg-rose-100 transition-all shrink-0">▶️</div>
                            <div class="overflow-hidden flex-1">
                                <h4 class="font-black text-slate-800 text-xs md:text-sm truncate group-hover:text-rose-600 transition-colors uppercase">{{ $video->title }}</h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 mt-1 truncate">{{ $video->category ?? 'Video Materi' }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- 5. SIMULASI INTERAKTIF -->
                @if($simulations->count() > 0)
                <div class="gsap-section">
                    <h3 class="text-[11px] md:text-sm font-black text-slate-400 uppercase tracking-widest mb-3 md:mb-5 flex items-center gap-2 px-1">
                        <span class="text-lg md:text-xl">🎮</span> Simulasi Interaktif
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6">
                        @foreach($simulations as $sim)
                        <a href="{{ route('student.simulasi') }}" class="bg-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:border-purple-400 hover:-translate-y-1 transition-all duration-300 flex items-center gap-3 md:gap-4 group">
                            <div class="w-12 h-12 md:w-14 md:h-14 bg-purple-50 text-purple-600 rounded-xl md:rounded-2xl flex items-center justify-center text-xl md:text-2xl group-hover:scale-110 group-hover:bg-purple-100 transition-all shrink-0">🔬</div>
                            <div class="overflow-hidden flex-1">
                                <h4 class="font-black text-slate-800 text-xs md:text-sm truncate group-hover:text-purple-600 transition-colors uppercase">{{ $sim->title }}</h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 mt-1 truncate">Lab Virtual Terpadu</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        @else
            <!-- PENCARIAN KOSONG -->
            <div class="bg-white border-2 border-dashed border-slate-300 rounded-3xl md:rounded-[3rem] p-10 md:p-16 text-center gsap-fade shadow-sm">
                <div class="text-6xl md:text-7xl mb-4 md:mb-6 opacity-50 grayscale drop-shadow-sm">🛸</div>
                <h3 class="text-xl md:text-3xl font-black text-slate-800 tracking-tight mb-2 md:mb-3">Tidak Ada Hasil</h3>
                <p class="text-xs md:text-base font-medium text-slate-500 max-w-lg mx-auto leading-relaxed">
                    Sistem tidak menemukan materi, tugas, atau kelas dengan kata kunci "<span class="font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded">{{ $query }}</span>". Coba gunakan kata kunci yang lebih umum.
                </p>
            </div>
        @endif

    @else
        <!-- BELUM MENCARI -->
        <div class="text-center py-16 md:py-24 gsap-fade">
            <div class="w-20 h-20 md:w-24 md:h-24 mx-auto bg-slate-200/50 rounded-full flex items-center justify-center mb-6 text-4xl grayscale opacity-50">⌨️</div>
            <p class="text-slate-400 font-black uppercase tracking-widest text-[10px] md:text-xs">Ketik kata kunci di atas dan mulai pencarian</p>
        </div>
    @endif

</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if(typeof gsap !== 'undefined') {
            gsap.from(".gsap-header", { y: -30, opacity: 0, duration: 0.8, ease: "power3.out" });
            gsap.from(".gsap-fade", { y: 20, opacity: 0, duration: 0.6, delay: 0.2, ease: "power2.out" });
            gsap.from(".gsap-section", { y: 30, opacity: 0, duration: 0.6, stagger: 0.15, ease: "back.out(1.2)", delay: 0.3 });
        }
    });
</script>
@endsection
