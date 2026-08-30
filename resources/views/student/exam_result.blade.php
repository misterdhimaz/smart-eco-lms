<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Evaluasi | SMART-ECO</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: { colors: { eco: { green: '#10b981' } } }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f7f6] text-slate-800 min-h-screen flex items-center justify-center p-4 md:p-8 relative overflow-x-hidden selection:bg-emerald-500 selection:text-white"
      x-data="resultApp()"
      x-init="initResult()">

    <div class="absolute inset-0 pointer-events-none z-0">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#cbd5e1_1px,transparent_1px),linear-gradient(to_bottom,#cbd5e1_1px,transparent_1px)] bg-[size:4rem_4rem] opacity-20"></div>
        <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[120px] mix-blend-multiply"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-blue-400/10 rounded-full blur-[120px] mix-blend-multiply"></div>
    </div>

    <div class="w-full max-w-4xl relative z-10">

        <div class="flex items-center justify-between mb-6 gsap-fade">
            <a href="{{ route('student.modul') }}" class="inline-flex items-center gap-2 text-xs font-black text-slate-500 hover:text-emerald-600 transition-colors bg-white/50 backdrop-blur-md px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Modul
            </a>
            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-white/80 backdrop-blur-md px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                Percobaan ke-{{ $attempt->attempt_number }}
            </span>
        </div>

        <div class="bg-white/90 backdrop-blur-xl border border-white/50 rounded-[2.5rem] p-8 md:p-12 shadow-[0_20px_60px_rgba(0,0,0,0.05)] relative overflow-hidden mb-8 gsap-fade">

            @if($attempt->is_passed)
                <div class="absolute -top-32 -right-32 w-[400px] h-[400px] bg-emerald-400/20 rounded-full blur-[80px] pointer-events-none"></div>
            @else
                <div class="absolute -top-32 -right-32 w-[400px] h-[400px] bg-rose-400/10 rounded-full blur-[80px] pointer-events-none"></div>
            @endif

            <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-10 relative z-10">

                <div class="text-center md:text-left flex-1">
                    @if($attempt->is_passed)
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 border border-emerald-200 rounded-xl text-[11px] font-black uppercase tracking-widest mb-5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Selamat! Evaluasi Tuntas
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-rose-100 text-rose-700 border border-rose-200 rounded-xl text-[11px] font-black uppercase tracking-widest mb-5 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            Belum Memenuhi KKM
                        </span>
                    @endif

                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-800 leading-tight mb-4 tracking-tight">
                        {{ $attempt->assessment->title }}
                    </h1>

                    <p class="text-sm text-slate-500 font-medium leading-relaxed max-w-xl">
                        @if($attempt->is_passed)
                            Luar biasa! Pemahaman Anda pada materi ini sangat baik. Anda berhasil mengklaim hadiah tambahan <strong class="text-emerald-600 font-black px-1 bg-emerald-50 rounded">+{{ $attempt->assessment->xp_reward ?? 50 }} XP</strong> untuk menaikkan level akun Anda!
                        @else
                            Jangan berkecil hati! Nilai Anda belum mencapai batas minimal KKM <strong class="text-slate-700">({{ $attempt->assessment->passing_grade ?? 70 }})</strong>. Silakan pelajari kembali materi dan coba evaluasi ini lagi.
                        @endif
                    </p>

                    <div class="mt-8 inline-flex items-center gap-2 bg-slate-50 px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-500">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Diselesaikan: {{ $attempt->completed_at ? \Carbon\Carbon::parse($attempt->completed_at)->format('d M Y, H:i') : now()->format('d M Y, H:i') }}
                    </div>
                </div>

                <div class="shrink-0 flex flex-col items-center justify-center">
                    <div class="relative w-48 h-48 md:w-56 md:h-56 flex items-center justify-center bg-white rounded-full shadow-[0_10px_30px_rgba(0,0,0,0.05)] border-8 border-slate-50">
                        <svg class="w-full h-full transform -rotate-90 absolute inset-0">
                            <circle cx="50%" cy="50%" r="42%" stroke="#f1f5f9" stroke-width="12" fill="none"></circle>
                            <circle cx="50%" cy="50%" r="42%"
                                    stroke="{{ $attempt->is_passed ? '#10b981' : '#f43f5e' }}"
                                    stroke-width="12"
                                    fill="none"
                                    stroke-dasharray="264"
                                    stroke-dashoffset="{{ 264 - (264 * $attempt->total_score / 100) }}"
                                    stroke-linecap="round"
                                    class="transition-all duration-1500 ease-out"></circle>
                        </svg>

                        <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-5xl md:text-6xl font-black text-slate-800 tracking-tighter">
                                <span class="gsap-counter" data-target="{{ $attempt->total_score }}">0</span>
                            </span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 mt-1">NILAI AKHIR</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10 gsap-fade">
            <div class="bg-white/80 backdrop-blur-md p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center font-black text-xl mb-3 border border-slate-200">
                    🎯
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Target KKM</p>
                <p class="text-lg font-black text-slate-800">{{ $attempt->assessment->passing_grade ?? 70 }}</p>
            </div>

            <div class="bg-white/80 backdrop-blur-md p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center font-black text-xl mb-3 border border-amber-200">
                    ⚡
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Hadiah XP</p>
                <p class="text-lg font-black text-slate-800">{{ $attempt->is_passed ? '+' . ($attempt->assessment->xp_reward ?? 50) : '0' }} <span class="text-xs text-slate-500">XP</span></p>
            </div>

            <div class="bg-white/80 backdrop-blur-md p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center font-black text-xl mb-3 border border-blue-200">
                    🔄
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Sisa Ujian</p>
                @php
                    $max = $attempt->assessment->max_attempts ?? 3;
                    $sisa = $max - $attempt->attempt_number;
                @endphp
                <p class="text-lg font-black text-slate-800">{{ $sisa > 0 ? $sisa . ' Kali' : 'Habis' }}</p>
            </div>

            <div class="bg-white/80 backdrop-blur-md p-5 rounded-3xl border border-slate-200 shadow-sm flex flex-col items-center text-center hover:-translate-y-1 transition-transform">
                <div class="w-12 h-12 rounded-full {{ $attempt->is_passed ? 'bg-emerald-50 text-emerald-500 border-emerald-200' : 'bg-rose-50 text-rose-500 border-rose-200' }} flex items-center justify-center font-black text-xl mb-3 border">
                    {{ $attempt->is_passed ? '🏆' : '💔' }}
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</p>
                <p class="text-lg font-black {{ $attempt->is_passed ? 'text-emerald-600' : 'text-rose-600' }}">{{ $attempt->is_passed ? 'LULUS' : 'GAGAL' }}</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 gsap-fade">
            <a href="{{ route('student.modul.read', $attempt->assessment->id) }}" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 text-slate-600 hover:text-slate-900 font-black rounded-2xl text-[11px] uppercase tracking-widest transition-all shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Pelajari Modul
            </a>

            @if($sisa > 0)
            <form action="{{ route('student.exam.start', $attempt->assessment->id) }}" method="POST" class="w-full sm:w-auto m-0">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-slate-800 hover:bg-slate-900 text-white font-black rounded-2xl text-[11px] uppercase tracking-widest transition-all shadow-[0_8px_20px_rgba(15,23,42,0.2)] active:scale-95 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Ulangi Evaluasi
                </button>
            </form>
            @endif

            <a href="{{ route('student.dashboard') }}" class="w-full sm:w-auto px-10 py-4 bg-[#10b981] hover:bg-[#059669] text-white font-black rounded-2xl text-[11px] uppercase tracking-widest transition-all shadow-[0_8px_20px_rgba(16,185,129,0.3)] active:scale-95 flex items-center justify-center gap-2 border border-emerald-400/50">
                Lanjut ke Beranda
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>

    <script>
        function resultApp() {
            return {
                initResult() {
                    // Animasi Masuk
                    gsap.from(".gsap-fade", {
                        y: 30,
                        opacity: 0,
                        duration: 0.8,
                        stagger: 0.15,
                        ease: "power3.out",
                        delay: 0.2
                    });

                    // Animasi Counter Angka
                    gsap.utils.toArray('.gsap-counter').forEach(el => {
                        let target = parseFloat(el.getAttribute('data-target'));
                        gsap.to(el, {
                            innerHTML: target,
                            duration: 2.5,
                            ease: "power2.out",
                            snap: { innerHTML: 1 },
                            delay: 0.5,
                            onUpdate: () => { el.innerHTML = Math.round(Number(el.innerHTML)); }
                        });
                    });

                    // Ledakan Confetti jika Lulus
                    @if($attempt->is_passed)
                    setTimeout(() => {
                        var duration = 3 * 1000;
                        var animationEnd = Date.now() + duration;
                        var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 100 };

                        function randomInRange(min, max) {
                            return Math.random() * (max - min) + min;
                        }

                        var interval = setInterval(function() {
                            var timeLeft = animationEnd - Date.now();

                            if (timeLeft <= 0) {
                                return clearInterval(interval);
                            }

                            var particleCount = 50 * (timeLeft / duration);
                            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                            confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
                        }, 250);
                    }, 800);
                    @endif
                }
            }
        }
    </script>
</body>
</html>
