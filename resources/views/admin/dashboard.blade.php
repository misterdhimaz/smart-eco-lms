<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Command Center | SMART-ECO</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; height: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar:hover::-webkit-scrollbar-thumb { background: #94a3b8; }
        [x-cloak] { display: none !important; }
        .chart-loader { backdrop-filter: blur(4px); }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans antialiased text-slate-800 selection:bg-[#047857] selection:text-white" x-data="adminDashboard()" x-init="initDashboard()">
    <div class="flex h-screen overflow-hidden relative">

        <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:inset-0 shrink-0 border-r border-slate-200 shadow-2xl lg:shadow-none">
            <x-admin-sidebar :admin="$admin" class="h-full" />
        </div>

        <div class="flex-1 flex flex-col relative overflow-hidden h-screen bg-[#f1f5f9]">

            <header class="h-[76px] bg-white border-b border-slate-200 flex items-center justify-between px-6 lg:px-8 z-10 sticky top-0 shadow-sm shrink-0 gsap-fade">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-black text-slate-800 tracking-tight leading-none">Command <span class="text-[#047857]">Center</span></h1>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1 hidden sm:block">Pemantauan Sistem Terpadu</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex relative group">
                        <input type="text" placeholder="Cari data..." class="pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold outline-none focus:border-[#047857] focus:ring-2 focus:ring-[#047857]/20 transition-all w-64">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button onclick="window.print()" class="hidden sm:flex bg-[#0f172a] hover:bg-[#047857] text-white px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all items-center gap-2 shadow-lg shadow-slate-500/20 active:scale-95">
                        Export Laporan
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 lg:p-8 space-y-6 custom-scrollbar pb-24">

                <div class="flex flex-col xl:flex-row gap-4 justify-between items-center gsap-fade">
                    <div class="flex flex-wrap gap-3 w-full xl:w-auto">
                        <a href="{{ route('admin.users') }}" class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 hover:text-[#047857] hover:border-[#047857]/30 transition-all">
                            <span class="w-6 h-6 rounded-md bg-emerald-50 text-emerald-600 flex items-center justify-center">+</span> Tambah Siswa
                        </a>
                        <a href="{{ route('admin.modules') }}" class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 hover:text-blue-600 hover:border-blue-300 transition-all">
                            <span class="w-6 h-6 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center">📚</span> Upload Modul
                        </a>
                        <a href="{{ route('admin.assessments') ?? '#' }}" class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-200 text-xs font-bold text-slate-600 hover:text-purple-600 hover:border-purple-300 transition-all">
                            <span class="w-6 h-6 rounded-md bg-purple-50 text-purple-600 flex items-center justify-center">📝</span> Buat Kuis Baru
                        </a>
                    </div>

                    <div class="bg-white border border-slate-200 p-1.5 rounded-xl flex shadow-sm w-full xl:w-auto overflow-x-auto custom-scrollbar">
                        <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-400 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg> Filter:
                        </span>
                        <button @click="changeGlobalFilter('year')" :class="globalFilter === 'year' ? 'bg-[#047857] text-white shadow-md' : 'text-slate-500 hover:bg-slate-50'" class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">Tahun Ini</button>
                    </div>
                </div>

              <div class="space-y-4 lg:space-y-6">

    <div class="bg-gradient-to-br from-[#0f172a] to-[#047857] rounded-2xl p-6 shadow-xl relative overflow-hidden gsap-stat-card group w-full flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="absolute -right-4 -bottom-4 opacity-10 text-8xl group-hover:scale-110 transition-transform duration-500 pointer-events-none">📈</div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-white/10 text-emerald-400 rounded-xl flex items-center justify-center text-lg border border-white/20 backdrop-blur-sm">⚡</div>
                <p class="text-xs font-bold uppercase tracking-widest text-emerald-200">Rata-rata Progress Keseluruhan Mahasiswa</p>
            </div>
            <p class="text-4xl lg:text-5xl font-black text-white"><span class="counter-number" data-target="{{ $stats['avg_progress'] ?? 0 }}">0</span>%</p>
        </div>

        <div class="relative z-10 w-full sm:w-1/3 text-left sm:text-right">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-300 mb-1">Status Sistem: <span class="text-emerald-400">Optimal</span></p>
            <div class="w-full bg-black/30 rounded-full h-3 overflow-hidden border border-white/10">
                <div class="bg-gradient-to-r from-emerald-400 to-teal-300 h-3 rounded-full gsap-progress-bar" style="width: {{ $stats['avg_progress'] ?? 0 }}%"></div>
            </div>
        </div>
    </div>
</div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 gsap-slide-up">

                    <div class="lg:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden relative flex flex-col">
                        <div x-show="isChartLoading" class="absolute inset-0 z-10 bg-white/50 chart-loader flex items-center justify-center">
                            <div class="w-8 h-8 border-4 border-slate-200 border-t-[#047857] rounded-full animate-spin"></div>
                        </div>
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Pendaftaran Mahasiswa</h3>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">Tren pengguna baru yang bergabung</p>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-emerald-50/50 border-b border-emerald-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-lg shrink-0">📈</div>
                            <div>
                                <p class="text-xs font-bold text-slate-600">Total pendaftar pada filter ini:</p>
                                <p class="text-xl font-black text-[#047857]" x-text="summary.students + ' Mahasiswa Baru'"></p>
                            </div>
                        </div>

                        <div class="p-4 flex-1"><div id="userGrowthChart" class="w-full h-full min-h-[250px]"></div></div>
                    </div>

                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden relative flex flex-col">
                        <div x-show="isChartLoading" class="absolute inset-0 z-10 bg-white/50 chart-loader flex items-center justify-center">
                            <div class="w-8 h-8 border-4 border-slate-200 border-t-blue-500 rounded-full animate-spin"></div>
                        </div>
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Konten Materi</h3>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">Modul & Video Diupload</p>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-blue-50/50 border-b border-blue-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-lg shrink-0">📁</div>
                            <div>
                                <p class="text-xs font-bold text-slate-600">Konten Baru:</p>
                                <p class="text-sm font-black text-blue-700">
                                    <span x-text="summary.modules"></span> Modul & <span x-text="summary.videos"></span> Video
                                </p>
                            </div>
                        </div>

                        <div class="p-4 flex-1 flex items-center justify-center"><div id="contentChart" class="w-full"></div></div>
                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 gsap-slide-up">

                    <div class="lg:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden relative flex flex-col">
                        <div x-show="isChartLoading" class="absolute inset-0 z-10 bg-white/50 chart-loader flex items-center justify-center">
                            <div class="w-8 h-8 border-4 border-slate-200 border-t-purple-500 rounded-full animate-spin"></div>
                        </div>
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Aktivitas Evaluasi</h3>
                                <p class="text-[10px] font-bold text-slate-400 mt-0.5">Kuis dikerjakan vs Tugas dikumpulkan</p>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-purple-50/50 border-b border-purple-100 flex items-center gap-4">
                            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-lg shrink-0">📝</div>
                            <div>
                                <p class="text-xs font-bold text-slate-600">Partisipasi Siswa:</p>
                                <p class="text-sm font-black text-purple-700">
                                    <span x-text="summary.kuis"></span> Kuis Selesai | <span x-text="summary.tugas"></span> Tugas Terkumpul
                                </p>
                            </div>
                        </div>

                        <div class="p-4 flex-1"><div id="assessmentChart" class="w-full h-full min-h-[220px]"></div></div>
                    </div>

                    <div class="flex flex-col gap-6">
                        <div class="bg-white rounded-[2rem] p-5 border border-slate-200 shadow-sm flex flex-col relative">
                            <div class="mb-2 text-center">
                                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Status Kelulusan Global</h3>
                            </div>
                            <div class="flex-1 flex items-center justify-center relative min-h-[180px]">
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-4">
                                    <span class="text-3xl font-black text-[#047857]">{{ $lulusPersen }}%</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Lulus Total</span>
                                </div>
                                <div id="donutChart" class="w-full"></div>
                            </div>
                        </div>

                        <div class="bg-[#0f172a] rounded-[2rem] p-5 border border-slate-800 shadow-lg text-white">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xs font-black uppercase tracking-widest text-slate-300">Penyimpanan Server</h3>
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold">
                                    <span class="text-slate-400">Terpakai ({{ $serverStorage['used_gb'] }} GB)</span>
                                    <span class="text-emerald-400">{{ $serverStorage['percent'] }}%</span>
                                </div>
                                <div class="w-full bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-emerald-500 to-blue-500 h-2.5 rounded-full" style="width: {{ $serverStorage['percent'] }}%"></div>
                                </div>
                                <p class="text-[10px] text-slate-500 font-medium text-right">Kapasitas Total: {{ $serverStorage['total_gb'] }} GB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 gsap-slide-up">

                    <div class="xl:col-span-2 bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Siswa Aktif Terbaru</h2>
                            <a href="{{ route('admin.users') }}" class="text-[10px] font-black text-[#047857] uppercase tracking-widest hover:bg-emerald-50 px-4 py-2 rounded-lg transition-colors border border-emerald-100">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto custom-scrollbar flex-1">
                            <table class="w-full text-left border-collapse min-w-[500px]">
                                <thead>
                                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white border-b border-slate-100">
                                        <th class="px-6 py-4">Nama Siswa</th>
                                        <th class="px-6 py-4">Level / XP</th>
                                        <th class="px-6 py-4 w-1/3">Modul Berjalan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($recentStudents ?? [] as $student)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if($student->avatar)
                                                    <img src="{{ asset('storage/' . $student->avatar) }}" class="w-10 h-10 rounded-xl object-cover shadow-sm border border-slate-200">
                                                @else
                                                    <div class="w-10 h-10 bg-gradient-to-br from-[#0a2540] to-[#047857] text-white rounded-xl flex items-center justify-center font-black text-sm shadow-md">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800">{{ $student->name }}</p>
                                                    <p class="text-[10px] font-semibold text-slate-500">{{ $student->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 bg-slate-100 border border-slate-200 text-slate-700 rounded-md text-[10px] font-black uppercase tracking-wider inline-block mb-1">Lv {{ $student->level ?? 1 }}</span>
                                            <p class="text-xs font-bold text-emerald-600">{{ $student->xp ?? 0 }} XP</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php $currentMod = ($student->progress)->first() ?? null; @endphp
                                            @if($currentMod)
                                                <p class="text-xs font-bold text-slate-700 mb-2 truncate max-w-[200px]">{{ $currentMod->module->title ?? 'Sedang Mengerjakan' }}</p>
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden shadow-inner">
                                                        <div class="bg-gradient-to-r from-blue-400 to-[#047857] h-2 rounded-full gsap-progress-bar" style="width: {{ $currentMod->progress_percentage ?? 0 }}%"></div>
                                                    </div>
                                                    <span class="text-[10px] font-black text-slate-500 w-8">{{ $currentMod->progress_percentage ?? 0 }}%</span>
                                                </div>
                                            @else
                                                <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] uppercase tracking-widest rounded-lg font-black border border-slate-200">Belum Mulai</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400 font-bold text-sm">Belum ada siswa yang aktif.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6 overflow-hidden flex flex-col">
                        <div class="mb-6">
                            <h2 class="text-sm font-black text-slate-800 uppercase tracking-widest">Aktivitas Terkini</h2>
                            <p class="text-[10px] font-bold text-slate-400 mt-1">Live Feed Sistem LMS</p>
                        </div>
                        <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-6">

                            @forelse($activities as $act)
                            <div class="flex gap-4 relative">
                                @if(!$loop->last)
                                <div class="absolute left-4 top-8 bottom-[-24px] w-0.5 bg-slate-100"></div>
                                @endif
                                <div class="w-8 h-8 rounded-full bg-{{ $act['color'] }}-100 text-{{ $act['color'] }}-600 flex items-center justify-center shrink-0 z-10 border-2 border-white shadow-sm text-sm">{{ $act['icon'] }}</div>
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $act['title'] }}</p>
                                    <p class="text-[10px] font-semibold text-slate-500">{{ $act['desc'] }}</p>
                                    <p class="text-[9px] font-bold text-slate-400 mt-1 uppercase">{{ \Carbon\Carbon::parse($act['time'])->diffForHumans() }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-xs font-bold text-slate-400 text-center py-10">Belum ada aktivitas di platform.</p>
                            @endforelse

                        </div>
                    </div>

                </div>

            </main>
        </div>
    </div>

    <script>
        function adminDashboard() {
            return {
                sidebarOpen: window.innerWidth >= 1024,
                globalFilter: 'year', // Set default ke year karena datanya yang lengkap
                isChartLoading: false,

                // Ringkasan Teks Realtime
                summary: { students: 0, modules: 0, videos: 0, kuis: 0, tugas: 0 },

                // Chart Instances
                userChart: null,
                contentChart: null,
                assessmentChart: null,

                // 100% DATA ASLI DARI LARAVEL BACKEND CONTROLLER
                dataStore: @json($chartData),

                initDashboard() {
                    this.updateSummaryText(this.globalFilter);
                    this.initGSAP();

                    this.renderUserChart();
                    this.renderContentChart();
                    this.renderAssessmentChart();
                    this.renderDonutChart();
                },

                initGSAP() {
                    gsap.from(".gsap-fade", { y: -20, opacity: 0, duration: 0.6, ease: "power2.out" });
                    gsap.from(".gsap-stat-card", { y: 30, scale: 0.95, opacity: 0, duration: 0.8, stagger: 0.1, ease: "back.out(1.2)", delay: 0.2 });
                    gsap.from(".gsap-slide-up", { y: 40, opacity: 0, duration: 0.8, stagger: 0.15, ease: "power3.out", delay: 0.4 });

                    const counters = document.querySelectorAll('.counter-number');
                    counters.forEach(counter => {
                        const target = parseFloat(counter.getAttribute('data-target'));
                        if(target > 0) {
                            let obj = { val: 0 };
                            gsap.to(obj, {
                                val: target, duration: 2.5, ease: "power2.out", delay: 0.5,
                                onUpdate: function() { counter.innerHTML = Math.floor(obj.val); }
                            });
                        }
                    });

                    setTimeout(() => {
                        gsap.fromTo(".gsap-progress-bar", { scaleX: 0 }, { scaleX: 1, duration: 1.5, ease: "power3.out" });
                    }, 800);
                },

                updateSummaryText(type) {
                    // Karena struktur array controller kita buat default di 'year'
                    // Ini akan mengupdate angka-angka di atas grafik (Insights)
                    const data = this.dataStore[type].total;

                    gsap.to(this.summary, {
                        students: data.students,
                        modules: data.modules,
                        videos: data.videos,
                        kuis: data.kuis,
                        tugas: data.tugas,
                        duration: 1,
                        ease: "power2.out",
                        roundProps: "students,modules,videos,kuis,tugas"
                    });
                },

                changeGlobalFilter(type) {
                    if(this.globalFilter === type) return;
                    this.globalFilter = type;
                    this.isChartLoading = true;

                    this.updateSummaryText(type);

                    setTimeout(() => {
                        const d = this.dataStore[type];

                        // Error handling fallback kalau datanya kosong/belum ada dari controller
                        if(d) {
                            this.userChart.updateOptions({ xaxis: { categories: d.labels }});
                            this.userChart.updateSeries([{ data: d.user }]);

                            this.contentChart.updateOptions({ xaxis: { categories: d.labels }});
                            this.contentChart.updateSeries([
                                { data: d.content.modul }, { data: d.content.video }
                            ]);

                            this.assessmentChart.updateOptions({ xaxis: { categories: d.labels }});
                            this.assessmentChart.updateSeries([
                                { data: d.assessment.kuis }, { data: d.assessment.tugas }
                            ]);
                        }
                        this.isChartLoading = false;
                    }, 500);
                },

                renderUserChart() {
                    const d = this.dataStore[this.globalFilter];
                    const options = {
                        series: [{ name: 'Siswa Baru', data: d.user }],
                        chart: { type: 'area', height: '100%', fontFamily: 'inherit', toolbar: { show: false } },
                        colors: ['#047857'],
                        fill: { type: 'gradient', gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 90, 100] } },
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 3 },
                        xaxis: { categories: d.labels, axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } } },
                        yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } } },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
                    };
                    this.userChart = new ApexCharts(document.querySelector("#userGrowthChart"), options);
                    this.userChart.render();
                },

                renderContentChart() {
                    const d = this.dataStore[this.globalFilter];
                    const options = {
                        series: [{ name: 'Modul', data: d.content.modul }, { name: 'Video', data: d.content.video }],
                        chart: { type: 'bar', height: '100%', fontFamily: 'inherit', toolbar: { show: false }, stacked: false },
                        colors: ['#3b82f6', '#f59e0b'],
                        plotOptions: { bar: { horizontal: false, columnWidth: '55%', borderRadius: 4 } },
                        dataLabels: { enabled: false },
                        stroke: { show: true, width: 2, colors: ['transparent'] },
                        xaxis: { categories: d.labels, axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } } },
                        yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } } },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                        legend: { position: 'top', fontSize: '10px', fontWeight: 'bold', markers: { radius: 12 } }
                    };
                    this.contentChart = new ApexCharts(document.querySelector("#contentChart"), options);
                    this.contentChart.render();
                },

                renderAssessmentChart() {
                    const d = this.dataStore[this.globalFilter];
                    const options = {
                        series: [{ name: 'Kuis Dibuat', data: d.assessment.kuis }, { name: 'Tugas Masuk', data: d.assessment.tugas }],
                        chart: { type: 'line', height: '100%', fontFamily: 'inherit', toolbar: { show: false } },
                        colors: ['#8b5cf6', '#ec4899'],
                        stroke: { width: 3, curve: 'smooth' },
                        dataLabels: { enabled: false },
                        xaxis: { categories: d.labels, axisBorder: { show: false }, axisTicks: { show: false }, labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } } },
                        yaxis: { labels: { style: { colors: '#94a3b8', fontSize: '10px', fontWeight: 'bold' } } },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                        legend: { position: 'top', fontSize: '10px', fontWeight: 'bold', markers: { radius: 12 } }
                    };
                    this.assessmentChart = new ApexCharts(document.querySelector("#assessmentChart"), options);
                    this.assessmentChart.render();
                },

                renderDonutChart() {
                    // Data asli dari controller: $donutData = [Lulus, Belajar, Belum]
                    const dataDonut = @json($donutData);

                    const options = {
                        series: dataDonut,
                        labels: ['Selesai / Lulus', 'Sedang Belajar', 'Belum Mulai'],
                        chart: { type: 'donut', height: 200, fontFamily: 'inherit' },
                        colors: ['#047857', '#3b82f6', '#cbd5e1'],
                        plotOptions: { pie: { donut: { size: '75%' } } },
                        dataLabels: { enabled: false },
                        stroke: { width: 0 },
                        legend: { position: 'bottom', horizontalAlign: 'center', fontSize: '10px', fontWeight: 'bold', markers: { radius: 12 } }
                    };
                    new ApexCharts(document.querySelector("#donutChart"), options).render();
                }
            }
        }
    </script>
</body>
</html>
