@extends('layouts.admin')
@section('title', 'Edit Kategori Video')

@section('content')
<div class="space-y-6 pb-12">
    <div>
        <a href="{{ route('admin.video-categories.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-emerald-600 transition-colors mb-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Daftar Kategori
        </a>
        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Edit Kategori Modul</h1>
    </div>

    <form action="{{ route('admin.video-categories.update', $videoCategory->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 md:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-6 max-w-3xl">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2">Badge Modul</label>
                <input type="text" name="badge" value="{{ old('badge', $videoCategory->badge) }}" required
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-2">Judul Kategori</label>
                <input type="text" name="title" value="{{ old('title', $videoCategory->title) }}" required
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 mb-2">Deskripsi Kategori</label>
            <textarea name="description" rows="3" required
                      class="w-full bg-slate-50 border border-slate-200 rounded-xl p-4 text-xs font-medium text-slate-800 outline-none focus:border-emerald-500 resize-none">{{ old('description', $videoCategory->description) }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-600 mb-2">Ganti Cover Thumbnail (Kosongkan jika tidak diubah)</label>
            <input type="file" name="cover_image" accept="image/*"
                   class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition-colors">
            @if($videoCategory->cover_image)
                <p class="text-[10px] text-slate-400 font-bold mt-2">Cover saat ini: <a href="{{ asset('storage/' . $videoCategory->cover_image) }}" target="_blank" class="text-emerald-600 underline">Lihat Gambar</a></p>
            @endif
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <button type="submit" class="px-8 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-black rounded-2xl text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 active:scale-95">
                Perbarui Kategori
            </button>
        </div>
    </form>
</div>
@endsection
