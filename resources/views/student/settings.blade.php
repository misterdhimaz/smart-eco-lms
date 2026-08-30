@extends('layouts.student')
@section('title', 'Pengaturan Profil Akademik | SMART-ECO')

@section('content')
<div class="max-w-6xl mx-auto pb-10 md:pb-20 font-sans text-slate-800 relative"
     x-data="{
        tab: 'data_diri',
        photoPreview: null,
        photoName: null,
        updatePreview(event) {
            const file = event.target.files[0];
            if (file) {
                this.photoName = file.name;
                const reader = new FileReader();
                reader.onload = (e) => { this.photoPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        }
     }">

    <!-- BACKGROUND EFEK (Aman untuk Layar Lebar) -->
    <div class="absolute top-12 left-0 md:left-10 w-64 md:w-96 h-64 md:h-96 bg-emerald-400/10 rounded-full blur-[80px] md:blur-[120px] pointer-events-none animate-pulse"></div>
    <div class="absolute top-80 right-0 md:right-10 w-64 md:w-96 h-64 md:h-96 bg-cyan-400/10 rounded-full blur-[80px] md:blur-[120px] pointer-events-none animate-pulse" style="animation-delay: 1s;"></div>

    @if(session('success'))
        <div class="relative z-20 bg-emerald-50 border border-emerald-200 text-emerald-900 px-5 md:px-6 py-4 rounded-xl md:rounded-2xl text-xs md:text-sm font-black mb-6 md:mb-8 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-emerald-500 text-white rounded-lg md:rounded-xl flex items-center justify-center shrink-0 shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <p class="font-black text-emerald-800">Pembaruan Berhasil!</p>
                    <p class="text-[10px] md:text-xs font-medium text-emerald-600">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('student.settings.update') }}" method="POST" enctype="multipart/form-data" class="relative z-10">
        @csrf
        @method('PUT')

        <input type="file" x-ref="avatarInput" name="avatar" class="hidden" accept="image/*" @change="updatePreview">

        <!-- HEADER PROFIL (Hero Section) -->
        <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-md border border-slate-200 overflow-hidden mb-6 md:mb-8 p-3 md:p-6">
            <div class="relative rounded-xl md:rounded-[1.5rem] bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 p-6 sm:p-8 text-white overflow-hidden shadow-inner flex flex-col sm:flex-row gap-6 md:gap-8 items-center sm:items-start text-center sm:text-left">

                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cube.png')] pointer-events-none"></div>
                <div class="absolute -right-20 -top-20 w-64 md:w-80 h-64 md:h-80 bg-emerald-400/20 blur-[80px] md:blur-[90px] rounded-full pointer-events-none"></div>

                <div class="relative group cursor-pointer shrink-0" @click="$refs.avatarInput.click()">
                    <div class="w-28 h-28 md:w-36 md:h-36 rounded-2xl md:rounded-[2rem] border-4 border-white shadow-2xl bg-slate-800 overflow-hidden relative transition-transform duration-300 group-hover:scale-105">

                        <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                        <template x-if="!photoPreview">
                            <div class="w-full h-full">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-emerald-400 text-5xl md:text-6xl font-black">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
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
                        <span class="absolute -top-2 -right-2 bg-emerald-500 text-white text-[9px] md:text-[10px] font-black px-2 md:px-3 py-1 rounded-full border-2 border-white shadow-md flex items-center gap-1">
                            <span class="w-1.5 md:w-2 h-1.5 md:h-2 rounded-full bg-white animate-ping"></span> Baru
                        </span>
                    </template>
                </div>

                <div class="flex-1 mt-2 z-10 w-full">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/20 text-emerald-300 text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-2 md:mb-3">
                        <span class="w-1.5 md:w-2 h-1.5 md:h-2 rounded-full bg-emerald-400"></span> MAHASISWA AKTIF
                    </span>
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-black tracking-tight text-white uppercase drop-shadow-sm mb-3 line-clamp-2">{{ Auth::user()->name }}</h1>

                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 md:gap-3 text-[10px] md:text-xs font-bold text-slate-200">
                        <span class="bg-slate-900/50 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg border border-white/10">🎓 {{ Auth::user()->prodi ?? 'Prodi Belum Diatur' }}</span>
                        <span class="bg-slate-900/50 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg border border-white/10">🆔 NIM: {{ Auth::user()->nim ?? 'Belum Diisi' }}</span>
                        <span class="bg-slate-900/50 px-2.5 md:px-3 py-1 md:py-1.5 rounded-lg border border-white/10 hidden md:inline">🏫 {{ Auth::user()->universitas ?? 'Universitas Belum Diatur' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABS NAVIGASI (Horizontal Scroll di Mobile) -->
        <div class="mb-6 md:mb-8 w-full overflow-hidden bg-white rounded-xl md:rounded-2xl border border-slate-200 p-2 md:p-3 shadow-sm">
            <div class="flex gap-2 overflow-x-auto custom-scrollbar-x pb-2 snap-x">
                @php
                    $tabs = [
                        ['key' => 'data_diri', 'label' => 'Biodata Diri', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                        ['key' => 'akademik', 'label' => 'Akademik', 'icon' => 'M12 14l9-5-9-5-9 5 9 5z'],
                        ['key' => 'alamat', 'label' => 'Alamat Domisili', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                        ['key' => 'keluarga', 'label' => 'Data Keluarga', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z'],
                        ['key' => 'riwayat', 'label' => 'Riwayat & PT Asal', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                    ];
                @endphp

                @foreach($tabs as $t)
                    <button type="button" @click="tab = '{{ $t['key'] }}'"
                            :class="tab === '{{ $t['key'] }}' ? 'bg-[#047857] text-white shadow-md border-emerald-600' : 'bg-slate-50 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 border-slate-200'"
                            class="flex items-center justify-center gap-2 md:gap-3 px-4 py-2.5 md:px-5 md:py-3 rounded-lg md:rounded-xl border transition-all shrink-0 font-black text-[10px] md:text-xs uppercase tracking-widest snap-start whitespace-nowrap">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="{{ $t['icon'] }}"></path></svg>
                        <span>{{ $t['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- AREA FORM KONTEN -->
        <div class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm border border-slate-200 p-5 md:p-8 lg:p-10 relative overflow-hidden">

            <!-- 1. TAB DATA DIRI -->
            <div x-show="tab === 'data_diri'" x-transition.opacity x-cloak class="space-y-6 md:space-y-8">

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                    <h3 class="text-sm md:text-base font-black text-slate-800 uppercase border-b border-slate-200 pb-3 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-xs">1</span> Biodata Pribadi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Lengkap (Sesuai Ijazah)</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">NIK (KTP)</label>
                            <input type="text" name="nik" value="{{ old('nik', Auth::user()->nik) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">NPWP (Opsional)</label>
                            <input type="text" name="npwp" value="{{ old('npwp', Auth::user()->npwp) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', Auth::user()->tempat_lahir) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', Auth::user()->tanggal_lahir) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Agama</label>
                            <input type="text" name="agama" value="{{ old('agama', Auth::user()->agama) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Kewarganegaraan</label>
                            <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan', Auth::user()->kewarganegaraan ?? 'Indonesia') }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Jenis Kelamin</label>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <label class="flex-1 flex items-center gap-3 cursor-pointer bg-white px-5 py-3.5 rounded-xl border-2 border-slate-200 hover:border-emerald-500 text-xs md:text-sm font-bold text-slate-700 transition-colors">
                                    <input type="radio" name="jenis_kelamin" value="Laki-Laki" {{ Auth::user()->jenis_kelamin == 'Laki-Laki' || Auth::user()->jenis_kelamin == 'L' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600"> 👨 Laki-Laki
                                </label>
                                <label class="flex-1 flex items-center gap-3 cursor-pointer bg-white px-5 py-3.5 rounded-xl border-2 border-slate-200 hover:border-emerald-500 text-xs md:text-sm font-bold text-slate-700 transition-colors">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan" {{ Auth::user()->jenis_kelamin == 'Perempuan' || Auth::user()->jenis_kelamin == 'P' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600"> 👩 Perempuan
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                    <h3 class="text-sm md:text-base font-black text-slate-800 uppercase border-b border-slate-200 pb-3 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-xs">2</span> Kontak & Akun
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Email (Akun Login)</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled class="w-full px-4 py-3 bg-slate-200 border-2 border-slate-300 rounded-xl text-xs md:text-sm font-bold text-slate-500 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">No. HP / WhatsApp Active</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp) }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. TAB AKADEMIK -->
            <div x-show="tab === 'akademik'" x-transition.opacity x-cloak class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                <h3 class="text-sm md:text-base font-black text-slate-800 uppercase border-b border-slate-200 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-xs">🎓</span> Informasi Akademik
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Perguruan Tinggi / Kampus</label>
                        <input type="text" name="universitas" value="{{ old('universitas', Auth::user()->universitas) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Program Studi</label>
                        <input type="text" name="prodi" value="{{ old('prodi', Auth::user()->prodi) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Nomor Induk Mahasiswa (NIM)</label>
                        <input type="text" name="nim" value="{{ old('nim', Auth::user()->nim) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Kelas / Rombel Asal</label>
                        <input type="text" name="kelas" value="{{ old('kelas', Auth::user()->kelas) }}" placeholder="Contoh: Indralaya A" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Dosen Pembimbing Akademik</label>
                        <input type="text" name="dosen_pa" value="{{ old('dosen_pa', Auth::user()->dosen_pa) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Tahun Angkatan</label>
                        <input type="text" name="angkatan" value="{{ old('angkatan', Auth::user()->angkatan) }}" placeholder="Contoh: 2021" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Jalur Pendaftaran</label>
                        <input type="text" name="jalur_pendaftaran" value="{{ old('jalur_pendaftaran', Auth::user()->jalur_pendaftaran) }}" placeholder="SNMPTN / SBMPTN / Mandiri" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Golongan UKT</label>
                        <input type="text" name="ukt" value="{{ old('ukt', Auth::user()->ukt) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 3. TAB ALAMAT -->
            <div x-show="tab === 'alamat'" x-transition.opacity x-cloak class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                <h3 class="text-sm md:text-base font-black text-slate-800 uppercase border-b border-slate-200 pb-3 mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-xs">🏡</span> Alamat Domisili Asal
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Jalan / Nama Perumahan</label>
                        <input type="text" name="jalan" value="{{ old('jalan', Auth::user()->jalan) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Dusun / RT / RW</label>
                        <input type="text" name="dusun" value="{{ old('dusun', Auth::user()->dusun) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Kelurahan / Desa</label>
                        <input type="text" name="kelurahan" value="{{ old('kelurahan', Auth::user()->kelurahan) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Kecamatan</label>
                        <input type="text" name="kecamatan" value="{{ old('kecamatan', Auth::user()->kecamatan) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Kabupaten / Kota</label>
                        <input type="text" name="kab_kota" value="{{ old('kab_kota', Auth::user()->kab_kota) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Provinsi</label>
                        <input type="text" name="provinsi" value="{{ old('provinsi', Auth::user()->provinsi) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Kode Pos</label>
                        <input type="text" name="kode_pos" value="{{ old('kode_pos', Auth::user()->kode_pos) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- 4. TAB KELUARGA (Orang Tua & Wali) -->
            <div x-show="tab === 'keluarga'" x-transition.opacity x-cloak class="space-y-6">

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                    <h3 class="text-sm md:text-base font-black text-slate-800 uppercase border-b border-slate-200 pb-3 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-xs">👨‍👩‍👦</span> Data Orang Tua
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-8">
                        <div class="space-y-4">
                            <h4 class="text-xs font-black uppercase text-emerald-700 tracking-wider">Biodata Ayah</h4>
                            <div>
                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Ayah</label>
                                <input type="text" name="nama_ayah" value="{{ old('nama_ayah', Auth::user()->nama_ayah) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">No. HP Ayah</label>
                                <input type="text" name="no_hp_ayah" value="{{ old('no_hp_ayah', Auth::user()->no_hp_ayah) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h4 class="text-xs font-black uppercase text-emerald-700 tracking-wider">Biodata Ibu</h4>
                            <div>
                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Ibu</label>
                                <input type="text" name="nama_ibu" value="{{ old('nama_ibu', Auth::user()->nama_ibu) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">No. HP Ibu</label>
                                <input type="text" name="no_hp_ibu" value="{{ old('no_hp_ibu', Auth::user()->no_hp_ibu) }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bagian Wali (Jika Ada) -->
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                    <h3 class="text-sm md:text-base font-black text-slate-800 uppercase border-b border-slate-200 pb-3 mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded bg-emerald-600 text-white flex items-center justify-center text-xs">🛡️</span> Data Wali (Opsional)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Nama Wali</label>
                            <input type="text" name="nama_wali" value="{{ old('nama_wali', Auth::user()->nama_wali ?? '') }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">No. HP Wali</label>
                            <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali', Auth::user()->no_hp_wali ?? '') }}" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. TAB RIWAYAT PENDIDIKAN & PT ASAL -->
            <div x-show="tab === 'riwayat'" x-transition.opacity x-cloak class="bg-slate-50 border border-slate-200 rounded-2xl p-5 md:p-8">
                <div class="text-center mb-6">
                    <span class="text-4xl">🎓</span>
                    <h3 class="text-sm md:text-base font-black text-slate-800 uppercase tracking-wide mt-3">Riwayat Pendidikan Sebelumnya</h3>
                    <p class="text-[10px] md:text-xs text-slate-500 font-bold max-w-lg mx-auto mt-1">Data asal SMA/SMK atau Perguruan Tinggi Asal (Jika Anda mahasiswa pindahan/transfer).</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6 max-w-3xl mx-auto">
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Perguruan Tinggi Asal / Sekolah Asal</label>
                        <input type="text" name="pt_asal" value="{{ old('pt_asal', Auth::user()->pt_asal) }}" placeholder="Contoh: SMA Negeri 1 Palembang" class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] md:text-xs font-black text-slate-600 uppercase tracking-widest mb-1.5">Tahun Lulus Pendidikan Terakhir</label>
                        <input type="text" name="riwayat_pendidikan_terakhir" value="{{ old('riwayat_pendidikan_terakhir', Auth::user()->riwayat_pendidikan_terakhir) }}" placeholder="Tahun kelulusan..." class="w-full px-4 py-3 bg-white border-2 border-slate-200 rounded-xl text-xs md:text-sm font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- TOMBOL SIMPAN GLOBAL -->
            <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[10px] md:text-[11px] font-black text-slate-400 uppercase tracking-wider hidden sm:block">* Pastikan seluruh isian valid sebelum menyimpan.</p>
                <button type="submit" class="w-full sm:w-auto px-8 py-3.5 md:px-10 md:py-4 bg-[#047857] hover:bg-[#065f46] text-white font-black rounded-xl md:rounded-2xl text-[11px] md:text-xs uppercase tracking-widest transition-all active:scale-95 shadow-xl shadow-emerald-700/20 flex items-center justify-center gap-2.5">
                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>

<style>
    [x-cloak] { display: none !important; }
    .custom-scrollbar-x::-webkit-scrollbar { height: 4px; }
    .custom-scrollbar-x::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar-x::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endsection
