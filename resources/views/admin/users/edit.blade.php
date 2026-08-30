<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Biodata Mahasiswa | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar-x::-webkit-scrollbar { height: 4px; }
        .custom-scrollbar-x::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar-x::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased font-sans h-[100dvh] flex overflow-hidden" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
        <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
    </div>

    <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-50">

        <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
            <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 rounded-xl transition-all shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="truncate">
                    <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Edit <span class="text-emerald-600">Mahasiswa</span></h1>
                </div>
            </div>
        </header>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col h-full overflow-hidden w-full"
              x-data="{
                  tab: 'data_diri',
                  photoPreview: null,
                  updatePreview(event) {
                      const file = event.target.files[0];
                      if (file) {
                          const reader = new FileReader();
                          reader.onload = (e) => { this.photoPreview = e.target.result; };
                          reader.readAsDataURL(file);
                      }
                  }
              }">
            @csrf
            @method('PUT')

            <input type="file" x-ref="avatarInput" name="avatar" class="hidden" accept="image/*" @change="updatePreview">

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-8 custom-scrollbar relative z-10 w-full">
                <div class="max-w-[1200px] mx-auto w-full pb-6">

                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3 mb-6 md:mb-8">
                        <div>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="inline-flex items-center gap-1.5 md:gap-2 px-3 py-1.5 bg-white rounded-lg border-2 border-slate-200 text-[10px] md:text-xs font-bold text-slate-500 hover:text-emerald-600 hover:border-emerald-200 transition-all mb-2 md:mb-3 shadow-sm w-fit active:scale-95">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Batal & Kembali
                            </a>
                            <h2 class="text-xl md:text-3xl font-black text-slate-900 tracking-tight leading-tight">Edit Biodata</h2>
                            <p class="text-[10px] md:text-xs font-bold text-slate-500 mt-1">Perbarui informasi data <span class="text-emerald-600">{{ $user->name }}</span></p>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-emerald-50 border-2 border-emerald-200 text-emerald-900 px-4 md:px-5 py-3 md:py-4 rounded-xl text-[10px] md:text-xs font-black mb-6 flex items-center gap-3 shadow-sm">
                            <div class="w-8 h-8 bg-emerald-600 text-white rounded-lg flex items-center justify-center shrink-0">✔</div>
                            <div>
                                <p class="font-black text-emerald-800">Berhasil!</p>
                                <p class="font-medium text-emerald-600">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm border-2 border-slate-200 overflow-hidden mb-6 md:mb-8 p-4 md:p-6 w-full">
                        <div class="relative rounded-xl md:rounded-[1.5rem] bg-slate-900 p-5 md:p-8 text-white overflow-hidden shadow-inner flex flex-col sm:flex-row gap-5 md:gap-8 items-center sm:items-start text-center sm:text-left border-b-4 border-emerald-500">

                            <div class="relative group cursor-pointer shrink-0" @click="$refs.avatarInput.click()">
                                <div class="w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 rounded-2xl border-4 border-white shadow-xl bg-slate-800 overflow-hidden relative transition-transform duration-300 group-hover:scale-105">
                                    <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                                    <template x-if="!photoPreview">
                                        <div class="w-full h-full">
                                            @if($user->avatar)
                                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-emerald-400 text-4xl md:text-6xl font-black bg-white">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                    </template>

                                    <div class="absolute inset-0 bg-slate-900/75 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity backdrop-blur-[2px]">
                                        <svg class="w-6 h-6 md:w-8 md:h-8 text-emerald-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                                        <span class="text-[9px] md:text-[10px] font-black text-white tracking-widest uppercase">Ubah Foto</span>
                                    </div>
                                </div>
                                <template x-if="photoPreview">
                                    <span class="absolute -top-2 -right-2 bg-emerald-500 text-white text-[9px] font-black px-2 py-1 rounded-full border-2 border-white shadow-md flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span> Baru
                                    </span>
                                </template>
                            </div>

                            <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                <div>
                                    <label class="block text-[10px] md:text-xs font-black uppercase tracking-widest text-slate-300 mb-1.5">Status Akademik</label>
                                    <select name="status_akademik" class="w-full bg-white border-2 border-slate-200 rounded-xl px-3 py-2.5 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-all">
                                        <option value="Aktif" {{ $user->status_akademik == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Cuti" {{ $user->status_akademik == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                        <option value="Lulus" {{ $user->status_akademik == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Drop Out" {{ $user->status_akademik == 'Drop Out' ? 'selected' : '' }}>Drop Out</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] md:text-xs font-black uppercase tracking-widest text-slate-300 mb-1.5">Hak Akses (Role)</label>
                                    <select name="role" class="w-full bg-white border-2 border-slate-200 rounded-xl px-3 py-2.5 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-all">
                                        <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>Student (Mahasiswa)</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-6 md:mb-8 w-full overflow-hidden bg-white rounded-xl md:rounded-2xl border-2 border-slate-200 p-1.5 md:p-2 shadow-sm">
                        <div class="flex gap-2 overflow-x-auto custom-scrollbar-x pb-1 px-1 snap-x">
                            @php
                                $tabs = [
                                    ['key' => 'data_diri', 'label' => 'Biodata & Akun', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                    ['key' => 'akademik', 'label' => 'Akademik', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z'],
                                    ['key' => 'alamat', 'label' => 'Alamat Domisili', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                    ['key' => 'keluarga', 'label' => 'Keluarga & Wali', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z'],
                                    ['key' => 'lainnya', 'label' => 'Riwayat', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                                ];
                            @endphp
                            @foreach($tabs as $t)
                                <button type="button" @click="tab = '{{ $t['key'] }}'"
                                        :class="tab === '{{ $t['key'] }}' ? 'bg-slate-900 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 text-slate-600'"
                                        class="flex items-center justify-center gap-1.5 md:gap-2 px-4 py-2 md:px-5 md:py-2.5 rounded-lg transition-all shrink-0 font-black text-[9px] md:text-[10px] uppercase tracking-wider snap-start whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $t['icon'] }}"></path></svg>
                                    <span>{{ $t['label'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm border-2 border-slate-200 p-4 md:p-8 lg:p-10 relative overflow-hidden w-full">

                        <div x-show="tab === 'data_diri'" x-transition.opacity x-cloak class="space-y-6 md:space-y-8 w-full">

                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-slate-800">
                                <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded bg-slate-800 text-white flex items-center justify-center text-[10px]">🔒</span> Akses Akun & Kontak
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Email Login</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Ubah Password (Opsional)</label>
                                        <input type="text" name="password" placeholder="Kosongkan jika tidak diubah" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">No. HP / WhatsApp Aktif</label>
                                        <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 transition-colors shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-emerald-600">
                                <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px]">1</span> Biodata Pribadi
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5">
                                    <div class="sm:col-span-2 lg:col-span-1">
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">NIK KTP</label>
                                        <input type="text" name="nik" value="{{ old('nik', $user->nik) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">NPWP (Jika Ada)</label>
                                        <input type="text" name="npwp" value="{{ old('npwp', $user->npwp) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $user->tempat_lahir) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Agama</label>
                                        <select name="agama" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                            <option value="">Pilih Agama</option>
                                            <option value="Islam" {{ $user->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ $user->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ $user->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ $user->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ $user->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ $user->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Kewarganegaraan</label>
                                        <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', $user->kewarganegaraan ?? 'Indonesia') }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 transition-colors shadow-sm">
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2">Jenis Kelamin</label>
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <label class="flex-1 flex items-center gap-3 cursor-pointer bg-slate-50 px-4 py-3 rounded-xl border-2 border-slate-200 hover:border-emerald-500 text-xs md:text-sm font-bold text-slate-700 transition-colors shadow-sm">
                                                <input type="radio" name="jenis_kelamin" value="Laki-Laki" {{ $user->jenis_kelamin == 'Laki-Laki' || $user->jenis_kelamin == 'L' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600"> 👨 Laki-Laki
                                            </label>
                                            <label class="flex-1 flex items-center gap-3 cursor-pointer bg-slate-50 px-4 py-3 rounded-xl border-2 border-slate-200 hover:border-emerald-500 text-xs md:text-sm font-bold text-slate-700 transition-colors shadow-sm">
                                                <input type="radio" name="jenis_kelamin" value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' || $user->jenis_kelamin == 'P' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600"> 👩 Perempuan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'akademik'" x-cloak class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-8 border-l-4 border-l-emerald-600 w-full">
                            <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <span class="w-5 h-5 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px]">🎓</span> Informasi Akademik
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5 w-full">
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Perguruan Tinggi</label>
                                    <input type="text" name="universitas" value="{{ old('universitas', $user->universitas) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">NIM</label>
                                    <input type="text" name="nim" value="{{ old('nim', $user->nim) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Program Studi</label>
                                    <input type="text" name="prodi" value="{{ old('prodi', $user->prodi) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Asal Kelas / Rombel</label>
                                    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Tahun Angkatan</label>
                                    <input type="number" name="angkatan" value="{{ old('angkatan', $user->angkatan) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Dosen PA / Wali</label>
                                    <input type="text" name="dosen_pa" value="{{ old('dosen_pa', $user->dosen_pa) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Jalur Pendaftaran</label>
                                    <input type="text" name="jalur_pendaftaran" value="{{ old('jalur_pendaftaran', $user->jalur_pendaftaran) }}" placeholder="SNMPTN/SBMPTN/dll" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Golongan / Nominal UKT</label>
                                    <input type="text" name="ukt" value="{{ old('ukt', $user->ukt) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-600 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'alamat'" x-cloak class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-8 border-l-4 border-l-amber-500 w-full">
                            <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <span class="w-5 h-5 rounded bg-amber-500 text-white flex items-center justify-center text-[10px]">🏡</span> Domisili
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5 w-full">
                                <div class="sm:col-span-2 lg:col-span-3">
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Jalan / Detail Perumahan</label>
                                    <textarea name="jalan" rows="2" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">{{ old('jalan', $user->jalan) }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Dusun / RT / RW</label>
                                    <div class="flex gap-2">
                                        <input type="text" name="dusun" value="{{ old('dusun', $user->dusun) }}" placeholder="Dusun" class="w-1/2 px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">
                                        <input type="text" name="rt" value="{{ old('rt', $user->rt) }}" placeholder="RT" class="w-1/4 px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm text-center">
                                        <input type="text" name="rw" value="{{ old('rw', $user->rw) }}" placeholder="RW" class="w-1/4 px-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm text-center">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Kelurahan / Desa</label>
                                    <input type="text" name="kelurahan" value="{{ old('kelurahan', $user->kelurahan) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Kecamatan</label>
                                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $user->kecamatan) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Kabupaten / Kota</label>
                                    <input type="text" name="kab_kota" value="{{ old('kab_kota', $user->kab_kota) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Provinsi</label>
                                    <input type="text" name="provinsi" value="{{ old('provinsi', $user->provinsi) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Kode Pos</label>
                                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $user->kode_pos) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-amber-500 shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'keluarga'" x-cloak class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6 w-full">
                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-slate-800 space-y-3 shadow-sm">
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider border-b-2 border-slate-100 pb-2">👨 Biodata Ayah</h3>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Ayah</label>
                                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $user->nama_ayah) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">No HP Ayah</label>
                                    <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah', $user->no_hp_ayah) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Alamat Ayah</label>
                                    <textarea name="alamat_ayah" rows="2" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 shadow-sm">{{ old('alamat_ayah', $user->alamat_ayah) }}</textarea>
                                </div>
                            </div>

                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-slate-800 space-y-3 shadow-sm">
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider border-b-2 border-slate-100 pb-2">👩 Biodata Ibu</h3>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Ibu</label>
                                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $user->nama_ibu) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">No HP Ibu</label>
                                    <input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu', $user->no_hp_ibu) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Alamat Ibu</label>
                                    <textarea name="alamat_ibu" rows="2" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-slate-800 shadow-sm">{{ old('alamat_ibu', $user->alamat_ibu) }}</textarea>
                                </div>
                            </div>

                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-blue-500 space-y-3 shadow-sm sm:col-span-2">
                                <h3 class="text-xs font-black text-blue-600 uppercase tracking-wider border-b-2 border-slate-100 pb-2">🛡️ Data Wali (Opsional)</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Wali</label>
                                        <input type="text" name="nama_wali" value="{{ old('nama_wali', $user->nama_wali) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-blue-500 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">No HP Wali</label>
                                        <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali', $user->no_hp_wali) }}" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-blue-500 shadow-sm">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'lainnya'" x-cloak class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-8 border-l-4 border-l-purple-600 w-full shadow-sm">
                            <div class="text-center mb-6">
                                <span class="text-4xl md:text-5xl">🎓</span>
                                <h3 class="text-sm md:text-base font-black text-slate-800 uppercase tracking-wide mt-3">Riwayat Pendidikan Terakhir</h3>
                                <p class="text-[10px] md:text-xs text-slate-500 font-bold max-w-lg mx-auto mt-1">Data asal SMA/SMK atau Perguruan Tinggi Asal jika berstatus mahasiswa transfer/pindahan.</p>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6 max-w-4xl mx-auto w-full">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Perguruan Tinggi Asal / Sekolah Asal</label>
                                    <input type="text" name="pt_asal" value="{{ old('pt_asal', $user->pt_asal) }}" placeholder="Contoh: SMA Negeri 1 Palembang" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-purple-600 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-1.5">Tahun Lulus Pendidikan Terakhir</label>
                                    <input type="text" name="riwayat_pendidikan_terakhir" value="{{ old('riwayat_pendidikan_terakhir', $user->riwayat_pendidikan_terakhir) }}" placeholder="Tahun kelulusan..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl px-4 py-3 text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-purple-600 shadow-sm">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>

            <div class="bg-white border-t-2 border-slate-200 p-4 shrink-0 z-20 shadow-[0_-5px_15px_rgba(0,0,0,0.05)] w-full relative">
                <div class="max-w-[1200px] mx-auto flex items-center justify-between gap-4">
                    <p class="text-[9px] md:text-xs font-bold text-slate-500 hidden sm:block">* Pastikan Anda mengecek ulang data form sebelum memperbarui.</p>
                    <div class="flex items-center justify-between sm:justify-end gap-2 md:gap-3 w-full sm:w-auto">
                        <a href="{{ route('admin.users.show', $user->id) }}" class="flex-1 sm:flex-none px-4 md:px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-black rounded-xl md:rounded-xl text-[10px] md:text-xs uppercase tracking-widest transition-all text-center">Batal</a>
                        <button type="submit" class="flex-1 sm:flex-none px-4 md:px-8 py-3.5 bg-slate-900 hover:bg-emerald-600 text-white font-black rounded-xl md:rounded-xl text-[10px] md:text-xs uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Data
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</body>
</html>
