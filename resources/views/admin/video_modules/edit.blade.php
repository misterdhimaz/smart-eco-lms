<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Modul Video | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex overflow-hidden" x-data="{ sidebarOpen: false }">

    <!-- OVERLAY MOBILE -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

    <!-- SIDEBAR -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
        <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-100">

        <!-- HEADER KECIL -->
        <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
            <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="truncate">
                    <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Edit <span class="text-emerald-600">Modul Video</span></h1>
                </div>
            </div>
        </header>

        <!-- FORM WRAPPER STICKY FOOTER -->
        <form action="{{ route('admin.video-modules.update', $module->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col h-full overflow-hidden w-full" x-data="videoForm({{ json_encode($module->videos) }})">
            @csrf
            @method('PUT')

            <!-- KONTEN SCROLLABLE -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-8 custom-scrollbar w-full relative z-10">
                <div class="max-w-[1000px] mx-auto space-y-6 md:space-y-8 w-full pb-10">

                    <!-- NAVIGASI KEMBALI -->
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.video-modules.index') }}" class="inline-flex items-center gap-1.5 md:gap-2 px-3 py-1.5 bg-white border-2 border-slate-200 rounded-lg text-[10px] md:text-xs font-bold text-slate-600 hover:text-emerald-700 hover:border-emerald-300 hover:bg-emerald-50 transition-all shadow-sm active:scale-95">
                            <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali Batal
                        </a>
                    </div>

                    @if($errors->any())
                        <div class="bg-rose-50 border-2 border-rose-200 text-rose-800 p-4 md:p-5 rounded-xl md:rounded-2xl text-[10px] md:text-xs font-bold space-y-1.5 shadow-sm">
                            @foreach($errors->all() as $error)
                                <p class="flex items-center gap-2"><span class="w-4 h-4 bg-rose-200 text-rose-700 rounded-full flex items-center justify-center">!</span> {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- BOX 1: INFO MODUL -->
                    <div class="bg-white rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm p-4 md:p-8 w-full border-t-4 border-t-emerald-500">
                        <h2 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest border-b-2 border-slate-100 pb-3 mb-5 flex items-center gap-2">
                            <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px]">1</span> Informasi Album Modul
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 mb-4 md:mb-6">
                            <div>
                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Badge / Label</label>
                                <input type="text" name="badge" value="{{ old('badge', $module->badge) }}" required placeholder="Contoh: Modul 01" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 focus:bg-white transition-colors shadow-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Judul Utama</label>
                                <input type="text" name="title" value="{{ old('title', $module->title) }}" required placeholder="Contoh: Dasar Perubahan Iklim" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 focus:bg-white transition-colors shadow-sm">
                            </div>
                        </div>

                        <div class="mb-4 md:mb-6">
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Deskripsi Ringkas</label>
                            <textarea name="description" rows="3" required placeholder="Tuliskan gambaran ringkas mengenai modul ini..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 focus:bg-white resize-none transition-colors shadow-sm">{{ old('description', $module->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Ganti Cover Gambar (Opsional)</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-xs font-bold text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-slate-800 file:text-white cursor-pointer border-2 border-dashed border-slate-300 rounded-xl p-2 bg-slate-50 hover:bg-slate-100 transition-colors">
                            @if($module->cover_image)
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-500 mt-2 ml-1">Cover aktif: <a href="{{ asset('storage/' . $module->cover_image) }}" target="_blank" class="text-emerald-600 underline">Lihat Gambar</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- BOX 2: PLAYLIST VIDEO -->
                    <div class="bg-white rounded-2xl md:rounded-[2rem] border-2 border-slate-200 shadow-sm p-4 md:p-8 w-full border-t-4 border-t-blue-600">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 border-b-2 border-slate-100 pb-4 mb-5">
                            <div>
                                <h2 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-6 h-6 rounded bg-blue-600 text-white flex items-center justify-center text-[10px]">2</span> Playlist Video Materi
                                </h2>
                                <p class="text-[9px] md:text-[10px] font-bold text-slate-400 mt-1">Ubah sumber video YouTube, atau ganti file MP4.</p>
                            </div>
                            <button type="button" @click="addVideo()" class="w-full sm:w-auto px-4 py-2.5 bg-blue-50 border-2 border-blue-200 text-blue-700 hover:bg-blue-600 hover:text-white text-[10px] md:text-xs font-black uppercase tracking-widest rounded-xl transition-all shadow-sm active:scale-95 flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Video Baris
                            </button>
                        </div>

                        <div class="space-y-4 md:space-y-6">
                            <template x-for="(video, index) in videos" :key="video.id">
                                <div class="p-4 md:p-6 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl relative shadow-sm transition-all">

                                    <div class="flex items-center justify-between border-b-2 border-slate-200 pb-3 mb-4">
                                        <span class="text-[10px] md:text-xs font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                                            <span class="w-6 h-6 rounded bg-slate-800 text-white flex items-center justify-center text-[10px]" x-text="index + 1"></span>
                                            Edit Data Video
                                        </span>
                                        <button type="button" @click="removeVideo(index)" x-show="videos.length > 1" class="text-rose-600 bg-white border-2 border-rose-200 hover:bg-rose-50 px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest transition-colors shadow-sm active:scale-95">
                                            Hapus
                                        </button>
                                    </div>

                                    <input type="hidden" :name="`videos[${index}][id]`" :value="video.db_id">

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-5 mb-4 md:mb-5">
                                        <div>
                                            <label class="block text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Judul Video Ini</label>
                                            <input type="text" :name="`videos[${index}][title]`" x-model="video.title" required placeholder="Judul Video..." class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-blue-500 transition-colors shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Tipe Sumber</label>
                                            <div class="grid grid-cols-2 gap-2 md:gap-3">
                                                <label class="px-3 py-2.5 border-2 rounded-xl flex items-center justify-center gap-1.5 md:gap-2 cursor-pointer text-[10px] md:text-xs font-black transition-all shadow-sm" :class="video.type === 'youtube' ? 'bg-rose-50 border-rose-500 text-rose-700' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                                    <input type="radio" :name="`videos[${index}][type]`" value="youtube" x-model="video.type" class="hidden"> 🔴 YouTube
                                                </label>
                                                <label class="px-3 py-2.5 border-2 rounded-xl flex items-center justify-center gap-1.5 md:gap-2 cursor-pointer text-[10px] md:text-xs font-black transition-all shadow-sm" :class="video.type === 'upload' ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'bg-white border-slate-200 text-slate-500 hover:bg-slate-50'">
                                                    <input type="radio" :name="`videos[${index}][type]`" value="upload" x-model="video.type" class="hidden"> 📁 File MP4
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4 md:p-5 rounded-xl border-2 transition-colors mb-4 md:mb-5" :class="video.type === 'youtube' ? 'bg-white border-rose-200' : 'bg-white border-indigo-200'">
                                        <div x-show="video.type === 'youtube'">
                                            <label class="block text-[9px] md:text-[10px] font-black text-rose-600 uppercase tracking-widest mb-1.5">Link URL YouTube</label>
                                            <input type="text" :name="`videos[${index}][youtube_url]`" x-model="video.youtube_url" @input="detectYoutubeDetails(index)" placeholder="https://www.youtube.com/watch?v=..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-mono font-bold text-slate-800 outline-none focus:border-rose-500 transition-colors shadow-inner">
                                            <p class="text-[9px] font-bold text-slate-500 mt-2">*Sistem akan mencoba mengisi durasi secara otomatis dari link.</p>
                                        </div>
                                        <div x-show="video.type === 'upload'" style="display: none;">
                                            <label class="block text-[9px] md:text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-1.5">Ganti Berkas Video (MP4) - Opsional</label>
                                            <input type="file" :name="`videos[${index}][video_file]`" accept="video/mp4,video/webm" @change="detectVideoDuration($event, index)" class="w-full text-xs font-bold text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:text-white cursor-pointer border-2 border-dashed border-slate-300 rounded-xl p-2 bg-slate-50 transition-colors">
                                            <input type="hidden" :name="`videos[${index}][existing_file]`" :value="video.existing_file">
                                            <template x-if="video.existing_file">
                                                <p class="text-[9px] md:text-[10px] text-slate-500 mt-2 font-bold">File MP4 Saat ini: <a :href="'/storage/' + video.existing_file" target="_blank" class="text-indigo-600 underline">Tonton Asli</a></p>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5 border-t-2 border-slate-200 pt-4 md:pt-5">
                                        <div>
                                            <label class="block text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Durasi</label>
                                            <input type="text" :name="`videos[${index}][duration]`" x-model="video.duration" required placeholder="00:00" class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-mono font-black text-emerald-600 outline-none focus:border-emerald-500 transition-colors shadow-sm">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Deskripsi Ringkas</label>
                                            <input type="text" :name="`videos[${index}][description]`" x-model="video.description" placeholder="Penjelasan singkat materi di video ini..." class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors shadow-sm">
                                        </div>
                                    </div>

                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </main>

            <!-- STICKY BOTTOM BAR FOOTER -->
            <div class="bg-white border-t-2 border-slate-200 p-4 shrink-0 z-20 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] w-full relative">
                <div class="max-w-[1200px] mx-auto flex items-center justify-between gap-4">
                    <p class="text-[9px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest hidden sm:block">* Pastikan semua kolom video terisi dengan benar.</p>
                    <div class="flex items-center justify-between sm:justify-end gap-2 md:gap-3 w-full sm:w-auto">
                        <a href="{{ route('admin.video-modules.index') }}" class="flex-1 sm:flex-none px-4 md:px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-xl text-[10px] md:text-xs uppercase tracking-widest transition-all text-center border-2 border-slate-200">Batal</a>
                        <button type="submit" class="flex-1 sm:flex-none px-4 md:px-8 py-3.5 bg-slate-900 hover:bg-emerald-600 text-white font-black rounded-xl text-[10px] md:text-xs uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Edit Data
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <!-- LOGIKA JAVASCRIPT (TETAP AMAN) -->
    <script>
        function videoForm(existingVideosData) {
            const mappedVideos = existingVideosData.map(v => {
                let ytUrl = '';
                if (v.type === 'youtube') ytUrl = v.video_url.includes('http') ? v.video_url : 'https://www.youtube.com/watch?v=' + v.video_url;
                return {
                    id: Date.now() + Math.random(), db_id: v.id, title: v.title, type: v.type, youtube_url: ytUrl,
                    existing_file: v.type === 'upload' ? v.video_url : '', duration: v.duration || '00:00', description: v.description || ''
                }
            });

            return {
                videos: mappedVideos.length > 0 ? mappedVideos : [
                    { id: Date.now(), db_id: null, title: '', type: 'youtube', youtube_url: '', existing_file: '', duration: '00:00', description: '' }
                ],
                addVideo() { this.videos.push({ id: Date.now() + Math.random(), db_id: null, title: '', type: 'youtube', youtube_url: '', existing_file: '', duration: '00:00', description: '' }); },
                removeVideo(index) { this.videos.splice(index, 1); },

                detectVideoDuration(event, index) {
                    const file = event.target.files[0];
                    if (!file) return;
                    const tempVideo = document.createElement('video');
                    tempVideo.preload = 'metadata'; tempVideo.src = URL.createObjectURL(file);
                    tempVideo.onloadedmetadata = () => {
                        window.URL.revokeObjectURL(tempVideo.src);
                        let totalSeconds = tempVideo.duration;
                        let h = Math.floor(totalSeconds / 3600), m = Math.floor((totalSeconds % 3600) / 60), s = Math.floor(totalSeconds % 60);
                        this.videos[index].duration = h > 0 ? String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0') : String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                    };
                },

                async detectYoutubeDetails(index) {
                    const url = this.videos[index].youtube_url;
                    if (!url) return;
                    try {
                        const res = await fetch(`https://noembed.com/embed?url=${encodeURIComponent(url)}`);
                        const data = await res.json();
                        if (data.title && !this.videos[index].title) this.videos[index].title = data.title;
                    } catch(e) {}

                    let match = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
                    let ytId = (match && match[1]) ? match[1] : null;

                    if (ytId) {
                        this.videos[index].duration = "Mendeteksi...";
                        if (!window.YT) {
                            let tag = document.createElement('script'); tag.src = "https://www.youtube.com/iframe_api";
                            let firstScriptTag = document.getElementsByTagName('script')[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        }
                        let checkYT = setInterval(() => {
                            if (window.YT && window.YT.Player) {
                                clearInterval(checkYT);
                                let tempDiv = document.createElement('div'); tempDiv.id = 'yt-temp-' + ytId + '-' + Date.now();
                                tempDiv.style.cssText = 'position:absolute; opacity:0; pointer-events:none;'; document.body.appendChild(tempDiv);
                                let tempPlayer = new YT.Player(tempDiv.id, {
                                    videoId: ytId,
                                    events: {
                                        'onReady': (event) => {
                                            let totalSeconds = event.target.getDuration();
                                            if(totalSeconds > 0) {
                                                let h = Math.floor(totalSeconds / 3600), m = Math.floor((totalSeconds % 3600) / 60), s = Math.floor(totalSeconds % 60);
                                                this.videos[index].duration = h > 0 ? String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0') : String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
                                            } else { this.videos[index].duration = '00:00'; }
                                            event.target.destroy(); tempDiv.remove();
                                        },
                                        'onError': (event) => { this.videos[index].duration = '00:00'; event.target.destroy(); tempDiv.remove(); }
                                    }
                                });
                            }
                        }, 500);
                    }
                }
            }
        }
    </script>
</body>
</html>
