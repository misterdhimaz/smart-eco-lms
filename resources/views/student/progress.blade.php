@extends('layouts.student')
@section('title', 'Progress Belajar Saya | SMART-ECO')

@section('content')
<div class="w-full pb-24 font-sans text-slate-800 overflow-x-hidden">

    <!-- HEADER PROFILE & XP -->
    <div class="relative bg-[#0f172a] rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-slate-800 mb-8 overflow-hidden gsap-fade">
        <div class="absolute -right-20 -top-20 w-96 h-96 bg-[#047857]/30 blur-[100px] rounded-full pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-blue-500/20 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
            <div class="relative shrink-0 group cursor-pointer">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-slate-700 bg-slate-800 p-2 overflow-hidden shadow-2xl relative z-10">
                    @if(isset($user->avatar) && $user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover rounded-full group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-[#047857] flex items-center justify-center text-5xl font-black text-white rounded-full group-hover:scale-110 transition-transform duration-500">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-gradient-to-r from-amber-400 to-orange-500 text-white px-5 py-1.5 rounded-full text-[11px] font-black uppercase tracking-widest border-2 border-[#0f172a] shadow-lg z-20 whitespace-nowrap">
                    ⭐ {{ $rank ?? 'Pemula' }}
                </div>
            </div>

            <div class="flex-1 w-full text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight mb-2">{{ $user->name ?? 'Mahasiswa' }}</h1>
                <p class="text-emerald-400 text-sm font-bold uppercase tracking-widest mb-6">Mahasiswa Level {{ $user->level ?? 1 }}</p>

                <div class="bg-slate-800/80 backdrop-blur-sm p-5 rounded-2xl border border-slate-700 shadow-sm">
                    <div class="flex justify-between items-end mb-3">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Total Experience (XP)</span>
                            <span class="text-2xl font-black text-white">{{ number_format($user->xp ?? 0) }} <span class="text-xs text-slate-500">/ {{ number_format($nextLevelXp ?? 100) }} XP</span></span>
                        </div>
                        <span class="text-sm font-black text-emerald-400">{{ round($levelPercentage ?? 0) }}%</span>
                    </div>
                    <div class="w-full bg-slate-900 rounded-full h-3 overflow-hidden border border-slate-700 shadow-inner">
                        <div class="bg-gradient-to-r from-blue-500 via-teal-400 to-[#34d399] h-full rounded-full relative gsap-xp-bar" style="width: {{ min($levelPercentage ?? 0, 100) }}%">
                            <div class="absolute top-0 left-0 bottom-0 right-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-[shimmer_2s_infinite]"></div>
                        </div>
                    </div>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-3 text-right">
                        Dapatkan {{ number_format(max(($nextLevelXp ?? 100) - ($user->xp ?? 0), 0)) }} XP lagi untuk naik ke Level {{ ($user->level ?? 1) + 1 }}!
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- STATS CARDS (Penyebab Masalah Sebelumnya Sudah Diperbaiki) -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-lg transition-shadow duration-300 gsap-stat-card">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-lg mb-3">📚</div>
            <p class="text-2xl font-black text-slate-800 mb-0.5 counter" data-target="{{ $stats['completed_modules'] ?? 0 }}">0</p>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Modul Tuntas</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-lg transition-shadow duration-300 gsap-stat-card">
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-lg mb-3">⏳</div>
            <p class="text-2xl font-black text-slate-800 mb-0.5 counter" data-target="{{ $stats['ongoing_modules'] ?? 0 }}">0</p>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Sedang Dipelajari</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-lg transition-shadow duration-300 gsap-stat-card">
            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-lg mb-3">🎯</div>
            <p class="text-2xl font-black text-slate-800 mb-0.5 counter" data-target="{{ $stats['completed_quizzes'] ?? 0 }}">0</p>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kuis Diselesaikan</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-lg transition-shadow duration-300 gsap-stat-card">
            <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-lg mb-3">📝</div>
            <p class="text-2xl font-black text-slate-800 mb-0.5 counter" data-target="{{ $stats['completed_tasks'] ?? 0 }}">0</p>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tugas Terkumpul</p>
        </div>
    </div>

    <!-- MAIN GRID: RECENT XP & MODULE PROGRESS -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- KOLOM KIRI: RIWAYAT PEROLEHAN XP -->
        <div class="lg:col-span-5 bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden gsap-slide-up">
            <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center bg-amber-50/30">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Riwayat XP</h2>
                    <p class="text-[11px] text-slate-500 font-medium mt-1">Aktivitas terakhir penghasil poin.</p>
                </div>
                <div class="w-10 h-10 bg-amber-100 text-amber-500 rounded-xl flex items-center justify-center text-xl shadow-inner shrink-0">
                    ⭐
                </div>
            </div>

            <div class="p-4 md:p-6">
                <div class="space-y-3">
                    @forelse($recentXpLogs ?? [
                        (object)['type' => 'latihan', 'title' => 'Menyelesaikan Latihan Soal Evaluasi', 'xp' => 15, 'created_at' => \Carbon\Carbon::now()->subMinutes(12)],
                        (object)['type' => 'game', 'title' => 'Bermain Games Edukasi', 'xp' => 20, 'created_at' => \Carbon\Carbon::now()->subHours(2)],
                        (object)['type' => 'video', 'title' => 'Menonton Video Pembelajaran', 'xp' => 10, 'created_at' => \Carbon\Carbon::now()->subDays(1)],
                        (object)['type' => 'modul', 'title' => 'Membaca Modul: Climate Change', 'xp' => 25, 'created_at' => \Carbon\Carbon::now()->subDays(2)],
                        (object)['type' => 'simulasi', 'title' => 'Praktek Simulasi Interaktif', 'xp' => 30, 'created_at' => \Carbon\Carbon::now()->subDays(3)]
                    ] as $log)

                        @php
                            $iconBg = 'bg-emerald-100'; $iconText = 'text-emerald-600'; $iconEmoji = '📖';
                            if($log->type == 'latihan') { $iconBg = 'bg-indigo-100'; $iconText = 'text-indigo-600'; $iconEmoji = '📝'; }
                            elseif($log->type == 'game') { $iconBg = 'bg-purple-100'; $iconText = 'text-purple-600'; $iconEmoji = '🎮'; }
                            elseif($log->type == 'video') { $iconBg = 'bg-rose-100'; $iconText = 'text-rose-600'; $iconEmoji = '▶️'; }
                            elseif($log->type == 'simulasi') { $iconBg = 'bg-cyan-100'; $iconText = 'text-cyan-600'; $iconEmoji = '💻'; }
                        @endphp

                        <div class="flex items-center gap-3 p-3 hover:bg-slate-50 rounded-xl transition-colors border border-transparent hover:border-slate-100">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0 {{ $iconBg }} {{ $iconText }}">
                                {{ $iconEmoji }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-xs font-bold text-slate-800 truncate">{{ $log->title }}</h4>
                                <p class="text-[10px] text-slate-500 mt-0.5">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</p>
                            </div>
                            <div class="shrink-0 flex items-center gap-1 bg-amber-50 border border-amber-200 text-amber-600 px-2 py-1 rounded-lg">
                                <span class="text-[10px]">⭐</span>
                                <span class="text-[11px] font-black">+{{ $log->xp }} XP</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <span class="text-4xl opacity-30 block mb-2">🤷‍♂️</span>
                            <p class="text-sm text-slate-500 font-medium">Belum ada perolehan XP akhir-akhir ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: MODULE PROGRESS LIST -->
        <div class="lg:col-span-7 bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden gsap-slide-up" style="animation-delay: 0.2s;">
            <div class="p-6 md:p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Riwayat Pembelajaran</h2>
                    <p class="text-[11px] text-slate-500 font-medium mt-1">Lacak progress modul yang kamu pelajari.</p>
                </div>
                <a href="{{ route('student.modul') }}" class="hidden sm:inline-flex items-center gap-2 bg-[#047857] text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#036146] shadow-md active:scale-95 transition-all">
                    Lanjut Belajar &rarr;
                </a>
            </div>

            <div class="p-4 md:p-6 space-y-4">
                @forelse($moduleProgress ?? [] as $mp)
                    <div class="group flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl border {{ $mp->progress_percentage == 100 ? 'border-emerald-200 bg-emerald-50/30 hover:border-emerald-400' : 'border-slate-100 bg-slate-50 hover:border-blue-300' }} hover:shadow-md transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl shrink-0 {{ $mp->progress_percentage == 100 ? 'bg-emerald-100 text-emerald-600 group-hover:scale-110' : 'bg-blue-100 text-blue-600 group-hover:scale-110' }} transition-transform">
                            {{ $mp->progress_percentage == 100 ? '✅' : '📖' }}
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-sm font-black text-slate-800">{{ $mp->module->title ?? 'Modul Terhapus' }}</h3>
                                <span class="text-xs font-black {{ $mp->progress_percentage == 100 ? 'text-emerald-600' : 'text-blue-600' }}">{{ $mp->progress_percentage }}%</span>
                            </div>

                            <div class="w-full bg-slate-200 rounded-full h-1.5 overflow-hidden">
                                <div class="{{ $mp->progress_percentage == 100 ? 'bg-emerald-500' : 'bg-blue-500' }} h-1.5 rounded-full" style="width: {{ $mp->progress_percentage }}%"></div>
                            </div>

                            <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase tracking-widest">
                                Aktivitas Terakhir: {{ $mp->updated_at ? $mp->updated_at->diffForHumans() : 'Baru saja' }}
                            </p>
                        </div>

                        <div class="shrink-0 sm:ml-4">
                            @if($mp->module_id && $mp->module)
                                <a href="{{ route('student.modul.read', $mp->module_id) }}" class="block text-center w-full sm:w-auto px-4 py-2 rounded-xl text-[10px] uppercase tracking-widest font-black transition-colors {{ $mp->progress_percentage == 100 ? 'bg-white border-2 border-slate-200 text-slate-600 hover:bg-slate-100 hover:border-slate-300' : 'bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/20 active:scale-95' }}">
                                    {{ $mp->progress_percentage == 100 ? 'Baca Ulang' : 'Lanjutkan' }}
                                </a>
                            @else
                                <button disabled class="block text-center w-full sm:w-auto px-4 py-2 rounded-xl text-[10px] uppercase tracking-widest font-black bg-slate-200 text-slate-400 cursor-not-allowed">
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4 opacity-30">📭</div>
                        <h3 class="text-lg font-black text-slate-800 mb-2">Belum Ada Progress</h3>
                        <p class="text-sm text-slate-500 mb-6">Kamu belum mulai membaca modul apapun. Yuk, mulai belajar!</p>
                        <a href="{{ route('student.modul') }}" class="inline-flex items-center gap-2 bg-[#047857] text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-[#036146] shadow-lg shadow-emerald-500/30 transition-all active:scale-95">
                            Mulai Belajar Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Animasi Masuk Header
        gsap.from(".gsap-fade", { y: -30, opacity: 0, duration: 0.8, ease: "power3.out" });

        // Animasi Progress Bar Utama (Glow)
        setTimeout(() => {
            gsap.fromTo(".gsap-xp-bar", { scaleX: 0, transformOrigin: "left" }, { scaleX: 1, duration: 1.5, ease: "power3.out" });
        }, 500);

        // Animasi Kartu Statistik (Sudah FIX, bebas dari error Tailwind transition)
        gsap.from(".gsap-stat-card", { y: 30, opacity: 0, duration: 0.6, stagger: 0.1, ease: "back.out(1.2)", delay: 0.3 });

        // Animasi Layout Bawah
        gsap.from(".gsap-slide-up", { y: 30, opacity: 0, duration: 0.8, stagger: 0.1, ease: "power3.out", delay: 0.5 });

        // Animasi Counter Angka
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            if(target > 0) {
                let obj = { val: 0 };
                gsap.to(obj, {
                    val: target,
                    duration: 2,
                    ease: "power2.out",
                    delay: 0.6,
                    onUpdate: () => { counter.innerHTML = Math.floor(obj.val); }
                });
            } else {
                counter.innerHTML = "0";
            }
        });
    });
</script>
@endpush
