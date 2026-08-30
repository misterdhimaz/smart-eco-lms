@extends('layouts.student')
@section('title', 'Kalkulator Jejak Karbon Presisi | SMART-ECO')

@section('content')
<div x-data="carbonCalculator()" x-init="initApp()" class="w-full pb-20 font-sans relative">

    <div class="mb-10 gsap-fade text-center max-w-3xl mx-auto">
        <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-emerald-500 to-blue-500 text-white px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            High Precision Calculator
        </span>
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-slate-800 tracking-tight mb-4">Kalkulator <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-blue-500">Karbon AI</span> 🌍</h1>
        <p class="text-sm text-slate-500 font-medium leading-relaxed">Masukkan angka akurat sesuai aktivitas Anda. Hasil dapat dikonversi ke berbagai skala waktu untuk melihat dampak jangka panjang.</p>
    </div>

    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200/80 shadow-sm relative overflow-hidden flex flex-col h-full gsap-card">
                <div class="flex items-center gap-4 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-2xl shadow-sm border border-amber-100 shrink-0">⚡</div>
                    <div>
                        <h3 class="text-base font-black text-slate-800 leading-none">Energi Rumah Tangga</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Data Bulanan</p>
                    </div>
                </div>

                <div class="space-y-6 flex-1">
                    <div>
                        <label class="text-xs font-bold text-slate-600 mb-2 block">Tagihan Listrik PLN</label>
                        <div class="relative">
                            <input type="number" x-model.number="listrikKwh" min="0" placeholder="0" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-4 pr-16 py-3 text-lg font-black text-amber-600 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kWh</span>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-600 mb-2 block">Pemakaian Gas LPG</label>
                        <div class="relative">
                            <input type="number" x-model.number="gasKg" min="0" placeholder="0" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-4 pr-16 py-3 text-lg font-black text-amber-600 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm font-bold text-slate-400">kg</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200/80 shadow-sm relative overflow-hidden flex flex-col h-full gsap-card">
                <div class="flex items-center gap-4 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-2xl shadow-sm border border-blue-100 shrink-0">🚗</div>
                    <div>
                        <h3 class="text-base font-black text-slate-800 leading-none">Mobilitas & Transportasi</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Data Mingguan</p>
                    </div>
                </div>

                <div class="space-y-4 flex-1">
                    <div>
                        <label class="text-xs font-bold text-slate-600 mb-2 block">Bensin Motor</label>
                        <div class="relative">
                            <input type="number" x-model.number="motorLiter" min="0" placeholder="0" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-4 pr-16 py-2.5 text-base font-black text-blue-600 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Liter</span>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-600 mb-2 block">Bensin Mobil</label>
                        <div class="relative">
                            <input type="number" x-model.number="mobilLiter" min="0" placeholder="0" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-4 pr-16 py-2.5 text-base font-black text-blue-600 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Liter</span>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-600 mb-2 block">Transportasi Umum</label>
                        <div class="relative">
                            <input type="number" x-model.number="publicKm" min="0" placeholder="0" class="w-full bg-slate-50 border-2 border-slate-200 rounded-xl pl-4 pr-16 py-2.5 text-base font-black text-blue-600 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">km</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200/80 shadow-sm relative overflow-hidden flex flex-col h-full gsap-card">
                <div class="flex items-center gap-4 mb-6 border-b border-slate-100 pb-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl shadow-sm border border-rose-100 shrink-0">🍔</div>
                    <div>
                        <h3 class="text-base font-black text-slate-800 leading-none">Konsumsi & Pola Makan</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Gaya Hidup</p>
                    </div>
                </div>

                <div class="flex-1 flex flex-col justify-start">
                    <label class="text-xs font-bold text-slate-600 mb-3 block">Pilih Pola Makan Dominan</label>
                    <div class="flex flex-col gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" x-model="diet" value="meat" class="peer hidden">
                            <div class="p-3 border-2 rounded-xl flex items-center gap-4 transition-all peer-checked:border-rose-500 peer-checked:bg-rose-50 hover:bg-slate-50">
                                <div class="text-2xl">🥩</div>
                                <div>
                                    <p class="text-xs font-black text-slate-700 uppercase tracking-wide">Karnivora</p>
                                    <p class="text-[9px] text-slate-500">Sering makan daging merah</p>
                                </div>
                                <div class="ml-auto opacity-0 peer-checked:opacity-100 text-rose-500 pr-2">✓</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" x-model="diet" value="balanced" class="peer hidden">
                            <div class="p-3 border-2 rounded-xl flex items-center gap-4 transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:bg-slate-50">
                                <div class="text-2xl">🍗</div>
                                <div>
                                    <p class="text-xs font-black text-slate-700 uppercase tracking-wide">Seimbang</p>
                                    <p class="text-[9px] text-slate-500">Daging putih & sayuran</p>
                                </div>
                                <div class="ml-auto opacity-0 peer-checked:opacity-100 text-emerald-500 pr-2">✓</div>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" x-model="diet" value="vegan" class="peer hidden">
                            <div class="p-3 border-2 rounded-xl flex items-center gap-4 transition-all peer-checked:border-teal-500 peer-checked:bg-teal-50 hover:bg-slate-50">
                                <div class="text-2xl">🥦</div>
                                <div>
                                    <p class="text-xs font-black text-slate-700 uppercase tracking-wide">Vegetarian</p>
                                    <p class="text-[9px] text-slate-500">Berbasis nabati murni</p>
                                </div>
                                <div class="ml-auto opacity-0 peer-checked:opacity-100 text-teal-500 pr-2">✓</div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

        </div>

        <div class="bg-[#0f172a] rounded-[2.5rem] p-8 md:p-10 text-white relative overflow-hidden shadow-2xl border border-slate-700 w-full mb-10 gsap-card">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e293b_1px,transparent_1px),linear-gradient(to_bottom,#1e293b_1px,transparent_1px)] bg-[size:1.5rem_1.5rem] opacity-20"></div>
            <div class="absolute top-[-50px] right-[-50px] w-[300px] h-[300px] bg-emerald-500/20 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">

                <div class="w-full md:w-5/12 text-center md:text-left md:border-r border-slate-700 md:pr-8">
                    <div class="flex bg-slate-800/80 p-1.5 rounded-xl border border-slate-700 mb-6 max-w-sm mx-auto md:mx-0">
                        <template x-for="(label, key) in {'daily':'Hari', 'weekly':'Minggu', 'monthly':'Bulan', 'yearly':'Tahun'}">
                            <button @click="timeframe = key"
                                    class="flex-1 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all"
                                    :class="timeframe === key ? 'bg-emerald-500 text-white shadow-md' : 'text-slate-400 hover:text-white'">
                                <span x-text="label"></span>
                            </button>
                        </template>
                    </div>

                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Estimasi Emisi</p>
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-1">
                        <span class="text-6xl lg:text-7xl font-black text-white tracking-tighter" x-text="scaledTotal.toLocaleString('id-ID', {minimumFractionDigits: 1, maximumFractionDigits: 1})">0.0</span>
                    </div>
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">kg CO₂e / <span x-text="timeframeLabel"></span></span>
                </div>

                <div class="w-full md:w-7/12 space-y-5">
                    <div>
                        <div class="flex justify-between items-end mb-2 text-[10px] font-black uppercase tracking-widest">
                            <span class="text-amber-400 flex items-center gap-2"><span class="w-2 h-2 bg-amber-400 rounded-full"></span> Energi Rumah</span>
                            <span class="text-slate-300"><span x-text="scaledEnergi.toFixed(1)"></span> kg</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 transition-all duration-500" :style="`width: ${Math.min((scaledEnergi / Math.max(scaledTotal, 1)) * 100, 100)}%`"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2 text-[10px] font-black uppercase tracking-widest">
                            <span class="text-blue-400 flex items-center gap-2"><span class="w-2 h-2 bg-blue-500 rounded-full"></span> Transportasi</span>
                            <span class="text-slate-300"><span x-text="scaledTransport.toFixed(1)"></span> kg</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-500 transition-all duration-500" :style="`width: ${Math.min((scaledTransport / Math.max(scaledTotal, 1)) * 100, 100)}%`"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2 text-[10px] font-black uppercase tracking-widest">
                            <span class="text-rose-400 flex items-center gap-2"><span class="w-2 h-2 bg-rose-500 rounded-full"></span> Pola Makan</span>
                            <span class="text-slate-300"><span x-text="scaledDiet.toFixed(1)"></span> kg</span>
                        </div>
                        <div class="w-full bg-slate-800 h-2.5 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500 transition-all duration-500" :style="`width: ${Math.min((scaledDiet / Math.max(scaledTotal, 1)) * 100, 100)}%`"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex justify-center mb-10 max-w-5xl mx-auto gsap-btn">
            <button @click="generateAIReport()" :disabled="isAnalyzing || totalEmisiBulanan === 0" class="w-full sm:w-2/3 lg:w-1/2 bg-white border border-slate-200 hover:border-emerald-400 rounded-3xl p-1.5 transition-all shadow-md hover:shadow-[0_10px_30px_rgba(16,185,129,0.2)] active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed group">
                <div class="bg-gradient-to-r from-emerald-500 via-teal-500 to-blue-500 bg-[length:200%_auto] hover:animate-[gradient_2s_ease_infinite] rounded-[1.4rem] flex items-center justify-center gap-3 py-4 text-white">
                    <svg x-show="!isAnalyzing" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <svg x-show="isAnalyzing" class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    <span class="font-black tracking-widest uppercase text-sm" x-text="isAnalyzing ? 'Sedang Memproses...' : 'Dapatkan Rekomendasi AI'"></span>
                </div>
            </button>
        </div>

        <div x-show="showAiResult" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" class="w-full">
            <div class="bg-white border-2 border-emerald-100 rounded-[2rem] p-8 md:p-10 relative overflow-hidden shadow-xl shadow-emerald-500/10">

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 border-b border-slate-100 pb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 text-white flex items-center justify-center shadow-md shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 text-xl leading-none mb-1">Laporan Cerdas AI</h3>
                            <p class="text-xs font-bold text-emerald-500 uppercase tracking-widest">SMART-ECO Analytics</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-5 py-3 rounded-2xl border border-slate-200 text-center shrink-0">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggung Jawab Karbon</p>
                        <p class="text-xl font-black text-emerald-600">Tanam <span x-text="Math.ceil(totalEmisiBulanan / 21)"></span> <span class="text-xs text-slate-500">Pohon/Bulan</span></p>
                    </div>
                </div>

                <div class="prose prose-slate prose-emerald max-w-none">
                    <div class="text-slate-700 leading-relaxed font-medium text-[15px]" x-html="aiText"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    /* Sembunyikan panah naik turun di input number untuk tampilan yang lebih bersih (Opsional) */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
@endsection

@push('scripts')
<script>
    function carbonCalculator() {
        return {
            listrikKwh: null,
            gasKg: null,
            motorLiter: null,
            mobilLiter: null,
            publicKm: null,
            diet: 'balanced',

            timeframe: 'monthly',

            isAnalyzing: false,
            showAiResult: false,
            aiText: '',

            // Konstanta GHG Protocol
            EF_LISTRIK: 0.87,
            EF_GAS: 3.0,
            EF_BBM: 2.3,
            EF_PUBLIC: 0.05,

            // --- PERHITUNGAN BULANAN ---
            get emisiEnergiBulanan() {
                return ((this.listrikKwh || 0) * this.EF_LISTRIK) + ((this.gasKg || 0) * this.EF_GAS);
            },

            get emisiTransportBulanan() {
                let motor = ((this.motorLiter || 0) * 4) * this.EF_BBM;
                let mobil = ((this.mobilLiter || 0) * 4) * this.EF_BBM;
                let publik = ((this.publicKm || 0) * 4) * this.EF_PUBLIC;
                return motor + mobil + publik;
            },

            get emisiDietBulanan() {
                if (this.diet === 'meat') return 120;
                if (this.diet === 'balanced') return 70;
                return 40;
            },

            get totalEmisiBulanan() {
                return this.emisiEnergiBulanan + this.emisiTransportBulanan + this.emisiDietBulanan;
            },

            // --- PENGALI SKALA WAKTU ---
            get scaleFactor() {
                if (this.timeframe === 'daily') return 1 / 30;
                if (this.timeframe === 'weekly') return 1 / 4;
                if (this.timeframe === 'yearly') return 12;
                return 1;
            },

            get timeframeLabel() {
                if (this.timeframe === 'daily') return 'Harian';
                if (this.timeframe === 'weekly') return 'Mingguan';
                if (this.timeframe === 'yearly') return 'Tahunan';
                return 'Bulanan';
            },

            get scaledEnergi() { return this.emisiEnergiBulanan * this.scaleFactor; },
            get scaledTransport() { return this.emisiTransportBulanan * this.scaleFactor; },
            get scaledDiet() { return this.emisiDietBulanan * this.scaleFactor; },
            get scaledTotal() { return this.totalEmisiBulanan * this.scaleFactor; },

            initApp() {
                gsap.from(".gsap-fade", { y: -20, opacity: 0, duration: 0.6, ease: "power2.out" });
                gsap.from(".gsap-card", { y: 30, opacity: 0, duration: 0.7, stagger: 0.15, ease: "power3.out", delay: 0.2 });
                gsap.from(".gsap-btn", { scale: 0.9, opacity: 0, duration: 0.6, ease: "back.out(1.7)", delay: 0.8 });
            },

            generateAIReport() {
                this.isAnalyzing = true;
                this.showAiResult = false;

                setTimeout(() => {
                    this.isAnalyzing = false;
                    this.showAiResult = true;
                    this.processAILogic();

                    setTimeout(() => {
                        window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                    }, 100);
                }, 1800);
            },

            processAILogic() {
                let total = this.totalEmisiBulanan;
                let energi = this.emisiEnergiBulanan;
                let transport = this.emisiTransportBulanan;
                let diet = this.emisiDietBulanan;
                let text = "";

                if (total <= 150) {
                    text += "<p class='mb-4'>🌟 <strong>Status: Sangat Rendah.</strong> Jejak karbon Anda di bawah rata-rata nasional. Teruskan kebiasaan baik ini!</p>";
                } else if (total <= 350) {
                    text += "<p class='mb-4'>📊 <strong>Status: Rata-rata.</strong> Emisi Anda berada di batas normal masyarakat urban Indonesia.</p>";
                } else {
                    text += "<p class='mb-4 text-rose-600'>⚠️ <strong>Status: Tinggi.</strong> Jejak karbon Anda terdeteksi melampaui batas normal. Perlu ada upaya mitigasi segera.</p>";
                }

                text += "<h4 class='text-emerald-700 font-black mt-6 mb-3 text-sm uppercase tracking-widest border-b border-emerald-100 pb-2'>Analisis Sektor Dominan</h4><ul class='space-y-4'>";

                let maxSector = Math.max(energi, transport, diet);

                if (maxSector === transport && transport > 0) {
                    text += "<li class='flex gap-3'><div class='text-2xl'>🚗</div><div>Penyumbang terbesar Anda adalah <strong>Transportasi Pribadi</strong> (" + transport.toFixed(1) + " kgCO₂e/bulan). <br><em class='text-slate-500 text-sm'>Rekomendasi AI:</em> Kurangi pemakaian kendaraan berbahan bakar bensin. Pertimbangkan opsi <em>carpooling</em> atau beralih gunakan transportasi umum secara bertahap.</div></li>";
                } else if (maxSector === energi && energi > 0) {
                    text += "<li class='flex gap-3'><div class='text-2xl'>⚡</div><div>Penyumbang terbesar Anda adalah <strong>Energi Rumah Tangga</strong> (" + energi.toFixed(1) + " kgCO₂e/bulan). <br><em class='text-slate-500 text-sm'>Rekomendasi AI:</em> Kurangi konsumsi daya dengan mengganti lampu ke tipe LED, memutus arus alat elektronik yang <em>standby</em>, dan mengatur AC pada suhu hemat (24-25°C).</div></li>";
                } else if (maxSector === diet) {
                    text += "<li class='flex gap-3'><div class='text-2xl'>🍔</div><div>Pola makan Anda menyumbang emisi terbesar (" + diet.toFixed(1) + " kgCO₂e/bulan). <br><em class='text-slate-500 text-sm'>Rekomendasi AI:</em> Sektor peternakan sapi dan ruminansia menyumbang gas metana tinggi. Cobalah program <em>Meatless Monday</em> untuk memangkas emisi diet Anda secara signifikan.</div></li>";
                }

                if ((this.publicKm || 0) > 50) {
                    text += "<li class='flex gap-3'><div class='text-2xl'>🚆</div><div><em class='text-blue-600 font-bold'>Apresiasi AI:</em> Hebat! Penggunaan transportasi umum Anda ("+this.publicKm+" km/mgg) patut diapresiasi. Ini tindakan luar biasa untuk mengurangi kemacetan dan emisi per kapita kota.</div></li>";
                }
                text += "</ul>";
                this.aiText = text;
            }
        }
    }
</script>
@endpush
