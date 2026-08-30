@extends('layouts.admin')
@section('title', 'Tambah Simulasi Baru')

@section('content')
<div x-data="{ type: 'native_carbon' }" class="max-w-4xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-black text-slate-800">Tambah Simulasi Virtual 🧪</h1>
    </div>

    <form action="{{ route('admin.simulations.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200 space-y-6">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2">Badge (Kode Lab)</label>
                <input type="text" name="badge" required class="w-full bg-slate-50 border rounded-xl px-4 py-3 text-sm focus:border-emerald-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 mb-2">Judul Simulasi</label>
                <input type="text" name="title" required class="w-full bg-slate-50 border rounded-xl px-4 py-3 text-sm focus:border-emerald-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 mb-2">Deskripsi Instruksi</label>
            <textarea name="description" rows="3" required class="w-full bg-slate-50 border rounded-xl p-4 text-sm focus:border-emerald-500"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 mb-2">Tipe Simulasi</label>
            <div class="flex gap-4">
                <label class="flex-1 cursor-pointer p-4 border rounded-xl flex items-center justify-center gap-2" :class="type === 'native_carbon' ? 'bg-emerald-50 border-emerald-500 text-emerald-700' : 'bg-slate-50'">
                    <input type="radio" name="type" value="native_carbon" x-model="type" class="hidden"> 🌍 Kalkulator Karbon (Bawaan)
                </label>
                <label class="flex-1 cursor-pointer p-4 border rounded-xl flex items-center justify-center gap-2" :class="type === 'embed' ? 'bg-cyan-50 border-cyan-500 text-cyan-700' : 'bg-slate-50'">
                    <input type="radio" name="type" value="embed" x-model="type" class="hidden"> 🔗 Link Eksternal (PhET / Game)
                </label>
            </div>
        </div>

        <div x-show="type === 'embed'">
            <label class="block text-xs font-bold text-cyan-600 mb-2">URL Tautan Embed</label>
            <input type="url" name="embed_url" placeholder="https://..." class="w-full bg-slate-50 border rounded-xl px-4 py-3 text-sm focus:border-cyan-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 mb-2">Cover Thumbnail (Wajib)</label>
            <input type="file" name="cover_image" required class="w-full text-xs file:py-2 file:px-4 file:rounded-xl file:bg-slate-800 file:text-white">
        </div>

        <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl uppercase">Simpan Simulasi</button>
    </form>
</div>
@endsection
