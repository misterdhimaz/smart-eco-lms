@extends('layouts.student')
@section('title', 'Pengaturan Profil | SMART-ECO')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="mb-8">
        <h2 class="text-2xl font-black text-slate-800">Pengaturan Akun</h2>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi profil dan kredensial Anda di sini.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        <form action="#" method="POST" class="space-y-6">
            @csrf

            <div class="flex items-center gap-6 pb-6 border-b border-slate-100">
                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=10b981&color=fff' }}" class="w-20 h-20 rounded-full border-4 border-emerald-50" alt="Avatar">
                <div>
                    <button type="button" class="bg-eco-green hover:bg-emerald-600 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">Ubah Foto</button>
                    <p class="text-[10px] text-slate-400 mt-2">JPG, GIF atau PNG. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 outline-none focus:border-eco-green focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 outline-none focus:border-eco-green focus:bg-white transition-all">
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-lg text-sm font-bold hover:bg-slate-200">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-eco-green hover:bg-emerald-600 text-white rounded-lg text-sm font-bold shadow-md shadow-emerald-500/20">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
