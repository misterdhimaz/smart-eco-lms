<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Detail Biodata Mahasiswa | SMART-ECO Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        [x-cloak] { display: none !important; }
        .print-only { display: none; }

        @media print {
            @page { size: A4 portrait; margin: 1.5cm; }
            body * { visibility: hidden; }
            .screen-only { display: none !important; }

            .print-only, .print-only * { visibility: visible; }
            .print-only { position: absolute; left: 0; top: 0; width: 100%; font-family: 'Times New Roman', Times, serif; color: #000; display: block; }
            .print-header { display: flex; align-items: center; border-bottom: 3px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
            .print-header img { width: 80px; height: 80px; margin-right: 20px; }
            .print-header h1 { font-size: 20px; font-weight: bold; margin: 0 0 5px 0; letter-spacing: 1px; }
            .print-header h2 { font-size: 16px; margin: 0 0 3px 0; }
            .print-header p { font-size: 12px; margin: 0; }
            .print-photo { position: absolute; top: 120px; right: 0; width: 3cm; height: 4cm; border: 1px solid #000; }
            .print-photo img { width: 100%; height: 100%; object-fit: cover; }
            .print-photo div { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 30px; background: #eee; -webkit-print-color-adjust: exact; }
            .print-section { margin-bottom: 20px; padding-right: 3.5cm; }
            .print-section:nth-of-type(3), .print-section:nth-of-type(4) { padding-right: 0; }
            .print-section-title { font-size: 14px; font-weight: bold; background-color: #e2e8f0; -webkit-print-color-adjust: exact; padding: 5px 10px; margin-bottom: 10px; border: 1px solid #000; }
            .print-table { width: 100%; border-collapse: collapse; font-size: 12px; line-height: 1.5; }
            .print-table td { padding: 4px 8px; vertical-align: top; }
            .print-signature { margin-top: 50px; width: 250px; float: right; text-align: center; font-size: 12px; }
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased font-sans h-[100dvh] flex overflow-hidden" x-data="{ sidebarOpen: false }">

    <div class="flex flex-1 overflow-hidden relative w-full screen-only">

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/90 z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static shrink-0 bg-slate-900 h-[100dvh]">
            <x-admin-sidebar :admin="$admin ?? Auth::user()" class="h-full" />
        </div>

        <div class="flex-1 flex flex-col min-w-0 h-full overflow-hidden relative z-10 w-full bg-slate-100">

            <header class="h-14 md:h-[76px] bg-white border-b-2 border-slate-200 flex items-center justify-between px-3 md:px-8 z-30 shrink-0 shadow-sm">
                <div class="flex items-center gap-2 md:gap-4 truncate w-full md:w-auto">
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 md:p-2 -ml-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div class="truncate">
                        <h1 class="text-sm md:text-xl lg:text-2xl font-black text-slate-900 tracking-tight leading-none truncate">Detail <span class="text-emerald-600">Mahasiswa</span></h1>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-3 md:p-6 lg:p-8 custom-scrollbar relative z-10 w-full pb-20">
                <div class="max-w-[1200px] mx-auto w-full" x-data="{ tab: 'data_diri' }">

                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-3 mb-6 md:mb-8">
                        <div>
                            <a href="{{ route('admin.users') }}" class="inline-flex items-center gap-1.5 md:gap-2 px-3 py-1.5 bg-white rounded-lg border-2 border-slate-200 text-[10px] md:text-xs font-bold text-slate-600 hover:text-emerald-700 hover:border-emerald-300 transition-all mb-2 md:mb-3 shadow-sm w-fit active:scale-95">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                Kembali ke Direktori
                            </a>
                            <h2 class="text-xl md:text-3xl font-black text-slate-900 tracking-tight leading-tight">Review Biodata</h2>
                            <p class="text-[10px] md:text-xs font-bold text-slate-500 mt-1">Review kelengkapan biodata dan status akun</p>
                        </div>

                        <div class="flex items-center gap-2 w-full md:w-auto">
                            <a href="{{ route('admin.users.edit', $user->id) ?? '#' }}" class="flex-1 md:flex-none justify-center px-4 md:px-5 py-2.5 md:py-3 bg-white hover:bg-slate-50 text-slate-800 font-black rounded-xl text-[10px] md:text-xs uppercase tracking-widest transition-all flex items-center gap-1.5 border-2 border-slate-300 shadow-sm active:scale-95">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                <span class="hidden sm:inline">Edit Data</span> <span class="sm:hidden">Edit</span>
                            </a>
                            <button onclick="window.print()" class="flex-1 md:flex-none justify-center px-4 md:px-5 py-2.5 md:py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl text-[10px] md:text-xs uppercase tracking-widest transition-all flex items-center gap-1.5 shadow-md active:scale-95">
                                <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                <span class="hidden sm:inline">Cetak Resmi</span> <span class="sm:hidden">Cetak</span>
                            </button>
                        </div>
                    </div>

                    <div class="bg-slate-900 rounded-2xl md:rounded-[2rem] shadow-md border-b-4 border-emerald-500 overflow-hidden mb-6 md:mb-8 p-6 md:p-8 w-full flex flex-col sm:flex-row gap-5 md:gap-8 items-center sm:items-start text-center sm:text-left">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 md:w-36 md:h-36 rounded-2xl border-4 border-white shadow-xl bg-white overflow-hidden shrink-0">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-emerald-600 text-4xl md:text-6xl font-black">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 w-full min-w-0">
                            <div class="flex items-center gap-2 justify-center sm:justify-start flex-wrap mb-2">
                                <span class="px-2.5 py-1 bg-emerald-600 text-white rounded-md text-[9px] md:text-[10px] font-black uppercase tracking-widest">
                                    Role: {{ strtoupper($user->role ?? 'Student') }}
                                </span>
                                <span class="px-2.5 py-1 bg-blue-600 text-white rounded-md text-[9px] md:text-[10px] font-black uppercase tracking-widest">
                                    Status: {{ $user->status_akademik ?? 'Aktif' }}
                                </span>
                            </div>

                            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-white uppercase mb-3 line-clamp-2">{{ $user->name }}</h2>

                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 md:gap-3 text-[9px] md:text-xs font-bold text-slate-900">
                                <span class="bg-white px-2.5 py-1 rounded-md max-w-full">🎓 {{ $user->prodi ?? 'Prodi Belum Diatur' }}</span>
                                <span class="bg-white px-2.5 py-1 rounded-md">🆔 {{ $user->nim ?? 'NIM Belum Diisi' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 w-full overflow-hidden bg-white rounded-xl md:rounded-2xl border-2 border-slate-200 p-1.5 md:p-2 shadow-sm">
                        <div class="flex gap-2 overflow-x-auto custom-scrollbar pb-1 px-1 snap-x">
                            @php
                                $tabs = [
                                    ['key' => 'data_diri', 'label' => 'Biodata', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                    ['key' => 'akademik', 'label' => 'Akademik', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z'],
                                    ['key' => 'alamat', 'label' => 'Alamat', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                    ['key' => 'keluarga', 'label' => 'Keluarga', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                                    ['key' => 'lainnya', 'label' => 'Riwayat', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                                ];
                            @endphp
                            @foreach($tabs as $t)
                                <button type="button" @click="tab = '{{ $t['key'] }}'"
                                        :class="tab === '{{ $t['key'] }}' ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 hover:bg-slate-200 text-slate-700'"
                                        class="flex items-center justify-center gap-1.5 md:gap-2 px-4 py-2 md:px-5 md:py-2.5 rounded-lg border-2 border-transparent transition-all shrink-0 font-black text-[9px] md:text-[10px] uppercase tracking-wider snap-start whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $t['icon'] }}"></path></svg>
                                    <span>{{ $t['label'] }}</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm border-2 border-slate-200 p-4 md:p-8 w-full overflow-hidden">

                        <div x-show="tab === 'data_diri'" x-cloak class="space-y-6">
                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-emerald-500">
                                <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px]">1</span> Biodata Pribadi
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-5">
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200 sm:col-span-2 md:col-span-1"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Nama Lengkap</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->name ?? '-' }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">NIK KTP</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->nik ?? '-' }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">NPWP</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->npwp ?? '-' }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200 sm:col-span-2 md:col-span-1"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Tempat, Tanggal Lahir</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->tempat_lahir ?? '-' }}, {{ $user->tanggal_lahir ? date('d-m-Y', strtotime($user->tanggal_lahir)) : '-' }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Jenis Kelamin</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->jenis_kelamin ?? '-' }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Agama</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->agama ?? '-' }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Kewarganegaraan</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->kewarganegaraan ?? 'Indonesia' }}</p></div>
                                </div>
                            </div>

                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-blue-600">
                                <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                    <span class="w-5 h-5 rounded bg-blue-600 text-white flex items-center justify-center text-[10px]">2</span> Kontak & Akun
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-5">
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Alamat Email</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->email }}</p></div>
                                    <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">No. HP / WhatsApp</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->no_hp ?? '-' }}</p></div>
                                </div>
                            </div>
                        </div>

                        <div x-show="tab === 'akademik'" x-cloak class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-emerald-600 w-full">
                            <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <span class="w-5 h-5 rounded bg-emerald-600 text-white flex items-center justify-center text-[10px]">🎓</span> Akademik
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 md:gap-5 w-full">
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200 sm:col-span-2 md:col-span-1"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Perguruan Tinggi</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->universitas ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Program Studi</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->prodi ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">NIM</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->nim ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Kelas / Rombel Asal</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->kelas ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Tahun Angkatan</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->angkatan ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Dosen PA / Wali</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->dosen_pa ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Jalur Pendaftaran</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->jalur_pendaftaran ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Golongan UKT</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->ukt ?? '-' }}</p></div>
                            </div>
                        </div>

                        <div x-show="tab === 'alamat'" x-cloak class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-amber-500 w-full">
                            <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <span class="w-5 h-5 rounded bg-amber-500 text-white flex items-center justify-center text-[10px]">🏡</span> Domisili
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-5 w-full">
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200 sm:col-span-2 lg:col-span-3"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Jalan / Komplek</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 break-words">{{ $user->jalan ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Dusun / RT / RW</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->dusun ?? '-' }} (RT:{{ $user->rt ?? '0' }}/RW:{{ $user->rw ?? '0' }})</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Kelurahan / Desa</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->kelurahan ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Kecamatan</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->kecamatan ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Kab / Kota</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->kab_kota ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Provinsi</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->provinsi ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Kode Pos</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->kode_pos ?? '-' }}</p></div>
                            </div>
                        </div>

                        <div x-show="tab === 'keluarga'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 w-full">
                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-slate-800 space-y-3">
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider border-b-2 border-slate-100 pb-2">👨 Biodata Ayah</h3>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Nama Ayah</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->nama_ayah ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">No. HP Ayah</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->no_hp_ayah ?? '-' }}</p></div>
                            </div>
                            <div class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-slate-800 space-y-3">
                                <h3 class="text-xs font-black text-slate-900 uppercase tracking-wider border-b-2 border-slate-100 pb-2">👩 Biodata Ibu</h3>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Nama Ibu</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->nama_ibu ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">No. HP Ibu</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->no_hp_ibu ?? '-' }}</p></div>
                            </div>
                        </div>

                        <div x-show="tab === 'lainnya'" x-cloak class="bg-white border-2 border-slate-200 rounded-xl md:rounded-2xl p-4 md:p-6 border-l-4 border-l-purple-600 w-full">
                            <h3 class="text-xs md:text-sm font-black text-slate-900 uppercase border-b-2 border-slate-100 pb-3 mb-4 flex items-center gap-2">
                                <span class="w-5 h-5 rounded bg-purple-600 text-white flex items-center justify-center text-[10px]">📚</span> Riwayat & Wali
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-5 w-full">
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Nama Wali (Jika Ada)</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->nama_wali ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">No. HP Wali</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->no_hp_wali ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Perguruan Tinggi / Sekolah Asal</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->pt_asal ?? '-' }}</p></div>
                                <div class="bg-slate-50 p-3 rounded-lg border-2 border-slate-200"><p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Tahun Lulus Pend. Terakhir</p><p class="text-xs md:text-sm font-bold text-slate-900 mt-1 truncate">{{ $user->riwayat_pendidikan_terakhir ?? '-' }}</p></div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>

            <div class="print-only">
                <div class="print-header">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                    <div>
                        <h1>SMART-ECO LEARNING PLATFORM</h1>
                        <h2>KARTU INDUK BIODATA MAHASISWA</h2>
                        <p>Tahun Akademik: {{ date('Y') }} / {{ date('Y')+1 }}</p>
                    </div>
                </div>

                <div class="print-photo">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="Foto">
                    @else
                        <div>{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                    @endif
                </div>

                <div class="print-section">
                    <div class="print-section-title">A. KETERANGAN PRIBADI</div>
                    <table class="print-table">
                        <tr><td width="30%">1. Nama Lengkap</td><td width="2%">:</td><td>{{ $user->name }}</td></tr>
                        <tr><td>2. NIK KTP</td><td>:</td><td>{{ $user->nik ?? '-' }}</td></tr>
                        <tr><td>3. Tempat, Tanggal Lahir</td><td>:</td><td>{{ $user->tempat_lahir ?? '-' }}, {{ $user->tanggal_lahir ? date('d-m-Y', strtotime($user->tanggal_lahir)) : '-' }}</td></tr>
                        <tr><td>4. Jenis Kelamin</td><td>:</td><td>{{ $user->jenis_kelamin ?? '-' }}</td></tr>
                        <tr><td>5. Agama</td><td>:</td><td>{{ $user->agama ?? '-' }}</td></tr>
                        <tr><td>6. No. Handphone (WA)</td><td>:</td><td>{{ $user->no_hp ?? '-' }}</td></tr>
                        <tr><td>7. Alamat Email</td><td>:</td><td>{{ $user->email }}</td></tr>
                        <tr><td>8. Alamat Lengkap</td><td>:</td><td>{{ $user->jalan ?? '-' }}, RT {{ $user->rt ?? '-' }}/RW {{ $user->rw ?? '-' }}, Kel. {{ $user->kelurahan ?? '-' }}, Kec. {{ $user->kecamatan ?? '-' }}, {{ $user->kab_kota ?? '-' }}, {{ $user->provinsi ?? '-' }} (Kode Pos: {{ $user->kode_pos ?? '-' }})</td></tr>
                    </table>
                </div>

                <div class="print-section">
                    <div class="print-section-title">B. KETERANGAN AKADEMIK</div>
                    <table class="print-table">
                        <tr><td width="30%">1. Perguruan Tinggi</td><td width="2%">:</td><td>{{ $user->universitas ?? '-' }}</td></tr>
                        <tr><td>2. Nomor Induk Mahasiswa (NIM)</td><td>:</td><td>{{ $user->nim ?? '-' }}</td></tr>
                        <tr><td>3. Program Studi</td><td>:</td><td>{{ $user->prodi ?? '-' }}</td></tr>
                        <tr><td>4. Kelas / Angkatan</td><td>:</td><td>{{ $user->kelas ?? '-' }} / {{ $user->angkatan ?? '-' }}</td></tr>
                        <tr><td>5. Dosen Pembimbing (PA)</td><td>:</td><td>{{ $user->dosen_pa ?? '-' }}</td></tr>
                        <tr><td>6. Status Akademik</td><td>:</td><td>{{ $user->status_akademik ?? 'Aktif' }}</td></tr>
                    </table>
                </div>

                <div class="print-section">
                    <div class="print-section-title">C. KETERANGAN ORANG TUA / WALI</div>
                    <table class="print-table">
                        <tr><td width="30%">1. Nama Ayah</td><td width="2%">:</td><td>{{ $user->nama_ayah ?? '-' }} (No. HP: {{ $user->no_hp_ayah ?? '-' }})</td></tr>
                        <tr><td>2. Nama Ibu</td><td>:</td><td>{{ $user->nama_ibu ?? '-' }} (No. HP: {{ $user->no_hp_ibu ?? '-' }})</td></tr>
                        <tr><td>3. Nama Wali</td><td>:</td><td>{{ $user->nama_wali ?? '-' }} (No. HP: {{ $user->no_hp_wali ?? '-' }})</td></tr>
                    </table>
                </div>

                <div class="print-signature">
                    <p>Telah diperiksa dan diverifikasi oleh,</p>
                    <p>Administrator Sistem</p>
                    <br><br><br>
                    <p><strong><u>{{ Auth::user()->name ?? 'Admin SMART-ECO' }}</u></strong></p>
                    <p>Tanggal: {{ date('d F Y') }}</p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
