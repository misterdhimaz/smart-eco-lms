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
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 4px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #64748b; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-900 selection:bg-emerald-600 selection:text-white h-[100dvh] flex flex-col overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden relative w-full">

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 bg-slate-100 w-full">

            <header class="h-16 md:h-20 bg-white border-b-2 border-slate-200 flex items-center justify-between px-4 lg:px-8 z-20 shrink-0 gsap-header">
                <div class="flex items-center gap-3 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate flex-1 min-w-0">
                        <h1 class="text-lg md:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Manajemen <span class="text-emerald-600">Mahasiswa</span></h1>
                        <p class="text-[10px] md:text-xs text-slate-500 font-bold hidden sm:block mt-1">Direktori Lengkap Data Akademik</p>
                    </div>
                </div>

                <div class="flex items-center shrink-0">
                    <button onclick="openCreateModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 md:px-5 md:py-2.5 rounded-xl text-[10px] md:text-xs font-black transition-all flex items-center gap-2 active:scale-95 gsap-btn uppercase tracking-widest shadow-md">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        <span class="hidden sm:inline">Tambah Akun Baru</span>
                        <span class="sm:hidden">Tambah</span>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 lg:p-8 custom-scrollbar w-full relative z-10 pb-20">
                <div class="max-w-[1400px] mx-auto space-y-6 md:space-y-8 w-full">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 w-full">

                        <div class="bg-slate-900 rounded-2xl p-6 text-white border-b-4 border-emerald-500 shadow-md relative overflow-hidden gsap-card w-full">
                            <p class="text-xs text-slate-400 font-black mb-2 uppercase tracking-widest relative z-10">Total Mahasiswa</p>
                            <div class="flex items-baseline gap-2 relative z-10">
                                <p class="text-4xl md:text-5xl font-black tracking-tight">{{ $students->count() }}</p>
                                <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Akun Aktif</p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm gsap-card w-full">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-black shrink-0 shadow-md">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] md:text-xs text-slate-500 font-black uppercase tracking-wider mb-1">Estimasi Aktif</p>
                                    <p class="text-2xl font-black text-slate-900 tracking-tight">{{ floor($students->count() * 0.85) }} <span class="text-[10px] font-black text-white bg-emerald-600 px-2 py-0.5 rounded ml-1 align-middle">~85%</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 border-2 border-slate-200 shadow-sm gsap-card w-full sm:col-span-2 lg:col-span-1">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-amber-500 text-white rounded-xl flex items-center justify-center font-black shrink-0 shadow-md">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] md:text-xs text-slate-500 font-black uppercase tracking-wider mb-1">Total XP Terkumpul</p>
                                    <p class="text-2xl font-black text-slate-900 tracking-tight">{{ number_format($students->sum('xp')) }} <span class="text-xs font-bold text-slate-400 align-middle">XP</span></p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="bg-white rounded-2xl border-2 border-slate-200 overflow-hidden gsap-table-wrap w-full flex flex-col shadow-sm">
                        <div class="p-4 md:p-6 border-b-2 border-slate-200 flex justify-between items-center bg-slate-50 shrink-0">
                            <h2 class="text-xs md:text-sm font-black text-slate-900 uppercase tracking-widest leading-none">Biodata Mahasiswa</h2>
                            <span class="text-[10px] font-black text-white bg-slate-800 px-3 py-1 rounded-md uppercase tracking-widest">{{ $students->count() }} Data</span>
                        </div>

                        <div class="w-full overflow-x-auto custom-scrollbar flex-1">
                            <table class="w-full text-left border-collapse whitespace-nowrap min-w-[800px]">
                                <thead>
                                    <tr class="text-[10px] font-black text-slate-500 uppercase tracking-widest bg-slate-100 border-b-2 border-slate-200">
                                        <th class="px-6 py-4">Profil Mahasiswa</th>
                                        <th class="px-6 py-4">NIM & Program Studi</th>
                                        <th class="px-6 py-4">Status & Level</th>
                                        <th class="px-6 py-4 text-center">Aksi (CRUD)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse($students as $student)
                                    <tr class="hover:bg-slate-50 transition-colors group gsap-row">

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                @if($student->avatar)
                                                    <img src="{{ asset('storage/' . $student->avatar) }}" class="w-10 h-10 md:w-12 md:h-12 rounded-lg object-cover border-2 border-slate-200 shrink-0">
                                                @else
                                                    <div class="w-10 h-10 md:w-12 md:h-12 bg-slate-800 text-white rounded-lg flex items-center justify-center font-black text-lg shrink-0">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div class="truncate max-w-[150px] sm:max-w-[250px]">
                                                    <p class="text-sm font-black text-slate-900 group-hover:text-emerald-700 transition-colors truncate">{{ $student->name }}</p>
                                                    <p class="text-[10px] md:text-xs text-slate-500 font-bold truncate">{{ $student->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <p class="text-xs md:text-sm font-black text-slate-900 truncate">{{ $student->nim ?? 'NIM Belum Diisi' }}</p>
                                            <p class="text-[10px] md:text-xs font-bold text-slate-500 mt-0.5 truncate">{{ $student->prodi ?? 'Prodi Belum Diatur' }}</p>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 bg-emerald-600 text-white rounded text-[10px] font-black uppercase tracking-widest shadow-sm">AKTIF</span>
                                                <div class="text-[10px] md:text-xs font-black text-slate-900 flex items-center gap-1 bg-amber-100 px-2.5 py-1 rounded border border-amber-300">
                                                    <span class="text-amber-500">⚡</span> {{ number_format($student->xp) }} XP
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">

                                                <a href="{{ route('admin.users.show', $student->id) }}"
                                                   class="px-3 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-1.5 shadow-md active:scale-95">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    <span class="hidden sm:inline">Biodata</span>
                                                </a>

                                                <button onclick="openEditModal({{ $student->id }}, '{{ addslashes($student->name) }}', '{{ addslashes($student->email) }}')"
                                                        class="p-2 text-slate-500 hover:text-white hover:bg-blue-600 border-2 border-slate-200 hover:border-blue-600 rounded-lg transition-all active:scale-95"
                                                        title="Edit Akses">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>

                                                <button onclick="confirmDelete({{ $student->id }}, '{{ addslashes($student->name) }}')"
                                                        class="p-2 text-slate-500 hover:text-white hover:bg-rose-600 border-2 border-slate-200 hover:border-rose-600 rounded-lg transition-all active:scale-95"
                                                        title="Hapus Akun">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
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
                                                <span class="text-4xl md:text-5xl opacity-40 mb-3">📂</span>
                                                <p class="text-xs md:text-sm font-black text-slate-500">Belum Ada Data Mahasiswa Terdaftar</p>
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

    <div id="modalCreate" class="fixed inset-0 bg-slate-900/80 z-[100] flex items-center justify-center invisible opacity-0 transition-all duration-300 p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 md:p-8 border-2 border-slate-800 transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="modalCreateContent">

            <div class="flex justify-between items-center mb-6 border-b-2 border-slate-200 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base md:text-lg leading-tight">Registrasi Mahasiswa</h3>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Tambah Akun Baru</p>
                    </div>
                </div>
                <button onclick="closeCreateModal()" class="text-slate-500 hover:text-white hover:bg-rose-600 p-2 rounded-lg border-2 border-slate-200 hover:border-rose-600 transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2">
                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-900 focus:bg-white focus:border-emerald-600 outline-none transition-all" placeholder="Contoh: Andi Pratama" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Email Login</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-900 focus:bg-white focus:border-emerald-600 outline-none transition-all" placeholder="andi@student.ac.id" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Password Akses</label>
                        <div class="relative" x-data="{ showPass: false }">
                            <input :type="showPass ? 'text' : 'password'" name="password" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-900 focus:bg-white focus:border-emerald-600 outline-none transition-all pr-10" placeholder="Minimal 6 karakter" required>
                            <button type="button" @click="showPass = !showPass" class="absolute right-3 top-3 text-slate-400 hover:text-emerald-600 p-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 md:py-4 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg> Simpan Akun Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalEdit" class="fixed inset-0 bg-slate-900/80 z-[100] flex items-center justify-center invisible opacity-0 transition-all duration-300 p-4 w-screen h-[100dvh] overflow-hidden">
        <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 md:p-8 border-2 border-slate-800 transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]" id="modalEditContent">

            <div class="flex justify-between items-center mb-6 border-b-2 border-slate-200 pb-4 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base md:text-lg leading-tight">Perbarui Akun</h3>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-0.5">Edit Akses Login Siswa</p>
                    </div>
                </div>
                <button onclick="closeEditModal()" class="text-slate-500 hover:text-white hover:bg-rose-600 p-2 rounded-lg border-2 border-slate-200 hover:border-rose-600 transition-all shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar pr-2">
                <form id="editForm" action="#" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                        <input type="text" name="name" id="edit_name" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-600 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Email Mahasiswa</label>
                        <input type="email" name="email" id="edit_email" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-600 outline-none transition-all" required>
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-800 mb-1.5 uppercase tracking-wider">Password Baru (Opsional)</label>
                        <input type="text" name="password" class="w-full bg-slate-50 border-2 border-slate-300 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-900 focus:bg-white focus:border-blue-600 outline-none transition-all" placeholder="Kosongkan jika tidak ingin diubah">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3.5 md:py-4 rounded-xl text-xs font-black uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                            Terapkan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    confirmButtonColor: '#047857', customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-6 font-bold' }
                });
            @endif

            @if($errors->any()) openCreateModal(); @endif
        });

        // MODAL LOGIC
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
                confirmButtonColor: '#e11d48', cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Permanen!', cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl px-4 md:px-5 font-bold', cancelButton: 'rounded-xl px-4 md:px-5 font-bold' }
            }).then((result) => {
                if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); }
            });
        }
    </script>
</body>
</html>
