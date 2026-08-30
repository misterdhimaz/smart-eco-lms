@extends('layouts.admin')
@section('title', 'Kelola Video - ' . $category->title)

@section('content')
<div x-data="videoManager()" class="space-y-6 pb-12">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-[#0f172a] p-6 md:p-8 rounded-3xl border border-slate-800 text-white shadow-xl">
        <div>
            <a href="{{ route('admin.video-categories.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-400 hover:underline mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Daftar Kategori
            </a>
            <span class="block text-[10px] font-black uppercase text-slate-400 tracking-widest mt-1">{{ $category->badge }}</span>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight">{{ $category->title }}</h1>
        </div>

        <button @click="openCreateModal()"
                class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-black rounded-2xl text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 active:scale-95 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            Tambah Video Baru
        </button>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $index => $vid)
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
                <div>
                    <div class="aspect-video bg-black relative">
                        @if($vid->type === 'youtube')
                            <iframe src="https://www.youtube.com/embed/{{ $vid->video_url }}" class="w-full h-full border-0" allowfullscreen></iframe>
                        @else
                            <video controls class="w-full h-full">
                                <source src="{{ asset('storage/' . $vid->video_url) }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutar video.
                            </video>
                        @endif
                        <span class="absolute top-3 left-3 bg-black/70 backdrop-blur-md text-white text-[9px] font-black uppercase px-2.5 py-1 rounded-lg">
                            {{ $vid->type === 'youtube' ? '🔴 YouTube' : '📁 File MP4' }}
                        </span>
                    </div>

                    <div class="p-5 space-y-2">
                        <div class="flex items-center justify-between text-[10px] font-black text-slate-400 uppercase tracking-wider">
                            <span>Video #{{ $index + 1 }}</span>
                            <span>⏱️ {{ $vid->duration }}</span>
                        </div>
                        <h3 class="font-black text-slate-800 text-sm leading-snug">{{ $vid->title }}</h3>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $vid->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-2">
                    <button @click="openEditModal({{ json_encode($vid) }})" class="px-3 py-1.5 text-xs font-bold text-slate-600 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors">
                        ✏️ Edit
                    </button>

                    <form action="{{ route('admin.videos.destroy', $vid->id) }}" method="POST" onsubmit="return confirm('Hapus video ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 text-xs font-bold text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 rounded-3xl text-center border border-slate-200">
                <p class="text-slate-400 font-bold text-sm">Belum ada video di kategori ini. Klik "Tambah Video Baru".</p>
            </div>
        @endforelse
    </div>

    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 md:p-8 space-y-6 shadow-2xl relative max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h2 class="text-lg font-black text-slate-800" x-text="isEdit ? 'Edit Video' : 'Tambah Video Baru'"></h2>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-700 text-xl font-black">&times;</button>
            </div>

            <form :action="isEdit ? `/admin/videos/${form.id}` : '{{ route('admin.videos.store', $category->id) }}'" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">Judul Video</label>
                    <input type="text" name="title" x-model="form.title" required placeholder="Judul video..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold outline-none focus:border-emerald-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">Pilih Sumber Video</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="p-3 border rounded-xl flex items-center gap-2 cursor-pointer font-bold text-xs" :class="form.type === 'youtube' ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-slate-200'">
                            <input type="radio" name="type" value="youtube" x-model="form.type"> 🔴 Link YouTube
                        </label>
                        <label class="p-3 border rounded-xl flex items-center gap-2 cursor-pointer font-bold text-xs" :class="form.type === 'upload' ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-slate-200'">
                            <input type="radio" name="type" value="upload" x-model="form.type"> 📁 Upload Manual (MP4)
                        </label>
                    </div>
                </div>

                <div x-show="form.type === 'youtube'">
                    <label class="block text-xs font-bold text-slate-600 mb-2">Link YouTube / Video ID</label>
                    <input type="text" name="youtube_url" x-model="form.youtube_url" placeholder="https://www.youtube.com/watch?v=XXXXXX" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-mono font-bold text-emerald-600 outline-none focus:border-emerald-500">
                </div>

                <div x-show="form.type === 'upload'">
                    <label class="block text-xs font-bold text-slate-600 mb-2">Upload Berkas Video (MP4 / WebM max 100MB)</label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2">Durasi Video (MM:SS)</label>
                        <input type="text" name="duration" x-model="form.duration" required placeholder="10:15" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold outline-none focus:border-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-2">Deskripsi Video</label>
                    <textarea name="description" x-model="form.description" rows="2" placeholder="Penjelasan singkat..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs outline-none focus:border-emerald-500 resize-none"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-xs">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-500 text-white font-bold rounded-xl text-xs uppercase tracking-wider" x-text="isEdit ? 'Update Video' : 'Simpan Video'"></button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function videoManager() {
        return {
            showModal: false,
            isEdit: false,
            form: { id: '', title: '', type: 'youtube', youtube_url: '', duration: '10:00', description: '' },

            openCreateModal() {
                this.isEdit = false;
                this.form = { id: '', title: '', type: 'youtube', youtube_url: '', duration: '10:00', description: '' };
                this.showModal = true;
            },

            openEditModal(video) {
                this.isEdit = true;
                this.form = {
                    id: video.id,
                    title: video.title,
                    type: video.type,
                    youtube_url: video.type === 'youtube' ? video.video_url : '',
                    duration: video.duration,
                    description: video.description
                };
                this.showModal = true;
            }
        }
    }
</script>
@endsection
