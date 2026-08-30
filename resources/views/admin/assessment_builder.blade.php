<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Assessment Builder | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800 min-h-screen relative pb-28 md:pb-32" x-data="assessmentBuilder()">

    <!-- HEADER STICKY -->
    <header class="h-16 md:h-20 bg-white/90 backdrop-blur-xl border-b-2 border-slate-200 sticky top-0 z-40 px-3 md:px-8 flex items-center justify-between shadow-sm w-full">

        <div class="flex items-center gap-2 md:gap-4 min-w-0 flex-1">
            <a href="{{ route('admin.assessments') }}" class="p-1.5 md:p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all shrink-0">
                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div class="h-6 md:h-8 w-px bg-slate-200 shrink-0"></div>
            <div class="truncate">
                <div class="flex items-center gap-1.5 md:gap-2 mb-0.5">
                    <span class="bg-indigo-600 text-white text-[8px] md:text-[10px] font-black uppercase tracking-widest px-1.5 md:px-2 py-0.5 rounded shadow-sm">Editor</span>
                    <span class="text-slate-500 text-[9px] md:text-[10px] font-bold uppercase tracking-widest truncate" x-text="questions.length + ' Pertanyaan'"></span>
                </div>
                <h1 class="text-sm md:text-xl font-black text-slate-900 tracking-tight truncate">{{ $assessment->title }}</h1>
            </div>
        </div>

        <div class="flex items-center gap-2 md:gap-4 shrink-0">
            <button @click="showSettingsModal = true" class="p-1.5 md:px-4 md:py-2.5 bg-slate-100 border border-slate-200 text-slate-600 hover:bg-slate-200 rounded-lg md:rounded-xl font-bold text-xs flex items-center gap-2 transition active:scale-95 shadow-sm">
                <svg class="w-5 h-5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="hidden sm:inline">Konfigurasi Kuis</span>
            </button>

            <button @click="saveQuestions" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 md:px-6 py-2 md:py-2.5 rounded-lg md:rounded-xl text-[10px] md:text-xs font-black transition-all flex items-center gap-1.5 shadow-md shadow-indigo-300 active:scale-95 uppercase tracking-wider">
                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                <span class="hidden sm:inline">Publish</span>
            </button>
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="max-w-4xl mx-auto mt-6 md:mt-10 px-3 md:px-4 space-y-6 md:space-y-8 w-full">

        <!-- INFO MODUL KUIS -->
        <div class="bg-slate-900 rounded-2xl md:rounded-[2rem] p-5 md:p-8 shadow-xl flex flex-col md:flex-row gap-5 md:gap-8 justify-between items-start md:items-center relative overflow-hidden border-b-4 border-indigo-500 w-full gsap-fade">
            <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-4 -translate-y-4">
                <svg class="w-48 h-48 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h-2v5H6v2h2v5h2v-5h2v-2z"></path></svg>
            </div>

            <div class="relative z-10 w-full md:w-auto">
                <h2 class="text-xl md:text-3xl font-black text-white mb-1.5 md:mb-2 leading-tight">Assessment Builder</h2>
                <p class="text-slate-400 text-[11px] md:text-sm leading-relaxed max-w-md">Ketik soal secara manual, atau biarkan AI mengekstrak materi dari PDF menjadi butir soal ujian.</p>
            </div>

            <div class="flex gap-3 md:gap-4 shrink-0 relative z-10 w-full md:w-auto overflow-x-auto custom-scrollbar pb-2 md:pb-0">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-3 md:p-4 rounded-xl md:rounded-2xl text-center min-w-[110px] md:min-w-[130px] shrink-0">
                    <p class="text-[9px] md:text-[10px] font-black text-indigo-300 uppercase tracking-widest mb-1">Target Modul</p>
                    <p class="text-[11px] md:text-xs font-bold text-white truncate max-w-[100px] md:max-w-[130px] mx-auto" title="{{ $assessment->module->title }}">{{ $assessment->module->title }}</p>
                </div>
                <div class="bg-emerald-500/10 backdrop-blur-md border border-emerald-500/30 p-3 md:p-4 rounded-xl md:rounded-2xl text-center min-w-[90px] md:min-w-[110px] shrink-0">
                    <p class="text-[9px] md:text-[10px] font-black text-emerald-300 uppercase tracking-widest mb-1">XP Reward</p>
                    <p class="text-xs md:text-sm font-black text-emerald-400">{{ $assessment->xp_reward }} XP</p>
                </div>
            </div>
        </div>

        <!-- LIST SOAL -->
        <div class="space-y-4 md:space-y-6 w-full">
            <template x-for="(q, index) in questions" :key="q.temp_id">
                <div class="bg-white rounded-2xl md:rounded-[2rem] p-4 md:p-8 shadow-sm border border-slate-200 transition-all relative group hover:border-indigo-300 hover:shadow-md w-full"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform translate-y-4">

                    <!-- Badge AI Generated -->
                    <template x-if="q.is_ai">
                        <div class="absolute -top-3 left-4 md:left-8 bg-gradient-to-r from-fuchsia-600 to-purple-600 text-white text-[9px] md:text-[10px] font-black uppercase tracking-widest px-3 md:px-4 py-1 md:py-1.5 rounded-full shadow-md z-10 flex items-center gap-1.5">
                            ✨ AI Generated
                        </div>
                    </template>

                    <!-- Header Soal (Nomor, Tipe, Hapus) -->
                    <div class="flex flex-row justify-between items-center gap-3 mb-4 md:mb-6 border-b border-slate-100 pb-3 md:pb-4">
                        <div class="flex items-center gap-2 md:gap-4 flex-1">
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl md:rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-xs md:text-sm shrink-0 shadow-sm" x-text="index + 1"></div>

                            <select x-model="q.type" class="bg-slate-100 border border-slate-200 rounded-lg px-2 py-1 md:px-3 md:py-1.5 text-slate-700 text-[10px] md:text-xs font-black outline-none cursor-pointer focus:border-indigo-500 shadow-inner">
                                <option value="pg">Pilihan Ganda</option>
                                <option value="essay">Soal Esai</option>
                            </select>
                        </div>

                        <button @click="removeQuestion(index)" class="text-slate-400 hover:text-white bg-slate-100 hover:bg-rose-500 p-1.5 md:p-2 border border-slate-200 hover:border-rose-600 rounded-lg md:rounded-xl transition-all shadow-sm active:scale-95 shrink-0" title="Hapus Soal">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>

                    <!-- Input Pertanyaan -->
                    <textarea x-model="q.text" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl md:rounded-2xl px-4 py-3 md:px-5 md:py-4 text-xs md:text-sm text-slate-800 font-bold focus:bg-white focus:border-indigo-500 outline-none transition-all resize-none mb-4 md:mb-6 shadow-inner placeholder:text-slate-400" placeholder="Ketik deskripsi pertanyaan di sini..."></textarea>

                    <!-- JIKA PILIHAN GANDA -->
                    <template x-if="q.type === 'pg'">
                        <div class="grid gap-2.5 md:gap-3">
                            <template x-for="(opt, optIndex) in q.options" :key="optIndex">
                                <div class="flex items-center gap-3 p-2.5 md:p-3 rounded-xl border-2 transition-all w-full"
                                     :class="q.correct_answer === optIndex ? 'border-emerald-500 bg-emerald-50' : 'border-slate-200 bg-white'">

                                    <button @click="q.correct_answer = optIndex" class="relative flex items-center justify-center shrink-0">
                                        <div class="w-6 h-6 md:w-8 md:h-8 rounded-lg border-2 transition-all flex items-center justify-center font-black text-[10px] md:text-xs"
                                             :class="q.correct_answer === optIndex ? 'border-emerald-600 bg-emerald-600 text-white shadow-sm' : 'border-slate-300 bg-slate-100 text-slate-400'">
                                            <template x-if="q.correct_answer === optIndex"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                            <template x-if="q.correct_answer !== optIndex"><span x-text="String.fromCharCode(65 + optIndex)"></span></template>
                                        </div>
                                    </button>

                                    <input type="text" x-model="q.options[optIndex]" class="flex-1 w-full bg-transparent text-[11px] md:text-[13px] font-bold text-slate-700 outline-none placeholder:text-slate-400" placeholder="Ketik opsi jawaban...">
                                </div>
                            </template>
                        </div>
                    </template>

                    <!-- JIKA ESAI -->
                    <template x-if="q.type === 'essay'">
                        <div class="bg-indigo-50/50 p-4 md:p-5 rounded-xl border border-indigo-100">
                            <label class="block text-[9px] md:text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-2 flex items-center gap-1.5"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Kunci / Poin Jawaban Esai</label>
                            <textarea x-model="q.essay_guideline" rows="3" class="w-full bg-white border border-indigo-200 rounded-lg px-3 py-2.5 text-[11px] md:text-xs text-slate-700 font-bold focus:border-indigo-500 outline-none transition-all resize-none shadow-sm placeholder:text-slate-400" placeholder="Masukkan poin-poin yang dianggap benar (Opsional)..."></textarea>
                        </div>
                    </template>

                </div>
            </template>
        </div>

        <!-- JIKA KOSONG -->
        <template x-if="questions.length === 0">
            <div class="py-16 md:py-24 flex flex-col items-center justify-center bg-white border-4 border-dashed border-slate-200 rounded-2xl md:rounded-[3rem] w-full text-center px-4 shadow-sm">
                <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4 border border-slate-200 shadow-inner">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <p class="font-black text-slate-600 text-base md:text-xl mb-1">Kanvas Kuis Masih Kosong</p>
                <p class="text-[10px] md:text-xs font-bold text-slate-400 max-w-sm">Mulai tambahkan soal secara manual atau gunakan kekuatan AI untuk membuat soal dari Modul.</p>
            </div>
        </template>
    </main>

    <!-- TOMBOL TAMBAH SOAL MENGAMBANG DI BAWAH -->
    <div class="fixed bottom-6 md:bottom-10 left-1/2 transform -translate-x-1/2 bg-white/95 backdrop-blur-xl border-2 border-slate-200 p-1.5 md:p-2 rounded-full shadow-2xl z-40 flex items-center gap-1 md:gap-2 w-max max-w-[90vw]">
        <button @click="addQuestion('pg')" class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-3 md:px-6 md:py-3.5 rounded-full text-[10px] md:text-xs font-black flex items-center gap-1.5 md:gap-2 transition-all active:scale-95 shadow-md whitespace-nowrap">
            <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            <span class="hidden sm:inline">Tambah</span> Manual
        </button>
        <div class="w-px h-5 md:h-6 bg-slate-300 mx-0.5 md:mx-1"></div>
        <button @click="showAIModal = true" class="bg-indigo-600 hover:bg-indigo-700 border-2 border-indigo-800 text-white px-4 py-3 md:px-6 md:py-3.5 rounded-full text-[10px] md:text-xs font-black flex items-center gap-1.5 md:gap-2 transition-all active:scale-95 shadow-md hover:shadow-lg whitespace-nowrap">
    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 animate-pulse text-indigo-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z" clip-rule="evenodd"></path></svg>
    <span class="hidden sm:inline">Generate</span> AI Soal
</button>
    </div>

    <!-- MODAL AI GENERATOR -->
    <div x-show="showAIModal" x-cloak class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-[100] flex items-center justify-center p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white rounded-2xl md:rounded-[2.5rem] w-full max-w-lg shadow-2xl overflow-hidden border border-slate-200 flex flex-col max-h-[90vh]" @click.outside="if(!isGenerating) showAIModal = false">

            <div class="bg-slate-50 p-5 md:p-8 border-b border-slate-200 shrink-0">
                <div class="flex justify-between items-center mb-3">
                    <div class="bg-indigo-600 p-2 md:p-3 rounded-lg md:rounded-xl text-white shadow-md shadow-indigo-200">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z" clip-rule="evenodd"></path></svg>
                    </div>
                    <button @click="showAIModal = false" x-show="!isGenerating" class="text-slate-400 hover:text-rose-500 bg-white border border-slate-200 hover:border-rose-500 p-2 rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <h3 class="text-lg md:text-2xl font-black text-slate-800 tracking-tight">AI Assessment Helper</h3>
                <p class="text-[10px] md:text-xs font-bold text-slate-500 mt-1">Ekstrak otomatis teks dari file PDF dan buat soal.</p>
            </div>

            <div x-show="!isGenerating" class="p-5 md:p-8 space-y-4 md:space-y-6 overflow-y-auto custom-scrollbar flex-1">
                <div class="bg-indigo-50 p-3 md:p-4 rounded-xl border border-indigo-100 flex items-center gap-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center shrink-0"><svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg></div>
                    <div class="overflow-hidden">
                        <p class="text-[8px] md:text-[9px] font-black text-indigo-500 uppercase tracking-widest">Sumber Modul PDF</p>
                        <p class="text-[10px] md:text-xs font-bold text-slate-700 truncate mt-0.5">{{ $assessment->module->document_file ?? 'Tidak ada file PDF' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 md:gap-4 w-full">
                    <div>
                        <label class="block text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Tipe Soal</label>
                        <select x-model="aiType" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-3 md:px-4 py-2.5 md:py-3 text-[10px] md:text-xs font-bold text-slate-700 outline-none focus:border-indigo-500 transition-all shadow-sm">
                            <option value="pg">Pilihan Ganda</option>
                            <option value="essay">Esai Materi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Jumlah</label>
                        <input type="number" x-model="aiCount" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-3 md:px-4 py-2.5 md:py-3 text-[10px] md:text-xs font-bold text-slate-700 outline-none focus:border-indigo-500 transition-all shadow-sm" min="1" max="10">
                    </div>
                </div>

                <div>
                    <label class="block text-[9px] md:text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Instruksi Khusus (Opsional)</label>
                    <textarea x-model="aiPrompt" rows="3" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-[10px] md:text-xs font-bold text-slate-700 outline-none focus:bg-white focus:border-indigo-500 transition-all resize-none shadow-sm" placeholder="Contoh: Buatkan soal khusus seputar Hukum Termodinamika dari bab 2..."></textarea>
                </div>

                <div class="pt-2">
                    <button @click="generateAIQuestions" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 md:py-3.5 rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest shadow-md shadow-indigo-200 hover:shadow-lg transition-all active:scale-95 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Generate Sekarang
                    </button>
                </div>
            </div>

            <!-- ANIMASI LOADING AI -->
            <div x-show="isGenerating" class="p-10 md:p-20 flex flex-col items-center justify-center text-center flex-1">
                <div class="relative w-16 h-16 md:w-20 md:h-20 mb-6">
                    <div class="absolute inset-0 rounded-full border-4 border-slate-200"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center text-xl md:text-2xl">✨</div>
                </div>
                <h4 class="text-base md:text-lg font-black text-slate-800 animate-pulse uppercase tracking-wider mb-2">AI Sedang Bekerja</h4>
                <p class="text-[10px] md:text-xs font-bold text-slate-500 max-w-[200px]">Membaca file PDF dan merangkai soal otomatis untuk Anda...</p>
            </div>
        </div>
    </div>

    <!-- MODAL SETTING (KONFIGURASI) -->
    <div x-show="showSettingsModal" x-cloak class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-[100] flex items-center justify-center p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white rounded-2xl md:rounded-[2.5rem] w-full max-w-lg shadow-2xl p-6 md:p-10 border border-slate-200 flex flex-col max-h-[90vh]" @click.outside="showSettingsModal = false">

            <div class="flex items-center gap-3 mb-6 md:mb-8 border-b-2 border-slate-100 pb-4 shrink-0">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-slate-800 text-white flex items-center justify-center font-black">⚙️</div>
                <h3 class="text-lg md:text-2xl font-black text-slate-800 tracking-tight">Konfigurasi Kuis</h3>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-1 md:pr-2">
                <form x-ref="settingsForm" @submit.prevent="saveSettings" class="space-y-4 md:space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Durasi Ujian (Menit)</label>
                        <input type="number" name="duration_minutes" value="{{ $assessment->duration_minutes }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-slate-800 transition-all shadow-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4 md:gap-6 w-full">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Passing Grade (KKM)</label>
                            <input type="number" name="passing_grade" value="{{ $assessment->passing_grade }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-slate-800 transition-all shadow-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5 ml-1">Batas Percobaan</label>
                            <input type="number" name="max_attempts" value="{{ $assessment->max_attempts }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:bg-white focus:border-slate-800 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="p-3 md:p-4 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl flex items-center gap-3 md:gap-4 shadow-sm">
                        <input type="checkbox" id="shuffle" name="shuffle_questions" value="1" {{ $assessment->shuffle_questions ? 'checked' : '' }} class="w-5 h-5 md:w-6 md:h-6 rounded text-slate-800 border-slate-300 focus:ring-slate-800">
                        <label for="shuffle" class="text-[10px] md:text-xs font-black text-slate-700 uppercase tracking-wider cursor-pointer select-none">Acak Urutan Soal (Anti Contek)</label>
                    </div>

                    <div class="flex justify-end gap-2 md:gap-3 pt-4 md:pt-6 border-t border-slate-100 mt-2">
                        <button type="button" @click="showSettingsModal = false" class="px-5 md:px-6 py-2.5 md:py-3 rounded-xl bg-slate-100 border border-slate-200 text-slate-600 font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">Batal</button>
                        <button type="submit" class="px-6 md:px-8 py-2.5 md:py-3 rounded-xl bg-slate-800 text-white font-black text-[10px] md:text-xs uppercase tracking-widest hover:bg-slate-900 transition-all shadow-md active:scale-95">Simpan Konfigurasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOGIKA JS ALPINE -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if(typeof gsap !== 'undefined') {
                gsap.from(".gsap-fade", { opacity: 0, y: -20, duration: 0.8, ease: "power3.out" });
            }
        });

        function assessmentBuilder() {
            return {
                showAIModal: false,
                showSettingsModal: false,
                isGenerating: false,
                aiPrompt: '',
                aiType: 'pg',
                aiCount: 3,
                questions: @json($questions ?? []),

                generateTempId() { return Date.now() + Math.floor(Math.random() * 1000); },

                addQuestion(type = 'pg') {
                    this.questions.push({
                        temp_id: this.generateTempId(),
                        type: type,
                        text: '',
                        options: ['', '', '', ''],
                        correct_answer: 0,
                        essay_guideline: '',
                        is_ai: false
                    });
                    this.scrollToBottom();
                },

                removeQuestion(index) {
                    Swal.fire({
                        title: 'Hapus Soal?', text: 'Soal ini akan dihapus dari daftar sementara.',
                        icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#94a3b8', confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
                        customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
                    }).then((res) => { if (res.isConfirmed) this.questions.splice(index, 1); });
                },

                scrollToBottom() {
                    setTimeout(() => {
                        const mainBox = document.querySelector('main');
                        if(mainBox) mainBox.scrollTo({ top: mainBox.scrollHeight, behavior: 'smooth' });
                    }, 100);
                },

                async generateAIQuestions() {
                    this.isGenerating = true;
                    try {
                        const response = await fetch("{{ route('admin.assessments.ai') }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({
                                prompt: this.aiPrompt, type: this.aiType, count: this.aiCount,
                                module_id: {{ $assessment->module_id }}, module_context: "Isi PDF Modul"
                            })
                        });

                        const rawText = await response.text();
                        let data;
                        try { data = JSON.parse(rawText); } catch (e) { throw new Error("Sistem AI mengalami Error Internal. Cek log Laravel."); }

                        if (!response.ok) {
                            let err = data.message || data.error || 'Gagal menghubungi server.';
                            if (data.errors) err = Object.values(data.errors)[0][0];
                            throw new Error(err);
                        }

                        let srcData = Array.isArray(data) ? data : (data.data ? data.data : null);
                        if(!srcData || !Array.isArray(srcData)) throw new Error('Format balasan AI tidak sesuai ekspektasi.');

                        srcData.forEach((q) => {
                            this.questions.push({
                                temp_id: this.generateTempId(),
                                type: q.type,
                                text: q.text,
                                options: q.options || ['', '', '', ''],
                                correct_answer: parseInt(q.correct_answer) || 0,
                                essay_guideline: q.essay_guideline || '',
                                is_ai: true
                            });
                        });

                        this.showAIModal = false;
                        this.aiPrompt = '';
                        this.scrollToBottom();
                        Swal.fire({ icon: 'success', title: 'Berhasil! ✨', text: 'Soal berhasil di-generate.', confirmButtonColor: '#4f46e5', customClass: { popup: 'rounded-[2rem]' } });

                    } catch (error) {
                        Swal.fire({ icon: 'error', title: 'Ups, Ada Kendala', text: error.message, customClass: { popup: 'rounded-[2rem]' } });
                    } finally {
                        this.isGenerating = false;
                    }
                },

                async saveQuestions() {
                    if (this.questions.length === 0) { Swal.fire({ icon: 'warning', title: 'Kuis Kosong', text: 'Silakan tambah minimal 1 soal.', customClass: { popup: 'rounded-[2rem]' } }); return; }

                    const emptyQ = this.questions.find(q => !q.text.trim());
                    if (emptyQ) { Swal.fire({ icon: 'warning', title: 'Teks Soal Kosong', text: 'Pastikan semua teks pertanyaan terisi.', customClass: { popup: 'rounded-[2rem]' } }); return; }

                    Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading(), customClass: { popup: 'rounded-[2rem]' } });

                    try {
                        const response = await fetch("{{ route('admin.assessments.save_questions', $assessment->id) }}", {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ questions: this.questions })
                        });

                        const res = await response.json();
                        if (response.ok && res.success) {
                            Swal.fire({ icon: 'success', title: 'Publikasi Berhasil!', text: 'Semua soal tersimpan di sistem.', confirmButtonColor: '#047857', customClass: { popup: 'rounded-[2rem]' } });
                        } else {
                            throw new Error(res.message || 'Terjadi kesalahan sistem saat menyimpan.');
                        }
                    } catch (error) {
                        Swal.fire({ icon: 'error', title: 'Gagal Simpan', text: error.message, customClass: { popup: 'rounded-[2rem]' } });
                    }
                },

                async saveSettings() {
                    Swal.fire({ title: 'Menyimpan Pengaturan...', allowOutsideClick: false, didOpen: () => Swal.showLoading(), customClass: { popup: 'rounded-[2rem]' } });
                    try {
                        const formData = new FormData(this.$refs.settingsForm);
                        const response = await fetch("{{ route('admin.assessments.update_settings', $assessment->id) }}", {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                            body: formData
                        });

                        if (response.ok) {
                            Swal.fire({ icon: 'success', title: 'Tersimpan!', text: 'Konfigurasi ujian berhasil diperbarui.', timer: 2000, showConfirmButton: false, customClass: { popup: 'rounded-[2rem]' } });
                            this.showSettingsModal = false;
                        } else {
                            throw new Error('Gagal memvalidasi pengaturan. Cek kembali form.');
                        }
                    } catch (error) {
                        Swal.fire({ icon: 'error', title: 'Oops!', text: error.message, customClass: { popup: 'rounded-[2rem]' } });
                    }
                }
            }
        }
    </script>
</body>
</html>
