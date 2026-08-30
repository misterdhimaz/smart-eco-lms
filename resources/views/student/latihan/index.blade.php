@extends('layouts.student')
@section('title', 'Latihan Soal | SMART-ECO')

@section('content')
<div x-data="latihanApp()" x-cloak class="max-w-7xl mx-auto pb-20 font-sans text-slate-800 relative">

    <!-- HEADER -->
    <div class="relative rounded-[3rem] bg-gradient-to-br from-indigo-900 via-indigo-800 to-purple-800 p-8 md:p-12 text-white overflow-hidden shadow-2xl mb-12 border-4 border-indigo-400/20 gsap-header">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-purple-500/30 blur-[100px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-10">
            <div class="text-center md:text-left flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 text-purple-300 text-[10px] font-black uppercase tracking-widest mb-4">
                    <span class="text-lg">🎯</span> MODE LATIHAN BEBAS
                </div>
                <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-3 uppercase leading-tight drop-shadow-md">
                    Asah <span class="text-purple-400">Kemampuanmu!</span>
                </h1>
                <p class="text-indigo-100 font-bold max-w-md mx-auto md:mx-0 text-sm leading-relaxed">
                    Kerjakan ulang soal-soal evaluasi modul di sini. Cek kunci jawabanmu, capai skor tertinggi, klaim <span class="text-amber-400">Bonus XP</span>, dan unduh laporan hasil belajarmu!
                </p>
            </div>

            <div class="shrink-0 animate-bounce-slow hidden md:block">
                <div class="w-40 h-40 bg-gradient-to-tr from-purple-400 to-indigo-300 rounded-[2.5rem] rotate-12 flex items-center justify-center text-7xl shadow-2xl border-4 border-white/20">
                    🧠
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 bg-indigo-100 text-indigo-700 rounded-xl flex items-center justify-center font-black text-xl shadow-sm">📚</div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Pilih Modul Latihan</h2>
    </div>

    <!-- GRID MODUL -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($assessments as $assessment)
        <div class="group bg-white rounded-[2.5rem] border-2 border-slate-200/80 hover:border-indigo-500 hover:shadow-2xl transition-all duration-500 overflow-hidden gsap-card flex flex-col relative">
            <div class="p-6 flex-1">
                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6 shadow-inner group-hover:scale-110 group-hover:rotate-12 transition-transform">🧩</div>
                <h3 class="text-xl font-black text-slate-900 uppercase leading-tight group-hover:text-indigo-700 transition-colors">{{ $assessment->title }}</h3>
                <p class="text-xs font-bold text-slate-400 mt-2 line-clamp-2 leading-relaxed">
                    {{ $assessment->description ?? 'Latihan soal untuk menguji pemahaman Anda pada modul ini.' }}
                </p>
            </div>
            <div class="px-6 py-5 bg-slate-50 border-t-2 border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest">
                        {{ $assessment->questions_count ?? 3 }} Soal
                    </span>
                </div>
                <!-- Tombol Mulai dengan Badge XP -->
                <button @click="bukaLatihan('{{ addslashes($assessment->title) }}')" class="bg-slate-800 text-white hover:bg-indigo-600 px-3 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center gap-2">
                    Mulai Latihan &rarr;
                    <span class="bg-amber-400 text-slate-900 px-1.5 py-0.5 rounded-md leading-none">+15 XP</span>
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-300 shadow-sm">
            <span class="text-6xl block mb-4 grayscale opacity-40">😴</span>
            <h3 class="text-2xl font-black text-slate-700 uppercase tracking-tight">Belum Ada Soal</h3>
        </div>
        @endforelse
    </div>

    <!-- MODAL POPUP LATIHAN SOAL (FULLSCREEN) -->
    <div x-show="isLatihanActive" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="fixed inset-0 z-50 bg-slate-900/95 backdrop-blur-md flex items-center justify-center p-4">

        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col h-[90vh]">

            <!-- Modal Header -->
            <div class="bg-indigo-600 p-6 flex justify-between items-center text-white shrink-0">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-indigo-200" x-text="isFinished ? 'HASIL & PEMBAHASAN' : 'MODE LATIHAN'"></span>
                    <h3 class="text-lg font-bold leading-tight" x-text="latihanTitle"></h3>
                </div>
                <button @click="tutupLatihan()" class="w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- AREA KUIS (BERJALAN) -->
            <template x-if="!isFinished">
                <div class="p-6 md:p-8 flex-1 overflow-y-auto bg-slate-50 relative flex flex-col">
                    <div class="flex justify-between items-center mb-8 shrink-0">
                        <span class="text-xs font-black text-slate-400 uppercase tracking-widest" x-text="'Soal ' + (currentIndex + 1) + ' dari ' + questions.length"></span>
                        <span class="bg-amber-100 text-amber-600 px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest">+15 XP Jika Selesai</span>
                    </div>

                    <h2 class="text-xl md:text-2xl font-bold text-slate-800 mb-8 leading-relaxed" x-text="questions[currentIndex].q"></h2>

                    <div class="space-y-3 mb-4 flex-1">
                        <template x-for="(option, index) in questions[currentIndex].options" :key="index">
                            <label class="flex items-center gap-4 p-4 rounded-xl border-2 cursor-pointer transition-all duration-200"
                                   :class="selectedAnswer === index ? 'border-indigo-500 bg-indigo-50 shadow-sm' : 'border-slate-200 bg-white hover:border-indigo-300'">
                                <!-- PENTING: x-model.number memastikan tipe data selalu Integer/Angka -->
                                <input type="radio" :value="index" x-model.number="selectedAnswer" class="w-5 h-5 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                <span class="font-medium text-slate-700 text-sm md:text-base" x-text="option"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </template>

            <!-- AREA HASIL AKHIR & REVIEW JAWABAN -->
            <template x-if="isFinished">
                <div class="p-6 md:p-10 flex-1 overflow-y-auto bg-slate-50 flex flex-col items-center custom-scrollbar">

                    <!-- Kotak Skor Atas -->
                    <div class="w-24 h-24 mb-4 rounded-full flex items-center justify-center text-5xl shadow-xl border-4 border-white shrink-0"
                         :class="score >= 70 ? 'bg-emerald-100 text-emerald-500' : 'bg-amber-100 text-amber-500'">
                        <span x-text="score >= 70 ? '🏆' : '💪'"></span>
                    </div>

                    <h2 class="text-3xl font-black text-slate-800 mb-2">Latihan Selesai!</h2>
                    <p class="text-slate-500 font-medium mb-6">Kamu berhasil menjawab <b class="text-slate-700" x-text="correctCount"></b> dari <b class="text-slate-700" x-text="questions.length"></b> pertanyaan dengan benar.</p>

                    <!-- Banner Bukti Dapat XP -->
                    <div class="mb-8 inline-flex items-center gap-2 bg-amber-50 border-2 border-amber-200 text-amber-600 px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-sm shrink-0">
                        <span class="text-lg animate-bounce">⭐</span> +15 XP Berhasil Diklaim!
                    </div>

                    <!-- Kotak Skor Besar -->
                    <div class="bg-white border-2 border-slate-100 rounded-[2rem] p-6 w-full max-w-sm mb-8 shadow-sm relative overflow-hidden text-center shrink-0">
                        <p class="text-xs font-black uppercase tracking-widest text-slate-400 mb-1">Skor Akhir</p>
                        <div class="text-7xl font-black tracking-tighter" :class="score >= 70 ? 'text-emerald-500' : 'text-amber-500'" x-text="score"></div>
                    </div>

                    <!-- Daftar Review Jawaban (Kunci Benar/Salah) -->
                    <div class="w-full max-w-3xl bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-left mb-8">
                        <h3 class="text-sm font-black uppercase tracking-widest text-slate-800 mb-6 border-b pb-4">Detail Kunci Jawaban</h3>

                        <div class="space-y-6">
                            <template x-for="(q, index) in questions" :key="index">
                                <div class="p-5 rounded-xl border-2"
                                     :class="userAnswers[index] === q.correct ? 'bg-emerald-50/50 border-emerald-200' : 'bg-rose-50/50 border-rose-200'">

                                    <p class="font-bold text-slate-800 text-sm md:text-base mb-3 leading-relaxed" x-text="(index + 1) + '. ' + q.q"></p>

                                    <!-- Jika Benar -->
                                    <template x-if="userAnswers[index] === q.correct">
                                        <div class="flex items-start gap-2">
                                            <span class="text-emerald-500 mt-0.5">✅</span>
                                            <p class="text-sm font-medium text-emerald-700">
                                                Jawaban Anda Benar: <br> <span class="font-bold" x-text="q.options[userAnswers[index]]"></span>
                                            </p>
                                        </div>
                                    </template>

                                    <!-- Jika Salah / Tidak Dijawab -->
                                    <template x-if="userAnswers[index] !== q.correct">
                                        <div class="space-y-2">
                                            <div class="flex items-start gap-2">
                                                <span class="text-rose-500 mt-0.5">❌</span>
                                                <p class="text-sm font-medium text-rose-700">
                                                    Jawaban Anda: <br>
                                                    <span class="font-bold" x-text="userAnswers[index] !== null ? q.options[userAnswers[index]] : 'Tidak dijawab'"></span>
                                                </p>
                                            </div>
                                            <div class="flex items-start gap-2 mt-2 pt-2 border-t border-rose-200/50">
                                                <span class="text-emerald-500 mt-0.5">💡</span>
                                                <p class="text-sm font-medium text-slate-600">
                                                    Kunci Jawaban yang Benar: <br> <span class="font-bold text-emerald-700" x-text="q.options[q.correct]"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </template>

            <!-- Modal Footer (Navigasi) -->
            <div class="p-6 bg-white border-t border-slate-200 flex justify-between items-center shrink-0">

                <!-- Tampil Jika Selesai -->
                <div class="w-full flex justify-between items-center" x-show="isFinished" style="display: none;">
                    <button @click="tutupLatihan()" class="px-6 py-3 rounded-xl text-xs font-bold text-slate-500 hover:bg-slate-100 transition-colors uppercase tracking-widest">
                        Tutup
                    </button>
                    <!-- Tombol Opsi Cetak PDF -->
                    <button @click="cetakLaporanLangsung()" class="bg-indigo-50 border border-indigo-200 text-indigo-700 hover:bg-indigo-600 hover:text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-sm active:scale-95 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Simpan PDF / Cetak
                    </button>
                </div>

                <!-- Tampil Jika Belum Selesai (Sedang Mengerjakan) -->
                <div class="w-full flex justify-end" x-show="!isFinished">
                    <button @click="nextQuestion()"
                            :disabled="selectedAnswer === null || isSubmitting"
                            class="bg-indigo-600 disabled:bg-slate-300 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center gap-2">
                        <!-- Teks Tombol Berubah Jika Soal Terakhir -->
                        <span x-text="currentIndex === questions.length - 1 ? (isSubmitting ? 'Memproses Skor...' : 'Selesai & Cek Skor (+15 XP)') : 'Soal Selanjutnya'"></span>
                        <svg x-show="!isSubmitting && currentIndex !== questions.length - 1" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                        <svg x-show="currentIndex === questions.length - 1 && !isSubmitting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if(typeof gsap !== 'undefined') {
            gsap.from(".gsap-header", { y: -20, opacity: 0, duration: 0.6, ease: "power2.out" });
            gsap.from(".gsap-card", { y: 30, opacity: 0, duration: 0.5, stagger: 0.1, ease: "back.out(1.2)" });
        }
    });

    function latihanApp() {
        return {
            isLatihanActive: false,
            isFinished: false,
            latihanTitle: '',
            currentIndex: 0,
            selectedAnswer: null,
            isSubmitting: false,

            userAnswers: [],
            score: 0,
            correctCount: 0,
            studentName: '{{ $user->name ?? "Mahasiswa" }}',

            /* DUMMY SOAL (Pastikan 'correct' menunjuk ke urutan pilihan mulai dari 0) */
            questions: [
                {
                    q: "Apa dampak utama dari peningkatan emisi gas rumah kaca?",
                    options: ["Penurunan suhu global", "Pemanasan global dan perubahan iklim", "Udara menjadi lebih bersih", "Lapisan ozon menebal"],
                    correct: 1 // Jawaban: Pemanasan global (Indeks 1)
                },
                {
                    q: "Sumber energi manakah yang termasuk energi terbarukan?",
                    options: ["Batu bara", "Gas alam", "Tenaga surya (Matahari)", "Minyak bumi"],
                    correct: 2 // Jawaban: Tenaga surya (Indeks 2)
                },
                {
                    q: "Praktik apa yang paling efektif untuk mengurangi jejak karbon sehari-hari?",
                    options: ["Meninggalkan lampu menyala", "Menggunakan kendaraan pribadi setiap saat", "Mendaur ulang dan menggunakan transportasi umum", "Membakar sampah plastik"],
                    correct: 2 // Jawaban: Mendaur ulang (Indeks 2)
                }
            ],

            bukaLatihan(title) {
                this.latihanTitle = title;
                this.currentIndex = 0;
                this.selectedAnswer = null;
                this.userAnswers = [];
                this.isFinished = false;
                this.isSubmitting = false;
                this.isLatihanActive = true;
                document.body.style.overflow = 'hidden';
            },

            tutupLatihan() {
                this.isLatihanActive = false;
                document.body.style.overflow = 'auto';
            },

            nextQuestion() {
                if (this.selectedAnswer === null) return;

                // PENTING: Gunakan parseInt() untuk menjamin nilai yang disimpan selalu Integer
                this.userAnswers[this.currentIndex] = parseInt(this.selectedAnswer);

                if (this.currentIndex < this.questions.length - 1) {
                    this.currentIndex++;
                    this.selectedAnswer = null;
                } else {
                    this.submitLatihan();
                }
            },

            submitLatihan() {
                this.isSubmitting = true;

                // 1. Kalkulasi Skor Akurat
                this.correctCount = 0;
                this.questions.forEach((q, index) => {
                    // Karena userAnswers sudah dipastikan Integer, perbandingan ini akan sangat akurat
                    if (this.userAnswers[index] === q.correct) {
                        this.correctCount++;
                    }
                });

                // Rumus: (Benar / Total Soal) * 100
                this.score = Math.round((this.correctCount / this.questions.length) * 100);

                // 2. Tembak API Claim 15 XP
                // Tembak API Claim XP
                fetch("{{ route('student.claim_xp') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        xp_amount: 15,
                        description: 'Latihan Soal: ' + this.latihanTitle,
                        type: 'latihan' // <-- TAMBAHKAN TIPE INI AGAR IKONNYA BERUBAH JADI KERTAS
                    })
                })
                .then(res => res.json())
                .then(data => {
                    this.isSubmitting = false;
                    this.isFinished = true; // Munculkan layar Hasil & Review

                    if(data.success && data.level_up) {
                        Swal.fire({
                            toast: true, position: 'top-end',
                            title: 'LEVEL UP! 🎉',
                            html: `Level ${data.new_level} Tercapai!<br><span class="text-indigo-600 font-black">+15 XP</span>`,
                            icon: 'success', showConfirmButton: false, timer: 4000
                        });
                    } else if(data.success) {
                        Swal.fire({
                            toast: true, position: 'top-end',
                            title: 'Latihan Selesai! 🎯',
                            html: `<span class="text-indigo-600 font-black">+15 XP</span> ditambahkan ke akunmu.`,
                            icon: 'success', showConfirmButton: false, timer: 3000
                        });
                    }
                })
                .catch(err => {
                    this.isSubmitting = false;
                    this.isFinished = true;
                });
            },

            // FUNGSI UNTUK GENERATE & CETAK LAPORAN LANGSUNG TANPA TAB BARU
            cetakLaporanLangsung() {
                let date = new Date().toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });

                let reportHTML = `
                <html>
                <head>
                    <title>Laporan Latihan - ${this.latihanTitle}</title>
                    <style>
                        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333; line-height: 1.6; padding: 40px; max-width: 800px; margin: 0 auto; background: #fff; }
                        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 20px; margin-bottom: 30px; }
                        .header h1 { margin: 0; color: #1e293b; font-size: 24px; text-transform: uppercase; }
                        .header p { margin: 5px 0 0; color: #64748b; font-size: 14px; }
                        .score-box { background: ${this.score >= 70 ? '#ecfdf5' : '#fffbeb'}; border: 1px solid ${this.score >= 70 ? '#a7f3d0' : '#fde68a'}; padding: 20px; text-align: center; border-radius: 12px; margin-bottom: 40px; }
                        .score-box h2 { margin: 0; font-size: 48px; color: ${this.score >= 70 ? '#10b981' : '#f59e0b'}; }
                        .score-box p { margin: 5px 0 0; font-weight: bold; color: #475569; }
                        .q-block { margin-bottom: 25px; page-break-inside: avoid; }
                        .q-title { font-weight: bold; margin-bottom: 8px; color: #0f172a; }
                        .ans { margin: 4px 0; font-size: 14px; padding: 8px 12px; border-radius: 6px; }
                        .ans-correct { background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
                        .ans-wrong { background-color: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }
                        .key { font-size: 13px; color: #64748b; font-style: italic; margin-top: 4px; }
                        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 20px; }
                        @media print { body { padding: 0; } }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Laporan Hasil Latihan</h1>
                        <p><strong>Modul:</strong> ${this.latihanTitle}</p>
                        <p><strong>Nama:</strong> ${this.studentName} &nbsp;|&nbsp; <strong>Tanggal:</strong> ${date}</p>
                    </div>

                    <div class="score-box">
                        <p>SKOR AKHIR</p>
                        <h2>${this.score} / 100</h2>
                        <p>(${this.correctCount} Benar dari ${this.questions.length} Soal)</p>
                    </div>

                    <h3>Detail Kunci Jawaban:</h3>
                `;

                this.questions.forEach((q, i) => {
                    let userAnswerIndex = this.userAnswers[i];
                    let isCorrect = userAnswerIndex === q.correct;
                    let answerStatusClass = isCorrect ? 'ans-correct' : 'ans-wrong';
                    let answerStatusText = isCorrect ? 'Benar' : 'Salah';

                    reportHTML += `
                    <div class="q-block">
                        <div class="q-title">${i + 1}. ${q.q}</div>
                        <div class="ans ${answerStatusClass}">
                            <strong>Jawaban Anda (${answerStatusText}):</strong> ${userAnswerIndex !== null ? q.options[userAnswerIndex] : 'Tidak dijawab'}
                        </div>
                        ${!isCorrect ? `<div class="key"><strong>Kunci Jawaban Benar:</strong> ${q.options[q.correct]}</div>` : ''}
                    </div>`;
                });

                reportHTML += `
                    <div class="footer">
                        Dokumen ini dicetak otomatis dari sistem SMART-ECO LMS.<br>
                        Jadikan hasil ini sebagai acuan belajar mandiri Anda.
                    </div>
                </body>
                </html>`;

                // Trik Iframe agar print langsung di halaman ini (tanpa buka tab baru)
                let oldFrame = document.getElementById('print-iframe');
                if (oldFrame) oldFrame.remove();

                let iframe = document.createElement('iframe');
                iframe.id = 'print-iframe';
                iframe.style.display = 'none'; // Sembunyikan iframe
                document.body.appendChild(iframe);

                iframe.contentWindow.document.open();
                iframe.contentWindow.document.write(reportHTML);
                iframe.contentWindow.document.close();

                // Eksekusi print secara langsung di halaman saat ini
                setTimeout(() => {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                }, 300);
            }
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .animate-bounce-slow { animation: bounce 3s infinite; }
    @keyframes bounce {
        0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8,0,1,1); }
        50% { transform: none; animation-timing-function: cubic-bezier(0,0,0.2,1); }
    }
    [x-cloak] { display: none !important; }
</style>
@endpush
