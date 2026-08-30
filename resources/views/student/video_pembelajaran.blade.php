@extends('layouts.student')
@section('title', 'Video Pembelajaran | SMART-ECO')

@section('content')
<script src="https://www.youtube.com/iframe_api"></script>

<div x-data="videoApp({{ json_encode($categories) }})" x-init="initApp()" class="w-full h-full flex flex-col font-sans relative">

    <!-- HALAMAN DEPAN: DAFTAR KATEGORI MODUL -->
    <div x-show="viewState === 'categories'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 y-4" x-transition:enter-end="opacity-100 y-0" class="w-full max-w-[1500px] mx-auto space-y-6 md:space-y-8 pb-10">

        <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 rounded-2xl lg:rounded-[2rem] p-6 md:p-8 xl:p-10 text-white overflow-hidden border border-slate-800 shadow-2xl">
            <div class="absolute -right-10 -bottom-10 w-48 md:w-80 h-48 md:h-80 bg-emerald-500/20 rounded-full blur-[80px] md:blur-[120px] pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 md:gap-2 bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 px-3 py-1.5 md:px-3.5 md:py-1.5 rounded-full text-[9px] md:text-[11px] font-black uppercase tracking-widest mb-3 md:mb-4">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    E-Learning Hub
                </span>
                <h1 class="text-2xl md:text-4xl lg:text-5xl font-black tracking-tight leading-tight mb-2 md:mb-4">
                    Eksplorasi Modul <br class="hidden sm:block"> <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-200">Video Pembelajaran</span>
                </h1>
                <p class="text-slate-300 text-[10px] md:text-sm lg:text-base font-medium leading-relaxed">
                    Selesaikan video secara berurutan. Jika Anda keluar, sistem otomatis melanjutkan dari materi terakhir.
                </p>
            </div>
        </div>

        <div>
            <div class="flex items-center justify-between mb-4 md:mb-6 px-1">
                <h2 class="text-lg md:text-xl font-black text-slate-800 tracking-tight">Kurikulum Berurutan</h2>
                <span class="text-[10px] md:text-xs font-bold text-slate-400" x-text="filteredCategories.length + ' Modul'"></span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                <template x-for="(category, idx) in filteredCategories" :key="category.id">

                    <!-- KARTU MODUL (Dengan Gembok) -->
                    <div @click="category.is_unlocked ? openCategory(category) : showLockedMessage('Selesaikan seluruh video di modul sebelumnya terlebih dahulu!')"
                         class="bg-white rounded-2xl md:rounded-[2rem] border shadow-sm transition-all duration-300 overflow-hidden flex flex-col group relative"
                         :class="category.is_unlocked ? 'border-slate-200/80 cursor-pointer hover:shadow-xl hover:-translate-y-1' : 'border-slate-200 opacity-75 grayscale cursor-not-allowed'">

                        <!-- OVERLAY GEMBOK -->
                        <template x-if="!category.is_unlocked">
                            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px] z-20 flex flex-col items-center justify-center text-white">
                                <span class="text-4xl md:text-5xl mb-2 md:mb-3 drop-shadow-md">🔒</span>
                                <span class="bg-slate-900/90 border border-white/20 px-3 md:px-4 py-1.5 md:py-2 rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest shadow-xl">Modul Terkunci</span>
                            </div>
                        </template>

                        <div class="h-36 md:h-48 relative overflow-hidden bg-slate-100 shrink-0">
                            <img :src="category.thumbnail" :alt="category.title" class="w-full h-full object-cover transition-transform duration-500" :class="category.is_unlocked ? 'group-hover:scale-105' : ''">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>

                            <span class="absolute top-3 md:top-4 left-3 md:left-4 bg-white/90 backdrop-blur-md text-slate-800 px-2 md:px-3 py-1 rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-wider shadow-sm flex items-center gap-1.5">
                                <span class="w-4 h-4 rounded bg-slate-800 text-white flex items-center justify-center leading-none" x-text="idx + 1"></span>
                                <span x-text="category.badge"></span>
                            </span>

                            <span class="absolute bottom-3 md:bottom-4 right-3 md:right-4 text-white px-2.5 md:px-3 py-1 rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-wider shadow-sm flex items-center gap-1"
                                  :class="category.is_completed ? 'bg-emerald-500' : 'bg-slate-700/80 backdrop-blur-md'">
                                <svg class="w-3 md:w-3.5 h-3 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                <span x-text="category.videos.length + ' Video'"></span>
                            </span>
                        </div>

                        <div class="p-4 md:p-6 flex-1 flex flex-col justify-between space-y-3 md:space-y-4">
                            <div>
                                <h3 class="text-sm md:text-lg font-black text-slate-800 transition-colors leading-snug mb-1 md:mb-2 line-clamp-2"
                                    :class="category.is_unlocked ? 'group-hover:text-emerald-600' : ''"
                                    x-text="category.title"></h3>
                                <p class="text-[10px] md:text-xs text-slate-500 font-medium leading-relaxed line-clamp-2" x-text="category.description"></p>
                            </div>

                            <div class="pt-3 md:pt-4 border-t border-slate-100 flex items-center justify-between text-[10px] md:text-xs font-bold"
                                 :class="category.is_completed ? 'text-emerald-600' : (category.is_unlocked ? 'text-blue-600' : 'text-slate-400')">
                                <span x-text="category.is_completed ? 'Modul Selesai' : (category.is_unlocked ? 'Lanjutkan Belajar' : 'Terkunci')"></span>
                                <template x-if="category.is_completed"><svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                <template x-if="category.is_unlocked && !category.is_completed"><svg class="w-3.5 h-3.5 md:w-4 md:h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg></template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- HALAMAN DETAIL: PEMUTAR VIDEO & DAFTAR (DIOPTIMALKAN UNTUK LANDSCAPE & PORTRAIT MOBILE) -->
    <!-- Menggunakan h-[100dvh] dan flex-col agar pas di layar tanpa scroll halaman utama -->
    <div x-show="viewState === 'detail'" x-cloak class="fixed inset-0 z-[100] bg-slate-900 flex flex-col h-[100dvh] w-screen overflow-hidden">

        <!-- HEADER KEMBALI -->
        <div class="h-12 md:h-16 bg-[#050B14] border-b border-slate-800 flex items-center justify-between px-3 md:px-6 shrink-0 z-20">
            <div class="flex items-center gap-3 text-white min-w-0 max-w-[70%] md:max-w-[50%]">
                <button @click="backToCategories()" class="w-8 h-8 md:w-10 md:h-10 rounded-lg bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white flex items-center justify-center transition-colors shrink-0">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div class="truncate">
                    <span class="text-[8px] md:text-[10px] font-black text-emerald-500 uppercase tracking-widest block mb-0.5" x-text="selectedCategory?.badge"></span>
                    <h2 class="text-xs md:text-sm font-black tracking-wide truncate" x-text="selectedCategory?.title"></h2>
                </div>
            </div>

            <!-- INDIKATOR PROGRESS -->
            <div class="hidden sm:flex items-center gap-3">
                <div class="text-right">
                    <p class="text-[9px] font-black uppercase text-slate-400">Progress Modul</p>
                    <p class="text-xs font-bold text-white"><span x-text="activeVideoIndex + 1"></span> dari <span x-text="selectedCategory?.videos.length"></span></p>
                </div>
            </div>
        </div>

        <!-- LAYOUT UTAMA: FLEX COLUMN DI PORTRAIT, FLEX ROW DI LANDSCAPE -->
        <div class="flex-1 flex flex-col lg:flex-row min-h-0 bg-slate-950 overflow-hidden relative z-10">

            <!-- AREA VIDEO (70% lebar di Desktop/Landscape) -->
            <div class="flex flex-col w-full lg:w-[70%] h-auto lg:h-full shrink-0 border-b lg:border-b-0 lg:border-r border-slate-800 shadow-xl z-20">

                <!-- PEMUTAR VIDEO -->
                <div class="w-full bg-black aspect-video lg:aspect-auto lg:h-[65vh] xl:h-[68vh] relative shrink-0">
                    <template x-if="activeVideo && activeVideo.type === 'youtube'">
                        <iframe :id="'youtube-iframe-' + activeVideo.id"
                                :src="'https://www.youtube.com/embed/' + extractYtId(activeVideo.video_src) + '?enablejsapi=1&autoplay=1&rel=0&modestbranding=1'"
                                class="w-full h-full absolute inset-0 border-0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                        </iframe>
                    </template>
                    <template x-if="activeVideo && activeVideo.type === 'upload'">
                        <video :id="'html5-video-player-' + activeVideo.id" controls controlsList="nodownload" class="w-full h-full object-contain absolute inset-0 bg-black"
                               :src="activeVideo.video_src" @ended="videoEnded()">
                            Browser Anda tidak mendukung HTML5.
                        </video>
                    </template>
                </div>

                <!-- INFO VIDEO (Scrollable di bawah video) -->
                <div class="flex-1 p-4 md:p-6 lg:p-8 bg-slate-900 overflow-y-auto custom-scrollbar">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 border-b border-slate-800 pb-4 mb-4">
                        <div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1.5 flex items-center gap-2">
                                <span class="bg-slate-800 px-2 py-0.5 rounded text-white">Video <span x-text="activeVideoIndex + 1"></span></span>
                                <span x-text="activeVideo?.type === 'youtube' ? '🔴 YouTube' : '📁 Internal MP4'" :class="activeVideo?.type === 'youtube' ? 'text-rose-500' : 'text-indigo-400'"></span>
                            </span>
                            <h3 class="text-sm md:text-xl font-black text-white leading-snug" x-text="activeVideo?.title"></h3>
                        </div>

                        <div class="px-3 py-1.5 md:px-4 md:py-2 rounded-lg md:rounded-xl font-black text-[9px] md:text-[10px] uppercase tracking-widest flex items-center justify-center gap-1.5 shrink-0 border border-emerald-500/30"
                             :class="activeVideo?.is_completed ? 'bg-emerald-500/10 text-emerald-400 shadow-inner' : 'bg-slate-800 text-slate-400'">
                            <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            <span x-text="activeVideo?.is_completed ? 'Selesai (+ XP)' : 'Tonton Sampai Habis'"></span>
                        </div>
                    </div>
                    <p class="text-[11px] md:text-sm text-slate-300 font-medium leading-relaxed" x-text="activeVideo?.description || 'Tidak ada deskripsi untuk materi ini.'"></p>
                </div>
            </div>

            <!-- AREA DAFTAR PLAYLIST (30% lebar di Desktop/Landscape) -->
            <div class="w-full lg:w-[30%] flex flex-col shrink-0 h-[40vh] lg:h-full bg-[#0B1120]">
                <div class="p-3 md:p-5 border-b border-slate-800 bg-slate-900 shrink-0 shadow-sm flex items-center justify-between">
                    <h4 class="font-black text-white text-[10px] md:text-xs uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Daftar Video
                    </h4>
                    <span class="text-[9px] font-bold text-slate-400 bg-slate-800 px-2 py-1 rounded" x-text="selectedCategory?.videos.length + ' Item'"></span>
                </div>

                <div class="flex-1 overflow-y-auto p-2 md:p-4 space-y-2 custom-scrollbar">
                    <template x-for="(video, idx) in selectedCategory?.videos" :key="video.id">

                        <button @click="video.is_unlocked ? selectVideo(idx) : showLockedMessage('Tonton video sebelumnya sampai selesai untuk membuka materi ini!')"
                                class="w-full p-3 md:p-4 rounded-xl border text-left transition-all flex items-start md:items-center gap-3 group relative overflow-hidden"
                                :class="{
                                    'bg-emerald-900/30 border-emerald-500/50 shadow-inner': activeVideoIndex === idx,
                                    'bg-slate-900 border-slate-800 hover:bg-slate-800 hover:border-slate-700': activeVideoIndex !== idx && video.is_unlocked,
                                    'bg-[#050B14] border-slate-800/50 opacity-60 cursor-not-allowed': !video.is_unlocked
                                }">

                            <!-- Angka/Checklist -->
                            <div class="w-6 h-6 md:w-8 md:h-8 rounded md:rounded-lg flex items-center justify-center shrink-0 text-[9px] md:text-[11px] font-black transition-colors z-10"
                                 :class="video.is_completed ? 'bg-emerald-500 text-white shadow-sm' : (activeVideoIndex === idx ? 'bg-white text-emerald-900' : 'bg-slate-800 text-slate-400')">
                                <template x-if="video.is_completed"><svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></template>
                                <template x-if="!video.is_completed"><span x-text="idx + 1"></span></template>
                            </div>

                            <div class="flex-1 min-w-0 z-10 pt-0.5 md:pt-0">
                                <p class="text-[10px] md:text-xs font-bold truncate transition-colors" :class="activeVideoIndex === idx ? 'text-white' : 'text-slate-300 group-hover:text-white'" x-text="video.title"></p>
                                <p class="text-[8px] md:text-[9px] font-bold text-slate-500 mt-0.5 md:mt-1 flex items-center gap-1.5">
                                    <span class="text-cyan-500" x-text="video.duration"></span> <span class="opacity-50">•</span> <span x-text="video.type === 'youtube' ? 'YouTube' : 'MP4'"></span>
                                </p>
                            </div>

                            <!-- ICON GEMBOK -->
                            <template x-if="!video.is_unlocked">
                                <div class="ml-auto text-slate-600 mt-1 md:mt-0 z-10">
                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            </template>

                            <!-- Garis Animasi Aktif -->
                            <template x-if="activeVideoIndex === idx">
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-400"></div>
                            </template>
                        </button>
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
<script>
    function videoApp(categoriesData) {
        return {
            categories: categoriesData,
            searchQuery: '',
            viewState: 'categories',
            selectedCategory: null,
            activeVideoIndex: 0,
            ytPlayer: null,

            get filteredCategories() {
                if (!this.searchQuery) return this.categories;
                const q = this.searchQuery.toLowerCase();
                return this.categories.filter(c => c.title.toLowerCase().includes(q) || c.description.toLowerCase().includes(q));
            },

            get activeVideo() {
                return this.selectedCategory && this.selectedCategory.videos.length > 0 ? this.selectedCategory.videos[this.activeVideoIndex] : null;
            },

            initApp() { },

            extractYtId(url) {
                if (!url) return '';
                let match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
                return (match && match[1]) ? match[1] : url;
            },

            openCategory(category) {
                this.selectedCategory = category;
                let firstUnfinished = category.videos.findIndex(v => !v.is_completed);
                this.activeVideoIndex = firstUnfinished !== -1 ? firstUnfinished : 0;

                this.viewState = 'detail';
                // Hindari scroll body latar belakang saat modal aktif
                document.body.style.overflow = 'hidden';
                this.setupVideoListeners();
            },

            backToCategories() {
                this.viewState = 'categories';
                this.selectedCategory = null;
                document.body.style.overflow = '';

                if(this.ytPlayer && typeof this.ytPlayer.pauseVideo === 'function') {
                    try { this.ytPlayer.pauseVideo(); } catch(e){}
                }
                document.querySelectorAll('video').forEach(vid => vid.pause());
            },

            selectVideo(index) {
                if(this.ytPlayer && typeof this.ytPlayer.pauseVideo === 'function') {
                    try { this.ytPlayer.pauseVideo(); } catch(e){}
                }
                document.querySelectorAll('video').forEach(vid => vid.pause());

                this.ytPlayer = null;
                this.activeVideoIndex = index;
                this.setupVideoListeners();
            },

            showLockedMessage(message) {
                Swal.fire({ icon: 'warning', title: 'Akses Terkunci 🔒', text: message, confirmButtonColor: '#10b981', customClass: { popup: 'rounded-3xl' } });
            },

            setupVideoListeners() {
                this.$nextTick(() => {
                    let video = this.activeVideo;
                    if (!video) return;

                    if (video.type === 'youtube') {
                        let iframeId = 'youtube-iframe-' + video.id;
                        let iframe = document.getElementById(iframeId);
                        if(!iframe) return;

                        let checkYT = setInterval(() => {
                            if (window.YT && window.YT.Player) {
                                clearInterval(checkYT);
                                this.ytPlayer = new YT.Player(iframeId, {
                                    events: { 'onStateChange': (event) => { if (event.data === 0) this.videoEnded(); } }
                                });
                            }
                        }, 200);
                    }
                    else if (video.type === 'upload') {
                        let html5Vid = document.getElementById('html5-video-player-' + video.id);
                        if(html5Vid) { html5Vid.load(); html5Vid.play().catch(e => console.log('Autoplay ditahan browser')); }
                    }
                });
            },

            videoEnded() {
                let video = this.activeVideo;
                if (video.is_completed) return;

                fetch("{{ route('student.claim_video_xp') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({ video_id: video.id })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        video.is_completed = true;
                        let nextVideoIndex = this.activeVideoIndex + 1;
                        if (this.selectedCategory.videos[nextVideoIndex]) {
                            this.selectedCategory.videos[nextVideoIndex].is_unlocked = true;
                        }

                        let allDone = this.selectedCategory.videos.every(v => v.is_completed);
                        if (allDone) {
                            this.selectedCategory.is_completed = true;
                            let catIndex = this.categories.findIndex(c => c.id === this.selectedCategory.id);
                            if (this.categories[catIndex + 1]) {
                                this.categories[catIndex + 1].is_unlocked = true;
                                if(this.categories[catIndex + 1].videos.length > 0){
                                    this.categories[catIndex + 1].videos[0].is_unlocked = true;
                                }
                            }
                        }

                        if(data.level_up) {
                            Swal.fire({ title: 'LEVEL UP! 🎉', text: 'Selamat! Kamu telah naik ke Level ' + data.new_level + ' (+10 XP)', icon: 'success', confirmButtonColor: '#10b981', customClass: { popup: 'rounded-[2rem]' } });
                        } else {
                            let successMsg = allDone ? 'Modul Tuntas! Modul selanjutnya kini terbuka 🔓' : 'Video Selesai! Video selanjutnya terbuka 🔓';
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: successMsg, showConfirmButton: false, timer: 4000 });
                        }
                    }
                });
            }
        }
    }
</script>
@endpush
