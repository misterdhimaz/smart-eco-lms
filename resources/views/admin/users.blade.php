<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Manajemen Mahasiswa | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans antialiased text-slate-800 selection:bg-emerald-600 selection:text-white h-[100dvh] flex flex-col overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden relative w-full">

        <!-- OVERLAY SIDEBAR MOBILE -->
        <div x-show="sidebarOpen"
             x-transition.opacity
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
             @click="sidebarOpen = false" x-cloak></div>

        <!-- SIDEBAR -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 lg:translate-x-0 lg:static shrink-0 bg-[#0f172a] h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <!-- AREA KONTEN UTAMA -->
        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 bg-slate-50/50 w-full">

            <div class="absolute top-0 right-0 -z-10 w-[300px] md:w-[500px] h-[300px] md:h-[500px] bg-emerald-500/10 md:bg-emerald-500/5 rounded-full blur-3xl md:blur-[120px] transform translate-x-1/3 -translate-y-1/4 pointer-events-none"></div>

            <!-- HEADER -->
            <header class="h-16 md:h-20 bg-white/80 backdrop-blur-xl border-b border-slate-200/90 flex items-center justify-between px-4 lg:px-10 shrink-0 z-20 gsap-header shadow-sm">
                <div class="flex items-center gap-3 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate flex-1 min-w-0">
                        <h1 class="text-lg md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Manajemen <span class="text-emerald-600">Mahasiswa</span></h1>
                        <p class="text-[9px] md:text-xs text-slate-500 font-bold hidden sm:block mt-1">Kelola data, akses login, dan pantau biodata lengkap mahasiswa</p>
                    </div>
                </div>

                <div class="flex items-center shrink-0">
                    <button onclick="openCreateModal()" class="bg-[#047857] hover:bg-[#065f46] text-white px-3 py-1.5 md:px-5 md:py-2.5 rounded-lg md:rounded-xl text-[10px] md:text-xs font-black transition-all flex items-center gap-2 shadow-lg shadow-emerald-700/20 active:scale-95 gsap-btn uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        <span class="hidden sm:inline">Tambah Akun Baru</span>
                        <span class="sm:hidden">Tambah</span>
                    </button>
                </div>
            </header>

            <!-- KONTEN SCROLLABLE -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 lg:p-10 custom-scrollbar w-full relative z-10 pb-20">
                <div class="max-w-[1600px] mx-auto space-y-6 md:space-y-8 w-full">

                    <!-- GRID STATISTIK -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 w-full">

                        <div class="bg-gradient-to-br from-[#0a2540] via-[#0f4a8a] to-[#047857] rounded-[1.5rem] md:rounded-2xl p-5 md:p-6 text-white shadow-xl border-2 border-slate-800 relative overflow-hidden gsap-card w-full">
                            <div class="absolute right-0 top-0 opacity-10 transform translate-x-2 -translate-y-2 pointer-events-none">
                                <svg class="w-24 h-24 md:w-32 md:h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356.257l4 4.5a1 1 0 001.488 0l4-4.5a.999.999 0 01.356-.257l2.644-1.131a1 1 0 000-1.84l-7-3zM3.208 9.404L8.1 11.5a1 1 0 00.8 0l4.892-2.096A6.97 6.97 0 0113 11v1a1 1 0 01-1 1H8a1 1 0 01-1-1v-1c0-.555-.07-1.1-.208-1.596z"></path></svg>
                            </div>
                            <p class="text-[10px] md:text-[11px] text-slate-200 font-black mb-1 md:mb-1.5 uppercase tracking-widest relative z-10">Total Mahasiswa</p>
                            <div class="flex items-baseline gap-2 relative z-10">
                                <p class="text-3xl md:text-4xl font-black tracking-tight">{{ $students->count() }}</p>
                                <p class="text-[10px] md:text-xs font-bold text-emerald-300 uppercase tracking-wider">Pengguna Terdaftar</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-[1.5rem] md:rounded-2xl p-5 md:p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow gsap-card w-full">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-50 text-emerald-600 rounded-xl border-2 border-emerald-200 flex items-center justify-center shadow-inner font-black shrink-0">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] md:text-[11px] text-slate-400 font-black uppercase tracking-wider mb-0.5 md:mb-1">Estimasi Aktif / Minggu</p>
                                    <p class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">{{ floor($students->count() * 0.85) }} <span class="text-[9px] md:text-[10px] font-black text-emerald-700 bg-emerald-100 border border-emerald-200 px-1.5 md:px-2 py-0.5 rounded-md ml-1 align-middle shadow-sm">~85%</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-[1.5rem] md:rounded-2xl p-5 md:p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow gsap-card w-full sm:col-span-2 lg:col-span-1">
                            <div class="flex items-center gap-3 md:gap-4">
                                <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-50 text-amber-500 rounded-xl border-2 border-amber-200 flex items-center justify-center shadow-inner font-black shrink-0">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] md:text-[11px] text-slate-400 font-black uppercase tracking-wider mb-0.5 md:mb-1">Total XP Terkumpul</p>
                                    <p class="text-xl md:text-2xl font-black text-slate-900 tracking-tight">{{ number_format($students->sum('xp')) }} <span class="text-[10px] md:text-xs font-bold text-slate-400 align-middle">XP</span></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- TABEL DIREKTORI MAHASISWA -->
                    <div class="bg-white rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden gsap-table-wrap w-full flex flex-col">
                        <div class="p-4 md:p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/80 shrink-0">
                            <div class="flex items-center gap-2 md:gap-2.5">
                                <span class="w-2.5 h-2.5 md:w-3 md:h-3 rounded-full bg-emerald-500 animate-pulse shadow-sm shadow-emerald-500/50"></span>
                                <h2 class="text-[11px] md:text-sm font-black text-slate-900 uppercase tracking-wider leading-none">Biodata Mahasiswa</h2>
                            </div>
                            <span class="text-[9px] md:text-[10px] font-black text-slate-500 bg-slate-200 px-2 md:px-3 py-1 rounded-full uppercase tracking-widest shadow-inner">{{ $students->count() }} Data</span>
                        </div>

                        <div class="w-full overflow-x-auto custom-scrollbar flex-1">
                            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[700px] md:min-w-[900px]">
                                <thead>
                                    <tr class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-200 bg-white">
                                        <th class="px-4 md:px-6 py-3 md:py-4">Profil Mahasiswa</th>
                                        <th class="px-4 md:px-6 py-3 md:py-4">NIM & Program Studi</th>
                                        <th class="px-4 md:px-6 py-3 md:py-4">Status & Level</th>
                                        <th class="px-4 md:px-6 py-3 md:py-4 text-center">Aksi (CRUD)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($students as $student)
                                    <tr class="hover:bg-slate-50/80 transition-colors group gsap-row">

                                        <td class="px-4 md:px-6 py-3 md:py-4">
                                            <div class="flex items-center gap-3 md:gap-4">
                                                @if($student->avatar)
                                                    <img src="{{ asset('storage/' . $student->avatar) }}" class="w-9 h-9 md:w-11 md:h-11 rounded-lg md:rounded-xl object-cover border border-slate-200 shadow-sm shrink-0">
                                                @else
                                                    <div class="w-9 h-9 md:w-11 md:h-11 bg-slate-900 text-emerald-400 rounded-lg md:rounded-xl flex items-center justify-center font-black text-xs md:text-base shadow-sm shrink-0 border border-slate-700">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="truncate max-w-[120px] sm:max-w-[200px] md:max-w-none">
                                                    <p class="text-xs md:text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors truncate">{{ $student->name }}</p>
                                                    <p class="text-[9px] md:text-[11px] text-slate-500 font-bold truncate">{{ $student->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 md:px-6 py-3 md:py-4">
                                            <p class="text-[10px] md:text-xs font-black text-slate-900 truncate">{{ $student->nim ?? 'NIM Belum Diisi' }}</p>
                                            <p class="text-[9px] md:text-[11px] font-bold text-emerald-600 mt-0.5 truncate">{{ $student->prodi ?? 'Prodi Belum Diatur' }}</p>
                                        </td>

                                        <td class="px-4 md:px-6 py-3 md:py-4">
                                            <div class="flex items-center gap-2 md:gap-3">
                                                <span class="inline-flex items-center gap-1.5 px-2 md:px-3 py-1 rounded-md md:rounded-lg text-[9px] md:text-[10px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase tracking-wider shadow-sm">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> AKTIF
                                                </span>
                                                <div class="text-[10px] md:text-xs font-black text-slate-800 flex items-center gap-1 bg-amber-50 px-2 py-0.5 md:px-2.5 md:py-1 rounded-lg border border-amber-200 shadow-sm">
                                                    <span class="text-amber-500">⚡</span> {{ number_format($student->xp) }} <span class="text-[8px] md:text-[9px] text-slate-400">XP</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 md:px-6 py-3 md:py-4 text-center">
                                            <div class="flex items-center justify-center gap-1.5 md:gap-2">

                                                <a href="{{ route('admin.users.show', $student->id) }}"
                                                   class="px-2.5 md:px-3.5 py-1.5 bg-[#047857] hover:bg-[#065f46] text-white rounded-lg text-[9px] md:text-[10px] font-black uppercase tracking-wider transition-all flex items-center gap-1.5 shadow-sm active:scale-95"
                                                   title="Lihat Detail Biodata">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    <span class="hidden sm:inline">Biodata</span>
                                                </a>

                                                <button onclick="openEditModal({{ $student->id }}, '{{ addslashes($student->name) }}', '{{ addslashes($student->email) }}')"
                                                        class="p-1.5 md:p-2 text-slate-500 hover:text-amber-600 hover:bg-amber-50 border border-slate-200 rounded-lg transition-all shadow-sm active:scale-95"
                                                        title="Edit Nama / Email / Password">
                                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>

                                                <button onclick="confirmDelete({{ $student->id }}, '{{ addslashes($student->name) }}')"
                                                        class="p-1.5 md:p-2 text-slate-500 hover:text-rose-600 hover:bg-rose-50 border border-slate-200 rounded-lg transition-all shadow-sm active:scale-95"
                                                        title="Hapus Akun Mahasiswa">
                                                    <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>

                                                <form id="delete-form-{{ $student->id }}" action="{{ route('admin.users.destroy', $student->id) }}" method="POST" style="display: none;">
                                                    @csrf @method('DELETE')
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <span class="text-4xl md:text-5xl opacity-30 grayscale mb-3">📂</span>
                                                <p class="text-xs md:text-sm font-bold text-slate-500">Belum Ada Data Mahasiswa Terdaftar</p>
                                            </div>
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

    <!-- MODAL CREATE USER -->
    <div id="modalCreate" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-[100] flex items-center justify-center invisible opacity-0 transition-all duration-300 p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white w-full max-w-md rounded-2xl md:rounded-[2rem] shadow-2xl p-6 md:p-8 border border-slate-200 transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="modalCreateContent">

            <div class="flex justify-between items-center mb-5 md:mb-6 border-b border-slate-100 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 border border-emerald-100 rounded-xl flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base md:text-lg leading-tight">Registrasi Mahasiswa</h3>
                        <p class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Tambah Akun Baru</p>
                    </div>
                </div>
                <button onclick="closeCreateModal()" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 p-2 rounded-xl transition-all border border-slate-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-1">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all shadow-inner" placeholder="Contoh: Andi Pratama" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wider">Email Login</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all shadow-inner" placeholder="andi@student.ac.id" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wider">Password Akses</label>
                        <div class="relative" x-data="{ showPass: false }">
                            <input :type="showPass ? 'text' : 'password'" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition-all pr-10 shadow-inner" placeholder="Minimal 6 karakter" required>
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-2.5 text-slate-400 hover:text-emerald-600 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-[#047857] hover:bg-[#065f46] text-white py-3.5 md:py-4 rounded-xl text-[11px] md:text-xs font-black uppercase tracking-widest transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Simpan Akun Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT USER -->
    <div id="modalEdit" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-[100] flex items-center justify-center invisible opacity-0 transition-all duration-300 p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white w-full max-w-md rounded-2xl md:rounded-[2rem] shadow-2xl p-6 md:p-8 border border-slate-200 transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="modalEditContent">

            <div class="flex justify-between items-center mb-5 md:mb-6 border-b border-slate-100 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 border border-amber-100 rounded-xl flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base md:text-lg leading-tight">Perbarui Akun</h3>
                        <p class="text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-wider mt-0.5">Edit Akses Login Siswa</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-rose-500 bg-slate-50 hover:bg-rose-50 p-2 rounded-xl transition-all border border-slate-100 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-1">
                <form id="editForm" action="#" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all shadow-inner" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wider">Email Mahasiswa</label>
                        <input type="email" name="email" id="edit_email" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all shadow-inner" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-700 mb-1.5 uppercase tracking-wider">Password Baru (Opsional)</label>
                        <input type="text" name="password" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all shadow-inner" placeholder="Kosongkan jika tidak ingin diubah">
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-3.5 md:py-4 rounded-xl text-[11px] md:text-xs font-black uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                            Terapkan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- LOGIKA JAVASCRIPT GSAP & MODAL -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if(typeof gsap !== 'undefined') {
                const tl = gsap.timeline();
                tl.from(".gsap-header", { y: -15, opacity: 0, duration: 0.5, ease: "power2.out" })
                  .from(".gsap-btn", { scale: 0.9, opacity: 0, duration: 0.4, ease: "back.out(1.5)" }, "-=0.2")
                  .from(".gsap-card", { y: 20, opacity: 0, duration: 0.5, stagger: 0.1, ease: "back.out(1.2)" }, "-=0.3")
                  .from(".gsap-table-wrap", { y: 25, opacity: 0, duration: 0.5, ease: "power3.out" }, "-=0.2")
                  .from(".gsap-row", { x: -10, opacity: 0, duration: 0.2, stagger: 0.05, ease: "power1.out" }, "-=0.3");
            }

            @if(session('success'))
                Swal.fire({
                    icon: 'success', title: 'Berhasil!', text: '{{ session('success') }}',
                    confirmButtonColor: '#047857', customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl px-6 font-bold' }
                });
            @endif

            @if($errors->any()) openCreateModal(); @endif
        });

        // MODAL CREATE & EDIT LOGIC (Z-Index Diperbaiki + Lock Scroll)
        const modalCreate = document.getElementById('modalCreate');
        const contentCreate = document.getElementById('modalCreateContent');
        function openCreateModal() {
            modalCreate.classList.remove('invisible', 'opacity-0');
            contentCreate.classList.remove('scale-95');
        }
        function closeCreateModal() {
            modalCreate.classList.add('invisible', 'opacity-0');
            contentCreate.classList.add('scale-95');
        }

        const modalEdit = document.getElementById('modalEdit');
        const contentEdit = document.getElementById('modalEditContent');
        function openEditModal(id, name, email) {
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('editForm').action = '/admin/users/' + id;

            modalEdit.classList.remove('invisible', 'opacity-0');
            contentEdit.classList.remove('scale-95');
        }
        function closeEditModal() {
            modalEdit.classList.add('invisible', 'opacity-0');
            contentEdit.classList.add('scale-95');
        }

        [modalCreate, modalEdit].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) { closeCreateModal(); closeEditModal(); }
            });
        });

        // DELETE CONFIRMATION SWEETALERT2
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus ' + name + '?',
                text: "Semua data, skor XP, dan progres tugas siswa ini akan lenyap selamanya!",
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#ef4444', cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Hapus Permanen!', cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl px-4 md:px-5 font-bold', cancelButton: 'rounded-xl px-4 md:px-5 font-bold' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
            });
        }
    </script>
</body>
</html>
