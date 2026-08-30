<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Evaluasi | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-[#f8fafc] font-sans antialiased text-slate-800 selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen w-full overflow-hidden relative">

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 lg:translate-x-0 lg:static shrink-0">
            <x-admin-sidebar :admin="$admin" />
        </div>

        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden bg-slate-50 relative z-10">

            <div class="absolute top-0 right-0 -z-10 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/4"></div>

            <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-slate-200/60 flex items-center justify-between px-6 lg:px-10 shrink-0 z-20 gsap-header">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-black text-slate-800 tracking-tight">Pusat <span class="text-indigo-500">Evaluasi</span></h1>
                        <p class="text-xs text-slate-500 font-medium hidden sm:block mt-0.5">Kelola kuis, tugas esai, dan analitik nilai mahasiswa</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 lg:p-10 space-y-6 lg:space-y-8 custom-scrollbar">

                <div class="bg-gradient-to-br from-[#1e1b4b] to-[#312e81] rounded-[2rem] p-8 lg:p-10 text-white relative overflow-hidden shadow-xl shadow-indigo-900/10 gsap-anim">
                    <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10">
                        <svg class="w-72 h-72" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div class="relative z-10 max-w-2xl">
                        <span class="bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest mb-4 inline-block backdrop-blur-sm">Assessment Center</span>
                        <h2 class="text-3xl lg:text-4xl font-black mb-3 leading-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-indigo-200">Uji Pemahaman Terintegrasi</h2>
                        <p class="text-sm text-indigo-200 font-medium leading-relaxed max-w-xl">Buat kuis cerdas dengan sistem auto-grading, hubungkan dengan modul spesifik, dan berikan reward XP untuk memotivasi mahasiswa Anda.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200/80 shadow-[0_4px_20px_rgb(0,0,0,0.03)] gsap-anim">
                    <form action="{{ route('admin.assessments') }}" method="GET" class="w-full sm:flex-1 relative group">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kuis atau tugas..." class="w-full bg-slate-50/50 border border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-sm">
                        <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        @if(request('search'))
                            <a href="{{ route('admin.assessments') }}" class="absolute right-4 top-3 text-slate-400 hover:text-red-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a>
                        @endif
                    </form>

                    <button onclick="openCreateModal()" class="w-full sm:w-auto shrink-0 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:to-indigo-700 text-white px-6 py-3 rounded-xl text-sm font-black transition-all flex items-center justify-center gap-2 shadow-[0_8px_20px_rgba(99,102,241,0.25)] hover:shadow-[0_10px_25px_rgba(99,102,241,0.35)] hover:-translate-y-0.5 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Buat Evaluasi
                    </button>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-200/80 shadow-[0_4px_20px_rgb(0,0,0,0.03)] overflow-hidden gsap-anim">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h2 class="text-base font-black text-slate-800">Daftar Evaluasi Akademik</h2>
                        <span class="bg-indigo-50 text-indigo-600 font-bold text-xs px-3 py-1 rounded-lg">{{ $assessments->count() }} Data</span>
                    </div>

                    <div class="w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap min-w-[850px]">
                            <thead>
                                <tr class="bg-white border-b border-slate-100 text-[11px] font-black text-slate-400 uppercase tracking-widest">
                                    <th class="px-6 py-4">Nama Evaluasi & Terhubung Modul</th>
                                    <th class="px-6 py-4">Tipe & Reward</th>
                                    <th class="px-6 py-4">Batas Waktu</th>
                                    <th class="px-6 py-4 text-center">Setup & Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assessments as $assessment)
                                <tr class="border-b border-slate-50 hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center shadow-sm">
                                                @if($assessment->type == 'quiz')
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                @else
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <h3 class="text-sm font-bold text-slate-800 mb-1 max-w-[250px] truncate" title="{{ $assessment->title }}">{{ $assessment->title }}</h3>
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-eco-green" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd"></path></svg>
                                                    <span class="text-[11px] text-slate-500 font-medium">Modul: {{ $assessment->module->title ?? 'Tidak diketahui' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col items-start gap-1">
                                            @if($assessment->type == 'quiz')
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600 uppercase tracking-wider border border-blue-100">Auto-Grading (PG)</span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-600 uppercase tracking-wider border border-purple-100">Manual (Esai)</span>
                                            @endif
                                            <span class="text-xs font-black text-amber-500 flex items-center gap-1 mt-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                                                {{ $assessment->xp_reward }} XP
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-lg">
                                            {{ $assessment->time_limit > 0 ? $assessment->time_limit . ' Menit' : 'Tanpa Batas' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.assessments.builder', $assessment->id) }}" class="px-4 py-2 bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-500 hover:to-orange-600 text-white rounded-xl text-[11px] font-black uppercase tracking-wider transition-all shadow-md hover:shadow-lg flex items-center gap-1.5" title="Susun Pertanyaan Kuis">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                Build Soal
                                            </a>

                                            <button onclick="openEditModal({{ $assessment->id }}, '{{ addslashes($assessment->title) }}', {{ $assessment->module_id }}, '{{ $assessment->type }}', {{ $assessment->time_limit }}, {{ $assessment->xp_reward }})" class="p-2 text-slate-400 hover:text-indigo-500 bg-slate-50 hover:bg-indigo-50 rounded-xl transition-colors shadow-sm border border-transparent hover:border-indigo-100" title="Edit Pengaturan Evaluasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>

                                            <button onclick="confirmDelete({{ $assessment->id }}, '{{ addslashes($assessment->title) }}')" class="p-2 text-slate-400 hover:text-red-500 bg-slate-50 hover:bg-red-50 rounded-xl transition-colors shadow-sm border border-transparent hover:border-red-100" title="Hapus Evaluasi">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>

                                            <form id="delete-form-{{ $assessment->id }}" action="{{ route('admin.assessments.destroy', $assessment->id) }}" method="POST" style="display: none;">
                                                @csrf @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-indigo-100 shadow-inner">
                                            <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-800">Belum Ada Kuis/Tugas</h3>
                                        <p class="font-medium text-sm mt-2 text-slate-500 max-w-md mx-auto">Mulai buat evaluasi pertama Anda untuk mengukur pemahaman mahasiswa terhadap materi modul.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <div id="modalCreate" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white w-full max-w-2xl rounded-[2rem] shadow-2xl p-6 lg:p-10 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-500 rounded-xl flex items-center justify-center border border-indigo-100/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-800 text-xl">Setup Evaluasi Baru</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Langkah 1: Konfigurasi Dasar</p>
                    </div>
                </div>
                <button onclick="closeCreateModal()" class="text-slate-400 hover:text-red-500 bg-slate-100 hover:bg-red-50 p-2.5 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.assessments.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Judul Evaluasi</label>
                    <input type="text" name="title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-sm" placeholder="Contoh: Kuis Akhir Bab Fisika Kuantum" required>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Hubungkan dengan Modul</label>
                    <select name="module_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 outline-none transition-all shadow-sm cursor-pointer" required>
                        <option value="">-- Pilih Modul Pembelajaran --</option>
                        @foreach($modules as $mod)
                            <option value="{{ $mod->id }}">Modul {{ $mod->order_number }}: {{ $mod->title }}</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] font-bold text-slate-400 mt-1.5">Mahasiswa harus membaca modul ini sebelum bisa mengerjakan kuis.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Tipe Evaluasi</label>
                        <select name="type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 outline-none cursor-pointer" required>
                            <option value="quiz">Kuis (Pilihan Ganda)</option>
                            <option value="essay">Tugas (Esai Manual)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Batas Waktu (Menit)</label>
                        <input type="number" name="time_limit" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-indigo-500 outline-none" min="0" value="0" placeholder="0 = Bebas">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide text-amber-500">Reward Lulus (XP)</label>
                        <div class="relative">
                            <input type="number" name="xp_reward" class="w-full bg-amber-50 border border-amber-200 rounded-xl pl-10 pr-4 py-3 text-sm font-bold text-amber-700 focus:bg-white focus:border-amber-500 outline-none" min="10" value="100" required>
                            <svg class="w-5 h-5 text-amber-500 absolute left-3 top-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 text-white py-3.5 rounded-xl text-sm font-black mt-4 hover:shadow-lg hover:shadow-indigo-500/30 transition-all active:scale-95 flex items-center justify-center gap-2">
                    Simpan Konfigurasi
                </button>
            </form>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
        <div class="bg-white w-full max-w-2xl rounded-[2rem] shadow-2xl p-6 lg:p-10 max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center border border-amber-100/50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-800 text-xl">Edit Konfigurasi Evaluasi</h3>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-red-500 bg-slate-100 hover:bg-red-50 p-2.5 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="editForm" action="#" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Judul Evaluasi</label>
                    <input type="text" name="title" id="edit_title" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all shadow-sm" required>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Modul Terhubung</label>
                    <select name="module_id" id="edit_module_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all shadow-sm cursor-pointer" required>
                        @foreach($modules as $mod)
                            <option value="{{ $mod->id }}">Modul {{ $mod->order_number }}: {{ $mod->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Tipe Evaluasi</label>
                        <select name="type" id="edit_type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-amber-500 outline-none cursor-pointer" required>
                            <option value="quiz">Kuis (Pilihan Ganda)</option>
                            <option value="essay">Tugas (Esai Manual)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Batas Waktu</label>
                        <input type="number" name="time_limit" id="edit_time_limit" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:bg-white focus:border-amber-500 outline-none" min="0">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide text-amber-500">Reward (XP)</label>
                        <input type="number" name="xp_reward" id="edit_xp_reward" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:bg-white focus:border-amber-500 outline-none" min="10" required>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 text-white py-3.5 rounded-xl text-sm font-black mt-4 hover:shadow-lg hover:shadow-orange-500/30 transition-all active:scale-95">Update Konfigurasi</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            gsap.from(".gsap-header", { y: -10, opacity: 0, duration: 0.5, ease: "power2.out" });
            gsap.from(".gsap-anim", { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, ease: "power2.out", delay: 0.2 });

            @if(session('success'))
                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}',
                    confirmButtonColor: '#6366f1', customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-xl px-6 font-bold' }
                });
            @endif
        });

        // MODAL TOGGLES
        const modalCreate = document.getElementById('modalCreate');
        function openCreateModal() { modalCreate.classList.remove('hidden'); }
        function closeCreateModal() { modalCreate.classList.add('hidden'); }

        const modalEdit = document.getElementById('modalEdit');
        function openEditModal(id, title, module_id, type, time_limit, xp_reward) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_module_id').value = module_id;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_time_limit').value = time_limit;
            document.getElementById('edit_xp_reward').value = xp_reward;
            document.getElementById('editForm').action = '/admin/assessments/' + id;
            modalEdit.classList.remove('hidden');
        }
        function closeEditModal() { modalEdit.classList.add('hidden'); }

        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Hapus Evaluasi?', text: "Semua soal kuis di dalamnya akan ikut terhapus!",
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!', customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold' }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
            });
        }
    </script>
</body>
</html>
