@extends('layouts.student')
@section('title', 'Modul Pembelajaran | SMART-ECO')

@section('content')
<div x-data="modulePage()" x-init="initPage()" class="w-full pb-10">

    <!-- Header Banner -->
    <div class="bg-gradient-to-br from-[#0f172a] to-[#1e3a8a] rounded-[2.5rem] p-6 md:p-8 text-white relative overflow-hidden shadow-xl mb-8 border-4 border-white/5 gsap-fade">
        <div class="absolute right-0 top-0 bottom-0 w-1/2 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 pointer-events-none"></div>
        <div class="absolute right-10 bottom-[-50px] w-48 h-48 bg-emerald-500/20 blur-[60px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="max-w-xl">
                <span class="bg-[#10b981]/20 text-emerald-400 border border-[#10b981]/30 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-3 inline-block">Pusat Kurikulum Berurutan</span>
                <h2 class="text-3xl md:text-4xl font-black mb-3 tracking-tight">Modul & <span class="text-emerald-400">Materi Pembelajaran</span> 📚</h2>
                <p class="text-xs md:text-sm text-slate-300 leading-relaxed font-medium">Pelajari materi secara bertahap. Anda harus membaca materi dan <b>Lulus Kuis Evaluasi</b> di modul sebelumnya untuk membuka gembok modul selanjutnya!</p>
            </div>

            <div class="flex items-center gap-5 bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-3xl shrink-0 group hover:bg-white/15 transition-all shadow-inner">
                <div class="relative w-16 h-16 shrink-0 group-hover:scale-105 transition-transform">
                    <svg class="w-full h-full transform -rotate-90 drop-shadow-md">
                        <circle cx="32" cy="32" r="28" stroke="rgba(255,255,255,0.15)" stroke-width="6" fill="none"></circle>
                        <circle cx="32" cy="32" r="28" stroke="#10b981" stroke-width="6" fill="none" stroke-dasharray="175.9" stroke-dashoffset="{{ 175.9 - (175.9 * $progressTotal / 100) }}" stroke-linecap="round" class="transition-all duration-1000 ease-out"></circle>
                    </svg>
                    <span class="absolute inset-0 flex items-center justify-center text-sm font-black text-white">{{ $progressTotal }}%</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-emerald-300 uppercase tracking-widest mb-0.5">Kelulusan Kurikulum</p>
                    <p class="text-xl font-black text-white leading-none">{{ $modulTuntas }} <span class="text-xs text-slate-300 font-medium">/ {{ $totalModul }} Modul Tuntas</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-8 gsap-fade">
        <div class="flex bg-white p-1 rounded-2xl shadow-sm border border-slate-200/80 w-full sm:w-auto">
            <button @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'bg-[#10b981] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all">Semua</button>
            <button @click="filterStatus = 'tuntas'" :class="filterStatus === 'tuntas' ? 'bg-[#10b981] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all">Tuntas</button>
            <button @click="filterStatus = 'belum'" :class="filterStatus === 'belum' ? 'bg-[#10b981] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'" class="flex-1 sm:flex-none px-6 py-2.5 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all">Belum</button>
        </div>

        <div class="relative w-full sm:w-80 group">
            <input type="text" x-model="searchQuery" placeholder="Cari judul modul..." class="w-full pl-12 pr-4 py-3 bg-white border-2 border-slate-200/80 rounded-2xl text-xs font-bold text-slate-700 outline-none focus:border-emerald-500 transition-all shadow-sm">
            <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    <!-- Grid Modul -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        @php
            $isNextModuleUnlocked = true; // Modul 1 (Paling atas) selalu terbuka otomatis
        @endphp

        @forelse($modules as $index => $module)
            @php
                // Cek Evaluasi & Nilai Kuis
                $assessment = \App\Models\Assessment::where('module_id', $module->id)->first();
                $bestScore = 0;
                $isPassed = false;

                if($assessment) {
                    $userAttempts = $attempts->where('assessment_id', $assessment->id);
                    $bestScore = $userAttempts->max('total_score') ?? 0;
                    $isPassed = $bestScore >= $assessment->passing_grade;
                }
                $statusFlag = $isPassed ? 'tuntas' : 'belum';

                // Hitung Progress Bar
                $readProgress = $userProgresses->where('module_id', $module->id)->first();
                $currentProgress = $isPassed ? 100 : ($readProgress ? $readProgress->progress_percentage : 0);

                // KALKULASI XP
                $earnedXP = 0;
                if ($currentProgress >= 50) $earnedXP += 50;
                if ($isPassed && $assessment) $earnedXP += $assessment->xp_reward;
                $totalPossibleXP = 50 + ($assessment ? $assessment->xp_reward : 0);

                // LOGIKA GEMBOK (SEQUENTIAL)
                $isUnlocked = $isNextModuleUnlocked;

                // Syarat modul ini dianggap "SELESAI" untuk membuka modul selanjutnya:
                // Jika ada kuis: Harus Lulus (isPassed). Jika tidak ada kuis: Harus sudah baca PDF (Progress >= 50)
                $isModuleCompleted = $assessment ? $isPassed : ($currentProgress >= 50);

                // Update status gembok untuk modul selanjutnya di iterasi berikutnya
                $isNextModuleUnlocked = $isModuleCompleted;
            @endphp

            <div x-show="(filterStatus === 'all' || filterStatus === '{{ $statusFlag }}') && ('{{ strtolower($module->title) }}'.includes(searchQuery.toLowerCase()))"
                 x-transition.opacity.duration.300ms
                 class="gsap-card h-full relative group">

                <!-- OVERLAY GEMBOK (Hanya muncul jika $isUnlocked = false) -->
                @if(!$isUnlocked)
                    <div class="absolute inset-0 bg-slate-900/30 backdrop-blur-[2px] z-20 flex flex-col items-center justify-center text-white rounded-[1.5rem] cursor-not-allowed border border-white/10"
                         onclick="showModuleLockedMessage()">
                        <span class="text-5xl mb-3 drop-shadow-md">🔒</span>
                        <span class="bg-slate-900/90 border border-white/20 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl">Modul Terkunci</span>
                    </div>
                @endif

                <div class="bg-white border-2 border-slate-200/80 rounded-3xl shadow-sm transition-all duration-300 flex flex-col h-full overflow-hidden {{ $isUnlocked ? 'hover:shadow-xl hover:border-emerald-400 hover:-translate-y-2' : 'opacity-80 grayscale' }}">

                    <!-- Cover Gambar -->
                    <div class="w-full h-44 bg-slate-100 relative overflow-hidden shrink-0 border-b-2 border-slate-100">
                        @if($module->cover_image)
                            <img src="{{ asset('storage/' . $module->cover_image) }}" alt="Cover" class="w-full h-full object-cover transition-transform duration-500 {{ $isUnlocked ? 'group-hover:scale-110' : '' }}">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-800 to-[#0f172a] flex flex-col items-center justify-center p-4 text-center">
                                <svg class="w-12 h-12 text-slate-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">SMART-ECO MODULE</span>
                            </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="bg-slate-900/80 backdrop-blur-md text-white border border-white/20 px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm">
                                {{ $module->category ?? 'Umum' }}
                            </span>
                        </div>

                        <div class="absolute top-3 right-3">
                            @if($isPassed)
                                <span class="bg-emerald-500 text-white px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-wider flex items-center gap-1.5 shadow-lg shadow-emerald-500/30">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> Tuntas
                                </span>
                            @else
                                <span class="bg-slate-900/60 backdrop-blur-md text-slate-300 border border-slate-600/50 px-3 py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-wider">Belum Tuntas</span>
                            @endif
                        </div>

                        <div class="absolute bottom-3 right-3 bg-amber-500/90 backdrop-blur-md text-white px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center gap-1.5 shadow-md">
                            ⭐ {{ $earnedXP }} / {{ $totalPossibleXP }} XP
                        </div>
                    </div>

                    <!-- Informasi Modul -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-base font-black text-slate-800 leading-snug mb-2 transition-colors line-clamp-2 {{ $isUnlocked ? 'group-hover:text-emerald-600' : '' }}" title="{{ $module->title }}">
                                {{ $index + 1 }}. {{ $module->title }}
                            </h3>

                            <div class="flex justify-between items-end mb-1">
                                <p class="text-[11px] font-bold text-slate-500">Status: <span class="{{ $currentProgress == 100 ? 'text-emerald-600' : 'text-blue-600' }}">{{ $currentProgress }}% Diselesaikan</span></p>
                                @if(!$assessment)
                                    <span class="text-rose-500 text-[9px] font-black uppercase tracking-widest animate-pulse">(Menunggu Kuis)</span>
                                @endif
                            </div>

                            <div class="w-full bg-slate-100 h-2 rounded-full mb-5 overflow-hidden shadow-inner">
                                <div class="h-full rounded-full transition-all duration-1000 {{ $isPassed ? 'bg-emerald-500' : 'bg-blue-500' }}" style="width: {{ $currentProgress }}%"></div>
                            </div>
                        </div>

                        <div>
                            <!-- RINCIAN XP BACA & KUIS -->
                            <div class="flex items-center justify-between text-[9px] sm:text-[10px] font-black text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-200 mb-4 uppercase tracking-widest">
                                <div class="flex items-center gap-1.5 {{ $currentProgress >= 50 ? 'text-emerald-600' : 'text-slate-400' }}">
                                    <div class="w-4 h-4 rounded-full flex items-center justify-center {{ $currentProgress >= 50 ? 'bg-emerald-100' : 'bg-slate-200' }}">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="{{ $currentProgress >= 50 ? 'M5 13l4 4L19 7' : 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253' }}"></path></svg>
                                    </div>
                                    Baca: 50 XP
                                </div>
                                <div class="w-px h-4 bg-slate-300"></div>
                                <div class="flex items-center gap-1.5 {{ $isPassed ? 'text-emerald-600' : 'text-slate-400' }}">
                                    <div class="w-4 h-4 rounded-full flex items-center justify-center {{ $isPassed ? 'bg-emerald-100' : 'bg-slate-200' }}">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="{{ $isPassed ? 'M5 13l4 4L19 7' : 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2' }}"></path></svg>
                                    </div>
                                    Kuis: {{ $assessment ? $assessment->xp_reward : '0' }} XP
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-3 border-t-2 border-slate-100">
                                <!-- Tombol BACA PDF -->
                                <a href="{{ $isUnlocked ? route('student.modul.read', $module->id) : 'javascript:void(0)' }}"
                                   class="py-3 px-2 rounded-xl border-2 {{ $isUnlocked ? ($currentProgress >= 50 ? 'border-slate-200 bg-white hover:bg-slate-800 hover:text-white hover:border-slate-800 text-slate-700' : 'border-blue-200 bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white hover:border-blue-600') : 'border-slate-200 bg-slate-100 text-slate-400 cursor-not-allowed' }} font-black text-[9px] sm:text-[10px] uppercase tracking-widest transition-all text-center flex items-center justify-center gap-1.5 shadow-sm active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    {{ $currentProgress >= 50 ? 'Baca Ulang' : 'Baca PDF' }}
                                </a>

                                <!-- Tombol EVALUASI -->
                                @if($assessment)
                                    @if($isPassed)
                                        <!-- Tampilan Jika Sudah Lulus (Lencana Hijau / Bukan Tombol) -->
                                        <div class="w-full py-3 px-2 rounded-xl bg-emerald-50 text-emerald-600 border-2 border-emerald-400 font-black text-[9px] sm:text-[10px] uppercase tracking-widest flex items-center justify-center gap-1.5 shadow-sm">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Kuis Selesai
                                        </div>
                                    @else
                                        <!-- Tampilan Jika Belum Lulus (Tombol Bisa Diklik / Terkunci) -->
                                        <form action="{{ $isUnlocked ? route('student.exam.start', $assessment->id) : 'javascript:void(0)' }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="{{ $isUnlocked ? 'submit' : 'button' }}" class="w-full py-3 px-2 rounded-xl {{ $isUnlocked ? 'bg-emerald-500 hover:bg-emerald-600 text-white shadow-lg shadow-emerald-500/20 border-2 border-transparent' : 'bg-slate-100 text-slate-400 border-2 border-slate-200 cursor-not-allowed' }} font-black text-[9px] sm:text-[10px] uppercase tracking-widest transition-all active:scale-95 flex items-center justify-center gap-1.5">
                                                Evaluasi
                                                @if($isUnlocked)
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                                @endif
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <button disabled class="w-full py-3 px-1 rounded-xl bg-slate-100 text-slate-400 border-2 border-slate-200 font-black text-[8px] sm:text-[9px] uppercase tracking-widest cursor-not-allowed flex items-center justify-center gap-1">
                                        Belum Ada Kuis
                                    </button>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-span-full py-20 bg-white border-2 border-dashed border-slate-300 rounded-[3rem] flex flex-col items-center justify-center text-slate-400 shadow-sm">
                <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <p class="text-lg font-black text-slate-700 uppercase tracking-tight">Belum Ada Modul Pembelajaran</p>
                <p class="text-xs mt-1 text-slate-400 font-bold">Modul yang ditambahkan Dosen akan otomatis muncul di sini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi SweetAlert untuk modul yang digembok
    function showModuleLockedMessage() {
        Swal.fire({
            icon: 'warning',
            title: 'Akses Terkunci 🔒',
            text: 'Anda harus membaca PDF dan Lulus Kuis Evaluasi di modul sebelumnya untuk membuka modul ini!',
            confirmButtonColor: '#10b981',
            customClass: { popup: 'rounded-[2rem]' }
        });
    }

    function modulePage() {
        return {
            filterStatus: 'all',
            searchQuery: '',

            initPage() {
                if(typeof gsap !== 'undefined') {
                    gsap.from(".gsap-fade", { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, ease: "power2.out" });
                    gsap.from(".gsap-card", {
                        y: 30, opacity: 0, duration: 0.6, stagger: 0.08, ease: "back.out(1.2)", delay: 0.2
                    });
                }
            }
        }
    }
</script>
@endpush
