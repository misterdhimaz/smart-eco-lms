@extends('layouts.student')
@section('title', 'Tugas: ' . $assignment->title)

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<div x-data="assignmentPage()" x-init="initPage()" class="max-w-7xl mx-auto px-2 sm:px-4 md:px-6 pb-20 font-sans text-slate-800">

    <div class="mb-6 sm:mb-8 gsap-fade">
        <a href="{{ route('student.proyek.show', $assignment->classroom_id) }}" class="inline-flex items-center gap-2 px-3.5 py-2 sm:px-4 sm:py-2 bg-white rounded-xl border border-slate-200 text-[11px] sm:text-xs font-black text-slate-500 hover:text-emerald-600 hover:border-emerald-200 hover:shadow-sm transition-all group">
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Detail Kelas
        </a>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-start">

        <div class="flex-1 w-full space-y-6 gsap-fade">
            <div class="bg-white rounded-[2rem] sm:rounded-[3rem] border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] p-5 sm:p-8 md:p-10 relative overflow-hidden">

                <div class="absolute top-0 right-0 w-64 h-64 bg-slate-50 rounded-full blur-[80px] -translate-y-1/2 translate-x-1/4 pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sm:gap-6 mb-6 sm:mb-8 pb-6 sm:pb-8 border-b-2 border-slate-100 relative z-10">
                    <div class="flex items-center gap-4 sm:gap-6">
                        <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-slate-800 to-[#0a2540] text-white rounded-2xl sm:rounded-[1.5rem] flex items-center justify-center text-2xl sm:text-3xl shadow-lg shadow-slate-900/10 shrink-0 transform -rotate-3">
                            📋
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-slate-800 tracking-tight uppercase leading-tight mb-1.5 sm:mb-2">{{ $assignment->title }}</h1>
                            <div class="flex items-center gap-2">
                                <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[9px] sm:text-[10px] font-black uppercase">
                                    {{ substr($assignment->classroom->admin->name, 0, 1) }}
                                </div>
                                <p class="text-[10px] sm:text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                                    Pengajar: <span class="text-slate-700">{{ $assignment->classroom->admin->name }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-[9px] sm:text-[10px] font-black uppercase tracking-widest mb-6 sm:mb-10 relative z-10">
                    <span class="inline-flex items-center gap-1.5 sm:gap-2 bg-slate-50 text-slate-600 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl border border-slate-200 shadow-sm">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Diposting: {{ $assignment->created_at->format('d M Y') }}
                    </span>
                    @if($assignment->due_date)
                    <span class="inline-flex items-center gap-1.5 sm:gap-2 bg-rose-50 text-rose-600 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl border border-rose-100 shadow-sm">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rose-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tenggat: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}
                    </span>
                    @endif
                </div>

                <div class="relative z-10">
                    <h3 class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 sm:mb-4">Instruksi & Deskripsi</h3>
                    <div class="prose max-w-none text-slate-700 font-medium text-xs sm:text-sm leading-relaxed bg-slate-50 p-4 sm:p-6 md:p-8 rounded-2xl sm:rounded-[2rem] border border-slate-100 shadow-inner break-words">
                        {!! nl2br(e($assignment->description)) !!}
                    </div>
                </div>

                @if($assignment->attachment)
                <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t-2 border-slate-100 relative z-10">
                    <p class="text-[10px] sm:text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 sm:mb-4">Lampiran Materi / Format Proyek</p>

                    <button type="button" @click="openPreview('{{ url('/storage/' . $assignment->attachment) }}', 'Lampiran Pengajar')" class="w-full text-left inline-flex items-center gap-3 sm:gap-5 p-3.5 sm:p-4 pr-5 sm:pr-8 bg-white border-2 border-slate-200 rounded-2xl sm:rounded-[1.5rem] hover:border-emerald-400 hover:shadow-lg transition-all group">
                        <div class="w-11 h-11 sm:w-14 sm:h-14 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-xl sm:text-2xl group-hover:scale-110 group-hover:-rotate-3 transition-transform shrink-0">📄</div>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-black text-slate-800 uppercase tracking-tight group-hover:text-emerald-600 transition-colors truncate">File Lampiran Admin</p>
                            <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase mt-0.5 sm:mt-1 tracking-wider">Klik untuk Preview File</p>
                        </div>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="w-full lg:w-[380px] xl:w-[400px] shrink-0 lg:sticky lg:top-24 gsap-fade">
            <div class="bg-white rounded-[2rem] sm:rounded-[3rem] border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.06)] overflow-hidden flex flex-col">

                @if($submission && $submission->grade !== null)
                    <div class="bg-gradient-to-br from-[#047857] to-[#064e3b] p-6 sm:p-8 text-white relative">
                        <div class="absolute -right-8 -bottom-8 text-8xl sm:text-9xl opacity-10 rotate-12 select-none pointer-events-none">🏆</div>
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-400/20 blur-[50px] rounded-full pointer-events-none"></div>

                        <div class="relative z-10 text-center">
                            <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-emerald-200 mb-1.5 sm:mb-2">Nilai Akhir Proyek</p>
                            <div class="flex items-baseline justify-center gap-1 mb-3 sm:mb-4">
                                <p class="text-5xl sm:text-6xl font-black tracking-tighter">{{ $submission->grade }}</p>
                                <p class="text-lg sm:text-xl font-bold text-emerald-200/70">/100</p>
                            </div>

                            @if($submission->admin_feedback)
                            <div class="bg-black/20 backdrop-blur-md p-3.5 sm:p-4 rounded-2xl border border-white/10 text-left mt-2">
                                <p class="text-[9px] font-black uppercase tracking-widest text-emerald-300 mb-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                    Umpan Balik Pengajar
                                </p>
                                <p class="text-xs font-bold text-white leading-relaxed italic break-words">"{{ $submission->admin_feedback }}"</p>
                            </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="p-6 sm:p-8 pb-4 sm:pb-5 border-b-2 border-slate-100 flex items-center justify-between">
                        <h3 class="text-sm sm:text-base font-black text-slate-800 uppercase tracking-tight">Status Tugas</h3>
                        <span class="text-[9px] sm:text-[10px] font-black px-3 py-1 sm:px-4 sm:py-1.5 {{ $submission && $submission->status != 'late' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm' : 'bg-slate-100 text-slate-500 border border-slate-200' }} rounded-xl uppercase tracking-widest">
                            {{ $submission ? 'Telah Diserahkan' : 'Belum Kirim' }}
                        </span>
                    </div>
                @endif

                <div class="p-6 sm:p-8 {{ $submission && $submission->grade !== null ? 'bg-slate-50 border-t border-slate-200 pt-5 sm:pt-6' : 'pt-4 sm:pt-5' }}">
                    <form action="{{ route('student.proyek.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 sm:space-y-6">
                        @csrf

                        @if($submission && $submission->file_path)
                        <div>
                            <label class="block text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 sm:mb-3 ml-1">File Pekerjaan Anda</label>
                            <button type="button" @click="openPreview('{{ url('/storage/' . $submission->file_path) }}', 'Pekerjaan Anda')" class="w-full text-left p-3.5 sm:p-4 bg-white border border-slate-200 rounded-2xl flex items-center gap-3 sm:gap-4 shadow-sm hover:border-emerald-400 hover:shadow-md transition-all group">
                                <span class="w-9 h-9 sm:w-10 sm:h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-base sm:text-lg shrink-0 group-hover:scale-110 transition-transform">✅</span>
                                <div class="overflow-hidden min-w-0 flex-1">
                                    <p class="text-[10px] font-black text-slate-700 uppercase tracking-wider truncate">Terkirim</p>
                                    <p class="text-xs font-bold text-emerald-600 group-hover:text-emerald-700 underline truncate block mt-0.5">Buka & Lihat Pekerjaan</p>
                                </div>
                            </button>
                        </div>
                        @endif

                        @if(!$submission || $submission->grade === null)
                        <div>
                            <label class="block text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 sm:mb-3 ml-1">Upload File Baru</label>
                            <div class="relative group cursor-pointer">
                                <input type="file" name="file_path" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''">

                                <div x-show="!fileName" class="border-2 border-dashed border-slate-300 rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 text-center group-hover:border-emerald-500 group-hover:bg-emerald-50/50 transition-all bg-slate-50">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white rounded-2xl flex items-center justify-center text-xl sm:text-2xl mx-auto shadow-sm mb-3 sm:mb-4 group-hover:scale-110 group-hover:-translate-y-1 transition-transform border border-slate-100">📤</div>
                                    <p class="text-xs font-black text-slate-700 uppercase tracking-widest leading-tight">Unggah / Ganti File<br><span class="text-[9px] font-bold text-slate-400 mt-1 inline-block">(PDF, ZIP, DOCX, IMG)</span></p>
                                </div>

                                <div x-show="fileName" x-cloak class="border-2 border-emerald-400 rounded-[1.5rem] sm:rounded-[2rem] p-6 sm:p-8 text-center bg-emerald-50/80 shadow-inner transition-all">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-xl sm:text-2xl mx-auto shadow-sm mb-3 sm:mb-4 animate-bounce">📄</div>
                                    <p class="text-[10px] font-black text-emerald-800 uppercase tracking-widest leading-tight">
                                        File Siap Dikirim:<br>
                                        <span class="text-xs font-bold text-emerald-600 mt-1.5 inline-block truncate max-w-[180px] sm:max-w-[200px]" x-text="fileName"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-[9px] sm:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 sm:mb-3 ml-1">Komentar Mahasiswa</label>
                            <textarea name="student_comment" rows="3" placeholder="Tambahkan catatan untuk dosen..." class="w-full bg-white border border-slate-200 rounded-2xl sm:rounded-[1.5rem] p-3.5 sm:p-4 text-xs font-bold text-slate-700 outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all resize-none shadow-sm disabled:bg-slate-100 disabled:text-slate-500" {{ $submission && $submission->grade !== null ? 'disabled' : '' }}>{{ $submission->student_comment ?? '' }}</textarea>
                        </div>

                        @if(!$submission || $submission->grade === null)
                        <button type="submit" class="w-full py-3.5 sm:py-4 bg-[#0a2540] text-white rounded-2xl sm:rounded-[1.5rem] font-black uppercase tracking-widest text-[10px] sm:text-[11px] hover:bg-emerald-600 transition-all shadow-xl shadow-slate-900/10 active:scale-95 flex items-center justify-center gap-2 group">
                            {{ $submission ? 'Perbarui Pengumpulan' : 'Tandai Selesai & Kirim' }}
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div x-show="previewOpen" style="display: none;" class="fixed inset-0 z-[100] flex flex-col justify-center items-center p-2 sm:p-4 md:p-6" x-transition.opacity.duration.400ms>

        <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-2xl" @click="closePreview()"></div>

        <div class="relative w-full max-w-6xl h-[95vh] sm:h-[90vh] bg-[#0f172a]/95 backdrop-blur-3xl border border-slate-600/50 shadow-[0_30px_60px_rgba(0,0,0,0.6)] rounded-2xl sm:rounded-[2.5rem] flex flex-col overflow-hidden"
             x-show="previewOpen"
             x-transition:enter="transition ease-out duration-400 transform"
             x-transition:enter-start="opacity-0 translate-y-10 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100">

            <div class="h-14 sm:h-16 px-3 sm:px-6 bg-slate-900/80 border-b border-slate-700/50 flex items-center justify-between shrink-0 relative z-20 gap-2">
                <div class="flex items-center gap-2 sm:gap-4 min-w-0">
                    <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs sm:text-sm border border-emerald-500/30 shadow-inner shrink-0">📄</div>
                    <h3 class="text-slate-200 font-bold text-[11px] sm:text-xs tracking-wider uppercase truncate max-w-[120px] xs:max-w-[180px] sm:max-w-[300px]" x-text="previewTitle"></h3>
                </div>

                <div x-show="fileType === 'pdf'" class="flex items-center gap-1.5 sm:gap-3 bg-slate-950/80 rounded-xl p-1 sm:p-1.5 border border-slate-700/50 shadow-inner">
                    <div class="flex items-center gap-1 text-slate-400 text-[9px] sm:text-[11px] font-black px-1.5 sm:px-3 tracking-widest uppercase">
                        <span class="text-white text-xs sm:text-sm" x-text="currentPage"></span><span class="opacity-50">/</span><span x-text="totalPages"></span>
                    </div>
                    <div class="w-px h-3.5 sm:h-4 bg-slate-700"></div>
                    <button @click="zoomOut()" class="p-1 text-slate-400 hover:text-white hover:bg-slate-700/80 rounded-lg transition-all active:scale-95" title="Perkecil">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg>
                    </button>
                    <span class="text-[10px] sm:text-xs font-mono font-bold text-emerald-400 w-8 sm:w-12 text-center" x-text="Math.round(pdfScale * 100) + '%'"></span>
                    <button @click="zoomIn()" class="p-1 text-slate-400 hover:text-white hover:bg-slate-700/80 rounded-lg transition-all active:scale-95" title="Perbesar">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    </button>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <a :href="previewUrl" download class="hidden sm:flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-emerald-400 hover:text-emerald-300 transition-colors bg-emerald-500/10 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl border border-emerald-500/20 hover:bg-emerald-500/20 active:scale-95">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh
                    </a>
                    <div class="w-px h-5 sm:h-6 bg-slate-700 hidden sm:block"></div>
                    <button @click="closePreview()" class="text-slate-400 hover:text-rose-400 bg-slate-800/80 hover:bg-rose-500/10 p-1.5 sm:p-2 rounded-xl transition-all border border-slate-700/50 hover:border-rose-500/30">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <div class="flex-1 relative overflow-hidden bg-transparent flex flex-col">

                <div x-show="isLoading" class="absolute inset-0 flex flex-col items-center justify-center text-emerald-400 z-10 bg-[#0a0f18]/80 backdrop-blur-sm">
                    <svg class="w-10 h-10 sm:w-12 sm:h-12 animate-spin mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <p class="text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-slate-300">Menyusun Kualitas HD...</p>
                </div>

                <div id="pdfRenderArea" x-show="fileType === 'pdf'" class="w-full h-full overflow-y-auto p-2 sm:p-6 md:p-8 flex flex-col items-center custom-scrollbar" style="scroll-behavior: smooth; -webkit-overflow-scrolling: touch;">
                </div>

                <div x-show="fileType === 'image'" class="w-full h-full flex items-center justify-center p-4 sm:p-6 overflow-auto">
                    <img :src="previewUrl" class="max-w-full max-h-full rounded-xl sm:rounded-2xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-slate-700">
                </div>

                <div x-show="fileType === 'office'" class="w-full h-full flex flex-col items-center justify-center p-2 sm:p-6 relative">
                    <iframe :src="officePreviewUrl" @load="isLoading = false" class="w-full h-full rounded-xl sm:rounded-2xl bg-white shadow-2xl relative z-20" frameborder="0"></iframe>
                </div>

                <div x-show="['other', 'pdf_error'].includes(fileType) && !isLoading" class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 sm:p-6 text-center relative z-20">
                    <div class="w-20 h-20 sm:w-28 sm:h-28 bg-slate-800/80 rounded-full flex items-center justify-center text-3xl sm:text-5xl mb-4 sm:mb-6 shadow-inner border border-slate-700/50 backdrop-blur-md">📦</div>
                    <h3 class="text-xl sm:text-3xl font-black text-white mb-2 sm:mb-3 tracking-tight">Perlu Diunduh</h3>
                    <p class="text-xs sm:text-sm font-medium text-slate-400 mb-6 sm:mb-10 max-w-xs sm:max-w-md">Dokumen ini tidak dapat dibuka di penampil web. Silakan unduh file aslinya ke perangkat Anda.</p>
                    <a :href="previewUrl" download class="px-6 py-3.5 sm:px-10 sm:py-5 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-slate-900 font-black rounded-xl sm:rounded-[1.5rem] text-xs sm:text-sm uppercase tracking-widest transition-all hover:scale-105 active:scale-95 shadow-[0_10px_25px_rgba(16,185,129,0.3)]">
                        Unduh File Sekarang
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let rawPdfDoc = null; // Menyimpan raw doc di luar AlpineJS untuk menghindari masalah Proxy/Crash

    function assignmentPage() {
        return {
            fileName: '',
            previewOpen: false,
            previewUrl: '',
            officePreviewUrl: '',
            previewTitle: '',
            isLoading: false,
            fileType: '',

            // Penyesuaian Skala Skrin Awal berdasarkan Device
            pdfScale: window.innerWidth < 640 ? 0.65 : (window.innerWidth < 1024 ? 0.9 : 1.3),
            currentPage: 0,
            totalPages: 0,
            observer: null,

            initPage() {
                if(typeof gsap !== 'undefined') {
                    gsap.from(".gsap-fade", { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, ease: "power2.out" });
                }
            },

            openPreview(url, title) {
                this.previewUrl = url;
                this.previewTitle = title;
                this.previewOpen = true;
                this.isLoading = true;
                document.body.style.overflow = 'hidden';

                let cleanUrl = url.split('?')[0];
                let ext = cleanUrl.split('.').pop().toLowerCase();

                if(['pdf'].includes(ext)) {
                    this.fileType = 'pdf';
                    this.loadCustomPDF(url);
                }
                else if(['jpg','jpeg','png','webp', 'gif'].includes(ext)) {
                    this.fileType = 'image';
                    this.isLoading = false;
                }
                else if(['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(ext)) {
                    this.fileType = 'office';
                    this.officePreviewUrl = `https://docs.google.com/gview?url=${encodeURIComponent(url)}&embedded=true`;
                }
                else {
                    this.fileType = 'other';
                    this.isLoading = false;
                }
            },

            closePreview() {
                this.previewOpen = false;
                document.body.style.overflow = 'auto';

                setTimeout(() => {
                    this.previewUrl = '';
                    this.officePreviewUrl = '';
                    this.previewTitle = '';
                    this.fileType = '';
                    let area = document.getElementById('pdfRenderArea');
                    if(area) area.innerHTML = '';
                    if(this.observer) this.observer.disconnect();
                    rawPdfDoc = null;
                }, 400);
            },

            // --- FUNGSI MESIN RENDER PDF.JS (KUALITAS HD) ---
            loadCustomPDF(url) {
                const container = document.getElementById('pdfRenderArea');
                if(container) container.innerHTML = '';

                pdfjsLib.getDocument(url).promise.then(doc => {
                    rawPdfDoc = doc;
                    this.totalPages = doc.numPages;
                    this.currentPage = 1;
                    this.isLoading = false;
                    this.renderAllPages();
                }).catch(err => {
                    console.error("GAGAL Render PDF:", err);
                    this.fileType = 'pdf_error';
                    this.isLoading = false;
                });
            },

            renderAllPages() {
                if (!rawPdfDoc) return;

                const container = document.getElementById('pdfRenderArea');
                if(!container) return;
                container.innerHTML = '';

                if (this.observer) this.observer.disconnect();
                this.observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && entry.intersectionRatio >= 0.25) {
                            this.currentPage = entry.target.getAttribute('data-page-num');
                        }
                    });
                }, { threshold: 0.25 });

                for(let i = 1; i <= rawPdfDoc.numPages; i++) {
                    let wrapper = document.createElement('div');
                    wrapper.className = 'w-full flex justify-center mb-6 sm:mb-8 shadow-[0_15px_40px_rgba(0,0,0,0.4)] bg-transparent transition-transform duration-300';
                    wrapper.setAttribute('data-page-num', i);

                    let canvas = document.createElement('canvas');
                    canvas.className = 'max-w-full bg-white rounded-lg sm:rounded-xl shadow-inner border border-slate-700/30';

                    wrapper.appendChild(canvas);
                    container.appendChild(wrapper);
                    this.observer.observe(wrapper);

                    rawPdfDoc.getPage(i).then(page => {
                        let viewport = page.getViewport({ scale: this.pdfScale });

                        // MENINGKATKAN KUALITAS RENDER (HD/RETINA DISPLAY)
                        let outputScale = window.devicePixelRatio || 1;
                        canvas.width = Math.floor(viewport.width * outputScale);
                        canvas.height = Math.floor(viewport.height * outputScale);
                        canvas.style.width = Math.floor(viewport.width) + "px";
                        canvas.style.height = Math.floor(viewport.height) + "px";

                        let transform = outputScale !== 1 ? [outputScale, 0, 0, outputScale, 0, 0] : null;

                        let renderContext = {
                            canvasContext: canvas.getContext('2d'),
                            transform: transform,
                            viewport: viewport
                        };
                        page.render(renderContext);
                    });
                }
            },

            zoomIn() {
                if(this.pdfScale >= 3.0) return;
                this.pdfScale += 0.2;
                this.renderAllPages();
            },

            zoomOut() {
                if(this.pdfScale <= 0.4) return;
                this.pdfScale -= 0.2;
                this.renderAllPages();
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }

    /* SCROLLBAR PREMIUM BANGET UNTUK SEMUA DEVICE */
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    @media (min-width: 640px) {
        .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(51, 65, 85, 0.6); border-radius: 20px; border: 2px solid #0f172a; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(16, 185, 129, 0.8); }
</style>
@endsection
