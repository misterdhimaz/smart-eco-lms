@extends('layouts.admin')
@section('title', 'Kategori Modul Video')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-[#0f172a] p-6 md:p-8 rounded-3xl border border-slate-800 text-white shadow-xl">
        <div>
            <span class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full text-[10px] font-black uppercase tracking-widest mb-2">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Kelola Kategori
            </span>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight">Kategori Modul Video</h1>
            <p class="text-xs md:text-sm text-slate-400 font-medium mt-1">Buat kategori modul materi, kemudian tambahkan video di dalamnya.</p>
        </div>

        <a href="{{ route('admin.video-categories.create') }}"
           class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-black rounded-2xl text-xs uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/20 active:scale-95 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kategori Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-5 py-4 rounded-2xl text-xs font-bold flex items-center gap-3">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <h2 class="font-black text-slate-800 text-base">Daftar Kategori Modul</h2>

            <form action="{{ route('admin.video-categories.index') }}" method="GET" class="relative w-full sm:w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-medium text-slate-700 outline-none focus:border-emerald-500 focus:bg-white transition-all">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-medium text-slate-600">
                <thead class="bg-slate-50 text-slate-400 font-black uppercase text-[10px] tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="p-4 pl-6">Cover</th>
                        <th class="p-4">Badge / Judul Kategori</th>
                        <th class="p-4">Jumlah Video</th>
                        <th class="p-4 text-center">Aksi & Kelola Video</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $cat)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 pl-6">
                                <div class="w-20 h-14 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    @if($cat->cover_image)
                                        <img src="{{ asset('storage/' . $cat->cover_image) }}" alt="{{ $cat->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[9px] text-slate-400 font-bold">NO COVER</div>
                                    @endif
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-0.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-md text-[9px] font-black uppercase tracking-wider inline-block mb-1">
                                    {{ $cat->badge }}
                                </span>
                                <h3 class="font-black text-slate-800 text-sm leading-snug">{{ $cat->title }}</h3>
                                <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $cat->description }}</p>
                            </td>
                            <td class="p-4 font-black text-slate-800 text-xs">
                                {{ $cat->videos_count }} Video
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.videos.index', $cat->id) }}"
                                       class="px-3 py-1.5 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-xl font-bold hover:bg-emerald-500 hover:text-white transition-all flex items-center gap-1.5 text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Kelola Video ({{ $cat->videos_count }})
                                    </a>

                                    <a href="{{ route('admin.video-categories.edit', $cat->id) }}"
                                       class="p-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-colors" title="Edit Kategori">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form action="{{ route('admin.video-categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini beserta seluruh videonya?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus Kategori">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 font-bold">
                                Belum ada kategori modul. Klik tombol "Tambah Kategori Baru".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $categories->links() }}
        </div>
    </div>

</div>
@endsection
