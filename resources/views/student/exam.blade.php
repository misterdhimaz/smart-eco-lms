<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misi Evaluasi | SMART-ECO</title>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Menggunakan JSON_HEX tag untuk mencegah XSS & Syntax Error pada teks soal
        window.EXAM_DATA = {!! json_encode($questions, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
        window.EXAM_DURATION = {{ $assessment->duration_minutes ?? 60 }};
        window.EXAM_SUBMIT_URL = "{{ route('student.exam.submit', $attempt->id) }}";
    </script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-800 h-screen flex flex-col overflow-hidden bg-[#f4f7f6] selection:bg-emerald-500 selection:text-white relative"
      x-data="examApp()"
      x-init="initApp()">

    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#cbd5e1_1px,transparent_1px),linear-gradient(to_bottom,#cbd5e1_1px,transparent_1px)] bg-[size:4rem_4rem] opacity-[0.25]"></div>
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/10 rounded-full blur-[100px]"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-white/50 rounded-full blur-[120px]"></div>
    </div>

    <header class="h-[76px] bg-white/90 backdrop-blur-xl border-b border-slate-200/80 px-4 md:px-8 flex items-center justify-between shrink-0 shadow-sm z-30 gsap-header">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-black border border-emerald-100 shadow-sm shrink-0">
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            </div>
            <div class="overflow-hidden">
                <p class="text-[9px] md:text-[10px] font-black text-emerald-500 uppercase tracking-widest mb-0.5">Misi Evaluasi</p>
                <h1 class="text-xs md:text-sm font-black text-slate-800 leading-none truncate max-w-[200px] sm:max-w-md lg:max-w-xl">{{ $assessment->title }}</h1>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="hidden sm:flex flex-col items-end mr-2">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Progress</span>
                <span class="text-xs font-black text-slate-800"><span x-text="answeredCount"></span> / <span x-text="questions.length"></span> Selesai</span>
            </div>

            <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl border border-slate-200 bg-white shadow-sm transition-colors duration-500"
                 :class="timeRemaining < 300 ? 'bg-rose-50 border-rose-200 text-rose-600 shadow-[0_0_15px_rgba(244,63,94,0.2)]' : 'text-slate-700'">
                <svg class="w-5 h-5" :class="timeRemaining < 300 ? 'animate-pulse' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 2v2"></path></svg>
                <span class="font-black font-mono text-sm md:text-base tracking-wider" x-text="formattedTime"></span>
            </div>
        </div>
    </header>

    <div class="flex-1 flex flex-col xl:flex-row overflow-hidden relative z-20">

        <main class="flex-1 overflow-y-auto p-4 md:p-8 custom-scrollbar relative">
            <div class="max-w-4xl mx-auto w-full flex flex-col min-h-full pb-8">

                <template x-if="questions.length > 0">
                    <div class="flex-1 flex flex-col">

                        <div x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             :key="currentIndex"
                             class="bg-white/90 backdrop-blur-xl rounded-[2rem] p-6 md:p-10 lg:p-12 shadow-lg border border-slate-200/80 gsap-content flex-1 flex flex-col relative overflow-hidden">

                            <div class="absolute right-[-10px] top-[-10px] text-slate-100 font-black text-9xl select-none pointer-events-none" x-text="currentIndex + 1"></div>

                            <div class="flex justify-between items-center mb-8 relative z-10 border-b border-slate-100 pb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-slate-800 text-white rounded-full flex items-center justify-center font-black shadow-md">
                                        <span x-text="currentIndex + 1"></span>
                                    </div>
                                    <span class="bg-indigo-50 text-indigo-600 border border-indigo-100 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest" x-text="currentQuestion.type === 'essay' ? 'Soal Esai' : 'Pilihan Ganda'"></span>
                                </div>
                            </div>

                            <div class="prose prose-slate max-w-none mb-10 relative z-10">
                                <div class="text-base md:text-lg lg:text-xl font-semibold text-slate-800 leading-relaxed" x-html="currentQuestion.text"></div>
                            </div>

                            <template x-if="currentQuestion.type !== 'essay'">
                                <div class="space-y-4 relative z-10 mt-auto">
                                    <template x-for="(optText, index) in currentQuestion.options" :key="index">
                                        <label class="flex items-center p-4 md:p-5 border-2 rounded-2xl cursor-pointer transition-all duration-300 group hover:-translate-y-0.5"
                                               :class="answers[currentQuestion.id] == index ? 'border-emerald-500 bg-emerald-50/80 shadow-[0_10px_20px_rgba(16,185,129,0.1)]' : 'border-slate-200 bg-white hover:border-emerald-300 hover:shadow-md'">

                                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-sm shrink-0 mr-4 transition-all duration-300"
                                                 :class="answers[currentQuestion.id] == index ? 'bg-emerald-500 text-white shadow-md scale-110' : 'bg-slate-100 text-slate-500 group-hover:bg-emerald-100 group-hover:text-emerald-600'">
                                                <span x-text="getLetter(index)"></span>
                                            </div>

                                            <input type="radio" :name="'question_'+currentQuestion.id" :value="index" x-model="answers[currentQuestion.id]" class="hidden">

                                            <span class="text-sm md:text-base font-medium text-slate-700 leading-relaxed" x-text="optText"></span>

                                            <div class="ml-auto opacity-0 transform translate-x-4 transition-all duration-300"
                                                 :class="answers[currentQuestion.id] == index ? 'opacity-100 translate-x-0' : ''">
                                                <div class="w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center text-white shadow-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </template>

                            <template x-if="currentQuestion.type === 'essay'">
                                <div class="mt-auto relative z-10">
                                    <textarea x-model="answers[currentQuestion.id]" rows="6" class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl p-5 text-sm md:text-base font-medium text-slate-700 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all resize-none shadow-inner" placeholder="Ketik jawaban penjelasan Anda secara lengkap di sini..."></textarea>
                                </div>
                            </template>

                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center mt-6 gap-4 gsap-content">
                            <button @click="prevQuestion" :disabled="currentIndex === 0" class="w-full sm:w-auto px-8 py-3.5 bg-white border-2 border-slate-200 text-slate-600 rounded-xl text-xs font-black transition-all hover:bg-slate-50 disabled:opacity-40 disabled:cursor-not-allowed flex justify-center items-center gap-2 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                                SOAL SEBELUMNYA
                            </button>

                            <button x-show="currentIndex < questions.length - 1" @click="nextQuestion" class="w-full sm:w-auto px-10 py-3.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-black transition-all shadow-[0_8px_20px_rgba(15,23,42,0.2)] active:scale-95 flex justify-center items-center gap-2 group">
                                SOAL SELANJUTNYA
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <button x-show="currentIndex === questions.length - 1" @click="confirmSubmit" class="w-full sm:w-auto px-10 py-3.5 bg-[#10b981] hover:bg-[#059669] text-white rounded-xl text-xs font-black transition-all shadow-lg shadow-emerald-500/30 active:scale-95 flex justify-center items-center gap-2 border border-emerald-400/50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                SELESAI & KUMPULKAN
                            </button>
                        </div>
                    </div>
                </template>

                <template x-if="questions.length === 0">
                    <div class="bg-white rounded-[2rem] p-16 shadow-lg border border-slate-200 text-center flex-1 flex flex-col items-center justify-center">
                        <svg class="w-20 h-20 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <h2 class="text-xl font-black text-slate-700 mb-2">Soal Belum Tersedia</h2>
                        <p class="text-sm text-slate-500">Hubungi pengajar karena bank soal untuk modul ini masih kosong.</p>
                        <a href="{{ route('student.modul') }}" class="mt-6 px-6 py-3 bg-slate-800 text-white rounded-xl text-xs font-black">Kembali ke Modul</a>
                    </div>
                </template>

            </div>
        </main>

        <aside class="w-full xl:w-[340px] bg-white/95 backdrop-blur-xl border-t xl:border-t-0 xl:border-l border-slate-200 flex flex-col shrink-0 z-30 shadow-[-10px_0_30px_rgba(0,0,0,0.04)] h-[250px] xl:h-auto gsap-sidebar">
            <div class="p-6 border-b border-slate-100 bg-slate-50/80">
                <h3 class="text-[11px] font-black text-slate-800 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    PETA SOAL (CAT)
                </h3>
                <p class="text-[10px] text-slate-500 font-medium">Terjawab: <strong class="text-emerald-600" x-text="answeredCount"></strong> / <span x-text="questions.length"></span></p>

                <div class="w-full h-1.5 bg-slate-200 rounded-full mt-3 overflow-hidden shadow-inner">
                    <div class="h-full bg-emerald-500 transition-all duration-500 rounded-full relative overflow-hidden" :style="`width: ${(answeredCount / questions.length) * 100}%`"></div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                <div class="grid grid-cols-5 sm:grid-cols-8 xl:grid-cols-5 gap-3">
                    <template x-for="(q, index) in questions" :key="q.id">
                        <button @click="goToQuestion(index)"
                                class="w-full aspect-square rounded-xl text-[11px] font-black flex items-center justify-center transition-all duration-300 border-2"
                                :class="{
                                    'border-emerald-500 bg-emerald-50 text-emerald-600 shadow-sm': answers[q.id] != null && currentIndex !== index,
                                    'border-slate-200 bg-white text-slate-500 hover:border-slate-300 hover:bg-slate-50': answers[q.id] == null && currentIndex !== index,
                                    'border-slate-800 bg-slate-800 text-white shadow-[0_4px_10px_rgba(15,23,42,0.3)] scale-110': currentIndex === index && answers[q.id] == null,
                                    'border-emerald-500 bg-emerald-500 text-white shadow-[0_4px_10px_rgba(16,185,129,0.3)] scale-110': currentIndex === index && answers[q.id] != null
                                }">
                            <span x-text="index + 1"></span>
                        </button>
                    </template>
                </div>

                <div class="mt-8 p-4 bg-slate-50 border border-slate-100 rounded-xl space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-3.5 h-3.5 rounded bg-slate-800 shadow-sm"></div>
                        <span class="text-[10px] font-bold text-slate-600">Posisi Saat Ini</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3.5 h-3.5 rounded bg-emerald-50 border border-emerald-500 flex items-center justify-center text-[8px] text-emerald-600 font-bold">✓</div>
                        <span class="text-[10px] font-bold text-slate-600">Sudah Dijawab</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3.5 h-3.5 rounded bg-white border border-slate-300"></div>
                        <span class="text-[10px] font-bold text-slate-600">Belum Dijawab</span>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100 bg-white shrink-0">
                <button @click="confirmSubmit" class="w-full py-3.5 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white border border-rose-200 hover:border-rose-500 rounded-xl text-[11px] font-black tracking-widest transition-all active:scale-95 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    AKHIRI UJIAN
                </button>
            </div>
        </aside>

    </div>

    <script>
        function examApp() {
            return {
                questions: window.EXAM_DATA || [],
                currentIndex: 0,
                answers: {},
                timeRemaining: (window.EXAM_DURATION || 60) * 60,
                timerInterval: null,
                submitUrl: window.EXAM_SUBMIT_URL,

                get currentQuestion() {
                    return this.questions[this.currentIndex] || {};
                },

                get answeredCount() {
                    return Object.values(this.answers).filter(val => val !== null && val !== '').length;
                },

                get formattedTime() {
                    let h = Math.floor(this.timeRemaining / 3600);
                    let m = Math.floor((this.timeRemaining % 3600) / 60);
                    let s = this.timeRemaining % 60;

                    if (h > 0) return `${h.toString().padStart(2, '0')}:${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                },

                // Fungsi helper untuk mengubah index 0,1,2,3 menjadi A,B,C,D
                getLetter(index) {
                    return String.fromCharCode(65 + index);
                },

                initApp() {
                    if(this.questions.length > 0) {
                        gsap.from(".gsap-header", { y: -20, opacity: 0, duration: 0.6, ease: "power2.out" });
                        gsap.from(".gsap-sidebar", { x: 50, opacity: 0, duration: 0.6, delay: 0.2, ease: "power2.out" });
                        gsap.from(".gsap-content", { y: 30, opacity: 0, duration: 0.6, delay: 0.1, ease: "power2.out" });

                        window.addEventListener('beforeunload', this.handleUnload);

                        this.timerInterval = setInterval(() => {
                            if (this.timeRemaining > 0) {
                                this.timeRemaining--;
                            } else {
                                clearInterval(this.timerInterval);
                                this.autoSubmit();
                            }
                        }, 1000);
                    }
                },

                handleUnload(e) {
                    e.preventDefault();
                    e.returnValue = '';
                },

                nextQuestion() {
                    if (this.currentIndex < this.questions.length - 1) this.currentIndex++;
                },

                prevQuestion() {
                    if (this.currentIndex > 0) this.currentIndex--;
                },

                goToQuestion(index) {
                    this.currentIndex = index;
                },

                confirmSubmit() {
                    let unanswered = this.questions.length - this.answeredCount;
                    let title = unanswered > 0 ? 'Peringatan!' : 'Kumpulkan Ujian?';
                    let message = unanswered > 0
                        ? `Anda masih memiliki <b class="text-rose-500">${unanswered} soal</b> yang belum dijawab. Apakah Anda yakin ingin mengakhiri ujian sekarang?`
                        : "Anda telah menjawab seluruh soal. Yakin ingin mengumpulkan jawaban sekarang?";

                    Swal.fire({
                        title: title,
                        html: message,
                        icon: unanswered > 0 ? 'warning' : 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#94a3b8',
                        confirmButtonText: 'Ya, Kumpulkan!',
                        cancelButtonText: 'Batal',
                        customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-6', cancelButton: 'rounded-xl font-bold px-6' }
                    }).then((result) => {
                        if (result.isConfirmed) this.processSubmit();
                    });
                },

                autoSubmit() {
                    Swal.fire({
                        title: 'Waktu Habis! ⏱️',
                        text: 'Waktu pengerjaan telah berakhir. Jawaban Anda akan dikumpulkan secara otomatis.',
                        icon: 'info',
                        showConfirmButton: false,
                        timer: 4000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        customClass: { popup: 'rounded-3xl' }
                    }).then(() => {
                        this.processSubmit();
                    });
                },

                processSubmit() {
                    window.removeEventListener('beforeunload', this.handleUnload);

                    Swal.fire({
                        title: 'Memproses Jawaban...',
                        html: 'Mohon jangan tutup halaman ini.',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading() },
                        customClass: { popup: 'rounded-[2rem]' }
                    });

                    fetch(this.submitUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ answers: this.answers })
                    })
                    .then(async response => {
                        const data = await response.json().catch(() => null);
                        if (!response.ok) throw new Error(data && data.message ? data.message : 'Server Error.');
                        return data;
                    })
                    .then(data => {
                        if(data && data.success) {

                            // JIKA LULUS EVALUASI (TAMPILKAN HADIAH XP DARI ADMIN)
                            if (data.is_passed) {
                                let titleText = data.level_up ? `LEVEL UP! 🎉` : `MISI SELESAI! 🏆`;
                                let messageText = `Luar Biasa! Kamu mendapat nilai <b>${data.score}</b>.<br><br><div class="inline-block bg-emerald-100 text-emerald-700 px-4 py-2 mt-2 rounded-xl font-black text-xl border-2 border-emerald-300 shadow-sm">+${data.xp_gained} XP</div>`;

                                Swal.fire({
                                    title: titleText,
                                    html: messageText,
                                    icon: 'success',
                                    confirmButtonColor: '#10b981',
                                    confirmButtonText: 'Lihat Rapor Akademik ➔',
                                    allowOutsideClick: false,
                                    customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl px-6 font-bold uppercase tracking-widest' }
                                }).then(() => {
                                    window.location.href = data.redirect_url; // Pindah ke halaman hasil (rapor)
                                });
                            }
                            // JIKA BELUM LULUS KKM
                            else {
                                Swal.fire({
                                    title: 'Ujian Selesai',
                                    html: `Nilai kamu: <b class="text-rose-500">${data.score}</b>.<br><br>Kamu belum mencapai nilai minimal (KKM). Ayo pelajari lagi materinya dan coba kembali!`,
                                    icon: 'info',
                                    confirmButtonColor: '#3b82f6',
                                    confirmButtonText: 'Lihat Rapor Akademik ➔',
                                    allowOutsideClick: false,
                                    customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl px-6 font-bold uppercase tracking-widest' }
                                }).then(() => {
                                    window.location.href = data.redirect_url;
                                });
                            }

                        } else {
                            Swal.fire('Gagal Menyimpan', data.message || 'Terjadi kesalahan sistem.', 'error');
                            window.addEventListener('beforeunload', this.handleUnload);
                        }
                    })
                    .catch(error => {
                        console.error("Detail Error:", error);
                        Swal.fire({
                            title: 'Pesan Error',
                            text: error.message,
                            icon: 'error',
                            customClass: { popup: 'rounded-[2rem]' }
                        });
                        window.addEventListener('beforeunload', this.handleUnload);
                    });
                }
            }
        }
    </script>
</body>
</html>
