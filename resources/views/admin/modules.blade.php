<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Modul | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';</script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased font-sans h-[100dvh] flex flex-col overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden relative w-full">

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-50">

            <div class="absolute top-0 right-0 -z-10 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-emerald-500/10 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>

            <header class="h-14 md:h-[76px] bg-white/90 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
                <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all shrink-0">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate">
                        <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Manajemen <span class="text-emerald-600">Modul</span></h1>
                        <p class="text-[9px] md:text-xs text-slate-500 font-bold hidden sm:block mt-1">Kelola kurikulum, materi PDF, dan urutan pembelajaran.</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-10 custom-scrollbar relative z-10 w-full pb-20">
                <div class="max-w-[1400px] mx-auto space-y-6 md:space-y-8 w-full">

                    <!-- HERO BANNER -->
<div class="bg-slate-900 rounded-2xl md:rounded-[2rem] p-6 md:p-10 text-white relative overflow-hidden shadow-md border-b-4 border-emerald-500 gsap-anim">

    <!-- Ikon Dekoratif SVG (Tetap ada tapi tanpa efek blur/gradasi) -->
    <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10 pointer-events-none hidden sm:block">
        <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2v-2zm0-6h2v4h-2v-4z"/></svg>
    </div>

    <div class="relative z-10 max-w-2xl">
        <span class="inline-block bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-4 shadow-sm">
            Course Builder
        </span>
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black mb-2 md:mb-3 leading-tight text-white">
            Pusat Kurikulum Pembelajaran
        </h2>
        <p class="text-[11px] md:text-sm text-slate-300 font-medium leading-relaxed">
            Unggah materi format PDF, tambahkan sampul visual, dan atur struktur pembelajaran LMS secara terpusat.
        </p>
    </div>
</div>

                    <div class="flex flex-col sm:flex-row justify-between items-center gap-3 bg-white p-3 md:p-4 rounded-xl md:rounded-2xl border border-slate-200 shadow-sm gsap-anim">
                        <form action="{{ route('admin.modules') }}" method="GET" class="w-full sm:flex-1 relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul modul atau kategori..." class="w-full bg-slate-50 border border-slate-200 rounded-lg md:rounded-xl pl-10 md:pl-12 pr-4 py-2.5 md:py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400 absolute left-3 md:left-4 top-1/2 -translate-y-1/2 group-focus-within:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            @if(request('search'))
                                <a href="{{ route('admin.modules') }}" class="absolute right-3 md:right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-500 transition-colors bg-white p-1 rounded-md" title="Reset"><svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></a>
                            @endif
                        </form>

                        <button onclick="openCreateModal()" class="w-full sm:w-auto shrink-0 bg-[#047857] hover:bg-[#065f46] text-white px-5 py-2.5 md:py-3 rounded-lg md:rounded-xl text-[10px] md:text-xs font-black uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg> Modul Baru
                        </button>
                    </div>

                    <div class="bg-white rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col gsap-anim">
                        <div class="px-4 md:px-6 py-4 md:py-5 border-b border-slate-100 bg-slate-50 flex justify-between items-center shrink-0">
                            <h2 class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-widest">Materi Terunggah</h2>
                            <span class="bg-slate-200 text-slate-600 text-[9px] md:text-[10px] font-black uppercase px-2.5 py-1 rounded-md tracking-widest">{{ $modules->count() }} Modul</span>
                        </div>

                        <div class="w-full overflow-x-auto custom-scrollbar flex-1">
                            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px] md:min-w-[850px]">
                                <thead>
                                    <tr class="bg-white border-b-2 border-slate-100 text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        <th class="px-4 md:px-6 py-3 md:py-4 w-12 md:w-16 text-center">No</th>
                                        <th class="px-4 md:px-6 py-3 md:py-4">Informasi Modul</th>
                                        <th class="px-4 md:px-6 py-3 md:py-4">File Dokumen</th>
                                        <th class="px-4 md:px-6 py-3 md:py-4 text-center">Aksi (CRUD)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($modules as $module)
                                    <tr class="hover:bg-slate-50 transition-colors group">

                                        <td class="px-4 md:px-6 py-3 md:py-4 text-center">
                                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-slate-100 text-slate-600 font-black flex items-center justify-center mx-auto border border-slate-200 shadow-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors text-xs md:text-sm">
                                                {{ $module->order_number }}
                                            </div>
                                        </td>

                                        <td class="px-4 md:px-6 py-3 md:py-4">
                                            <div class="flex items-center gap-3 md:gap-4">
                                                <div class="w-10 h-12 md:w-12 md:h-16 bg-slate-100 rounded-md md:rounded border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center shadow-sm">
                                                    @if(isset($module->cover_image) && $module->cover_image)
                                                        <img src="{{ asset('storage/' . $module->cover_image) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <svg class="w-5 h-5 md:w-6 md:h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    @endif
                                                </div>
                                                <div class="truncate max-w-[150px] sm:max-w-[250px] md:max-w-[300px]">
                                                    <h3 class="text-xs md:text-sm font-black text-slate-900 mb-1 truncate group-hover:text-emerald-700 transition-colors" title="{{ $module->title }}">{{ $module->title }}</h3>
                                                    <span class="bg-slate-100 text-slate-500 border border-slate-200 text-[8px] md:text-[9px] font-black px-2 py-0.5 md:py-1 rounded-md uppercase tracking-wider">{{ $module->category }}</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 md:px-6 py-3 md:py-4">
                                            <div class="flex flex-col items-start gap-1">
                                                @if($module->document_file)
                                                    <span class="inline-flex items-center gap-1.5 px-2 md:px-3 py-1 rounded-md text-[9px] md:text-[10px] font-black uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200 shadow-sm">
                                                        <svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 15h-2v-2h2v2zm0-4h-2V7h2v6z"></path></svg>
                                                        PDF Tersedia
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2 md:px-3 py-1 rounded-md text-[9px] md:text-[10px] font-black uppercase tracking-wider bg-slate-100 text-slate-400 border border-slate-200">
                                                        Kosong
                                                    </span>
                                                @endif
                                                <span class="text-[9px] md:text-[10px] text-slate-400 font-bold mt-1">{{ $module->created_at->format('d M Y') }}</span>
                                            </div>
                                        </td>

                                        <td class="px-4 md:px-6 py-3 md:py-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5 md:gap-2">
                                                <button onclick="openPreviewModal(
                                                    '{{ addslashes($module->title) }}',
                                                    '{{ addslashes($module->category) }}',
                                                    `{{ addslashes($module->description ?? 'Tidak ada deskripsi tersedia untuk modul ini.') }}`,
                                                    '{{ $module->cover_image ? asset('storage/' . $module->cover_image) : '' }}',
                                                    '{{ $module->document_file ? asset('storage/' . $module->document_file) : '' }}'
                                                )" class="px-3 md:px-4 py-1.5 md:py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-wider transition-colors shadow-sm flex items-center gap-1.5 active:scale-95">
                                                    <svg class="w-3 h-3 md:w-3.5 md:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    Preview
                                                </button>

                                                <button onclick="openEditModal({{ $module->id }}, '{{ addslashes($module->title) }}', '{{ addslashes($module->category) }}', {{ $module->order_number }}, `{{ addslashes($module->description) }}`)" class="p-1.5 md:p-2 text-slate-500 hover:text-amber-600 bg-white border-2 border-slate-200 hover:border-amber-400 rounded-lg transition-colors shadow-sm active:scale-95" title="Edit Modul">
                                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>

                                                <button onclick="confirmDelete({{ $module->id }}, '{{ addslashes($module->title) }}')" class="p-1.5 md:p-2 text-slate-500 hover:text-rose-600 bg-white border-2 border-slate-200 hover:border-rose-400 rounded-lg transition-colors shadow-sm active:scale-95" title="Hapus Modul">
                                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>

                                                <form id="delete-form-{{ $module->id }}" action="{{ route('admin.modules.destroy', $module->id) }}" method="POST" style="display: none;">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 md:py-16 text-center">
                                            <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200 shadow-sm">
                                                <svg class="w-8 h-8 md:w-10 md:h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            </div>
                                            <h3 class="text-sm md:text-base font-black text-slate-800">Modul Tidak Ditemukan</h3>
                                            <p class="font-bold text-[10px] md:text-xs mt-1 text-slate-500">Belum ada modul yang diupload atau sesuai pencarian Anda.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>

    <div id="modalCreate" class="fixed inset-0 bg-slate-900/80 z-[100] flex items-center justify-center hidden p-3 md:p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white w-full max-w-2xl rounded-2xl md:rounded-[2rem] shadow-2xl p-5 md:p-8 lg:p-10 flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center mb-5 md:mb-8 border-b-2 border-slate-100 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-100 text-emerald-600 rounded-lg md:rounded-xl flex items-center justify-center font-black">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm md:text-lg">Upload Modul Baru</h3>
                        <p class="text-[9px] md:text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tambah Kurikulum</p>
                    </div>
                </div>
                <button onclick="closeCreateModal()" class="text-slate-400 hover:text-white bg-slate-100 hover:bg-rose-500 p-2 border-2 border-slate-200 hover:border-rose-500 rounded-lg md:rounded-xl transition-all">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-1 md:pr-2">
                <form action="{{ route('admin.modules.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Judul Modul Materi</label>
                        <input type="text" name="title" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-emerald-600 outline-none transition-all shadow-sm" placeholder="Contoh: Energi Terbarukan" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Kategori</label>
                            <input type="text" name="category" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-emerald-600 outline-none transition-all shadow-sm" placeholder="Contoh: Fisika Dasar" required>
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Urutan Pembelajaran</label>
                            <input type="number" name="order_number" class="w-full bg-slate-200 border-2 border-slate-300 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-black text-slate-500 cursor-not-allowed outline-none" value="{{ ($modules->max('order_number') ?? 0) + 1 }}" readonly required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 p-4 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl border-dashed">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Sampul (Cover Opsional)</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-[10px] md:text-xs text-slate-500 file:mr-3 file:py-1.5 md:file:py-2 file:px-3 md:file:px-4 file:rounded-lg file:border-0 file:font-black file:bg-emerald-600 file:text-white cursor-pointer outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-rose-600 mb-1.5 md:mb-2 uppercase tracking-wide">File Modul (Wajib PDF)</label>
                            <input type="file" name="document_file" accept=".pdf" class="w-full text-[10px] md:text-xs text-slate-500 file:mr-3 file:py-1.5 md:file:py-2 file:px-3 md:file:px-4 file:rounded-lg file:border-0 file:font-black file:bg-rose-500 file:text-white cursor-pointer outline-none" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-emerald-600 outline-none transition-all shadow-sm resize-none"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-[#047857] hover:bg-[#065f46] text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all active:scale-95 shadow-lg">Publikasikan Modul</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-slate-900/80 z-[100] flex items-center justify-center hidden p-3 md:p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white w-full max-w-2xl rounded-2xl md:rounded-[2rem] shadow-2xl p-5 md:p-8 lg:p-10 flex flex-col max-h-[90vh]">
            <div class="flex justify-between items-center mb-5 md:mb-8 border-b-2 border-slate-100 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 md:w-10 md:h-10 bg-amber-100 text-amber-600 rounded-lg md:rounded-xl flex items-center justify-center font-black">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm md:text-lg leading-tight">Perbarui Modul</h3>
                        <p class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest">Edit Data Kurikulum</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-500 hover:text-white bg-slate-100 hover:bg-rose-500 p-2 border-2 border-slate-200 hover:border-rose-500 rounded-lg md:rounded-xl transition-all">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-1 md:pr-2">
                <form id="editForm" action="#" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Judul Modul Materi</label>
                        <input type="text" name="title" id="edit_title" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-amber-500 outline-none transition-all shadow-sm" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Kategori</label>
                            <input type="text" name="category" id="edit_category" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-amber-500 outline-none transition-all shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Urutan Ke-</label>
                            <input type="number" name="order_number" id="edit_order" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-amber-500 outline-none transition-all shadow-sm" min="1" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 p-4 bg-slate-50 border-2 border-slate-200 rounded-xl md:rounded-2xl border-dashed">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Ganti Sampul</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full text-[10px] md:text-xs text-slate-500 file:mr-3 file:py-1.5 md:file:py-2 file:px-3 md:file:px-4 file:rounded-lg file:border-0 file:font-black file:bg-slate-800 file:text-white cursor-pointer">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-rose-600 mb-1.5 md:mb-2 uppercase tracking-wide">Ganti PDF (Opsional)</label>
                            <input type="file" name="document_file" accept=".pdf" class="w-full text-[10px] md:text-xs text-slate-500 file:mr-3 file:py-1.5 md:file:py-2 file:px-3 md:file:px-4 file:rounded-lg file:border-0 file:font-black file:bg-rose-500 file:text-white cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 md:mb-2 uppercase tracking-wide">Deskripsi</label>
                        <textarea name="description" id="edit_desc" rows="3" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-2.5 md:py-3 text-xs md:text-sm font-bold focus:bg-white focus:border-amber-500 outline-none transition-all shadow-sm resize-none"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all active:scale-95 shadow-md">Terapkan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalPreview" class="fixed inset-0 z-[120] flex flex-col hidden bg-[#0f172a] h-[100dvh] w-screen overflow-hidden">

        <div class="h-14 md:h-[72px] bg-slate-900 border-b border-slate-800 flex items-center justify-between px-3 md:px-6 shrink-0 z-20 shadow-md">
            <div class="flex items-center gap-2 md:gap-4 w-[60%] md:w-1/3 overflow-hidden">
                <span class="bg-emerald-600 text-white px-2 py-1 md:px-3 md:py-1.5 rounded border border-emerald-400/30 text-[9px] md:text-[10px] font-black uppercase tracking-widest flex items-center gap-1.5 md:gap-2 shrink-0">
                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm0 0a8 8 0 100-16 8 8 0 000 16zm0-12a2 2 0 100 4 2 2 0 000-4z"></path></svg>
                    READER
                </span>
                <div class="h-5 w-px bg-slate-700 hidden sm:block"></div>
                <h3 id="previewTitle" class="text-slate-300 font-bold text-[10px] md:text-sm truncate">Document.pdf</h3>
            </div>

            <div class="flex items-center justify-center gap-1 md:gap-3 flex-1">
                <div class="flex items-center bg-slate-800 rounded-lg px-2 py-1 border border-slate-700 hidden sm:flex">
                    <input type="number" id="pageNumberInput" class="bg-transparent text-white text-center text-xs font-bold w-10 outline-none" value="1" min="1">
                    <span class="text-xs text-slate-500 mx-1">/</span>
                    <span id="pageCountDisplay" class="text-xs text-slate-400 font-bold w-6">0</span>
                </div>
                <button onclick="zoomOut()" class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700 rounded-md transition-colors"><svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"></path></svg></button>
                <span id="zoomDisplay" class="font-mono text-[10px] md:text-xs font-bold text-slate-300 w-10 text-center">100%</span>
                <button onclick="zoomIn()" class="p-1.5 text-slate-400 hover:text-white hover:bg-slate-700 rounded-md transition-colors"><svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg></button>
            </div>

            <div class="flex items-center justify-end gap-1.5 md:gap-2 shrink-0">
                <button onclick="printPDF()" class="text-slate-400 hover:text-emerald-400 hover:bg-slate-800 p-1.5 md:p-2 rounded-lg transition-all hidden md:flex items-center gap-1.5 border border-transparent">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span class="text-[10px] font-black uppercase tracking-wider hidden lg:block">Cetak</span>
                </button>
                <div class="w-px h-5 bg-slate-700 mx-0.5 md:mx-1 hidden sm:block"></div>
                <button onclick="closePreviewModal()" class="text-slate-400 hover:text-white hover:bg-rose-600 bg-slate-800 p-1.5 md:p-2 border border-slate-700 hover:border-rose-500 rounded-lg transition-all active:scale-95">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto overflow-x-hidden bg-slate-950 custom-scrollbar relative w-full" id="pdfScrollArea">
            <div class="w-full max-w-[1000px] mx-auto py-6 md:py-10 px-2 md:px-6 flex flex-col items-center">

                <div class="w-full bg-slate-900 border border-slate-800 rounded-2xl md:rounded-[2rem] p-4 md:p-8 mb-6 md:mb-10 shadow-2xl flex flex-col md:flex-row gap-5 md:gap-8 items-center md:items-start relative overflow-hidden">
                    <div class="w-24 md:w-48 aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-xl shrink-0 p-1 md:p-1.5 relative border border-slate-700">
                        <img id="previewCoverImg" src="" alt="Cover" class="w-full h-full object-cover hidden rounded-lg border border-slate-200">
                        <div id="previewCoverFallback" class="flex flex-col items-center justify-center p-2 text-center w-full h-full bg-slate-100 rounded-lg">
                            <span class="text-slate-400 font-bold text-[8px] md:text-[10px] uppercase">SMART-ECO</span>
                        </div>
                    </div>

                    <div class="flex-1 text-center md:text-left w-full mt-2">
                        <span id="previewCategoryBadge" class="inline-block bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-3 md:mb-4">KATEGORI</span>
                        <h1 class="text-xl md:text-3xl lg:text-4xl font-black text-white mb-3 md:mb-4 leading-tight line-clamp-2" id="previewDocTitle">Judul Materi Pembelajaran</h1>
                        <div class="w-12 md:w-16 h-1 bg-emerald-500 rounded-full mx-auto md:mx-0 mb-4 md:mb-6"></div>
                        <div class="bg-slate-950/50 p-4 md:p-5 rounded-xl md:rounded-2xl border border-slate-800 text-left">
                            <h4 class="text-[9px] md:text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1.5 md:mb-2">Deskripsi Materi</h4>
                            <p id="previewDescText" class="text-slate-300 text-xs md:text-sm leading-relaxed font-medium">Deskripsi materi akan muncul di sini...</p>
                        </div>
                    </div>
                </div>

                <div id="pdfPagesContainer" class="w-full flex flex-col items-center gap-4 md:gap-6 mb-16"></div>

                <div id="pdfLoading" class="text-white flex flex-col items-center justify-center py-16 md:py-20 w-full hidden">
                    <svg class="w-10 h-10 md:w-12 md:h-12 animate-spin mb-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="font-black tracking-widest text-[10px] md:text-xs uppercase text-slate-400">Menyiapkan Dokumen PDF...</span>
                </div>

                <div id="previewPdfFallback" class="w-full max-w-2xl bg-slate-900 border border-slate-800 shadow-xl rounded-2xl md:rounded-[2rem] p-10 md:p-16 text-center text-slate-400 flex flex-col items-center hidden">
                    <svg class="w-12 h-12 md:w-16 md:h-16 mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="font-black text-white text-lg md:text-2xl mb-2">Dokumen Belum Tersedia</p>
                    <p class="text-[11px] md:text-sm">Admin belum mengunggah file PDF untuk modul ini.</p>
                </div>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            gsap.from(".gsap-header", { y: -10, opacity: 0, duration: 0.5, ease: "power2.out" });
            gsap.from(".gsap-anim", { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, ease: "power2.out", delay: 0.2 });

            @if(session('success'))
                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}',
                    confirmButtonColor: '#047857', customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl px-6 font-bold' }
                });
            @endif
        });

        // MODAL CREATE & EDIT LOGIC
        const modalCreate = document.getElementById('modalCreate');
        function openCreateModal() { modalCreate.classList.remove('hidden'); }
        function closeCreateModal() { modalCreate.classList.add('hidden'); }

        const modalEdit = document.getElementById('modalEdit');
        function openEditModal(id, title, category, order, desc) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_category').value = category;
            document.getElementById('edit_order').value = order;
            document.getElementById('edit_desc').value = desc;
            document.getElementById('editForm').action = '/admin/modules/' + id;
            modalEdit.classList.remove('hidden');
        }
        function closeEditModal() { modalEdit.classList.add('hidden'); }

        // ================== PDF.js LOGIC (FIT TO MOBILE SCREEN) ==================
        const modalPreview = document.getElementById('modalPreview');
        const pdfPagesContainer = document.getElementById('pdfPagesContainer');
        const pdfLoading = document.getElementById('pdfLoading');
        const previewPdfFallback = document.getElementById('previewPdfFallback');
        const scrollArea = document.getElementById('pdfScrollArea');
        const pageNumberInput = document.getElementById('pageNumberInput');

        let pdfDoc = null;
        let zoomMultiplier = 1.0;
        let globalPdfUrl = '';

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if(entry.isIntersecting && entry.intersectionRatio >= 0.3) {
                    pageNumberInput.value = entry.target.getAttribute('data-page-num');
                }
            });
        }, { threshold: 0.3 });

        function renderNextPage(num) {
            if (num > pdfDoc.numPages) {
                pdfLoading.classList.add('hidden');
                return;
            }

            const wrapper = document.createElement('div');
            // CLASS KUNCI: w-full max-w-full agar gambar mengecil di HP
            wrapper.className = 'w-full max-w-full flex justify-center shadow-lg rounded bg-white overflow-hidden relative border-2 border-slate-700';
            wrapper.id = 'pdf-page-' + num;
            wrapper.setAttribute('data-page-num', num);

            const canvas = document.createElement('canvas');
            canvas.className = 'max-w-full h-auto object-contain block';
            wrapper.appendChild(canvas);
            pdfPagesContainer.appendChild(wrapper);

            observer.observe(wrapper);

            pdfDoc.getPage(num).then(function(page) {
                const unscaledViewport = page.getViewport({ scale: 1.0 });

                const containerWidth = pdfPagesContainer.clientWidth;
                const screenWidth = window.innerWidth;
                const padding = screenWidth < 768 ? 0 : 32;
                const availableWidth = Math.min(containerWidth - padding, 1000);

                let baseScale = availableWidth / unscaledViewport.width;
                if (screenWidth >= 1024) { baseScale = Math.min(baseScale, 1.5); }

                const finalScale = baseScale * zoomMultiplier;
                const displayViewport = page.getViewport({ scale: finalScale });

                // Render HD
                const renderScale = finalScale * 3;
                const renderViewport = page.getViewport({ scale: renderScale });

                canvas.width = renderViewport.width;
                canvas.height = renderViewport.height;
                canvas.style.width = Math.floor(displayViewport.width) + "px";
                canvas.style.height = "auto";

                page.render({ canvasContext: canvas.getContext('2d'), viewport: renderViewport }).promise.then(() => {
                    renderNextPage(num + 1);
                });
            });
        }

        function renderAllPages() {
            pdfPagesContainer.innerHTML = '';
            observer.disconnect();
            if (!pdfDoc) return;

            document.getElementById('zoomDisplay').innerText = Math.round(zoomMultiplier * 100) + "%";
            document.getElementById('pageCountDisplay').innerText = pdfDoc.numPages;
            pageNumberInput.value = 1;
            pageNumberInput.max = pdfDoc.numPages;

            pdfLoading.classList.remove('hidden');
            renderNextPage(1);
        }

        function zoomIn() { if (!pdfDoc || zoomMultiplier >= 2.5) return; zoomMultiplier += 0.2; renderAllPages(); }
        function zoomOut() { if (!pdfDoc || zoomMultiplier <= 0.4) return; zoomMultiplier -= 0.2; renderAllPages(); }

        pageNumberInput.addEventListener('change', function() {
            let val = parseInt(this.value);
            if(val >= 1 && val <= pdfDoc.numPages) {
                const targetPage = document.getElementById('pdf-page-' + val);
                if(targetPage) { scrollArea.scrollTo({ top: targetPage.offsetTop - 20, behavior: 'smooth' }); }
            } else { this.value = 1; }
        });

        function loadCustomPDF(url) {
            pdfPagesContainer.innerHTML = '';
            pdfLoading.classList.remove('hidden');
            previewPdfFallback.classList.add('hidden');
            globalPdfUrl = url;

            pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
                pdfDoc = pdfDoc_;
                renderAllPages();
            }).catch(function(error) {
                console.error("Error loading PDF: ", error);
                pdfLoading.classList.add('hidden');
                previewPdfFallback.classList.remove('hidden');
            });
        }

        function openPreviewModal(title, category, description, coverUrl, pdfUrl) {
            document.getElementById('previewTitle').innerText = title + ".pdf";
            document.getElementById('previewDocTitle').innerText = title;
            document.getElementById('previewCategoryBadge').innerText = category;
            document.getElementById('previewDescText').innerText = description;

            const previewCoverImg = document.getElementById('previewCoverImg');
            const previewCoverFallback = document.getElementById('previewCoverFallback');
            if (coverUrl && coverUrl.trim() !== '') {
                previewCoverImg.src = coverUrl;
                previewCoverImg.classList.remove('hidden');
                previewCoverFallback.classList.add('hidden');
            } else {
                previewCoverImg.classList.add('hidden');
                previewCoverFallback.classList.remove('hidden');
            }

            if (pdfUrl && pdfUrl.trim() !== '') {
                loadCustomPDF(pdfUrl);
            } else {
                globalPdfUrl = '';
                previewPdfFallback.classList.remove('hidden');
            }

            modalPreview.classList.remove('hidden');
            zoomMultiplier = 1.0; // Reset Zoom tiap buka modal
            scrollArea.scrollTop = 0;
        }

        function closePreviewModal() {
            modalPreview.classList.add('hidden');
            pdfPagesContainer.innerHTML = '';
            observer.disconnect();
            pdfDoc = null;
            globalPdfUrl = '';
        }

        function printPDF() {
            if(!globalPdfUrl) {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Tidak ada dokumen PDF untuk dicetak.', customClass: { popup: 'rounded-[2rem]' } });
                return;
            }
            const hideFrame = document.createElement("iframe");
            hideFrame.onload = function() { setTimeout(() => { hideFrame.contentWindow.focus(); hideFrame.contentWindow.print(); }, 500); };
            hideFrame.style.cssText = "position:fixed;right:0;bottom:0;width:0;height:0;border:0;";
            hideFrame.src = globalPdfUrl;
            document.body.appendChild(hideFrame);
        }

        function confirmDelete(id, title) {
            Swal.fire({
                title: 'Hapus Modul?', text: "File PDF dan cover dari modul ini akan terhapus permanen!",
                icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus!', customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-6', cancelButton: 'rounded-xl font-bold px-6' }
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('delete-form-' + id).submit();
            });
        }
    </script>
</body>
</html>
