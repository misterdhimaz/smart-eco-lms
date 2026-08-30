@extends('layouts.student')
@section('title', 'Laboratorium Virtual | SMART-ECO')

@section('content')
<div x-data="labSimulator()" class="w-full pb-10 md:pb-20 font-sans">

    <!-- HALAMAN DEPAN: DAFTAR SIMULASI -->
    <div x-show="!activeSim" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="space-y-6 md:space-y-8">

        <div class="relative bg-gradient-to-br from-[#0B1120] via-slate-900 to-cyan-950 rounded-2xl md:rounded-[2.5rem] p-6 md:p-12 text-white overflow-hidden shadow-2xl border border-slate-800">
            <div class="absolute w-64 md:w-96 h-64 md:h-96 bg-cyan-500/20 rounded-full blur-[80px] md:blur-[100px] top-0 left-0 pointer-events-none"></div>

            <div class="relative z-10">
                <span class="inline-flex items-center gap-2 bg-cyan-500/20 text-cyan-400 px-3 py-1.5 md:px-3.5 md:py-1.5 rounded-full text-[9px] md:text-[11px] font-black uppercase tracking-widest mb-3 md:mb-4 border border-cyan-500/30">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span> Laboratorium Virtual 🧪
                </span>
                <h1 class="text-3xl md:text-5xl font-black tracking-tight mb-2 md:mb-4 leading-tight">Simulasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-emerald-300">Interaktif Bumi</span></h1>
                <p class="text-slate-300 text-xs md:text-base font-medium max-w-xl leading-relaxed">Uji coba secara virtual dampak aktivitas harian terhadap perubahan iklim melalui rekayasa laboratorium interaktif kami.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <template x-for="sim in simulations" :key="sim.id">
                <div @click="openSim(sim)" class="bg-white rounded-2xl md:rounded-[2rem] border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer overflow-hidden group flex flex-col">
                    <div class="h-40 md:h-48 relative overflow-hidden flex items-center justify-center shrink-0" :class="sim.bg_gradient">
                        <span class="absolute text-7xl md:text-8xl opacity-20 group-hover:scale-125 transition-transform duration-700" x-text="sim.icon_emoji"></span>
                        <span class="relative z-10 text-5xl md:text-6xl drop-shadow-lg group-hover:scale-110 transition-transform duration-500" x-text="sim.icon_emoji"></span>

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 to-transparent"></div>
                        <span class="absolute top-3 left-3 md:top-4 md:left-4 bg-white/90 backdrop-blur-md text-slate-800 px-2.5 py-1 md:px-3 md:py-1 rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-wider shadow-sm" x-text="sim.badge"></span>
                    </div>

                    <div class="p-5 md:p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base md:text-lg font-black text-slate-800 mb-1.5 md:mb-2 leading-tight group-hover:text-cyan-600 transition-colors line-clamp-2" x-text="sim.title"></h3>
                            <p class="text-[11px] md:text-xs text-slate-500 font-medium line-clamp-2 md:line-clamp-3 mb-4" x-text="sim.description"></p>
                        </div>

                        <div class="flex items-center justify-between pt-3 md:pt-4 border-t border-slate-100">
                            <div class="flex items-center gap-1.5 text-[9px] md:text-[10px] font-black uppercase tracking-widest" :class="sim.type === 'native_carbon' ? 'text-emerald-500' : 'text-cyan-500'">
                                <span x-text="sim.type === 'native_carbon' ? '⚙️ Native Engine' : '🔗 WebGL Embed'"></span>
                            </div>

                            <template x-if="sim.is_completed">
                                <span class="bg-emerald-100 text-emerald-600 px-2 py-1 rounded text-[8px] md:text-[9px] font-black uppercase flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Selesai
                                </span>
                            </template>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL SIMULASI AKTIF -->
    <div x-show="activeSim" x-cloak class="fixed inset-0 z-[100] bg-slate-950 flex flex-col h-[100dvh] w-screen overflow-hidden">

        <!-- HEADER MODAL -->
        <div class="h-14 md:h-16 bg-[#050B14] border-b border-slate-800 flex items-center justify-between px-3 md:px-6 shrink-0 z-20">
            <div class="flex items-center gap-2 md:gap-4 text-white truncate max-w-[70%]">
                <span class="hidden sm:inline px-2 py-1 bg-cyan-500/20 text-cyan-400 rounded text-[9px] md:text-[10px] font-black uppercase tracking-widest border border-cyan-500/30" x-text="activeSim?.badge"></span>
                <h2 class="font-black text-xs md:text-sm tracking-wide truncate" x-text="activeSim?.title"></h2>
            </div>
            <button @click="closeSim()" class="px-3 py-1.5 md:px-4 md:py-2 bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white rounded-lg md:rounded-xl text-[10px] md:text-xs font-black uppercase transition-colors flex items-center gap-1.5 shrink-0">
                <span class="hidden sm:inline">Tutup Lab</span> <span class="text-sm leading-none">✖</span>
            </button>
        </div>

        <!-- KONTEN MODAL -->
        <div class="flex-1 flex flex-col lg:flex-row p-2 md:p-4 gap-2 md:gap-4 min-h-0 relative z-10">

            <!-- PhET EMBED -->
            <template x-if="activeSim?.type === 'embed'">
                <div class="w-full h-full flex flex-col lg:flex-row gap-2 md:gap-4 flex-1">

                    <!-- IFRAME WRAPPER (Absolute Inset agar touch tidak nge-bug) -->
                    <div class="flex-1 relative bg-white rounded-xl md:rounded-[2rem] border-2 md:border-4 border-slate-800 shadow-2xl overflow-hidden min-h-[50vh] lg:min-h-0 flex flex-col">

                        <div x-show="isLoading" class="absolute inset-0 z-20 bg-slate-900 flex flex-col items-center justify-center text-white pointer-events-none">
                            <div class="w-10 h-10 border-4 border-cyan-500 border-t-transparent rounded-full animate-spin"></div>
                            <p class="text-[10px] font-black uppercase mt-4 text-cyan-400 animate-pulse tracking-widest">Menyiapkan Alat Lab...</p>
                        </div>

                        <iframe :src="activeSim?.embed_url"
                                class="absolute inset-0 w-full h-full border-0 z-10 bg-white"
                                allowfullscreen
                                scrolling="no"
                                @load="isLoading = false">
                        </iframe>
                    </div>

                    <!-- SIDEBAR PANDUAN LAB -->
                    <div class="h-[35vh] lg:h-full w-full lg:w-80 bg-slate-900 rounded-xl md:rounded-[2rem] border border-slate-800 p-4 md:p-6 flex flex-col shrink-0">
                        <div class="flex items-center gap-3 mb-4 pb-3 border-b border-slate-800 shrink-0">
                            <div class="w-10 h-10 bg-slate-800 rounded-xl flex items-center justify-center text-xl shrink-0" x-text="activeSim?.icon_emoji"></div>
                            <div>
                                <h2 class="text-[10px] md:text-xs font-black text-white uppercase tracking-widest">Lembar Panduan</h2>
                                <p class="text-[8px] md:text-[9px] font-bold text-slate-400" x-text="activeSim?.badge"></p>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-4 md:space-y-6">
                            <div>
                                <h4 class="text-[9px] md:text-[10px] font-black text-cyan-400 uppercase tracking-wider mb-1.5">📌 Tujuan</h4>
                                <p class="text-[10px] md:text-xs text-slate-300 leading-relaxed font-medium" x-text="activeSim?.objective"></p>
                            </div>

                            <div>
                                <h4 class="text-[9px] md:text-[10px] font-black text-emerald-400 uppercase tracking-wider mb-1.5">📋 Instruksi Kerja</h4>
                                <ul class="text-[10px] md:text-xs text-slate-300 space-y-2.5 font-medium">
                                    <template x-for="(step, index) in activeSim?.steps" :key="index">
                                        <li class="flex items-start gap-2">
                                            <span class="w-3.5 h-3.5 rounded-full bg-slate-800 text-slate-400 flex items-center justify-center shrink-0 text-[8px] font-bold mt-0.5" x-text="index + 1"></span>
                                            <span class="leading-relaxed" x-text="step"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>

                        <!-- WAKTU PRAKTIKUM -->
                        <div class="mt-4 pt-4 border-t border-slate-800 shrink-0">
                            <template x-if="!activeSim?.is_completed">
                                <div>
                                    <div class="flex justify-between items-center mb-1.5">
                                        <span class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest">Waktu Praktikum</span>
                                        <span class="text-[10px] md:text-xs font-black text-emerald-400" x-text="formatTime + ' / 02:00'"></span>
                                    </div>
                                    <div class="w-full bg-slate-800 h-1.5 md:h-2 rounded-full overflow-hidden shadow-inner">
                                        <div class="bg-gradient-to-r from-emerald-500 to-cyan-400 h-full rounded-full transition-all duration-1000" :style="'width: ' + progressPercent + '%'"></div>
                                    </div>
                                    <p class="text-[8px] font-bold text-slate-500 mt-2 text-center uppercase tracking-widest">Selesaikan 2 Menit = <span class="text-amber-400">+10 XP</span></p>
                                </div>
                            </template>

                            <template x-if="activeSim?.is_completed">
                                <div class="w-full py-2.5 rounded-lg bg-emerald-900/30 border border-emerald-500/30 text-emerald-400 text-[9px] font-black uppercase tracking-widest text-center flex items-center justify-center gap-1.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Selesai (+10 XP)
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </template>

            <!-- NATIVE CARBON KALKULATOR -->
            <template x-if="activeSim?.type === 'native_carbon'">
                <div class="w-full h-full flex flex-col lg:flex-row bg-white rounded-xl md:rounded-[2.5rem] shadow-2xl overflow-hidden border border-slate-200 relative">

                    <div class="flex-1 p-5 md:p-8 lg:p-12 bg-slate-50 border-b lg:border-b-0 lg:border-r border-slate-200 overflow-y-auto custom-scrollbar pb-24">
                        <h3 class="text-xl md:text-2xl font-black text-slate-800 mb-1.5">Carbon Footprint Simulator</h3>
                        <p class="text-[10px] md:text-sm text-slate-500 mb-6 md:mb-8 font-medium">Ubah variabel gaya hidup Anda di bawah ini dan lihat dampaknya terhadap emisi CO2 bumi secara instan.</p>

                        <div class="space-y-6 md:space-y-8">
                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <label class="text-[10px] md:text-xs font-black text-slate-700 uppercase tracking-widest">⚡ Listrik Bulanan</label>
                                    <span class="text-xs md:text-sm font-black text-amber-500" x-text="calc.electricity + ' kWh'"></span>
                                </div>
                                <input type="range" x-model="calc.electricity" min="50" max="1000" step="10" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-amber-500">
                            </div>

                            <div>
                                <div class="flex justify-between items-end mb-2">
                                    <label class="text-[10px] md:text-xs font-black text-slate-700 uppercase tracking-widest">🚗 Berkendara (Minggu)</label>
                                    <span class="text-xs md:text-sm font-black text-blue-500" x-text="calc.transport + ' KM'"></span>
                                </div>
                                <input type="range" x-model="calc.transport" min="0" max="500" step="5" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-blue-500">
                            </div>

                            <div>
                                <label class="text-[10px] md:text-xs font-black text-slate-700 uppercase tracking-widest block mb-2 md:mb-3">🥗 Pola Makan</label>
                                <div class="grid grid-cols-3 gap-2 md:gap-3">
                                    <button @click="calc.diet = 50" :class="calc.diet === 50 ? 'bg-emerald-500 text-white shadow-md' : 'bg-white border-slate-200 text-slate-500'" class="p-2.5 md:p-3 rounded-lg border text-[10px] md:text-xs font-black transition-all">Vegan</button>
                                    <button @click="calc.diet = 100" :class="calc.diet === 100 ? 'bg-amber-500 text-white shadow-md' : 'bg-white border-slate-200 text-slate-500'" class="p-2.5 md:p-3 rounded-lg border text-[10px] md:text-xs font-black transition-all">Campur</button>
                                    <button @click="calc.diet = 250" :class="calc.diet === 250 ? 'bg-rose-500 text-white shadow-md' : 'bg-white border-slate-200 text-slate-500'" class="p-2.5 md:p-3 rounded-lg border text-[10px] md:text-xs font-black transition-all">Daging</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 p-6 md:p-12 bg-slate-900 relative flex flex-col items-center justify-center text-center overflow-hidden min-h-[250px]">
                        <div class="absolute inset-0 transition-colors duration-700 opacity-20" :class="carbonStatusColor"></div>

                        <div class="relative z-10">
                            <p class="text-[9px] md:text-xs font-black text-slate-400 uppercase tracking-widest mb-2 md:mb-4">Total Jejak Karbon</p>
                            <div class="text-4xl md:text-6xl font-black text-white mb-1 md:mb-2 tracking-tighter">
                                <span x-text="totalCarbon"></span><span class="text-xl md:text-2xl text-slate-500 ml-1">kg</span>
                            </div>
                            <p class="text-[10px] md:text-sm font-medium text-slate-400 mb-6 md:mb-8">Setara Emisi CO2 per bulan</p>

                            <div class="relative w-24 h-24 md:w-48 md:h-48 mx-auto rounded-full shadow-2xl flex items-center justify-center transition-all duration-700 border-4 md:border-8" :class="carbonBorderColor">
                                <span class="text-4xl md:text-7xl transition-transform duration-300" :class="carbonScale" x-text="carbonEmoji"></span>
                            </div>

                            <p class="mt-6 md:mt-8 text-[9px] md:text-sm font-bold text-white max-w-xs mx-auto px-3 py-1.5 md:px-4 md:py-2 rounded-xl border" :class="carbonStatusTextClass" x-text="carbonMessage"></p>
                        </div>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full lg:w-1/2 p-4 md:p-6 bg-white/95 backdrop-blur-md border-t border-slate-200 z-20">
                        <template x-if="!activeSim?.is_completed">
                            <div>
                                <div class="flex justify-between items-center mb-1.5 md:mb-2">
                                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Waktu Eksplorasi</span>
                                    <span class="text-[10px] md:text-xs font-black text-emerald-500" x-text="formatTime + ' / 02:00'"></span>
                                </div>
                                <div class="w-full bg-slate-200 h-1.5 md:h-2 rounded-full overflow-hidden shadow-inner">
                                    <div class="bg-gradient-to-r from-emerald-500 to-cyan-400 h-full rounded-full transition-all duration-1000" :style="'width: ' + progressPercent + '%'"></div>
                                </div>
                            </div>
                        </template>
                        <template x-if="activeSim?.is_completed">
                            <div class="w-full py-2 md:py-2.5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-600 text-[9px] md:text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5">
                                <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Praktikum Selesai (+10 XP)
                            </div>
                        </template>
                    </div>

                </div>
            </template>

        </div>
    </div>
</div>

<style>
    input[type=range]::-webkit-slider-thumb { appearance: none; width: 16px; height: 16px; border-radius: 50%; background: currentColor; cursor: pointer; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.2); }
    @media (min-width: 768px) { input[type=range]::-webkit-slider-thumb { width: 20px; height: 20px; } }
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #475569; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function labSimulator() {
        return {
            isLoading: false,
            simulations: [
                {
                    id: 1, type: "embed", time_spent: 0, is_completed: false,
                    title: "Efek Rumah Kaca & Atmosfer", badge: "🌍 Iklim & Atmosfer",
                    description: "Simulasikan interaksi molekul gas rumah kaca (CO2, CH4) terhadap radiasi matahari dan inframerah bumi.",
                    embed_url: "https://phet.colorado.edu/sims/html/greenhouse-effect/latest/greenhouse-effect_all.html",
                    icon_emoji: "🌍", bg_gradient: "bg-gradient-to-br from-blue-500 to-cyan-600",
                    objective: "Memahami bagaimana peningkatan konsentrasi gas rumah kaca mempengaruhi suhu permukaan bumi secara langsung.",
                    steps: [
                        "Klik menu 'Greenhouse Effect'.",
                        "Amati perbedaan arah pergerakan partikel sinar kuning (Matahari) dan merah (Inframerah bumi).",
                        "Ubah slider 'Greenhouse Gas Concentration' dari Ice Age ke Today.",
                        "Perhatikan dan catat angka di Thermometer saat konsentrasi gas ditambah."
                    ]
                },
                {
                    id: 2, type: "embed", time_spent: 0, is_completed: false,
                    title: "Bentuk & Konversi Energi", badge: "🔥 Termodinamika",
                    description: "Eksplorasi hukum kekekalan energi. Rangkai sistem mekanik, termal, air, hingga surya menjadi energi listrik dan gerak.",
                    embed_url: "https://phet.colorado.edu/sims/html/energy-forms-and-changes/latest/energy-forms-and-changes_all.html",
                    icon_emoji: "⚡", bg_gradient: "bg-gradient-to-br from-amber-500 to-orange-600",
                    objective: "Menganalisis proses perubahan (transformasi) energi dari energi mekanik/panas lingkungan menjadi energi listrik.",
                    steps: [
                        "Buka tab 'Systems' (Sistem).",
                        "Centang kotak 'Energy Symbols' di pojok kanan atas.",
                        "Ganti sumber tenaga dari sepeda menjadi keran air atau matahari.",
                        "Ganti perangkat penerima listrik menjadi pemanas air atau lampu."
                    ]
                },
                {
                    id: 3, type: "embed", time_spent: 0, is_completed: false,
                    title: "Interferensi Gelombang", badge: "🌊 Dinamika Gelombang",
                    description: "Eksplorasi bagaimana gelombang air, suara, dan cahaya berinteraksi satu sama lain dalam suatu medium.",
                    embed_url: "https://phet.colorado.edu/sims/html/wave-interference/latest/wave-interference_all.html",
                    icon_emoji: "🌊", bg_gradient: "bg-gradient-to-br from-indigo-500 to-blue-800",
                    objective: "Menganalisis prinsip superposisi dan pola interferensi (konstruktif/destruktif) pada berbagai jenis gelombang.",
                    steps: [
                        "Pilih jenis gelombang (Air, Suara, atau Cahaya).",
                        "Aktifkan dua sumber gelombang (Two Drips/Speakers/Lights).",
                        "Ubah nilai Frekuensi dan Amplitudo.",
                        "Amati pola garis terang-gelap yang terbentuk."
                    ]
                },
                {
                    id: 4, type: "embed", time_spent: 0, is_completed: false,
                    title: "Polusi Suara & Gelombang Bunyi", badge: "🔊 Kebisingan Lingkungan",
                    description: "Visualisasikan bagaimana gelombang suara merambat di udara, memantul, dan mengubah tekanan di sekitar pendengar.",
                    embed_url: "https://phet.colorado.edu/sims/html/sound-waves/latest/sound-waves_all.html",
                    icon_emoji: "🔊", bg_gradient: "bg-gradient-to-br from-slate-700 to-slate-900",
                    objective: "Memahami hubungan antara frekuensi, amplitudo, dan rambatan tekanan suara untuk menganalisis tingkat kebisingan.",
                    steps: [
                        "Buka tab 'Measure' (Pengukuran).",
                        "Tarik alat pengukur (Meter) ke area rambatan suara.",
                        "Nyalakan speaker dan amati pergerakan partikel udara.",
                        "Mainkan frekuensi tinggi vs rendah."
                    ]
                },
                {
                    id: 5, type: "embed", time_spent: 0, is_completed: false,
                    title: "Reaktor Fisi Nuklir (PLTN)", badge: "☢️ Energi Nuklir",
                    description: "Simulasikan reaksi berantai inti Uranium-235 di dalam Pembangkit Listrik Tenaga Nuklir dan lihat dampaknya.",
                    embed_url: "https://phet.colorado.edu/sims/cheerpj/nuclear-physics/latest/nuclear-physics.html?simulation=nuclear-fission",
                    icon_emoji: "☢️", bg_gradient: "bg-gradient-to-br from-yellow-500 to-red-600",
                    objective: "Mempelajari mekanisme reaksi fisi berantai pada energi nuklir dan kontrol suhu di dalam reaktor PLTN.",
                    steps: [
                        "Buka tab 'Chain Reaction' (Reaksi Berantai).",
                        "Tembakkan neutron menggunakan pistol ke arah inti Uranium-235.",
                        "Amati apa yang terjadi pada inti atom dan energi yang dilepaskan.",
                        "Pindah ke tab 'Nuclear Reactor', naikkan Control Rods perlahan."
                    ]
                },
                {
                    id: 6, type: "embed", time_spent: 0, is_completed: false,
                    title: "Pencemaran Air & Udara (Difusi)", badge: "🌫️ Polusi & Lingkungan",
                    description: "Amati bagaimana polutan gas atau cair menyebar ke udara/air dari wilayah padat ke wilayah kosong secara mikroskopis.",
                    embed_url: "https://phet.colorado.edu/sims/html/diffusion/latest/diffusion_en.html",
                    icon_emoji: "🦠", bg_gradient: "bg-gradient-to-br from-purple-500 to-indigo-600",
                    objective: "Menganalisis laju penyebaran (difusi) partikel polutan berdasarkan konsentrasi, massa, dan suhu lingkungan.",
                    steps: [
                        "Masukkan sejumlah partikel biru (polutan) ke satu sisi ruangan.",
                        "Klik tombol 'Remove Divider' untuk menghilangkan pembatas.",
                        "Amati seberapa cepat partikel menyebar ke seluruh ruang.",
                        "Naikkan suhu (Temperature) partikel dan lihat perubahannya."
                    ]
                },
                {
                    id: 7, type: "embed", time_spent: 0, is_completed: false,
                    title: "Radiasi & Spektrum Benda Hitam", badge: "☀️ Fisika Termal",
                    description: "Analisis pancaran radiasi matahari, lampu pijar, hingga bumi berdasarkan spektrum warna dan suhu mutlaknya.",
                    embed_url: "https://phet.colorado.edu/sims/html/blackbody-spectrum/latest/blackbody-spectrum_en.html",
                    icon_emoji: "☀️", bg_gradient: "bg-gradient-to-br from-orange-400 to-red-600",
                    objective: "Memahami hubungan antara suhu suatu benda dengan intensitas dan spektrum warna radiasi yang dipancarkannya.",
                    steps: [
                        "Perhatikan bentuk kurva spektrum saat suhu disetel ke 'Sun' (Matahari).",
                        "Centang opsi 'Graph Values' dan 'Labels'.",
                        "Geser tuas suhu ke bawah (ke arah 'Earth') atau ke atas.",
                        "Amati pergeseran puncak kurva warna dari UV ke Inframerah."
                    ]
                },
                {
                    id: 8, type: "native_carbon", time_spent: 0, is_completed: false,
                    title: "Kalkulator Jejak Karbon", badge: "🌱 Ekologi & Gaya Hidup",
                    description: "Uji coba secara virtual dampak pilihan transportasi, listrik, dan makanan harian Anda terhadap emisi karbon bumi.",
                    icon_emoji: "🌱", bg_gradient: "bg-gradient-to-br from-emerald-500 to-teal-700",
                }
            ],

            activeSim: null,
            timerInterval: null,
            requiredSeconds: 120, // 2 Menit

            // Variabel Kalkulator Karbon
            calc: { electricity: 200, transport: 50, diet: 100 },

            openSim(sim) {
                this.activeSim = sim;
                this.isLoading = true;
                this.startTimer();
                document.body.style.overflow = 'hidden';
            },
            closeSim() {
                this.stopTimer();
                this.activeSim = null;
                document.body.style.overflow = '';
            },

            startTimer() {
                this.stopTimer();
                this.timerInterval = setInterval(() => {
                    if (this.activeSim && !this.activeSim.is_completed) {
                        if (typeof this.activeSim.time_spent === 'undefined') {
                            this.activeSim.time_spent = 0;
                        }
                        this.activeSim.time_spent++;
                        if (this.activeSim.time_spent >= this.requiredSeconds) {
                            this.autoClaimXP(this.activeSim);
                        }
                    }
                }, 1000);
            },

            stopTimer() {
                if (this.timerInterval) {
                    clearInterval(this.timerInterval);
                    this.timerInterval = null;
                }
            },

            autoClaimXP(sim) {
                if (sim.is_completed) return;
                this.stopTimer();

                fetch("{{ route('student.claim_xp') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ xp_amount: 10, description: 'Menyelesaikan Simulasi: ' + sim.title, type: 'simulasi' })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        sim.is_completed = true;
                        if(data.level_up) {
                            Swal.fire({ title: 'LEVEL UP! 🎉', text: 'Level ' + data.new_level + ' Tercapai! (+10 XP)', icon: 'success', confirmButtonColor: '#10b981', customClass: { popup: 'rounded-[2rem]' } });
                        } else {
                            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Praktikum Selesai! +10 XP 🚀', showConfirmButton: false, timer: 4000 });
                        }
                    }
                });
            },

            get formatTime() {
                if (!this.activeSim) return "00:00";
                let t = this.activeSim.time_spent || 0;
                let m = Math.floor(t / 60).toString().padStart(2, '0');
                let s = (t % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            },

            get progressPercent() {
                if (!this.activeSim) return 0;
                let t = this.activeSim.time_spent || 0;
                let p = (t / this.requiredSeconds) * 100;
                return p > 100 ? 100 : p;
            },

            get totalCarbon() {
                let el = parseInt(this.calc.electricity) * 0.85;
                let tr = parseInt(this.calc.transport) * 0.8;
                let dt = parseInt(this.calc.diet);
                return Math.round(el + tr + dt);
            },
            get carbonLevel() {
                let t = this.totalCarbon;
                if(t < 300) return 'low';
                if(t < 700) return 'medium';
                return 'high';
            },
            get carbonStatusColor() {
                if(this.carbonLevel === 'low') return 'bg-emerald-500';
                if(this.carbonLevel === 'medium') return 'bg-amber-500';
                return 'bg-rose-600';
            },
            get carbonBorderColor() {
                if(this.carbonLevel === 'low') return 'border-emerald-500 shadow-emerald-500/50';
                if(this.carbonLevel === 'medium') return 'border-amber-500 shadow-amber-500/50';
                return 'border-rose-500 shadow-rose-500/50';
            },
            get carbonEmoji() {
                if(this.carbonLevel === 'low') return '🌍';
                if(this.carbonLevel === 'medium') return '🌤️';
                return '🔥';
            },
            get carbonScale() {
                if(this.carbonLevel === 'low') return 'scale-100';
                if(this.carbonLevel === 'medium') return 'scale-110';
                return 'scale-125 animate-bounce';
            },
            get carbonMessage() {
                if(this.carbonLevel === 'low') return 'Luar biasa! Gaya hidup Anda sangat ramah lingkungan.';
                if(this.carbonLevel === 'medium') return 'Cukup baik, tapi masih bisa dikurangi lagi!';
                return 'WASPADA! Jejak karbon Anda terlalu tinggi, bumi dalam bahaya.';
            },
            get carbonStatusTextClass() {
                if(this.carbonLevel === 'low') return 'bg-emerald-500/20 text-emerald-400 border-emerald-500/30';
                if(this.carbonLevel === 'medium') return 'bg-amber-500/20 text-amber-400 border-amber-500/30';
                return 'bg-rose-500/20 text-rose-400 border-rose-500/30';
            }
        };
    }
</script>
@endpush
