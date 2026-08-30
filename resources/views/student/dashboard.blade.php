@extends('layouts.student')
@section('title', 'Beranda | SMART-ECO')

@section('content')
<div x-data="dashboardApp()" x-init="initApp()" x-cloak class="w-full pb-12 font-sans text-slate-800">

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        <div class="xl:col-span-8 space-y-6 min-w-0">

            <!-- BANNER WELCOME -->
            <div class="relative rounded-xl p-6 md:p-8 text-white overflow-hidden shadow-sm flex items-center justify-between min-h-[160px] bg-[#0A2540] hover:shadow-lg transition-all duration-300">
                <div class="absolute right-0 top-0 bottom-0 w-1/2 opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;"></div>
                <div class="absolute -right-10 -bottom-20 w-80 h-80 bg-emerald-500/30 blur-[80px] rounded-full pointer-events-none"></div>

                <div class="relative z-10 w-full flex justify-between items-center">
                    <div class="max-w-xl">
                        <h2 class="text-3xl font-bold mb-3 leading-tight tracking-tight text-white">
                            Halo {{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 3)) }},<br>
                            <span class="text-emerald-400">Selamatkan Bumi Hari Ini!</span>
                        </h2>
                        <div class="flex flex-wrap gap-4 mt-2">
                            <span class="flex items-center gap-1.5 text-xs font-semibold text-emerald-100"><span class="text-lg">🌿</span> SETS Approach</span>
                            <span class="flex items-center gap-1.5 text-xs font-semibold text-cyan-100"><span class="text-lg">⚙️</span> Computational Thinking</span>
                            <span class="flex items-center gap-1.5 text-xs font-semibold text-amber-100"><span class="text-lg">🤖</span> AI for Sustainability</span>
                            <span class="flex items-center gap-1.5 text-xs font-semibold text-blue-100"><span class="text-lg">🌍</span> 21st Century Skills</span>
                        </div>
                    </div>
                    <div class="hidden md:block text-6xl opacity-90 drop-shadow-xl animate-pulse">
                        🌍 ⚡ 🍃
                    </div>
                </div>
            </div>

            <!-- DASHBOARD IKLIM GLOBAL (API Realtime) -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest">Dashboard Iklim Global</h3>
                    <div class="flex items-center gap-3">
                        <span x-show="apiLoading" class="text-[9px] bg-amber-50 text-amber-600 px-2 py-1 rounded font-bold animate-pulse">Menyambungkan API...</span>
                        <a href="{{ route('student.climate') }}" class="text-[11px] font-bold text-blue-600 hover:underline">Lihat detail →</a>
                    </div>
                </div>

                <div class="flex gap-4 overflow-x-auto pb-2 custom-scrollbar snap-x">
                    <a href="https://climate.nasa.gov/" target="_blank" class="min-w-[190px] shrink-0 border border-slate-100 p-4 rounded-xl hover:border-rose-300 hover:shadow-md transition-all snap-start">
                        <p class="text-[11px] font-bold text-slate-500 mb-1">Suhu Global</p>
                        <div class="flex items-end gap-1">
                            <p class="text-2xl font-black text-slate-800 leading-none" x-text="tempGlobal > 0 ? '+' + tempGlobal : tempGlobal"></p>
                            <span class="text-xs font-bold text-slate-500 pb-0.5">°C</span>
                        </div>
                        <p class="text-[9px] text-slate-400 mt-1">di atas era pra-industri</p>
                        <div class="h-10 mt-3 w-full"><canvas id="chartSuhu"></canvas></div>
                    </a>

                    <a href="https://gml.noaa.gov/ccgg/trends/" target="_blank" class="min-w-[190px] shrink-0 border border-slate-100 p-4 rounded-xl hover:border-emerald-300 hover:shadow-md transition-all snap-start">
                        <p class="text-[11px] font-bold text-slate-500 mb-1">Konsentrasi CO₂</p>
                        <div class="flex items-end gap-1">
                            <p class="text-2xl font-black text-slate-800 leading-none" x-text="co2Global"></p>
                            <span class="text-xs font-bold text-slate-500 pb-0.5">ppm</span>
                        </div>
                        <p class="text-[9px] text-slate-400 mt-1">(Bulan Terbaru)</p>
                        <div class="h-10 mt-3 w-full"><canvas id="chartCo2"></canvas></div>
                    </a>

                    <a href="https://ourworldindata.org/co2-emissions" target="_blank" class="min-w-[190px] shrink-0 border border-slate-100 p-4 rounded-xl hover:border-blue-300 hover:shadow-md transition-all snap-start">
                        <p class="text-[11px] font-bold text-slate-500 mb-1">Emisi CO₂ Global</p>
                        <div class="flex items-end gap-1">
                            <p class="text-2xl font-black text-slate-800 leading-none">36.8</p>
                            <span class="text-xs font-bold text-slate-500 pb-0.5">Gt</span>
                        </div>
                        <p class="text-[9px] text-slate-400 mt-1">/tahun</p>
                        <div class="h-10 mt-3 w-full"><canvas id="chartGlobal"></canvas></div>
                    </a>

                    <a href="https://sdgs.un.org/goals" target="_blank" class="min-w-[180px] shrink-0 border border-slate-100 p-4 rounded-xl hover:border-indigo-300 hover:shadow-md transition-all snap-start flex flex-col justify-center">
                        <p class="text-[11px] font-bold text-slate-500 mb-3 text-center">Tujuan SDGs Terkait</p>
                        <div class="flex justify-center gap-2">
                            <div class="w-10 h-10 bg-amber-500 rounded text-white flex flex-col items-center justify-center shadow-sm">
                                <span class="font-black text-[10px] leading-none">7</span>
                                <span class="text-[5px] uppercase font-bold text-center leading-tight mt-1">Energi<br>Bersih</span>
                            </div>
                            <div class="w-10 h-10 bg-orange-500 rounded text-white flex flex-col items-center justify-center shadow-sm">
                                <span class="font-black text-[10px] leading-none">11</span>
                                <span class="text-[5px] uppercase font-bold text-center leading-tight mt-1">Kota &<br>Komunitas</span>
                            </div>
                            <div class="w-10 h-10 bg-emerald-700 rounded text-white flex flex-col items-center justify-center shadow-sm">
                                <span class="font-black text-[10px] leading-none">13</span>
                                <span class="text-[5px] uppercase font-bold text-center leading-tight mt-1">Aksi<br>Iklim</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- MODUL PEMBELAJARAN (Database Dinamis) -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest">Modul Pembelajaran</h3>
                    <a href="{{ route('student.modul') }}" class="text-[11px] font-bold text-blue-600 hover:underline">Lihat semua modul →</a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    @forelse($assessments->take(5) as $idx => $assessment)
                        @php
                            // Mengecek apakah modul ini sudah lulus
                            $isPassed = $attempts->where('assessment_id', $assessment->id)->where('is_passed', true)->isNotEmpty();
                            $progress = $isPassed ? 100 : 0;

                            // Tema Warna & Ikon Dinamis
                            $colors = ['emerald', 'blue', 'amber', 'purple', 'rose'];
                            $color = $colors[$idx % count($colors)];
                            $icons = ['🌍', '⚡', '🧠', '🤖', '🌱'];
                            $icon = $icons[$idx % count($icons)];
                        @endphp

                        <a href="{{ route('student.modul.read', $assessment->module_id ?? 1) }}" class="border border-slate-100 rounded-lg p-3 hover:shadow-md hover:-translate-y-1 hover:border-{{ $color }}-300 transition-all group flex flex-col justify-between h-full">
                            <div>
                                <div class="flex gap-2 items-start mb-3">
                                    <span class="w-5 h-5 rounded bg-{{ $color }}-500 text-white flex items-center justify-center text-[10px] font-black shrink-0">{{ $idx + 1 }}</span>
                                    <h4 class="text-[10px] font-bold text-slate-800 leading-tight group-hover:text-{{ $color }}-600 line-clamp-2">{{ $assessment->module->title ?? $assessment->title }}</h4>
                                </div>
                                <div class="text-4xl text-center mb-4 group-hover:scale-110 transition-transform">{{ $icon }}</div>
                            </div>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden mr-2">
                                        <div class="bg-{{ $isPassed ? 'emerald' : 'slate' }}-400 h-full rounded-full transition-all" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <p class="text-[9px] font-bold text-slate-500">{{ $progress }}%</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-4 text-xs font-bold text-slate-400">Belum ada modul yang tersedia.</div>
                    @endforelse
                </div>
            </div>

            <!-- MEDIA INTERAKTIF -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest mb-4">Media Interaktif</h3>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    <a href="{{ route('student.simulasi') }}" class="bg-white border border-slate-100 p-3 rounded-lg flex items-center gap-3 hover:border-cyan-400 hover:shadow-sm transition-all shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                        <div class="text-2xl">💻</div>
                        <div><p class="text-[10px] font-bold text-slate-800 leading-tight">Simulasi</p><p class="text-[8px] text-slate-500">PhET, Climate...</p></div>
                    </a>
                    <a href="{{ route('student.video') }}" class="bg-white border border-slate-100 p-3 rounded-lg flex items-center gap-3 hover:border-rose-400 hover:shadow-sm transition-all shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                        <div class="text-2xl">▶️</div>
                        <div><p class="text-[10px] font-bold text-slate-800 leading-tight">Video Belajar</p><p class="text-[8px] text-slate-500">Microlearning</p></div>
                    </a>
                    <a href="{{ route('student.games') }}" class="bg-white border border-slate-100 p-3 rounded-lg flex items-center gap-3 hover:border-blue-400 hover:shadow-sm transition-all shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                        <div class="text-2xl">🎮</div>
                        <div><p class="text-[10px] font-bold text-slate-800 leading-tight">Games Edukasi</p><p class="text-[8px] text-slate-500">Belajar bermain</p></div>
                    </a>
                    <a href="{{ route('student.simulasi') }}" class="bg-white border border-slate-100 p-3 rounded-lg flex items-center gap-3 hover:border-teal-400 hover:shadow-sm transition-all shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                        <div class="text-2xl">🔬</div>
                        <div><p class="text-[10px] font-bold text-slate-800 leading-tight">Virtual Lab</p><p class="text-[8px] text-slate-500">Eksperimen Aktif</p></div>
                    </a>
                    <a href="{{ route('student.latihan') }}" class="bg-white border border-slate-100 p-3 rounded-lg flex items-center gap-3 hover:border-emerald-400 hover:shadow-sm transition-all shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
                        <div class="text-2xl">📝</div>
                        <div><p class="text-[10px] font-bold text-slate-800 leading-tight">Latihan Soal</p><p class="text-[8px] text-slate-500">Kuis & Ujian</p></div>
                    </a>
                </div>
            </div>

            <!-- SIKLUS PEMBELAJARAN -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200 overflow-x-auto custom-scrollbar">
                <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest mb-6">Siklus Pembelajaran SOSML-SETS</h3>
                <div class="flex items-center justify-between min-w-[750px] relative pb-2 px-4">
                    <div class="absolute top-[22px] left-10 right-10 h-0.5 bg-emerald-200 -z-10"></div>

                    @php
                        $siklus = [
                            ['icon'=>'🌍', 'title'=>'Sustainability Awareness', 'desc'=>'Mengamati isu perubahan iklim'],
                            ['icon'=>'🔗', 'title'=>'SETS Exploration', 'desc'=>'Menghubungkan Science, Tech, Society'],
                            ['icon'=>'🧠', 'title'=>'Computational Thinking', 'desc'=>'Dekomposisi, pola, abstraksi...'],
                            ['icon'=>'💻', 'title'=>'AI Prediction', 'desc'=>'Prediksi jejak karbon dengan ML'],
                            ['icon'=>'💡', 'title'=>'Engineering Design', 'desc'=>'Merancang solusi berbasis STEM'],
                            ['icon'=>'🌱', 'title'=>'Reflection and Action', 'desc'=>'Refleksi dan aksi keberlanjutan'],
                        ];
                    @endphp

                    @foreach($siklus as $idx => $s)
                        <div class="text-center w-28 relative group">
                            <div class="w-12 h-12 bg-white border-2 border-emerald-400 rounded-full mx-auto flex items-center justify-center text-xl mb-3 relative z-10 group-hover:scale-110 group-hover:bg-emerald-50 transition-all shadow-sm">
                                {{ $s['icon'] }}
                                <span class="absolute -bottom-1 -left-1 w-5 h-5 bg-emerald-500 text-white text-[9px] font-black rounded-sm flex items-center justify-center">{{ $idx+1 }}</span>
                            </div>
                            <p class="text-[10px] font-black text-slate-800 leading-tight mb-1">{{ $s['title'] }}</p>
                            <p class="text-[8px] text-slate-500 font-medium">{{ $s['desc'] }}</p>

                            @if($idx < 5)
                                <div class="absolute top-5 -right-5 text-emerald-500 text-base z-0">➔</div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="xl:col-span-4 space-y-6">

            <!-- KALKULATOR KARBON MINI -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="mb-5">
                    <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest leading-tight">Kalkulator Jejak Karbon <span class="text-[9px] text-emerald-600 bg-emerald-100 px-1.5 py-0.5 rounded ml-1">(AI)</span></h3>
                    <p class="text-[10px] text-slate-500 mt-1">Hitung jejak karbon Anda dengan Machine Learning</p>
                </div>

                <div class="flex gap-4 mb-4">
                    <div class="flex-1 space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xl text-emerald-600">🚗</span>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-slate-700 leading-tight mb-0.5">Transportasi</p>
                                <p class="text-[9px] text-slate-400 mb-1" x-text="transport + ' km/hari'"></p>
                                <input type="range" x-model="transport" @input="updateCarbon" min="0" max="200" class="w-full h-1 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl text-emerald-500">⚡</span>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-slate-700 leading-tight mb-0.5">Listrik</p>
                                <p class="text-[9px] text-slate-400 mb-1" x-text="electricity + ' kWh/bulan'"></p>
                                <input type="range" x-model="electricity" @input="updateCarbon" min="50" max="500" class="w-full h-1 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-emerald-500">
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl text-cyan-500">❄️</span>
                            <div class="flex-1">
                                <p class="text-[10px] font-bold text-slate-700 leading-tight mb-0.5">AC</p>
                                <p class="text-[9px] text-slate-400 mb-1" x-text="ac + ' jam/hari'"></p>
                                <input type="range" x-model="ac" @input="updateCarbon" min="0" max="24" class="w-full h-1 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-cyan-500">
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-xl text-orange-500">🍅</span>
                            <div class="flex-1 flex justify-between items-center">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-700 leading-tight mb-0.5">Konsumsi Makanan</p>
                                    <p class="text-[9px] text-slate-400" x-text="food == 1 ? 'Rendah' : (food == 2 ? 'Sedang' : 'Tinggi')"></p>
                                </div>
                                <select x-model="food" @change="updateCarbon" class="opacity-0 w-0 h-0"></select>
                            </div>
                        </div>
                    </div>

                    <div class="w-[120px] shrink-0 text-center flex flex-col items-center justify-start pt-2">
                        <div class="relative w-[100px] h-[50px] overflow-hidden mb-2">
                            <canvas id="carbonDonut"></canvas>
                            <div class="absolute bottom-0 left-0 right-0 text-center">
                                <span class="text-3xl font-black text-slate-800 leading-none" x-text="carbonTotal.toFixed(2)"></span>
                            </div>
                        </div>
                        <p class="text-[8px] text-slate-800 font-medium mb-3">ton CO₂ / tahun</p>
                        <p class="text-[9px] text-slate-500 mb-1">Kategori</p>
                        <span class="text-[10px] font-black px-3 py-1 rounded mb-3" :class="statusClass" x-text="statusText"></span>
                        <a href="{{ route('student.carbon') }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold py-2 rounded-md transition-colors shadow-sm">Lihat Rekomendasi</a>
                    </div>
                </div>
            </div>

            <!-- CHAT WIDGET -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200 flex flex-col h-[380px]">
                <div class="mb-4 border-b border-slate-100 pb-3">
                    <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest leading-tight">AI Sustainability Advisor</h3>
                    <p class="text-[10px] text-slate-500 mt-1">Tanya apa saja tentang keberlanjutan!</p>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar pr-2 space-y-4 mb-3 flex flex-col text-[10px]" id="chatContainer">
                    <div class="flex items-start justify-start w-full">
                        <div class="text-slate-800 max-w-[95%] font-medium">
                            <span class="font-bold">Anda:</span> Bagaimana cara mengurangi emisi karbon harian saya?
                        </div>
                    </div>

                    <div class="flex gap-2 items-start text-slate-700">
                        <div class="w-full">
                            <p class="font-bold text-emerald-600 mb-1">AI Advisor:</p>
                            <p class="mb-1.5">Berikut beberapa rekomendasi untuk Anda:</p>
                            <ul class="space-y-1">
                                <li class="flex items-center gap-1.5"><span class="text-emerald-500 text-xs">✔️</span> Gunakan transportasi umum</li>
                                <li class="flex items-center gap-1.5"><span class="text-emerald-500 text-xs">✔️</span> Hemat penggunaan listrik</li>
                                <li class="flex items-center gap-1.5"><span class="text-emerald-500 text-xs">✔️</span> Kurangi penggunaan plastik sekali pakai</li>
                            </ul>
                        </div>
                        <div class="w-12 h-12 bg-slate-50 border border-slate-200 rounded-full flex items-center justify-center shrink-0 text-xl shadow-sm self-end mb-2">🤖</div>
                    </div>

                    <template x-for="chat in chats" :key="chat.id">
                        <div class="flex gap-2 items-start" :class="chat.role === 'user' ? 'justify-start w-full' : ''">
                            <div class="w-full leading-relaxed"
                                 :class="chat.role === 'user' ? 'font-medium text-slate-800' : 'text-slate-700'"
                                 x-html="chat.text">
                            </div>
                        </div>
                    </template>
                    <div x-show="isTyping" class="text-emerald-600 italic animate-pulse mt-2">AI sedang mengetik...</div>
                </div>

                <div class="relative shrink-0 border border-slate-200 rounded overflow-hidden bg-slate-50 focus-within:border-emerald-400 transition-colors flex items-center">
                    <input type="text" x-model="chatMsg" @keyup.enter="sendMessage" placeholder="Ketik pertanyaan Anda..." class="w-full pl-3 pr-2 py-2 bg-transparent text-[11px] outline-none">
                    <button @click="sendMessage" class="w-8 h-8 bg-emerald-600 hover:bg-emerald-700 flex items-center justify-center text-white transition-colors disabled:opacity-50 mr-1 rounded" :disabled="isTyping || !chatMsg">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>

            <!-- PROGRESS SAYA (Database Dinamis) -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest leading-tight">Progress Saya</h3>
                    <a href="{{ route('student.progress') }}" class="text-[10px] text-blue-600 font-bold hover:underline">Lihat detail →</a>
                </div>

                <div class="flex justify-between items-center px-1">
                    <div class="text-center">
                        <div class="relative w-12 h-12 mx-auto mb-2">
                            <svg class="w-12 h-12 transform -rotate-90">
                                <circle cx="24" cy="24" r="20" stroke="#f1f5f9" stroke-width="4" fill="none"></circle>
                                <circle cx="24" cy="24" r="20" stroke="#f59e0b" stroke-width="4" fill="none" stroke-dasharray="125" stroke-dashoffset="{{ 125 - (125 * $modulSelesaiPersen / 100) }}" stroke-linecap="round"></circle>
                            </svg>
                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-black text-slate-800">{{ $modulSelesaiPersen }}%</span>
                        </div>
                        <p class="text-[8px] font-bold text-slate-500 leading-tight">Modul<br>Selesai</p>
                    </div>
                    <div class="text-center">
                        <div class="relative w-12 h-12 mx-auto mb-2">
                            <svg class="w-12 h-12 transform -rotate-90">
                                <circle cx="24" cy="24" r="20" stroke="#f1f5f9" stroke-width="4" fill="none"></circle>
                                <circle cx="24" cy="24" r="20" stroke="#3b82f6" stroke-width="4" fill="none" stroke-dasharray="125" stroke-dashoffset="{{ 125 - (125 * $rataNilai / 100) }}" stroke-linecap="round"></circle>
                            </svg>
                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-black text-slate-800">{{ $rataNilai }}%</span>
                        </div>
                        <p class="text-[8px] font-bold text-slate-500 leading-tight">Rata-Rata<br><span class="text-[7px] font-normal">(Nilai Kuis)</span></p>
                    </div>
                    <div class="text-center">
                        <div class="relative w-12 h-12 mx-auto mb-2">
                            <svg class="w-12 h-12 transform -rotate-90">
                                <circle cx="24" cy="24" r="20" stroke="#f1f5f9" stroke-width="4" fill="none"></circle>
                                <circle cx="24" cy="24" r="20" stroke="#10b981" stroke-width="4" fill="none" stroke-dasharray="125" stroke-dashoffset="{{ 125 - (125 * $xpPercentage / 100) }}" stroke-linecap="round"></circle>
                            </svg>
                            <span class="absolute inset-0 flex items-center justify-center text-[10px] font-black text-slate-800">{{ round($xpPercentage) }}%</span>
                        </div>
                        <p class="text-[8px] font-bold text-slate-500 leading-tight">Level {{ $currentLevel }}<br><span class="text-[7px] font-normal">(To Lv.{{ $currentLevel + 1 }})</span></p>
                    </div>
                    <div class="text-center">
                        <div class="relative w-12 h-12 mx-auto mb-2">
                            <div class="w-full h-full bg-indigo-50 border-2 border-indigo-200 rounded-full flex items-center justify-center">
                                <span class="text-xl">⭐</span>
                            </div>
                        </div>
                        <p class="text-[8px] font-bold text-slate-500 leading-tight mt-3">Total<br><span class="text-[9px] font-black text-slate-800">{{ number_format($currentXp) }} XP</span></p>
                    </div>
                </div>
            </div>

            <!-- PENCAPAIAN (Dinilai dari Level) -->
            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[13px] font-black text-slate-800 uppercase tracking-widest leading-tight">Pencapaian</h3>
                    <a href="{{ route('student.ranks') }}" class="text-[10px] text-blue-600 font-bold hover:underline">Lihat semua →</a>
                </div>
                <div class="flex justify-between px-1">
                    <div class="text-center group cursor-pointer {{ $currentLevel >= 1 ? '' : 'opacity-30 grayscale' }}">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-base mx-auto mb-1 group-hover:scale-110 transition-transform border border-emerald-200 shadow-sm">🌱</div>
                        <p class="text-[8px] font-bold text-slate-800 leading-tight">Eco Seedling<br><span class="text-slate-500 font-normal">Level 1+</span></p>
                    </div>
                    <div class="text-center group cursor-pointer {{ $currentLevel >= 10 ? '' : 'opacity-30 grayscale' }}">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-base mx-auto mb-1 group-hover:scale-110 transition-transform border border-blue-200 shadow-sm">🌿</div>
                        <p class="text-[8px] font-bold text-slate-800 leading-tight">Green Learner<br><span class="text-slate-500 font-normal">Level 10+</span></p>
                    </div>
                    <div class="text-center group cursor-pointer {{ $currentLevel >= 20 ? '' : 'opacity-30 grayscale' }}">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-base mx-auto mb-1 group-hover:scale-110 transition-transform border border-indigo-200 shadow-sm">🌳</div>
                        <p class="text-[8px] font-bold text-slate-800 leading-tight">Earth Guard<br><span class="text-slate-500 font-normal">Level 20+</span></p>
                    </div>
                    <div class="text-center group cursor-pointer {{ $currentLevel >= 30 ? '' : 'opacity-30 grayscale' }}">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center text-base mx-auto mb-1 group-hover:scale-110 transition-transform border border-amber-200 shadow-sm">⚡</div>
                        <p class="text-[8px] font-bold text-slate-800 leading-tight">Energy Saver<br><span class="text-slate-500 font-normal">Level 30+</span></p>
                    </div>
                    <div class="text-center group cursor-pointer {{ $currentLevel >= 50 ? '' : 'opacity-30 grayscale' }}">
                        <div class="w-10 h-10 bg-rose-100 rounded-full flex items-center justify-center text-base mx-auto mb-1 group-hover:scale-110 transition-transform border border-rose-200 shadow-sm">🌍</div>
                        <p class="text-[8px] font-bold text-slate-800 leading-tight">Defender<br><span class="text-slate-500 font-normal">Level 50+</span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Styling khusus Slider Calculator Range */
    input[type=range]::-webkit-slider-thumb {
        appearance: none; width: 14px; height: 14px; border-radius: 50%; background: currentColor; cursor: pointer;
    }
    .custom-scrollbar::-webkit-scrollbar { height: 4px; width: 4px;}
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endsection

@push('scripts')
<script>
    function dashboardApp() {
        return {
            // State APIs Iklim
            apiLoading: true,
            tempGlobal: 0,
            co2Global: 0,

            // State Calculator Karbon Mini
            transport: 120,
            electricity: 150,
            ac: 8,
            food: 2,    // 1:Rendah, 2:Sedang, 3:Tinggi
            plastic: 2, // 1:Jarang, 2:Sedang, 3:Sering
            carbonTotal: 2.45,
            chartDonut: null,

            // State AI Chatbot
            chatMsg: '',
            isTyping: false,
            chats: [],

            async initApp() {
                await this.fetchClimateAPI();
                this.renderCharts();
            },

            async fetchClimateAPI() {
                try {
                    let resTemp = await fetch('https://global-warming.org/api/temperature-api');
                    let dataTemp = await resTemp.json();
                    let latestTemp = dataTemp.result[dataTemp.result.length - 1].station;
                    this.tempGlobal = parseFloat(latestTemp).toFixed(2);

                    let resCo2 = await fetch('https://global-warming.org/api/co2-api');
                    let dataCo2 = await resCo2.json();
                    let latestCo2 = dataCo2.co2[dataCo2.co2.length - 1].trend;
                    this.co2Global = parseFloat(latestCo2).toFixed(1);

                    this.apiLoading = false;
                } catch (error) {
                    this.tempGlobal = 1.18;
                    this.co2Global = 421;
                    this.apiLoading = false;
                }
            },

            // Kalkulator Logika Real-time
            calculateCarbon() {
                const tr = (this.transport * 365 * 0.14) / 1000;
                const el = (this.electricity * 12 * 0.85) / 1000;
                const acTotal = (this.ac * 365 * 0.5) / 1000;
                const fd = this.food == 1 ? 0.3 : (this.food == 2 ? 0.6 : 1.2);
                const pl = this.plastic == 1 ? 0.1 : (this.plastic == 2 ? 0.2 : 0.4);

                this.carbonTotal = tr + el + acTotal + fd + pl;
            },

            updateCarbon() {
                this.calculateCarbon();
                if(this.chartDonut) {
                    const tr = (this.transport * 365 * 0.14) / 1000;
                    const el = ((this.electricity * 12 * 0.85) + (this.ac * 365 * 0.5)) / 1000;
                    const others = (this.food == 2 ? 0.6 : 1.2) + 0.2;
                    this.chartDonut.data.datasets[0].data = [el, tr, others];
                    this.chartDonut.update();
                }
            },

            get statusText() {
                if(this.carbonTotal < 2.0) return 'RENDAH';
                if(this.carbonTotal < 3.5) return 'SEDANG';
                return 'TINGGI';
            },

            get statusClass() {
                if(this.carbonTotal < 2.0) return 'bg-emerald-500 text-white';
                if(this.carbonTotal < 3.5) return 'bg-amber-400 text-white';
                return 'bg-rose-500 text-white';
            },

            // Fungsi Chatbot Integrasi API Groq Langsung (Bypass Backend)
            // Fungsi Chatbot Integrasi via Backend Laravel (Aman & Multi-Key)
            async sendMessage() {
                if (this.chatMsg.trim() === '') return;

                let userText = this.chatMsg;
                this.chats.push({ id: Date.now(), role: 'user', text: `<span class="font-bold text-slate-800">Anda:</span> ${userText}` });
                this.chatMsg = '';
                this.isTyping = true;
                this.scrollToBottom();

                try {
                    // Tembak ke Route Backend Laravel (Bukan langsung ke Groq)
                    const res = await fetch("{{ route('admin.chatAI') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message: userText })
                    });

                    const data = await res.json();
                    let replyContent = "";

                    if (res.ok && data.reply) {
                        replyContent = data.reply;
                    } else {
                        const errDetail = data.error || 'Terjadi kesalahan tidak dikenal dari Server.';
                        replyContent = `<span class="text-rose-500 font-medium">❌ <strong>Error:</strong> ${errDetail}</span>`;
                    }

                    let replyHtml = `
                        <div class="w-full">
                            <p class="font-bold text-emerald-600 mb-1">AI Advisor:</p>
                            <div class="prose prose-sm text-[10px] leading-relaxed">${replyContent}</div>
                        </div>
                    `;

                    this.chats.push({ id: Date.now(), role: 'ai', text: replyHtml });

                } catch(e) {
                    this.chats.push({ id: Date.now(), role: 'ai', text: `
                        <div class="w-full">
                            <p class="font-bold text-emerald-600 mb-1">AI Advisor:</p>
                            <p class="text-rose-500 font-medium text-[10px]">⚠️ Koneksi Gagal: ${e.message}</p>
                        </div>
                    ` });
                } finally {
                    this.isTyping = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const b = document.getElementById('chatContainer');
                    if(b) b.scrollTop = b.scrollHeight;
                }, 100);
            },

            // Render Library Chart.js
            renderCharts() {
                if (typeof Chart === 'undefined') return;

                const createGradient = (ctxId, colorStart, colorEnd) => {
                    let canvas = document.getElementById(ctxId);
                    if(!canvas) return colorStart;
                    let ctx = canvas.getContext('2d');
                    let grad = ctx.createLinearGradient(0, 0, 0, 40);
                    grad.addColorStop(0, colorStart);
                    grad.addColorStop(1, colorEnd);
                    return grad;
                };

                const sparkOpts = {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false }, tooltip: { enabled: false } },
                    scales: { x: { display: false }, y: { display: false, min: 'auto' } },
                    elements: { point: { radius: 0 }, line: { tension: 0.2, borderWidth: 1.5 } },
                    layout: { padding: 0 }
                };

                new Chart(document.getElementById('chartSuhu'), {
                    type: 'line', data: { labels: [1,2,3,4,5,6,7,8,9,10], datasets: [{ data: [0.6,0.7,0.8,0.75,0.9,1.0,0.95,1.1,1.15, 1.18], borderColor: '#f43f5e', backgroundColor: createGradient('chartSuhu', 'rgba(244,63,94,0.2)', 'rgba(244,63,94,0)'), fill: true }] }, options: sparkOpts
                });
                new Chart(document.getElementById('chartCo2'), {
                    type: 'line', data: { labels: [1,2,3,4,5,6,7,8,9,10], datasets: [{ data: [405,407,410,412,415,416,418,419,420, 421], borderColor: '#10b981', backgroundColor: createGradient('chartCo2', 'rgba(16,185,129,0.2)', 'rgba(16,185,129,0)'), fill: true }] }, options: sparkOpts
                });
                new Chart(document.getElementById('chartGlobal'), {
                    type: 'line', data: { labels: [1,2,3,4,5,6,7,8,9,10], datasets: [{ data: [34,34.5,35,35.2,35.8,36,36.2,36.5,36.7,36.8], borderColor: '#3b82f6', backgroundColor: createGradient('chartGlobal', 'rgba(59,130,246,0.2)', 'rgba(59,130,246,0)'), fill: true }] }, options: sparkOpts
                });
                new Chart(document.getElementById('chartIndo'), {
                    type: 'line', data: { labels: [1,2,3,4,5,6,7,8,9,10], datasets: [{ data: [0.4,0.45,0.5,0.55,0.6,0.62,0.65,0.68,0.69,0.7], borderColor: '#f59e0b', backgroundColor: createGradient('chartIndo', 'rgba(245,158,11,0.2)', 'rgba(245,158,11,0)'), fill: true }] }, options: sparkOpts
                });

                this.calculateCarbon();
                this.chartDonut = new Chart(document.getElementById('carbonDonut'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Listrik', 'Transportasi', 'Lainnya'],
                        datasets: [{
                            data: [1.5, 0.8, 0.15],
                            backgroundColor: ['#f59e0b', '#10b981', '#ef4444'],
                            borderWidth: 0,
                            cutout: '80%',
                            rotation: 270,
                            circumference: 180
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { enabled: false } },
                        animation: { animateRotate: true, duration: 1000 }
                    }
                });
            }
        }
    }
</script>
@endpush
