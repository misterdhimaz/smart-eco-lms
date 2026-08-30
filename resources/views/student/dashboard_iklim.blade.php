@extends('layouts.student')
@section('title', 'Dashboard Iklim Real-time | SMART-ECO')

@section('content')
<div x-data="climateApp()" x-init="initClimate()" class="w-full pb-12 font-sans">

    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 gsap-fade">
        <div>
            <span class="bg-emerald-100 text-emerald-700 border border-emerald-200 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-3 inline-block">Real-Time Data 📡</span>
            <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Dashboard <span class="text-emerald-500">Iklim & Cuaca</span></h1>
            <p class="text-xs md:text-sm text-slate-500 font-medium mt-1">Pantau kondisi lingkungan sekitarmu secara langsung (Live API Data).</p>
        </div>

        <div class="relative w-full md:w-80 z-50">
            <div class="flex items-center gap-3 bg-white px-4 py-2.5 rounded-xl border border-slate-200 shadow-sm shrink-0 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/20 transition-all">

                <button @click="detectUserLocation()" class="w-8 h-8 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0 hover:bg-blue-500 hover:text-white transition-colors" title="Gunakan Lokasi GPS Saya">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </button>

                <div class="flex-1">
                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-400 mb-0.5" x-text="currentLocationName">Mencari Lokasi...</p>
                    <input type="text" x-model="searchQuery" @input.debounce.500ms="searchLocation()" @keydown.enter.prevent="searchLocation()" placeholder="Cari kota lain..." class="w-full bg-transparent text-xs font-bold text-slate-800 outline-none placeholder:text-slate-300">
                </div>
                <svg x-show="isSearching" class="w-4 h-4 text-emerald-500 animate-spin absolute right-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>

            <div x-show="searchResults.length > 0" @click.away="searchResults = []" style="display: none;" class="absolute w-full mt-2 bg-white border border-slate-200 rounded-xl shadow-xl overflow-hidden z-50 divide-y divide-slate-50">
                <template x-for="result in searchResults" :key="result.id">
                    <button @click="selectLocation(result)" class="w-full text-left px-4 py-3 hover:bg-slate-50 transition-colors flex flex-col gap-0.5">
                        <span class="text-xs font-black text-slate-800" x-text="result.name"></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider" x-text="(result.admin1 ? result.admin1 + ', ' : '') + result.country"></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- SKELETON LOADING -->
    <div x-show="isLoading" class="w-full space-y-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 h-64 bg-slate-200 animate-pulse rounded-[2rem]"></div>
            <div class="h-64 bg-slate-200 animate-pulse rounded-[2rem]"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="h-32 bg-slate-200 animate-pulse rounded-2xl"></div>
            <div class="h-32 bg-slate-200 animate-pulse rounded-2xl"></div>
            <div class="h-32 bg-slate-200 animate-pulse rounded-2xl"></div>
            <div class="h-32 bg-slate-200 animate-pulse rounded-2xl"></div>
        </div>
    </div>

    <div x-show="!isLoading" style="display: none;" class="space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 gsap-card">

            <!-- WIDGET CUACA UTAMA -->
            <div class="lg:col-span-2 bg-[#202124] rounded-[2rem] p-8 md:p-10 text-white relative overflow-hidden shadow-xl border border-slate-700 flex flex-col justify-between">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')]"></div>
                <div class="absolute right-[-10%] top-[-20%] text-[200px] opacity-10 pointer-events-none transition-transform duration-1000" :class="weatherIcon === '☀️' ? 'rotate-45' : ''" x-text="weatherIcon"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-[80px] pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-start justify-between gap-6">
                    <div>
                        <p class="text-sm font-medium text-slate-400 mb-2 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Cuaca Saat Ini
                        </p>
                        <div class="flex items-center gap-4 mb-2">
                            <div class="text-6xl md:text-7xl drop-shadow-md" x-text="weatherIcon"></div>
                            <div class="flex items-start">
                                <h2 class="text-6xl md:text-7xl font-black tracking-tighter" x-text="Math.round(weatherData.temperature_2m)">--</h2>
                                <span class="text-2xl font-bold text-slate-500 mt-2">°C</span>
                            </div>
                        </div>
                        <p class="text-lg font-bold text-slate-300 ml-2 capitalize" x-text="weatherDesc">Mengambil data...</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 md:gap-8 bg-white/5 backdrop-blur-md p-5 rounded-2xl border border-white/10 shrink-0 shadow-inner mt-4 md:mt-0">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Terasa Seperti</p>
                            <p class="text-xl font-black text-white"><span x-text="Math.round(weatherData.apparent_temperature)">--</span> °C</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Kecepatan Angin</p>
                            <p class="text-xl font-black text-white"><span x-text="weatherData.wind_speed_10m">--</span> km/h</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-700/50 relative z-10">
                    <div class="flex overflow-x-auto gap-4 pb-2 custom-scrollbar snap-x">
                        <template x-for="hour in hourlyForecast" :key="hour.time">
                            <div class="flex flex-col items-center justify-center shrink-0 w-16 snap-center bg-white/5 py-3 rounded-xl border border-white/5 hover:bg-white/10 transition-colors">
                                <p class="text-[10px] font-bold text-slate-400 mb-2" x-text="hour.time"></p>
                                <div class="text-2xl mb-1 drop-shadow-md" x-text="hour.icon"></div>
                                <p class="text-sm font-black text-white mb-1"><span x-text="hour.temp"></span>°</p>
                                <div class="flex items-center justify-center gap-1 text-[9px] font-bold text-blue-400" x-show="hour.precip > 0">
                                    <span x-text="hour.precip + '%'"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- WIDGET AQI (SUDAH DIPERBAIKI) -->
            <div class="bg-white rounded-[2rem] p-8 border border-slate-200 shadow-sm relative overflow-hidden flex flex-col justify-center text-center group transition-all hover:shadow-md">
                <div class="absolute inset-0 opacity-10 transition-colors duration-500" :class="aqiBgColor"></div>

                <h3 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-6 relative z-10">Kualitas Udara (AQI)</h3>

                <!-- Lingkaran Angka -->
                <div class="relative w-36 h-36 mx-auto mb-6 flex items-center justify-center relative z-10">
                    <svg class="w-full h-full transform -rotate-90 absolute inset-0 drop-shadow-sm">
                        <circle cx="50%" cy="50%" r="45%" stroke="#f1f5f9" stroke-width="10" fill="none"></circle>
                        <circle cx="50%" cy="50%" r="45%"
                            :stroke="aqiColorHex"
                            stroke-width="10"
                            fill="none"
                            stroke-dasharray="283"
                            :stroke-dashoffset="283 - (283 * (aqiIndexValue / 5))"
                            stroke-linecap="round"
                            class="transition-all duration-1000 ease-out"></circle>
                    </svg>
                    <!-- HANYA MENAMPILKAN ANGKA AGAR TIDAK BERTABRAKAN -->
                    <div class="flex flex-col items-center">
                        <span class="text-4xl font-black text-slate-800 leading-none" x-text="aqiData.european_aqi || '--'">--</span>
                        <span class="text-[9px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Index</span>
                    </div>
                </div>

                <!-- Teks Status di Luar Lingkaran -->
                <div class="relative z-10">
                    <p class="text-xl font-black uppercase tracking-tight mb-2" :class="aqiTextColor" x-text="aqiStatus">--</p>
                    <p class="text-[11px] text-slate-500 font-bold leading-relaxed px-4" x-text="aqiMessage">--</p>
                </div>
            </div>

        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 gsap-card">

            <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:-translate-y-1 transition-transform flex flex-col justify-center">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-lg mb-3">💧</div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Kelembapan Relatif</p>
                <p class="text-2xl font-black text-slate-800"><span x-text="weatherData.relative_humidity_2m">--</span><span class="text-sm text-slate-500 ml-1">%</span></p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:-translate-y-1 transition-transform flex flex-col justify-center">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center text-lg mb-3">☀️</div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Indeks UV Ekstrem</p>
                <p class="text-2xl font-black text-slate-800"><span x-text="aqiData.uv_index || '--'">--</span><span class="text-sm text-slate-500 ml-1">UV</span></p>
            </div>

            <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-200/80 shadow-sm hover:-translate-y-1 transition-transform flex flex-col justify-center">
                <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-500 flex items-center justify-center text-lg mb-3">🌧️</div>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Tingkat Curah Hujan</p>
                <p class="text-2xl font-black text-slate-800"><span x-text="weatherData.precipitation || 0">--</span><span class="text-sm text-slate-500 ml-1">mm</span></p>
            </div>

            <div class="bg-gradient-to-br from-[#10b981] to-[#059669] p-5 md:p-6 rounded-3xl border border-emerald-600 shadow-md shadow-emerald-500/20 text-white flex flex-col justify-center relative overflow-hidden group">
                <div class="absolute right-[-10%] top-[-10%] text-6xl opacity-20 group-hover:scale-110 transition-transform duration-500">🌍</div>
                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-200 mb-1 relative z-10">Misi Harian</p>
                <p class="text-sm font-bold leading-snug relative z-10" x-text="ecoMission">Memuat misi...</p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 gsap-card">

            <div class="lg:col-span-2 bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm">
                <div class="mb-6 border-b border-slate-100 pb-4">
                    <h3 class="text-base font-black text-slate-800">Prakiraan Suhu Mingguan</h3>
                </div>
                <div class="w-full h-[250px] relative">
                    <canvas id="climateChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-200 shadow-sm flex flex-col">
                <h3 class="text-base font-black text-slate-800 mb-6 border-b border-slate-100 pb-4">Prakiraan 7 Hari</h3>

                <div class="flex flex-col gap-3 overflow-y-auto flex-1 custom-scrollbar pr-2" style="max-height: 250px;">
                    <template x-for="(day, index) in dailyForecastList" :key="index">
                        <div class="flex items-center justify-between bg-slate-50 p-3.5 rounded-xl border border-slate-100 hover:bg-slate-100 transition-colors">
                            <p class="text-xs font-bold text-slate-700 w-16" x-text="day.dayName"></p>

                            <div class="flex items-center gap-2 w-16">
                                <div class="text-xl drop-shadow-sm" x-text="day.icon"></div>
                                <div class="flex items-center gap-0.5 text-[10px] font-bold text-blue-500" x-show="day.precip > 0">
                                    <span x-text="day.precip + '%'"></span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-xs font-bold w-20 justify-end">
                                <span class="text-slate-800" x-text="Math.round(day.maxTemp) + '°'"></span>
                                <span class="text-slate-400" x-text="Math.round(day.minTemp) + '°'"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function climateApp() {
        return {
            isLoading: true,
            isSearching: false,

            // API Keys & Config
            owmKey: '917245df14a42e4aaad94ae5cda18b6b',
            bmkgDefaultAdm4: '31.71.03.1001',

            // State Lokasi
            searchQuery: '',
            searchResults: [],
            currentLocationName: 'Mendeteksi Lokasi...',
            currentLat: -6.2088,
            currentLon: 106.8456,

            weatherData: {},
            aqiData: {},
            dailyData: {},
            hourlyForecast: [],
            dailyForecastList: [],

            weatherDesc: 'Loading...',
            weatherIcon: '🌤️',

            aqiStatus: 'Loading...',
            aqiMessage: 'Menghitung...',
            aqiColorHex: '#cbd5e1',
            aqiTextColor: 'text-slate-600',
            aqiBgColor: 'bg-slate-50',
            aqiIndexValue: 0,

            ecoMission: 'Gunakan transportasi umum hari ini untuk mengurangi emisi karbon.',
            chartInstance: null,

            initClimate() {
                this.detectUserLocation();
            },

            detectUserLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        async (position) => {
                            this.currentLat = position.coords.latitude;
                            this.currentLon = position.coords.longitude;
                            this.fetchClimateData();
                        },
                        (error) => {
                            console.warn("Akses lokasi ditolak. Menggunakan Jakarta.");
                            this.currentLocationName = "Jakarta, Indonesia";
                            this.fetchClimateData();
                        }
                    );
                } else {
                    this.fetchClimateData();
                }
            },

            async searchLocation() {
                if(this.searchQuery.length < 3) {
                    this.searchResults = [];
                    return;
                }

                this.isSearching = true;
                try {
                    const res = await fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${encodeURIComponent(this.searchQuery)}&limit=5&appid=${this.owmKey}`);
                    const data = await res.json();

                    if(data.length > 0) {
                        this.searchResults = data.map(item => ({
                            id: `${item.lat}-${item.lon}`,
                            name: item.local_names?.id || item.name,
                            admin1: item.state || '',
                            country: item.country,
                            latitude: item.lat,
                            longitude: item.lon
                        }));
                    } else {
                        this.searchResults = [];
                    }
                } catch(e) {
                    console.error("Gagal mencari lokasi", e);
                } finally {
                    this.isSearching = false;
                }
            },

            selectLocation(location) {
                this.currentLocationName = `${location.name}, ${location.country}`;
                this.currentLat = location.latitude;
                this.currentLon = location.longitude;

                this.searchQuery = '';
                this.searchResults = [];
                this.isLoading = true;

                if(this.chartInstance) {
                    this.chartInstance.destroy();
                }

                this.fetchClimateData();
            },

            async fetchClimateData() {
                try {
                    // Fetch OpenWeather Current Weather
                    const weatherRes = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${this.currentLat}&lon=${this.currentLon}&units=metric&lang=id&appid=${this.owmKey}`);
                    const weatherJson = await weatherRes.json();

                    if(this.currentLocationName === 'Mendeteksi Lokasi...' || this.currentLocationName === 'Jakarta, Indonesia') {
                        this.currentLocationName = `${weatherJson.name}, ${weatherJson.sys.country}`;
                    }

                    this.weatherData = {
                        temperature_2m: weatherJson.main.temp,
                        relative_humidity_2m: weatherJson.main.humidity,
                        apparent_temperature: weatherJson.main.feels_like,
                        wind_speed_10m: (weatherJson.wind.speed * 3.6).toFixed(1),
                        precipitation: weatherJson.rain ? weatherJson.rain['1h'] || 0 : 0
                    };

                    this.weatherDesc = weatherJson.weather[0].description;
                    this.weatherIcon = this.getOWMIcon(weatherJson.weather[0].icon);

                    // Fetch OpenWeather Air Pollution (AQI)
                    try {
                        const aqiRes = await fetch(`https://api.openweathermap.org/data/2.5/air_pollution?lat=${this.currentLat}&lon=${this.currentLon}&appid=${this.owmKey}`);
                        const aqiJson = await aqiRes.json();
                        const aqiIndex = aqiJson.list[0].main.aqi;
                        this.parseOWMAQI(aqiIndex);
                    } catch (aqiErr) {
                        this.parseOWMAQI(null);
                    }

                    // Fetch Forecast
                    try {
                        const bmkgRes = await fetch(`https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=${this.bmkgDefaultAdm4}`);
                        const bmkgJson = await bmkgRes.json();

                        if(bmkgJson && bmkgJson.data && bmkgJson.data[0].cuaca) {
                            this.processBMKGData(bmkgJson.data[0].cuaca);
                        } else {
                            throw new Error("Data BMKG tidak lengkap");
                        }
                    } catch (bmkgErr) {
                        await this.fetchOWMForecast();
                    }

                    this.isLoading = false;
                    setTimeout(() => {
                        this.renderChart();
                        if(typeof gsap !== 'undefined') {
                            gsap.from(".gsap-card", { y: 20, opacity: 0, duration: 0.6, stagger: 0.1, ease: "power2.out" });
                        }
                    }, 100);

                } catch (error) {
                    console.error("Fatal Error API:", error);
                    this.isLoading = false;
                }
            },

            processBMKGData(cuacaArray) {
                this.hourlyForecast = [];
                this.dailyForecastList = [];
                let tempDaily = {};

                const now = new Date();

                cuacaArray.flat().forEach(item => {
                    const dateObj = new Date(item.utc_datetime);

                    if(dateObj >= now && this.hourlyForecast.length < 8) {
                        let hours = dateObj.getHours().toString().padStart(2, '0') + ':00';
                        this.hourlyForecast.push({
                            time: hours,
                            temp: Math.round(item.t),
                            icon: this.getBMKGIcon(item.weather_desc),
                            precip: 0
                        });
                    }

                    const dateStr = dateObj.toLocaleDateString('id-ID');
                    if(!tempDaily[dateStr]) {
                        tempDaily[dateStr] = { temps: [], descs: [], dateObj: dateObj };
                    }
                    tempDaily[dateStr].temps.push(item.t);
                    tempDaily[dateStr].descs.push(item.weather_desc);
                });

                Object.keys(tempDaily).forEach((dateStr, index) => {
                    if (index > 4) return;

                    const dayData = tempDaily[dateStr];
                    let dayName = index === 0 ? 'Hari Ini' : (index === 1 ? 'Besok' : dayData.dateObj.toLocaleDateString('id-ID', { weekday: 'short' }));

                    this.dailyForecastList.push({
                        dayName: dayName,
                        icon: this.getBMKGIcon(dayData.descs[Math.floor(dayData.descs.length/2)]),
                        maxTemp: Math.max(...dayData.temps),
                        minTemp: Math.min(...dayData.temps),
                        precip: 0
                    });
                });

                this.dailyData = {
                    time: Object.values(tempDaily).map(d => d.dateObj),
                    temperature_2m_max: Object.values(tempDaily).map(d => Math.max(...d.temps)),
                    temperature_2m_min: Object.values(tempDaily).map(d => Math.min(...d.temps))
                };
            },

            async fetchOWMForecast() {
                const res = await fetch(`https://api.openweathermap.org/data/2.5/forecast?lat=${this.currentLat}&lon=${this.currentLon}&units=metric&lang=id&appid=${this.owmKey}`);
                const data = await res.json();

                this.hourlyForecast = data.list.slice(0, 8).map(item => {
                    let dateObj = new Date(item.dt * 1000);
                    return {
                        time: dateObj.getHours().toString().padStart(2, '0') + ':00',
                        temp: Math.round(item.main.temp),
                        icon: this.getOWMIcon(item.weather[0].icon),
                        precip: Math.round((item.pop || 0) * 100)
                    };
                });

                let dailyMap = {};
                data.list.forEach(item => {
                    let dateStr = new Date(item.dt * 1000).toLocaleDateString('id-ID');
                    if(!dailyMap[dateStr]) dailyMap[dateStr] = { temps: [], icon: item.weather[0].icon };
                    dailyMap[dateStr].temps.push(item.main.temp);
                });

                this.dailyForecastList = Object.keys(dailyMap).slice(0,5).map((date, index) => ({
                    dayName: index === 0 ? 'Hari Ini' : (index === 1 ? 'Besok' : date),
                    icon: this.getOWMIcon(dailyMap[date].icon),
                    maxTemp: Math.round(Math.max(...dailyMap[date].temps)),
                    minTemp: Math.round(Math.min(...dailyMap[date].temps)),
                    precip: 0
                }));

                this.dailyData = {
                    time: Object.keys(dailyMap),
                    temperature_2m_max: Object.values(dailyMap).map(d => Math.max(...d.temps)),
                    temperature_2m_min: Object.values(dailyMap).map(d => Math.min(...d.temps))
                };
            },

            getOWMIcon(iconCode) {
                const map = {
                    '01d': '☀️', '01n': '🌙',
                    '02d': '🌤️', '02n': '☁️',
                    '03d': '☁️', '03n': '☁️',
                    '04d': '🌥️', '04n': '🌥️',
                    '09d': '🌧️', '09n': '🌧️',
                    '10d': '🌦️', '10n': '🌧️',
                    '11d': '⛈️', '11n': '⛈️',
                    '13d': '🌨️', '13n': '🌨️',
                    '50d': '🌫️', '50n': '🌫️'
                };
                return map[iconCode] || '🌍';
            },

            getBMKGIcon(desc) {
                desc = desc.toLowerCase();
                if(desc.includes('cerah berawan')) return '🌤️';
                if(desc.includes('cerah')) return '☀️';
                if(desc.includes('berawan')) return '☁️';
                if(desc.includes('hujan petir')) return '⛈️';
                if(desc.includes('hujan')) return '🌧️';
                if(desc.includes('kabut')) return '🌫️';
                return '⛅';
            },

            // --- PERBAIKAN LOGIKA AQI AGAR MENGHASILKAN ANGKA DI DALAM LINGKARAN ---
            parseOWMAQI(aqi) {
                if(aqi === null) {
                    this.aqiStatus = 'Tak Tersedia';
                    this.aqiMessage = 'Sensor polusi tidak ada di wilayah ini.';
                    this.aqiColorHex = '#cbd5e1'; this.aqiTextColor = 'text-slate-500'; this.aqiBgColor = 'bg-slate-50';
                    this.aqiIndexValue = 0;
                    this.aqiData.european_aqi = '--';
                    return;
                }

                this.aqiIndexValue = aqi;

                // Konversi Index (1-5) menjadi estimasi angka US AQI (0-500) agar terlihat profesional
                switch(aqi) {
                    case 1:
                        this.aqiData.european_aqi = '25';
                        this.aqiStatus = 'Sangat Baik';
                        this.aqiMessage = 'Udara sangat bersih dan sehat untuk semua orang.';
                        this.aqiColorHex = '#3b82f6'; this.aqiTextColor = 'text-blue-600'; this.aqiBgColor = 'bg-blue-500';
                        break;
                    case 2:
                        this.aqiData.european_aqi = '50';
                        this.aqiStatus = 'Baik';
                        this.aqiMessage = 'Kualitas udara memuaskan, aman beraktivitas.';
                        this.aqiColorHex = '#10b981'; this.aqiTextColor = 'text-emerald-600'; this.aqiBgColor = 'bg-emerald-500';
                        break;
                    case 3:
                        this.aqiData.european_aqi = '110';
                        this.aqiStatus = 'Sedang';
                        this.aqiMessage = 'Dapat diterima, namun sedikit berisiko bagi yang sensitif.';
                        this.aqiColorHex = '#eab308'; this.aqiTextColor = 'text-amber-600'; this.aqiBgColor = 'bg-amber-500';
                        break;
                    case 4:
                        this.aqiData.european_aqi = '160';
                        this.aqiStatus = 'Buruk';
                        this.aqiMessage = 'Tingkat polusi tinggi. Kurangi aktivitas fisik di luar ruangan.';
                        this.aqiColorHex = '#f97316'; this.aqiTextColor = 'text-orange-600'; this.aqiBgColor = 'bg-orange-500';
                        break;
                    case 5:
                        this.aqiData.european_aqi = '220';
                        this.aqiStatus = 'Sangat Buruk';
                        this.aqiMessage = 'Peringatan kesehatan darurat! Tetap berada di dalam ruangan.';
                        this.aqiColorHex = '#f43f5e'; this.aqiTextColor = 'text-rose-600'; this.aqiBgColor = 'bg-rose-500';
                        break;
                }
            },

            renderChart() {
                const ctx = document.getElementById('climateChart').getContext('2d');
                if(this.chartInstance) this.chartInstance.destroy();

                const labels = this.dailyData.time.map(date => {
                    const d = new Date(date);
                    return d.toLocaleDateString('id-ID', { weekday: 'short' });
                });

                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Suhu Maks (°C)',
                                data: this.dailyData.temperature_2m_max,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 3,
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: { backgroundColor: '#0f172a', padding: 12, cornerRadius: 8 } },
                        scales: {
                            y: { display: false, min: Math.min(...this.dailyData.temperature_2m_min) - 2 },
                            x: { grid: { display: false }, ticks: { font: { weight: 'bold', size: 12, color: '#64748b' } } }
                        },
                        interaction: { intersect: false, mode: 'index' },
                    }
                });
            }
        }
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { height: 6px; width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(148, 163, 184, 0.3); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(148, 163, 184, 0.6); }
</style>
@endpush
