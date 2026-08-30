@extends('layouts.student')
@section('title', 'Peta Peringkat | SMART-ECO')

@section('content')
<div class="w-full max-w-5xl mx-auto pb-24 font-sans text-slate-800">

    <!-- HEADER -->
    <div class="relative bg-gradient-to-br from-slate-900 via-[#0f172a] to-emerald-950 rounded-[2.5rem] p-10 shadow-2xl border-4 border-emerald-900/50 mb-12 overflow-hidden text-center gsap-header">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/20 blur-[80px] rounded-full pointer-events-none"></div>

        <div class="relative z-10">
            <span class="inline-block bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest mb-4 shadow-sm">
                🏆 SISTEM PERINGKAT SMART-ECO
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-4 uppercase leading-tight drop-shadow-md">
                Jadilah <span class="text-emerald-400">Pahlawan Bumi!</span>
            </h1>
            <p class="text-slate-300 font-medium max-w-xl mx-auto text-sm leading-relaxed">
                Tingkatkan levelmu dengan menyelesaikan modul, menonton video, dan berlatih. Semakin tinggi levelmu, semakin prestisius gelar penyelamat bumi yang kamu sandang!
            </p>
        </div>
    </div>

    <!-- CURRENT PROGRESS -->
    <div class="bg-white rounded-3xl p-6 md:p-8 border-2 border-slate-200 shadow-sm mb-12 flex flex-col md:flex-row items-center gap-6 gsap-card">
        <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-4xl shadow-inner shrink-0">
            {{ explode(' ', $user->rank_name)[0] ?? '🌱' }}
        </div>
        <div class="flex-1 text-center md:text-left w-full">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">Pangkat Kamu Saat Ini</p>
            <h2 class="text-2xl font-black text-slate-800">{{ $user->rank_name ?? 'Eco Seedling' }} <span class="text-emerald-600">(Level {{ $user->level ?? 1 }})</span></h2>

            <div class="w-full bg-slate-100 rounded-full h-3 mt-4 overflow-hidden border border-slate-200">
                <!-- Logika persentase bar XP -->
                @php
                    $currentLvlXp = \App\Models\User::calculateXpForLevel($user->level ?? 1);
                    $nextLvlXp = \App\Models\User::calculateXpForLevel(($user->level ?? 1) + 1);
                    $xpGainedThisLevel = ($user->xp ?? 0) - $currentLvlXp;
                    $xpNeededForNext = $nextLvlXp - $currentLvlXp;
                    $percent = $xpNeededForNext > 0 ? ($xpGainedThisLevel / $xpNeededForNext) * 100 : 100;
                @endphp
                <div class="bg-gradient-to-r from-emerald-400 to-emerald-600 h-full rounded-full relative" style="width: {{ min(max($percent, 0), 100) }}%">
                    <div class="absolute inset-0 bg-white/30 animate-pulse"></div>
                </div>
            </div>
            <p class="text-[10px] font-bold text-slate-500 mt-2 text-right">Butuh {{ number_format($nextLvlXp - ($user->xp ?? 0)) }} XP lagi untuk Level {{ ($user->level ?? 1) + 1 }}</p>
        </div>
    </div>

    <!-- TIER LIST (10 Tahap) -->
    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-[3.25rem] before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-1 before:bg-gradient-to-b before:from-emerald-200 before:via-blue-200 before:to-amber-200">

        @php
            $tiers = [
                ['lv' => '1 - 9', 'name' => '🌱 Eco Seedling', 'desc' => 'Langkah pertamamu menyadari pentingnya menjaga lingkungan.', 'color' => 'emerald'],
                ['lv' => '10 - 19', 'name' => '🌿 Green Learner', 'desc' => 'Mulai memahami konsep dasar keberlanjutan dan jejak karbon.', 'color' => 'emerald'],
                ['lv' => '20 - 29', 'name' => '🌳 Earth Guardian', 'desc' => 'Tumbuh kuat! Kamu sudah terbiasa dengan gaya hidup rendah emisi.', 'color' => 'teal'],
                ['lv' => '30 - 39', 'name' => '⚡ Energy Saver', 'desc' => 'Pakar efisiensi energi. Kamu tahu fisika di balik panel surya.', 'color' => 'cyan'],
                ['lv' => '40 - 49', 'name' => '♻️ Recycling Master', 'desc' => 'Tidak ada yang terbuang sia-sia di tanganmu. Sirkular ekonomi sejati!', 'color' => 'blue'],
                ['lv' => '50 - 59', 'name' => '🌍 Climate Defender', 'desc' => 'Lebih dari sekadar peduli, kamu beraksi nyata untuk melindungi iklim.', 'color' => 'indigo'],
                ['lv' => '60 - 69', 'name' => '💡 Eco Innovator', 'desc' => 'Mampu menciptakan solusi STEM berbasis lingkungan.', 'color' => 'violet'],
                ['lv' => '70 - 79', 'name' => '🔬 Tech for Earth', 'desc' => 'Menggunakan komputasi dan AI untuk memecahkan masalah bumi.', 'color' => 'purple'],
                ['lv' => '80 - 89', 'name' => '🚀 Eco Visionary', 'desc' => 'Pandanganmu menjangkau masa depan yang 100% berkelanjutan.', 'color' => 'fuchsia'],
                ['lv' => '90 - 99', 'name' => '👑 Master of Sustainability', 'desc' => 'Kamu adalah panutan bagi pelajar lainnya dalam hal keberlanjutan.', 'color' => 'rose'],
                ['lv' => '100', 'name' => '🌟 SMART-ECO Legend', 'desc' => 'Pangkat Tertinggi. Sang Legenda Fisika dan Lingkungan!', 'color' => 'amber']
            ];
        @endphp

        @foreach($tiers as $index => $tier)
            <!-- Timeline Item -->
            <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active gsap-timeline">

                <!-- Marker -->
                <div class="flex items-center justify-center w-14 h-14 rounded-full border-4 border-white bg-{{ $tier['color'] }}-100 shadow-lg shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 relative z-10 group-hover:scale-110 transition-transform">
                    <span class="text-2xl">{{ explode(' ', $tier['name'])[0] }}</span>
                </div>

                <!-- Content Box -->
                <div class="w-[calc(100%-4rem)] md:w-[calc(50%-3rem)] bg-white p-6 rounded-2xl shadow-sm border-2 border-slate-100 hover:border-{{ $tier['color'] }}-400 hover:shadow-xl transition-all duration-300">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-black text-slate-800">{{ substr(strstr($tier['name'], ' '), 1) }}</h3>
                        <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-widest shrink-0 ml-2">LV {{ $tier['lv'] }}</span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">{{ $tier['desc'] }}</p>

                    @if($index < 10)
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <span>🎯 Butuh total ~{{ number_format(\App\Models\User::calculateXpForLevel(explode(' ', $tier['lv'])[0])) }} XP</span>
                    </div>
                    @else
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center gap-2 text-[10px] font-black text-amber-500 uppercase tracking-widest">
                        <span class="animate-pulse">🏆 THE ULTIMATE GOAL</span>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.from(".gsap-header", { y: -30, opacity: 0, duration: 0.8, ease: "power3.out" });
        gsap.from(".gsap-card", { scale: 0.95, opacity: 0, duration: 0.6, ease: "back.out(1.2)", delay: 0.2 });
        gsap.from(".gsap-timeline", {
            y: 30, opacity: 0, duration: 0.6, stagger: 0.15, ease: "power2.out", delay: 0.4
        });
    });
</script>
@endpush
