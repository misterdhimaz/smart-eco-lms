@extends('layouts.student')
@section('title', 'Games Edukasi | SMART-ECO')

@section('content')
<div x-data="gameApp()" class="w-full pb-10 md:pb-24 font-sans selection:bg-fuchsia-500 selection:text-white relative">

    <!-- BACKGROUND EFEK -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0 overflow-hidden" x-show="!activeGame">
        <div class="absolute top-[-10%] left-[-10%] w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-purple-600/10 blur-[100px] md:blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[400px] md:w-[600px] h-[400px] md:h-[600px] bg-cyan-600/10 blur-[100px] md:blur-[150px] rounded-full"></div>
    </div>

    <!-- HALAMAN DEPAN: DAFTAR GAMES -->
    <div x-show="!activeGame" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8 md:space-y-10 relative z-10">

        <!-- HERO BANNER -->
        <div class="relative bg-slate-900 rounded-2xl md:rounded-[3rem] p-6 md:p-14 text-white overflow-hidden shadow-[0_15px_40px_-10px_rgba(147,51,234,0.3)] border border-white/10 gsap-fade">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-fuchsia-900 opacity-90"></div>

            <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-fuchsia-500/30 rounded-full blur-[80px] md:blur-[100px] animate-pulse pointer-events-none"></div>
            <div class="absolute bottom-0 left-10 md:left-20 w-48 md:w-72 h-48 md:h-72 bg-cyan-500/30 rounded-full blur-[60px] md:blur-[80px] pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 md:gap-8">
                <div class="w-full text-center md:text-left">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md px-3 md:px-4 py-1.5 md:py-2 rounded-full text-[9px] md:text-xs font-black uppercase tracking-widest mb-4 md:mb-6 border border-white/20 text-fuchsia-300 shadow-[0_0_15px_rgba(217,70,239,0.3)]">
                        <span class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-fuchsia-400 animate-ping"></span>
                        Arcade Zone Aktif
                    </div>
                    <h1 class="text-3xl sm:text-4xl md:text-6xl font-black tracking-tighter mb-3 md:mb-4 leading-tight">
                        Bermain & <br class="hidden sm:block">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-fuchsia-400 to-purple-400">Tingkatkan Levelmu!</span>
                    </h1>
                    <p class="text-slate-300 text-xs md:text-base font-medium max-w-xl leading-relaxed mx-auto md:mx-0">
                        Pilih tantanganmu. Uji ketangkasan dan pengetahuan lingkunganmu melalui mini-games interaktif. Kumpulkan <span class="text-amber-400 font-bold">XP</span> untuk setiap misi yang diselesaikan!
                    </p>
                </div>

                <div class="hidden md:flex shrink-0 w-40 h-40 lg:w-48 lg:h-48 bg-white/5 backdrop-blur-xl border-2 border-white/20 rounded-[2.5rem] lg:rounded-[3rem] items-center justify-center text-7xl lg:text-8xl shadow-2xl rotate-12 hover:rotate-0 hover:scale-110 transition-all duration-500 cursor-default">
                    👾
                </div>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-6 md:mb-8 px-1 md:px-2">
                <h2 class="text-lg md:text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2 md:gap-3">
                    <span class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-xs md:text-sm shadow-sm">🎯</span>
                    Daftar Mini Games
                </h2>
                <span class="text-[10px] md:text-xs font-bold text-slate-500 bg-white px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg border border-slate-200 shadow-sm" x-text="games.length + ' Game Tersedia'"></span>
            </div>

            <!-- GRID GAME CARDS -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-8">
                <template x-for="game in games" :key="game.id">
                    <button @click="openGame(game)" class="w-full text-left bg-white rounded-2xl md:rounded-[2.5rem] border-2 border-slate-200 shadow-md hover:shadow-2xl hover:border-purple-400 hover:-translate-y-2 transition-all duration-300 cursor-pointer overflow-hidden group flex flex-col relative z-20 block">

                        <div class="h-40 md:h-56 relative overflow-hidden flex items-center justify-center bg-gradient-to-br from-indigo-950 via-purple-950 to-slate-900 w-full shrink-0">
                            <span class="absolute text-8xl md:text-9xl opacity-30 blur-sm group-hover:scale-150 transition-transform duration-700 pointer-events-none" x-text="game.icon_emoji"></span>
                            <span class="relative z-10 text-6xl md:text-7xl drop-shadow-[0_10px_20px_rgba(0,0,0,0.5)] group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-500 pointer-events-none" x-text="game.icon_emoji"></span>

                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent pointer-events-none"></div>
                            <span class="absolute top-3 left-3 md:top-5 md:left-5 bg-slate-900/90 text-white border border-white/20 px-2.5 py-1 md:px-3.5 md:py-1.5 rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest shadow-md pointer-events-none" x-text="game.badge"></span>
                        </div>

                        <div class="p-5 md:p-8 flex-1 flex flex-col relative bg-white w-full">
                            <h3 class="text-lg md:text-xl font-black text-slate-900 mb-2 md:mb-3 leading-tight group-hover:text-purple-600 transition-colors uppercase line-clamp-2" x-text="game.title"></h3>
                            <p class="text-[11px] md:text-sm text-slate-600 font-bold line-clamp-2 md:line-clamp-3 mb-4 md:mb-6 flex-1 leading-relaxed" x-text="game.description"></p>

                            <div class="flex items-center justify-between pt-4 md:pt-5 border-t-2 border-slate-100">
                                <div class="flex items-center gap-1.5 md:gap-2 text-[9px] md:text-[11px] font-black uppercase tracking-widest text-purple-700 bg-purple-50 px-2.5 py-1.5 md:px-3.5 md:py-2 rounded-lg md:rounded-xl border border-purple-200">
                                    <span>🎲 Wordwall</span>
                                </div>

                                <template x-if="game.is_completed">
                                    <span class="bg-emerald-500 text-white px-3 py-1.5 md:px-4 md:py-2 rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-md shadow-emerald-500/20">
                                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Selesai
                                    </span>
                                </template>
                                <template x-if="!game.is_completed">
                                    <span class="text-purple-600 font-black text-[10px] md:text-xs flex items-center gap-1 opacity-0 group-hover:opacity-100 -translate-x-4 group-hover:translate-x-0 transition-all duration-300">
                                        Mainkan <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- MODAL GAME AKTIF (THEATER MODE MOBILE/DESKTOP) -->
    <!-- h-[100dvh] + overflow-hidden agar halaman tidak scroll saat main -->
    <div x-show="activeGame" x-cloak class="fixed inset-0 z-[100] bg-slate-950 flex flex-col w-screen h-[100dvh] overflow-hidden">

        <!-- HEADER MODAL -->
        <div class="h-14 md:h-[72px] bg-[#050B14] border-b border-slate-800 flex items-center justify-between px-3 md:px-6 shrink-0 z-20">
            <div class="flex items-center gap-2 md:gap-4 text-white min-w-0 max-w-[70%]">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-purple-500/20 hidden sm:flex items-center justify-center text-sm md:text-xl shrink-0 border border-purple-500/30" x-text="activeGame?.icon_emoji"></div>
                <div class="truncate">
                    <span class="text-[8px] md:text-[10px] font-black text-cyan-400 uppercase tracking-widest block mb-0.5" x-text="activeGame?.badge"></span>
                    <h2 class="font-black text-xs md:text-sm tracking-wide uppercase truncate" x-text="activeGame?.title"></h2>
                </div>
            </div>

            <button @click="closeGame()" class="px-3 py-1.5 md:px-5 md:py-2.5 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest transition-all active:scale-95 flex items-center gap-1.5 md:gap-2 border border-rose-500/20 shrink-0">
                <span class="hidden sm:inline">Keluar</span> <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- LAYOUT GAME (Flex-col di HP untuk Scroll, Flex-row di LG) -->
        <div class="flex-1 w-full bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-slate-800 to-slate-950 overflow-y-auto lg:overflow-hidden flex flex-col lg:flex-row p-2 md:p-4 lg:p-6 gap-3 md:gap-6 relative z-10 custom-scrollbar">

            <!-- FRAME GAME -->
            <!-- Diberi min-h-[50vh] di HP agar space untuk kliknya luas -->
            <div class="flex-1 w-full flex flex-col bg-white rounded-xl md:rounded-[2rem] border-2 md:border-4 border-slate-800 shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden relative shrink-0 min-h-[55vh] lg:min-h-0 transform-gpu">

                <div x-show="isLoading" class="absolute inset-0 z-30 bg-slate-900 flex flex-col items-center justify-center text-white pointer-events-none">
                    <div class="relative w-12 h-12 md:w-16 md:h-16">
                        <div class="absolute inset-0 rounded-full border-4 border-slate-700"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-purple-500 border-t-transparent animate-spin"></div>
                    </div>
                    <p class="text-[10px] md:text-xs font-black tracking-widest uppercase text-purple-400 mt-4 md:mt-6 animate-pulse">Menghubungkan ke Game...</p>
                </div>

                <!-- IFRAME DENGAN NORMAL FLOW & TOUCH ACTION NONE UNTUK iOS/CHROME -->
                <iframe :src="activeGame?.embed_url"
                        class="w-full flex-1 border-0 bg-white relative z-10"
                        allowfullscreen
                        style="touch-action: pan-y;"
                        @load="isLoading = false">
                </iframe>
            </div>

            <!-- SIDEBAR MISI -->
            <div class="w-full lg:w-80 bg-slate-950/80 backdrop-blur-xl rounded-xl md:rounded-[2rem] border border-slate-800 p-4 md:p-6 flex flex-col shrink-0 shadow-2xl relative lg:h-full lg:overflow-y-auto custom-scrollbar">

                <div class="absolute -right-10 -top-10 w-32 h-32 md:w-40 md:h-40 bg-purple-500/20 rounded-full blur-2xl md:blur-3xl pointer-events-none"></div>

                <div class="flex items-center gap-2 md:gap-3 mb-4 md:mb-6 pb-3 md:pb-4 border-b border-slate-700/50 shrink-0">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-lg md:text-2xl shrink-0 shadow-inner border border-white/10" x-text="activeGame?.icon_emoji"></div>
                    <div>
                        <h2 class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest">Misi Bermain</h2>
                        <p class="text-[8px] md:text-[9px] font-bold text-fuchsia-400" x-text="activeGame?.badge"></p>
                    </div>
                </div>

                <div class="flex-1 space-y-4 md:space-y-6 shrink-0 relative z-10">
                    <div>
                        <h4 class="text-[9px] md:text-[10px] font-black text-cyan-400 uppercase tracking-wider mb-2 md:mb-3 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Misi & Instruksi
                        </h4>
                        <p class="text-[11px] md:text-sm text-slate-300 font-medium leading-relaxed mb-4 md:mb-5" x-text="activeGame?.description"></p>

                        <ul class="text-[10px] md:text-xs text-slate-400 space-y-2.5 md:space-y-4 font-medium">
                            <template x-for="(step, index) in activeGame?.steps" :key="index">
                                <li class="flex items-start gap-2.5 md:gap-3 bg-slate-900/50 p-2.5 md:p-3 rounded-lg md:rounded-xl border border-slate-800">
                                    <span class="w-4 h-4 md:w-5 md:h-5 rounded bg-purple-500/20 text-purple-400 border border-purple-500/30 flex items-center justify-center shrink-0 text-[9px] md:text-[10px] font-black" x-text="index + 1"></span>
                                    <span class="mt-0.5 leading-relaxed" x-text="step"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Indikator Waktu Bermain -->
                <div class="mt-4 md:mt-6 pt-4 md:pt-6 border-t border-slate-800 shrink-0 relative z-10">
                    <template x-if="!activeGame?.is_completed">
                        <div class="bg-slate-900 p-4 md:p-5 rounded-xl md:rounded-2xl border border-slate-700 shadow-inner relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-cyan-500/5 pointer-events-none"></div>

                            <div class="flex justify-between items-center mb-2 md:mb-3 relative z-10">
                                <span class="text-[8px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">Durasi Bermain</span>
                                <span class="text-sm md:text-lg font-black font-mono tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-cyan-400" x-text="formatTime"></span>
                            </div>

                            <div class="w-full bg-slate-950 h-2 md:h-3 rounded-full overflow-hidden shadow-inner border border-slate-800 relative z-10">
                                <div class="bg-gradient-to-r from-purple-500 via-fuchsia-500 to-cyan-400 h-full rounded-full transition-all duration-1000 relative" :style="'width: ' + progressPercent + '%'">
                                    <div class="absolute top-0 bottom-0 left-0 right-0 bg-white/20 animate-pulse"></div>
                                </div>
                            </div>
                            <p class="text-[8px] md:text-[9px] font-bold text-slate-500 mt-2 md:mt-3 text-center uppercase tracking-widest relative z-10">Mainkan 1 menit = <span class="text-amber-400">+15 XP</span></p>
                        </div>
                    </template>

                    <template x-if="activeGame?.is_completed">
                        <div class="w-full p-4 md:p-5 rounded-xl md:rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-center shadow-[0_0_30px_rgba(16,185,129,0.1)] relative overflow-hidden">
                            <div class="absolute -right-2 -bottom-2 md:-right-4 md:-bottom-4 text-5xl md:text-6xl opacity-20 pointer-events-none">🏆</div>
                            <svg class="w-6 h-6 md:w-8 md:h-8 mx-auto mb-1 md:mb-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-[9px] md:text-[11px] font-black uppercase tracking-widest">Misi Diselesaikan!</p>
                            <p class="text-[10px] md:text-xs font-bold mt-1 text-white">+15 XP Telah Masuk Akun</p>
                        </div>
                    </template>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #475569; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        if(typeof gsap !== 'undefined') {
            gsap.from(".gsap-fade", { y: -30, opacity: 0, duration: 0.8, ease: "power3.out" });
        }
    });

    function gameApp() {
        return {
            games: [
                {
                    id: 1,
                    title: "Kuis Perubahan Lingkungan",
                    badge: "🌱 Biologi & Ekologi",
                    description: "Uji seberapa jauh pemahamanmu mengenai dampak aktivitas manusia terhadap lingkungan, polusi, dan upaya pelestariannya. Jawab dengan cepat!",
                    embed_url: "https://wordwall.net/id/embed/7d496503bc38422082cf97633ad1a072?themeId=49&templateId=5&fontStackId=0",
                    icon_emoji: "🌍",
                    bg_gradient: "from-blue-600 to-teal-600",
                    steps: [
                        "Tekan layar game dan ketik nama kamu untuk memulai.",
                        "Baca pertanyaan dengan teliti, lalu pilih jawaban yang paling tepat.",
                        "Perhatikan batas waktu yang berjalan di layar!",
                        "Kumpulkan skor terbaikmu dan kalahkan teman-temanmu."
                    ],
                    time_spent: 0,
                    is_completed: false
                }
            ],

            activeGame: null,
            timerInterval: null,
            requiredSeconds: 60, // Syarat Main: 60 Detik (1 Menit)
            isLoading: false,

            openGame(game) {
                this.activeGame = game;
                this.isLoading = true;
                this.startTimer();
                // Mengunci scroll background utama
                document.body.style.overflow = 'hidden';
            },
            closeGame() {
                this.stopTimer();
                this.activeGame = null;
                // Membuka kunci scroll
                document.body.style.overflow = '';
            },

            startTimer() {
                this.stopTimer();
                this.timerInterval = setInterval(() => {
                    if (this.activeGame && !this.activeGame.is_completed) {
                        if (typeof this.activeGame.time_spent === 'undefined') {
                            this.activeGame.time_spent = 0;
                        }
                        this.activeGame.time_spent++;

                        if (this.activeGame.time_spent >= this.requiredSeconds) {
                            this.autoClaimXP(this.activeGame);
                        }
                    }
                }, 1000);
            },

            stopTimer() {
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                    this.timerInterval = null;
                }
            },

            autoClaimXP(game) {
                if (game.is_completed) return;
                this.stopTimer();

                fetch("{{ route('student.claim_xp') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        xp_amount: 15,
                        description: 'Bermain Game Edukasi: ' + game.title,
                        type: 'game'
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        game.is_completed = true;

                        if(data.level_up) {
                            Swal.fire({
                                title: 'LEVEL UP! 🎉',
                                html: `Level <b>${data.new_level}</b> Tercapai!<br><br><span class="inline-block bg-purple-100 text-purple-700 px-3 py-1 rounded-lg font-black text-sm">+15 XP</span>`,
                                icon: 'success',
                                confirmButtonColor: '#9333ea',
                                customClass: { popup: 'rounded-[2rem]' }
                            });
                        } else {
                            Swal.fire({
                                toast: true, position: 'top-end', icon: 'success',
                                title: 'Misi Game Selesai! +15 XP 🚀', showConfirmButton: false, timer: 4000
                            });
                        }
                    }
                });
            },

            get formatTime() {
                if (!this.activeGame) return "00:00";
                let t = this.activeGame.time_spent || 0;
                let m = Math.floor(t / 60).toString().padStart(2, '0');
                let s = (t % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            get progressPercent() {
                if (!this.activeGame) return 0;
                let t = this.activeGame.time_spent || 0;
                let p = (t / this.requiredSeconds) * 100;
                return p > 100 ? 100 : p;
            }
        };
    }
</script>
@endpush
