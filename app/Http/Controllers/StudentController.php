<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http; // <-- Ditambahkan agar AI Groq tidak error
use Illuminate\Support\Str; // <-- Ditambahkan untuk Str::markdown di AI Groq

use App\Models\Assessment;
use App\Models\StudentAttempt;
use App\Models\VideoModule;
use App\Models\VideoCategory;
use App\Models\Simulation;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil data kuis/misi dan riwayat pengerjaan user
        $assessments = Assessment::with('module')->latest()->get();
        $attempts = StudentAttempt::where('user_id', $user->id)->get();

        // 1. Sistem Gamifikasi (Hitung Level & Progress XP)
        // Asumsi: Setiap 500 XP, mahasiswa naik 1 Level
        $currentXp = $user->xp ?? 0;
        $currentLevel = floor($currentXp / 500) + 1;
        $xpForNextLevel = $currentLevel * 500;
        $xpPercentage = ($currentXp % 500) / 500 * 100;

        // Auto-update level di database jika naik level
        if ($user->level != $currentLevel) {
            $user->update(['level' => $currentLevel]);
        }

        // 2. Statistik Progress (Untuk Widget Grafik Lingkaran)
        $totalKuis = $assessments->count();
        $lulusKuis = $attempts->where('is_passed', true)->unique('assessment_id')->count();
        $modulSelesaiPersen = $totalKuis > 0 ? round(($lulusKuis / $totalKuis) * 100) : 0;

        // Rata-rata nilai keseluruhan kuis
        $rataNilai = $attempts->count() > 0 ? round($attempts->avg('total_score')) : 0;

        return view('student.dashboard', compact(
            'user', 'assessments', 'attempts',
            'currentLevel', 'currentXp', 'xpForNextLevel', 'xpPercentage',
            'modulSelesaiPersen', 'rataNilai'
        ));
    }

    // ==========================================
    // MODUL & MATERI PEMBELAJARAN
    // ==========================================
    // ==========================================
    // MODUL & MATERI PEMBELAJARAN
    // ==========================================
    public function modul()
    {
        $user = Auth::user();

        // 1. Ambil SEMUA MODUL dari database (Bukan cuma yang ada kuisnya)
        $modules = \App\Models\Module::orderBy('order_number', 'asc')->get();

        // 2. Ambil riwayat evaluasi dan progress membaca PDF
        $attempts = StudentAttempt::where('user_id', $user->id)->get();
        $userProgresses = class_exists(\App\Models\UserProgress::class)
            ? \App\Models\UserProgress::where('user_id', $user->id)->get()
            : collect([]);

        // 3. Hitung Kalkulasi Progress Total Kurikulum
        $totalModul = $modules->count();
        $modulTuntas = 0;

        foreach ($modules as $mod) {
            // Cek apakah modul ini sudah dibuatkan Evaluasinya oleh Admin
            $assessment = \App\Models\Assessment::where('module_id', $mod->id)->first();

            if ($assessment) {
                // Jika sudah ada evaluasi, cek apakah mahasiswa sudah lulus
                $bestScore = $attempts->where('assessment_id', $assessment->id)->max('total_score') ?? 0;
                if ($bestScore >= $assessment->passing_grade) {
                    $modulTuntas++;
                }
            }
        }

        // Persentase total kurikulum
        $progressTotal = $totalModul > 0 ? round(($modulTuntas / $totalModul) * 100) : 0;

        return view('student.modul', compact('user', 'modules', 'attempts', 'userProgresses', 'totalModul', 'modulTuntas', 'progressTotal'));
    }

    public function readModul($id)
    {
        // Ambil Data Modul asli
        $module = \App\Models\Module::findOrFail($id);

        // Cari evaluasi/kuis yang terhubung dengan modul ini (jika ada)
        $assessment = \App\Models\Assessment::where('module_id', $module->id)->first();

        return view('student.modul_read', compact('module', 'assessment'));
    }

    // FUNGSI BARU: Untuk menyimpan progress saat siswa membaca PDF
    public function updateModuleProgress(Request $request, $id)
    {
        $user = Auth::user();
        $percentage = $request->percentage ?? 0;

        if (class_exists(\App\Models\UserProgress::class)) {
            $progress = \App\Models\UserProgress::firstOrCreate(
                ['user_id' => $user->id, 'module_id' => $id],
                ['progress_percentage' => 0]
            );

            if ($percentage > $progress->progress_percentage) {
                // 🌟 JIKA BARU PERTAMA KALI MENCAPAI 50% BACA, BERIKAN XP!
                if ($progress->progress_percentage < 50 && $percentage >= 50) {
                    $user->xp += 50; // XP Baca PDF
                    $user->save();

                    // Catat di Riwayat
                    $moduleName = \App\Models\Module::find($id)->title ?? 'Materi Pembelajaran';
                    \App\Models\XpLog::create([
                        'user_id' => $user->id,
                        'type' => 'modul',
                        'title' => 'Membaca Modul: ' . $moduleName,
                        'xp' => 50
                    ]);
                }

                $progress->progress_percentage = $percentage;
                $progress->save();
            }
        }

        return response()->json(['success' => true]);
    }

    public function simulasi()
    {
        return view('student.simulasi');
    }

    public function latihan()
    {
        // Kita mengambil data Assessment yang memiliki soal untuk latihan
        $assessments = Assessment::withCount('questions')
                        ->having('questions_count', '>', 0)
                        ->get();

        return view('student.latihan.index', compact('assessments'));
    }

    // ==========================================
    // GAMES EDUKASI (Wordwall, dll)
    // ==========================================
    public function games()
    {
        $user = Auth::user();
        return view('student.games', compact('user'));
    }

    // ==========================================
    // RUANG KELAS & PROYEK MAHASISWA
    // ==========================================
    public function proyek()
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Ambil SEMUA kelas yang diikuti oleh mahasiswa ini
        $classrooms = $user->classrooms()->withCount('assignments', 'students')->latest()->get();

        return view('student.proyek.index', compact('user', 'classrooms'));
    }

    public function joinClassroom(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        // Cari kelas berdasarkan kode akses
        $classroom = \App\Models\Classroom::where('code', strtoupper($request->code))->first();

        if (!$classroom) {
            return back()->with('error', 'Kode Kelas tidak valid atau tidak ditemukan!');
        }

        // Cek apakah mahasiswa sudah bergabung di kelas ini
        if ($user->classrooms()->where('classroom_id', $classroom->id)->exists()) {
            return back()->with('warning', 'Anda sudah bergabung di kelas ini!');
        }

        // Masukkan mahasiswa ke dalam kelas (Relasi Many-to-Many)
        $user->classrooms()->attach($classroom->id);

        return back()->with('success', 'Berhasil bergabung ke kelas: ' . $classroom->name);
    }

    public function showClassroom($id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        // Pastikan mahasiswa hanya bisa membuka kelas yang dia ikuti
        $classroom = $user->classrooms()->with(['assignments' => function($q) {
            $q->latest();
        }])->findOrFail($id);

        return view('student.proyek.show', compact('classroom'));
    }

    public function aiAdvisor()
    {
        $user = Auth::user();
        return view('student.ai_advisor', compact('user'));
    }



    // ==========================================
    // MENU PETA PERINGKAT (RANKS)
    // ==========================================
    public function ranks()
    {
        $user = Auth::user();
        return view('student.rank_map', compact('user'));
    }

    public function progress()
    {
        $user = Auth::user();

        // ========================================================
        // 1. FITUR AUTO-SYNC LEVEL (PENTING UNTUK MEMPERBAIKI BUG)
        // ========================================================
        $correctLevel = 1;
        // Sistem menghitung maju: Apakah XP user cukup untuk level berikutnya?
        while (\App\Models\User::calculateXpForLevel($correctLevel + 1) <= $user->xp) {
            $correctLevel++;
        }

        // Jika level di database tertinggal, otomatis naikkan levelnya!
        if ($user->level < $correctLevel) {
            $user->level = $correctLevel;
            $user->save();
        }

        // Gunakan level yang sudah benar
        $level = $user->level;

        // 2. HITUNG PROGRESS BAR
        $currentLevelBaseXp = \App\Models\User::calculateXpForLevel($level);
        $nextLevelXp = \App\Models\User::calculateXpForLevel($level + 1);

        $xpEarnedInCurrentLevel = max(0, $user->xp - $currentLevelBaseXp);
        $xpNeededForNext = $nextLevelXp - $currentLevelBaseXp;

        $levelPercentage = $xpNeededForNext > 0 ? min(100, ($xpEarnedInCurrentLevel / $xpNeededForNext) * 100) : 100;
        $rank = $user->rank_name ?? '🌱 Eco Seedling';

        // 3. AMBIL DATA PROGRESS MODUL
        $moduleProgress = class_exists(\App\Models\UserProgress::class)
            ? \App\Models\UserProgress::with('module')->where('user_id', $user->id)->latest('updated_at')->get()
            : collect([]);

        // 4. STATISTIK PENCAPAIAN
        $stats = [
            'completed_modules' => $moduleProgress->where('progress_percentage', 100)->count(),
            'ongoing_modules'   => $moduleProgress->where('progress_percentage', '<', 100)->where('progress_percentage', '>', 0)->count(),
            'completed_quizzes' => \Illuminate\Support\Facades\Schema::hasTable('exam_attempts')
                                    ? \Illuminate\Support\Facades\DB::table('exam_attempts')->where('user_id', $user->id)->where('status', 'finished')->count() : 0,
            'completed_tasks'   => \Illuminate\Support\Facades\Schema::hasTable('submissions')
                                    ? \Illuminate\Support\Facades\DB::table('submissions')->where('user_id', $user->id)->count() : 0,
        ];

        // 4. AMBIL DATA RIWAYAT ASLI DARI DATABASE (Maksimal 5 aktivitas terakhir)
        $recentXpLogs = \App\Models\XpLog::where('user_id', $user->id)
                            ->latest()
                            ->take(5)
                            ->get();

        return view('student.progress', compact('user', 'nextLevelXp', 'levelPercentage', 'rank', 'moduleProgress', 'stats', 'recentXpLogs'));
    }

    public function pengaturan()
    {
        return view('student.pengaturan');
    }

    // ==========================================
    // AI SUSTAINABILITY ADVISOR (GROQ API)
    // ==========================================
    public function chatAI(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $apiKey = env('GROQ_API_KEY');

        if (!$apiKey) return response()->json(['reply' => 'API Key belum disetting.']);

        try {
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->timeout(15)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant', // Model yang cepat untuk chat
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Anda adalah EcoBot, asisten AI untuk SMART-ECO. PENTING: Dilarang menyertakan salam/greeting (seperti "Halo", "Hai", "Halo [Nama]") di awal setiap respon kecuali di chat pertama dan tetap sertakan nama pengguna. Langsung berikan jawaban inti dari pertanyaan pengguna dengan format yang rapi, informatif, dan komunikatif.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->message
                        ]
                    ],
                    'temperature' => 0.7,
                ]);

            return response()->json(['reply' => $response->json('choices.0.message.content')]);
        } catch (\Exception $e) {
            return response()->json(['reply' => 'Maaf, server AI sedang sibuk. Coba sebentar lagi ya!']);
        }
    }

    public function chatGroq(Request $request)
    {
        $request->validate(['message' => 'required|string']);

        // Mengambil API Key dari .env
        $apiKey = env('GROQ_API_KEY');

        // Jika API Key kosong atau belum diset
        if (empty($apiKey)) {
            return response()->json([
                'reply' => '<div class="p-3 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl font-medium text-xs">⚠️ <strong>API Key Groq Belum Dipasang:</strong><br>Buka file <code>.env</code> Anda, tambahkan <code>GROQ_API_KEY=gsk_xxx</code>, lalu jalankan <code>php artisan config:clear</code>.</div>'
            ]);
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(15)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . trim($apiKey),
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'openai/gpt-oss-20b',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Anda adalah EcoBot, asisten AI cerdas untuk platform LMS SMART-ECO. Anda ahli dalam sains, fisika, keberlanjutan lingkungan, dan jejak karbon. Jawab dengan ramah, komunikatif, dan rapi.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->message
                        ]
                    ],
                ]);

            if ($response->successful()) {
                $reply = $response->json('choices.0.message.content');
                return response()->json([
                    'reply' => Str::markdown($reply)
                ]);
            }

            // Jika Groq merespons dengan Error HTTP (misal 401 Unauthorized / Key Salah)
            $errMsg = $response->json('error.message') ?? $response->body();
            return response()->json([
                'reply' => '<div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-medium text-xs">❌ <strong>Groq API Error (' . $response->status() . '):</strong><br>' . e($errMsg) . '</div>'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => '<div class="p-3 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl font-medium text-xs">🔌 <strong>Koneksi Error:</strong><br>' . e($e->getMessage()) . '</div>'
            ]);
        }
    }

    public function climateDashboard()
    {
        $user = Auth::user();
        return view('student.dashboard_iklim', compact('user'));
    }

    public function carbonCalculator()
    {
        $user = Auth::user();
        return view('student.carbon_calculator', compact('user'));
    }

    // ==========================================
    // MENU VIDEO PEMBELAJARAN (SEKUENSIAL KETAT)
    // ==========================================
    public function videoIndex()
    {
        $user = Auth::user();

        // 1. Ambil history tontonan dari Database
        $watchedVideoIds = \Illuminate\Support\Facades\DB::table('user_video')
                            ->where('user_id', $user->id)
                            ->pluck('video_id')
                            ->toArray();

        // 2. Ambil modul beserta videonya
        $videoModules = \App\Models\VideoModule::with(['videos' => function($q) {
            $q->orderBy('id', 'asc');
        }])->orderBy('id', 'asc')->get();

        $categories = [];
        $isNextModuleUnlocked = true; // Modul 1 (Paling atas) SELALU terbuka otomatis

        // 3. Petakan Data & Aturan Gembok Ketat
        foreach ($videoModules as $module) {
            $allVideosCompleted = true;
            $isNextVideoUnlocked = true;
            $mappedVideos = [];

            $totalVideos = $module->videos->count();

            // Jika sebuah modul tidak punya video sama sekali, jangan biarkan membuka modul selanjutnya!
            if ($totalVideos === 0) {
                $allVideosCompleted = false;
            }

            foreach ($module->videos as $vidIndex => $video) {
                $isCompleted = in_array($video->id, $watchedVideoIds);

                // Syarat mutlak video terbuka: Modulnya sudah terbuka DAN video sebelumnya sudah selesai
                $isUnlocked = $isNextModuleUnlocked && $isNextVideoUnlocked;

                if (!$isCompleted) {
                    $allVideosCompleted = false;
                }

                $mappedVideos[] = [
                    'id' => $video->id,
                    'title' => $video->title,
                    'type' => $video->type,
                    'video_src' => $video->type === 'youtube' ? $video->video_url : asset('storage/' . $video->video_url),
                    'duration' => $video->duration ?? '00:00',
                    'description' => $video->description,
                    'is_completed' => $isCompleted,
                    'is_unlocked' => $isUnlocked, // Flag gembok video
                ];

                // Gembok untuk video SEBELAHNYA ditentukan dari status video ini
                $isNextVideoUnlocked = $isCompleted;
            }

            $categories[] = [
                'id' => 'modul-' . $module->id,
                'title' => $module->title,
                'badge' => $module->badge ?? 'Materi Video',
                'description' => $module->description,
                'thumbnail' => $module->cover_image ? asset('storage/' . $module->cover_image) : 'https://images.unsplash.com/photo-1511497584788-8767610419ea?w=800',
                'is_unlocked' => $isNextModuleUnlocked, // Flag gembok modul
                'is_completed' => $allVideosCompleted,
                'videos' => $mappedVideos,
            ];

            // Syarat Modul SELANJUTNYA terbuka: Modul ini harus 100% tuntas videonya!
            $isNextModuleUnlocked = $allVideosCompleted;
        }

        return view('student.video_pembelajaran', compact('user', 'categories'));
    }

    // FUNGSI BARU: Merekam & Menambahkan XP khusus untuk Video
    public function claimVideoXP(Request $request)
    {
        $user = Auth::user();
        $videoId = $request->video_id;

        $alreadyWatched = \Illuminate\Support\Facades\DB::table('user_video')
                            ->where('user_id', $user->id)
                            ->where('video_id', $videoId)
                            ->exists();

        if ($alreadyWatched) {
            return response()->json(['success' => false, 'message' => 'XP untuk video ini sudah diklaim.']);
        }

        // CATAT KE DATABASE: Video resmi ditonton sampai habis
        \Illuminate\Support\Facades\DB::table('user_video')->insert([
            'user_id' => $user->id,
            'video_id' => $videoId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $xpReward = 10;

        // 🌟 TULIS KE BUKU RIWAYAT (MUNcUL DI MENU PROGRESS)
        \App\Models\XpLog::create([
            'user_id' => $user->id,
            'type' => 'video',
            'title' => 'Menonton Video Pembelajaran',
            'xp' => $xpReward
        ]);

        $user->xp += $xpReward;

        $xpNeeded = \App\Models\User::calculateXpForLevel($user->level + 1);
        $levelUp = false;

        while ($user->xp >= $xpNeeded) {
            $user->level += 1;
            $levelUp = true;
            $xpNeeded = \App\Models\User::calculateXpForLevel($user->level + 1);
        }
        $user->save();

        return response()->json([
            'success' => true,
            'xp_added' => $xpReward,
            'new_level' => $user->level,
            'level_up' => $levelUp
        ]);
    }

    public function simulasiIndex()
    {
        $user = Auth::user();

        // Mengambil data simulasi dari database
        $simulations = Simulation::latest()->get();

        // Mengirimkan variabel $simulations ke view
        return view('student.simulasi', compact('user', 'simulations'));
    }

    public function settings()
    {
        return view('student.settings');
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'password' => 'nullable|string|min:8',
        ]);

        // Mengambil seluruh request kecuali token & password/avatar
        $input = $request->except(['_token', '_method', 'avatar', 'password']);
        $user->fill($input);

        // Update Password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Upload Avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Data profil akademik berhasil diperbarui!');
    }

    // --- FUNGSI PENCARIAN GLOBAL (OMNI-SEARCH) SUPER DEEP ---
    public function search(Request $request)
    {
        $query = $request->input('q');
        $user = \Illuminate\Support\Facades\Auth::user();

        // Siapkan wadah kosong
        $videoModules = collect();
        $simulations = collect();
        $classrooms = collect();
        $assessments = collect();
        $assignments = collect();

        // Jika user mengetik sesuatu di search bar
        if ($query) {

            // 1. CARI VIDEO (Termasuk menyelam ke dalam isi/judul videonya!)
            $videoModules = \App\Models\VideoModule::where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhereHas('videos', function($q) use ($query) {
                    // Mencari di tabel anak (Video spesifik di dalam modul)
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->get();

            // 2. CARI SIMULASI
            $simulations = \App\Models\Simulation::where('title', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();

            // 3. CARI KELAS (Ruang Kelas)
            $classrooms = \App\Models\Classroom::where('name', 'like', "%{$query}%")
                ->orWhere('subject', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->get();

            // 4. CARI MODUL & EVALUASI
            $assessments = \App\Models\Assessment::with('module')
                ->where('title', 'like', "%{$query}%")
                ->orWhereHas('module', function($q) use ($query) {
                    // Mencari di dalam nama dan kategori modul PDF
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('category', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })->get();

            // 5. CARI TUGAS (Hanya di kelas yang sudah mahasiswa ikuti)
            $assignments = \App\Models\Assignment::where(function($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%");
                })
                ->whereHas('classroom.students', function($q) use ($user) {
                    // Filter agar hanya tugas dari kelas mahasiswa itu saja yang muncul
                    $q->where('user_id', $user->id);
                })
                ->get();
        }

        // Hitung total semua hasil temuan
        $totalResults = $videoModules->count() + $simulations->count() + $classrooms->count() + $assessments->count() + $assignments->count();

        return view('student.search', compact(
            'query', 'totalResults', 'videoModules', 'simulations', 'classrooms', 'assessments', 'assignments'
        ));
    }


    // ==========================================
    // SISTEM REWARD XP REAL-TIME (GAMIFIKASI)
    // ==========================================
    public function claimXP(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $xpReward = $request->xp_amount ?? 50;
        $description = $request->description ?? 'Aktivitas Pembelajaran';
        $type = $request->type ?? 'modul'; // Ambil tipe dari request frontend

        // 1. TULIS KE BUKU RIWAYAT (Ini yang akan muncul di menu Progress)
        \App\Models\XpLog::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $description,
            'xp' => $xpReward
        ]);

        // 2. Tambahkan XP ke akun mahasiswa
        $user->xp += $xpReward;

        // Cek apakah XP cukup untuk NAIK LEVEL
        $xpNeeded = \App\Models\User::calculateXpForLevel($user->level + 1);
        $levelUp = false;

        while ($user->xp >= $xpNeeded) {
            $user->level += 1;
            $levelUp = true;
            $xpNeeded = \App\Models\User::calculateXpForLevel($user->level + 1);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'xp_added' => $xpReward,
            'new_xp' => $user->xp,
            'new_level' => $user->level,
            'level_up' => $levelUp,
            'message' => 'Luar biasa! Kamu mendapatkan +' . $xpReward . ' XP 🚀'
        ]);
    }
}
